<?php

namespace App\Http\Controllers;
use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\ItensVenda;
use App\Models\Parcela;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clientes = Cliente::orderBy('nome')->get();
        $query = Venda::with('cliente');

        if ($request->filled('cliente_cpf')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('cpf', $request->cliente_cpf);
            });
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('cliente_nome')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nome', 'LIKE', '%' . $request->cliente_nome . '%');
            });
        }

        $vendas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('vendas.index', compact('vendas', 'clientes'));
    }
    // public function index(Request $request) 
    // {
    //     $clientes = Cliente::all();
    
    //     $vendas = Venda::with('cliente')
    //         ->when($request->cliente_id, function ($query) use ($request) {
    //             return $query->where('cliente_id', $request->cliente_id);
    //         })
    //         ->get();
    
    //     return view('site.principal', compact('clientes'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('vendas.create', compact('clientes', 'produtos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produtos' => 'required|array',
            'produtos.*' => 'exists:produtos,id',
            'quantidades' => 'required|array',
            'quantidades.*' => 'integer|min:1',
            'parcelas.numero' => 'required|array',
            'parcelas.valor' => 'required|array',
            'parcelas.vencimento' => 'required|array',
        ]);

        $valorTotal = 0;
        foreach ($request->produtos as $index => $produto_id) {
            $produto = Produto::findOrFail($produto_id);
            $valorTotal += $produto->valor * $request->quantidades[$index];

            $quantidade = $produto->estoque - $request->quantidades[$index];
            $produto->update([
                'estoque' => $quantidade,
            ]);

        }
    
        $totalParcelas = array_sum($request->parcelas['valor']);
        if ($totalParcelas != $valorTotal) {
            return redirect()->back()->withErrors(['parcelas' => 'O total das parcelas deve ser igual ao valor total da venda!']);
        }
    
        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'valor' => $valorTotal,
            'qtnd_parcelas' => count($request->parcelas['numero']),
        ]);

        foreach ($request->produtos as $index => $produto_id) {
            $produto = Produto::findOrFail($produto_id);
            ItensVenda::create([
                'venda_id' => $venda->id,
                'produto_id' => $produto->id,
                'quantidade' => $request->quantidades[$index],
            ]);
        }
    
        foreach ($request->parcelas['numero'] as $index => $numero) {
            Parcela::create([
                'venda_id' => $venda->id,
                'numero' => $numero,
                'valor' => $request->parcelas['valor'][$index],
                'vencimento' => $request->parcelas['vencimento'][$index],
            ]);
        }
    
        return redirect()->route('vendas.create')->with('success', 'Venda cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function gerarPdf($id)
    {
        $venda = Venda::with(['cliente', 'produtos'])->findOrFail($id);
        $pdf = Pdf::loadView('vendas.pdf', compact('venda'));
        return $pdf->download("venda_{$venda->id}.pdf");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $venda = Venda::with(['cliente', 'produtos', 'parcelas'])->findOrFail($id);
        $clientes = Cliente::all();
        $produtos = Produto::all();

        //dd($venda->produtos[0]->pivot->quantidade);
        return view('vendas.edit', compact('clientes', 'produtos', 'venda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $venda = Venda::findOrFail($id);

        // foreach ($venda->produtos as $item) {
        //     $produto = Produto::findOrFail($item->id);
        //     $produto->increment('estoque', $item->pivot->quantidade);
        // }

        $valorTotal = 0;
        foreach ($request->produtos as $index => $produto_id) {
            $produto = Produto::findOrFail($produto_id);
            $valorTotal += $produto->valor * $request->quantidades[$index];

            // $novaQuantidade = $produto->estoque - $request->quantidades[$index];
            // if ($novaQuantidade < 0) {
            //     return redirect()->back()->withErrors(['estoque' => 'Estoque insuficiente para o produto ' . $produto->nome]);
            // }
            //$produto->update(['estoque' => $novaQuantidade]);
        }

        $totalParcelas = array_sum($request->parcelas['valor']);
        if ($totalParcelas != $valorTotal) {
            return redirect()->back()->withErrors(['parcelas' => 'O total das parcelas deve ser igual ao valor total da venda!']);
        }

        $venda->update([
            'cliente_id' => $request->cliente_id,
            'valor' => $valorTotal,
            'qtnd_parcelas' => count($request->parcelas['numero']),
        ]);

        ItensVenda::where('venda_id', $venda->id)->delete();
        foreach ($request->produtos as $index => $produto_id) {
            ItensVenda::create([
                'venda_id' => $venda->id,
                'produto_id' => $produto_id,
                'quantidade' => $request->quantidades[$index],
            ]);
        }

        Parcela::where('venda_id', $venda->id)->delete();
        foreach ($request->parcelas['numero'] as $index => $numero) {
            Parcela::create([
                'venda_id' => $venda->id,
                'numero' => $numero,
                'valor' => $request->parcelas['valor'][$index],
                'vencimento' => $request->parcelas['vencimento'][$index],
            ]);
        }

        return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $venda = Venda::findOrFail($id);

        try {
            $venda->delete();
            return redirect()->route('vendas.index')->with('success', 'Venda excluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('vendas.index')->with('error', 'Erro ao excluir a venda.');
        }
    }
}

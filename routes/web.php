<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/clientes', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/vendas/create', [\App\Http\Controllers\VendaController::class, 'create'])->name('vendas.create');
Route::post('vendas/create', [\App\Http\Controllers\VendaController::class, 'store'])->name('vendas.store');
Route::get('/vendas/{id}/edit', [\App\Http\Controllers\VendaController::class, 'edit'])->name('vendas.edit');
Route::put('/vendas/{id}', [\App\Http\Controllers\VendaController::class, 'update'])->name('vendas.update');
Route::delete('/vendas/{id}/destroy', [\App\Http\Controllers\VendaController::class, 'destroy'])->name('vendas.destroy');
Route::get('/vendas', [\App\Http\Controllers\VendaController::class, 'index'])->name('vendas.index');
Route::get('/vendas/{id}/pdf', [\App\Http\Controllers\VendaController::class, 'gerarPdf'])->name('vendas.pdf');


Route::resource('clientes', \App\Http\Controllers\ClienteController::class);
Route::resource('produtos', \App\Http\Controllers\ProdutoController::class);
//Route::resource('vendas', \App\Http\Controllers\VendaController::class);
//Route::resource('parcelas', \App\Http\Controllers\ParcelaController::class);
//Route::resource('itensvendas', \App\Http\Controllers\ItensVendaController::class);


//Route::get('/', [\App\Http\Controllers\ClienteController::class, 'index'])->name('site.index');
//Route::resource('clientes', Clientes::class);

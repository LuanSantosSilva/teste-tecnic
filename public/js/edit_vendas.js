$(document).ready(function () {
    let totalVenda = 0;
    let dataCompra = new Date(); // Data da compra
    console.log("Teste arquivo")

    function calcularTotalVenda() {
        totalVenda = 0;
        $("#produtos-container .produto-item").each(function () {
            let select = $(this).find("select");
            let quantidade = parseInt($(this).find(".quantidade").val()) || 0;
            let preco = parseFloat(select.find(":selected").data("preco")) || 0;
            totalVenda += quantidade * preco;
        });

        $("#total-venda").text(totalVenda.toFixed(2));
        calcularTotalParcelas();
    }

    function calcularTotalParcelas() {
        let totalParcelas = 0;
        $("#parcelas-container .parcela-item input[name='parcelas[valor][]']").each(function () {
            totalParcelas += parseFloat($(this).val()) || 0;
        });

        $("#total-parcelas").text(totalParcelas.toFixed(2));
        let diferenca = totalVenda - totalParcelas;
        $("#diferenca").text(diferenca.toFixed(2));

        if (totalParcelas !== totalVenda) {
            $("#total-parcelas").css("color", "red");
            $("#finalizar-venda").prop("disabled", true);
        } else {
            $("#total-parcelas").css("color", "green");
            $("#finalizar-venda").prop("disabled", false);
        }
    }

    function calcularProximaDataVencimento(numeroParcela) {
        let data = new Date(dataCompra);
        data.setMonth(data.getMonth() + numeroParcela);
        return data.toISOString().split("T")[0];
    }

    function atualizarSelects() {
        let produtosSelecionados = [];

        $("#produtos-container select").each(function () {
            let val = $(this).val();
            if (val) produtosSelecionados.push(val);
        });

        $("#produtos-container select").each(function () {
            let select = $(this);
            select.find("option").each(function () {
                if ($(this).val() && produtosSelecionados.includes($(this).val()) && $(this).val() !== select.val()) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    }

    function verificarRemocaoProdutos() {
        let totalProdutos = $("#produtos-container .produto-item").length;
        $(".remover-produto").toggle(totalProdutos > 1);
    }

    $("#add-produto").click(function () {
        let primeiroProduto = $("#produtos-container .produto-item").first();
        let novoProduto = primeiroProduto.clone();

        novoProduto.find("select").val("");
        novoProduto.find(".quantidade").val(1);
        
        $("#produtos-container").append(novoProduto);
        atualizarSelects();
        verificarRemocaoProdutos();
        calcularTotalVenda();
    });

    $(document).on("change", "select[name='produtos[]']", function () {
        let estoque = $(this).find(":selected").data("estoque");
        let inputQuantidade = $(this).closest(".produto-item").find(".quantidade");

        if (estoque) {
            inputQuantidade.attr("max", estoque);
        }
        atualizarSelects();
        calcularTotalVenda();
    });

    $(document).on("input", ".quantidade", function () {
        let estoque = $(this).closest(".produto-item").find("select option:selected").data("estoque");
        corrigirQuantidade($(this), estoque);
        calcularTotalVenda();
    });

    function corrigirQuantidade(input, estoque) {
        let valorAtual = parseInt(input.val()) || 1;
        if (estoque && valorAtual > estoque) {
            input.val(estoque);
        } else if (valorAtual < 1) {
            input.val(1);
        }
    }

    $("#add-parcela").click(function () {
        let numeroParcela = $("#parcelas-container .parcela-item").length + 1;
        let dataVencimento = calcularProximaDataVencimento(numeroParcela);

        let novaParcela = `
            <div class="parcela-item flex items-center gap-2">
                <input type="number" name="parcelas[numero][]" value="${numeroParcela}" readonly>
                <input type="number" name="parcelas[valor][]" min="0.01" step="0.01" required placeholder="Valor da parcela" class="w-32 p-2 border rounded-md text-center">
                <input type="date" name="parcelas[vencimento][]" value="${dataVencimento}" required class="p-2 border rounded-md">
                <button type="button" class="remover-parcela bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700">Remover</button>
            </div>
        `;

        $("#parcelas-container").append(novaParcela);
        calcularTotalParcelas();
    });

    $(document).on("input", "input[name='parcelas[valor][]']", function () {
        calcularTotalParcelas();
    });

    $(document).on("click", ".remover-produto", function () {
        $(this).closest(".produto-item").remove();
        atualizarSelects();
        calcularTotalVenda();
        verificarRemocaoProdutos();
    });

    $(document).on("click", ".remover-parcela", function () {
        $(this).closest(".parcela-item").remove();
        recalcularNumeracaoParcelas();
        calcularTotalParcelas();
    });

    function recalcularNumeracaoParcelas() {
        $("#parcelas-container .parcela-item").each(function (index) {
            $(this).find("input[name='parcelas[vencimento][]']").val(calcularProximaDataVencimento(index + 1));
        });
    }

    atualizarSelects();
    verificarRemocaoProdutos();
    calcularTotalVenda();
});

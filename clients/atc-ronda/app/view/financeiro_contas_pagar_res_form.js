
function fcExcluirLancamento(v_pk, v_status) {

    var objParametros = {
        "ds_dominio_modulo": "excluir_lancamentos",
        "ic_acao": "del"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);
    if (arrCarregar.result != 'success') {
        alert("Você não tem Permissão");
        return false;
    }

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")) {
        if (v_pk != "") {

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("lancamento", "excluir", objParametros);

            if (arrExcluir.result == 'success') {

                //Exibe a mensagem
                alert(arrExcluir.message);
                location.reload();
            }
            else {
                alert('Falhou a requisição de exclusão.');
            }
        }
        else {
            alert("Código não encontrado");
        }

    }
    return false;
}


function fcImprimirLancamento(pk) {
    sendPost('financeiro_impressao_lancamento_form.php', { token: token, pk: pk });
}

function fcCarregar(){
    $("#exibir").show();
    $("#exibir").css("display", "block");
}

function fcLoader(){
    
    $("#exibir").hide();
    var count = $(('#count'));
    $({ Counter: 0 }).animate({ Counter: count.text() }, {
    duration: 5000,
    easing: 'linear',
    step: function () {
        count.text(Math.ceil(this.Counter)+ "%");
    }
    });

    var s = Snap('#animated');
    var progress = s.select('#progress');

    progress.attr({strokeDasharray: '0, 251.2'});
    Snap.animate(0,251.2, function( value ) {
        progress.attr({ 'stroke-dasharray':value+',251.2'});
    }, 1000);
}


$(document).ready(function () {
    $(document).on('click', '#cmdNovoLencamento', fcNovoLancamento);
    fcLoader();
      
});



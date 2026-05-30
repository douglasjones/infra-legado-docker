function fcLote() {  
    var objParametros = {
        "ic_status": 1
    }
    var arrEnviar = carregarController("financeiro_import_lancamentos", "salvar", objParametros); 
    if (arrEnviar.result == 'success'){
        window.open("financeiro_lote_lancamentos_cad.php?token="+token+"&financeiro_import_lancamentos_pk="+arrEnviar.data[0]['pk'], 
                    "Cadastro Em Lote","width="+screen.availWidth+",height="+screen.availHeight+",top=0,left=0,resizable=no,scrollbars=yes,status=no");
        sendPost('financeiro_lote_lancamentos_res.php', { token: token });
    }
}

function fcImportar() {
    sendPost('financeiro_import_lancamentos_cad.php', { token: token });
}

function fcVoltar() {
    sendPost('financeiro_lote_lancamentos_res.php', { token: token });
}

$(document).ready(function () {
    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdLote', fcLote);
    $(document).on('click', '#cmdImport', fcImportar);
})

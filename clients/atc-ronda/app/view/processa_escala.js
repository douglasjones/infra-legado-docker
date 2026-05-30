function fc_processa_escala(){
    alert('Processo iniciado aguarde')
    var arrEnviar = carregarController("agenda_colaborador_padrao", "processa_escala", "");
    if (arrEnviar.result == 'success'){
        alert(arrEnviar.message);
    }
}
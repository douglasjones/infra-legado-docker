
function fcVoltarUsuario(){
    sendPost("menu_financeiro.php", {token: token});
}



$(document).ready(function () {
    $("usuario_cadastro_lancamento_pk").val(29)
    $(document).on('click', '#cmdNovoLencamento', fcNovoLancamento);
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdVoltar', fcVoltarUsuario);
});

function fcEnviar() {

    event.preventDefault();

    var v_ds_login = $("#ds_login").val();
    var v_ds_senha = $("#ds_senha").val();


    if (v_ds_login == "") {
        $("#alert_login").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_login").slideUp(500);
        });
        $('#ds_login').focus();
        return false;
    }

    //var url = '../controller/usuario.controller.php?job=autenticarUsuario&ds_login=' + encodeURIComponent(v_ds_login)+ '&ds_senha=' + encodeURIComponent(v_ds_senha);
    var url = '../controller/colaborador.controller.php?job=autenticarColaborador&ds_pin=' + encodeURIComponent(v_ds_login);

    var request = $.ajax({
        url: url,
        type: 'post',
        cache: false,
        dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    });
    request.done(function (output) {

        if (output.result == 'success') {
            fcAbrirPopUpRedirecionar(output.data[0]['token'], output.data[0]['ds_colaborador'], v_ds_login, output.data[0]['colaborador_pk']);
        } else {
            alert('PIN não localizado ou desativado!');
            $('#ds_login').val("");
        }
    });
    request.fail(function (jqXHR, textStatus) {
        alert('PIN não localizado ou desativado!');
    });
}

function fcAbrirPopUpRedirecionar(token, ds_colaborador, ds_pin, colaborador_pk) {
    sendPost("colaborador_holerite_res_form.php", { token: token, ds_colaborador: ds_colaborador, ds_pin: ds_pin, colaborador_pk: colaborador_pk });
}

$(document).ready(function () {
    //Atribui a validação do formulário dos campos obrigatórios
    $(document).on('click', '#cmdEnviar', fcEnviar);

    $.ajax({
        url: "../versao.txt",
        success: function (data) {
            $("#ds_versao").text(data);
        }
    });

    //Verifica se o registro é para alteracao e puxa os dados.
}
);

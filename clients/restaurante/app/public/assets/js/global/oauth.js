$(document).ready(function () {

    $('#btn-modal-update-password').on('click', function (e) {
        utilsJS.loading('Atualizando...');
        $.ajax({
            type: 'POST',
            url: '/api/auth/updateSenha',
            data: $("#formAlterarSenha").serializeArray(),
            complete: function (response) {
                try {
                    var log = JSON.parse(response.responseText);
                    utilsJS.loaded();
                    if(log.status == false){
                        utilsJS.toastNotify(false, log.message);
                    }else{
                        window.location.href="menu/principal";
                    }
                } catch (e) {
                    utilsJS.toastNotify(false, 'Ocorreu um erro para alterar a Senha !.<br />');
                }
            }
        });
    });

    /*var logo = "";
    logo = 'https://gepros.com.br/comercial/condominios/img/nlogo.png';
    //$('.bg').css('background-image', 'url(' + logo + ')');
    $("#ds_img_cliente").attr("src", logo)*/

    $.ajax({
        url:"",
        success : function (data) {
           $("#ds_versao").text("v 01.S.23");
        }
    });
    $(document).on('click', '.btn-auth', fcLogar);
    //Make authentication
});
function fcLogar(){
    utilsJS.loading('Efetuando Login...');
    $.ajax({
        type: 'POST',
        url: '/api/auth/login',
        data: $("#authForm").serializeArray(),
        complete: function (response) {
            try {
                var log = JSON.parse(response.responseText);
                utilsJS.loaded();
                if($("#password").val()=="gepros"||$("#password").val()=="Gepros"||$("#password").val()=="GEPROS"){
                
                    $("#janela_modal_nova_senha").modal("show");
                    $("#ds_login_nova_senha").val($("#login").val());
                    $("#text_login").text($("#login").val());
                    return false;
                }
                if(log.data == ''){
                    utilsJS.toastNotify(false, log.message);
                }else{
                    window.location.href="menu/principal";
                }
            } catch (e) {
                utilsJS.toastNotify(false, 'Ocorreu um erro para efetuar o Login !.<br />');
            }
        }
    });
}
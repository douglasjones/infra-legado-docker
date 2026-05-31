$(document).ready(function () {

    var logo = "";
    var defaultLogo = "/assets/img/logo/logo-white.png";
    $("#ds_img_cliente").attr("src", defaultLogo);
    $.ajax({
  
        type: 'GET',
        url: '/api/conta/carregarLogo',
        data:[],
        complete: function (response) {
    
            try {
                var log = JSON.parse(response.responseText);

                if (!log || log.status === false || !log.data || !log.data[0]) {
                    return;
                }

                if(log.data[0] == '[]'){
                    logo = defaultLogo;
                }
                else{
                   if(log.data[0]['tipo_conta_pk'] == 1){
                       if(log.data[0]['ds_img_cliente'] != null){
                           logo = log.data[0]['ds_img_cliente'];
                       }
                       else{
                            logo = defaultLogo;
                       }
                   }
                   else{
                       logo = defaultLogo;
                   }
              
                    //$('.bg').css('background-image', 'url(' + logo + ')');
                    $("#ds_img_cliente").attr("src", logo)
                   
                   

                }
            } catch (e) {
                $("#ds_img_cliente").attr("src", defaultLogo);
            }
        }
    });

    $.ajax({
        url:"",
        success : function (data) {
           $("#ds_versao").text("v. 25.05.1 F");
        }
    });
    $(document).on('click', '.btn-auth', fcLogar);

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
                        sweetMensagem('warning', log.message);
                    }else{
                        window.location.href="menu/principal";
                    }
                } catch (e) {
                    utilsJS.toastNotify(false, 'Ocorreu um erro para alterar a Senha !.<br />');
                }
            }
        });
    });

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

                    fcVerificarTrocaSenha();
                    
                    return false;
                }
                else if(log.data == ''){
                    sweetMensagem('warning', log.message);
                }else{
                    window.location.href="menu/principal";
                }
            } catch (e) {
                utilsJS.toastNotify(false, 'Ocorreu um erro para efetuar o Login !.<br />');
            }
        }
    });
}

function fcVerificarTrocaSenha(){
    $.ajax({
        type: 'POST',
        url: '/api/auth/verificarTrocaSenha',
        data: $("#authForm").serializeArray(),
        complete: function (response) {
            try {
                var log = JSON.parse(response.responseText);
                
                if(log.data == 0){
                    sweetMensagem('warning','Credenciais inválidas');
                }else{
                    $("#janela_modal_nova_senha").modal("show");
                    $("#ds_login_nova_senha").val($("#login").val());
                    $("#text_login").text($("#login").val());
                }
            } catch (e) {
                utilsJS.toastNotify(false, 'Ocorreu um erro para efetuar o Login !.<br />');
            }
        }
    });
}

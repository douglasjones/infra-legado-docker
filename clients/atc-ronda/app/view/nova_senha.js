function fcValidarForm(){  

    if($("#ds_nova_senha").val()==""){
        $("#alert_ds_nova_senha").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_nova_senha").slideUp(500);
        });
        $('#ds_nova_senha').focus();
        return false;
    }     
    if($("#ds_confirmar_senha").val()==""){
        $("#alert_ds_confirmar_senha").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_confirmar_senha").slideUp(500);
        });
        $('#ds_confirmar_senha').focus();
        return false;
    }     
    fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
    return false;
}

function fcEnviar(){
    
    var ds_login = $("input[id='ds_login']");
    ds_login.get(0).value; 
    
    var v_ds_login = ds_login.get(0).value;
    var v_ds_nova_senha = $("#ds_nova_senha").val();
    var v_ds_confirmar_nova_senha = $("#ds_confirmar_senha").val();
    
    if(v_ds_nova_senha!=v_ds_confirmar_nova_senha){
        $("#alert_incorreta").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_incorreta").slideUp(500);
        });
           
        $('#ds_nova_senha').val("");
        $('#ds_confirmar_senha').val("");
        return false;
    }
    
    
    var url = '../controller/usuario.controller.php?job=trocarSenha&ds_login=' + encodeURIComponent(v_ds_login)+ '&ds_nova_senha=' + encodeURIComponent(v_ds_nova_senha)+"&ds_cofirmar_senha="+encodeURIComponent(v_ds_confirmar_nova_senha);
	
    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){
        if (output.result == 'success'){
           
            fcAbrirPopUpRedirecionar(output.data[0]['token']);
           
            
        } 
        else{
            alert("Verifique o Login");
            $('#ds_nova_senha').val("");
            $('#ds_confirmar_senha').val("");
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Usuário ou Senha Incorreto ' + textStatus);
    });   
}
function fcAbrirPopUpRedirecionar(token){
    
    var v_url = "../controller/retorno.controller.php?job=listarRerornoPopUp&token="+token;

    var request = $.ajax({
        url:          v_url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){
        if (output.result == 'success'){

            if(output.data[0]['t_qtde_retorno']>0){
                var width = 1100;
                var height = 600;

                var left = 250;
                var top = 150;
                var URL = "retorno_popup.php?token="+token;
                window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
            }

            var arrCarregarPermissao = permissaoLogin("menu_meu_gepros", "cons",token);  
            
            if (arrCarregarPermissao.result == 'success'){
                sendPost("dashboard_res_form.php", {token: token});
            }
            sendPost("principal.php", {token: token});
        } 
        else{
            sendPost("principal.php", {token: token});
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Usuário ou Senha Incorreto ' + textStatus);
    });   
}
var token = "";
function fcCarregarLogo(){
	var arrCarregar = carregarController("conta", "carregarLogo");
	
	var logo = "";
	if (arrCarregar.result == 'success'){
		
		for(i=0; i<arrCarregar.data.length; i++){
			if(arrCarregar.data[i]['tipo_conta_pk'] == 1){
				if(arrCarregar.data[i]['ds_img_cliente'] != null ){
					logo = arrCarregar.data[i]['ds_img_cliente'];
				}else{
					logo = "https://gepros.com.br/comercial/condominios/img/nlogo.png";
				}
				break;
			}else {
				logo = "https://gepros.com.br/comercial/condominios/img/nlogo.png";
				break;
			}
			
		}
		$("#ds_img_cliente").attr("src", logo)
	}
	else{
		alert('Falhar ao carregar o registro');
	} 
}


$(document).ready(function()
    {
        //Atribui a validação do formulário dos campos obrigatórios
        $(document).on('click', '#cmdConfirmarSenhaNova', fcValidarForm);
        fcValidarForm();
        fcCarregarLogo();
        //Verifica se o registro é para alteracao e puxa os dados.
    }    
);

function fcEnviar(){   

    var v_produtos_servicos_pk = $("#produtos_servicos_pk").val();
    var v_ds_colaborador = $("#ds_colaborador").val();
    var v_dt_nascimento = $("#dt_nascimento").val();
    var v_generos_pk = $("#generos_pk").val();
    //valida cpf
    if($("#ds_cpf").val()==""){
        var v_ds_cpf = '000.000.000-00';
    }else{
        var v_ds_cpf = $("#ds_cpf").val();
    }
    if($("#ds_rg").val()==""){
        var v_ds_rg = "0000000";
    }else{
        var v_ds_rg = $("#ds_rg").val();
    }
        
    var v_ds_nome_pai = $("#ds_nome_pai").val();
    var v_ds_nome_mae = $("#ds_nome_mae").val();
    var v_ds_cel = $("#ds_cel").val();
    var v_ic_whatsapp = 1;
    var v_ds_cel2 = $("#ds_cel2").val();
    var v_ds_email = $("#ds_email").val();
    var v_ds_cep = $("#ds_cep").val();
    var v_ds_endereco = $("#ds_endereco").val();
    var v_ds_numero = $("#ds_numero").val();
    var v_ds_complemento = $("#ds_complemento").val();
    var v_ds_bairro = $("#ds_bairro").val();
    var v_ds_cidade = $("#ds_cidade").val();
    var v_ds_uf = $("#ds_uf").val();
    var v_ic_status = 2;
    var v_ic_origem = 2; 

    var objParametros = {    
        "produtos_servicos_pk": (v_produtos_servicos_pk),        
        "ds_colaborador": (v_ds_colaborador),
        "dt_nascimento": (v_dt_nascimento),    
        "generos_pk": (v_generos_pk),
        "ds_cpf": (v_ds_cpf),
        "ds_rg": (v_ds_rg),
        "ds_nome_pai": (v_ds_nome_pai),
        "ds_nome_mae": (v_ds_nome_mae),
        "ds_cel": (v_ds_cel),
        "ic_whatsapp": (v_ic_whatsapp),        
        "ds_cel2": (v_ds_cel2),
        "ds_email": (v_ds_email),
        "ds_cep": (v_ds_cep),
        "ds_endereco": (v_ds_endereco),
        "ds_numero": (v_ds_numero),
        "ds_complemento": (v_ds_complemento),
        "ds_bairro": (v_ds_bairro),
        "ds_cidade": (v_ds_cidade),
        "ds_uf": (v_ds_uf),
        "ic_status": (v_ic_status),
        "ic_origem": (v_ic_origem)
    };   

    var arrEnviar = carregarController_externo("colaborador", "salvarSite", objParametros); 

  if (arrEnviar.result == 'success'){
        // Reload datable
        alert('Obrigado! Vamos analisar sua fixa')
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
   fcLimpaForm()
}

function fcLimpaForm(){
    $("#produtos_servicos_pk").val("");
    $("#ds_colaborador").val("");
    $("#dt_nascimento").val("");
    $("#generos_pk").val("");
    $("#ds_cpf").val("");
    $("#ds_rg").val("");
    $("#ds_nome_pai").val("");
    $("#ds_nome_mae").val("");
    $("#ds_cel").val("");    
    $("#ds_cel2").val("");
    $("#ds_email").val("");
    $("#ds_cep").val("");
    $("#ds_endereco").val("");
    $("#ds_numero").val("");
    $("#ds_complemento").val("");
    $("#ds_bairro").val("");
    $("#ds_cidade").val("");
    $("#ds_uf").val("");
}

function fcValidarForm(){
    if($('#produtos_servicos_pk').val()==""){
        $("#alert_produtos_servicos_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_produtos_servicos_pk").slideUp(500);
        });
        $('#produtos_servicos_pk').focus();
        return false;
    }

    if($('#ds_colaborador').val()==""){
        $("#alert_ds_colaborador").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_colaborador").slideUp(500);
        });
        $('#ds_colaborador').focus();
        return false;
    }
        
    if($('#dt_nascimento').val()==""){
        $("#alert_dt_nascimento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_nascimento").slideUp(500);
        });
        $('#ds_dt_nascimento').focus();
        return false;
    }
    
    if($('#generos_pk').val()==""){
        $("#alert_generos_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_generos_pk").slideUp(500);
        });
        $('#generos_pk').focus();
        return false;
    }
        
    if($('#ds_cpf').val()!=""){         
        var ds_cpf_cnpj = $('#ds_cpf').val();
        if(ds_cpf_cnpj.length < 14 ){
            $("#alert_cpf").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_cpf").slideUp(500);
            });
            $('#ds_cpf').focus();
            return false;
        }else if(ds_cpf_cnpj.length > 14 && ds_cpf_cnpj.length < 18 ){
            $("#alert_cpf").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_cpf").slideUp(500);
            });
            $('#ds_cpf').focus();
            return false;
        }
    }    
    
   if($('#ds_cel').val()==""){
        $("#alert_ds_cel").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_cel").slideUp(500);
        });
        $('#ds_cel').focus();
        return false;
    }
    
    if($('#ds_cel').val()==""){
        $("#alert_ds_cel").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_cel").slideUp(500);
        });
        $('#ds_cel').focus();
        return false;
    }
    
    if($('#ds_cel2').val()==""){
        $("#alert_ds_cel2").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_cel2").slideUp(500);
        });
        $('#ds_cel2').focus();
        return false;
    }
    
    fcEnviar();     
}
function fcCarregarCep(){
    var cpf = $("#ds_cep").val();

    if(cpf.length == 9){
        
        var objParametros = {
            "ds_cep": $("#ds_cep").val()
        };        
        
        var arrCarregar = carregarController_externo("cep", "buscarCep", objParametros);
  
        if (arrCarregar.result == 'success'){

            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
            

        }
        else{
            alert('Falhar ao carregar o registro');
        }       
    }
} 

function montarUrlController_externo(vController, vJob, v_ParametrosJob){
   
    var v_strParametros = "";
    var url = "";
    var token = $("#token").val()
    if(v_ParametrosJob){    
        $.each( v_ParametrosJob, function( key, value ) {
            v_strParametros += "&"+key+"="+encodeURIComponent(value);
        });
    }
    
    url = "../controller/"+vController+".controller.php?"+"job="+vJob+"&token="+token + "" +v_strParametros;

    v_last_url = url;
    
    return url;
}

function carregarController_externo(vController, vJob, vParametrosJob){
  
    var v_strParametros = "";
    
    var url = montarUrlController_externo(vController, vJob, vParametrosJob);
    var arrRetornoCarregarControle;

    var request = $.ajax({
        url:          url,
        cache:        false,
        async:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){     
        if (output.result == 'success'){
          
            arrRetornoCarregarControle = output;
        } else{
          alert('Falhou a requisição: '+output.message);
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha na req: ' + textStatus);
    });

    return arrRetornoCarregarControle;
    
}


function fcCarregarQualificacao(){

    var objParametros = {
        "pk": ""
    };

       var arrCarregar = carregarController_externo("produto_servico", "listarTodos", objParametros);    

    carregarComboAjax($("#produtos_servicos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
 
}

function fcLogin(){
    
    var v_ds_login = "admin";
    var v_ds_senha = "vectra_10";
    var url = '../controller/usuario.controller.php?job=autenticarUsuario&ds_login=' + encodeURIComponent(v_ds_login)+ '&ds_senha=' + encodeURIComponent(v_ds_senha);
    
     var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){
        if (output.result == 'success'){ 
            $("#token").val(output.data[0]['token'])
            fcCarregarQualificacao(); 
            fcCarregarGenero();
        }else{
            alert('Usuário ou Senha Incorreto');  
        }
    });  
}

function fcCarregarGenero(){
    //Carrega os grupos
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController_externo("genero", "listarTodos", objParametros); 
    carregarComboAjax($("#generos_pk"), arrCarregar, " ", "pk", "ds_genero");
    
}
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout('execmascara()',1);
}
 
function execmascara(){
    v_obj.value=v_fun(v_obj.value);
}


function chama_mascara(o) {
	if (o.value.length > 14)
		mascara(o, cnpj);
	else
		mascara(o, cpf);
}

function cpf(v) {
	v = v.replace( /\D/g , ""); //Remove tudo o que não é dígito
	v = v.replace( /(\d{3})(\d)/ , "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dígitos
	v = v.replace( /(\d{3})(\d)/ , "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dígitos
	//de novo (para o segundo bloco de números)
	v = v.replace( /(\d{3})(\d{1,2})$/ , "$1-$2"); //Coloca um hífen entre o terceiro e o quarto dígitos
	return v;
}

function cnpj(v) {
	v = v.replace( /\D/g , ""); //Remove tudo o que não é dígito
	v = v.replace( /^(\d{2})(\d)/ , "$1.$2"); //Coloca ponto entre o segundo e o terceiro dígitos
	v = v.replace( /^(\d{2})\.(\d{3})(\d)/ , "$1.$2.$3"); //Coloca ponto entre o quinto e o sexto dígitos
	v = v.replace( /\.(\d{3})(\d)/ , ".$1/$2"); //Coloca uma barra entre o oitavo e o nono dígitos
	v = v.replace( /(\d{4})(\d)/ , "$1-$2"); //Coloca um hífen depois do bloco de quatro dígitos
	return v;
}

//data
function mdata(v){
    v=v.replace(/\D/g,"");    //Remove tudo o que não é dígito
    v=v.replace(/(\d{2})(\d)/,"$1/$2");       
    v=v.replace(/(\d{2})(\d)/,"$1/$2");       
                                             
    v=v.replace(/(\d{2})(\d{2})$/,"$1$2");
    return v;
}

function mascaraTelefone(v){
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if (r.length > 10) {
      r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1)$2-$3");
    } else if (r.length > 5) {
      r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1)$2-$3");
    } else if (r.length > 2) {
      r = r.replace(/^(\d\d)(\d{0,5})/, "($1)$2");
    } else {
      r = r.replace(/^(\d*)/, "($1");
    }
    return r;

}

function moeda(v){
    v=v.replace(/\D/g,""); // permite digitar apenas numero
    v=v.replace(/(\d{1})(\d{17})$/,"$1.$2"); // coloca ponto antes dos ultimos digitos
    v=v.replace(/(\d{1})(\d{13})$/,"$1.$2"); // coloca ponto antes dos ultimos 13 digitos
    v=v.replace(/(\d{1})(\d{8})$/,"$1.$2"); // coloca ponto antes dos ultimos 8 digitos
    v=v.replace(/(\d{1})(\d{5})$/,"$1.$2"); // coloca ponto antes dos ultimos 5 digitos
    v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2"); // coloca virgula antes dos ultimos 4 digitos
    return v;
}

function soNumeros(v){
    return v.replace(/\D/g,"");
}

function horamask(v) {
    v = v.replace(/\D/g, "");                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = (v.substring(0, 1) > 2) ? "" : v;
    v = (v.substring(0, 1) == 1 && v.substring(1, 2) > 9) ? v.substring(0, 1) : v;
    v = (v.substring(0, 1) == 0 && v.substring(1, 2) > 9) ? v.substring(0, 1) : v;
    v = (v.substring(2, 3) > 5) ? v.substring(0, 2) : v;
    v = v.replace(/(\d{2})(\d)/, "$1:$2");    //Coloca dois pontos entre o segundo e terceiro d&#237;gitos
    v = (v.length > 5) ? v.substring(0, 5) : v;
    return v;
}
function horamasksemanal(v) {
    v = v.replace(/\D/g, "");                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = (v.substring(0, 1) > 9) ? "" : v;
    v = (v.substring(0, 1) == 1 && v.substring(1, 2) > 9) ? v.substring(0, 1) : v;
    v = (v.substring(0, 1) == 0 && v.substring(1, 2) > 9) ? v.substring(0, 1) : v;
    v = (v.substring(2, 3) > 5) ? v.substring(0, 2) : v;
    v = v.replace(/(\d{2})(\d)/, "$1:$2");    //Coloca dois pontos entre o segundo e terceiro d&#237;gitos
    v = (v.length > 5) ? v.substring(0, 5) : v;
    return v;
}

function cep(d){
    d = soNumeros(d);
    d=d.replace(/^(\d{5})(\d)/,"$1-$2");
    return d;
}
$(document).ready(function(){

   fcLogin();

    $('#dt_nascimento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    
    $("#dt_nascimento").on('keyup', function () {
       mascara(this,mdata);
    });
    $("#ds_cpf").on('keyup', function () {
       chama_mascara(this);
    }); 
    $("#ds_cel").on('keyup', function () {
       mascara(this,mascaraTelefone);
    }); 
    $("#ds_cel2").on('keyup', function () {
       mascara(this,mascaraTelefone);
    });   
    $("#ds_cep").on('keyup', function () {
       mascara(this,cep);
    });  
    $("#ds_cep").on('keyup', function () {
        fcCarregarCep();
    });
    
    $(document).on('click', '#cmdEnviarTudo', fcValidarForm);
    
});
function carregar(){
	//C�digo javascript ao carregar a tabela;
}

function enviar(){
    var frm = document.forms[0];

    if(document.getElementById("Mailing").value==''){
        alert('Selecione um Mailing !');
        return false;         
    }

    if(document.getElementById("email_modelo_pk").value==''){
        alert('Selecione um modelo de E-mail !');
        return false;         
    }   

    if(!capturarEmails())
     return false;   

    frm.acao.value = "gravar";
    frm.submit();
}

function enviarGepros(){

    var frm = document.forms[0];

    if(document.getElementById("Mailing").value==''){
        alert('Selecione um Mailing !');
        return false;         
    }

    if(document.getElementById("email_modelo_pk").value==''){
        alert('Selecione um modelo de E-mail !');
        return false;         
    }   

    if(!capturarEmails())
     return false;  
 
    frm.acao.value = "gravarGepros";
    frm.submit();
}


function excluir(vlr){
        
	if(!confirm("Deseja REALMENTE excluir o registro?")){
		return;
	}   
        
	var frm = document.forms[0];
        frm.acao.value = "excluir";
	frm.codcontato.value = vlr;
	frm.submit();
}

function selecionar(){
           var tabela = document.getElementById("tbl");
         
        for(i = 0; i < tabela.rows.length; i++){ 
            document.getElementById("codcontatolead"+i).checked=true;
        }
}

function pesq_mailing(){
    
    
    if(document.getElementById("Mailing").value==''){
        alert('Selecione um Mailing !');
        return false;         
    }

    if(document.getElementById("email_modelo_pk").value==''){
        alert('Selecione um modelo de E-mail !');
        return false;         
    }   


    var mailing = document.getElementById("Mailing").value;
    var email_modelo_pk = document.getElementById("email_modelo_pk").value;
    var qtde = document.getElementById("qtde").value;

    location.href = "email_cad_form.php?Mailing="+mailing+"&email_modelo_pk="+email_modelo_pk+"&qtde="+qtde;
}

function capturarEmails(){

    try{
       
        var frm = document.forms[0];
        var strRetorno = "";
        var strRetorno1 = "";
        var tabela = document.getElementById("tbl");
         
        for(i = 0; i < tabela.rows.length; i++){                     
            if(document.getElementById("codcontatolead"+i).checked==true){                
                strRetorno += document.getElementById("codcontatolead"+i).value+"##"+document.getElementById("codcontatolead"+i).value+"##"+document.getElementById("codlead"+i).value;
                strRetorno += "////";                                         
           }             
        }  
        frm.strEmails.value = strRetorno; 
    }
    catch(e){
        //alert(e.description);
       // return false;
    }
    return true;
}
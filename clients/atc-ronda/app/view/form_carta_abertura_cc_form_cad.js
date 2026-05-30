function fcVoltar(){
    sendPost('formulario_contrato_colaborador_res_form.php',{token: token, colaborador_pk: colaborador_pk});
}
function fcImprimir(){
    window.print();
    
}
function fcCarregar(){
    var v_html = ""    
    var meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"];    
    var hoje = new Date();
    var dia = hoje.getDate();
    var mes = hoje.getMonth()+1;
    var ano = hoje.getFullYear();   

    var data = "São Paulo, "+dia+" de "+ meses[parseInt(mes)-1]+" de "+ano;
    
   var objParametros = {
        "pk": colaborador_pk
    };          
    var arrCarregar = carregarController("colaborador", "listarPk", objParametros); 
    var v_ds_endereco = "";
    var v_ds_numero = "";
    var v_ds_cep = "";
    var v_ds_cidade = "";
    var v_ds_salario = "";
    if(arrCarregar.data[0]['ds_endereco']!=null){
        var v_ds_endereco = arrCarregar.data[0]['ds_endereco'];
    }
    if(arrCarregar.data[0]['ds_numero']!=null){
        var v_ds_numero = arrCarregar.data[0]['ds_numero'];
    }
    if(arrCarregar.data[0]['ds_cep']!=null){
        var v_ds_cep = arrCarregar.data[0]['ds_cep'];
    }
    if(arrCarregar.data[0]['ds_cidade']!=null){
        var v_ds_cidade = arrCarregar.data[0]['ds_cidade'];
    }
    if(arrCarregar.data[0]['ds_salario']!=null){
        var v_ds_salario = arrCarregar.data[0]['ds_salario'];
    }
    
        
    v_html += "<br><br><br>";
    v_html += data+"<br><br><br><br><br><br>";
    v_html += "Ao Banco Itaú S.A<br><br>";    
    v_html += "Ref:  Abertura de Conta Corrente Para Crédito de Salário<br><br><br><br>";    
    v_html += "Prezado Gerente,<br><br>";
    v_html += "Apresentamos o colaborador abaixo, para abertura de conta para recebimento de salário.<br><br><br><br>" ; 
    v_html += "Nome: "+arrCarregar.data[0]['ds_colaborador']+"<br>"; 
    v_html += "CPF: "+arrCarregar.data[0]['ds_cpf']+"<br>"; 
    v_html += "Endereço: "+v_ds_endereco+","+v_ds_numero+"<br>"; 
    v_html += "Cep: "+v_ds_cep+"&nbsp;&nbsp;Cidade:"+v_ds_cidade+"<br><br><br><br><br>"; 
    v_html += "SEG FORMULA Serviços de Portaria Eireli.<br>CNPJ 22.908.962/0001-86<br>Ag 0866<br>CC 14005-6"; 
    
    $("#v_html").html(v_html);
    
}

$(document).ready(function() {      
    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);      
});
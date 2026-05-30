function fcVoltar(){
    sendPost('formulario_contrato_colaborador_res_form.php',{token: token, colaborador_pk: colaborador_pk});
}
function fcImprimir(){
    window.print();
    
}
function fcCarregar(){
    var v_html = ""  ; 

    v_html += "<img src='https://segformula.gepros6.com.br/img/logo_cliente.png'  width='60%'><br><br>";
    

    $("#v_html").html(v_html);    
}

$(document).ready(function() {      
    //Verifica se o registro é para alteracao e puxa os dados.
    //fcCarregar();

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);      
});
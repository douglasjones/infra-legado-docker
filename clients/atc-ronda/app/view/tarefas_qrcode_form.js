function fcCancelar(){
    sendPost("tarefas_res_form.php", {token: token});
}
function fcPriintQrcode(){

    var objParametros = {
        "agenda_colaborador_tarefa_pk": pk
    }; 
    
    var arrCarregar = carregarController("agenda_colaborador_tarefa_itens", "listarPkTarefas", objParametros);
    
    if (arrCarregar.result == 'success'){
        //alert(arrCarregar.data[0]['pk']);
        var v_html = "";
        v_html +="<table align='center'>";
        for(i=0;i<arrCarregar.data.length;i++){  
            var v_pk = arrCarregar.data[i]['pk'];
            v_html +="<tr>";
            v_html +="<td>";
            v_html +="Posto de Trabalho:"+arrCarregar.data[i]['ds_lead'];
            v_html +="</td>";
            v_html +="</tr>";
            v_html +="<tr>";
            v_html +="<td>";
            v_html +="Setor:"+arrCarregar.data[i]['ds_local'];
            v_html +="</td>";
            v_html +="</tr>";   
            v_html +="<tr>";
            v_html +="<td>";
            v_html +="Área:"+arrCarregar.data[i]['ds_area'];
            v_html +="</td>";
            v_html +="</tr>";  
            v_html +="<tr>";
            v_html +="<td>";
            //v_html +="<img id='imageQRCode' src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=https://www.gepros6.com.br/desenvolvimento/crm_condominio/view/login_form.php/?pk="+arrCarregar.data[i]['pk']+"'>";
            v_html +="<img id='imageQRCode' src='https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=https://www.gepros6.com.br/desenvolvimento/crm_condominio/view/tarefas_login.php?pk="+v_pk+"'";
            v_html +="</td>";
            v_html +="</tr>";
        }
        v_html +="</table>";
        
        $("#qr_code").html(v_html)
        
        
               
        
    }
   
}
$(document).ready(function(){

    
    fcPriintQrcode();
    
    $(document).on('click', '#cmdCancelar', fcCancelar); 
    
});
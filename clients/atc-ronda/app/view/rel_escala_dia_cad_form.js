var tblResultado;
var click_id = 0;

function fcCarregarGrid(){  

   var v_leads_pk = leads_pk;
   var v_colabboradores_pk = colaboradores_pk;
   var v_dt_ini = dt_ini;
   var strRetorno = "";

    var strNenhumRegisto = "";
        var objParametros = {
            "leads_pk": v_leads_pk,
            "colaborador_pk": v_colabboradores_pk,
            "dt_ini": v_dt_ini
        };    
 
    var arrCarregar = carregarController("lead", "relatorioEscalaDia", objParametros); 
    alert(v_last_url)
    if (arrCarregar.result == 'success'){

        if(arrCarregar.data.length > 0){                
                strRetorno+="<table id='tabela' class='table-responsive-sm' style='width:100%' id='tblResultado'>";
                strRetorno+="    <thead>";
                strRetorno+="       <tr>";
                strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
                strRetorno+="            <th><input type='text' id='txtRE' /></th>";
                strRetorno+="            <th><input type='text' id='txtDsPin' /></th>";
                strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
                strRetorno+="            <th><input type='text' id='txtFuncao' /></th>";
                //strRetorno+="            <th><input type='text' id='txtHorario' /></th>";
                strRetorno+="            <th><input type='text' id='txtEscala' /></th>";
                strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                strRetorno+="            <th><input type='text' id='txtDtSaidaPonto' /></th>";
                strRetorno+="            <th><input type='text' id='txtTotalHorasTrabalhadas' /></th>";
                strRetorno+="            <th><input type='text' id='txtStatus' /></th>";
                strRetorno+="            <th><input type='text' id='txtLocal' /></th>";
                strRetorno+="            <th><input type='text' id='txtImgPonto' /></th>";
                strRetorno+="       </tr>";
                strRetorno+="       <tr>";
                strRetorno+="           <th>Posto Trabalho</th>";
                strRetorno+="           <th>R.E</th>";
                strRetorno+="           <th>PIN</th>";  
                strRetorno+="           <th>Colaborador</th>";
                strRetorno+="           <th>Função</th>";
                //strRetorno+="           <th>Horário</th>";
                strRetorno+="           <th>Escala</th>";
                strRetorno+="           <th>Dt/HR Entrada</th>";
                strRetorno+="           <th>Dt/HR Saída</th>";
                strRetorno+="           <th>Total Horas</th>";
                strRetorno+="           <th>Status</th>";
                strRetorno+="           <th>Local Ponto App</th>";
                strRetorno+="           <th>Img Ponto App</th>";
                strRetorno+="       </tr>";
                strRetorno+="    </thead>";
                strRetorno+="<tbody'>";
                
            for(j=0; j < arrCarregar.data.length ;j++){  

                if(arrCarregar.data[j]['ds_lead']!= null){
                    $ds_lead = arrCarregar.data[j]['ds_lead'];
                }else{
                    $ds_lead = "";
                }          
                
                if(arrCarregar.data[j]['ds_re']!= null){
                    $ds_re = arrCarregar.data[j]['ds_re'];
                }else{
                    $ds_re = "";
                }
                
                if(arrCarregar.data[j]['ds_pin']!= null){
                    $ds_pin = arrCarregar.data[j]['ds_pin'];
                }else{
                    $ds_pin = "";
                }
                
                if(arrCarregar.data[j]['ds_colaborador']!= null){
                    $ds_colaborador = arrCarregar.data[j]['ds_colaborador'];
                }else{
                    $ds_colaborador = "";
                }
                
                if(arrCarregar.data[j]['ds_produto_servico']!= null){
                    $ds_produto_servico = arrCarregar.data[j]['ds_produto_servico'];
                }else{
                    $ds_produto_servico = "";
                }
                
                if(arrCarregar.data[j]['n_qtde_dias_semana']!= null){
                    $n_qtde_dias_semana = arrCarregar.data[j]['n_qtde_dias_semana'];
                }else{
                    $n_qtde_dias_semana = "";
                }
                
                if(arrCarregar.data[j]['dt_rh_entratada']!= null){
                    $dt_rh_entratada = arrCarregar.data[j]['dt_rh_entratada'];
                }else{
                    $dt_rh_entratada = "";
                }
                
                if(arrCarregar.data[j]['dt_rh_saida']!= null){
                    $dt_rh_saida = arrCarregar.data[j]['dt_rh_saida'];
                }else{
                    $dt_rh_saida = "";
                }
                
                if(arrCarregar.data[j]['ds_total_horas_trabalhadas']!= null){
                    $ds_total_horas_trabalhadas = arrCarregar.data[j]['ds_total_horas_trabalhadas'];
                }else{
                    $ds_total_horas_trabalhadas = "";
                }
                
                if(arrCarregar.data[j]['status']!= null){
                    $status = arrCarregar.data[j]['status'];
                }else{
                    $status = "";
                }
                
               if(arrCarregar.data[j]['ds_localizacao']!= null){
                    $ds_localizacao = arrCarregar.data[j]['ds_localizacao'];
                }else{
                    $ds_localizacao = "";
                }
                
                if(arrCarregar.data[j]['ds_imagem']==null){
                    $ds_imagem="<img src='../img/usuario_sem_imagem.png' width='30'>";
                }else{
                     $ds_imagem="<img src="+arrCarregar.data[j]['ds_imagem']+" width='40'>";
                }
                
                strRetorno+="<tr>";
                strRetorno+="<td width='10%'>"+$ds_lead+"</td>";
                strRetorno+="<td width='10%'>"+$ds_re+"</td>";
                strRetorno+="<td width='10%'>"+$ds_pin+"</td>"; 
                strRetorno+="<td width='10%'>"+$ds_colaborador+"</td>";
                strRetorno+="<td width='10%'>"+$ds_produto_servico+"</td>";
                //strRetorno+="<td width='10%'>"+arrCarregar.data[j]['periodo']+"</td>";
                strRetorno+="<td width='10%'>"+$n_qtde_dias_semana+"</td>";
                strRetorno+="<td width='10%'>"+$dt_rh_entratada+"</td>";
                strRetorno+="<td width='10%'>"+$dt_rh_saida+"</td>";
                strRetorno+="<td width='10%'>"+$ds_total_horas_trabalhadas+"</td>";
                strRetorno+="<td width='10%'>"+$status+"</td>";
                strRetorno+="<td width='10%'>"+$ds_localizacao+"</td>";
                strRetorno+="<td width='10%'>"+$ds_imagem+"</td>";              
            
                strRetorno+="</tr>";
            }

            strRetorno+="</tbody>";
            strRetorno+="</table>";

        }

    }
    else{
        alert('Falhar ao carregar o registro');
    }
    
    if(strRetorno!=""){        
        $("#grid").html(strRetorno);
    }else{ 
        $("#grid").append(strNenhumRegisto);
    }
    
}

pegarUltimoDiaMes = function(year, month){
    var ultimoDia = (new Date(year, month, 0)).getDate();
    return ultimoDia;
};

function pegarPosicaoDiaSemana(data){
    
    var splitData = data.split("/");
    var semana = [0, 1, 2, 3, 4, 5,6];
    var d = new Date(splitData[2], splitData[1] - 1, splitData[0]);
    return semana[d.getDay()];
}

function fcCarregarColaborador(){

    var objParametros = {
        "pk": ds_colaboradores
    };      
    
    var arrCarregar = carregarController("colaborador", "listarPk", objParametros); 
    if (arrCarregar.result == 'success'){
        $("#ds_colaborador").text(arrCarregar.data[0]['ds_colaborador']);
    }
        
}

function fcCancelar(){

    sendPost("rel_escala_dia_res_form.php", {token: token});
}

function fcExport(){

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#form").html() + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "export.xls";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}

$(document).ready(function(){    
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
     
    //fcCarregarColaborador();
 
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
    var seg = today.getSeconds();
    //data
    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 
    //hora 
    if(hh<10) {
        hh = '0'+hh
    } 

    if(min<10) {
        min = '0'+min
    } 
    if(seg<10) {
        seg = '0'+seg
    } 

    today = dd + '/' + mm + '/' + yyyy + ' '+hh+':'+min+':'+seg;
    
   $("#ds_colaborador").text(ds_colaboradores);
   $("#ds_lead").text(ds_lead);
    
    $("#dt_emissao").text(today);
    $("#dt_ini").text(dt_ini);
 
    fcCarregarGrid();
        
    $("#tabela input").keyup(function(){
            var index = $(this).parent().index();
            var nth = "#tabela td:nth-child("+(index+1).toString()+")";
            var valor = $(this).val().toUpperCase();
            $("#tabela tbody tr").show();
            $(nth).each(function(){
                    if($(this).text().toUpperCase().indexOf(valor) < 0){
                            $(this).parent().hide();
                    }
            });
    });
    $("#tabela input").blur(function(){
            $(this).val("");
    });	

});



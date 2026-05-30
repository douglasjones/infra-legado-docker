var tblResultado;
var click_id = 0;

function fcCarregarGrid(){  
    
    
    
    var strModal="";
    $("#grid").append("");
    $("#grid").empty();

    
    strModal+="<div class='row'>";
    strModal+="    <div class='col-md-12'>";
    strModal+="    <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblLeadColaborador'>";
    strModal+="        <thead>";
    strModal+="            <tr>";
    strModal+="                <th>Tipo Apontamento</th>";
    strModal+="                <th>Usuário de Cadastro</th>";
    strModal+="                <th>Dt Cadastro</th>";
    strModal+="                <th>Dt Apontamento</th>";
    strModal+="                <th>Colaborador</th>";
    strModal+="                <th>Posto de Trabalho</th>";    
    strModal+="                <th>Observação</th>";    
    strModal+="            </tr>";
    strModal+="        </thead>";
    strModal+="        <tbody>";
    var objParametros = {
        "colaborador_pk": colaborador_pk,
        "dt_ini": dt_apontamento_ini,
        "dt_fim": dt_apontamento_fim,
        "leads_pk": leads_pk,
        "tipo_apontamento_pk": tipo_apontamento_pk,
    };         

    var arrCarregar = carregarController("agenda_colaborador_apontamento", "relApontamento", objParametros);

    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){
          
            for(i=0; i < arrCarregar.data.length ;i++){
                var obs = "";

                if(arrCarregar.data[i]['t_obs']!=null){
                    obs = arrCarregar.data[i]['t_obs'];
                }

                strModal+="<tr>";
                strModal+="<th width='20%'>"+arrCarregar.data[i]['t_ds_tipo_apontamento']+"</th>";
                strModal+="<th width='20%'>"+arrCarregar.data[i]['t_ds_usuario']+"</th>";
                strModal+="<th width='20%'>"+arrCarregar.data[i]['t_dt_cadastro']+"</th>";
                strModal+="<th width='20%'>"+arrCarregar.data[i]['t_dt_apontamento']+"</th>";                
                strModal+="<th width='20%'>"+arrCarregar.data[i]['t_ds_colaborador']+"</th>";     
                strModal+="<th width='20%'>"+arrCarregar.data[i]['t_ds_lead']+"</th>";  
                strModal+="<th width='20%'>"+obs+"</th>";  
                strModal+="</tr>";
            }
        }   
    }
    
    strModal+="</tbody>";
    strModal+="</table>";
    strModal+="</div>";
    strModal+="</div>";
        
    $("#grid").append(strModal);
     
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

    sendPost("rel_apontamento_colaborador_res_form.php", {token: token});
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





function fcHistoricoApontamento(){
    
    
    
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
    
   $("#ds_colaborador").text(ds_colaborador);
   $("#ds_tipo_apontamento").text(ds_tipo_apontamento);
   $("#ds_lead").text(ds_lead);
    
    $("#dt_emissao").text(today);
    $("#dt_ini").text(dt_apontamento_ini);
    $("#dt_fim").text(dt_apontamento_fim);
 
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
    $("#loader").hide();
    $("#exibir").show();

});



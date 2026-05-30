var tblResultado;
var click_id = 0;

function fcCarregarGrid(){  
    
    
    var v_leads_pk = leads_pk;
    var v_colabboradores_pk = colaboradores_pk;
    var dt_agenda_ini = dt_ini;
    var v_dt_ini = dt_ini;
   
    var strRetorno = "";

    var strNenhumRegisto = "";
    
    var objParametros1 = {
        "leads_pk": v_leads_pk,
        "colaborador_pk": v_colabboradores_pk,
        "dt_agenda": dt_ini,
        "dt_agenda_fim": dt_fim,
    };         

    var arrCarregar1 = carregarController("agenda_colaborador_pausa", "listarAgendaPausaFolga", objParametros1);
  
    if (arrCarregar1.result == 'success'){
        
        if(arrCarregar1.data.length > 0){
            strRetorno+="<table id='tabela' class='table table-striped table-bordered nowrap' style='width:100%' id='tblResultado'>";
            strRetorno+="    <thead>";
            strRetorno+="       <tr>";
            strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
            strRetorno+="            <th><input type='text' id='txtFuncao' /></th>";
            strRetorno+="            <th><input type='text' id='txtRE' /></th>";
            strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno' /></th>";
            strRetorno+="       </tr>";
            strRetorno+="       <tr>";
            strRetorno+="           <th>Posto Trabalho</th>";
            strRetorno+="           <th>Colaborador</th>";
            strRetorno+="           <th>Data Folga</th>";
            strRetorno+="           <th>Motivo Folga</th>";
            strRetorno+="           <th>Observação</th>";
            strRetorno+="       </tr>";
            strRetorno+="    </thead>";
            strRetorno+="<tbody'>";
            for(i=0; i < arrCarregar1.data.length ;i++){
                var motivo = "";
                if(arrCarregar1.data[i]['ds_motivo_folga']!=null){
                    var motivo = arrCarregar1.data[i]['ds_motivo_folga'];
                }
                var obs = "";
                if(arrCarregar1.data[i]['ds_obs_folga']!=null){
                    var obs = arrCarregar1.data[i]['ds_obs_folga'];
                }
                strRetorno+="<tr>";
                strRetorno+="<td width='10%'>"+arrCarregar1.data[i]['ds_lead']+"</td>";
                strRetorno+="<td width='10%'>"+arrCarregar1.data[i]['ds_colaborador']+"</td>";
                strRetorno+="<td width='10%'>"+arrCarregar1.data[i]['dt_inicio_pausa']+"</td>";
                strRetorno+="<td width='10%'>"+motivo+"</td>";
                strRetorno+="<td width='10%'>"+obs+"</td>";
                strRetorno+="</tr>";

                }
            strRetorno+="</tbody>";
            strRetorno+="</table>";
            }
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

    sendPost("rel_folga_colaborador_res_form.php", {token: token});
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
    $("#dt_fim").text(dt_fim);
 
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



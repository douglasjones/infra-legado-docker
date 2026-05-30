var tblResultado;
var click_id = 0;




function fcCarregarGrid(){
  
  
  
  
  
    var ArrDataIni = dt_ini.split("/");
    var ArrDataFim = dt_fim.split("/");
    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
    //0 dia; 1 mes; 2 ano

    var date1 = new Date(ArrDataIni[2], ArrDataIni[1] - 1, ArrDataIni[0]);
    var date2 = new Date(ArrDataFim[2], ArrDataFim[1] - 1, ArrDataFim[0]);

   
    var diffDays = (date2 - date1)/(1000*3600*24);
    
    var dt_agenda = dt_ini;
    
    var strNenhumRegisto = "";
    var strRetorno = "";
    
    
    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

    strRetorno+="<tbody>";
    strRetorno+="       <tr>";
    strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
    strRetorno+="            <th><input type='text' id='txtFuncao' /></th>";
    strRetorno+="            <th><input type='text' id='txtRE' /></th>";
    strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
    strRetorno+="            <th><input type='text' id='txtTurno' /></th>";
    strRetorno+="       </tr>";
    strRetorno+="<tr>";
    strRetorno+="<th width='20%'>Posto de Trabalho</th>";
    strRetorno+="<th width='20%'>Colaborador</th>";
    strRetorno+="<th width='20%'>Data Falta</th>";
    strRetorno+="<th width='20%'>Motivo Falta</th>";
    strRetorno+="<th width='20%'>Observação</th>";

    strRetorno+="</tr>";
    
    
    
    
    for(j = 0 ;j<= diffDays;j++){
        var objParametros = {
            "colaborador_pk": colaboradores_pk,
            "leads_pk": leads_pk,
            "dt_ini": dt_agenda,
            "dt_fim": dt_agenda
        };         

        var arrCarregar = carregarController("colaborador_falta", "RelatorioFalta", objParametros); 
      
        if (arrCarregar.result == 'success'){

            if(arrCarregar.data.length > 0){    
                for(i=0; i < arrCarregar.data.length ;i++){
                    if(arrCarregar.data[i]['ds_colaborador']==null){
                        var ds_colaborador = "";
                    }
                    else{
                        var ds_colaborador = arrCarregar.data[i]['ds_colaborador'];
                    }
                    if(arrCarregar.data[i]['ds_lead']==null){
                        var ds_lead = "";
                    }
                    else{
                        var ds_lead = arrCarregar.data[i]['ds_lead'];
                    }
                    if(arrCarregar.data[i]['dt_escala']==null){
                        var dt_escala = "";
                    }
                    else{
                        var dt_escala = arrCarregar.data[i]['dt_escala'];
                    }
                    if(arrCarregar.data[i]['ds_motivo_falta']==null){
                        var ds_motivo_falta = "";
                    }
                    else{
                        var ds_motivo_falta = arrCarregar.data[i]['ds_motivo_falta'];
                    }
                    if(arrCarregar.data[i]['obs']==null){
                        var obs = "";
                    }
                    else{
                        var obs = arrCarregar.data[i]['obs'];
                    }

                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>"+ds_lead+"</th>";
                    strRetorno+="<th width='20%'>"+ds_colaborador+"</th>";
                    strRetorno+="<th width='20%'>"+dt_escala+"</th>";
                    strRetorno+="<th width='20%'>"+ds_motivo_falta+"</th>";
                    strRetorno+="<th width='20%'>"+obs+"</th>";
                    strRetorno+="</tr>";
                }
                
                

            }

        }
        else{
            alert('Falhar ao carregar o registro');
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
         var p_nova_dt_agenda = dt_agenda.split("/");


        //pega a data que ja passou pelo for 
        var nova_dt_agenda_dia_anterior = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
        var nova_dt_agenda_dia_proximo = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
        //a cada looping acrescenta mais um dia 
        nova_dt_agenda_dia_proximo.setDate(nova_dt_agenda_dia_anterior.getDate() + 1);

        var dt_agenda = 0;
        var dia = 0;
        var mes = 0;
        var ano = 0;
        if(nova_dt_agenda_dia_proximo.getDate()<10){
            dia = "0"+nova_dt_agenda_dia_proximo.getDate();
            mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
            ano = nova_dt_agenda_dia_proximo.getFullYear();
        }
        else{
            dia = nova_dt_agenda_dia_proximo.getDate();
            mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
            ano = nova_dt_agenda_dia_proximo.getFullYear();
        }

        if((nova_dt_agenda_dia_proximo.getMonth()+1)<10){
            mes = "0"+(nova_dt_agenda_dia_proximo.getMonth()+1);
            ano = nova_dt_agenda_dia_proximo.getFullYear();

        }
        else{
            mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
            ano = nova_dt_agenda_dia_proximo.getFullYear();

        }                
        dt_agenda = dia+"/"+mes+"/"+ano;
        
    }
    strRetorno+="</tbody>";
    strRetorno+="</table>";
    strRetorno+="</div>";
    strRetorno+="</div>";
    strRetorno+="<br><br><br><br>";
    
    if(strRetorno!=""){
        $("#grid").html(strRetorno);
    }
    else{

        strNenhumRegisto+="<div class='row'>";
        strNenhumRegisto+="<div class='col-md-12 text-center'>";
        strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
        strNenhumRegisto+=" </div>";
        strNenhumRegisto+="</div>";
        $("#grid").html(strNenhumRegisto);
    }
      
    
}


function fcVerificarPontoColaborador(leads_pk,colaboradores_pk,dt_base){

    var objParametros = {
        "leads_pk": leads_pk,
        "colaborador_pk": colaboradores_pk,
        "dt_base": dt_base
    };  
    
    var intRegistroPonto = 0;
 
    var arrCarregar = carregarController("ponto", "relatorioFalta", objParametros); 
    
    if (arrCarregar.result == 'success'){
        intRegistroPonto = arrCarregar.data[0]['registros'];
    }
    else{
        alert('Falhar ao carregar o registro');
    }
    return intRegistroPonto;
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

    sendPost("rel_falta_colaborador_sistema_res_form.php", {token: token});
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
    $("#loader").hide();
    $("#exibir").show();
        
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



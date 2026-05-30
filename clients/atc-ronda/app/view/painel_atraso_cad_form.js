var tblResultado;
var click_id = 0;

function fcCarregarDatatable(){


    var objParametros = {
        "dt_ini": $("#dt_ini").val(),
        "dt_fim": $("#dt_fim").val()
    };

    var v_url = montarUrlController("ponto", "popUpAtraso", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": false,
        "searching": false,
        "paging":false,
        "columnDefs": [
           {"targets": -6, "data": "ds_lead"},
           {"targets": -5, "data": "ds_tel"},
           {"targets": -4, "data": "ds_colaborador"},
           {"targets": -3, "data": "ds_cel"},
           {"targets": -2, "data": "hr_escala"},
           {"targets": -1, "data": "ds_hr_dif"}
         ],
         "rowCallback": function( row, data, index ) {
            //COR DOS HORARIOS
            if(parseInt(data.segundos) >=60 && parseInt(data.segundos)< 600){
                $(row).css('background-color','#c3c3c1');
            }
            if(parseInt(data.segundos)>= 600){
                $(row).css('background-color','#e6df55');
            }
            if(parseInt(data.segundos)>= 900){
                $(row).css('background-color','#f99856');
                $(row).css('color','#FFFFFF');
            }
            if (parseInt(data.segundos)>= 1500){
                $(row).css('background-color','#ec1c24');
                $(row).css('color','#FFFFFF');
            }
            if (parseInt(data.segundos)<= 0){
                $(row).css('background-color','#63ed83');
            }
            if(data.t_ic_tipo_transacao==1){
                $(row).css('background-color','#ffb4b4');
            }
        },
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $("#exibir").show();
    $("#loader").hide();
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

function fcAtualizar(){
    $("#loader").show();
    $("#exibir").hide();
    tblResultado.ajax.reload();
    $("#exibir").show();
    $("#loader").hide();
}

$(document).ready(function(){    
    $(document).on('click', '#cmdAtualizar', fcAtualizar);
    
    $("#menu_desabilitar_pop").hide();
    

    var today = new Date();
    var periodo = new Date();
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
    periodo  = dd + '/' + mm + '/' + yyyy;
    
    $("#dt_emissao").text(today);
    $("#dt_ini").val(periodo);
    $("#dt_fim").val(periodo);
    
    fcCarregarDatatable();

    $("#tblResultado input").keyup(function(){
        var index = $(this).parent().index();
        var nth = "#tblResultado td:nth-child("+(index+1).toString()+")";
        var valor = $(this).val().toUpperCase();
        $("#tblResultado tbody tr").show();
        $(nth).each(function(){
                if($(this).text().toUpperCase().indexOf(valor) < 0){
                        $(this).parent().hide();
                }
        });
    });
    $("#tblResultado input").blur(function(){
            $(this).val("");
    });	
    
    //atualiza de 5 em 5 min
    setInterval(function() {
        $("#loader").show();
        $("#exibir").hide();
        tblResultado.ajax.reload();
        $("#exibir").show();
        $("#loader").hide();
      }, 300000);
    
});



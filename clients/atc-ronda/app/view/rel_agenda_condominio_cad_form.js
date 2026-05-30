var tblResultado;
function fcCarregarGrid(){
    
    var objParametros = {
        "leads_pk": leads_pk,
        "dt_inicio_periodo": dt_periodo_ini,
        "dt_fim_periodo": dt_periodo_fim
    };     
    
    var v_url = montarUrlController("agenda_colaborador_padrao", "relatorioAgendaLead", objParametros);
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "columnDefs": [
           //{"targets": -1, "data": "t_ds_motivo_pausa"},
           {"targets": -1, "data": "t_ds_turno"},
           {"targets": -2, "data": "t_dt_fim_agenda"},
           {"targets": -3, "data": "t_dt_inicio_agenda"},
           {"targets": -4, "data": "t_ds_colaborador"}
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });        
    
}


$(document).ready(function(){

    //faz a carga inicial do grid.
    fcCarregarGrid();
});



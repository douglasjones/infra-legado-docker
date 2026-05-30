var tblResultado;

function fcEditar(v_pk,v_colaborador_pk){
    var v_leads_pk = $("#leads_pk").val();

    sendPost('ponto_folha_registros_cad_form.php', {token: token, pk: v_pk,colaborador_pk: v_colaborador_pk,leads_pk: v_leads_pk});
}

function fcPrintFolhaColaborador(v_pk,v_colaborador_pk){
    var v_leads_pk = $("#leads_pk").val();
   
    sendPost('ponto_folha_print_form.php', {token: token, pk: v_pk,colaborador_pk: v_colaborador_pk,leads_pk: v_leads_pk});
}

function fcPrintFolhaTodosColaborador(){
    var v_leads_pk = $("#leads_pk").val();
    var v_colaborador_pk = "";
    sendPost('ponto_folha_print_form.php', {token: token, pk: pk,colaborador_pk: v_colaborador_pk,leads_pk: v_leads_pk});
}


function fcExcluir(ponto_folha_pk,colaborador_pk){
    if (confirm("Deseja realmente excluir o registro?")){
        if(ponto_folha_pk != ""){

            var objParametros = {
                "ponto_folha_pk": ponto_folha_pk,
                "colaborador_pk":colaborador_pk
            };              
            
            var arrExcluir = carregarController("ponto_folha_registro", "excluirFolhaColaborador", objParametros);   

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}
function fcCarregarGrid(){

    var objParametros = {
        "ponto_folha_pk": pk
    };     
    
    var v_url = montarUrlController("ponto_folha_registro", "listarPontoFolhaPK", objParametros);
   
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;<a class='function_fcPrint'><span><img width=16 height=16 src='../img/impressora.png'></span></a>&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },         
           {"targets": -2, "data": "t_ds_colaborador"},
           {"targets": -3, "data": "t_ic_status"},
           {"targets": -4, "data": "t_dt_ult_atualizacao"},
           {"targets": -5, "data": "t_dt_cadastro"},
           {"targets": -6, "data": "t_ponto_folha_pk",visible:false},
           {"targets": -7, "data": "t_colaborador_pk"},
           {"targets": -8, 'defaultContent':"<input type=checkbox name='checks[]' value='1'>" }
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcEditar(data['t_ponto_folha_pk'],data['t_colaborador_pk']);
        
    } );   

    $('#tblResultado tbody').on('click', '.function_fcPrint', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcPrintFolhaColaborador(data['t_ponto_folha_pk'],data['t_colaborador_pk']);
    } );  
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_ponto_folha_pk'],data['t_colaborador_pk']);
    } );        
    
}

function fcAbrirRegerar(){
    var data;
    var colaboradores_pk = [];

    data = tblResultado.rows('.selected').data();
    for(var l=0; l<data.length; l++){
        if(data[l]['t_ic_status']=="Finalizada"){
            alert("Folhas finalizadas não podem ser regeradas. Por favor escolha folhas que não foram finalizadas.");
            return false;
        }
    }

    for(var i=0; i<data.length; i++){
        colaboradores_pk[i] = data[i]['t_colaborador_pk']; 
    }
    var json_colaboradores = JSON.stringify(colaboradores_pk);
    $("#colaboradores_pk").val(json_colaboradores);
    $("#dt_ini_periodo").val($("#dt_periodo_ini").html());
    $("#dt_fim_periodo").val($("#dt_periodo_fim").html());
    $("#data_periodo_ini").val($("#dt_periodo_ini").html());
    $("#data_periodo_fim").val($("#dt_periodo_fim").html());
    $("#ponto_folha_pk").val(data[0]['t_ponto_folha_pk']);

    $("#janela_regerar").modal();
}

function fcCarregar(){
    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("ponto_folha", "listarFolhasRegstros", objParametros);
  
        if (arrCarregar.result == 'success'){
            
            $("#ds_empresa").html(arrCarregar.data[0]['ds_empresa']);
            $("#ds_lead").html(arrCarregar.data[0]['ds_lead']);
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $("#dt_periodo_ini").html(arrCarregar.data[0]['dt_periodo_ini']);
            $("#dt_periodo_fim").html(arrCarregar.data[0]['dt_periodo_fim']);
            $("#obs").val(arrCarregar.data[0]['obs']); 
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcPrintAll(){
    var v_leads_pk = $("#leads_pk").val();
    sendPost('ponto_folha_print_all_form.php', {token: token, pk: pk, leads_pk: v_leads_pk});
}

function fcGerarPlanilhaExcel(){
    var v_leads_pk = $("#leads_pk").val();
    sendPost('ponto_folha_planilha_form.php', {token: token, pk: pk, leads_pk: v_leads_pk});
}

function fcCancelar(){
   sendPost("ponto_folha_res_form.php", {token: token});
   //history.back();
}

$(document).ready(function(){

    fcCarregar();
    
    $(document).on('click', '#cmdVoltar', fcCancelar);
    $(document).on('click', '#cmdPrintAll', fcPrintAll);
    $(document).on('click', '#cmdGerarPlanilhaExcel', fcGerarPlanilhaExcel);
    $(document).on('click', '#cmdImprimirModal', fcPrintFolhaTodosColaborador);
    $(document).on('click', '#cmdRegerarFolha', fcAbrirRegerar);
    
    //faz a carga inicial do grid.
    fcCarregarGrid();
    
    //Atribui os eventos dos demais controles
    //$(document).on('click', '#cmdPesquisar', fcPesquisar);
    //$(document).on('click', '#cmdIncluir', fcIncluir);

    $('#tblResultado tbody').on('click', "input[name='checks[]']", function () { 
         $(this).parents("tr").toggleClass('selected');
    });


});



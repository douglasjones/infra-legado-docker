var tblResultado;
function fcPesquisar(){	
    tblResultado.clear().destroy();
    fcCarregarGrid();    
}

function fcExcluir(v_pk, v_fornecedor_pk){
    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){
            var objParametros = {
                "pk": v_pk
            };   
            var arrExcluir = carregarController("compras_solicitacao_orcamentos", "excluir", objParametros);  

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
    var v_compra_solicitacao_pk =""    
    if(compra_solicitacao_pk > 0){
       v_compra_solicitacao_pk =  compra_solicitacao_pk;
    }

    var objParametros = {
        "compra_solicitacao_pk": v_compra_solicitacao_pk
    };         
    var v_url = montarUrlController("compras_solicitacao_orcamentos", "listarDataTable", objParametros);

    //Trata a tabela
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
                "defaultContent": "&nbsp;&nbsp;&nbsp;<a class='function_impressao'><span><img width=16 height=16 src='../img/impressora.png'></span></a>&nbsp;&nbsp;&nbsp;<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_compra_solicitacao_pk",visible:false},
           {"targets": -3, "data": "t_obs_orcamento",visible:false},
           {"targets": -4, "data": "t_ds_status"},
           {"targets": -5, "data": "t_ic_status",visible:false},           
           {"targets": -6, "data": "t_vl_total"},
           {"targets": -7, "data": "t_vl_frete"},
           {"targets": -8, "data": "t_dt_pevisao_entrega"},
           {"targets": -9, "data": "t_ds_fornecedor"},
           {"targets": -10, "data": "t_fornecedor_pk",visible:false},
           {"targets": -11, "data": "t_compras_solicitacao_orcamentos_pk"}

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
        //fcEditarOrcamento(data['t_pk']); 
        fcEditarOrcamento(data['t_compras_solicitacao_orcamentos_pk']);
    } );   
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_compras_solicitacao_orcamentos_pk'], data['t_fornecedor_pk']);
    } );            
    $('#tblResultado tbody').on('click', '.function_impressao', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcImprimir(data['t_compras_solicitacao_orcamentos_pk'], data['t_compra_solicitacao_pk']);
    } );            
    
}
function fcImprimir(compras_solicitacao_orcamentos_pk, compra_solicitacao_pk){
    sendPost('impressao_compras_solicitacao_orcamentos_res_form.php', { token: token, compra_solicitacao_pk: compra_solicitacao_pk,  compras_solicitacao_orcamentos_pk: compras_solicitacao_orcamentos_pk});
}

/*function fcIncluir(){
    fcEnviarSolicitacaoCompras(); 
}**/

function fcEditarOrcamento(compras_solicitacao_orcamentos_pk){
    sendPost('compras_solicitacao_orcamentos_cad_form.php', {token: token, pk: compras_solicitacao_orcamentos_pk, compra_solicitacao_pk: compra_solicitacao_pk, usuario_aprovacao_pk: usuario_aprovacao_pk})
}

$(document).ready(function(){     
    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#btnNewOrcamento', fcEnviarSolicitacaoCompras);
});



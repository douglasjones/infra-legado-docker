var tblResultado;
function fcPesquisar(){

    tblResultado.clear().destroy();
    fcCarregarGrid();

}

function fcIncluir(){

    sendPost('financeiro_conciliacao_banco_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_link_arquivo){

    if (confirm("Deseja realmente excluir o registro '" + v_ds_link_arquivo + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("financeiro_conciliacao_banco", "excluir", objParametros);

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

function fcEditar(v_pk){
    sendPost('financeiro_conciliacao_banco_cad_form.php', {token: token, pk: v_pk});
}

function fcDetalhar(v_pk){
    sendPost('financeiro_conciliacao_banco_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){


    var objParametros = {
    };

    var v_url = montarUrlController("financeiro_conciliacao_banco", "listarDataTable", objParametros);
    //NewWindow(v_last_url)
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a title='Editar' class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a title='Incluir' class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_dt_periodo_saldo"},
           {"targets": -3, "data": "t_ds_conta_bancaria"},
           {"targets": -4, "data": "t_ds_agencia"},
           {"targets": -5, "data": "t_ds_banco"},
           {"targets": -6, "data": "t_ds_conta"},
           {"targets": -7, "data": "t_pk"}

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
        fcEditar(data['t_pk']);

    } );

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_ds_link_arquivo']);
    } );

}

function fcCarregarBancos(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("banco", "listarTodos", objParametros);    
    carregarComboAjax($("#bancos_pk"), arrCarregar, " ", "pk", "ds_banco");        
}
function carregarComboEmpresa(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("conta", "listarPk", objParametros);   
   
    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_razao_social");
}

$(document).ready(function(){

    fcCarregarBancos();
    carregarComboEmpresa();
    
    $(".chzn-select").chosen({allow_single_deselect: true});

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

    //faz a carga inicial do grid.
    fcCarregarGrid();


});



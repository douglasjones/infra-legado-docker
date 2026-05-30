var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){

    sendPost('plano_contas_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_tipo_operacao){
    if(v_pk==1000){
        alert(v_ds_tipo_operacao+" Não pode ser excluido.");
        return false;
    }
    else if(v_pk==1001){
        alert(v_ds_tipo_operacao+" Não pode ser excluido.");
        return false;
    }
    else if(v_pk==1002){
        alert(v_ds_tipo_operacao+" Não pode ser excluido.");
        return false;
    }
    else{
        if (confirm("Deseja realmente excluir o registro '" + v_ds_tipo_operacao + "'?")){
            if(v_pk != ""){

                var objParametros = {
                    "pk": v_pk
                };              

                var arrExcluir = carregarController("plano_contas", "excluir", objParametros);   

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
    
}

function fcEditar(v_pk){
    sendPost('plano_contas_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){

    
    var objParametros = {
        "ds_tipo_operacao": $("#ds_tipo_operacao").val(),
        "ic_status": $("#ic_status").val()
    };     
    
    var v_url = montarUrlController("plano_contas", "listarDataTable", objParametros);
  
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_status"},
           {"targets": -3, "data": "t_ds_categoria"},
           {"targets": -4, "data": "t_ds_tipo_operacao"},
           {"targets": -5, "data": "t_pk"}

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
        fcExcluir(data['t_pk'], data['t_ds_tipo_operacao']);
    } );            
    
}



$(document).ready(function(){

    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});



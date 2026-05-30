var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){

    sendPost('usuario_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_usuario){

    if (confirm("Deseja realmente excluir o registro '" + v_ds_usuario + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("usuario", "excluir", objParametros);   

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
    sendPost('usuario_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){

    
    var objParametros = {
        "ds_usuario": $("#ds_usuario").val(),
        "contas_pk": $("#contas_pk").val(),
        "grupos_pk": $("#grupos_pk").val(),
        "ic_status": $("#ic_status").val()
    };     
    
    var v_url = montarUrlController("usuario", "listarGrid", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 title='Editar Usuário' src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 title='Excluir Usuário' height=16 src='../img/excluir.png'></span></a>"
            },           
           {"targets": -2, "data": "t_ds_status"},
           {"targets": -3, "data": "t_ds_cel"},
           {"targets": -4, "data": "t_ds_email"},
           {"targets": -5, "data": "t_ds_grupo"},
           {"targets": -6, "data": "t_ds_conta"},
           {"targets": -7, "data": "t_ds_login"},
           {"targets": -8, "data": "t_ds_usuario"},
           {"targets": -9, "data": "t_pk"}

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
        fcExcluir(data['t_pk'], data['t_ds_usuario']);
    } );            
    
}


function fcVoltar(){
    sendPost("menu_administracao.php", {token: token});
}

function fcCarregarContas(){
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("conta", "listarTodos", objParametros);    
    carregarComboAjax($("#contas_pk"), arrCarregar, " ", "pk", "ds_conta");        
}


function fcCarregarGrupos(){
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("grupo", "listarTodos", objParametros);    
    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_grupo");        
}

$(document).ready(function(){

    //faz a carga inicial do grid.
    fcCarregarGrid();
    fcCarregarContas();
    fcCarregarGrupos();
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
    $(document).on('click', '#cmdVoltar', fcVoltar);

});



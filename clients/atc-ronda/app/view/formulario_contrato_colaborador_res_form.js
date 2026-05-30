var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}


function fcEditar(ds_link){
    
    sendPost(ds_link, {token: token, colaborador_pk: colaborador_pk});
}

function fcCarregarGrid(){

    
    var objParametros = {
        
    };     
    
    var v_url = montarUrlController("colaborador", "listarFormulario", objParametros);   
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 title='Abrir Formulário' src='../img/copiar.png'></span></a>"
            },
           {"targets": -2, "data": "ds_formulario"},
           {"targets": -3, "data": "pk"}

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
        fcEditar(data['ds_link']);
        
    } );   
    
             
    
}



$(document).ready(function(){
    //faz a carga inicial do grid.
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);

});



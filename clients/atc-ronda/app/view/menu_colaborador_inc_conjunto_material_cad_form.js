var tblMaterial;
function fcCarregarGridConjuntoMateriais(){
    
    var objParametros = {
       "leads_pk": leads_pk,
       "colaborador_pk": pk,
    };     

    var v_url = montarUrlController("conjunto_material", "listarColaboradorPk", objParametros);
    //Trata a tabela
    tblConjuntoMaterial = $('#tblConjuntoMaterial').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": true,
        "paging": true,
        "bFilter": true,
        "bInfo": false, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_delete'><span><img width=16 height=16 src='../img/impressora.png'></span></a>"
            },
           {"targets": -2, "data": "ds_conjunto_material"},           
           {"targets": -3, "data": "pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });   
      
    //Atribui os eventos na coluna ação.
    $('#tblConjuntoMaterial tbody').on('click', '.function_delete', function () {
         var data;
        
        rLinhaSelecionada = null;
        
        if(tblConjuntoMaterial.row( $(this).parents('li')).data()){
            data = tblConjuntoMaterial.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblConjuntoMaterial.row( $(this).parents('tr')).data()){
            data = tblConjuntoMaterial.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        
        fcImprimirConjuntoMaterial(data,1);  
     
    } );   
    
    return false;
}

function fcImprimirConjuntoMaterial(objRegistro,local){
   sendPost('impressao_material.php',{token: token, pk: pk,leads_pk:leads_pk,conjunto_material_pk:objRegistro['pk'],ds_colaborador:$("#ds_colaborador").val(),ds_re:$("#ds_re").val(),ds_secao:$("#ds_secao").val(),dt_admissao:$("#dt_admissao").val(),dt_demissao:$("#dt_demissao").val(),local:local});
}


$(document).ready(function(){
    
    
    fcCarregarGridConjuntoMateriais();

    
});

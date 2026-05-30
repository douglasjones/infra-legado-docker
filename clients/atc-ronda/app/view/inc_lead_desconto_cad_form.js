var tblDesconto
var strComboProdutoServico = "";
function fcFormatarGridDesconto(){
    tblDesconto = $("#tblDesconto").DataTable(
        {
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2,3]
            }],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        }
    );
    return false;

}


function fcAtualizarDadosGridDesconto(){

    var objParametros = {
        "leads_pk":leads_pk,
        "token": token
    };

    var arrCarregar = carregarController("lead_desconto", "listarDescontoPorLead", objParametros);
   
        if (arrCarregar.result == 'success'){
            for(i = 0; i < arrCarregar.data.length; i++){

                //Adiciona a linha.
                fcIncluirDesconto();

                //Pega as variaveis
                var ds_desconto = $("input[id='ds_desconto']");
                var dt_base_desconto = $("input[id='dt_base_desconto']");
                var vl_desconto = $("input[id='vl_desconto']");

                ds_desconto.get(i).value = arrCarregar.data[i]['ds_desconto'];
                dt_base_desconto.get(i).value = (arrCarregar.data[i]['dt_base']);
                vl_desconto.get(i).value = float2moeda(arrCarregar.data[i]['vl_desconto']);

            }
        }
        else{

            alert('Falhar ao carregar o registro');
        }

}

function fcIncluirDesconto(){

    tblDesconto.row.add(
            [
             "<input type='text' class='form-control form-control-sm'  id='ds_desconto' />",
             "<input type='text' class='form-control form-control-sm' onkeypress='mascara(this, mdata)' maxlength='10' id='dt_base_desconto' />",
             "<input type='text' class='form-control form-control-sm' onkeypress='mascara(this, moeda)' id='vl_desconto' />",
             "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcExcluirLinhaDesconto);

    return false;
}

function fcExcluirLinhaDesconto(){
    
    tblDesconto.row($(this).parents('tr')).remove().draw();

    return false;
}
function fcFormatarDadosDesconto(){

    var ds_desconto = $("input[id='ds_desconto']");
    var dt_base_desconto = $("input[id='dt_base_desconto']");
    var vl_desconto = $("input[id='vl_desconto']");

    var arrKeys = [];
    arrKeys[0] = "ds_desconto";
    arrKeys[1] = "dt_base_desconto";
    arrKeys[2] = "vl_desconto";

    var arrDados = [];

    var data = tblDesconto.rows().data();
            
    for(i = 0; i < data.length; i++){

        arrDados[i] = [ds_desconto.get(i).value,dt_base_desconto.get(i).value,moeda2float(vl_desconto.get(i).value)];

    }

    return arrayToJson(arrKeys, arrDados);

}
$(document).ready(function(){  
    
    $(document).on('click', '#cmdIncluirDesconto', fcIncluirDesconto);
    
    fcFormatarGridDesconto();
    fcAtualizarDadosGridDesconto();
    
});
var tblImposto
var strComboProdutoServico = "";
function fcFormatarGridImposto(){
    tblImposto = $("#tblImposto").DataTable(
        {
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2]
            }],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        }
    );
    return false;

}

function carregarListaComboImposto(){
        
    
        strComboProdutoServico = "<select class='form-control form-control-sm' id='imposto_pk' name='imposto_pk'><option></option>";
        strComboProdutoServico += "<option value='1'>INSS</option>";
        strComboProdutoServico += "<option value='2'>ISSQN</option>";
        strComboProdutoServico += "</select>";
        //Carrega os dados no combo.
        fcFormatarGridImposto();
        fcAtualizarDadosGridImposto();
}


function fcAtualizarDadosGridImposto(){

    var objParametros = {
        "leads_pk":leads_pk,
        "token": token
    };

    var arrCarregar = carregarController("lead_imposto", "listarImpostoPorLead", objParametros);
   
        if (arrCarregar.result == 'success'){
            for(i = 0; i < arrCarregar.data.length; i++){

                //Adiciona a linha.
                fcIncluirImposto();

                //Pega as variaveis
                var imposto_pk = $("select[id='imposto_pk']");
                var ds_percentual_imposto = $("input[id='ds_percentual_imposto']");

                imposto_pk.get(i).value = arrCarregar.data[i]['imposto_pk'];
                ds_percentual_imposto.get(i).value = float2moeda(arrCarregar.data[i]['ds_percentual_imposto']);

            }
        }
        else{

            alert('Falhar ao carregar o registro');
        }

}

function fcIncluirImposto(){

    tblImposto.row.add(
            [
             strComboProdutoServico,
             "<input type='text' class='form-control form-control-sm' onkeypress='mascara(this, moeda)' maxlength='6' id='ds_percentual_imposto' />",
             "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcExcluirLinhaImposto);

    return false;
}

function fcExcluirLinhaImposto(){

    tblImposto.row($(this).parents('tr')).remove().draw();

    return false;
}
function fcFormatarDadosImposto(){

    var imposto_pk = $("select[id='imposto_pk']");
    var ds_percentual_imposto = $("input[id='ds_percentual_imposto']");

    var arrKeys = [];
    arrKeys[0] = "imposto_pk";
    arrKeys[1] = "ds_percentual_imposto";

    var arrDados = [];

    var data = tblImposto.rows().data();
            
    for(i = 0; i < data.length; i++){

        arrDados[i] = [imposto_pk.get(i).value,moeda2float(ds_percentual_imposto.get(i).value)];

    }

    return arrayToJson(arrKeys, arrDados);

}
$(document).ready(function(){  
    
    $(document).on('click', '#cmdIncluirImposto', fcIncluirImposto);
    
    carregarListaComboImposto();
    
});
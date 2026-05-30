var tblQualificacao;
var strComboProdutoServico = "";
function fcFormatarGrid(){
    tblQualificacao = $("#tblQualificacao").DataTable(
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

function carregarListaCombo(){



    var objParametros = {
        pk:""
    };

    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);

    if (arrCarregar.result == 'success'){
        strComboProdutoServico = "<select id='produtos_servicos_pk' name='produtos_servicos_pk'><option></option>";
        for(i = 0; i < arrCarregar.data.length; i++){
            strComboProdutoServico = strComboProdutoServico + "<option value='"+arrCarregar.data[i]['pk']+"'>"+arrCarregar.data[i]['ds_produto_servico']+"</option>";
        }
        strComboProdutoServico += "</select>";
        //Carrega os dados no combo.
        fcFormatarGrid();
        fcAtualizarDadosGrid();
    }
    else{

        alert('Falhar ao carregar o registro');

    }
}


function fcAtualizarDadosGrid(){

    var objParametros = {
        "colaboradores_pk":colaborador_pk,
        "token": token
    };

    var arrCarregar = carregarController("produto_servico", "listarQualificacaoColaboradores", objParametros);

        if (arrCarregar.result == 'success'){
            for(i = 0; i < arrCarregar.data.length; i++){
                //Adiciona a linha.
                fcIncluirQualificacao();

                //Pega as variaveis
                var cboProdutosServicosPk = $("select[id='produtos_servicos_pk']");
                var chkTreinamento = $("input[id='ic_possui_treinamento']");
                var chkCertificado = $("input[id='ic_possui_certificado']");

                cboProdutosServicosPk.get(i).value = arrCarregar.data[i]['t_produtos_servicos_pk'];

                if(arrCarregar.data[i]['t_ic_possui_treinamento'] == 1)
                    chkTreinamento.get(i).checked = true;
                if(arrCarregar.data[i]['t_ic_possui_certificado'] == 1)
                    chkCertificado.get(i).checked = true;
            }
        }
        else{

            alert('Falhar ao carregar o registro');
        }

}

function fcIncluirQualificacao(){

    tblQualificacao.row.add(
            [strComboProdutoServico,
             "<input type='checkbox' id='ic_possui_treinamento' />",
             "<input type='checkbox' id='ic_possui_certificado' />",
             "<a class='function_delete'><span><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR'></i></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcExcluirLinha);

    return false;
}

function fcExcluirLinha(){

    tblQualificacao.row($(this).parents('tr')).remove().draw();

    return false;
}
function fcFormatarDadosQualificacao(){

    var cboProdutosServicosPk = $("select[id='produtos_servicos_pk']");
    var chkTreinamento = $("input[id='ic_possui_treinamento']");
    var chkCertificado = $("input[id='ic_possui_certificado']");

    var arrKeys = [];
    arrKeys[0] = "produtos_servicos_pk";
    arrKeys[1] = "ic_possui_treinamento";
    arrKeys[2] = "ic_possui_certificado";

    var arrDados = [];

    var v_ic_possui_treinamento = 2;
    var v_ic_possui_certificado = 2;

    for(i = 0; i < cboProdutosServicosPk.length; i++){
        if(cboProdutosServicosPk.get(i).value == ""){
            cboProdutosServicosPk.get(i).focus();
            return false;

        }


        v_ic_possui_treinamento = 2;
        v_ic_possui_certificado = 2;

        if(chkTreinamento.get(i).checked)
            v_ic_possui_treinamento = 1;
        if(chkCertificado.get(i).checked)
            v_ic_possui_certificado = 1;

        arrDados[i] = [cboProdutosServicosPk.get(i).value, v_ic_possui_treinamento, v_ic_possui_certificado];

    }

    return arrayToJson(arrKeys, arrDados);

}

$(document).ready(function(){
    $(document).on('click', '#cmdIncluirQualificacao', fcIncluirQualificacao);
    carregarListaCombo();
     //faz a carga inicial do grid.
    
    //Atribui os eventos dos demais controles
    
});



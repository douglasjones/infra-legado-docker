
function fcCarregarTable(){
    try {
        
    var objParametros = {
        "pk": faturamento_pk
    };
    var arrCarregar = carregarController("faturamento", "listarLancamentos", objParametros);

    for(var i=0; i<arrCarregar.data.length; i++){
        $("#tblFaturamentoLancamentos tbody").append("<tr id='tr"+arrCarregar.data[i]['pk']+"'></tr>");
        $("#tr"+arrCarregar.data[i]['pk']).append("<td>"+arrCarregar.data[i]['ds_lead']+"</td>")
                                        .append("<td>"+arrCarregar.data[i]['pk']+"</td>")                                           
                                        .append("<td>"+arrCarregar.data[i]['tipo_contrato']+"</td>")
                                        .append("<td>"+arrCarregar.data[i]['lancamentos_pk']+"</td>")   
                                        .append("<td>"+arrCarregar.data[i]['dt_lancamento']+"</td>")
                                        .append("<td>"+arrCarregar.data[i]['dt_faturamento']+"</td>")
                                        .append("<td>"+arrCarregar.data[i]['dt_vencimento']+"</td>")
                                        .append("<td>"+arrCarregar.data[i]['vl_total_contrato']+"</td>")
                                        .append("<td>"+arrCarregar.data[i]['notas_pk']+"</td>")
                                        .append("<td><a href='https://facilitiesdemo.gpros.com.br/docs/nf.pdf' <i class='bi bi-receipt-cutoff' style='font-size:18px; color:black' title='Visualizar Nota Fiscal'></i></a></td>")
    }
    } catch (error) {
     alert(error)   
    }
}

function fcDownloadDocumento(ds_documento){
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }

    var v_url = "../docs/"+ds_documento;
    NewWindow(v_url, '_blank');
}

function fcVoltar(){
    sendPost("faturamento_res_form.php", {token: token});
}

function AdicionarFiltroSelect(tabela, coluna) {
    try {
        var cols = $("#" + tabela + " thead tr:first-child th").length;
        if ($("#" + tabela + " thead tr").length == 1) {
            var linhaFiltro = "<tr>";
            for (var i = 0; i < cols; i++) {
                linhaFiltro += "<th></th>";
            }
            linhaFiltro += "</tr>";
    
            $("#" + tabela + " thead").append(linhaFiltro);
        }
    
        var colFiltrar = $("#" + tabela + " thead tr:nth-child(1) th:nth-child(" + coluna + ")");
    
        $(colFiltrar).html("<select id='filtroColuna_" + coluna.toString() + "'  class='filtroColuna'> </select>");

        var valores = new Array();
    
        $("#" + tabela + " tbody tr").each(function () {
            var txt = $(this).children("td:nth-child(" + coluna + ")").text();
            if (valores.indexOf(txt) < 0) {
                valores.push(txt);
            }
        });
        $("#filtroColuna_" + coluna.toString()).append("<option> </option>")
        for (elemento in valores) {
            $("#filtroColuna_" + coluna.toString()).append("<option>" + valores[elemento] + "</option>");
        }
    
        $("#filtroColuna_" + coluna.toString()).change(function () {
            var filtro = $(this).val();
            if($("#" + tabela + " tbody tr").is(':visible')){
                $(this).show();
            }
            if(filtro == ""){
                $("#" + tabela + " tbody tr").show();
            }
            if (filtro != "") {
                $("#" + tabela + " tbody tr").each(function () {
                    var txt = $(this).children("td:nth-child(" + coluna + ")").text();
                    if (txt != filtro) {
                        $(this).hide();
                    }
                });
            }
        
        });
    } catch (error) {
        alert(error)
    }
    
};

$(document).ready(function(){
    
    //Atribui os eventos
    $(document).on('click', '#cmdVoltar', fcVoltar);

    fcCarregarTable()

    
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 1)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 2)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 3)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 4)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 5)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 6)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 7)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 8)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 9)
    AdicionarFiltroSelect('tblFaturamentoLancamentos', 10)
});
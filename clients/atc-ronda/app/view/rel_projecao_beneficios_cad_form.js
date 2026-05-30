var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid() {
    var strNenhumRegisto = "";
    var strRetorno = "";


    var objParametros = {
        "pk": colaborador_pk,
        "produtos_servicos_pk": produtos_servicos_pk,
        "turnos_pk": turnos_pk,
        "dt_inicio": dt_inicio,
        "dt_fim": dt_fim,
        "dt_falta_inicio": dt_falta_inicio,
        "dt_falta_fim": dt_falta_fim,
        "leads_pk": leads_pk
    };
    
    var arrCarregar = carregarController("colaborador", "RelatorioColaboradorPlanilha", objParametros);

    if (arrCarregar.result == 'success') {

        if (arrCarregar.data.length > 0) {

            strRetorno = "";
            //strRetorno += "<div class='row'><div class='col-md-12'>";
            //strRetorno += "<table  id='tblResultado'>";
            strRetorno += "<thead>";
            strRetorno += "<tr style=' text-align: center' font-family:'Nunito'>";
            strRetorno += " <th width='5%' class='menu_fixo'>#</th>";
            strRetorno += " <th width='20%' class='menu_fixo'>Posto de Trabalho</th>";
            strRetorno += " <th width='20%' class='menu_fixo'>Colaborador</th>";
            strRetorno += " <th width='10%'>Turno</th>";
            strRetorno += " <th width='20%'>Qualificação</th>";
            strRetorno += " <th width='25%'>Dias Trab. na Escala</th>";
            strRetorno += " <th width='20%'>Adicional Noturno</th>";
            strRetorno += " <th width='40%'>Dias a Abonar Atestado</th>";
           // strRetorno += "<th width='20%'>Total para Efeito<br>Pagamento</th>";
            strRetorno += " <th width='20%'>Faltas</th>";
            //strRetorno += "<th width='20%'>Cod 38 Atraso</th>";
            //strRetorno += "<th width='20%'>Dias para<b> Cálculo</th>";
           // strRetorno += "<th width='20%'>Faltas Mês<br> Anterior</th>";
            strRetorno += " <th width='20%'>V.T.</th>";
            strRetorno += " <th width='20%'>V.R.</th>";
            strRetorno += " <th width='20%'>V.A.</th>";
            strRetorno += " <th width='20%'>C.B.</th>";
            //strRetorno += " <th width='20%'>HR. Extra 50%</th>";
            strRetorno += "</tr>";
            strRetorno += "</thead>";
            strRetorno += "<tbody>";
            var count = 1;
            for (i = 0; i < arrCarregar.data.length; i++) {
                if (arrCarregar.data[i]['ds_colaborador'] == null) {
                    var ds_colaboradorGrid = "";
                } else {
                    var ds_colaboradorGrid = arrCarregar.data[i]['ds_colaborador'];
                }

                if (arrCarregar.data[i]['ds_turno'] == null) {
                    var dt_turno = "";
                } else {
                    var dt_turno = arrCarregar.data[i]['ds_turno'];
                }

                if (arrCarregar.data[i]['ds_produto_servico'] == null) {
                    var ds_qualificacao = "";
                } else {
                    var ds_qualificacao = arrCarregar.data[i]['ds_produto_servico'];
                }

                if (arrCarregar.data[i]['ds_escolaridade'] == null) {
                    var ds_escolaridade = "";
                } else {
                    var ds_escolaridade = arrCarregar.data[i]['ds_escolaridade'];
                }

                if (arrCarregar.data[i]['ds_rg'] == null) {
                    var ds_rg = "";
                } else {
                    var ds_rg = arrCarregar.data[i]['ds_rg'];
                }

                if (arrCarregar.data[i]['ds_cpf'] == null) {
                    var ds_cpf = "";
                } else {
                    var ds_cpf = arrCarregar.data[i]['ds_cpf'];
                }

                if (arrCarregar.data[i]['ds_razao_social'] == null) {
                    var ds_razao_social = "";
                } else {
                    var ds_razao_social = arrCarregar.data[i]['ds_razao_social'];
                }

                if (arrCarregar.data[i]['dt_admissao'] == null) {
                    var dt_admissao = "";
                } else {
                    var dt_admissao = arrCarregar.data[i]['dt_admissao'];
                }

                if (arrCarregar.data[i]['ds_regime_contratacao'] == null) {
                    var ds_regime_contratacao = "";
                } else {
                    var ds_regime_contratacao = arrCarregar.data[i]['ds_regime_contratacao'];
                }

                if (arrCarregar.data[i]['vl_vt'] == "" || arrCarregar.data[i]['vl_vt'] == null ) {
                    var vl_vt = "0,00";
                } else {
                    var vl_vt = arrCarregar.data[i]['vl_vt'];
                }
                

                if (arrCarregar.data[i]['vl_va'] == "" || arrCarregar.data[i]['vl_va'] == null) {
                    var vl_va = "0,00";
                } else {
                    var vl_va = arrCarregar.data[i]['vl_va'];
                }


                if (arrCarregar.data[i]['vl_vr'] == null || arrCarregar.data[i]['vl_vr'] == "" ) {
                    var vl_vr = "0,00";
                } else {
                    var vl_vr = arrCarregar.data[i]['vl_vr'];
                }

                if (arrCarregar.data[i]['vl_cb'] == null || arrCarregar.data[i]['vl_cb'] == "" ) {
                    var vl_cb = "0,00";
                } else {
                    var vl_cb = arrCarregar.data[i]['vl_cb'];
                }

                if (arrCarregar.data[i]['ds_endereco'] == null) {
                    var ds_endereco = "";
                } else {
                    var ds_endereco = (arrCarregar.data[i]['ds_endereco']);
                }

                if (arrCarregar.data[i]['dias_escala'] == null) {
                    var ds_dias_escala = "";
                } else {
                    var ds_dias_escala = (arrCarregar.data[i]['dias_escala']);
                }

                if (arrCarregar.data[i]['ds_lead'] == null) {
                    var ds_lead = "";
                } else {
                    var ds_lead = (arrCarregar.data[i]['ds_lead']);
                }

                strRetorno += "<tr style=' text-align: center'; >";
                strRetorno += "<td width='5%'>" + count + "</td>";
                strRetorno += "<td width='20%'>" + ds_lead + "</td>";
                strRetorno += "<td width='20%'>" + ds_colaboradorGrid + "</td>";
                strRetorno += "<td width='10%'>" + dt_turno + "</td>";
                strRetorno += "<td width='20%'>" + ds_qualificacao + "</td>";
                strRetorno += "<td width='25%'>" + ds_dias_escala + "</td>";
                strRetorno += "<td width='20%'>" + arrCarregar.data[i]['n_adicional_noturno'] + "</td>";
                strRetorno += "<td width='40%'>" + arrCarregar.data[i]['n_dias_abonar'] + "</td>";
               // strRetorno += "<th width='20%'>" + ds_cpf + "</th>";
                strRetorno += "<td width='20%'>" + arrCarregar.data[i]['n_faltas'] + "</td>";
                //strRetorno += "<th width='20%'>" + ds_escolaridade + "</th>";
                //strRetorno += "<th width='20%'>" + ds_regime_contratacao + "</th>";
                //strRetorno += "<th width='20%'>" + arrCarregar.data[i]['n_faltas_mes_anterior'] + "</th>";
                strRetorno += "<td width='20%'>" + vl_vt + "</td>";
                strRetorno += "<td width='20%'>" + vl_vr + "</td>";
                strRetorno += "<td width='20%'>" + vl_va + "</td>";
                strRetorno += "<td width='20%'>" + vl_cb + "</td>";
               // strRetorno += "<td width='20%'>" + ds_endereco + "</td>";
                strRetorno += "</tr>";
                count++;
            }
            strRetorno += "</tbody>";
            //strRetorno += "</table>";
            strRetorno += "</div>";
            strRetorno += "</div>";
            strRetorno += "<br><br>";
            if (strRetorno != "") {
                $("#grid").html(strRetorno);
            }
            else {

                strNenhumRegisto += "<div class='row'>";
                strNenhumRegisto += "<div class='col-md-12 text-center'>";
                strNenhumRegisto += "   <h3><b>Nenhum Registro Encontrado</b></h3>";
                strNenhumRegisto += " </div>";
                strNenhumRegisto += "</div>";
                $("#grid").html(strNenhumRegisto);
            }

        }
        else {
            strNenhumRegisto += "<div class='row'>";
            strNenhumRegisto += "<div class='col-md-12 text-center'>";
            strNenhumRegisto += "   <h3><b>Nenhum Registro Encontrado</b></h3>";
            strNenhumRegisto += " </div>";
            strNenhumRegisto += "</div>";
            $("#grid").html(strNenhumRegisto);
        }

    }
    else {
        alert('Falhar ao carregar o registro');
    }
}



function fcCancelar() {
    sendPost("rel_projecao_beneficios_res_form.php", { token: token });
}

function fcExport() {

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#head").html() +'<tr></tr>'+  $("#grid").html() + '</table></body></html>';

    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
    

    var hyperlink = document.createElement("a");
    hyperlink.href = link;
    hyperlink.download = "export.xls";
    hyperlink.style.display = 'none';

    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}


$(document).ready(function () {

    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
   
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
    var seg = today.getSeconds();
    //data
    if (dd < 10) {
        dd = '0' + dd
    }

    if (mm < 10) {
        mm = '0' + mm
    }
    //hora 
    if (hh < 10) {
        hh = '0' + hh
    }

    if (min < 10) {
        min = '0' + min
    }
    if (seg < 10) {
        seg = '0' + seg
    }

    today = dd + '/' + mm + '/' + yyyy + ' ' + hh + ':' + min + ':' + seg;


    $("#dt_emissao").text(today);
    $("#ds_colaborador").text(ds_colaborador);
    $("#ds_periodo").text(dt_inicio + " - " + dt_fim);
    $("#ds_lead").text(ds_lead);
    $("#ds_qualificacao").text(ds_produto_servico);
    $("#ds_turno").text(ds_turno);

    fcCarregarGrid();

});



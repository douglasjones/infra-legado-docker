function fcCarregar(){
    var v_leads_pk = leads_pk;

    if (pk > 0) {
        var objParametros = {
            "leads_pk": v_leads_pk,
            "ponto_folha_pk": pk
        };
        var arrCarregar = carregarController("ponto_folha", "listarDadosPrintAll", objParametros);
    
        
        if (arrCarregar.result == 'success') {

            var v_ht_total = "";
            var v_he_total = "";
            var v_hf_total = "";
            var v_he1_total = "";
            var v_he2_total = "";
            var v_an_total = "";
            var v_html = "";

            for (a = 0; a < arrCarregar.data.length; a++) {
                if (arrCarregar.data[a]['total_ht'] != null) {
                    v_ht_total = arrCarregar.data[a]['total_ht'];
                }
                if (arrCarregar.data[a]['total_he'] != null) {
                    v_he_total = arrCarregar.data[a]['total_he'];
                }
                if (arrCarregar.data[a]['total_hf'] != null) {
                    v_hf_total = arrCarregar.data[a]['total_hf'];
                }
                if (arrCarregar.data[a]['total_he50'] != null) {
                    v_he1_total = arrCarregar.data[a]['total_he50'];
                }
                if (arrCarregar.data[a]['total_he100'] != null) {
                    v_he2_total = arrCarregar.data[a]['total_he100'];
                }
                if (arrCarregar.data[a]['v_total_hadn'] != null) {
                    v_an_total = arrCarregar.data[a]['v_total_hadn'];
                }
    
               // v_html += "<style type='text/css'>  @media print {  #container"+a+"{page-break-inside: avoid; margin:0; page-break-before: always; border-collapse: collapse;}  } </style>";
                    v_html += "<table class='row' id='container"+a+"' >";  
                    v_html += "     <tr><td>&nbsp;</td></tr>";
                    v_html += "    <table id='periodo"+a+"' class='col-md-12' align='Left' style='font-size:10'>";
                    v_html += "        <td>Folha de ponto</td>";
                    v_html += "         <tr><td>&nbsp;</td></tr>";
                    v_html += "        <td>Período " + arrCarregar.data[a]['ds_periodo']+"</td>";
                    v_html += "     </table>";
                    v_html += "     <tr><td>&nbsp;</td></tr>";
                    v_html += "     <table id='folha_ponto"+a+"' class='col-md-12' align='Left' >";
                    v_html += "     <tr style=' width: 100%; heigth: 50%'>";
                    v_html += "         <tr style='height:5px;background: #1A0F6B'>";
                    v_html += "             <th colspan='2' >";
                    v_html += "                 <label style='color:white;font-size:10 '>DADOS DO COLABORADOR</label>";
                    v_html += "             </th>";
                    v_html += "             <th colspan='2'>";
                    v_html += "                 <label style=' color: white;font-size:10  '>DADOS DO EMPREGADOR</label>";
                    v_html += "             </th>";
                    v_html += "         </tr>";
                    v_html += "         <tr style='font-size:10'>";
                    v_html += "             <td width='20%'>";
                    v_html += "                 <b>Nome:</b>";
                    v_html += "             </td>";
                    v_html += "             <td width: 25%  align='Left'>";
                    v_html +=                   arrCarregar.data[a]['ds_colaborador'];
                    v_html += "             </td>";
                    v_html += "             <td width: 25%>";
                    v_html += "                 <b>Razão Social:</b>";
                    v_html += "             </td>";
                    v_html += "             <td width: 25%  align='Left'>";
                    v_html +=                   arrCarregar.data[a]['ds_empresa'];
                    v_html += "             </td>";
                    v_html += "         </tr>";
                    v_html += "         <tr style='font-size:10'>";
                    v_html += "             <td>";
                    v_html += "                 <b>CPF:</b>";
                    v_html += "             </td>";
                    v_html += "             <td  align='Left'>";
                    v_html +=                   arrCarregar.data[a]['ds_cpf'];
                    v_html += "             </td>";
                    v_html += "             <td>";
                    v_html += "                 <b>Endereço:</b>";
                    v_html += "             </td>";
                    v_html += "             <td  align='Left'>";
                    v_html +=                   arrCarregar.data[a]['ds_endereco'];
                    v_html += "             </td>";
                    v_html += "         </tr>";
                    v_html += "         <tr style='font-size:10'>";
                    v_html += "             <td>";
                    v_html += "                 <b>Cargo:</b>";
                    v_html += "             </td>";
                    v_html += "             <td  align='Left'>";
                    v_html +=                   arrCarregar.data[a]['ds_cargo'];
                    v_html += "             </td>";
                    v_html += "             <td>";
                    v_html += "                 <b>CNPJ:</b>";
                    v_html += "             </td>";
                    v_html += "             <td  align='Left'>";
                    v_html +=                    arrCarregar.data[a]['ds_cnpj'];
                    v_html += "             </td>";
                    v_html += "         </tr>";
                    v_html += "         <tr style='font-size:10'>";
                    v_html += "             <td>";
                    v_html += "                  <b>Posto de Trabalho:</b>";
                    v_html += "             </td>";
                    v_html += "             <td  align='Left'>";
                    v_html +=                   arrCarregar.data[a]['ds_posto_trabalho']
                    v_html += "             </td>";
                    v_html += "             <td>";
                    v_html += "                 <b>DT Admissão:</b>";
                    v_html += "             </td>";
                    v_html += "             <td align='Left'>";
                    v_html +=                    arrCarregar.data[a]['dt_admissao']
                    v_html += "             </td>";
                    v_html += "         </tr>";
                    v_html += "         <tr style='font-size:10'>";
                    v_html += "             <td>";
                    v_html += "                 <b>Turno:</b>";
                    v_html += "             </td>";
                    v_html += "             <td colspan='3' width: 100%  align='Left'>";
                    v_html += "                  Turno: " + arrCarregar.data[a]['ds_turno'] + "  -  Escala: " + arrCarregar.data[a]['ds_escala'] + "  -  Expediente: " + arrCarregar.data[a]['ds_hr_expediente'];
                    v_html += "             </td>";
                    v_html += "        </tr>";
                    v_html += "        <tr>";
                    v_html += "            &nbsp;";
                    v_html += "        </tr>";
                    v_html += "        <tr style='height:5px;background: #1A0F6B'>";
                    v_html += "            <th colspan='4'>";
                    v_html += "                 &nbsp;<label style=' color: white;font-size:10'>REGISTROS</label>";
                    v_html += "            </th>";
                    v_html += "        </tr>";
                    v_html += "     </tr>";
                v_html += "</table>";
                v_html += "<table class='row'>";
                v_html += " <tr class='col-md-12' align='Left'>";
                v_html += "   <table  style='width:100%;border-color: white' id='tblResultado1"+a+"' border=1>";
                v_html += "     <thead>"
                v_html += "         <tr style='font-size:10;border-color: black'>";
                v_html += "             <th width='5' style=' text-align: center'>";
                v_html += "                 DATA";
                v_html += "             </th>";
                v_html += "             <th width='7'  style='text-align: center'>";
                v_html += "                 Entra";
                v_html += "             </th>";
                v_html += "             <th width='7' style='text-align: center'>";
                v_html += "                 H.SI";
                v_html += "             </th>";
                v_html += "             <th width='7' style='text-align: center'>";
                v_html += "                 H.RI";
                v_html += "             </th>";
                v_html += "             <th width='7' style='text-align: center'>";
                v_html += "                 H.EE";
                v_html += "             </th>";
                v_html += "             <th width='7' align='center' style=' text-align: center'>";
                v_html += "                 H.T";
                v_html += "             </th>";
                v_html += "             <th width='7' align='center' style=' text-align: center'>";
                v_html += "                 H.E";
                v_html += "             </th>";
                v_html += "             <th width='7' align='center' style=' text-align: center'>";
                v_html += "                 H.F";
                v_html += "             </th>";
                v_html += "             <th width='6' align='center' style=' text-align: center'>";
                v_html += "                 SITUAÇÃO";
                v_html += "             </th>";
                v_html += "             <th width='7' align='center' style=' text-align: center'>";
                v_html += "                 H.E1";
                v_html += "             </th>  ";
                v_html += "             <th width='7' align='center' style=' text-align: center'>";
                v_html += "                 H.E2"
                v_html += "             </th> ";
                v_html += "             <th width='7' align='center' style=' text-align: center'>";
                v_html += "                 A.N";
                v_html += "             </th>";
                v_html += "             <th width='8' align='center' style=' text-align: center'>";
                v_html += "                 OBS";
                v_html += "             </th>";
                v_html += "          </tr>";
                v_html += "     </thead>";
                v_html += "     <tbody>";
                for (i = 0; i < arrCarregar.data[a].registrosfolha.length; i++) {

                    var v_pk = "";
                    var v_dt = "";
                    var hr_ini_expediente = "";
                    var hr_ini_intervalo = "";
                    var hr_fim_intervalo = "";
                    var hr_fim_expediente = "";
                    var hr_trabalhadas = "";
                    var hr_excedentes = "";
                    var hr_faltantes = "";
                    var hr_extra50 = "";
                    var hr_extra100 = "";
                    var hr_adicional_noturno = "";
                    var ds_situacao = "";
                    var v_obs = "";

                    v_pk = arrCarregar.data[a].registrosfolha[i].ponto_folha_registro_pk;
                    v_dt = arrCarregar.data[a].registrosfolha[i].dt_registro_ponto;

                    if (arrCarregar.data[a].registrosfolha[i].hr_ini_expediente != null) {
                        hr_ini_expediente = arrCarregar.data[a].registrosfolha[i].hr_ini_expediente;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_ini_intervalo != null) {
                        hr_ini_intervalo = arrCarregar.data[a].registrosfolha[i].hr_ini_intervalo;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_fim_intervalo != null) {
                        hr_fim_intervalo = arrCarregar.data[a].registrosfolha[i].hr_fim_intervalo;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_fim_expediente != null) {
                        hr_fim_expediente = arrCarregar.data[a].registrosfolha[i].hr_fim_expediente;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_trabalhadas != null) {
                        hr_trabalhadas = arrCarregar.data[a].registrosfolha[i].hr_trabalhadas;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_excedentes != null) {
                        hr_excedentes = arrCarregar.data[a].registrosfolha[i].hr_excedentes;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_faltantes != null) {
                        hr_faltantes = arrCarregar.data[a].registrosfolha[i].hr_faltantes;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_extra50 != null) {
                        hr_extra50 = arrCarregar.data[a].registrosfolha[i].hr_extra50;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_extra100 != null) {
                        hr_extra100 = arrCarregar.data[a].registrosfolha[i].hr_extra100;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].hr_adicional_noturno != null) {
                        hr_adicional_noturno = arrCarregar.data[a].registrosfolha[i].hr_adicional_noturno;
                    }

                    if (arrCarregar.data[a].registrosfolha[i].tipo_ponto_pk == 1) {
                        ds_situacao = "Expediente";
                    }else if (arrCarregar.data[a].registrosfolha[i].tipo_ponto_pk == 5) {
                        ds_situacao = "Folga";
                    }else if (arrCarregar.data[a].registrosfolha[i].tipo_ponto_pk == 10) {
                        ds_situacao = "Falta";
                    }else if (arrCarregar.data[a].registrosfolha[i].tipo_ponto_pk == 10) {
                        ds_situacao = "Atestado";
                    }

                    if (arrCarregar.data[a].registrosfolha[i].obs != null) {
                        v_obs = arrCarregar.data[a].registrosfolha[i].obs;
                    }

                    v_html += "<tr style='font-size:10;border-color: black'>";
                        v_html += "<td width='7px' style=' text-align: center'>";
                            v_html += v_dt;
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += hr_ini_expediente;
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += hr_ini_intervalo;
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += hr_fim_intervalo;
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += hr_fim_expediente;
                        v_html += "</td>";
                        v_html += "<td style=' text-align: center'>";
                            v_html += hr_trabalhadas;
                        v_html += "</td>";
                        v_html += " <td style=' text-align: center'>";
                            v_html += hr_excedentes;
                        v_html += "</td>";
                        v_html += "<td style=' text-align: center'>";
                            v_html += hr_faltantes;
                        v_html += "</td>";
                        v_html += "<td style=' text-align: center'>";
                            v_html += ds_situacao;
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += hr_extra50;
                        v_html += "</td>";
                        v_html += "<th style=' text-align: center'>";
                            v_html += hr_extra100;
                        v_html += "</td>";
                        v_html += "<td style=' text-align: center'>";
                            v_html += hr_adicional_noturno;
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += v_obs;
                        v_html += "</td>";
                    v_html += "</tr>";
                }
                v_html += "</tbody>";
                v_html += "<tfoot >";
                v_html += "<tr style='height:5px;background: #1A0F6B'>";
                        v_html += "<td  colspan='13'>";
                            v_html += "<label style=' color: white;font-size:10'><b>TOTAL DE HORAS</b></label>";
                        v_html += "</td>";
                v_html += "</tr>";
                v_html += "            <tr style='font-size:10;border-color: black'>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html += "                     &nbsp;";
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center' colspan=4>";
                v_html += "                    &nbsp;";
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center'>";
                            v_html += "                 <b>H.T</b>";
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += "<b>H.E</b>";
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += "<b>H.F</b>";
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += "&nbsp;";
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += "<b>H.E1</b>";
                        v_html += "</td>";
                        v_html += "<td style=' text-align: center'>";
                            v_html += "<b>H.E2</b>";
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += "<b>A.N</b>";
                        v_html += "</td>";
                        v_html += "<td  style=' text-align: center'>";
                            v_html += "&nbsp;";
                        v_html += "</td>";
                v_html += "            </tr>";
                v_html += "            <tr style='font-size:10;border-color: black'>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html += "                     &nbsp;";
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center' colspan=4>";
                v_html += "                     &nbsp;";
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html +=                        v_ht_total;
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html +=                       v_he_total;
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html +=                       v_hf_total;
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html += "                     &nbsp;";
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html +=                        v_he1_total;
                v_html += "                 </td>";
                v_html += "                 <td style=' text-align: center'>";
                v_html +=                       v_he2_total;
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html +=                       v_an_total;
                v_html += "                 </td>";
                v_html += "                 <td  style=' text-align: center'>";
                v_html += "                     &nbsp;";
                v_html += "                 </td>";
                v_html += "            </tr>";
                v_html += "            <tr style=' background: #f5f5f5'>";
                v_html += "                         <td colspan='14'>";
                v_html += "                             <table style=' width: 100%' >";
                v_html += "                                 <tr>";
                v_html += "                                     <td width='50%' style='font-size:10'>";
                v_html += "                                         H.T: Horas Trabalhasdas";
                v_html += "                                     </td>";
                v_html += "                                     <td width='50%' style='font-size:10'>";
                v_html += "                                         H.E: Horas Excedentes";
                v_html += "                                     </td>";
                v_html += "                                 </tr>";
                v_html += "                                 <tr>";
                v_html += "                                     <td width='50%' style='font-size:10'>";
                v_html += "                                         H.F: Horas Faltantes";
                v_html += "                                     </td>";
                v_html += "                                     <td width='50%' style='font-size:10'>";
                v_html += "                                         H.E1: Horas Extra Fase 1 (50%)";
                v_html += "                                     </td>";
                v_html += "                                 </tr>";
                v_html += "                                 <tr>";
                v_html += "                                     <td width='50%' style='font-size:10'>";
                v_html += "                                         H.E2: Horas Extra Fase 2 (100%)";
                v_html += "                                     </td>";
                v_html += "                                     <td width='50%' style='font-size:10'>";
                v_html += "                                         A.N:  Adicional Noturno";
                v_html += "                                     </td>";
                v_html += "                                 </tr>";
                v_html += "                             </table>";
                v_html += "                         </td>";
                v_html += "                    </tr>";
                v_html += " </tfoot>";
                v_html += "</table>";
                v_html += "</tr>";
                v_html += "</table>";
                v_html += "<td  style=' text-align: center'>";
                v_html += "&nbsp;";
                v_html += "</td>";
                v_html += "</table>";
                
            }
            v_html += "<input type='hidden' name='qtd_conteiner_folhas' id='qtd_conteiner_folhas' value='"+a+"'> ";
            $("#areaGerar").html(v_html);
        } else {
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcExport(){
        var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
        htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
        htmlPlanilha += '<![endif]--></head><body>';
        for(var i=0; i <$("#qtd_conteiner_folhas").val(); i++){
            htmlPlanilha += '<table>';
            htmlPlanilha += $("#container"+i).html();
            htmlPlanilha += $("#periodo"+i).html();
            htmlPlanilha += $("#folha_ponto"+i).html();
            htmlPlanilha += $("#tblResultado1"+i).html();
            htmlPlanilha += '</table>';
        }
        htmlPlanilha += '</body></html>';

    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
    
    var hyperlink = document.createElement("a");
        hyperlink.download = "export.xls";
        hyperlink.href = link; 
        hyperlink.style.display = 'none';

    document.body.appendChild(hyperlink);
        hyperlink.click();
    document.body.removeChild(hyperlink);
}

function fcCancelar(){
    sendPost("ponto_folha_registros_res_form.php", {token: token});
}



$(document).ready(function(){    
    
    fcCarregar()
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdGerar', fcExport);

});

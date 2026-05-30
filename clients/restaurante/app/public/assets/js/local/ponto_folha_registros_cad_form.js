function fcEnviar(){

    var v_li = $("#totalLinhas").val()
    var arrEnviar = []; 

    for (i = 0; i < v_li; i++) {
        var v_ponto_folha_pk = $("#pk").val();
        var v_dt_hora_ponto = $("#dt_hora_ponto" + i).val();
        var v_colaborador_pk = $("#colaborador_pk").val();
        var v_leads_pk = $("#leads_pk").val();
        var v_ponto_folha_registros_pk = $("#ponto_folha_registros_pk" + i).val();
        var v_hr_ini_expediente = ($("#hr_ini_expediente" + i).val() != "") ? $("#hr_ini_expediente" + i).val() : null;
        var v_hr_ini_intervalo = ($("#hr_ini_intervalo" + i).val() != "") ? $("#hr_ini_intervalo" + i).val() : null;
        var v_hr_fim_intervalo = ($("#hr_fim_intervalo" + i).val() != "") ? $("#hr_fim_intervalo" + i).val() : null;
        var v_hr_fim_expediente = ($("#hr_fim_expediente" + i).val() != "") ? $("#hr_fim_expediente" + i).val() : null;
        var v_hr_trabalhadas = ($("#hr_trabalhadas" + i).val() != "") ? $("#hr_trabalhadas" + i).val() : null;
        var v_hr_excedentes = ($("#hr_excedentes" + i).val() != "") ? $("#hr_excedentes" + i).val() : null;
        var v_hr_faltantes = ($("#hr_faltantes" + i).val() != "") ? $("#hr_faltantes" + i).val() : null;
        var v_hr_extra50 = ($("#hr_extra50" + i).val() != "") ? $("#hr_extra50" + i).val() : null;
        var v_hr_extra100 = ($("#hr_extra100" + i).val() != "") ? $("#hr_extra100" + i).val() : null;
        var v_hr_adicional_noturno = ($("#hr_adicional_noturno" + i).val() != "") ? $("#hr_adicional_noturno" + i).val() : null;
        var v_obs = ($("#obs" + i).val() != "") ? $("#obs" + i).val() : null;
        var v_ic_status = ($("#ic_status" + i).is(':checked')) ? $("#ic_status" + i).val() : 0;
        var v_tipo_ponto_pk = "";
        if ($("#ds_situacao" + i).html() == 'Folga') {
            v_tipo_ponto_pk = 5;
        } else if ($("#ds_situacao" + i).html() == 'Falta') {
            v_tipo_ponto_pk = 10;
        } else if ($("#ds_situacao" + i).html() == 'Abonada') {
            v_tipo_ponto_pk = 11;
        } else if ($("#ds_situacao" + i).html() == 'Dia Trabalhado') {
            v_tipo_ponto_pk = 1;
        } else if ($("#ds_situacao" + i).html() == 'Férias') {
            v_tipo_ponto_pk = 12;
        } else if ($("#ds_situacao" + i).html() == 'Afastamento') {
            v_tipo_ponto_pk = 15;
        } else if ($("#ds_situacao" + i).html() == 'Atestado') {
            v_tipo_ponto_pk = 16;
        } else if ($("#ds_situacao" + i).html() == 'Advertencia') {
            v_tipo_ponto_pk = 17;
        } else if ($("#ds_situacao" + i).html() == 'Declaração da defesa civil') {
            v_tipo_ponto_pk = 18;
        } else if ($("#ds_situacao" + i).html() == 'Demissão') {
            v_tipo_ponto_pk = 19;
        } else if ($("#ds_situacao" + i).html() == 'Folga compensatória') {
            v_tipo_ponto_pk = 20;
        } else if ($("#ds_situacao" + i).html() == 'Folga de feriado') {
            v_tipo_ponto_pk = 21;
        } else if ($("#ds_situacao" + i).html() == 'Justa causa') {
            v_tipo_ponto_pk = 22;
        } else if ($("#ds_situacao" + i).html() == 'Recisão indireta') {
            v_tipo_ponto_pk = 23;
        } else if ($("#ds_situacao" + i).html() == 'Suspensão') {
            v_tipo_ponto_pk = 24;
        } else if ($("#ds_situacao" + i).html() == 'Troca Folga') {
            v_tipo_ponto_pk = 25;
        }
        else if ($("#ds_situacao" + i).html() == 'Folga Semanal') {
            v_tipo_ponto_pk = 26;
        }
        else if ($("#ds_situacao" + i).html() == 'Folga Domingo') {
            v_tipo_ponto_pk = 27;
        }
        else if ($("#ds_situacao" + i).html() == 'Feriado') {
            v_tipo_ponto_pk = 28;
        }
        else if ($("#ds_situacao" + i).html() == 'Atraso') {
            v_tipo_ponto_pk = 29;
        }
        console.log(v_tipo_ponto_pk)

        var objParamentros = {
            "pk": v_ponto_folha_registros_pk,
            "colaborador_pk": v_colaborador_pk,
            "leads_pk": v_leads_pk,
            "dt_hora_ponto": v_dt_hora_ponto,
            "ponto_folha_pk": v_ponto_folha_pk,
            "hr_ini_expediente": v_hr_ini_expediente,
            "hr_ini_intervalo": v_hr_ini_intervalo,
            "hr_fim_intervalo": v_hr_fim_intervalo,
            "hr_fim_expediente": v_hr_fim_expediente,
            "hr_trabalhadas": v_hr_trabalhadas,
            "hr_excedentes": v_hr_excedentes,
            "hr_faltantes": v_hr_faltantes,
            "tipo_ponto_pk": v_tipo_ponto_pk,
            "ic_status": v_ic_status,
            "hr_extra50": v_hr_extra50,
            "hr_extra100": v_hr_extra100,
            "hr_adicional_noturno": v_hr_adicional_noturno,
            "obs": v_obs
        };

        arrEnviar.push(objParamentros);
    }

    var JsonEnviar = JSON.stringify(arrEnviar);
    formdata.append('arrDadosRegistros', JsonEnviar);

    $.ajax({
        type: 'POST',
        url: '/api/ponto_folha/salvarRegistros',
        data: formdata,
        processData: false,
        contentType: false,
        complete: function (response) {
            try {
                var log = JSON.parse(response.responseText);
                if(log.status==true){
                    salvarFolhaFinalizada();
                    utilsJS.toastNotify(true,'Registros salvos com sucesso!')
                    var objParametros = {};
                    sendPost('ponto_folha','receptivoPontoFolha' ,objParametros);
                }
            } catch (e) {
                sweetMensagem(false, "Ocorreu um erro na requisição <br /> Contate o suporte");
            }
        }
    }); 
}

function salvarFolhaFinalizada(){

    var ic_folha_finalizada = "";
    if ($("#ic_folha_finalizada").is(':checked') == true) {
        ic_folha_finalizada = 1;
        var objParametros = {
            "ic_status": ic_folha_finalizada,
            "pk": $("#pk").val(),
            "colaborador_pk": $("#colaborador_pk").val()
            
        };
        carregarController("ponto_folha", "salvarFolhaFinalizada", objParametros);
    }
}

function fcCarregar(){
    
    let pk = $('#pk').val();
    let colaborador_pk = $('#colaborador_pk').val();
    let leads_pk = $('#leads_pk').val();

    if (pk > 0) {
        
        var objParametros = {
            "pk": pk,
            "colaborador_pk": colaborador_pk,
            "leads_pk": leads_pk
        };
        var arrCarregar = carregarController("ponto_folha", "listarRegistros", objParametros);

        if (arrCarregar.status == true) {
            
            $("#ds_periodo").html(arrCarregar.data[0]['ds_periodo']);
            $("#ds_empresa").html(arrCarregar.data[0]['ds_empresa']);
            $("#ds_cnpj").html(arrCarregar.data[0]['ds_cnpj'])
            $("#ds_endereco").html(arrCarregar.data[0]['ds_endereco'])
            $("#ds_colaborador").html(arrCarregar.data[0]['ds_colaborador']);
            $("#ds_cpf").html(arrCarregar.data[0]['ds_cpf']);
            $("#ds_cargo").html(arrCarregar.data[0]['ds_cargo']);
            $("#ds_posto_trabalho").html(arrCarregar.data[0]['ds_posto_trabalho']);
            $("#ds_dt_admissao").html(arrCarregar.data[0]['dt_admissao']);
            $("#ds_dados_turno").html("Turno: " + arrCarregar.data[0]['ds_turno'] + "  -  Escala: " + arrCarregar.data[0]['ds_escala'] + "  -  Expediente: " + arrCarregar.data[0]['ds_hr_expediente']);
            $("#colaborador_pk").val(colaborador_pk);

            var v_html = "";
            var t_hr_ini_exp = "";
            var v_contador = "";
            var v_ht_total = "";
            var v_he_total = "";
            var v_hf_total = "";
            var v_he1_total = "";
            var v_he2_total = "";
            var v_an_total = "";
            var v_expediente_diario = "";
            var v_ds_turno = "";

            if (arrCarregar.data[0]['total_ht'] != null) {
                v_ht_total = arrCarregar.data[0]['total_ht'];
            }
            if (arrCarregar.data[0]['total_he'] != null) {
                v_he_total = arrCarregar.data[0]['total_he'];
            }
            if (arrCarregar.data[0]['total_hf'] != null) {
                v_hf_total = arrCarregar.data[0]['total_hf'];
            }
            if (arrCarregar.data[0]['total_he50'] != null) {
                v_he1_total = arrCarregar.data[0]['total_he50'];
            }
            if (arrCarregar.data[0]['total_he100'] != null) {
                v_he2_total = arrCarregar.data[0]['total_he100'];
            }
            if (arrCarregar.data[0]['total_hadn'] != null) {
                v_an_total = arrCarregar.data[0]['total_hadn'];
            }
            if (arrCarregar.data[0]['expediente_diario'] != null) {
                v_expediente_diario = arrCarregar.data[0]['expediente_diario'];
                console.log(v_expediente_diario);
            }
            if (arrCarregar.data[0]['ds_turno'] != null) {
                v_ds_turno = arrCarregar.data[0]['ds_turno'];
            }
            if (arrCarregar.data[0]['ic_folha_finalizada'] == "1") {
                $("#ic_folha_finalizada").prop('checked', true);
            }
            
            $("#totalLinhas").val(arrCarregar.data[0].registrosfolha.length);
            for (i = 0; i < arrCarregar.data[0].registrosfolha.length; i++) {
                
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
                var v_ic_status = "";
                var v_obs = "";

                v_pk = arrCarregar.data[0].registrosfolha[i].ponto_folha_registro_pk;
                v_dt = arrCarregar.data[0].registrosfolha[i].dt_registro_ponto;

                hr_ini_expediente = arrCarregar.data[0].registrosfolha[i].hr_ini_expediente;
                hr_ini_expediente = hr_ini_expediente == null ? '' : hr_ini_expediente;

                hr_ini_intervalo = arrCarregar.data[0].registrosfolha[i].hr_ini_intervalo;
                hr_ini_intervalo = hr_ini_intervalo == null ? '' : hr_ini_intervalo;

                hr_fim_intervalo = arrCarregar.data[0].registrosfolha[i].hr_fim_intervalo;
                hr_fim_intervalo = hr_fim_intervalo == null ? '' : hr_fim_intervalo;

                hr_fim_expediente = arrCarregar.data[0].registrosfolha[i].hr_fim_expediente;
                hr_fim_expediente = hr_fim_expediente == null ? '' : hr_fim_expediente;                

                hr_trabalhadas = arrCarregar.data[0].registrosfolha[i].hr_trabalhadas;
                hr_trabalhadas = hr_trabalhadas == null ? '' : hr_trabalhadas;

                hr_excedentes = arrCarregar.data[0].registrosfolha[i].hr_excedentes;
                hr_excedentes = hr_excedentes == null ? '' : hr_excedentes;

                hr_faltantes = arrCarregar.data[0].registrosfolha[i].hr_faltantes;
                hr_faltantes = hr_faltantes == null ? '' : hr_faltantes;

                hr_extra50 = arrCarregar.data[0].registrosfolha[i].hr_extra50;
                hr_extra50 = hr_extra50 == null ? '' : hr_extra50;

                hr_extra100 = arrCarregar.data[0].registrosfolha[i].hr_extra100;
                hr_extra100 = hr_extra100 == null ? '' : hr_extra100;

                hr_adicional_noturno = arrCarregar.data[0].registrosfolha[i].hr_adicional_noturno;
                hr_adicional_noturno = hr_adicional_noturno == null ? '' : hr_adicional_noturno;

                var  tipo_ponto_pk = arrCarregar.data[0].registrosfolha[i].tipo_ponto_pk;
                if (tipo_ponto_pk == 1) {
                    ds_situacao = "Expediente";
                } else if (tipo_ponto_pk == 5) {
                    ds_situacao = "Folga";
                } else if (tipo_ponto_pk == 10) {
                    ds_situacao = "Falta";
                } else if (tipo_ponto_pk == 11) {
                    ds_situacao = "Abonada";
                }else if (tipo_ponto_pk == 12) {
                    ds_situacao = "Férias";
                }else if (tipo_ponto_pk == 15) {
                    ds_situacao = "Afastamento";
                }else if (tipo_ponto_pk == 16) {
                    ds_situacao = "Atestado";
                }else if (tipo_ponto_pk == 17) {
                    ds_situacao = "Advertencia";
                }else if (tipo_ponto_pk == 18) {
                    ds_situacao = "Declaração da defesa civil";
                }else if (tipo_ponto_pk == 19) {
                    ds_situacao = "Demissão";
                }else if (tipo_ponto_pk == 20) {
                    ds_situacao = "Folga compensatória";
                }else if (tipo_ponto_pk == 21) {
                    ds_situacao = "Folga de feriado";
                }else if (tipo_ponto_pk == 22) {
                    ds_situacao = "Justa causa";
                }else if (tipo_ponto_pk == 23) {
                    ds_situacao = "Recisão indireta";
                }else if (tipo_ponto_pk == 24) {
                    ds_situacao = "Suspensão";
                }else if (tipo_ponto_pk == 25) {
                    ds_situacao = "Troca Folga";
                }
                else if (tipo_ponto_pk == 26) {
                    ds_situacao = "Folga Semanal";
                }
                else if (tipo_ponto_pk == 27) {
                    ds_situacao = "Folga Domingo";
                }
                else if (tipo_ponto_pk == 28) {
                    ds_situacao = "Feriado";
                }
                else if (tipo_ponto_pk == 29) {
                    ds_situacao = "Atraso";
                }
                



               
                
                
                var obs = arrCarregar.data[0].registrosfolha[i].obs;
                obs = obs == null ? '' : obs;
                
                var ic_status = arrCarregar.data[0].registrosfolha[i].ic_status;
                ic_status = ic_status == null ? '' : ic_status;
                
                v_html += "<tr>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<input type='hidden' id='ponto_folha_registros_pk" + i + "' value='" + v_pk + "'>";
                v_html += "<input type='hidden' id='expediente_diario" + i + "' value='" + v_expediente_diario + "'>";

                v_html += "<input type='hidden' id='ds_turno" + i + "' value='" + v_ds_turno + "'>";

                if (ic_status == 1) {
                    v_html += "     <input type='checkbox' class='ic_status' id='ic_status"+i+"' checked value='1'>";
                }else {
                    v_html += "     <input type='checkbox' class='ic_status' id='ic_status"+i+"' value='1'>";
                }

                v_html += "   </td>";
                v_html += "   <td width='25'>";
                v_html += v_dt;
                v_html += "   <input type='hidden' id='dt_hora_ponto" + i + "' size='3' value='" + v_dt + "'>";
                v_html += "   </td>";
                v_html += "   <td width='25'>";
                v_html += "<input type='text' id='hr_ini_expediente" + i + "' size='3' value='" + hr_ini_expediente + "' onkeypress='mascara(this,horamask)' onChange='PreencherAutomatico("+i+")'>";
                v_html += "   </td>";
                v_html += "   <td width='25'>";
                v_html += "<input type='text' id='hr_ini_intervalo" + i + "' size='3' value='" + hr_ini_intervalo + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td width='25'>";
                v_html += "<input type='text' id='hr_fim_intervalo" + i + "' size='3' value='" + hr_fim_intervalo + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td width='25'>";
                v_html += "<input type='text' id='hr_fim_expediente" + i + "' size='3' value='" + hr_fim_expediente + "' onkeypress='mascara(this,horamask)' onChange='PreencherAutomatico("+i+")'>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<input type='text' id='hr_trabalhadas" + i + "' size='3' value='" + hr_trabalhadas + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<input type='text' id='hr_excedentes" + i + "' size='3' value='" + hr_excedentes + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<input type='type' id='hr_faltantes" + i + "' size='3' value='" + hr_faltantes + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<font size='1,7'><span id='ds_situacao" + i + "'>" + ds_situacao + "</span></font>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<input type='text' id='hr_extra50" + i + "' size='3' value='" + hr_extra50 + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <th style=' text-align: center'>";
                v_html += "<input type='text' id='hr_extra100" + i + "' size='3' value='" + hr_extra100 + "'>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<input type='text' id='hr_adicional_noturno" + i + "' size='3' value='" + hr_adicional_noturno + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<input type='text' id='obs" + i + "' maxlength='20' value='" + obs + "'>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "<select id='ic_acao" + i + "' onchange='fcAlteraSituacao(this.value," + i + ")'>";
                v_html += "        <option value=''></option>";
                v_html += "        <option value='1'>Expediente</option>";
                v_html += "        <option value='5'>Folga</option>";
                v_html += "        <option value='10'>Falta</option>";
                v_html += "        <option value='11'>Abonada</option>";
                v_html += "        <option value='12'>Férias</option>";
                v_html += "        <option value='15'>Afastamento</option>";
                v_html += "        <option value='16'>Atestado</option>";
                v_html += "        <option value='17'>Advertencia</option>";
                v_html += "        <option value='18'>Declaração da defesa civil</option>";
                v_html += "        <option value='19'>Demissão</option>";
                v_html += "        <option value='20'>Folga compensatória</option>";
                v_html += "        <option value='21'>Folga de feriado</option>";
                v_html += "        <option value='22'>Justa causa</option>";
                v_html += "        <option value='23'>Recisão indireta</option>";
                v_html += "        <option value='24'>Suspensão</option>";
                v_html += "        <option value='25'>Troca Folga</option>";
                v_html += "        <option value='26'>Folga Semanal</option>";
                v_html += "        <option value='27'>Folga Domingo</option>";
                v_html += "        <option value='28'>Feriado</option>";
                v_html += "        <option value='29'>Atraso</option>";
                v_html += "        </select> ";
                v_html += "    </td>";
                v_html += "</tr>";
                setTimeout(function () {
                    PreencherAutomatico(i);
                }, 2000);

            }
            v_html += "<tr style='background: #1A0F6B'>";
            v_html += "    <td  width='15%'  colspan='15'>";
            v_html += "      <label style=' color: white '><b>TOTAL DE HORAS</b></label>";
            v_html += "    </td>";
            v_html += "</tr>";
            v_html += "<tr >";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "      &nbsp;";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center' colspan=5>";
            v_html += "      &nbsp;";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <b>H.T</b>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <b>H.E</b>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <b>H.F</b>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "      &nbsp;";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <b>H.E1</b>";
            v_html += "    </td>";
            v_html += "    <td style=' text-align: center'>";
            v_html += "   <b>H.E2</b>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "   <b>A.N</b>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "   &nbsp;";
            v_html += "    </td>";
            v_html += "</tr>";
            v_html += "<tr >";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "      &nbsp;";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center' colspan=5>";
            v_html += "      &nbsp;";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <input type='text' id='ht_total' name='ht_total' size='3' maxlength='6' value='" + v_ht_total + "' onkeypress='mascara(this,horamask)'>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <input type='text' id='he_total' name='he_total' size='3' maxlength='6' value='" + v_he_total + "' onkeypress='mascara(this,horamask)'>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <input type='text' id='hf_total' name='hf_total' size='3' maxlength='6' value='" + v_hf_total + "' onkeypress='mascara(this,horamask)'>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "      &nbsp;";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <input type='text' id='he1_total' name='he1_total' size='3' maxlength='6' value='" + v_he1_total + "' onkeypress='mascara(this,horamask)'>";
            v_html += "    </td>";
            v_html += "    <td style=' text-align: center'>";
            v_html += "       <input type='text' id='he2_total' name='he2_total' size='3' maxlength='6' value='" + v_he2_total + "' onkeypress='mascara(this,horamask)'>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "       <input type='text' id='an_total' name='an_total' size='3' maxlength='6' value='" + v_an_total + "' onkeypress='mascara(this,horamask)'>";
            v_html += "    </td>";
            v_html += "    <td  style=' text-align: center'>";
            v_html += "   &nbsp;";
            v_html += "    </td>";
            v_html += "</tr>";

            $("#listar_registros").html(v_html);
        }
        else {
            alert('Falhar ao carregar o registro');
        }
    }

}

function hmToMins(str){
    const [hh, mm] = str.split(':').map(nr => Number(nr) || 0);
    return hh * 60 + mm;
}

function converHrs(hr){

        horas = (hr / 60)|0;
        min = hr % 60; 
        
        if(horas < 0){
            horas = horas * -1;
        }

        if(min < 0){
            min = min * -1;
        }

        if(min < 10){
            min = "0"+min;
        }

        if(horas < 10){
            horas = "0"+horas;
        }

        return hora = horas +":"+ min;
}

function PreencherAutomatico(l){

    try {
        var v_li = $("#totalLinhas").val();
    
        for (l = 0; l < v_li; l++) {
            var hr_ini_expediente = $("#hr_ini_expediente" + l).val();
            var hr_fim_expediente = $("#hr_fim_expediente" + l).val();
            var expediente_diario = $("#expediente_diario" + l).val(); // Quantas horas a pessoa deveria trabalhar no dia
            var hr_ini_intervalo = $("#hr_ini_intervalo" + l).val();
            var hr_fim_intervalo = $("#hr_fim_intervalo" + l).val();
    
            var hr_excedentes = "00:00";
            var hr_faltantes = "00:00";
    
            if (hr_ini_expediente != "" && hr_fim_expediente != "") {
    
                hr_ini_expediente = hmToMins(hr_ini_expediente);
                hr_fim_expediente = hmToMins(hr_fim_expediente);
                hr_ini_intervalo = hr_ini_intervalo != '' ? hmToMins(hr_ini_intervalo) : 0;
                hr_fim_intervalo = hr_fim_intervalo != '' ? hmToMins(hr_fim_intervalo) : 0;
                expediente_diario = hmToMins(expediente_diario);
    
                // Cálculo do intervalo
                var hr_intervalo = hr_fim_intervalo - hr_ini_intervalo;
                if (hr_intervalo < 0) hr_intervalo += 24 * 60; // Caso o intervalo passe de meia-noite
    
                // Horas trabalhadas
                var hr_trabalhadas_manha = hr_ini_intervalo - hr_ini_expediente; // Período da manhã
                var hr_trabalhadas_tarde = hr_fim_expediente - hr_fim_intervalo; // Período da tarde
    
                var hr_trabalhadas = hr_trabalhadas_manha + hr_trabalhadas_tarde;
    
                // Corrigir para expediente que ultrapassa meia-noite
                if (hr_trabalhadas < 0) {
                    hr_trabalhadas += 24 * 60;
                }
    
                // Comparar com o expediente diário
                if (expediente_diario > hr_trabalhadas) {
                    hr_faltantes = expediente_diario - hr_trabalhadas;
                    hr_faltantes = converHrs(hr_faltantes);
                }
    
                if (expediente_diario < hr_trabalhadas) {
                    hr_excedentes = hr_trabalhadas - expediente_diario;
                    hr_excedentes = converHrs(hr_excedentes);
                }
    
                hr_trabalhadas = converHrs(hr_trabalhadas);
    
                // Atualizar os valores no formulário
                $("#hr_excedentes" + l).val(hr_excedentes);
                $("#hr_faltantes" + l).val(hr_faltantes);
                $("#hr_trabalhadas" + l).val(hr_trabalhadas);
                calcTotal();
            } else {
                $("#hr_excedentes" + l).val("");
                $("#hr_faltantes" + l).val("");
                $("#hr_trabalhadas" + l).val("");
            }
        }
    } catch (e) {
        alert(e);
    }
    
}

function calcTotal(){ 
    var total_hr_trabalhadas = 0;
    var toral_hr_faltantes = 0;
    var total_hr_excedentes = 0;
    var total_hr_an = 0;

    var v_li = $("#totalLinhas").val();

    for (l = 0; l < v_li; l++) {

        var hr_excedentes = $("#hr_excedentes" + l).val();
        var hr_faltantes = $("#hr_faltantes" + l).val();
        var hr_trabalhadas = $("#hr_trabalhadas" + l).val();
        var hr_an = $("#hr_adicional_noturno" + l).val();

        
        if(hr_excedentes == ""){
            hr_excedentes = "00:00";
        }
        if(hr_faltantes == ""){
            hr_faltantes = "00:00";
        }
        if(hr_trabalhadas == ""){
            hr_trabalhadas = "00:00";
        }
        if(hr_an == ""){
            hr_an = "00:00";
        }
        
        hr_excedentes = hmToMins(hr_excedentes);
        hr_faltantes = hmToMins(hr_faltantes);
        hr_trabalhadas = hmToMins(hr_trabalhadas);
        hr_an = hmToMins(hr_an);

        total_hr_trabalhadas += hr_trabalhadas;
        toral_hr_faltantes += hr_faltantes;
        total_hr_excedentes += hr_excedentes;
        total_hr_an += hr_an;
    }

    total_hr_trabalhadas = converHrs(total_hr_trabalhadas);
    toral_hr_faltantes = converHrs(toral_hr_faltantes);
    total_hr_excedentes = converHrs(total_hr_excedentes);
    total_hr_an = converHrs(total_hr_an);

    $("#ht_total").val(total_hr_trabalhadas);
    $("#he_total").val(total_hr_excedentes);
    $("#hf_total").val(toral_hr_faltantes);
    $("#an_total").val(total_hr_an);
}

function PrintElem(elem){
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}

function fcAlteraSituacao(pk, row){
    


    if (pk == 5) {
        $("#ds_situacao" + row).html("Folga");
    } else if (pk == 10) {
        $("#ds_situacao" + row).html("Falta");
    } else if (pk == 11) {
        $("#ds_situacao" + row).html("Abonada");
    } else if (pk == 1) {
        $("#ds_situacao" + row).html("Dia Trabalhado");
    }
    else if (pk == 12) {
        $("#ds_situacao" + row).html("Férias");
    }
    else if (pk == 15) {
        $("#ds_situacao" + row).html("Afastamento");
    }

    else if (pk == 16) {
        $("#ds_situacao" + row).html("Atestado");
    }
    else if (pk == 17) {
        $("#ds_situacao" + row).html("Advertencia");
    }
    else if (pk == 18) {
        $("#ds_situacao" + row).html("Declaração da defesa civil");
    }
    else if (pk == 19) {
        $("#ds_situacao" + row).html("Demissão");
    }
    else if (pk == 20) {
        $("#ds_situacao" + row).html("Folga compensatória");
    }
    else if (pk == 21) {
        $("#ds_situacao" + row).html("Folga de feriado");
    }
    else if (pk == 22) {
        $("#ds_situacao" + row).html("Justa causa");
    }
    else if (pk == 23) {
        $("#ds_situacao" + row).html("Recisão indireta");
    }
    else if (pk == 24) {
        $("#ds_situacao" + row).html("Suspensão");
    }
    else if (pk == 25) {
        $("#ds_situacao" + row).html("Troca Folga");
    }
    else if (pk == 26) {
        $("#ds_situacao" + row).html("Folga Semanal");
    }
    else if (pk == 27) {
        $("#ds_situacao" + row).html("Folga Domingo");
    }
    else if (pk == 28) {
        $("#ds_situacao" + row).html("Feriado");
    }
    else if (pk == 29) {
        $("#ds_situacao" + row).html("Atraso");
    }
}

function fcCancelar(){
    var objParametros = {
        "pk":$('#pk').val()  
    };
    sendPost('ponto_folha','colaboradoresCad',objParametros)
}


var formdata;
$(document).ready(function () {

    formdata = new FormData();
    $("#ic_marcar_todos").on( 'change', function () {
        if ($("#ic_marcar_todos").prop( "checked")) 
        $(".ic_status").attr('checked', true)
        else 
        $(".ic_status").attr('checked', false)
    } );
    

    //fcVerificacaoPonto();
    fcCarregar();

    //Atibuir funções
    $(document).on('click', '#cmdVoltar', fcCancelar);
    $(document).on('click', '#cmdImprimirModal', fcEnviar);
});



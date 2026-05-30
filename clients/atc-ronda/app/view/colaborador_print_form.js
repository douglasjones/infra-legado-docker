

function fcCarregarDadosColaborador(){
    if(colaborador_pk > 0){
        var tipoGrauEscolaridade = {
            1: "Educação infantil",
            2: "Ensino Fundamental",
            3: "Ensino Médio",
            4: "Superior (Graduação)",
            5: "Pós-graduação",
            6: "Mestrado",
            7: "Doutorado"
        }; 
        var tipoGenero = {
            1: "Masculino",
            2: "Feminino"
        }; 
        var tipoRegimeContratacao = {
            1: "Mensalista",
            2: "Horista"
        }; 
        var tipoFuncionario = {
            1: "Sim",
            2: "Não"
        }; 
        var tipoStatusColaborador = {
            1: "Ativo",
            2: "Demitido",
            3: "Afastado",
            4: "Férias",
            5: "Currículo"
        };
        var tipoReserva = {
            0: "Desativado",
            1: "Ativo"
        }; 
        var tipoWhatsapp = {
            1: "Sim",
            2: "Não"
        };  
        var tipoEstadoCivil = {
            1: "Solteiro",
            2: "Casado",
            3: "Separado",
            4: "Divorciado",
            5: "Viúvo",
            6: "União Estável"
        }; 
        var tipoFilho = {
            null: "Não",
            1: "Sim"
        }; 
        var tipoRegimeCasamento = {
            1: "Comunhão parcial",
            2: "Comunhão universal",
            3: "Participação final nos aquestos e separação convencional de bens"
        }; 
        var tipoContaBancaria = {
            1: "Conta Corrente",
            2: "Conta Poupança",
            3: "Conta Salário"
        }; 
        var tipoPossuiTreinamentoECertificado = {
            2: "Não",
            1: "Sim"
        };

        var objParametros = {
            "pk": colaborador_pk
        };

        var arrCarregar = carregarController("colaborador", "listarColaboradorPkPrint", objParametros);

        if (arrCarregar.result == 'success'){
            if(arrCarregar.data[0]['ds_pin']!=null){
                $("#ds_pin").html("<h6>Pin: " + arrCarregar.data[0]['ds_pin']+"</h6>");
            }
            else{
                $("#ds_pin").html("");
            }

            $("#ds_colaborador").text(arrCarregar.data[0]['ds_colaborador']);
            $("#ds_cel").text(arrCarregar.data[0]['ds_cel']);
            $("#ic_whatsapp").text(tipoWhatsapp[arrCarregar.data[0]['ic_whatsapp']]);
            $("#ds_cel2").text(arrCarregar.data[0]['ds_cel2']);
            $("#ic_whatsapp2").text(tipoWhatsapp[arrCarregar.data[0]['ic_whatsapp2']]);
            $("#ds_cel3").text(arrCarregar.data[0]['ds_cel3']);
            $("#ic_whatsapp3").text(tipoWhatsapp[arrCarregar.data[0]['ic_whatsapp3']]);
            $("#ds_email").text(arrCarregar.data[0]['ds_email']);
            $("#ds_rg").text(arrCarregar.data[0]['ds_rg']);
            $("#ds_cpf").text(arrCarregar.data[0]['ds_cpf']);
            $("#dt_nascimento").text(arrCarregar.data[0]['dt_nascimento']);
            $("#ds_endereco").text(arrCarregar.data[0]['ds_endereco']);
            $("#ds_numero").text(arrCarregar.data[0]['ds_numero']);
            $("#ds_complemento").text(arrCarregar.data[0]['ds_complemento']);
            $("#ds_bairro").text(arrCarregar.data[0]['ds_bairro']);
            $("#ds_cep").text(arrCarregar.data[0]['ds_cep']);
            $("#ds_cidade").text(arrCarregar.data[0]['ds_cidade']);
            $("#ds_uf").text(arrCarregar.data[0]['ds_uf']);
            $("#ic_status").text(tipoStatusColaborador[arrCarregar.data[0]['ic_status']]);
            $("#generos_pk").text(tipoGenero[arrCarregar.data[0]['generos_pk']]);
            $("#ic_funcionario").text(tipoFuncionario[arrCarregar.data[0]['ic_funcionario']]);
            $("#ds_re").text(arrCarregar.data[0]['ds_re']);
            $("#ds_raca").text(arrCarregar.data[0]['ds_raca']);
            $("#ds_deficiencia_fisica").text(arrCarregar.data[0]['ds_deficiencia_fisica']);
            $("#estado_civil").text(tipoEstadoCivil[arrCarregar.data[0]['estado_civil']]);
            $("#ds_nome_pai").text(arrCarregar.data[0]['ds_nome_pai']);
            $("#ds_nome_mae").text(arrCarregar.data[0]['ds_nome_mae']);
            $("#ds_nome_conjuge").text(arrCarregar.data[0]['ds_nome_conjuge']);
            $("#dt_nascimento_conjuge").text(arrCarregar.data[0]['dt_nascimento_conjuge']);
            $("#ds_cpf_conjuge").text(arrCarregar.data[0]['ds_cpf_conjuge']);
            $("#ds_tel_conjuge").text(arrCarregar.data[0]['ds_tel_conjuge']);
            $("#regime_casamento").text(tipoRegimeCasamento[arrCarregar.data[0]['regime_casamento']]);
            $("#ds_ctps").text(arrCarregar.data[0]['ds_ctps']);
            $("#ds_serie").text(arrCarregar.data[0]['ds_serie']);
            $("#dt_expedicao").text(arrCarregar.data[0]['dt_expedicao']);
            $("#ds_uf_rg").text(arrCarregar.data[0]['ds_uf_rg']);
            $("#ds_org_exp").text(arrCarregar.data[0]['ds_org_exp']);
            $("#ds_pis").text(arrCarregar.data[0]['ds_pis']);
            $("#ds_titulo_eleitoral").text(arrCarregar.data[0]['ds_titulo_eleitoral']);
            $("#ds_zona_eleitoral").text(arrCarregar.data[0]['ds_zona_eleitoral']);
            $("#ds_secao").text(arrCarregar.data[0]['ds_secao']);
            $("#ds_certificado_reservista").text(arrCarregar.data[0]['ds_certificado_reservista']);
            $("#ds_nacionalidade").text(arrCarregar.data[0]['ds_nacionalidade']);
            $("#ds_matricula").text(arrCarregar.data[0]['ds_matricula']);
            $("#grau_escolaridade_pk").text(tipoGrauEscolaridade[arrCarregar.data[0]['grau_escolaridade_pk']]);
            $("#dt_demissao").text(arrCarregar.data[0]['dt_demissao']);
            $("#dt_admissao").text(arrCarregar.data[0]['dt_admissao']);

            $("#empresas_pk").text(arrCarregar.data[0]['empresas_pk']);
            $("#regime_contratacao_pk").text(tipoRegimeContratacao[arrCarregar.data[0]['regime_contratacao_pk']]);
            $("#ds_carga_horaria_semanal").text(arrCarregar.data[0]['ds_carga_horaria_semanal']);
            
            $("#ds_n_sapato").text(arrCarregar.data[0]['ds_n_sapato']);
            $("#ds_n_camisa").text(arrCarregar.data[0]['ds_n_camisa']);
            $("#ds_n_calca").text(arrCarregar.data[0]['ds_n_calca']);
            $("#ds_n_luva").text(arrCarregar.data[0]['ds_n_luva']);
            
            $("#tipo_conta_bancaria").text(tipoContaBancaria[arrCarregar.data[0]['tipo_conta_bancaria']]);
            $("#ds_agencia").text(arrCarregar.data[0]['ds_agencia']);
            $("#ds_conta").text(arrCarregar.data[0]['ds_conta']);
            $("#ds_digito").text(arrCarregar.data[0]['ds_digito']);
            $("#bancos_pk").text(arrCarregar.data[0]['ds_banco']);
            $("#vl_salario").text(float2moeda(arrCarregar.data[0]['vl_salario']));
            $("#ds_pix").text(arrCarregar.data[0]['ds_pix'])
            $("#ds_conta_favorecido").text(arrCarregar.data[0]['ds_conta_favorecido']) 
            $("#ic_reserva").text(tipoReserva[arrCarregar.data[0]['ic_reserva']]) 
            $("#ic_filho_menor_14").text(tipoFilho[arrCarregar.data[0]['ic_filho_menor_14']])
            $("#ds_produto_servico").text(arrCarregar.data[0]['ds_produto_servico'])

            $("#ic_possui_treinamento").text(tipoPossuiTreinamentoECertificado[arrCarregar.data[0]['ic_possui_treinamento']])
            $("#ic_possui_certificado").text(tipoPossuiTreinamentoECertificado[arrCarregar.data[0]['ic_possui_certificado']])
            $("#ds_beneficio").text(arrCarregar.data[0]['ds_beneficio'])
            $("#obs").text(arrCarregar.data[0]['obs'])
            $("#vl_beneficio").text(arrCarregar.data[0]['vl_beneficio'])

            $("#exibir_qtde_filho").hide();
            $("#exibir_nome_filho").hide();
            $("#exibir_osbeneficios").hide();
            $("#exibir_osservicos").hide();

            for(var i=0; i < arrCarregar.data[0].DadosEscala.length; i++){

                $("#ds_lead").text(arrCarregar.data[0].DadosEscala[i]['ds_lead'])
                $("#dt_inicio_agenda").text(arrCarregar.data[0].DadosEscala[i]['dt_inicio_agenda'])
                $("#dt_fim_agenda").text(arrCarregar.data[0].DadosEscala[i]['dt_fim_agenda'])
                $("#dt_cancelamento").text(arrCarregar.data[0].DadosEscala[i]['dt_cancelamento'])
                $("#ds_turno").text(arrCarregar.data[0].DadosEscala[i]['ds_turno'])
                $("#hr_inicio_expediente").text(arrCarregar.data[0].DadosEscala[i]['hr_inicio_expediente'])
                $("#hr_termino_expediente").text(arrCarregar.data[0].DadosEscala[i]['hr_termino_expediente'])
                $("#hr_saida_intervalo").text(arrCarregar.data[0].DadosEscala[i]['hr_saida_intervalo'])
                $("#hr_saida_intervalo").text(arrCarregar.data[0].DadosEscala[i]['hr_retorno _intervalo'])
                
            }    

            
            for(var i=0; i < arrCarregar.data[0].DadosColaboradorServico.length; i++){
                
                var nomeServico = arrCarregar.data[0].DadosColaboradorServico[i]['ds_produto_servico']; 
                var possuiCertificado = tipoPossuiTreinamentoECertificado[arrCarregar.data[0].DadosColaboradorServico[i]['ic_possui_certificado']]; 
                var possuiTreinamento = tipoPossuiTreinamentoECertificado[arrCarregar.data[0].DadosColaboradorServico[i]['ic_possui_treinamento']]; 

                linhaHtml = "<div class='row'>";
                linhaHtml += "<div class='col-md-4'>Qualificação: <span id='nome_filho' name='nome_filho'>" + nomeServico + "</span></div>";
                linhaHtml += "<div class='col-md-4'>Possui Treinamento: <span id='nome_filho' name='nome_filho'>" + possuiTreinamento + "</span></div>";
                linhaHtml += "<div class='col-md-4'>Possui Certificado: <span id='nome_filho' name='nome_filho'>" + possuiCertificado + "</span></div>";
                linhaHtml += "</div>";
                $("#exibir_servicos").append(linhaHtml);
                $("#exibir_osservicos").show();
            }

            for(var i=0; i < arrCarregar.data[0].DadosColaboradorBeneficio.length; i++){
                
                var nomeBeneficio = arrCarregar.data[0].DadosColaboradorBeneficio[i]['ds_beneficio']; 
                var obs = arrCarregar.data[0].DadosColaboradorBeneficio[i]['obs']; 
                var valorBeneficio = arrCarregar.data[0].DadosColaboradorBeneficio[i]['vl_beneficio']; 

                linhaHtml = "<div class='row'>";
                linhaHtml += "<div class='col-md-4'>Beneficio: <span id='nome_filho' name='nome_filho'>" + nomeBeneficio + "</span></div>";
                linhaHtml += "<div class='col-md-4'>Valor: <span id='nome_filho' name='nome_filho'>" + valorBeneficio + "</span></div>";
                linhaHtml += "<div class='col-md-4'>OBS: <span id='nome_filho' name='nome_filho'>" + obs + "</span></div>";
                linhaHtml += "</div>";
                $("#exibir_beneficios").append(linhaHtml);
                $("#exibir_osbeneficios").show();
            }           

            
            if(arrCarregar.data[0]['ic_filho_menor_14']==1){
                
                $("#exibir_qtde_filho").show();
                $("#qtde_filho").text(arrCarregar.data[0]['qtde_filho']);
                $("#exibir_nome_filho").show();
                for(var i=0; i < arrCarregar.data[0].DadosColaboradorFilhos.length; i++){
                    var nomeFilho = arrCarregar.data[0].DadosColaboradorFilhos[i]['ds_nome_filho']; 
                    var cpfFilho = arrCarregar.data[0].DadosColaboradorFilhos[i]['ds_cpf_filho']; 
                    var dtnascFilho = arrCarregar.data[0].DadosColaboradorFilhos[i]['dt_nascimento_filho']; 

                    linhaHtml = "<div class='row'>";
                    linhaHtml += "<div class='col-md-4'> <span id='nome_filho' name='nome_filho'> Nome Filho:" + nomeFilho + "</span></div>";
                    linhaHtml += "<div class='col-md-4'> <span id='nome_filho' name='nome_filho'> CPF Filho:" + cpfFilho + "</span></div>";
                    linhaHtml += "<div class='col-md-4'> <span id='nome_filho' name='nome_filho'>Data de Nasc Filho:" + dtnascFilho + "</span></div>";
                    linhaHtml += "</div>";
                    $("#exibir_nomes_filhos").append(linhaHtml);
                }
            }    





        }
        else{
            alert('Falhar ao carregar o registro');
        }

    }
}

function printDiv() {
    var divToPrint = document.getElementById('colaboradordados'); 
    var divToPrint2 = document.getElementById('contratacaodados');
    var divToPrint3 = document.getElementById('contatodados'); 
    var divToPrint4 = document.getElementById('documentacaodados');
    var divToPrint5 = document.getElementById('dependendesdados');
    var divToPrint6 = document.getElementById('bancodados'); 
    var divToPrint7 = document.getElementById('enderecodados'); 
    var divToPrint8 = document.getElementById('vestuariodados');
    var divToPrint9 = document.getElementById('qualificacaodados');
    var divToPrint10 = document.getElementById('beneficiosdados');

    
    var newWin = window.open('', 'Print-Window');
    newWin.document.write('<title>Tela Impressão</title>');
    newWin.document.write('<style>@page { size: auto; margin: 5mm; }</style>'); 
    newWin.document.write('<style>.print-styleh h5{margin-top: 1em;margin-bottom: 0;} .print-style .row [class^="col-"] {display: inline-block;vertical-align: top; margin-right: 2em;} .print-style2 .row [class^="col-"] {display: inline-block;vertical-align: top; margin-right: 1em;} .print-style3 .row [class^="col-"] {display: inline-block;vertical-align: top; margin-right: 1em;} .print-stylefilho .row [class^="col-"] {display: inline-block;vertical-align: top; margin-right: 0.5em;} .print-style .row {margin-top: 1em;margin-left: -2.5em;} .print-style2 .row {margin-top: 1em;margin-left: -0.7em;} .print-style3 .row {margin-top: 1em;margin-left: -0.7em;} .print-stylefilho .row {margin-top: 0.5em;margin-left: -0.3em;}</style>'); 
    newWin.document.write('<html><body onload="window.print()">' + '<div class="row"><h5 style="margin-top: 1em; margin-bottom: 0;">Colaboradores</h5><hr style="height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;"></div>' +
                            divToPrint.innerHTML + '<div class="row"><div class="col-md-10"><h5 style="margin-top: 1em; margin-bottom: 0;">Dados de Contratação</h5><hr style="height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;"></div></div>' +
                            divToPrint2.innerHTML + '<div class="row"><div class="col-md-10"><h5 style="margin-top: 1em; margin-bottom: 0;">Dados de Contato do Colaborador</h5><hr style="height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;"></div></div>' +
                            divToPrint3.innerHTML + '<div class="row"><div class="col-md-10"><h5 style="margin-top: 1em; margin-bottom: 0;">Documentação do Colaborador</h5><hr style="height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;"></div></div>' +
                            divToPrint4.innerHTML + '<div class="row"><div class="col-md-10"><h5 style="margin-top: 1em; margin-bottom: 0;">Dados de Dependentes</h5><hr style="height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;"></div></div>' +  
                            divToPrint5.innerHTML + '<div class="row"><div class="col-md-10"><h5 style="margin-top: 1em; margin-bottom: 0;">Dados Bancários</h5><hr style="height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;"></div></div>' +
                            divToPrint6.innerHTML + '<div class="row"><div class="col-md-10"><h5 style="margin-top: 1em; margin-bottom: 0;">Endereço do Colaborador</h5><hr style="height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;"></div></div>' +
                            divToPrint7.innerHTML + '<div class="row"><div class="col-md-10"><h5 style="margin-top: 1em; margin-bottom: 0;">Dados de Vestuário</h5><hr style="height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;"></div></div>' +
                            divToPrint8.innerHTML +
                            divToPrint9.innerHTML + 
                            divToPrint10.innerHTML + 
                            '</body></html>');
    newWin.document.close();
    setTimeout(function () { newWin.close(); }, 1000);

            

 }



 function fcCancelar() {
    history.back();
}

$(document).ready(function () {

    $(document).on('click', '#cmdVoltar', fcCancelar);
    $(document).on('click', '#cmdImprimirModal', printDiv);

    /// Lista os dados do cliente
    fcCarregarDadosColaborador()
    //fcCarregar()

});





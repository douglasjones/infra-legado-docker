function fcCarregar(){

    if(colaborador_pk > 0){


        var objParametros = {
            "pk": colaborador_pk
        };

        var arrCarregar = carregarController("colaborador", "listarPk", objParametros);

        if (arrCarregar.result == 'success'){
            if(arrCarregar.data[0]['ds_pin']!=null){
                $(".ds_pin").text(arrCarregar.data[0]['ds_pin']);
            }
            else{
                $(".ds_pin").text("");
            }

            $(".ds_colaborador").text(arrCarregar.data[0]['ds_colaborador']);
            $(".dt_nascimento").text(arrCarregar.data[0]['dt_nascimento']);
            
            $(".ds_rg").text(arrCarregar.data[0]['ds_rg']);
            $(".ds_re").text(arrCarregar.data[0]['ds_re']);
            $(".ds_cpf").text(arrCarregar.data[0]['ds_cpf']);
            $(".ds_genero").text(arrCarregar.data[0]['ds_genero']);
            $(".ds_uf_rg").text(arrCarregar.data[0]['ds_uf_rg']);
            $(".ds_org_exp").text(arrCarregar.data[0]['ds_org_exp']);
            $(".dt_expedicao").text(arrCarregar.data[0]['dt_expedicao']);
            $(".ds_genero").text(arrCarregar.data[0]['ds_genero']);
            $(".ds_nome_pai").text(arrCarregar.data[0]['ds_nome_pai']);
            $(".ds_nome_mae").text(arrCarregar.data[0]['ds_nome_mae']);
            $(".ds_titulo_eleitoral").text(arrCarregar.data[0]['ds_titulo_eleitoral']);
            $(".ds_zona_eleitoral").text(arrCarregar.data[0]['ds_zona_eleitoral']);
            $(".ds_secao").text(arrCarregar.data[0]['ds_secao']);
            $(".ds_ctps").text(arrCarregar.data[0]['ds_ctps']);
            $(".ds_serie").text(arrCarregar.data[0]['ds_serie']);
            $(".ds_pis").text(arrCarregar.data[0]['ds_pis']);
            $(".ds_endereco").text(arrCarregar.data[0]['ds_endereco']);
            $(".ds_numero").text(arrCarregar.data[0]['ds_numero']);
            $(".ds_complemento").text(arrCarregar.data[0]['ds_complemento']);
            $(".ds_bairro").text(arrCarregar.data[0]['ds_bairro']);
            $(".ds_cep").text(arrCarregar.data[0]['ds_cep']);
            $(".ds_cidade").text(arrCarregar.data[0]['ds_cidade']);
            $(".ds_uf").text(arrCarregar.data[0]['ds_uf']);
            $(".ds_email").text(arrCarregar.data[0]['ds_email']);
            $(".ds_agencia").text(arrCarregar.data[0]['ds_agencia']);
            $(".ds_conta").text(arrCarregar.data[0]['ds_conta']);
            $(".ds_digito").text(arrCarregar.data[0]['ds_digito']);
            $(".ds_banco").text(arrCarregar.data[0]['ds_banco']);
            $(".vl_salario").text("R$: "+float2moeda(arrCarregar.data[0]['vl_salario']));

            $(".ds_cel").text(arrCarregar.data[0]['ds_cel']);
            $(".ic_whatsapp").text(arrCarregar.data[0]['ic_whatsapp']);
            $(".ds_cel2").text(arrCarregar.data[0]['ds_cel2']);
            $(".ic_whatsapp2").text(arrCarregar.data[0]['ic_whatsapp2']);
            $(".ds_cel3").text(arrCarregar.data[0]['ds_cel3']);
            $(".ic_whatsapp3").text(arrCarregar.data[0]['ic_whatsapp3']);
            $(".ds_estado_civil").text(arrCarregar.data[0]['ds_estado_civil']);
            $(".ds_escolaridade").text(arrCarregar.data[0]['ds_escolaridade']);
            $(".ds_nome_conjuge").text(arrCarregar.data[0]['ds_nome_conjuge']);
            $(".qtde_filho").text(arrCarregar.data[0]['qtde_filho']);
            
            $(".ds_n_sapato").text(arrCarregar.data[0]['ds_n_sapato']);
            $(".ds_n_camisa").text(arrCarregar.data[0]['ds_n_camisa']);
            $(".ds_n_calca").text(arrCarregar.data[0]['ds_n_calca']);
            
            fcAtualizarDadosGridNomeFilho();
            
            $(".ds_produto_servico").text(arrCarregar.data[0]['ds_produto_servico']);
            $(".dt_admissao").text(arrCarregar.data[0]['dt_admissao']);
         
            $(".ds_turno").text(arrCarregar.data[0]['ds_turno']);
            $(".hr_inicio_expediente").text(arrCarregar.data[0]['hr_inicio_expediente']);
            $(".hr_termino_expediente").text(arrCarregar.data[0]['hr_termino_expediente']);
            $(".n_qtde_dias_semana").text(arrCarregar.data[0]['n_qtde_dias_semana']);

            
            fcAtualizarDadosGridBeneficio();
            
            $(".ds_carga_horaria_semanal").text(arrCarregar.data[0]['ds_carga_horaria_semanal']);
            if(arrCarregar.data[0]['empresas_pk']==null){
                fcListarConta();
            }
            else{
                 $(".ds_empresa").text(arrCarregar.data[0]['ds_razao_social_empresa']);
                $(".ds_cnpj").text(arrCarregar.data[0]['ds_cpf_cnpj_empresa']);
                $(".ds_endereco_empresa").text(arrCarregar.data[0]['ds_endereco_empresa']+", "+arrCarregar.data[0]['ds_numero_empresa']+" - "+arrCarregar.data[0]['ds_bairro_empresa']+" - "+arrCarregar.data[0]['ds_cep_empresa'] +" - "+arrCarregar.data[0]['ds_cidade_empresa']+" / "+arrCarregar.data[0]['ds_uf_empresa']);
                $(".ds_cidade_empresa").text(arrCarregar.data[0]['ds_cidade_empresa']+" - "+arrCarregar.data[0]['ds_uf_empresa']);
                $(".ds_tel_empresa").text(arrCarregar.data[0]['ds_cel_empresa']);
                $(".ds_email_empresa").text(arrCarregar.data[0]['ds_email_empresa']);
            }
            
            
            $(".ds_matricula").text(arrCarregar.data[0]['ds_matricula']);
            
            if(arrCarregar.data[0]['ds_imagem']!=null){
                $(".ds_imagem").html("<img width=100 height=120 src='"+arrCarregar.data[0]['ds_imagem']+"'>");
            }else{
               $(".ds_imagem").html("<img width=100 height=120 src='http://democondominio.gepros6.com.br/img/usuario_sem_imagem.png'>");
            }
            
            fcTotalHREscalaPeriodo(colaborador_pk);
           
            
            /*$("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#generos_pk").val(arrCarregar.data[0]['generos_pk']);
            $("#ic_funcionario").val(arrCarregar.data[0]['ic_funcionario']);
            $("#ds_re").val(arrCarregar.data[0]['ds_re']);
            $("#ds_raca").val(arrCarregar.data[0]['ds_raca']);
            $("#ds_deficiencia_fisica").val(arrCarregar.data[0]['ds_deficiencia_fisica']);
            $("#estado_civil").val(arrCarregar.data[0]['estado_civil']);
            
           
            $("#dt_nascimento_conjuge").val(arrCarregar.data[0]['dt_nascimento_conjuge']);
            $("#ds_cpf_conjuge").val(arrCarregar.data[0]['ds_cpf_conjuge']);
            $("#ds_tel_conjuge").val(arrCarregar.data[0]['ds_tel_conjuge']);
            $("#regime_casamento").val(arrCarregar.data[0]['regime_casamento']);
            
            
            
            $("#ds_certificado_reservista").val(arrCarregar.data[0]['ds_certificado_reservista']);
            $("#ds_nacionalidade").val(arrCarregar.data[0]['ds_nacionalidade']);
            $("#ds_matricula").val(arrCarregar.data[0]['ds_matricula']);
            $("#grau_escolaridade_pk").val(arrCarregar.data[0]['grau_escolaridade_pk']);
            $("#dt_demissao").val(arrCarregar.data[0]['dt_demissao']);
            $("#dt_admissao").val(arrCarregar.data[0]['dt_admissao']);

            $("#empresas_pk").val(arrCarregar.data[0]['empresas_pk']);
            $("#regime_contratacao_pk").val(arrCarregar.data[0]['regime_contratacao_pk']);
            

           
            $("#tipo_conta_bancaria").val(arrCarregar.data[0]['tipo_conta_bancaria']);
            

            

            $("#dt_liberado").html(arrCarregar.data[0]['dt_liberado']);

            if(arrCarregar.data[0]['ds_status_app']!= null){
                $("#ds_status_app").html("Status liberação acesso App Ponto :<b>"+arrCarregar.data[0]['ds_status_app']+"</b>");
            }else{

                $("#ds_status_app").html("Status liberação acesso App Ponto: <b>Não solicitado</b>");
            }

            if(arrCarregar.data[0]['ds_status_app']=='Liberado'){
                $("#dt_liberacao").html("Data da Liberação acesso App Ponto <b>"+arrCarregar.data[0]['dt_liberacao']+"</b>");
            }


            if(arrCarregar.data[0]['ic_filho_menor_14']==1){

			                    $("#exibir_qtde_filho").show();
			                    $("input[id=ic_filho_menor_14]").prop("checked", "true");
			                    
			                    $("#exibir_nome_filho").show();
			                    setTimeout(function(){
			                        tblNomeFilho.clear().destroy();
			                        fcFormatarGridNomeFilho();
			                        fcAtualizarDadosGridNomeFilho();
			                    }, 500);
            }
            if(arrCarregar.data[0]['ic_reserva']==1){
                    $("input[id=ic_reserva]").prop("checked", "true");
            }

            if(arrCarregar.data[0]['ic_dom']==1){
                $("input[id=ic_dom]").prop("checked", "true");
           }
           //SEG
           if(arrCarregar.data[0]['ic_seg']==1){
                $("input[id=ic_seg]").prop("checked", "true");
           }
           if(arrCarregar.data[0]['ic_registrar_ponto']==1){
                $("input[id=ic_registrar_ponto]").prop("checked", "true");
           }
           //TER
           if(arrCarregar.data[0]['ic_ter']==1){
                $("input[id=ic_ter]").prop("checked", "true");
           }
           //QUA
           if(arrCarregar.data[0]['ic_qua']==1){
                $("input[id=ic_qua]").prop("checked", "true");
           }
           //QUI
           if(arrCarregar.data[0]['ic_qui']==1){
                $("input[id=ic_qui]").prop("checked", "true");
           }
           //SEX
           if(arrCarregar.data[0]['ic_sex']==1){
                $("input[id=ic_sex]").prop("checked", "true");
           }
           //SAB
           if(arrCarregar.data[0]['ic_sab']==1){
                $("input[id=ic_sab]").prop("checked", "true");
           }

           $("#colaborador_ponto_pk").val(arrCarregar.data[0]['colaborador_ponto_pk']);
           $("#dom_turnos_pk").val(arrCarregar.data[0]['turnos_pk_dom']);
           $("#seg_turnos_pk").val(arrCarregar.data[0]['turnos_pk_seg']);
           $("#ter_turnos_pk").val(arrCarregar.data[0]['turnos_pk_ter']);
           $("#qua_turnos_pk").val(arrCarregar.data[0]['turnos_pk_qua']);
           $("#qui_turnos_pk").val(arrCarregar.data[0]['turnos_pk_qui']);
           $("#sex_turnos_pk").val(arrCarregar.data[0]['turnos_pk_sex']);
           $("#sab_turnos_pk").val(arrCarregar.data[0]['turnos_pk_sab']);

            $("#hr_entrada_dom").val(arrCarregar.data[0]['hr_entrada_dom']);
            $("#hr_entrada_seg").val(arrCarregar.data[0]['hr_entrada_seg']);
            $("#hr_entrada_ter").val(arrCarregar.data[0]['hr_entrada_ter']);
            $("#hr_entrada_qua").val(arrCarregar.data[0]['hr_entrada_qua']);
            $("#hr_entrada_qui").val(arrCarregar.data[0]['hr_entrada_qui']);
            $("#hr_entrada_sex").val(arrCarregar.data[0]['hr_entrada_sex']);
            $("#hr_entrada_sab").val(arrCarregar.data[0]['hr_entrada_sab']);

            $("#hr_saida_dom").val(arrCarregar.data[0]['hr_saida_dom']);
            $("#hr_saida_seg").val(arrCarregar.data[0]['hr_saida_seg']);
            $("#hr_saida_ter").val(arrCarregar.data[0]['hr_saida_ter']);
            $("#hr_saida_qua").val(arrCarregar.data[0]['hr_saida_qua']);
            $("#hr_saida_qui").val(arrCarregar.data[0]['hr_saida_qui']);
            $("#hr_saida_sex").val(arrCarregar.data[0]['hr_saida_sex']);
            $("#hr_saida_sab").val(arrCarregar.data[0]['hr_saida_sab']);*/

        }
        else{
            alert('Falhar ao carregar o registro');
        }

    }
}

function fcTotalHREscalaPeriodo(colaborador_pk){

        var hoje = new Date();
        var dia = hoje.getDate();
        var mes = hoje.getMonth()+1;
        var ano = hoje.getFullYear();     
        var dt_ini = '01/'+mes+'/'+ano; 
        var udm = (new Date(ano,mes+1,0,0,0,0)).getDate();
        var dt_fim = udm+'/'+mes+'/'+ano;
        
         var objParametros = {
            "colaborador_pk": colaborador_pk,
            "dt_periodo_ini": dt_ini,
            "dt_periodo_fim": dt_fim
        };

        var arrCarregar0 = carregarController("agenda_colaborador_padrao", "retornoTotalHrTrabalhadasEscala", objParametros);

        if (arrCarregar0.result == 'success'){

            $(".ds_carga_horaria_semanal").text(arrCarregar0.data[0]['total_hr_mes']);
            
        }
        
        
}   


function fcAtualizarDadosGridNomeFilho(){

    var objParametros = {
        "colaborador_pk":colaborador_pk,
        "token": token
    };

    var arrCarregar = carregarController("colaborador_nome_filho", "listarNomeFilhoColaboradorPk", objParametros);

    if (arrCarregar.result == 'success'){
        var ds_filho ="";
        for(i = 0; i < arrCarregar.data.length; i++){
            
            ds_filho += arrCarregar.data[i]['ds_nome_filho']+" - "+arrCarregar.data[i]['dt_nascimento_filho']+" - "+arrCarregar.data[i]['ds_cpf_filho'];
            

        }
        
    }
    else{

        alert('Falhar ao carregar o registro');
    }
    $(".ds_nome_filho").text(ds_filho);
}




function fcAtualizarDadosGridBeneficio(){

    var objParametros = {
        "colaboradores_pk":colaborador_pk,
        "token": token
    };

    var arrCarregar = carregarController("beneficio", "listarBeneficioColaboradores", objParametros);
   
        if (arrCarregar.result == 'success'){
            $(".ds_vr").text("NAO");
            $(".ds_vl_transporte").text("NAO");
            for(i = 0; i < arrCarregar.data.length; i++){
                if(arrCarregar.data[i]['beneficios_pk']==1){
                    $(".ds_vr").text("R$: "+float2moeda(arrCarregar.data[i]['vl_beneficio']));
                }
                if(arrCarregar.data[i]['beneficios_pk']==2){
                     $(".ds_vl_transporte").text("R$: "+float2moeda(arrCarregar.data[i]['vl_beneficio']));
                }
               
            }
            
        }
        else{

            alert('Falhar ao carregar o registro');
        }
}
function fcListarConta(){

    var objParametros = {
        "token": token
    };

    var arrCarregar = carregarController("conta", "listarPk", objParametros);
    
        if (arrCarregar.result == 'success'){
            $(".ds_empresa").text(arrCarregar.data[0]['ds_razao_social']);
            $(".ds_cnpj").text(arrCarregar.data[0]['ds_cpf_cnpj']);
            $(".ds_endereco_empresa").text(arrCarregar.data[0]['ds_endereco']+", "+arrCarregar.data[0]['ds_numero']+" - "+arrCarregar.data[0]['ds_bairro']+" - "+arrCarregar.data[0]['ds_cep'] +" - "+arrCarregar.data[0]['ds_cidade']+" / "+arrCarregar.data[0]['ds_uf']);
            $(".ds_cidade_empresa").text(arrCarregar.data[0]['ds_cidade']+" - "+arrCarregar.data[0]['ds_uf']);
            $(".ds_tel_empresa").text(arrCarregar.data[0]['ds_cel']);
            $(".ds_email_empresa").text(arrCarregar.data[0]['ds_email']);
            
        }
        else{

            alert('Falhar ao carregar o registro');
        }

}

function fcVoltar(){
    sendPost('formulario_contrato_colaborador_res_form.php',{token: token, colaborador_pk: colaborador_pk});
}
function fcImprimir(){
    window.print();
    
}

$(document).ready(function()
    {
        

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
        
        $(document).on('click', '#cmdVoltar', fcVoltar);
        $(document).on('click', '#cmdImprimir', fcImprimir);
      

    }
);
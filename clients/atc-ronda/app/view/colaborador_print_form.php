<?
require_once "../inc/php/header.php";
?>

<script src="colaborador_print_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>
    
    .print-style .row {
            
      }
    
  </style>
<div class="container" >

    <div class='row'>
        &nbsp;
        <div class='col-md-12' align='center' >
            <button type="button" class="btn btn-primary" id="cmdImprimirModal"  name="cmdPrint">Imprimir</button>
            &nbsp;
            <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>
            
        </div>
    </div>
    
    
    <p>
    <form id="form_colaborador_ins" class="form" >
        
        
        <div class="tab-content" id="myTabContent">
            <p>
            
            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">           
            <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    
                    <div class="col-md-10">
                        <h5>Colaboradores</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
            </div>
            <div id='colaboradordados'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    
                    <div class='col-md-6'>
                        <label for='ds_colaborador'>Colaborador (Nome Completo):&nbsp;</label>
                        <span id='ds_colaborador' name='ds_colaborador'></span>
                    </div>                     
                </div>
                

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cel2'>Nacionalidade:&nbsp;</label>
                        <span id='ds_nacionalidade' name='ds_nacionalidade'  > </span>
                    </div>
                </div>   
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ds_cep'>Grau Escolaridade:&nbsp;</label>
                        <span id='grau_escolaridade_pk' name="grau_escolaridade_pk"> </span>
                        
                    </div>
                </div>
                <div class='print-style'>
                <div class='row'>
                    
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='dt_nascimento'>Data Nasc.:&nbsp;</label>
                        <span id='dt_nascimento' name='dt_nascimento' ></span>
                    </div> 

                    <div class='col-md-2'>
                        <label for='generos_pk'>Gênero:&nbsp;</label>
                        <span  id='generos_pk' name='generos_pk' > </span>
                        
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cel'>Raça:&nbsp;</label>
                        <span id='ds_raca' name='ds_raca'> </span>
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cel'>Deficiência Física:&nbsp;</label>
                        <span  id='ds_deficiencia_fisica' name='ds_deficiencia_fisica'> </span>
                    </div>                     
                </div>
                </div>
                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='ds_cel2'>Nome do Pai:&nbsp;</label>
                        <span  id='ds_nome_pai' name='ds_nome_pai'  > </span>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='ic_whatsapp2'>Nome da Mãe:&nbsp;</label>
                        <span  id='ds_nome_mae' name='ds_nome_mae'  > </span>
                    </div>
                </div>
                </div>
                <p>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Dados de Contratação</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>
                <div id='contratacaodados'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='matricula'>Empresa:&nbsp;</label>
                        <span  id='empresas_pk' name='empresas_pk'  > </span>
                    </div>
                </div>
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='matricula'>Regime Contratação:&nbsp;</label>
                         <span  id='regime_contratacao_pk' name='regime_contratacao_pk'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_rg'>Carga Horária:&nbsp;</label>
                        <span  id='ds_carga_horaria_semanal' name='ds_carga_horaria_semanal' > </span>
                    </div> 
                     <div class='col-md-2'>
                        <label for='ds_salario'>Salário R$:&nbsp;</label>
                        <span   id='vl_salario' name='vl_salario' > </span>
                    </div>   
                </div>
                </div>
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='matricula'>Matricula:&nbsp;</label>
                        <span id='ds_matricula' name='ds_matricula'  > </span>
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>R.E (e-social):&nbsp;</label>
                        <span  id='ds_re' name='ds_re' > </span>
                    </div> 
                </div>
                </div>
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_colaborador'>Data Admissão:&nbsp;</label>
                        <span id='dt_admissao' name='dt_admissao' > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_funcionario'>Funcionário:&nbsp;</label>
                        <span  id='ic_funcionario' name='ic_funcionario' > </span>
                            
                    </div>                    
                    <div class='col-md-5'>
                        <label for='ic_status'>Status Colaborador no Sistema:&nbsp;</label>
                        <span id='ic_status' name='ic_status' > </span>
                        
                    </div>
                </div>
                </div>
                

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Reserva:&nbsp;</label>
                        <span id='ic_reserva' name='ic_reserva' >
                    </div>        
                </div>
                <p>
                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    
                     <div class='col-md-3'>
                        <label for='dt_demissao'>Data Demissão:&nbsp;</label>
                        <span  id='dt_demissao' name='dt_demissao'  > </span>
                        
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                    </div>
                   
                </div>
                </div>
                <p>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Dados da Escala do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>
                <div class='print-style'>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-6'>
                            <label for='posto_trabalho'>Posto de Trabalho:&nbsp;</label>
                            <span id='ds_lead' name='ds_lead'  > </span> 
                        </div>
                    </div>
                </div>                
                <div class='print-style'>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='dt_inicio_escala'>Dt Início Escala:&nbsp;</label>
                            <span id='dt_inicio_agenda' name='dt_inicio_agenda'  > </span> 
                        </div>
                        <div class='col-md-4'>
                            <label for='dt_termino_escala'>Dt Termino Escala:&nbsp;</label>
                            <span id='dt_termino_agenda' name='dt_termino_agenda'  > </span> 
                        </div>
                    </div>
                </div>
                <div class='print-style'>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='dt_cancelamento_escala'>Dt Cancelamento Escala:&nbsp;</label>
                            <span id='dt_cancelamento' name='dt_cancelamento'  > </span> 
                        </div>
                    </div>
                </div>
                <div class='print-style'>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='turno'>Turno:&nbsp;</label>
                            <span id='ds_turno' name='ds_turno'  > </span> 
                        </div>
                    </div>
                </div>
                <div class='print-style'>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='hr_ini_expediente'>HR Início Expediente:&nbsp;</label>
                            <span id='hr_inicio_expediente' name='hr_inicio_expediente'  > </span> 
                        </div>
                        <div class='col-md-4'>
                            <label for='dt_termino_escala'>HR Termino Expediente:&nbsp;</label>
                            <span id='hr_termino_expediente' name='hr_termino_expediente'  > </span> 
                        </div>
                    </div>
                </div>
                <div class='print-style'>
                    <div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='hr_ini_expediente'>HR Início Intervalo:&nbsp;</label>
                            <span id='hr_saida_intervalo' name='hr_saida_intervalo'  > </span> 
                        </div>
                        <div class='col-md-4'>
                            <label for='dt_termino_escala'>HR Termino Intervalo:&nbsp;</label>
                            <span id='hr_retorno_intervalo' name='hr_retorno_intervalo'  > </span> 
                        </div>
                    </div>
                </div>
                <p>

                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Dados de Contato do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div> 
                <div id='contatodados'>  
                <div class='print-style'>            
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                     <div class='col-md-2'>
                        <label for='ds_cel'>Cel:&nbsp;</label>
                        <span id='ds_cel' name='ds_cel'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp'>Whatsapp:&nbsp;</label>
                        <span id='ic_whatsapp' name='ic_whatsapp'> </span>
                            
                    </div>     
                     <div class='col-md-4'>
                        <label for='ds_email'>E-mail:&nbsp;</label>
                        <span  id='ds_email' name='ds_email' > </span>
                    </div>
                     
                </div>
                </div>
                
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cel2'>Cel 2:&nbsp;</label>
                        <span id='ds_cel2' name='ds_cel2'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Whatsapp 2:&nbsp;</label>
                        <span  id='ic_whatsapp2' name='ic_whatsapp2' > </span>
                            
                    </div>      
                    <div class='col-md-2'>
                        <label for='ds_cel3'>Cel 3:&nbsp;</label>
                        <span id='ds_cel3' name='ds_cel3'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp3'>Whatsapp 3:&nbsp;</label>
                        <span id='ic_whatsapp3' name='ic_whatsapp3' > </span>
                            
                    </div> 
                </div>
                </div>
                </div>
                
                
                <p>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Documentação do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>
                <div id='documentacaodados'>  
                <div class='print-style'> 
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cpf'>CPF:&nbsp;</label>
                        <span  id='ds_cpf' name='ds_cpf' > </span>
                    </div>
                         
                    <div class='col-md-3'>
                        <label for='ds_rg'>Pis:&nbsp;</label>
                        <span id='ds_pis' name='ds_pis' > </span>
                    </div>   
                </div>
                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_rg'>RG/RNE:&nbsp;</label>
                        <span id='ds_rg' name='ds_rg' > </span>
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Orgão Expedição :&nbsp;</label>
                        <span  id='ds_org_exp' name='ds_org_exp' > </span>
                    </div>  
                    <div class='col-md-3'>
                        <label for='ds_rg'>Dt. Expedição :&nbsp;</label>
                        <span id='dt_expedicao' name='dt_expedicao' > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_uf_rg'>UF RG:&nbsp;</label>
                        <span  id='ds_uf_rg' name='ds_uf_rg'> </span>
                        
                    </div>
                </div>
                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Titulo Eleitoral:&nbsp;</label>
                        <span id='ds_titulo_eleitoral' name='ds_titulo_eleitoral' > </span>
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Zona Eleitoral:&nbsp;</label>
                        <span id='ds_zona_eleitoral' name='ds_zona_eleitoral' > </span>
                    </div> 
                    <div class='col-md-3'>
                        <label for='ds_rg'>Seção:&nbsp;</label>
                        <span  id='ds_secao' name='ds_secao' > </span>
                    </div>                
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                   
                    <div class='col-md-3'>
                        <label for='ds_rg'>CTPS:&nbsp;</label>
                        <span   id='ds_ctps' name='ds_ctps' > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_rg'>Série:&nbsp;</label>
                        <span  id='ds_serie' name='ds_serie' > </span>
                    </div>     
                </div>
                
                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Certificado Reservista:&nbsp;</label>
                        <span  id='ds_certificado_reservista' name='ds_certificado_reservista' > </span>
                    </div>
                  
                </div>
                </div>
                </div>
                <p>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Dados de Dependentes</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>     
                <div id='dependendesdados'>   
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ic_whatsapp2'>Nome Cônjuge:&nbsp;</label>
                        <span  id='ds_nome_conjuge' name='ds_nome_conjuge'  > </span>
                    </div>
                </div>                     
               <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>     
                        <div class='col-md-2'>
                        <label for='generos_pk'>Estado Civil:&nbsp;</label>
                        <span  id='estado_civil' name='estado_civil'> </span>
                            
                    </div>
                </div>     
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cel2'>Dt. Nasc. Cônjuge:&nbsp;</label>
                        <span id='dt_nascimento_conjuge' maxlength="10" name='dt_nascimento_conjuge'  > </span>
                    </div>
                    <div class='col-md-3'>
                        <label for='ic_whatsapp2'>CPF Cônjuge:&nbsp;</label>
                        <span id='ds_cpf_conjuge' name='ds_cpf_conjuge'  > </span>
                    </div>
                    <div class='col-md-3'>
                        <label for='ic_whatsapp2'>Tel Cônjuge:&nbsp;</label>
                        <span   id='ds_tel_conjuge' maxlength="14" name='ds_tel_conjuge'  > </span>
                    </div>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-7'>
                        <label for='ic_whatsapp2'>Regime Casamento:&nbsp;</label>
                        <span   id='regime_casamento' name='regime_casamento'> </span>
                            
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Filho menor 14 anos:&nbsp;</label>
                        <span id='ic_filho_menor_14' name='ic_filho_menor_14' > </span>
                    </div> 
                    <div class='col-md-2' id="exibir_qtde_filho">
                          <label for='ds_rg'>Qtde. Filho:&nbsp;</label>
                          <span  id='qtde_filho' name='qtde_filho' > </span>
                      </div> 
                </div> 
                </div>  
                
                <br>
                <div id="exibir_nome_filho">
                <div class='print-styleh'>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    
                    <div class="col-md-10">
                        <h5>Dados Filhos</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                    
                </div> 
                </div>
                

                <div class='print-stylefilho'>
                    <div class="row" >
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class="col-md-10" id="exibir_nomes_filhos">
                            
                        </div>
                    </div>
                    </div>
                    </div>
                    <p>
                    <br>
                </div>
                <p>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Dados Bancários</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>    
                <div id='bancodados'>                   
               <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>     
                        <div class='col-md-4'>
                        <label for='generos_pk'>Tipo Conta:&nbsp;</label>
                        <span  id='tipo_conta_bancaria' name='tipo_conta_bancaria'></span>
                        
                    </div>
                </div> 
               <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>     
                        <div class='col-md-4'>
                        <label for='generos_pk'>Banco:&nbsp;</label>
                        <span id='bancos_pk' name='bancos_pk'> </span>
                            
                    </div>
                </div> 
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cel2'>Agência:&nbsp;</label>
                        <span  id='ds_agencia' maxlength="12" name='ds_agencia'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Conta:&nbsp;</label>
                        <span maxlength="15" id='ds_conta' name='ds_conta'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Digito:&nbsp;</label>
                        <span    id='ds_digito' maxlength="5" name='ds_digito'  > </span>
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_whatsapp2'>PIX:&nbsp;</label>
                        <span    id='ds_pix'  name='ds_pix'  > </span>
                    </div>
                </div>
                </div>
                 <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ds_cel2'>Favorecido:&nbsp;</label>
                        <span  id='ds_conta_favorecido' name='ds_conta_favorecido'  > </span>
                    </div>
                   
                </div>
                </div>
                <p>
               
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Endereço do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>      
                <div id='enderecodados'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cep'>CEP:&nbsp;</label>
                        <span  id='ds_cep' name='ds_cep' > </span>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ds_endereco'>Endereço:&nbsp;</label>
                        <span id='ds_endereco' name='ds_endereco' > </span>
                    </div>
                </div>
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_numero'>Número:&nbsp;</label>
                        <span id='ds_numero' name='ds_numero' > </span>
                    </div>
                    <div class='col-md-4'>
                        <label for='ds_complemento'>Complemento:&nbsp;</label>
                        <span  id='ds_complemento' name='ds_complemento' > </span>
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_bairro'>Bairro:&nbsp;</label>
                        <span id='ds_bairro' name='ds_bairro' > </span>
                    </div>
                </div>
                </div>
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ds_cidade'>Cidade:&nbsp;</label>
                        <span  id='ds_cidade' name='ds_cidade' > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_uf'>UF:&nbsp;</label>
                        <span  id='ds_uf' name='ds_uf'> </span>
                            
                    </div> 
                </div>
                </div>
                </div>
          <p>
          <br>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Dados de Vestuário</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>    
                <div id='vestuariodados'>  
                <div class='print-style'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cel2'>N Sapato:&nbsp;</label>
                        <span  id='ds_n_sapato'  name='ds_n_sapato'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Tamanho Camisa:&nbsp;</label>
                        <span   id='ds_n_camisa' name='ds_n_camisa'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Tamanho Calça:&nbsp;</label>
                        <span   id='ds_n_calca'  name='ds_n_calca'  > </span>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Tamanho luva:&nbsp;</label>
                        <span    id='ds_n_luva'  name='ds_n_luva'  > </span>
                    </div>
                </div>
                </div>
                </div>

                <p>
                <div id='qualificacaodados'>
                <div class='print-styleh'>
                <div id="exibir_osservicos">
                
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Qualificação</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>  
                <div class='print-style2'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class="col-md-10" id="exibir_servicos">
                    
                    </div>
                    
                </div>
                </div>
                </div>
                </div>
                </div>
                <p>
                <div id='beneficiosdados'>
                <div class='print-styleh'>
                <div id="exibir_osbeneficios">
                
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Benefícios</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>      
                
                <div class='print-style3'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class="col-md-10" id="exibir_beneficios">
                    
                    </div>
                    
                </div>
                </div>
                </div>
                </div>
                </div>


                
    </form>

</div>

 
<?
require_once "../inc/php/footer.php";
?>

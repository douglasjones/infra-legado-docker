<?
require_once "../inc/php/header.php";
?>

<script src="colaborador_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="container">
    <br>
    <div class="row">
    <div class="col-lg">
        <div class="card shadow mb-6">
            <div class="card-header py-3">	
                <div class="row">
                    <div class='col-sm-6' align="left">
                        <h6 class="m-0 font-weight-bold text-primary">Colaboradores</h6>     
                    </div>       
                    <div class='col-sm-6' align="Right">
                        <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                        &nbsp;
                        <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarColaborador">Salvar</button>                         
                    </div>
                </div>   
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-13">
                        <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="dados-tab" data-toggle="tab" href="#dados" role="tab" aria-controls="dados" aria-selected="true">Dados Cadastrais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="qualificacao-tab" data-toggle="tab" href="#qualificacao" role="tab" aria-controls="qualificacao" >Qualificação</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="controleescalas-tab" data-toggle="tab" href="#controleescalas" role="tab" aria-controls="controleescalas" onclick="recarregarGridEscala()" >Controle De Escala</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cursos-tab" data-toggle="tab" href="#cursos" role="tab" aria-controls="cursos" >Exames/Cursos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="beneficios-tab" data-toggle="tab" href="#beneficios" role="tab" aria-controls="beneficios" >Benefícios</a>
                        </li>
                        <li class="nav-item" style="display:none" id="exibir_afastamento">
                            <a class="nav-link" id="afastamento-tab" data-toggle="tab" href="#afastamento" role="tab" aria-controls="afastamento">Afastamento/ Férias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="documentacao-tab" data-toggle="tab" href="#documentacao" role="tab" aria-controls="documentacao" >Documentação</a>
                        </li>
                        <li class="nav-item" style="display:none" id="exibir_materiais">
                            <a class="nav-link" id="materiais-tab" data-toggle="tab" href="#materiais" role="tab" aria-controls="materiais" onclick="recarregarGridEstoque()">Materiais</a>
                        </li>
                        </ul>
                    </div>       
            </div>
            <br>
            <div class="tab-content" id="myTabContent">
            <p>
            
            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
            <div class='row'>
                
                <div class='col-md-4'>
                    <div id='ds_imagem'></div>
                </div>
            </div>
            <div class='row'>
                
                <div class='col-md-8'>
                    <div id='ds_pin'></div>
                </div>               
            </div>
            <div class='row'>
                
                <div class='col-md-8'>
                    <div id='ds_status_app'></div>
                </div>               
            </div>
            <div class='row'>
                
                <div class='col-md-8'>
                    <div id='dt_liberacao'></div>
                </div>               
            </div>
            <div class='row'>
                    
                    <div class='col-md-6'>
                        <label for='ds_colaborador'>Colaborador (Nome Completo):&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_colaborador' name='ds_colaborador' required >
                    </div>                     
                </div>
                <div class='row' id="alert_ds_colaborador" style="display:none">
                    
                    <div class='col-md-4'>
                        <strong style="color: red">Por favor, informe Colaborador (Nome Completo)</strong>
                    </div>
                </div>

                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='ds_cel2'>Nacionalidade:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nacionalidade' name='ds_nacionalidade'  >
                    </div>
                </div>   
                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='ds_cep'>Grau Escolaridade:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='grau_escolaridade_pk' name="grau_escolaridade_pk" name=''>
                            <option></option>
                            <option value="1">Educação infantil</option>
                            <option value="2">Ensino Fundamental</option>
                            <option value="3">Ensino Médio</option>
                            <option value="4">Superior (Graduação)</option>
                            <option value="5">Pós-graduação</option>
                            <option value="6">Mestrado</option>
                            <option value="7">Doutorado</option>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='dt_nascimento'>Data Nasc.:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="10" id='dt_nascimento' name='dt_nascimento' >
                    </div> 
                    <div class='col-md-2'>
                        <label for='generos_pk'>Gênero:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='generos_pk' name='generos_pk' required>
                            <option></option>
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cel'>Raça:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_raca' name='ds_raca'>
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cel'>Deficiência Física:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'  id='ds_deficiencia_fisica' name='ds_deficiencia_fisica'>
                    </div>                     
                </div>
                <div class='row' id="alert_generos_pk" style="display:none">
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <strong style="color: red">Por favor, informe Gênero</strong>
                    </div>
                </div>
                <div class='row' id="alert_dt_nascimento" style="display:none">
                    
                    <div class='col-md-2'>
                        <strong style="color: red">Por favor, informe Data Nasc.</strong>
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='ds_cel2'>Tipo Sanguíneo:&nbsp;</label>
                        <select class='form-control form-control-sm' id="ic_tipo_sanguineo" name="ic_tipo_sanguineo" >
                            <option></option>
                            <option value="1">A+</option>
                            <option value="2">A-</option>
                            <option value="3">B+</option>
                            <option value="4">B-</option>
                            <option value="5">AB+</option>
                            <option value="6">AB-</option>
                            <option value="7">O+</option>
                            <option value="8">O-</option>
                        </select>
                    </div>
                </div>                
                <div class='row'>
                    
                    <div class='col-md-6'>
                        <label for='ds_cel2'>Nome do Pai:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nome_pai' name='ds_nome_pai'  >
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-6'>
                        <label for='ic_whatsapp2'>Nome da Mãe:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nome_mae' name='ds_nome_mae'  >
                    </div>
                </div>
                <p>
                <div class="row">
                     
                    <div class="col-md-10">
                        <h5>Dados de Contratação</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-4'>
                        <label for='matricula'>Empresa:&nbsp;</label>
                        <select  class='form-control form-control-sm' id='empresas_pk' name='empresas_pk'  >
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='matricula'>Regime Contratação:&nbsp;</label>
                         <select  class='form-control form-control-sm' id='regime_contratacao_pk' name='regime_contratacao_pk'  >
                            <option></option>
                            <option value="1">Mensalista</option>
                            <option value="2">Horista</option>
                        </select>
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_rg'>Carga Horária:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="5" id='ds_carga_horaria_semanal' name='ds_carga_horaria_semanal' >
                    </div> 
                     <div class='col-md-2'>
                        <label for='ds_salario'>Salário R$:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'  id='vl_salario' name='vl_salario' >
                    </div>   
                </div>
                <div class='row'>
                    
                    <div class='col-md-4'>
                        <label for='matricula'>Matricula:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_matricula' name='ds_matricula'  >
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>R.E (e-social):&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="9" id='ds_re' name='ds_re' >
                    </div> 
                </div>
               
                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='ds_colaborador'>Data Admissão:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='dt_admissao' name='dt_admissao' >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_funcionario'>Funcionário:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_funcionario' name='ic_funcionario' />
                            <option value='1'>Sim</option>
                            <option value='2'>Não</option>
                        </select>
                    </div>                    
                    <div class='col-md-3'>
                        <label for='ic_status'>Status Colaborador no Sistema:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_status' name='ic_status' required/>
                            <option value='1'>Ativo</option>
                            <option value='2'>Demitido</option>
                            <option value='3'>Afastado</option>
                            <option value='4'>Férias</option>
                            <option value='5'>Currículo</option>
                        </select>
                    </div>
                </div>
                <div class='row' id="alert_ic_status" style="display:none">
                    <div class='col-md-7'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <strong style="color: red">Por favor, informe Status (Ativo no Sistema ?).</strong>
                    </div>
                </div>

                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='ds_rg'>Reserva:&nbsp;</label>
                        <input type='checkbox'  id='ic_reserva' name='ic_reserva' >
                    </div>        
                </div>
                <p>
                <div class='row'>
                    <div class='col-md-2'>
                        <label for='ic_experiencia'>Dias de Experiência:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_experiencia' name='ic_experiencia' />
                            <option></option>
                            <option value='1'>30</option>
                            <option value='2'>60</option>
                        </select>
                    </div>
               </div>

                <div class='row'>
                    
                    
                     <div class='col-md-3'>
                        <label for='dt_demissao'>Data Demissão:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='dt_demissao' name='dt_demissao'  >
                        <div id="alert_dt_demissao" style="display:none" class='row'>
                            <strong style="color: red">Por favor, informe a Data Demissão</strong>
                        </div>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                    </div>
                   
                </div>
                
                <div class="row">
                     
                    <div class="col-md-10">
                        <h5>Dados de Contato do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>               
                <div class='row'>
                    
                     <div class='col-md-2'>
                        <label for='ds_cel'>Cel:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'  maxlength="14" id='ds_cel' name='ds_cel'  required>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp'>Whatsapp:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_whatsapp' name='ic_whatsapp'>
                            <option></option>
                            <option value='1'>Sim</option>
                            <option value='2'>Não</option>
                        </select>
                    </div>     
                     <div class='col-md-4'>
                        <label for='ds_email'>E-mail:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_email' name='ds_email' >
                    </div>
                     
                </div>
                <div class='row' id="alert_ds_cel" style="display:none">
                    
                    <div class='col-md-2'>
                        <strong style="color: red">Por favor, informe Cel.</strong>
                    </div>
                </div>
                <div class='row' id="alert_ic_whatsapp" style="display:none">
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <strong style="color: red">Por favor, informe Whatsapp.</strong>
                    </div>
                </div>
                <div class='row' id="alert_ds_email" style="display:none">
                    <div class='col-md-6'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <strong style="color: red">Por favor, informe E-mail.</strong>
                    </div>
                </div>

                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='ds_cel2'>Cel 2:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="14" id='ds_cel2' name='ds_cel2'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Whatsapp 2:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_whatsapp2' name='ic_whatsapp2' />
                            <option></option>
                            <option value='1'>Sim</option>
                            <option value='2'>Não</option>
                        </select>
                    </div>      
                    <div class='col-md-2'>
                        <label for='ds_cel3'>Cel 3:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="14" id='ds_cel3' name='ds_cel3'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp3'>Whatsapp 3:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_whatsapp3' name='ic_whatsapp3' />
                            <option></option>
                            <option value='1'>Sim</option>
                            <option value='2'>Não</option>
                        </select>
                    </div> 
                </div>
                <div class='row' id="alert_ds_cel2" style="display:none">
                    
                    <div class='col-md-2'>
                        <strong style="color: red">Por favor, informe Cel 2.</strong>
                    </div>
                </div>
                <div class='row' id="alert_ds_cel3" style="display:none">
                    <div class='col-md-6'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <strong style="color: red">Por favor, informe Cel 3.</strong>
                    </div>
                </div>
                <p>
                <div class="row">
                     
                    <div class="col-md-10">
                        <h5>Documentação do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='ds_cpf'>CPF:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="14" id='ds_cpf' name='ds_cpf' >
                    </div>
                         
                    <div class='col-md-3'>
                        <label for='ds_rg'>Pis:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'  id='ds_pis' name='ds_pis' >
                    </div>   
                </div>
                <div class='row' id="alert_ds_cpf" style="display:none">
                    
                    <div class='col-md-3'>
                        <strong style="color: red">Por favor, informe CPF.</strong>
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='ds_rg'>RG/RNE:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="20" id='ds_rg' name='ds_rg' >
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_rg'>Orgão Expedição :&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="9" id='ds_org_exp' name='ds_org_exp' >
                    </div>  
                    <div class='col-md-3'>
                        <label for='ds_rg'>Dt. Expedição :&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="10" id='dt_expedicao' name='dt_expedicao' >
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_uf_rg'>UF RG:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ds_uf_rg' name='ds_uf_rg'>
                            <option></option>
                            <option>AC</option>
                            <option>AL</option>
                            <option>AP</option>
                            <option>AM</option>
                            <option>BA</option>
                            <option>CE</option>
                            <option>DF</option>
                            <option>ES</option>
                            <option>GO</option>
                            <option>MA</option>
                            <option>MT</option>
                            <option>MS</option>
                            <option>MG</option>
                            <option>PA</option>
                            <option>PB</option>
                            <option>PR</option>
                            <option>PE</option>
                            <option>PI</option>
                            <option>RJ</option>
                            <option>RN</option>
                            <option>RS</option>
                            <option>RO</option>
                            <option>RR</option>
                            <option>SC</option>
                            <option>SP</option>
                            <option>SE</option>
                            <option>TO</option>                            
                        </select>
                    </div>
                </div>
                <div class='row' id="alert_ds_rg" style="display:none">
                    
                    <div class='col-md-2'>
                        <strong style="color: red">Por favor, informe RG/RNE.</strong>
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='ds_rg'>Titulo Eleitoral:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_titulo_eleitoral' name='ds_titulo_eleitoral' >
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Zona Eleitoral:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_zona_eleitoral' name='ds_zona_eleitoral' >
                    </div> 
                    <div class='col-md-3'>
                        <label for='ds_rg'>Seção:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'  id='ds_secao' name='ds_secao' >
                    </div>                
                </div>
                <div class='row'>
                    
                   
                    <div class='col-md-3'>
                        <label for='ds_rg'>CTPS:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'  id='ds_ctps' name='ds_ctps' >
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_rg'>Série:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_serie' name='ds_serie' >
                    </div>     
                </div>    
                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='ds_rg'>Certificado Reservista:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_certificado_reservista' name='ds_certificado_reservista' >
                    </div>                  
                </div>
                <div class='row'>
                    
                    <div class='col-md-6'>
                        <label for='ds_rg'>Numéro Cartão SUS:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_cartao_sus' name='ds_cartao_sus' >
                    </div>                  
                </div>
                <p>
                <div class="row">
                     
                    <div class="col-md-10">
                        <h5>Dados de Dependentes</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>     
         
                <div class='row'>
                    
                    <div class='col-md-8'>
                        <label for='ic_whatsapp2'>Nome Cônjuge:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nome_conjuge' name='ds_nome_conjuge'  >
                    </div>
                </div>                     
               <div class='row'>
                         
                        <div class='col-md-2'>
                        <label for='generos_pk'>Estado Civil:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='estado_civil' name='estado_civil'>
                            <option></option>
                            <option value="1">Solteiro</option>
                            <option value="2">Casado</option>
                            <option value="3">Separado</option>
                            <option value="4">Divorciado</option>
                            <option value="5">Viúvo</option>
                            <option value="6">União Estável</option>
                        </select>
                    </div>
                </div>     
                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='ds_cel2'>Dt. Nasc. Cônjuge:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='dt_nascimento_conjuge' maxlength="10" name='dt_nascimento_conjuge'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>CPF Cônjuge:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="14" id='ds_cpf_conjuge' name='ds_cpf_conjuge'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Tel Cônjuge:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="14"  id='ds_tel_conjuge' maxlength="14" name='ds_tel_conjuge'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Regime Casamento:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='regime_casamento' name='regime_casamento'>
                            <option></option>
                            <option value="1">Comunhão parcial</option>
                            <option value="2">Comunhão universal</option>
                            <option value="3">Participação final nos aquestos e separação convencional de bens</option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='ds_cel2'>Tipo Sanguíneo Cônjuge:&nbsp;</label>
                        <select class='form-control form-control-sm' id="ic_tipo_sanguineo_conjuge" name="ic_tipo_sanguineo_conjuge" >
                            <option></option>
                            <option value="1">A+</option>
                            <option value="2">A-</option>
                            <option value="3">B+</option>
                            <option value="4">B-</option>
                            <option value="5">AB+</option>
                            <option value="6">AB-</option>
                            <option value="7">O+</option>
                            <option value="8">O-</option>
                        </select>
                    </div>
                    <div class='col-md-6'>
                        <label for='ds_rg'>Numéro Cartão SUS:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_cartao_sus_conjuge' name='ds_cartao_sus_conjuge' >
                    </div>  
                </div>  
                <br>
                <div class='row'>
                    
                    <div class='col-md-3'>
                        <label for='ds_rg'>Filho menor 14 anos:&nbsp;</label>
                        <input type='checkbox'  id='ic_filho_menor_14' name='ic_filho_menor_14' >
                    </div> 
                    <div class='col-md-2' id="exibir_qtde_filho">
                          <label for='ds_rg'>Qtde. Filho:&nbsp;</label>
                          <input type='text' class='form-control form-control-sm' style="width:40px"  id='qtde_filho' name='qtde_filho' >
                      </div> 
                </div>   
                <p>
                <br>
                <div id="exibir_nome_filho">
                    <div class="row" >
                        
                        <div class="col-md-10">
                             <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblNomeFilho">
                                <thead>
                                    <tr>
                                        <th>Nome Filho</th>
                                        <th>CPF Filho</th>
                                        <th>Data Nasci. Filho</th>
                                        <th>Tipo Sanguíneo</th>
                                        <th>Núm Cartão SUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p>
                    <br>
                </div>
                <p>
                <div class="row">
                     
                    <div class="col-md-10">
                        <h5>Dados Bancários</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>                    
               <div class='row'>
                         
                        <div class='col-md-2'>
                        <label for='generos_pk'>Tipo Conta:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='tipo_conta_bancaria' name='tipo_conta_bancaria'>
                            <option></option>
                            <option value="1">Conta Corrente</option>
                            <option value="2">Conta Poupança</option>
                            <option value="2">Conta Salário</option>
                        </select>
                    </div>
                </div> 
               <div class='row'>
                         
                        <div class='col-md-2'>
                        <label for='generos_pk'>Banco:&nbsp;</label>
                        <select class='form-control form-control-sm chzn-select'  id='bancos_pk' name='bancos_pk'>
                            <option></option>
                        </select>
                    </div>
                </div> 
                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='ds_cel2'>Agência:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_agencia' maxlength="12" name='ds_agencia'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Conta:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="15" id='ds_conta' name='ds_conta'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Digito:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'   id='ds_digito' maxlength="5" name='ds_digito'  >
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_whatsapp2'>PIX:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'   id='ds_pix'  name='ds_pix'  >
                    </div>
                </div>
                 <div class='row'>
                    
                    <div class='col-md-4'>
                        <label for='ds_cel2'>Favorecido:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_conta_favorecido' name='ds_conta_favorecido'  >
                    </div>
                   
                </div>
                <p>
               
                <div class="row">
                     
                    <div class="col-md-10">
                        <h5>Endereço do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>      
     
                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='ds_cep'>CEP:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="9" id='ds_cep' name='ds_cep' >
                    </div>
                </div>
                <div class='row'>
                    
                    <div class='col-md-8'>
                        <label for='ds_endereco'>Endereço:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_endereco' name='ds_endereco' >
                    </div>
                </div>

                <div class='row'>
                    
                    <div class='col-md-1'>
                        <label for='ds_numero'>Número:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_numero' name='ds_numero' >
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_complemento'>Complemento:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_complemento' name='ds_complemento' >
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_bairro'>Bairro:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_bairro' name='ds_bairro' >
                    </div>
                </div>

                <div class='row'>
                    
                    <div class='col-md-4'>
                        <label for='ds_cidade'>Cidade:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_cidade' name='ds_cidade' >
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_uf'>UF:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ds_uf' name='ds_uf'>
                            <option></option>
                            <option>AC</option>
                            <option>AL</option>
                            <option>AP</option>
                            <option>AM</option>
                            <option>BA</option>
                            <option>CE</option>
                            <option>DF</option>
                            <option>ES</option>
                            <option>GO</option>
                            <option>MA</option>
                            <option>MT</option>
                            <option>MS</option>
                            <option>MG</option>
                            <option>PA</option>
                            <option>PB</option>
                            <option>PR</option>
                            <option>PE</option>
                            <option>PI</option>
                            <option>RJ</option>
                            <option>RN</option>
                            <option>RS</option>
                            <option>RO</option>
                            <option>RR</option>
                            <option>SC</option>
                            <option>SP</option>
                            <option>SE</option>
                            <option>TO</option>                            
                        </select>
                    </div> 
                </div>

                <p>
                <br>
                <div class="row">
                     
                    <div class="col-md-10">
                        <h5>Dados de Vestuário</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>      
                <div class='row'>
                    
                    <div class='col-md-2'>
                        <label for='ds_cel2'>N Sapato:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_n_sapato' maxlength="12" name='ds_n_sapato'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Tamanho Camisa:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="12" id='ds_n_camisa' name='ds_n_camisa'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Tamanho Calça:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="12"  id='ds_n_calca' maxlength="1" name='ds_n_calca'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Tamanho Luva:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="12"  id='ds_n_luva' maxlength="1" name='ds_n_luva'  >
                    </div>

                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                </div>
            </div>
                <p>
        
            <div class="tab-pane fade" id="qualificacao" role="tabpanel" aria-labelledby="qualificacao-tab">
                <br>
                <?php  include("colaborador_qualificacao_res.php"); ?>
            </div>

            <div class="tab-pane fade" id="cursos" role="tabpanel" aria-labelledby="cursos-tab">
                <br>
                <?php  include("colaborador_exames_cursos_res.php"); ?>
            </div>

            <div class="tab-pane fade" id="controleescalas" role="tabpanel" aria-labelledby="controleescalas-tab">
                <br>
                <?php  include("colaborador_controle_escala_res_form.php"); ?>
            </div>

            <div class="tab-pane fade" id="beneficios" role="tabpanel" aria-labelledby="beneficios-tab">
                <br>
                <?php  include("colaborador_beneficios_res.php"); ?>
            </div>

            <div class="tab-pane fade" id="afastamento" role="tabpanel" aria-labelledby="afastamento-tab">
                <br>
                <?php  include("colaborador_afastamento_ferias_res.php"); ?>
            </div>

            <div class="tab-pane fade" id="documentacao" role="tabpanel" aria-labelledby="documentacao-tab">
                <br>
                <?php  include("colaborador_documentos_res.php"); ?>
            </div>


            <!--Materiais-->
            <div class="tab-pane fade" id="materiais" role="tabpanel" aria-labelledby="materiais-tab">
                <br>
                <?php  include_once("movimentacao_estoque_colaborador_res_form.php"); ?> 
                
            </div>



        
        <div class="col-md-12" align="Right">
            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            <br>
            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
            &nbsp;
            <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarColaborador">Salvar</button>                
        </div>
</div>




 
<?
require_once "../inc/php/footer.php";
?>

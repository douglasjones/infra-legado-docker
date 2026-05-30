<?
require_once "../inc/php/header.php";
?>

<script src="menu_colaborador_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Colaboradores</h4>
        </div>
    </div>
   <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    <form id="form" class="form">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dados-tab" data-toggle="tab" href="#dados" role="tab" aria-controls="dados" aria-selected="true">Dados Cadastrais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="qualificacao-tab" data-toggle="tab" href="#qualificacao" role="tab" aria-controls="qualificacao" aria-selected="false">Qualificação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="cursos-tab" data-toggle="tab" href="#cursos" role="tab" aria-controls="cursos" aria-selected="false">Exames/Cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="beneficios-tab" data-toggle="tab" href="#beneficios" role="tab" aria-controls="beneficios" aria-selected="false">Benefícios</a>
            </li>
            <li class="nav-item" style="display:none" id="exibir_afastamento">
                <a class="nav-link" id="afastamento-tab" data-toggle="tab" href="#afastamento" role="tab" aria-controls="afastamento" aria-selected="false">Afastamento/ Férias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="documentacao-tab" data-toggle="tab" href="#documentacao" role="tab" aria-controls="documentacao" aria-selected="false">Documentação</a>
            </li>
            <!--li class="nav-item">
                <a class="nav-link" id="controle_ponto-tab" data-toggle="tab" href="#controle_ponto" role="tab" aria-controls="controle_ponto" >Ponto</a>
            </li-->
            <!--<li class="nav-item">
                <a class="nav-link" id="exames-tab" data-toggle="tab" href="#exames" role="tab" aria-controls="exames" aria-selected="false">Exames</a>
            </li>-->
            <li class="nav-item" style="display:none" id="exibir_materiais">
                <a class="nav-link" id="materiais-tab" data-toggle="tab" href="#materiais" role="tab" aria-controls="materiais" aria-selected="false">Materiais</a>
            </li>            
        </ul>
        <div class="tab-content" id="myTabContent">
            <p>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <div id='ds_imagem'></div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-8'>
                    <div id='ds_pin'></div>
                </div>               
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-8'>
                    <div id='ds_status_app'></div>
                </div>               
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-8'>
                    <div id='dt_liberacao'></div>
                </div>               
            </div>               
           <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>
            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">           
               
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='ds_colaborador'>Colaborador (Nome Completo):&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_colaborador' name='ds_colaborador' required >
                    </div>                     
                </div>

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cel2'>Nacionalidade:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nacionalidade' name='ds_nacionalidade'  >
                    </div>
                </div>   
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                        &nbsp;
                    </div>
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
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='ds_cel2'>Nome do Pai:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nome_pai' name='ds_nome_pai'  >
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='ic_whatsapp2'>Nome da Mãe:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nome_mae' name='ds_nome_mae'  >
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
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='matricula'>Empresa:&nbsp;</label>
                        <select  class='form-control form-control-sm' id='empresas_pk' name='empresas_pk'  >
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='matricula'>Matricula:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_matricula' name='ds_matricula'  >
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>R.E (Registro Empregado):&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="9" id='ds_re' name='ds_re' >
                    </div> 
                </div>
               
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                        <label for='ic_status'>Status (Ativo no Sistema ?):&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_status' name='ic_status' required/>
                            <option value='1'>Ativo</option>
                            <option value='2'>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Reserva:&nbsp;</label>
                        <input type='checkbox'  id='ic_reserva' name='ic_reserva' >
                    </div>        
                </div>
                <p>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class="col-md-6">
                         <table class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th width="30%" style="font-size: 12px">Dia Semana</th>
                                    <th width="70%" colspan="4" style="font-size: 12px">Horário de Trabalho</th>
                                </tr>
                                <tr align="center">
                                    <td></td>
                                    <td aling="center" style="font-size: 12px">ENTRADA</td>
                                    <td aling="center" colspan="2" style="font-size: 12px">INTEVALO</td>
                                    <td aling="center" style="font-size: 12px">SAIDA</td>
                                </tr>
                                
                                <tr align="center">
                                    <td style="font-size: 12px">SEGUNDA</td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_entrada_seg' name='ds_entrada_seg' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_ida_intervalo_seg' name='ds_ida_intervalo_seg' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_volta_intervalo_seg' name='ds_volta_intervalo_seg' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_saida_seg' name='ds_saida_seg' ></td>
                                </tr>
                                <tr align="center">
                                    <td style="font-size: 12px">TERÇA</td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_entrada_ter' name='ds_entrada_ter' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_ida_intervalo_ter' name='ds_ida_intervalo_ter' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_volta_intervalo_ter' name='ds_volta_intervalo_ter' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_saida_ter' name='ds_saida_ter' ></td>
                                </tr>
                                <tr align="center">
                                    <td style="font-size: 12px">QUARTA</td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_entrada_qua' name='ds_entrada_qua' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_ida_intervalo_qua' name='ds_ida_intervalo_qua' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_volta_intervalo_qua' name='ds_volta_intervalo_qua' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_saida_qua' name='ds_saida_qua' ></td>
                                </tr>
                                <tr align="center">
                                    <td style="font-size: 12px">QUINTA</td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_entrada_qui' name='ds_entrada_qui' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_ida_intervalo_qui' name='ds_ida_intervalo_qui' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_volta_intervalo_qui' name='ds_volta_intervalo_qui' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_saida_qui' name='ds_saida_qui' ></td>
                                </tr>
                                <tr align="center">
                                    <td style="font-size: 12px">SEXTA</td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_entrada_sex' name='ds_entrada_sex' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_ida_intervalo_sex' name='ds_ida_intervalo_sex' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_volta_intervalo_sex' name='ds_volta_intervalo_sex' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_saida_sex' name='ds_saida_sex' ></td>
                                </tr>
                                <tr align="center">
                                    <td style="font-size: 12px">SABADO</td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_entrada_sab' name='ds_entrada_sab' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_ida_intervalo_sab' name='ds_ida_intervalo_sab' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_volta_intervalo_sab' name='ds_volta_intervalo_sab' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_saida_sab' name='ds_saida_sab' ></td>
                                </tr>
                                <tr align="center">
                                    <td style="font-size: 12px">DOMINGO</td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_entrada_dom' name='ds_entrada_dom' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_ida_intervalo_dom' name='ds_ida_intervalo_dom' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_volta_intervalo_dom' name='ds_volta_intervalo_dom' ></td>
                                    <td><input type='text' class='form-control form-control-sm' maxlength="5" id='ds_saida_dom' name='ds_saida_dom' ></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    
                     <div class='col-md-3'>
                        <label for='matricula'>Data Demissão:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='dt_demissao' name='dt_demissao'  >
                    </div>
                </div>
                
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Dados de Contato do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>               
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                     <div class='col-md-2'>
                        <label for='ds_cel'>Cel:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'  maxlength="14" id='ds_cel' name='ds_cel'  required>
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp'>Whatsapp:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_whatsapp' name='ic_whatsapp' required/>
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
                <!--<input type='hidden' class='form-control form-control-sm' maxlength="14" id='ds_cel2' name='ds_cel2'  >
                <input type='hidden' class='form-control form-control-sm' maxlength="14" id='ds_cel3' name='ds_cel3'  >
                <input type='hidden' class='form-control form-control-sm' maxlength="14" id='ic_whatsapp2' name='ic_whatsapp2'  >
                <input type='hidden' class='form-control form-control-sm' maxlength="14" id='ic_whatsapp3' name='ic_whatsapp3'  >-->
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cpf'>CPF:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="14" id='ds_cpf' name='ds_cpf' >
                    </div>
                         
                    <div class='col-md-3'>
                        <label for='ds_rg'>Pis:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm'  id='ds_pis' name='ds_pis' >
                    </div>   
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                   
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
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>Certificado Reservista:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_certificado_reservista' name='ds_certificado_reservista' >
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
         
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ic_whatsapp2'>Nome Cônjuge:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nome_conjuge' name='ds_nome_conjuge'  >
                    </div>
                </div>                     
               <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>     
                        <div class='col-md-2'>
                        <label for='generos_pk'>Estado Civil:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='estado_civil' name='estado_civil'>
                            <option></option>
                            <option value="1">Solteiro</option>
                            <option value="2">Casado</option>
                            <option value="3">Separado</option>
                            <option value="4">Divorciado</option>
                            <option value="5">Viuvo</option>
                        </select>
                    </div>
                </div>     
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                <br>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                             <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblNomeFilho">
                                <thead>
                                    <tr>
                                        <th>Nome Filho</th>
                                        <th>CPF Filho</th>
                                        <th>Data Nasci. Filho</th>
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
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Dados Bancários</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>                    
               <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>     
                        <div class='col-md-2'>
                        <label for='generos_pk'>Tipo Conta:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='tipo_conta_bancaria' name='tipo_conta_bancaria'>
                            <option></option>
                            <option value="1">Conta Corrente</option>
                            <option value="2">Conta Poupança</option>
                        </select>
                    </div>
                </div> 
               <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>     
                        <div class='col-md-2'>
                        <label for='generos_pk'>Banco:&nbsp;</label>
                        <select class='form-control form-control-sm chzn-select'  id='bancos_pk' name='bancos_pk'>
                            <option></option>
                        </select>
                    </div>
                </div> 
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cel2'>Agência:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_agencia' maxlength="4" name='ds_agencia'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Conta:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="5" id='ds_conta' name='ds_conta'  >
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_whatsapp2'>Digito:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="1"  id='ds_digito' maxlength="1" name='ds_digito'  >
                    </div>
                </div>
                <p>
                <br>
                <div class="row">
                    <div class='col-md-2'>
                        &nbsp;
                    </div> 
                    <div class="col-md-10">
                        <h5>Endereço do Colaborador</h5>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    </div>
                </div>      
     
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cep'>CEP:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="9" id='ds_cep' name='ds_cep' >
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ds_endereco'>Endereço:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_endereco' name='ds_endereco' >
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
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

     
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="qualificacao" role="tabpanel" aria-labelledby="qualificacao-tab">
                <br>
                <div class="row">
                    <div class="col-md-12">
                         <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblQualificacao">
                            <thead>
                                <tr>
                                    <th>Qualificação</th>
                                    <th>Possui Treinamento</th>
                                    <th>Possui Certificado</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="beneficios" role="tabpanel" aria-labelledby="beneficios-tab">
                <br>
                <div class="row">
                    <div class="col-md-12">
                         <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblBeneficio">
                            <thead>
                                <tr>
                                    <th>Benefício</th>
                                    <th>Valor</th>
                                    <th>Observação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="afastamento" role="tabpanel" aria-labelledby="afastamento-tab">
                <br>
                <div class="row">
                    <div class="col-md-12">
                         <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblAfastamento">
                            <thead>
                                <tr>
                                    <th>Tipo Apontamento</th>
                                    <th>Data Início</th>
                                    <th>Data Fim</th>
                                    <th>Observação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="cursos" role="tabpanel" aria-labelledby="cursos-tab">
                <br>
                <div class="row">
                    <div class="col-md-12">
                         <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblCurso">
                            <thead>
                                <tr>
                                    <th>Exame/Curso</th>
                                    <th>Data Execução</th>
                                    <th>Data Validade</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                
            <!--Materiais-->
            <div class="tab-pane fade" id="materiais" role="tabpanel" aria-labelledby="materiais-tab">
                <br>
                <?php  include("menu_colaborador_inc_conjunto_material_res_form.php"); ?>
                
            </div>
            <div class="tab-pane fade" id="documentacao" role="tabpanel" aria-labelledby="documentacao-tab">
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblDocumentos">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Documento</th>
                                    <th>Observação</th>
                                    <th>Nome Original</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade bd-example-modal-lg" id="janela_documentos" >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="janela_contatosLabel">Novo Documento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">                                    
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>
                                
                                <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                                
                                <div class='col-md-8'>
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Escolha o Arquivo</span>
                                        <input id="fileupload"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php">

                                    </span>
                                    <br>
                                    <div id="alert_documento" style="display:none" >
                                        <strong style="color: red">Selecione um arquivo</strong>
                                    </div>
                                    <br>
                                    <div id="progress" class="progress">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                    <div id="files" class="files"></div>
                                    <!---->
                                    <div class="row" id="rowFotos"></div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    &nbsp;
                                </div>
                                <div class="col-md-8">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblArquivos">
                                        <thead>
                                            <tr>
                                                <th>Documento</th>
                                                <th>Nome Original</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-md-2">
                                    &nbsp;
                                </div>

                                <div class='col-md-6'>
                                    <label for='ds_obs_doc'>Observação: </label>
                                    <input type='text' class='form-control form-control-sm'  id='ds_obs_doc' name='ds_obs_doc'>
                                    <input type="hidden" name="ds_nome_original" id="ds_nome_original"/>
                                    <input type="hidden" name="ds_documento" id="ds_documento"/>

                                </div>
                            </div>                                                    
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary" id="cmdEnviarDocumento"  name="cmdEnviarDocumento">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
            </div>
            <div class="tab-pane fade" id="controle_ponto" role="tabpanel" aria-labelledby="controle_ponto-tab">
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <label>Registrar Ponto</label>
                    </div>
                    <div class="col-md-1">
                        
                        <input type="checkbox" id="ic_registrar_ponto">
                    </div>
                </div>
                
                <br>
                <div class='row'>
                    <div class='col-md-12'>
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id='tblAgendaTurno'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Domingo</th>
                                    <th>Segunda</th>
                                    <th>Terça</th>
                                    <th>Quarta</th>
                                    <th>Quinta</th>
                                    <th>Sexta</th>
                                    <th>Sabado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <input type="hidden" name="colaborador_ponto_pk" id="colaborador_ponto_pk">
                                    <td>Dia</td>
                                    <td>
                                        <input type='checkbox' name='ic_dom' id='ic_dom' />
                                    </td>
                                    <td>
                                        <input type='checkbox' name='ic_seg' id='ic_seg' />
                                    </td>
                                    <td>
                                        <input type='checkbox' name='ic_ter' id='ic_ter' />
                                    </td>
                                    <td>
                                        <input type='checkbox' name='ic_qua' id='ic_qua' />
                                    </td>
                                    <td>
                                        <input type='checkbox' name='ic_qui' id='ic_qui' />
                                    </td>
                                    <td>
                                        <input type='checkbox' name='ic_sex' id='ic_sex' />
                                    </td>
                                    <td>
                                        <input type='checkbox' name='ic_sab' id='ic_sab' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Turno</td>
                                    <td>
                                        <select class='form-control form-control-sm'  id='dom_turnos_pk' name='dom_turnos_pk'>
                                            <option></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class='form-control form-control-sm'  id='seg_turnos_pk' name='seg_turnos_pk'>
                                            <option></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class='form-control form-control-sm'  id='ter_turnos_pk' name='ter_turnos_pk'>
                                            <option></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class='form-control form-control-sm'  id='qua_turnos_pk' name='qua_turnos_pk'>
                                            <option></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class='form-control form-control-sm'  id='qui_turnos_pk' name='qui_turnos_pk'>
                                            <option></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class='form-control form-control-sm'  id='sex_turnos_pk' name='sex_turnos_pk'>
                                            <option></option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class='form-control form-control-sm'  id='sab_turnos_pk' name='sab_turnos_pk'>
                                            <option></option>
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Hora</td>
                                    <td>
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_entrada_dom' id='hr_entrada_dom' />
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_saida_dom' id='hr_saida_dom' />
                                    </td>
                                    <td>
                                        <input   class='form-control form-control-sm' maxlength="5" type='type' name='hr_entrada_seg' id='hr_entrada_seg' />
                                        <input   class='form-control form-control-sm' maxlength="5" type='type' name='hr_saida_seg' id='hr_saida_seg' />
                                    </td>
                                    <td>
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_entrada_ter' id='hr_entrada_ter' />
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_saida_ter' id='hr_saida_ter' />
                                    </td>
                                    <td>
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_entrada_qua' id='hr_entrada_qua' />
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_saida_qua' id='hr_saida_qua' />
                                    </td>
                                    <td>
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_entrada_qui' id='hr_entrada_qui' />
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_saida_qui' id='hr_saida_qui' />
                                    </td>
                                    <td>
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_entrada_sex' id='hr_entrada_sex' />
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_saida_sex' id='hr_saida_sex' />
                                    </td>
                                    <td>
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_entrada_sab' id='hr_entrada_sab' />
                                        <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_saida_sab' id='hr_saida_sab' />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div id="alert" style="display:none" >
                    <strong style="color: red">Selecione o Turno</strong>
                </div>
                
            </div>
        </div>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>                
                

            </div>
        </div>
    </form>
</div>

<?
require_once "../inc/php/footer.php";
?>

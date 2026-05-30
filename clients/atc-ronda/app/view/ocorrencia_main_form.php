<?
require_once "../inc/php/header.php";
?>

<script src="ocorrencia_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Ocorrências</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form method="post">
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='clientes_pk'>Lead</label>
                <select class='form-control form-control-sm chzn-select'  id='ds_lead' name='ds_lead'>
                    <option></option>
                </select>
            </div>
            <div class='col-md-4'>
                <label for='clientes_pk'>Agendado p/ Equipe</label>
                <select class='form-control form-control-sm chzn-select'  id='equipes_pk_res' name='equipes_pk_res'>
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">                        
            <div class='col-md-2'>
                &nbsp;                                             
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Colaborador&nbsp;</label>
                <select class=" form-control form-control-sm chzn-select" id="colaborador_pk" name="colaborador_pk"><option></option></select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Tipo Ocorrência&nbsp;</label>
                <select class='form-control form-control-sm'  id='tipo_ocorrencia_res_pk' name='tipo_ocorrencia_res_pk' />
                    <option></option>
                </select>
            </div>  
           <div class="col-md-2">
                <label for="ic_status">Status Ocorrências:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value=""></option>
                    <option value="1">Aberta</option>
                    <option value="2">Fechada</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Usuário de Cadastro&nbsp;</label>
                <select class='form-control form-control-sm'  id='usuario_cadastro_res_pk' name='usuario_cadastro_res_pk' />
                    <option></option>
                </select>    
            </div> 
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Data Abertura Oc Ini</label>
                    <input type='text' class=" form-control form-control-file" id="dt_cadastro" name="dt_cadastro"/>
                </div>
            </div>  
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Data Abertura Oc Fim</label>
                    <input type='text' class=" form-control form-control-file" id="dt_cadastro_fim" name="dt_cadastro_fim"/>
                </div>    
            </div>      
        </div>        
        <div class="row">
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Dt Prazo Execução Ini</label>
                    <input type='text' class=" form-control form-control-file" id="dt_prazo_execucao_ini" name="dt_prazo_execucao_ini"/>
                </div>
            </div>  
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Dt Prazo Execução Fim</label>
                    <input type='text' class=" form-control form-control-file" id="dt_prazo_execucao_fim" name="dt_prazo_execucao_fim"/>
                </div>    
            </div>      
            <div class='col-md-2'>
                    <label for='tipo_ocorrencia_pk'>Status&nbsp;</label>
                    <select class='form-control form-control-sm'  id='ic_status_fechamento_pesq' name='ic_status_fechamento_pesq' />
                        <option ></option>
                    <option value='1'>Não lido</option>
                    <option value='2'>Dentro do prazo</option>
                    <option value='3'>Chamado vencido</option>
                    <option value='4'>Recusado</option>
                    <option value='5'>Finalizado</option>
                    </select>   
            </div>      
        </div>        
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>  &nbsp;&nbsp;&nbsp;            
                <button type="button" class="btn btn-link" id="cmdIncluirNovaOcLeadCombo"><img src="../img/incluir.png" width=40 height=40>Incluir</button>                
            </div>
        </div>
        
    </form>
    

<div class="row" > 
    <div class="col-md-1 ">
        <div class="text-center" >
            
        </div>
    </div> 
    <div class="col-md-2 "style="background-color:#FFFF00">
        <div class="text-center" >
            <font>Não lido</font> 
        </div>
    </div> 
    <div class="col-md-2 " style="background-color:1dc2ff;">
        <div class="text-center" >
            <font> Dentro do prazo</font> 
        </div>
    </div> 
    <div class="col-md-2 "  style="background-color:#FF4500">
        <div class="text-center">
             <font >Chamado vencido</font> 
        </div>
    </div> 
   <div class="col-md-2 "  style="background-color:fab14c;">
        <div class="text-center">
             <font >Recusado</font> 
        </div>
    </div> 
    <div class="col-md-2 "  style="background-color:#47e51f">
        <div class="text-center">
             <font >Finalizado</font> 
        </div>
    </div> 

</div>
<br>
<hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'><p></p>
<br>
</div>
<div class="row">
    <div class="col-md-1">
        &nbsp;
    </div>
    <div class="col-md-10">
    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
        <thead>
            <tr>
                <th>Cód</th>
                <th>Lead</th>                    
                <th>Colaborador</th>                    
                <th>Dt Cad OC</th>
                <th>Dt Execução</th>
                <th>Descr Execução</th>
                <th>Status</th>
                <th>ic_recusa</th>
                <th>Dt Fech OC</th>
                <th>Tipo OC</th>
                <th>Tipo Ocorrência_pk</th>
                <th>Descr OC</th> 
                <th>Usuário Cad</th>                                    
                <th>Agendado Para</th>
                <th>Dt Retorno</th>
                <th>Descr Retorno</th>
                <th>Dt Fech Retorno</th>  
                <th>Descr Recusa</th>  
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table> 
    </div>    
    <div class="col-md-1">
        &nbsp;
    </div>
</div>
<!--form id="form_contato" class="form">
<!-- Inicio janeja modal para edicao do registro -->
<!--div class="modal fade bd-example-modal-lg" id="janela_enviar_email" >
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Enviar E-mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

                <div class="modal-body">

                    <input type='hidden' class='form-control form-control-sm'  id='dt_ocorrencia' name='dt_ocorrencia'>
                    <input type='hidden' class='form-control form-control-sm'  id='ds_tipo_oc' name='ds_tipo_oc'>
                    <input type='hidden' class='form-control form-control-sm'  id='ds_oc' name='ds_oc'>
                    <input type='hidden' class='form-control form-control-sm'  id='dt_termino_oc' name='dt_termino_oc'>

                    <div class="row">
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblEnviarEmail">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>                    
                                    <th>E-mail</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table> 
                        </div>    
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                    </div>                                                 
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-secondary" id="cmdEnviarEmail"  name="cmdEnviarEmail">Enviar E-mail</button>
                    </div>

                </div>
            </div>
        </div>   
    </div>            
</form-->
<div class="container">    
    <form id="form_ocorrencia" class="form">
        <div class="modal fade bd-example-modal-lg" id="janela_ocorrencia" >
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Nova Ocorrência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                                    
                    <div class="row">
                        <div class='col-md-2'>
                            &nbsp;                                             
                        </div>
                        <div class='col-md-6'>
                            <label for='clientes_pk'>Lead</label>
                            <select class='form-control form-control-sm chzn-select'  id='leads_pk' name='leads_pk'>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class='row' id="alert_ds_lead" style="display:none">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe Lead</strong>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class='col-md-2'>
                            &nbsp;                                             
                        </div>
                        <div class='col-md-4'>
                            <label for='tipo_ocorrencia_pk'>Colaborador&nbsp;</label>
                            <select class=" form-control form-control-sm chzn-select" id="colaborador_pk_ocorrencia_ins" name="colaborador_pk_ocorrencia_ins"><option></option></select>
                        </div>
                    </div>
                    <br> 
                    <div class="row">
                        <input type="hidden" name="ds_tipo_ocorrencia" id="ds_tipo_ocorrencia"/>
                        <input type='hidden' id='ocorrencias_pk' name='ocorrencias_pk'/>
                        <input type='hidden' id='ic_fechar_ocorrencia_auto' name='ic_fechar_ocorrencia_auto'/>
                        <input type='hidden' id='ic_abrir_oc_combo_lead' name='ic_abrir_oc_combo_lead'/>
                        
                        <div class='col-md-2'>
                            &nbsp;                                             
                        </div>
                        <div class='col-md-6'>
                            <label for='tipo_ocorrencia_pk'>Tipo Ocorrência&nbsp;</label>
                            <select class='form-control form-control-sm'  id='tipo_ocorrencia_pk' name='tipo_ocorrencia_pk' />
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>                                                             
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="ds_ocorrencia">Descrição Ocorrência:</label>
                                <textarea class=" form-control form-control-file" id="ds_ocorrencia" name="ds_ocorrencia"></textarea>
                            </div>
                        </div>                                                             
                    </div>  
                    <div class="row">                        
                        <div class='col-md-2'>
                            &nbsp;                                             
                        </div>
                        <div class='col-md-3'>
                            <label for='tipo_ocorrencia_pk'>Dt Prazo Execução&nbsp;</label>
                            <input type='text' class=" form-control form-control-file" id="dt_prazo_execucao" name="dt_prazo_execucao"/>
                        </div>
                    </div>
                    <div class='row' id="alert_dt_prazo_execucao" style="display:none">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-8'>
                            <strong style="color: red">Por favor, informe a data de execução!</strong>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>                                                             
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="ds_ocorrencia">Descrição Execução:</label>
                                <textarea class=" form-control form-control-file" id="obs_execucao" name="obs_execucao"></textarea>
                            </div>
                        </div>                                                             
                    </div>
                    <div class="row">                        
                        <div class='col-md-2'>
                            &nbsp;                                             
                        </div>
                        <div class='col-md-6'>
                            <label for='tipo_ocorrencia_pk'>Recusar chamado&nbsp;</label>
                            <input type='checkbox' class='form-check-label'   id='ic_recusa' name='ic_recusa'>
                            <!--<select class='form-control form-control-sm'  id='ic_status_fechamento' name='ic_status_fechamento' />
                                <option value='1'>Em Execu��o</option>
                                <option value='2'>Fechado</option>
                                <option value='3'>Recusado</option>
                            </select>-->
                        </div>
                    </div>
                    <div id="div_ds_recusa" style="display:none">
                        <div class="row">
                             <div class='col-md-2'>
                                 &nbsp;
                             </div>                                                             
                             <div class='col-md-6'>
                                 <div class="form-group">
                                     <label for="ds_ocorrencia">Descrição Recusa:</label>
                                     <textarea class=" form-control form-control-file" id="obs_recusa" name="obs_recusa"></textarea>
                                 </div>
                             </div>                                                             
                         </div>
                    </div>   
                    <div class='row' id="alert_ds_recusa_ocorrencia" style="display:none">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-8'>
                            <strong style="color: red">Por favor, informe o motivo da recusa !</strong>
                        </div>
                    </div>
                    <br>  
                    <div class="row">
                        <div class='col-md-2'>
                             
                        </div>
                        <div class='col-md-3'>
                            Fechar Ocorrência:
                        </div>                                                              
                        <div class='col-md-1'>
                            <input type='checkbox' class='form-check-label'   id='dt_fechamento' name='dt_fechamento'>
                        </div>                                                              
                    </div>
                    
                    <div class="row">
                        <div class='col-md-2'>
                             
                        </div>
                        <div class='col-md-3'>
                            Agendar Retorno:
                        </div>                                                              
                        <div class='col-md-1'>
                            <input type='hidden' id='agenda_retorno_pk' name='agenda_retorno_pk'/>
                            <input type='checkbox' class='form-check-label'  id='agenda_retorno' name='agenda_retorno'>
                        </div>                                                              
                    </div>
                    <div class="row">
                        <div class='col-md-2'>
                             
                        </div>
                        <div class='col-md-3'>
                            Incluir Documento:
                        </div>                                                              
                        <div class='col-md-1'>
                            <input type='checkbox' class='form-check-label'  id='ic_docs' name='ic_docs'>
                        </div>                                                              
                    </div>
                    <div id="doc" style="display:none">
                        <div class="row" >
                            <input type="hidden" name="ds_nome_original_oc" id="ds_nome_original_oc"/>
                            
                            <input type="hidden" name="ds_documento_oc" id="ds_documento_oc"/>
                            <div class='col-md-2'>
                                &nbsp;
                            </div>
                            <div class='col-md-8'>
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Escolha o Arquivo</span>
                                    <input id="fileuploadOc"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php">

                                </span>
                                <br>
                                <div id="alert_documento" style="display:none" >
                                    <strong style="color: red">Selecione um arquivo</strong>
                                </div>
                                <br>
                                <div id="progressOc" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                <div id="files" class="files"></div>
                                <!---->
                                <div class="row" id="rowFotos"></div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblDocumentosOc">
                                    <thead>
                                        <tr>
                                            <th>Cód</th>
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
                    </div>
                    <!--Agenda Retornos-->
                    <div id='agenda_visible'>
                        <hr>
                        <input type="hidden" class="form-control form-control-file" id="tipo_lembrete_pk" name="tipo_lembrete_pk"/>
                        <!--div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="dt_retornoa">Tipo Lembrete:</label>
                                    <select class="form-control form-control-file" id="tipo_lembrete_pk" name="tipo_lembrete_pk">
                                        <option> </option>
                                        <option value="1">Lembrete</option>
                                        <option value="2">WhatsApp</option>
                                    </select>
                                </div>
                            </div>  
                        </div-->                 
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="dt_retornoa">Data Retorno:</label>
                                    <input type='text' class=" form-control form-control-file" id="agenda_dt_retorno" name="agenda_dt_retorno"/>
                                </div>
                            </div>  
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="hr_retorno">Hora Retorno:</label>
                                    <input type='text' class=" form-control form-control-file" id="agenda_hr_retorno" name="agenda_hr_retorno"/>
                                </div>    
                            </div>  
                        </div>                 
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                      
                            <div class='col-md-2'>
                                <label for='ic_usuario'>Usuário:&nbsp;</label>
                                <input type='radio' class="btn btn-secondary" id="ic_usuario" name="ic_usuario"/>
                            </div>
                                           <div class='col-md-2'>
                                <label for='ic_equipe'>Equipe:&nbsp;</label>
                                <input type='radio' class="btn btn-secondary" id="ic_equipe" name="ic_equipe"/>
                            </div>   
                            <div class='col-md-4'>
                                <div id='agenda_responsavel_visible'>                                   
                                    <label for='agenda_responsavel_pk'>Lista Usuários&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='agenda_responsavel_pk' name='agenda_responsavel_pk' />
                                        <option></option>
                                    </select>                                   
                                </div>    
                                <div id='agenda_equipe_visible'> 
                                    <label for='agenda_equipes_pk'>Lista Equipes&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='agenda_equipes_pk' name='agenda_equipes_pk' />
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>        
                        <!--<div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="agenda_ds_retorno">Descrição Retorno:</label>
                                    <textarea class=" form-control form-control-file" id="agenda_ds_retorno" name="agenda_ds_retorno"></textarea>
                                </div>
                            </div>                                                             
                        </div>-->
                    </div>                    
                    <!--EDIÇÃO RETORNO-->
                    <div id='edit_agenda_visible'>
                        <hr>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Data Retorno:</label>
                                    <div class=" form-control form-control-file" disabled id="edit_agenda_dt_retorno" name="edit_agenda_dt_retorno"></div>
                                </div>
                            </div> 
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Hora Retorno:</label>
                                    <div class=" form-control form-control-file" disabled id="edit_agenda_hr_retorno" name="edit_agenda_hr_retorno"></div>
                                </div>
                            </div>
                            
                        </div> 
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-3'>
                                <input type="hidden" class="form-control form-control-file" id="tipo_lembrete_pk" name="tipo_lembrete_pk"/>
                                <!--div class="form-group">
                                    <label for="dt_retornoa">Tipo Lembrete:</label>
                                    <select class="form-control form-control-file" id="edit_tipo_lembrete_pk" name="tipo_lembrete_pk">
                                        <option> </option>
                                        <option value="1">Lembrete</option>
                                        <option value="2">WhatsApp</option>
                                    </select>
                                </div-->
                            </div>
                            
                        </div> 
                        <div id='edit_agenda_responsavel_visible'>
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>                                                             
                                <div class='col-md-4'>
                                    <label for='agenda_responsavel_pk'>Usuário Responsável&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='edit_agenda_responsavel_pk' name='edit_agenda_responsavel_pk' />
                                        <option></option>
                                    </select>
                                </div>                                                             
                            </div>
                        </div>
                        <div id='edit_agenda_equipe_visible'>
                            <div class="row">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div>                                                             
                                <div class='col-md-4'>
                                    <label for='agenda_equipes_pk'>Equipe Responsável&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='edit_agenda_equipes_pk' name='edit_agenda_equipes_pk' />
                                        <option></option>
                                    </select>
                                </div>                                                             
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="agenda_ds_retorno">Descrição Retorno:</label>
                                    <textarea disabled class=" form-control form-control-file" id="agenda_ds_retorno" name="agenda_ds_retorno"></textarea>
                                </div>
                            </div>                             
                        </div>
                        <br>
                        
                        <div class="row">
                            <div class='col-md-2'>

                            </div>
                            <div class='col-md-3'>
                                Fechar Retorno:
                            </div>                                                              
                            <div class='col-md-1'>
                                <input type='checkbox' class='form-check-label' maxlength="10"  id='dt_termino_retorno' name='dt_termino_retorno'>
                            </div>                                                              
                        </div>
                        <!--<div class="row">
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                             
                            <div class='col-md-4'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Data Termino Retorno:</label>
                                    <input type='text' class=" form-control form-control-file" id="edit_agenda_dt_retorno_termino" name="edit_agenda_dt_retorno_termino"/>
                                </div>
                            </div> 
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Hora Termino Retorno:</label>
                                    <input type='text' class=" form-control form-control-file" id="edit_agenda_hr_retorno_termino" name="edit_agenda_hr_retorno_termino"/>
                                </div>
                            </div>  
                        </div>-->
                    </div>  
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="cmdEnviarOcorrencia"  name="cmdEnviarOcorrencia">Salvar</button>
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

<?
require_once "../inc/php/header.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<script src="menu_ocorrencia_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <h2><div class="ds_usuario" ></div></h2>
        </div>
    </div>
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_colaborador">Posto de Trabalho:&nbsp;</label>
                <select class="form-control form-control-sm chzn-select" id="leads_usuarios_pk" >
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='clientes_pk'>Data Cadastro</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <input class='form-control form-control-sm' id='dt_cadastro_ini_pesq' name='dt_cadastro_ini_pesq'/>
            </div>
            <div class='col-md-2'>
                <input class='form-control form-control-sm' id='dt_cadastro_fim_pesq' name='dt_cadastro_fim_pesq'/>
            </div>
        </div>        
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='responsavel_pk'>Tipo Ocorrência:&nbsp;</label>
                <select class='form-control form-control-sm'  id='tipo_ocorrencia_pk_pesq' name='tipo_ocorrencia_pk_pesq' />
                    <option></option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='responsavel_pk'>Ocorrência:&nbsp;</label>
                <select class='form-control form-control-sm'  id='oc_aberta_fechado' name='oc_aberta_fechado' />
                    <option></option>
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
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
                &nbsp;
                <button type="button" class="btn btn-link" id="cmdIncluirOcorrencia"><img src="../img/incluir.png" width=40 height=40>Novo</button>
            </div>
        </div>
    </form>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <br>    
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
    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblOcorrencia">
        <thead>
            <tr>
                <th>Cód</th>
                <th>Lead</th>                    
                <th>Dt Cad OC</th>
                <th>Dt Execução</th>
                <th>Status</th>
                <th>Dt Fech OC</th>
                <th>Tipo OC</th>
                <th>Tipo Ocorrência_pk</th>
                <th>Descr OC</th> 
                <th>Usuário Cad</th>                                    
                <th>Agendado Para</th>
                <th>Dt Retorno</th>
                <th>Descr Retorno</th>
                <th>Dt Fech Retorno</th>  
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
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    
    <hr><br>   
</div>
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
                        <div class="col-md-2">
                            &nbsp;
                        </div>
                        <div class='col-md-6'>
                            <label for="ds_colaborador">Posto de Trabalho:&nbsp;</label>
                            <select class="form-control form-control-sm" id="leads_ocorrencia_pk" >
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="ds_tipo_ocorrencia" id="ds_tipo_ocorrencia"/>
                        <input type='hidden' id='ocorrencias_pk' name='ocorrencias_pk'/>
                        <input type='hidden' id='ic_fechar_ocorrencia_auto' name='ic_fechar_ocorrencia_auto'/>
                        <input type='hidden' id='leads_pk' name='leads_pk'/>
                        
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
                    <div class='row' id="div_cliente" style="display:none">
                        <div class="row">                        
                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-6'>
                                <label for='tipo_ocorrencia_pk'>Status Fechamento&nbsp;</label>
                                <select class='form-control form-control-sm'  id='ic_status_fechamento' name='ic_status_fechamento' />
                                    <option value='1'>Aberto</option>
                                    <option value='2'>Fechado</option>
                                    <option value='3'>Recusado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">                        
                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-6'>
                                <label for='tipo_ocorrencia_pk'>Obs Status&nbsp;</label>
                                <textarea type='text' class=" form-control form-control-file" id="obs_status" name="obs_status"></textarea>
                            </div>
                        </div>                    
                        <div class="row">                        
                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-3'>
                                <label for='tipo_ocorrencia_pk'>Dt Prazo Execução&nbsp;</label>
                                <input type='text' class=" form-control form-control-file" id="dt_prazo_execucao" name="dt_prazo_execucao" disabled/>
                            </div>
                        </div>
                        <br>
                        <div class="row">                        
                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-6'>
                                <label for='tipo_ocorrencia_pk'>Obs Execução&nbsp;</label>
                                <textarea type='text' class=" form-control form-control-file" id="obs_execucao" name="obs_execucao"></textarea>
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
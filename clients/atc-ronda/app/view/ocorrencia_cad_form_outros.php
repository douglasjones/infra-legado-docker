<script src="ocorrencia_cad_form_outros.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>

    <!-- Custom fonts for this template-->
    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
	
    <?require_once '../inc/php/scripts.php';?>
</head>
<form id="form_ocorrencia" class="form">
    <div class="modal fade bd-example-modal-lg" id="janela_ocorrencia_cad" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="m-0 font-weight-bold text-primary">Lead - Ocorrência</h6>   
                    <div align='right'>
                        <button type="submit" class="btn btn-primary btn-sm" id="cmdEnviarOcorrencia"  name="cmdEnviarOcorrencia">Salvar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
                    </div>
                </div>                
                <div class="modal-body">
                    <div class="row">
                        <input type='hidden' id='ocorrencias_pk' name='ocorrencias_pk'/>
                        <input type='hidden' id='ic_fechar_ocorrencia_auto' name='ic_fechar_ocorrencia_auto'/>
                        <input type='hidden' id='ds_tipo_ocorrencia' name='ds_tipo_ocorrencia'/>
                        <input type='hidden' id='ds_sem_interesse' name='ds_sem_interesse'/>
                        <input type='hidden' id='classificacao_lead_pk' name='classificacao_lead_pk'/>
                        
                        <div class='col-md-6'>
                            <label for='tipo_ocorrencia_pk'>Tipo Ocorrência&nbsp;</label>
                            <select class='form-control form-control-sm'  id='tipos_ocorrencias_pk' name='tipos_ocorrencias_pk'>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">                                                       
                        <div class='col-md-8'>
                            <div class="form-group">
                                <label for="ds_ocorrencia">Descrição Ocorrência:</label>
                                <textarea class="form-control form-control-sm" rows="3" id="ds_ocorrencia" name="ds_ocorrencia"></textarea>
                            </div>
                        </div>                                                             
                    </div>
                    <div class="row">
                        <div class='col-md-3'>
                            Agendar Retorno:
                        </div>                                                              
                        <div class='col-md-1'>
                            <input type='hidden' id='agenda_retorno_pk' name='agenda_retorno_pk'/>
                            <input type='checkbox' class='form-check-label' maxlength="10"  id='agenda_retorno' name='agenda_retorno'>
                        </div>                                                              
                    </div>
                    <!--Agenda Retornos-->
                    <div id='agenda_visible' style="display:none">
                        <p>
                        <div class="row">    
                            <div class="col-md-12">
                                <h5>Agendar Retorno</h5>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            </div>        
                        </div>   
                        <div class="row">                                                         
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="dt_retornoa">Data Retorno:</label>
                                    <input type='text' class="form-control form-control-sm" id="agenda_dt_retorno" name="agenda_dt_retorno"/>
                                </div>
                            </div>  
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="hr_retorno">Hora Retorno:</label>
                                    <input type='text' class="form-control form-control-sm" id="agenda_hr_retorno" name="agenda_hr_retorno"/>
                                </div>    
                            </div>  
                        </div>     
                        <div class="row">                                                          
                            <div class='col-md-2'>
                                <label for='ic_usuario'>Usuário:&nbsp;</label>
                                <input type='radio' class="form-check-label" id="ic_usuario" name="ic_usuario"/>
                            </div>
                                        <div class='col-md-2'>
                                <label for='ic_equipe'>Equipe:&nbsp;</label>
                                <input type='radio' class="form-check-label" id="ic_equipe" name="ic_equipe"/>
                            </div>   
                            <div class='col-md-4'>
                                <div id='agenda_responsavel_visible'>                                   
                                    <label for='agenda_responsavel_pk'>Lista Usuários&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='agenda_responsavel_pk' name='agenda_responsavel_pk' >
                                        <option></option>
                                    </select>                                   
                                </div>    
                                <div id='agenda_equipe_visible'> 
                                    <label for='agenda_equipes_pk'>Lista Equipes&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='agenda_equipes_pk' name='agenda_equipes_pk'>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>   
                        <p>
                        <div class="row">                 
                            <div class="col-md-12">                            
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            </div>        
                        </div>                                              
                    </div>
                    <!--EDIÇÃO RETORNO-->
                    <div id='edit_agenda_visible' style="display:none">
                        <p>
                        <div class="row">    
                            <div class="col-md-12">
                                <h6>Agendar Retorno</h6>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            </div>        
                        </div>   
                        <div class="row">                                                                          
                            <div class='col-md-3'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Data Retorno:</label>
                                    <div class=" form-control form-control-sm" disabled id="edit_agenda_dt_retorno" name="edit_agenda_dt_retorno"></div>
                                </div>
                            </div> 
                            <div class='col-md-2'>
                                <div class="form-group">
                                    <label for="ds_ocorrencia">Hora Retorno:</label>
                                    <div class="form-control form-control-sm" disabled id="edit_agenda_hr_retorno" name="edit_agenda_hr_retorno"></div>
                                </div>
                            </div>        
                        </div> 
                        <div id='edit_agenda_responsavel_visible'>
                            <div class="row">                                                  
                                <div class='col-md-4'>
                                    <label for='agenda_responsavel_pk'>Usuário Responsável&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='edit_agenda_responsavel_pk' name='edit_agenda_responsavel_pk'>
                                        <option></option>
                                    </select>
                                </div>                                                             
                            </div>
                        </div>
                        <div id='edit_agenda_equipe_visible'>
                            <div class="row">                                                                  
                                <div class='col-md-4'>
                                    <label for='agenda_equipes_pk'>Equipe Responsável&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='edit_agenda_equipes_pk' name='edit_agenda_equipes_pk'>
                                        <option></option>
                                    </select>
                                </div>                                                             
                            </div>
                        </div>
                        <div class="row">                                                       
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="agenda_ds_retorno">Descrição Retorno:</label>
                                    <textarea disabled class=" form-control form-control-file" id="agenda_ds_retorno" name="agenda_ds_retorno"></textarea>
                                </div>
                            </div>                             
                        </div>
                        <div class="row">
                            <div class='col-md-3'>
                                Fechar Retorno:
                            </div>                                                              
                            <div class='col-md-1'>
                                <input type='checkbox' class='form-check-label' maxlength="10"  id='dt_termino_retorno' name='dt_termino_retorno'>
                            </div>                                                              
                        </div>
                        <div class="row">                                    
                            <div class='col-md-3'>
                                <label for='ic_usuario'>Novo Retorno:&nbsp;</label>                                
                            </div>
                            <div class='col-md-1'>
                                <input type='checkbox' disabled="" class='form-check-label' maxlength="10"  id='n_retorno' name='n_retorno'>
                            </div>
                        </div>  
                        <p>
                        <div class="row">                 
                            <div class="col-md-12">                            
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            </div>        
                        </div>          
                    </div>  
                    <p>
                    <div class="row">
                        <div class='col-md-3'>
                            Fechar Ocorrência:
                        </div>                                                              
                        <div class='col-md-1'>
                            <input type='checkbox' class='form-check-label' maxlength="10"  id='dt_fechamento' name='dt_fechamento'>
                        </div>                                                              
                    </div>
                    <br>                            
                </div>  
            </div>
        </div>
    </div> 
</form>
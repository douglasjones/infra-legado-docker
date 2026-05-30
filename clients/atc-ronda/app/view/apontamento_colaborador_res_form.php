<?
require_once "../inc/php/header.php";
?>
<div class="container-fluid">
    <div id="html_modal_painel"></div>
    <input type='hidden' id='leads_pk_apontamento'  />
    <input type='hidden' id='turnos_pk_apontamento'  />
    <input type='hidden' id='colaborador_pk_apontamento'  />
    <input type='hidden' id='dt_agenda_apontamento'  />
    <input type='hidden' id='ds_re_apontamento'  />
    <input type='hidden' id='ds_colaborador_apontamento'  />
    <input type='hidden' id='ds_produto_servico_apontamento'  />
    <input type='hidden' id='ds_turno_apontamento'  />
    <input type='hidden' id='hr_turno_apontamento'  />
    <input type='hidden' id='dia_semana_apontamento'  />
    <input type='hidden' id='hr_turno_saida_apontamento'  />
    <input type='hidden' id='produtos_servicos_pk_apontamento'  />
    <input type='hidden' id='contratos_itens_pk_apontamento'  />
    <input type='hidden' id='agenda_pk_apontamento'  />
    <input type='hidden' id='processos_etapas_pk_apontamento'  />
    <input type='hidden' id='ds_registro_inicial'  />
    
    
    
        <!-- Inicio janeja modal para edicao do registro -->
        <div class="modal fade bd-example-modal-lg" id="janela_escala" tabindex="-1" role="dialog" aria-labelledby="janela_contatosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contatosLabel">Registrar Troca de Colaborador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form_contato">
                        <div class="modal-body">
                            
                            <input type='hidden' id='dias_semana_inclusao'  />
                            <input type='hidden' id='dia_semana_troca'  />
                            <input type='hidden' id='dt_base_inclusao_modal'  />
                            <input type='hidden' id='produtos_servicos_pk'  />
                            <input type='hidden' id='turnos_pk'  />
                            <input type='hidden' id='agenda_contratos_pk'  />
                            <input type='hidden' id='leads_pk_troca'  />
                            
                            
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id='dt_base_modal' ></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="ds_colaborador_troca"></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="ds_re_troca"></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="hr_troca"></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="ds_funcao_troca"></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md'>
                                    <input type='hidden' id='colaborador_atual_pk'  />
                                    <input type='hidden' id='pausa_pk'  />
                                </div>
                            </div>
                            <br>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <br>
                            <div class="row">
                                <div class='col-md-4'>
                                    <label for='cargos_pk'>Motivo de Alteração: </label>
                                    <select class='form-control form-control-sm-8'  id='motivo_alteracao_pk' name='motivo_alteracao_pk' /><option></option></select>
                                </div>  
                            </div>
                            <div class='row' id="alert_motivo" style="display:none">
                                <div class='col-md-4'>
                                    <strong style="color: red">Por favor, informe Motivo de Alteração</strong>
                                </div>
                            </div>     
                            <!--div class="row">
                                <div class='col-md-4'>
                                    <label for='cargos_pk'>De: </label>
                                    <input type="text" class='form-control form-control-sm-6'  id='dt_novo_periodo_ini' name='dt_novo_periodo_ini' />
                                </div>
                                <div class='col-md-4'>
                                    <label for='cargos_pk'>Até: </label>
                                    <input type="text" class='form-control form-control-sm-6'  id='dt_novo_periodo_fim' name='dt_novo_periodo_fim' />
                                </div>
                            </div-->
                            <div class="row">
                                <div class='col-md-4'>
                                    <label for='cargos_pk'>Colaborador Substituto : </label>
                                    <select class='form-control form-control-sm-8'  id='colaboradores_pk' name='colaboradores_pk' /><option></option></select>
                                </div>
                                
                            </div>
                            <div class='row' id="alert_colaborador" style="display:none">
                                <div class='col-md-4'>
                                    <strong style="color: red">Por favor, informe Colaborador Substituto</strong>
                                </div>
                            </div>
                            <!--div class="row">
                                <div class='col-md'>
                                    <label for='cargos_pk'>Observação : </label>
                                    <textarea class='form-control form-control-sm'  id='ds_obs' name='ds_obs' ></textarea>
                                </div>
                                
                            </div-->                                
                            
                            <div class="row">
                                <div class='col-md-12'>
                                    &nbsp;
                                </div>
                            </div>                                
                                
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" class="close" data-dismiss="modal" aria-label="Close">Fechar</button>
                            <button type="button" class="btn btn-primary" id="cmdIncluir" name="cmdIncluir">Salvar</button>
                        </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="janela_incluir_escala" tabindex="-1" role="dialog" aria-labelledby="janela_contatosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contatosLabel">Registrar Incluir Escala</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form_contato">
                        <div class="modal-body">
                            <div class="row">
                                <div class='col-md'>
                                    <input type='hidden' id='dt_inicio_ins'  />
                                    <input type='hidden' id='dia_semana_ins'  />
                                    <input type='hidden' id='colaborador_pk_ins'  />
                                    <input type='hidden' id='agenda_pk_ins'  />
                                    <input type='hidden' id='processos_etapas_pk_ins'  />
                                    <input type='hidden' id='contratos_itens_pk_ins'  />
                                    <input type='hidden' id='leads_pk_ins'  />
                                </div>
                            </div>
                            <div class="row">
                                <div class='col-md'>
                                    <div id='dt_base_modal_ins' ></div>
                                </div>                 
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="ds_colaborador_ins"></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="ds_re_ins"></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="ds_funcao_ins"></div>
                                </div>                                                                          
                            </div> 
                            
                            <br>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <br> 
                            <div class='row'>
                                <div class='col-md-12 text-center' align="center">
                                    <table class="table table-striped table-bordered nowrap text-center" align="center" style="width:60%;align-content:center" id=''>
                                        <thead>
                                            <tr>
                                                <th colspan='2'><div id='ds_dia_semana_ins'></div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style=" background: #FFFFFF ">
                                                <td>Turno</td>
                                                <td>
                                                    <select class='form-control form-control-sm'  id='turnos_pk_ins' name='turnos_pk_ins'>
                                                        <option></option>
                                                    </select>
                                                </td> 
                                            </tr>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>HR Entrada</td>
                                                <td>
                                                    <input  class='form-control form-control-sm' maxlength="5" type='type' name='hr_turno_ins' id='hr_turno_ins' />
                                                </td>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div> 
                            <div class='row' id="alert_turno_ins_escala" style="display:none">
                                <div class='col-md-4'>
                                    <strong style="color: red">Por favor, informe Turno</strong>
                                </div>
                            </div>
                            <div class='row' id="alert_hora_turno_escala" style="display:none">
                                <div class='col-md-4'>
                                    <strong style="color: red">Por favor, informe Hora</strong>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class='col-md-12'>
                                    &nbsp;
                                </div>
                            </div>                                
                                
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" class="close" data-dismiss="modal" aria-label="Close">Fechar</button>
                            <button type="button" class="btn btn-primary" id="cmdIncluirEscala" name="cmdIncluirEscala">Salvar</button>
                        </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="janela_retornar_escala" tabindex="-1" role="dialog" aria-labelledby="janela_contatosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contatosLabel">Registrar Retornar Escala</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form_contato">
                        <div class="modal-body">
                            <div class="row">
                                <div class='col-md'>
                                    <input type='hidden' id='dt_inicio_inc'  />
                                    <input type='hidden' id='dia_semana_inc'  />
                                    <input type='hidden' id='colaborador_pk_inc'  />
                                    <input type='hidden' id='leads_pk_inc'  />
                                </div>
                            </div>
                            <br>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <br>
                            <div class="row">
                                <div class='col-md'>
                                    <div id='dt_base_modal_inc' ></div>
                                </div>                 
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="colaborador_ins"></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="re_ins"></div>
                                </div>                                                                          
                            </div>
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="funcao_ins"></div>
                                </div>                                                                          
                            </div>     
                            <div class="row">
                                <div class='col-md-12'>                                    
                                    <div id="ds_turno_inc"></div>
                                </div>                                                                          
                            </div>     
                              
                            <div class="row">
                                <div class='col-md-12'>
                                    &nbsp;
                                </div>
                            </div>                                
                                
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" class="close" data-dismiss="modal" aria-label="Close">Fechar</button>
                            <button type="button" class="btn btn-primary" id="cmdRetornarEscala" name="cmdRetornarEscala">Salvar</button>
                        </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modal_hora_extra">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Registrar Hora Extra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container ">
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_hora_extra"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_hora_extra"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_hora_extra"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_hora_extra"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_hora_extra"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_hora_extra"></div>
                            </div>                                                                          
                        </div>
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        <br>
                        <input type="hidden" id="ic_dia_hora_extra">
                        <input type="hidden" id="agendas_pk_hora_extra">
                        <input type="hidden" id="leads_pk_hora_extra">
                        <input type="hidden" id="colaborador_pk_hora_extra">
                        <input type="hidden"  class='form-control form-control-sm' id='dt_execucao_hora_extra' maxlength="10" name='dt_execucao_hora_extra'>
                        <div class="row">                                                                        
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                           
                            <div class='col-md-4'>
                                <label for='dt_fim_agenda'>Hora Início: </label>
                                <input type="text"  class='form-control form-control-sm' id='hr_inicio_hora_extra' maxlength="5" name='hr_inicio_hora_extra'>
                            </div>                                           
                            <div class='col-md-4'>
                                <label for='dt_fim_agenda'>Hora Fim: </label>
                                <input type="text"  class='form-control form-control-sm' id='hr_fim_hora_extra' maxlength="5" name='hr_fim_hora_extra'>
                            </div>                                           
                        </div>
                        <div class='row' id="alert_hr_extra" style="display:none">
                                <div class='col-md-2'>
                                    &nbsp;
                                </div> 
                                <div class='col-md-4'>
                                    <strong style="color: red">Por favor, informe Hora Início</strong>
                                </div>
                                <div class='col-md-4'>
                                    <strong style="color: red">Por favor, informe Hora Fim</strong>
                                </div>
                            </div>
                        <div class="row">  
                            
                            <div class='col-md-2'>
                                &nbsp;
                            </div>                                                                                    
                            <div class='col-md-8'>
                                <label for='dt_fim_agenda'>Obs Hora Extra: </label>
                                <textarea  class='form-control form-control-sm' id='obs_hora_extra' name='obs_hora_extra'></textarea>
                            </div>                                                                                    
                        </div>
                        
                    <div class="modal-body">
                      
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                         <button type="button"  class="btn btn-primary" id='btnHoraExtra' >Salvar</button>
                          
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modal_afastamento">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Registrar Afastamento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container ">
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_afastamento"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_afastamento"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_afastamento"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_afastamento"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_afastamento"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_afastamento"></div>
                            </div>                                                                          
                        </div>
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        <br>
                        <input type="hidden" id="leads_pk_afastamento">
                        <input type="hidden" id="colaborador_pk_afastamento">
                        <input type="hidden" id="ic_dia_semana_afastamento">
                        <div class="row">                                                                                                                
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Motivo Afastamento: </label>
                                <select  class='form-control form-control-sm' id='motivo_afastamento_pk' name='motivo_afastamento_pk'>
                                    <option></option>
                                    <option value="1">Afastamento Médico</option>
                                    <option value="2">Licença Maternidade.</option>
                                </select>
                            </div>                                                                                     
                        </div>
                        <div class='row' id="alert_motivo_afastamento" style="display:none">
                            <div class='col-md-4'>
                                <strong style="color: red">Por favor, informe Motivo Afastamento</strong>
                            </div>
                        </div>
                        <div class="row">                                                                                                                
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Data Início: </label>
                                <input type="text"  class='form-control form-control-sm' id='dt_inicio_afastamento' maxlength="10" name='dt_inicio_afastamento'>
                            </div>                                           
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Data Fim: </label>
                                <input type="text"  class='form-control form-control-sm' id='dt_fim_afastamento' maxlength="10" name='dt_fim_afastamento'>
                            </div>                                           
                        </div>
                        <div class='row' id="alert_afastamento_dia" style="display:none">
                            <div class='col-md-2'>
                                &nbsp;
                            </div> 
                            <div class='col-md-4'>
                                <strong style="color: red">Por favor, informe Data Início</strong>
                            </div>
                            <div class='col-md-4'>
                                <strong style="color: red">Por favor, informe Data Fim</strong>
                            </div>
                        </div>
                        
                        
                        <div class="row">                                                                                     
                            <div class='col-md-8'>
                                <label for='dt_fim_agenda'>Observação: </label>
                                <textarea  class='form-control form-control-sm' id='obs_afastamento' name='obs_afastamento'></textarea>
                            </div>                                                                                    
                        </div>
                        
                    <div class="modal-body">
                      
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                         <button type="button"  class="btn btn-primary" id='btnAfastamento' >Salvar</button>
                          
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modal_tarefa">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Registrar Tarefa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container ">
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_tarefa"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_tarefa"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_tarefa"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_tarefa"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_tarefa"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_tarefa"></div>
                            </div>                                                                          
                        </div>
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        <br>
                        <input type="hidden" id="ic_dia">
                        <input type="hidden" id="agendas_pk">
                        <input type="hidden" id="leads_pk_tarefa">
                        <input type="hidden"  class='form-control form-control-sm' id='dt_execucao' maxlength="10" name='dt_execucao'>
                        <div class="row">
                            <div class='col-md-7'>                                    
                                <label for='dt_inicio_agenda'>Tarefa: </label>
                                <input type='text' class='form-control form-control-sm' id='ds_tarefa' name='ds_tarefa'>
                            </div>                                                                          
                        </div>
                        <div class="row">                                                                        
                            <div class='col-md-4'>
                                <label for='dt_fim_agenda'>Hora Início: </label>
                                <input type="text"  class='form-control form-control-sm' id='hr_inicio' maxlength="5" name='hr_inicio'>
                            </div>                                           
                        </div>
                        <div class="row">                               
                            <div class='col-md-7'>
                                <label for='dt_fim_agenda'>Obs Tarefa: </label>
                                <textarea  class='form-control form-control-sm' id='obs_tarefa' name='obs_tarefa'></textarea>
                            </div>                                                                                    
                        </div>
                        <br>
                        <div class="row">                                                                        
                            <div class='col-md-4'>
                                <label for='dt_fim_agenda'>Tarefa Recorrente: </label>
                                
                            </div>                                           
                            <div class='col-md-2'>
                                <input type="checkbox"   id='ic_tarefa_recorrente'name='ic_tarefa_recorrente'>
                            </div>                                           
                        </div>
                        <div class="row">                                                                        
                            <div class='col-md-5'>
                                &nbsp;
                                
                            </div>                                           
                            <div class='col-md-2'>
                                <button type="button"  class="btn btn-primary" id='btntarefa' >Incluir</button>
                            </div>                                           
                        </div>
                        
                    </div>
                    <div class="container">    
                        <div class="row" id="ic_grid">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap " style="width:100%;" id="tblTarefa">
                                    <thead >
                                        <tr>
                                        <th>Código</th>
                                        <th>Tarefa</th>
                                        <th>Obs Tarefa</th>
                                        <th>Hora inicio</th>
                                        <th>Data Exec.</th>
                                        <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                      
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                          
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modal_falta">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Registrar Falta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container ">
                        <input type="hidden"  id='dia_semana_falta' name='dia_semana_falta'>
                        <input type="hidden"  id='colaborador_faltou_pk' name='colaborador_faltou_pk'>
                        <input type="hidden"  id='dt_escala_falta' name='dt_escala_falta'>
                        <input type="hidden"  id='leads_pk_falta' name='leads_pk_falta'>
                        
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_falta"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_falta"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_falta"></div>
                            </div>                                                                          
                        </div>
                        
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_falta"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_falta"></div>
                            </div>                                                                          
                        </div>
                        
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    
                        <br>
                        <div class="row">                               
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Motivo Falta: </label>
                                <select  class='form-control form-control-sm' id='motivo_falta_pk' name='motivo_falta_pk'>
                                    <option></option>
                                    <option value="1">Falta sem justificativa</option>
                                    <option value="2">Atestado</option>
                                    <option value="3">Reciclagem</option>
                                    <option value="4">Posto vago</option>
                                    <option value="5">Remanejamento</option>
                                </select>
                            </div>                                                                                    
                        </div>
                        <div class='row' id="alert_motivo_falta" style="display:none">
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe Motivo Falta</strong>
                            </div>
                        </div>
                        <div class="row" >                               
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Colaborador Reserva: </label>
                                <select  class='form-control form-control-sm chzn-select' data-placeholder="Selecione Colaborador" id='colaborador_falta_pk' name='colaborador_falta_pk'>
                                    <option></option>
                                </select>
                            </div>                                                                                    
                        </div>
                        
                        <div class='row' id="alert_ds_colaborador_falta" style="display:none">
                        <div class='col-md-5'>
                            <strong style="color: red">Por favor, informe Colaborador</strong>
                        </div>
                    </div>
                        <div class="row">                               
                            <div class='col-md-12'>
                                <label for='dt_fim_agenda'>Obs: </label>
                                <textarea  class='form-control form-control-sm' id='obs_falta' name='obs_falta'></textarea>
                            </div>                                                                                    
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                          <button type="button"  class="btn btn-primary" id='btnFalta' >Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modal_ponto">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Registrar Ponto Manualmente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container ">
                        <input type="hidden"  id='dia_semana_ponto' name='dia_semana_ponto'>
                        <input type="hidden"  id='colaborador_ponto_pk' name='colaborador_ponto_pk'>
                        <input type="hidden"  id='dt_escala_ponto' name='dt_escala_ponto'>
                        <input type="hidden"  id='leads_pk_ponto' name='leads_pk_ponto'>
                        
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_ponto"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_ponto"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_ponto"></div>
                            </div>                                                                          
                        </div>
                        
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_ponto"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_ponto"></div>
                            </div>                                                                          
                        </div>
                        
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    
                        <br>
                        <div class="row">                                                                        
                            <div class='col-md-12'>
                                <label for='dt_fim_agenda'>Tipo de registro de ponto: </label>
                                <select class='form-control form-control-sm' id="tipo_registro_ponto_pk" name="tipo_registro_ponto_pk">
                                    <option></option>
                                    <option value="1">Início Expediente</option>
                                    <option value="3">Saida p/ Intervalo</option>
                                    <option value="4">Retorno do Intervalo</option>
                                    <option value="2">Fim Expediente</option>
                                </select>
                            </div>                                           
                        </div>
                        <div class='row' id="alert_tipo_registro" style="display:none">
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe Tipo de registro de ponto</strong>
                            </div>
                        </div>
                        <br>
                        <div class="row">                                                                        
                            <div class='col-md-12'>
                                <label for='dt_fim_agenda'>Hora Automática Sistema: </label>
                                <input type="checkbox"  id='ic_hr_sistema' name='ic_hr_sistema'>
                            </div>                                           
                        </div>
                        <div class="row">                                                                        
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Hora Entrada Manual: </label>
                                <input type="text"  class='form-control form-control-sm' id='hr_entrada_manual' maxlength="5" name='hr_entrada_manual'>
                            </div>                                           
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                          <button type="button"  class="btn btn-primary" id='btnPonto' >Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <div style='overflow: scroll;' class='modal fade bd-example-modal-lg' tabindex='-1' role='dialog' aria-labelledby='janela_contatosLabel' aria-hidden='true' id="modal_servico_extra">
            <div class='modal-dialog modal-lg' role='document'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Registrar Apontar quem Executou</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container ">
                        <input type="hidden"  id='dia_semana_servico_extra' name='dia_semana_servico_extra'>
                        <input type="hidden"  id='colaborador_servico_extra_pk' name='colaborador_servico_extra_pk'>
                        <input type="hidden"  id='dt_escala_servico_extra' name='dt_escala_servico_extra'>
                        <input type="hidden"  id='leads_pk_servico_extra' name='leads_pk_servico_extra'>
                        
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_servico_extra"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_servico_extra"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_servico_extra"></div>
                            </div>                                                                          
                        </div>
                        
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_servico_extra"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_servico_extra"></div>
                            </div>                                                                          
                        </div>
                        
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    
                        <br>
                        <div class="row">                                                                        
                            <div class='col-md-12'>
                                <div id='grid_contratos_itens'></div>
                            </div>                                           
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                          <button type="button"  class="btn btn-primary" id='btnServicoExtra' >Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modal_exclusao">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Registrar Excluisão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container ">
                        <input type="hidden"  id='turnos_exclusao_pk' name='turnos_exclusao_pk'>
                        <input type="hidden"  id='colaborador_exclusao_pk' name='colaborador_exclusao_pk'>
                        <input type="hidden"  id='dt_base_exclusao' name='dt_base_exclusao'>
                        <input type="hidden"  id='dia_semana_exclusao' name='dia_semana_exclusao'>
                        <input type="hidden"  id='leads_pk_exclusao' name='leads_pk_exclusao'>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_excluir"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_excluir"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_excluir"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_excluir"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_excluir"></div>
                            </div>                                                                          
                        </div>
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        <br>
                        <div class="row">                               
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Motivo Exclusão: </label>
                                <select  class='form-control form-control-sm' id='motivo_exclusao_pk' name='motivo_exclusao_pk'>
                                    <option></option>
                                    <option value="1">Posto de trabalho cancelado</option>
                                    <option value="2">Duplicidade</option>
                                    <option value="3">Escala data Errada</option>
                                </select>
                            </div>                                                                                    
                        </div>
                        <div class='row' id="alert_motivo_exclusao" style="display:none">
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe Motivo Exclusão</strong>
                            </div>
                        </div>
                        <div class="row">                               
                            <div class='col-md-12'>
                                <label for='dt_fim_agenda'>Obs: </label>
                                <textarea  class='form-control form-control-sm' id='ds_obs_exclusao' name='ds_obs_exclusao'></textarea>
                            </div>                                                                                    
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                          <button type="button"  class="btn btn-primary" id='btnExclusao' >Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modal_folga">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Folga Escala</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container ">
                        <input type="hidden"  id='turnos_folga_pk' name='turnos_folga_pk'>
                        <input type="hidden"  id='colaborador_folga_pk' name='colaborador_folga_pk'>
                        <input type="hidden"  id='dt_base_folga' name='dt_base_folga'>
                        <input type="hidden"  id='dia_semana_folga' name='dia_semana_folga'>
                        <input type="hidden"  id='leads_pk_folga' name='leads_pk_folga'>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_folga"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_folga"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_folga"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_folga"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_folga"></div>
                            </div>                                                                          
                        </div>
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        <br>
                        <div class="row">                               
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Motivo Folga: </label>
                                <select  class='form-control form-control-sm' id='motivo_folga_pk' name='motivo_folga_pk'>
                                    <option></option>
                                    <option value="1">Consulta Médica</option>
                                    <option value="2">Outro motivo folga</option>
                                    <option value="3">Escala data Errada</option>
                                    <option value="4">Folga Trabalhada</option>
                                    <option value="5">Cobertura</option>
                                </select>
                            </div>                                                                                    
                        </div>
                        <div class='row' id="alert_motivo_folga" style="display:none">
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe Motivo Folga</strong>
                            </div>
                        </div>
                        <div class="row" id="exibir_colaborador_cobertura" style="display:none">                               
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Colaborador Cobertura: </label>
                                <select  class='form-control form-control-sm chzn-select' data-placeholder="Selecione Colaborador" id='colaborador_cobertura_pk' name='colaborador_cobertura_pk'>
                                    <option></option>
                                </select>
                            </div>                                                                                    
                        </div>
                        <div class='row' id="alert_ds_colaborador_cobertura" style="display:none">
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe Colaborador</strong>
                            </div>
                        </div>

                            <div class="row">                               
                                <div class='col-md-12'>
                                    <label for='dt_fim_agenda'>Obs: </label>
                                    <textarea  class='form-control form-control-sm' id='ds_obs_folga' name='ds_obs_folga'></textarea>
                                </div>                                                                                    
                            </div>

                        </div>
                        <br>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                          <button type="button"  class="btn btn-primary" id='btnAtribuirFolga' >Salvar</button>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="modal fade bd-example-modal-lg" id="modal_ferias">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Registrar Férias</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="colaborador_ferias_pk" name="colaborador_ferias_pk">
                    <input type="hidden" id="leads_pk_ferias" name="leads_pk_ferias">
                    <input type="hidden" id="turnos_pk_ferias" name="turnos_pk_ferias">
                    <div class="container ">
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="dt_agenda_ferias"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_ferias"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_ferias"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_ferias"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_ferias"></div>
                            </div>                                                                          
                        </div>
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        <br>
                        <div class="row">                               
                            <div class='col-md-6'>
                                <label for='dt_fim_agenda'>Data Início Férias: </label>
                                <input  class='form-control form-control-sm' id='dt_ferias_ini' name='dt_ferias_ini'>
                            </div>                                                                                    
                            <div class='col-md-6'>
                                <label for='dt_fim_agenda'>Data Fim Férias: </label>
                                <input  class='form-control form-control-sm' id='dt_ferias_fim' name='dt_ferias_fim'>
                            </div>                                                                                    
                        </div>
                        <br>
                        <div class='row' id="alert_dt_ferias" style="display:none">
                            <div class='col-md-6'>
                                <strong style="color: red">Por favor, informe Data Inicio Férias</strong>
                            </div>
                            <div class='col-md-6'>
                                <strong style="color: red">Por favor, informe Data Fim Férias</strong>
                            </div>
                        </div>
                        <br>
                        <div class="row">                               
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Colaborador Reserva: </label>
                                <select  class='form-control form-control-sm chzn-select' data-placeholder="Selecione Colaborador" id='colaborador_substituto_ferias_pk' name='colaborador_substituto_ferias_pk'>
                                    <option></option>
                                </select>
                            </div>                                                                                    
                        </div>
                        <div class='row' id="alert_ds_colaborador_ferias" style="display:none">
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe Colaborador</strong>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                          <button type="button"  class="btn btn-primary" id='btnAtribuirFerias' >Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="modal_cobertura">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_agendaLabel">Cobertura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="colaborador_cobertura_pk" name="colaborador_cobertura_pk">
                    <input type="hidden" id="leads_pk_cobertura" name="leads_pk_cobertura">
                    <input type="hidden" id="turnos_pk_cobertura" name="turnos_pk_cobertura">
                    <input type="hidden" id="dt_cobertura_ini" name="dt_cobertura_ini">
                    <div class="container ">
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_colaborador_cobertura"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_re_cobertura"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="hr_cobertura"></div>
                            </div>                                                                          
                        </div>
                        <div class="row">
                            <div class='col-md-12'>                                    
                                <div id="ds_funcao_cobertura"></div>
                            </div>                                                                          
                        </div>
                        <br>
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        <br>
                        <div class="row" >                               
                            <div class='col-md-5'>
                                <label for='dt_fim_agenda'>Colaborador: </label>
                                <select  class='form-control form-control-sm chzn-select' data-placeholder="Selecione Colaborador" id='colaborador_reserva_cobertura_pk' name='colaborador_reserva_cobertura_pk'>
                                    <option></option>
                                </select>
                            </div>                                                                                    
                        </div>
                        <div class='row' id="alert_cobertura" style="display:none">
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe Colaborador</strong>
                            </div>
                        </div>
                        <br>
                        <div class="row" >                               
                            <div class='col-md-8'>
                                <label for='dt_fim_agenda'>Obs: </label>
                                <textarea  class='form-control form-control-sm '  id='obs_cobertura' name='obs_cobertura'>
                                </textarea>
                            </div>                                                                                    
                        </div>
                        
                        
                    </div>
                    <div class="modal-footer">
                         <a href="#" data-dismiss="modal" class="btn btn-secondary">Fechar</a>
                          <button type="button"  class="btn btn-primary" id='btnCobertura' >Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal fade bd-example-modal-lg" id="myModal" role="dialog" aria-labelledby="janela_contatosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content bd-example-modal-lg-12" style="width:1200px; height: 650px;">
                <div class="modal-body">
                    <div class="modal-body-agenda" ></div>  
                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" class="close" data-dismiss="modal" aria-label="Close">Fechar</button>
                </div>  
                
            </div>
        </div>
    </div>              
</div>
<?
require_once "../inc/php/footer.php";
?>

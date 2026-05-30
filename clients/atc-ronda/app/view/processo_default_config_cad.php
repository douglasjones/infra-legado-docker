<?
require_once "../inc/php/header.php";
?>
<script src="processo_default_config_cad.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<title>Gepros CRM</title>
<!-- Custom fonts for this template-->
<link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
<div class="container">
    <br>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-6">
                <div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Processo - Configuração Classificação</h6>     
                        </div>       
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarTudo">Salvar</button>  
                        </div>                   
                    </div>   
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                            <div class='row'>
                                <div class='col-md-4'>                        
                                    <label>Processo:</label>
                                    <select id="processo_default_pk" class='form-control form-control-sm ' name="processo_default_pk">
                                        <option value=""> </option>
                                    </select>
                                    <div id="alert_processo_default_pk" name="alert_processo_default_pk" style="display:none">
                                        <div class='col-md-12'>
                                            <strong style="color: red">Por favor, informe Processo</strong>
                                        </div>
                                    </div>                           
                                </div>                    
                                <div class='col-md-4'>                        
                                    <label>Processo Etapa:</label>
                                    <input id="ds_processo_default_etapa" class='form-control form-control-sm ' name="ds_processo_default_etapa">   
                                    <input type="hidden" id="processos_default_etapas_pk" class='form-control form-control-sm ' name="processos_default_etapas_pk">   
                                    <div id="alert_ds_processo_default_etapa" name="alert_ds_processo_default_etapa" style="display:none">
                                        <div class='col-md-12'>
                                            <strong style="color: red">Por favor, informe Processo Etapa</strong>
                                        </div>
                                    </div>                    
                                </div>                    
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>                        
                                    <label>Movimentação Classificação:</label>
                                    <input id="ds_processo_default_configuracao" class='form-control form-control-sm ' name="ds_processo_default_configuracao">                               
                                    <div id="alert_ds_processo_default_configuracao" name="alert_ds_processo_default_configuracao" style="display:none">
                                        <div class='col-md-12'>
                                            <strong style="color: red">Por favor, informe Movimentação Classificação</strong>
                                        </div>
                                    </div>
                                </div>                    
                                <div class='col-md-4'>                        
                                    <label>Ordem de Exibição:</label>
                                    <select id="n_ordem" class='form-control form-control-sm ' name="n_ordem">
                                        <option value=""> </option>
                                    </select>
                                    <div id="alert_n_ordem" name="alert_n_ordem" style="display:none">
                                        <div class='col-md-12'>
                                            <strong style="color: red">Por favor, informe Ordem de Exibição</strong>
                                        </div>
                                    </div>                      
                                </div>                    
                                <div class='col-md-4'>                        
                                    <label>Cor Identificação:</label>
                                    <select id="ds_cor" class='form-control form-control-sm ' name="ds_cor">
                                        <option value=""> </option>
                                        <option value="1">Azul</option>
                                        <option value="2">Amarelo</option>
                                        <option value="3">Laranja</option>
                                        <option value="4">Vermelho</option>
                                        <option value="5">Verde</option>
                                        <option value="6">Roxo</option>
                                    </select>                      
                                </div>                    
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>                        
                                    <label>Tempo para Execução:</label>
                                    <select id="tempo_execucao_pk" class='form-control form-control-sm ' name="tempo_execucao_pk">
                                        <option value=""> </option>
                                    </select>                             
                                </div>                    
                                <div class='col-md-4'>                        
                                    <label>Tipo de Ocorrência:</label>
                                    <select id="tipos_ocorrencias_pk" class='form-control form-control-sm ' name="tipos_ocorrencias_pk">
                                        <option value=""> </option>
                                    </select>                      
                                </div>                    
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>                        
                                    <label>Módulos:</label>
                                    <select id="processos_default_modulos_pk" class='form-control form-control-sm ' name="processos_default_modulos_pk">
                                        <option value=""> </option>
                                    </select>                             
                                </div>
                                <div class='col-md-4'>                        
                                    <label>Registro Obrigatório Movimentação:</label>
                                    <select id="processos_default_modulos_obrigatorio_pk" class='form-control form-control-sm ' name="processos_default_modulos_obrigatorio_pk">
                                        <option value=""> </option>
                                    </select>                      
                                </div>                    
                                <div class='col-md-4'>                        
                                    <label>Status:</label>
                                    <select id="ic_status" class='form-control form-control-sm ' name="ic_status">
                                        <option value=""> </option>
                                        <option value="1">Sim</option>
                                        <option value="2">Não</option>
                                    </select>                      
                                </div>                 
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>                        
                                    <label>Grupos com permissão de acesso:</label>                         
                                    <div class='col-md-12' id="grid_processo_default_grupos" name="grid_processo_default_grupos">                        
                                                
                                    </div>              
                            </div>
                            <br>
                        </div>
                        <div class="col-md-12" align="Right">
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <br>
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarTudo">Salvar</button>                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
<?require_once "../inc/php/footer.php";?>

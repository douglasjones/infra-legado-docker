<? require_once "../inc/php/header.php"; ?>
<script src="analise_financeira_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>

</style>
<div class="container">
    <br>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-6">
                <div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">PAF - Análise Financeira</h6>     
                        </div>       
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>                    
                        </div>
                    </div>   
                </div>
                <div class="card-body">
                    <form id="form" class="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class='row'>                      
                                    <div class='col-sm-12' align="left">
                                        <h6>Dados de Identificação do Lançamento</h6>     
                                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                    </div>                    
                                </div>
                                <br>
                                <div class='row'>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Cód Lançamento:</b></label>
                                        <div id='lancamento_pk'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Dt. Cadastro:</b></label>
                                        <div id='dt_cadastro'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Nome Usuário:</b></label>
                                        <div id='ds_usuario'></div>                          
                                    </div>                    
                                </div>
                                <div class='row'>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Tipo Lançamento:</b></label>
                                        <div id='ds_operacao'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Tipo Operação/ Planos Conta:</b></label>
                                        <div id='ds_tipo_operacao'></div>                          
                                    </div>                    
                                </div>
                                <div class='row'>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Empresa Para o Lançamento:</b></label>
                                        <div id='ds_empresas'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Conta Bancária:</b></label>
                                        <div id='ds_conta_bancaria'></div>                          
                                    </div>                    
                                </div>
                                <div class='row'>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Identificação do Lançamento:</b></label>
                                        <div id='ds_lancamento'></div>                          
                                    </div>                    
                                </div>
                                <div class='row'>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Grupo Origem do Lançamento:</b></label>
                                        <div id='ds_tipo_grupo'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Recebimento de ? Pago de ?:</b></label>
                                        <div id='ds_lead'></div>                          
                                    </div>                    
                                </div>
                                <div class='row'>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Cliente:</b></label>
                                        <div id='ds_cliente'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Posto De Trabalho:</b></label>
                                        <div id='ds_posto_trabalho'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Contrato:</b></label>
                                        <div id='ds_contrato'></div>                          
                                    </div>                    
                                </div>
                                <div class='row'>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Banco:</b></label>
                                        <div id='ds_banco'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Agência:</b></label>
                                        <div id='ds_agencia'></div>                          
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Conta:</b></label>
                                        <div id='ds_conta'></div>                          
                                    </div>                    
                                </div>
                                <div class='row'>                    
                                    <div class='col-md-4'>                        
                                        <label><b>Pix:</b></label>
                                        <div id='ds_pix'></div>                          
                                    </div>                    
               
                                </div>
                                <br>
                                <div class='row'>                      
                                    <div class='col-sm-12' align="left">
                                        <h6>Dados de Valor e Data Do Lançamento / Status</h6>     
                                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                    </div>
                                    <br>
                                </div>
                                <div class='col-sm-12' align="left">
                                    <div class='row'>                    
                                        <div class='col-md-4'>                        
                                            <label><b>Valor do Lançamento:</b></label>
                                            <div id='vl_lancamento'></div>                          
                                        </div>                    
                                        <div class='col-md-4'>                        
                                            <label><b>Método de Recebimento:</b></label>
                                            <div id='ds_metodo_pagamento'></div>                          
                                        </div>                                        
                                    </div>                    
                                    <div class='row'>                    
                                        <div class='col-md-4'>                        
                                            <label><b>Dt Vencimento / Recebimento:</b></label>
                                            <div id='dt_vencimento'></div>                          
                                        </div>                    
                                        <div class='col-md-4'>                        
                                            <label><b>Parcela:</b></label>
                                            <div id='parcela_pk'></div>                          
                                        </div>                                        
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        <label><b>Grid de Documentos:</b></label>
                                        <div class="row" >
                                            <div class="col-md-12">
                                                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblDocumentos">
                                                    <thead>
                                                        <tr>
                                                            <th>Cód</th>
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
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        <label><b>Observação:</b></label>
                                        <div id='obs'></div>                          
                                    </div>
                                </div>
                                <br>
                                <div class='row'>                      
                                    <div class='col-sm-12' align="left">
                                        <h6>Analise(s) Financeiras</h6>     
                                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                    </div>
                                    <br>
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        <label><b>Status de Análise:</b></label>
                                        <select id="ic_status" class='form-control form-control-sm ' name="ic_status">
                                            <option value=""></option>
                                        </select>                         
                                    </div>
                                </div>
                                <hr>  
                                <div class='row' id="solicitar_correcao">
                                    <div class='col-md-12'>                        
                                        <h6>Solicitar Correção:</h6>
                                        <hr>
                                        <div class='col-md-6'>  
                                            <label>Observação Correção:</label>
                                            <textarea cols="5" rows="5" class='form-control form-control-sm' name="obs_correcao" id="obs_correcao"></textarea>                            
                                        </div>
                                    </div>
                                </div>
                                <div class='row' id="solicitar_recusa">
                                    <div class='col-md-12'>                        
                                        <h6>Solicitar Recusa:</h6>
                                        <hr>
                                        <div class='col-md-6'>  
                                            <label>Observação Recusa:</label>
                                            <textarea cols="5" rows="5" class='form-control form-control-sm ' name="obs_recusa" id="obs_recusa">
                                            </textarea>                            
                                        </div>
                                    </div>
                                </div>
                                <div class='row' id="solicitar_aprovacao">
                                    <div class='col-md-12'>                        
                                        <h6>Aprovado</h6>
                                        <hr>
                                        <div class='col-md-6' id="gestor">
                                            <label>Envio para Gestor:</label>
                                            <select class="form-control form-control-sm" name="gestores_pk" id="gestores_pk">
                                                <option value=""> </option>
                                            </select>
                                        </div>
                                        <div class='col-md-6'>  
                                            <label>Observação Aprovação:</label>
                                            <textarea cols="5" rows="5" class='form-control form-control-sm' name="obs_aprovacao" id="obs_aprovacao"></textarea>                            
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class='row'>  
                                    <div class='col-md-12' align="center">
                                            <button type="button" class="btn btn-primary btn-sm" id="cmdIncluirAnalise">Incluir Analise</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class='row'>  
                        <div class='col-md-12'>
                            <h6>Histórico de Analise(s) Financeiras</h6>
                            <hr>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap" style="width:90%" id="tblResultado">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Dt. Cadastro</th>
                                        <th>Usu. Cadastro</th>
                                        <th>Obs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<? require_once "../inc/php/header.php"; ?>
<script src="analise_financeira_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label>Status:</label>
                                        <select id="ic_status" class='form-control form-control-sm ' name="ic_status">
                                            <option value=""></option>
                                            <option value="1">Não Analisado</option>
                                            <option value="2">Aprovado Analista</option>
                                            <option value="3">Aprovado Gestor</option>
                                            <option value="4">Correção Solicitada</option>
                                            <option value="5">Recusado</option>
                                            <option value="6">Correção Feita</option>
                                            <option value="7">Cancelado</option>
                                        </select>                           
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Cód. Lançamento:</label>
                                        <input type='text' class='form-control form-control-sm' id='lancamento_pk' name='lancamento_pk' >                           
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Cadastro Ini:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_cadastro_ini' name='dt_cadastro_ini' >                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Cadastro Fim:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_cadastro_fim' name='dt_cadastro_fim' >                           
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Aprovação Ini:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_aprovacao_ini' name='dt_aprovacao_ini' >                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Aprovação Fim:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_aprovacao_fim' name='dt_aprovacao_fim' >                           
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Correção Ini:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_correcao_ini' name='dt_correcao_ini' >                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Correção Fim:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_correcao_fim' name='dt_correcao_fim' >                           
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Recusa Ini:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_recusa_ini' name='dt_recusa_ini' >                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Recusa Fim:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_recusa_fim' name='dt_recusa_fim' >                           
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Venciment Ini:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_vencimento_ini' name='dt_vencimento_ini' >                           
                                    </div>                    
                                    <div class='col-md-2'>                        
                                        <label>Dt. Vencimento Fim:</label>
                                        <input type='text' class='form-control form-control-sm' id='dt_vencimento_fim' name='dt_vencimento_fim' >                           
                                    </div>    
                                </div>                                 
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label>Solicitante:</label>
                                        <select id="usuario_cadastro_lancamento_pk" class='form-control form-control-sm ' name="usuario_cadastro_lancamento_pk">
                                            <option value=""></option>
                                        </select>                           
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label>Análista:</label>
                                        <select id="usuario_cadastro_analista_pk" class='form-control form-control-sm ' name="usuario_cadastro_analista_pk">
                                            <option value=""></option>
                                        </select>                           
                                    </div>                    
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>                        
                                        &nbsp;                           
                                    </div>                    
                                    <div class='col-md-4'>                        
                                        <label>Gestor:</label>
                                        <select id="usuario_cadastro_gestor_pk" class='form-control form-control-sm ' name="usuario_cadastro_gestor_pk">
                                            <option value=""></option>
                                        </select>                           
                                    </div>                    
                                </div>
                                <br>
                                <div class='row'>                    
                                    <div class='col-md-12' align="center">
                                        <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisar">Pesquisar</button>                         
                                    </div>                    
                                </div>
                                <br>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            </div>       
                        </div>
                    </form>
                    <div class="row" >
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Cód. Lançamento</th>
                                        <th>Solicitante</th>
                                        <th>Dt. Lançamento</th>
                                        <th>Status</th>
                                        <th>Dt. Aprovação</th>
                                        <th>Dt. Correção</th>
                                        <th>Dt. Recusa</th>
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
        </div>
    </div>
</div>
<?
require_once "../inc/php/header.php";
include("inc_agenda_escala_cad_form.php"); ?> 
<script src="colaborador_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="container">
	<br>
    <div class="row">            
        <div class="col-md-12">
            <div  id="abrir" tabindex="-1" role="dialog" aria-labelledby="modal-set-ramalLabel" >       
                <div class="col-lg"  style="max-width:1000px;margin-left: auto;margin-right: auto;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">	
                            <div class="row">
                                <div class='col-sm-6' align="left">
                                    <h6 class="m-0 font-weight-bold text-primary">Pesquisar Colaboradores</h6>
                                </div> 
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_padrao' >
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Novo</button>                       
                                </div>
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_modal'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdFecharModalLead">Fechar</button>                    
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdSalvarModalLead">Incluir</button>                    
                                </div>
                            </div>
                        </div>
                        <form method="post">
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ds_colaborador">Posto de Trabalho:&nbsp;</label>
                                    <select class="form-control form-control-sm chzn-select" id="leads_pk" >
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ds_colaborador">Colaborador:&nbsp;</label>
                                    <select class="form-control form-control-sm chzn-select" id="colaborador_pk" >
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ds_colaborador">Qualificação:&nbsp;</label>
                                    <select class="form-control form-control-sm" id="ds_produto_servico" >
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ds_colaborador">Pin:&nbsp;</label>
                                    <input class="form-control form-control-sm" id="ds_pin" >
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ds_cpf">CPF:&nbsp;</label>
                                    <input class="form-control form-control-sm" id="ds_cpf" >
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ic_status">Status acesso App Ponto:&nbsp;</label>
                                    <select class="form-control form-control-sm" id="ic_status_app" name="ic_status_app" >
                                        <option value=""></option>
                                        <option value="1">Liberado</option>
                                        <option value="2">Pendente</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ds_colaborador">RE:&nbsp;</label>
                                    <input class="form-control form-control-sm" id="ds_re" >
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="generos_pk">Gênero:&nbsp;</label>
                                    <select class="form-control form-control-sm" id="generos_pk" name="generos_pk" >
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <label for='ds_rg'>Reserva:&nbsp;</label>
                                    <input type='checkbox'  id='ic_reserva' name='ic_reserva' >
                                </div>        
                            </div>
                            <br>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ic_status">Origem:&nbsp;</label>
                                    <select class="form-control form-control-sm" id="ic_origem" name="ic_origem" >
                                        <option value=""></option>
                                        <option value="">Sistema</option>
                                        <option value="2">Site</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-4'>
                                    &nbsp;
                                </div>
                                <div class='col-md-4'>
                                    <label for="ic_status">Status:&nbsp;</label>
                                    <select class="form-control form-control-sm" id="ic_status" name="ic_status" >
                                        <option value=""></option>
                                        <option value="1">Ativo</option>
                                        <option value="2">Demitido</option>
                                        <option value="3">Afastado</option>
                                        <option value="3">Férias</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-4" align="center">
                                        <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisar">Pesquisar</button>                         
                                    </div>
                                </div>
                            </form>
                            <p>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <p>
                            
                            <div class="row">
                                <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap" style="width:100%"  id="tblResultado">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Posto de Trab</th>
                                            <th>Colaborador</th>
                                            <th>Pin</th>
                                            <th>Re</th>
                                            <th>Cel</th>
                                            <th>Status App</th>                      
                                            <th>Origem</th>
                                            <th>Status</th>
                                            <th>Cel 2</th>
                                            <th>Função</th>
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
	</div>
</div>

<?
require_once "../inc/php/footer.php";
?>

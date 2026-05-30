<?
require_once "../inc/php/header.php";
?>
<script src="lead_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>
   
</head>    
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
                                    <h6 class="m-0 font-weight-bold text-primary">Pesquisar Lead´s</h6>
                                </div> 
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_padrao'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltarLead">Voltar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdIncluirLead">Novo</button>                       
                                </div>
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_modal'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdFecharModalLead">Fechar</button>                    
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdSalvarModalLead">Incluir</button>                    
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='ds_uf'>Cód Cliente / Posto de Trabalho:</label>
                                <input type="text" name="cod_lead" id="cod_lead" value="" class='form-control form-control-sm'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='ds_uf'>Tipo:</label>
                                <select id="ic_tipo_lead" class='form-control form-control-sm'  name="ic_tipo_lead">
                                    <option ></option>
                                    <option value="1">Cliente</option>
                                    <option value="2">Posto de Trabalho</option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_colaborador">Cliente:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select" id="leads_clientes_pk" >
                                    <option></option>
                                </select>
                            </div>
                        </div>
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
                                <label for='ds_uf'>Segmento:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='segmentos_pk' name='segmentos_pk' >
                                    <option></option>
                                    <option value="1">Condomínios</option>
                                    <option value="2">Escolas</option>
                                    <option value="3">Escritórios</option>
                                    <option value="4">Industrias</option>
                                    <option value="5">Residencial</option>
                                    <option value="6">Pós obra</option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='supervisores_pk'>Supervisor:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='supervisores_pk' name='supervisores_pk' >
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='responsavel_pk'>Responsavel Comercial:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='responsavel_pk' name='responsavel_pk' >
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="ic_status">Status:&nbsp;</label>
                                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                                    <option value=""></option>
                                    <option value="1" selected>Ativo</option>
                                    <option value="2">Desativado</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4" align="center">
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisarLead">Pesquisar</button>                         
                                </div>
                            </div>
                            <p>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <p>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                        <thead>
                                        <th>Cód</th>
                                        <th>Tipo Lead</th>
                                        <th>Lead</th>
                                        <!--th>Bairro</th-->
                                        <th>Cidade</th>
                                        <th>Status</th>
                                        <th>Ação</th>
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
include_once "agenda_cad_form.php";
require_once "../inc/php/footer.php";
?>
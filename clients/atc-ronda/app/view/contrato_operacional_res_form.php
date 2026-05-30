<?
require_once "../inc/php/header.php";
?>
<script src="contrato_operacional_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>
@import "bourbon";
      .label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input[type=text]{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 300px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  
  border-radius:0;
}

.label-float input[type=text]:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input[type=text]:placeholder{
  color:transparent;
}

.label-float label{
  pointer-events: none;
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 13px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
}

.label-float input[type=text]:required:invalid + label{
  color: red;
}
.label-float input[type=text]:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input[type=text]:focus + label,
.label-float input[type=text]:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
.oc_modal{
    cursor:pointer;
}
.doc_modal{
    cursor:pointer;
}
.processo_modal{
    cursor:pointer;
}

</style>





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
                                    <h6 class="m-0 font-weight-bold text-primary">Pesquisar Contrato(s)</h6>
                                </div> 
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_padrao'>
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Novo</button>                       
                                </div>
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_modal'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdFecharModalLead">Fechar</button>                    
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdSalvarModalLead">Incluir</button>                    
                                </div>
                            </div>
                        </div>
                        <div id="x"></div>
                        <div class='row'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='ds_uf'>Cliente:</label>
                                <select id="leads_clientes_pk" class='form-control form-control-sm chzn-select' name="leads_clientes_pk">
                                    <option ></option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='ds_uf'>Posto de Trabalho:</label>
                                <select id="leads_postotrabalho_pk" class='form-control form-control-sm chzn-select' name="leads_pk">
                                    <option ></option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='ds_uf'> Tipos de contrato:</label>
                                <select id="ic_tipo_contrato" class='form-control form-control-sm ' name="ic_tipo_contrato">
                                    <option ></option>
                                    <option value='1'>Contrato</option>
                                    <option value='2'>Aditivo</option>
                                    <option value='3'>Serviços Extras</option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-md-3'>
                                <label for='ds_uf'>DT. Início Contrato:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm'  id='dt_inicio' name='dt_inicio' />
                            </div>
                            <div class='col-md-3'>
                                <label for='ds_uf'>DT. Fim Contrato:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm'  id='dt_fim' name='dt_fim' />
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-md-3'>
                                <label for='ds_uf'>DT. Recisão Contrato:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm'  id='dt_recisao_ini' name='dt_recisao_ini' />
                            </div>
                            <div class='col-md-3'>
                                <label for='ds_uf'>DT. Recisão Contrato:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm'  id='dt_recisao_fim' name='dt_recisao_fim' />
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-md-3'>
                                <label for='ds_uf'>DT. Cancel. Contrato:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm'  id='dt_cancelamento_ini' name='dt_cancelamento_ini' />
                            </div>
                            <div class='col-md-3'>
                                <label for='ds_uf'>DT. Cancel. Contrato:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm'  id='dt_cancelamento_fim' name='dt_cancelamento_fim' />
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4" align="center">
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisarContratos">Pesquisar</button>                         
                                </div>
                            </div>
                            <p>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <p>
                            <div class="row" >
                                <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblContratos">
                                    <thead>
                                        <tr>
                                            <th>Cód</th>
                                            <th>Tipo </th>
                                            <th>Posto de Trabalho</th>
                                            <th>Nome Fantas<br>Setor Indent</th>
                                            <th>Tipo Contrato</th>
                                            <th>DT. Inicio Contrato</th>
                                            <th>DT. Fim Contrato</th>
                                            <th>Vl Serviço</th>
                                            <th>Vl Mão de Obra</th>
                                            <th>Vl Contrato</th>
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

<?include_once("contrato_operacional_cad_form.php")?>

<?
require_once "../inc/php/footer.php";
?>

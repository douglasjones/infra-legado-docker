<?
require_once "../inc/php/header.php";
?>
<script src="inc_movimentar_material_prod_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
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
                                    <h6 class="m-0 font-weight-bold text-primary">Movimentação Estoque</h6>
                                </div> 
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_padrao' >
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltarLead">Voltar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdIncluirConjuntoMaterial">Novo</button>                       
                                </div>
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_modal'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdFecharModalLead">Fechar</button>                    
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdSalvarModalLead">Incluir</button>                    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class='row'>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="fornecedor_pk">Grupo Para Movimentação:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select" id="grupo_para_movimentacao_pk">
                                    <option></option>
                                    <option value="1">Colaborador(es)</option>
                                    <option value="2">Posto(s) de Trabalho</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class='row'>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="fornecedor_pk">Categorias:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select" id="categoria_res_pk">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="fornecedor_pk">Produtos:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select" id="produtos_res_pk">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <label for="ic_status">DT Mov. Ini:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="dt_movimentacao_ini" maxlength="10">
                            </div>
                            <div class="col-md-2">
                                <label for="ic_status">DT Mov. Fim:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="dt_movimentacao_fim" maxlength="10">
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
                            <p>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <p>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Grupo Movimentação</th>
                                                <th>Colaborador/Posto</th>
                                                <th>Categoria</th>
                                                <!--th>Produto</th-->
                                                <th>Qtde</th>
                                                <th>DT Movimentação</th>
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
include_once "inc_movimentar_material_prod_cad_form.php";
require_once "../inc/php/footer.php";
?>

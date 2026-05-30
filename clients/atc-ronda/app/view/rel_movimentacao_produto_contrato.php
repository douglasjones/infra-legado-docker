<?
require_once "../inc/php/header.php";
?>
<script src="rel_movimentacao_produto_contrato.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Extrato de Movimentação de Produtos por Contrato</h6>
                                </div> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='ds_tel'>Lead: </label>
                                <select type='text' class='form-control form-control-sm chzn-select'  id='leads_pk' name='leads_pk'>
                                    <option></option>
                                </select>
                            </div>            
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for='clientes_pk'>Data Troca:</label>
                            </div>
                        </div>  
                        
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <input class='form-control form-control-sm'  id='dt_troca_ini' name='dt_troca_ini'>
                            </div>
                            <div class="col-md-2">
                                <input class='form-control form-control-sm'  id='dt_troca_fim' name='dt_troca_fim'>
                            </div>
                        </div> 

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4" align="center">
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisarMovimentacaoEstoqueProduto">Pesquisar</button>                         
                                </div>
                            </div>
                            <p>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <p>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblMovimentacaoProdutoContrato">
                                        <thead>
                                            <th>Lead</th>
                                            <th>Produto</th>
                                            <th>Unidade</th>
                                            <th>Op.</th> 
                                            <th>Quant</th>
                                            <th>Vl. Unitario</th>
                                            <th>Vl. Total</th>
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
<?
require_once "../inc/php/header.php";
?>
<script src="compras_solicitacao_orcamentos_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<br> 
<div class="row">
    <div class="col-md-12">
        <h5>Orçamento(s)</h5>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" id="btnNewOrcamento"   name="btnNewOrcamento" >Incluir Orçamento</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Cód</th>       
                    <th>fornecedor_pk</th>
                    <th>Fornecedor</th>
                    <th>Dt Previsão Entrega</th>
                    <th>Vl do Frete</th>
                    <th>Vl Total Orçar</th>
                    <th>Ic_status</th>
                    <th>Status</th> 
                    <th>Obs</th> 
                    <th>Solicitacao Compra</th>                         
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>

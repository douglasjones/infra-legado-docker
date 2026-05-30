<?
require_once "../inc/php/header.php";
?>
<script src="produto_add.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="modal fade bd-example-modal-lg"  id="janela_adicionar_produto">
                <form id="adicionar_produto">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content" >
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class='col-sm-6' align="left">
                                        <h6 class="m-0 font-weight-bold text-primary">Adicionar Produto</h6>     
                                    </div>
                                    <div class='col-sm-6' align="right">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>    
                                        <button type="submit" class="btn btn-primary" id="cmdEnviarProduto" onclick='fcValidarFormProduto()' name="cmdEnviarProduto">Incluir</button>
                                    </div> 
                                </div>
                            </div>
                            <div class="card-body">
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='categoria_pk_modal'>Categoria:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='categoria_pk_modal' name='categoria_pk_modal'>
                                            <option></option>
                                        </select>  
                                    </div> 
                                </div> 
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp;
                                    </div> 
                                    <div class='col-md-4'>
                                        <label for='ds_produto_modal'>Produto:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm'  id='ds_produto_modal' name='ds_produto_modal'>  
                                    </div> 
                                </div>
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='ic_status_modal'>Status:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='ic_status_modal' name='ic_status_modal'>
                                            <option value='1'>Ativo</option>
                                            <option value='2'>Inativo</option>
                                        </select>  
                                    </div> 
                                </div>  
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" align='right' data-dismiss="modal" class="btn btn-secondary">Fechar</button>
                                <button type="submit" align='right' class="btn btn-primary" id="cmdEnviarProduto" onclick='fcValidarFormProduto()'  name="cmdEnviarProduto">Incluir</button>
                            </div>    
                        </div>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>

<?
require_once "../inc/php/footer.php";
?>
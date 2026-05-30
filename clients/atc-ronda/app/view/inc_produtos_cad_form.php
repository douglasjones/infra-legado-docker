<?
require_once "../inc/php/header.php";
?>
<script src="inc_produtos_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="produto_estoque_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<form id="form_produtos" class="form">
    <div class="modal fade bd-example-modal-lg" id="janela_produto" >
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Novo Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <input type='hidden' class='form-control form-control-sm'  id='produtos_pk' name='produtos_pk'>
                <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='categorias_produto_pk'>Categorias:&nbsp;</label>                
                        <select class='form-control form-control-sm chzn-select'  id='modal_categorias_produto_pk' name='modal_categorias_produto_pk'>
                            <option></option>
                        </select>
                     </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Produto / Materiais:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="ds_produto" name="ds_produto"/>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Unidade:&nbsp;</label>
                        <select class='form-control form-control-sm chzn-select'  id='tipo_unidade_pk' name='tipo_unidade_pk'>
                            <option></option>
                            <option value='1'>Caixa</option>
                            <option value='2'>Par</option>
                            <option value='3'>Unidade</option>
                            <option value='4'>Conjunto</option>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='ic_status'>Status:&nbsp;</label>
                        <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>
                </div>                
            </div>  
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="cmdEnviarExames"  name="cmdEnviarProdutos">Salvar</button>
            </div>
            </div>
        </div>
    </div>  
</form>

<?
require_once "../inc/php/header.php";
?>
<script src="inc_materiais_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<form id="form_materiais" class="form">
    <div class="modal fade bd-example-modal-lg" id="janela_materiais" >
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Incluir Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <input type='hidden' class='form-control form-control-sm'  id='movimentacao_estoque_pk' name='movimentacao_estoque_pk'>
                <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Categoria:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='categorias_produto_pk' name='categorias_produto_pk' requered/>
                            <option></option>
                        </select>    
                    </div>
                </div> 
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Produtos:&nbsp;</label>
                        <select class='form-control form-control-sm chzn-select'  id='produtos_pk' name='produto_pk' requered/>
                            <option></option>
                        </select>    
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='processos_pk'>Quantidade:&nbsp;</label>
                        <input type="text" class='form-control form-control-sm'  id='qtde_materias' name='qtde_materias'/>  
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Materiais:&nbsp;</label>
                        <select class='form-control form-control-sm chzn-select'  id='produtos_itens_pk' name='produtos_itens_pk' requered/>
                            <option></option>
                        </select>    
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>Data Entrega:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="dt_entrega" name="dt_entrega"/>
                    </div>
                </div>
                <div class='row' id="div_dt_devolucao" style="display:none">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>Data Devolução:&nbsp;</label>
                        <input type='text' class=" form-control form-control-file" id="dt_devolucao" name="dt_devolucao"/>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='processos_pk'>Material Carga:&nbsp;</label>
                        <input type='checkbox'  id="ic_mateiral_carga" name="ic_mateiral_carga"/>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='processos_pk'>Observação:&nbsp;</label>
                        <textarea class=" form-control form-control-file" id="obs_material" name="obs_material"></textarea>
                    </div>
                </div>
            </div>  
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="cmdEnviarMateriais"  name="cmdEnviarMateriais">Enviar</button>
            </div>
            </div>
        </div>
    </div>  
</form>

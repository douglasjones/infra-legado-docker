<?
require_once "../inc/php/header.php";
?>
<script src="movimentar_material_prod_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
    <div class="row">
        <div class="col-md-12">
            <h2>Movimentação de Estoque</h2>
        </div>
    </div>
    <form method="post">
        
        <div class="row">
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
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="fornecedor_pk"><span id='str_opc'></span>&nbsp;</label>
                <select class="form-control form-control-sm chzn-select" id="movimentar_para_pesq_pk">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
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
        <div class="row">
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
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
                &nbsp;
                <button type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Incluir</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Grupo Movimentação</th>
                    <th>Colaborador/Posto</th>
                    <th>Categoria</th>
                    <th>Produto</th>
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

<form id="form_materiais" class="form">
    <div class="modal fade bd-example-modal-lg" id="janela_materiais" >
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Movimentar Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <input type='hidden' class='form-control form-control-sm'  id='count_material' name='count_material'>
                <input type='hidden' class='form-control form-control-sm'  id='movimentacao_estoque_pk' name='movimentacao_estoque_pk'>
                <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                
                
                
                <div class="row">
                    <div class="col-md-2">
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for="fornecedor_pk">Grupo Para Movimentação:&nbsp;</label>
                        <select class="form-control form-control-sm chzn-select" id="grupo_para_movimentacao_ins_pk">
                            <option></option>
                            <option value="1">Colaborador(es)</option>
                            <option value="2">Posto(s) de Trabalho</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for="fornecedor_pk"><span id='str_opc_ins'></span>&nbsp;</label>
                        <select class="form-control form-control-sm chzn-select" id="movimentar_para_pk">
                            <option></option>
                        </select>
                    </div>
                </div>
                
                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-6'>
                        <label for='processos_pk'>Categoria:&nbsp;</label>
                        <select class='form-control form-control-sm chzn-select'  id='categorias_produto_pk' name='categorias_produto_pk' requered/>
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


<?
require_once "../inc/php/footer.php";
?>

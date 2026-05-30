<?
require_once "../inc/php/header.php";
?>
<script src="estoque_baixa_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Baixa Estoque</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_n_ordem">Posto de Trabalho:&nbsp;</label>
                <select  class="form-control form-control-sm" id="leads_pk" required="true"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_n_ordem">Categorias:&nbsp;</label>
                <select class="form-control form-control-sm" id="categorias_pk"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_n_ordem">Produtos:&nbsp;</label>
                <select class="form-control form-control-sm" id="produtos_pk"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <div class="form-group">
                   <label for="ds_n_ordem">Data Inicio Movimentação:&nbsp;</label>
                    <input type="text" class="form-control form-control-sm" id="dt_inicio" >
                </div>
            </div>  
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="ds_n_ordem">Data Fim Movimentação:&nbsp;</label>
                    <input type="text" class="form-control form-control-sm" id="dt_fim" >
                </div>    
            </div>  
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_n_ordem">Status:&nbsp;</label>
                <select class="form-control form-control-sm" id="ic_status">
                    <option></option>
                    <option value="1">Baixado</option>
                    <option value="2">Não Baixado</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
                
            </div>
        </div>
    </form>
    <div class="row col-md-12" align="center">
        <div class="col-md-2">
            &nbsp;
        </div> 
        <div class="col-md-4 " style="background-color:#f2f2f2;">
            <div class="text-center" >
                <font color="black">Não Baixado</font> 
            </div>
        </div>
        <div class="col-md-4 " style="background-color:#1dc2ff;">
            <div class="text-center" >
                <font color="white">Baixado</font> 
            </div>
        </div>
        <div class="col-md-3">
            &nbsp;
        </div> 
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Cód</th>    
                    <th>Titulo Produto</th>
                    <th>Produto</th>
                    <th>Categoria</th>
                    <th>Posto de Trabalho</th>
                    <th>Dt Movimentação</th>
                    <th>Dt Baixa</th>
                    <th>Obs Baixa</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class="container">    
    <form id="form" class="form">
        <div class="modal fade bd-example-modal-lg" id="janela_baixa" >
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="janela_contatosLabel">Baixa Produto Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                                    
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-10'>
                                <div id="ds_produto"></div>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="produtos_itens_pk" id="produtos_itens_pk"/>

                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-4'>
                                <label for='tipo_ocorrencia_pk'>Data Baixa&nbsp;</label>
                                <input type="text" class='form-control form-control-sm'  id='dt_baixa' name='dt_baixa' />
                            </div>
                        </div>
                        <div class='row' id="alert_dt_baixa" style="display:none">
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Data Baixa</strong>
                        </div>
                    </div>
                        <div class="row">
                            <div class='col-md-2'>
                                &nbsp;                                             
                            </div>
                            <div class='col-md-10'>
                                <label for='tipo_ocorrencia_pk'>Obs Baixa&nbsp;</label>
                                <textarea class='form-control form-control-sm'  id='obs_baixa' name='obs_baixa' ></textarea>
                            </div>
                        </div>
                          
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary" id="cmdEnviarBaixa"  name="cmdEnviarBaixa">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

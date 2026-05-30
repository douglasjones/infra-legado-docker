<?
require_once "../inc/php/header.php";
?>

<script src="entrada_estoque_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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


</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Entrada de Estoque</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='categorias_pk'>Categoria:&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='categorias_produto_pk' name='categorias_produto_pk' requered/>
                    <option></option>
                </select>    
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='fornecedor_pk'>Foenecedor:&nbsp;</label>         
                <select class='form-control form-control-sm chzn-select'  id='fornecedor_pk' name='fornecedor_pk' requered/>
                    <option></option>
                </select>    
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='produtos_pk'>Produto:&nbsp;</label>         
                <select class='form-control form-control-sm chzn-select'  id='produtos_pk' name='produto_pk' requered/>
                    <option></option>
                </select>    
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='produtos_pk'>Valor Unitário:&nbsp;</label> 
                <input type="text" class='form-control form-control-sm' id="vl_unitario" name="vl_unitario"/>    
            </div>
        </div>
        
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='qtde'>Quantidade:&nbsp;</label>
                <input type="text" class='form-control form-control-sm' id="qtde" name="qtde" maxlength="5" placeholder=" "/>               
                <input type="hidden" id="qtde_registro" name="qtde_registro"/>               
           </div>
        </div>
        <br>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class="form-group">
                <label for='ds_senha'>&nbsp;&nbsp;&nbsp;&nbsp;Listar Itens:</label>
            </div>
            <div class='col-md-2'>
                <input type="checkbox" id="ic_listar_itens" name="ic_listar_itens" />      
            </div>
        </div>

         <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_n_ordem'>N Ordem:&nbsp;</label>
                <input type="text" class='form-control form-control-sm' id="ds_n_ordem" name="ds_n_ordem" maxlength="50" placeholder=" "/>               
           </div>
        </div>        
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <label for='obs_entrada_estoque'>Observação:&nbsp;</label>
                <textarea  class=" form-control form-control-file" id="obs_entrada_estoque" name="obs_entrada_estoque"></textarea>
            </div>
        </div>
        <p>
        <div id="exibir_grid_produto_itens" style="display:none">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered " style="width:100%" id="tblProdutoItens">
                        <thead>
                            <tr>
                                <th style="width:2%">Cód.</th>
                                <th>Nº de Serie</th>
                            </tr>
                        </thead>
                        <tbody class="hover">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        </p>
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Voltar</button>                
                &nbsp;
                <button type="submit" class="btn btn-primary" id="cmdEnviar">Enviar</button>
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

<?
require_once "../inc/php/header.php";
?>

<script src="produto_servico_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Serviços</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    <form id="form" class="form">       
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_produto_servico'>Produto/Serviço:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_produto_servico' name='ds_produto_servico' required >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for='ds_produto_servico'>CBO:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_cbo' name='ds_cbo' >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='vl_servico'>Valor Serviço:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='vl_servico' name='vl_servico' >
            </div>
        </div>
        <p>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>
                &nbsp;
                <button type="submit" class="btn btn-primary" id="cmdEnviar">Salvar</button>                
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

<?
require_once "../inc/php/header.php";
?>

<script src="modulo_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Módulos</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    
    <form id="form" class="form">

        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_modulo'>Módulo: </label>
                <input type='text' class='form-control form-control-sm' id='ds_modulo' name='ds_modulo' required >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_dominio'>Domínio: </label>
                <input type='text' class='form-control form-control-sm' id='ds_dominio' name='ds_dominio' required >
            </div>
        </div>
        <p>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="cmdEnviar">Salvar</button>
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

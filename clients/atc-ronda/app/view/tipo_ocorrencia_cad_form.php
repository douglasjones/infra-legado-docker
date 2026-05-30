<?
require_once "../inc/php/header.php";
?>

<script src="tipo_ocorrencia_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Tipo Ocorrências</h4>
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
                <label for='ds_tipo_ocorrencia'>Tipo ocorrência:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_tipo_ocorrencia' name='ds_tipo_ocorrencia' required >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_fechar_ocorrencia_auto">Fechar ocorrência:&nbsp;</label>
                <select id="ic_fechar_ocorrencia_auto" class="form-control form-control-sm" name="ic_fechar_ocorrencia_auto">
                    <option value=""></option>
                    <option value="1">Sim</option>
                    <option value="2">Não</option>
                </select>
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

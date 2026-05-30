<?
require_once "../inc/php/header.php";
?>

<script src="plano_contas_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Plano de Contas</h4>
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
                <label for='categorias_financeiras_pk'>Categoria:&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='categorias_financeiras_pk' name='categorias_financeiras_pk' />
                    <option></option>
                </select> 
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_tipo_operacao'>Tipo Operação:&nbsp;</label>
                <input type="text" id="ds_tipo_operacao" class='form-control form-control-sm' name="ds_tipo_operacao" maxlength="100" />   
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-3">
                <label for="ic_status">Status:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
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

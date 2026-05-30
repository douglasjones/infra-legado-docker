<?
require_once "../inc/php/header.php";
?>

<script src="supervisao_auditoria_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Supervisão Auditoria</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        <div class='row'>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="leads_pk">Posto Trabalho:&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='leads_pk' name='leads_pk'>
                        <option></option>
                </select>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="leads_pk">Tipo Auditória:&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='auditoria_categoria_pk' name='auditoria_categoria_pk'>
                        <option></option>
                </select>
            </div>
        </div>
        <p>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ic_contato_cliente'>Falou com o Cliente:</label>
                <input  type='checkbox' id='ic_contato_cliente' name='ic_contato_cliente' />
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='obs_contato_cliente'>Observação Cliente:&nbsp;</label>
                <textarea id="obs_contato_cliente" name="obs_contato_cliente" rows="5" cols="50"></textarea>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='obs_geral'>Observação Geral:&nbsp;</label>
                <textarea id="obs_geral" name="obs_geral" rows="5" cols="50"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">  
                      
            <div class="col-md-12" align="right">

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

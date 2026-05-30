<?
require_once "../inc/php/header.php";
?>
<script src="rel_agenda_condominio_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Agenda Condomínio Período</h2>
        </div>
    </div>
    <form id="form" class="form">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                <label for="dt_periodo_ini">Período Início:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_periodo_ini' name='dt_periodo_ini' value="">                
            </div>
            <div class="col-md-2">
                <label for="dt_periodo_fim">Período Fim:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_periodo_fim' name='dt_periodo_fim' value="">         
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="leads_pk">Lead:&nbsp;</label>
                <select id="leads_pk" class="form-control form-control-sm" name="leads_pk" id="leads_pk">
                    <option value=""></option>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="submit" class="btn btn-secondary" id="cmdEnviar">Enviar</button>
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

<?
require_once "../inc/php/header.php";
?>
<script src="rel_conciliacao_colaborador_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Conciliação por Colaborador</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                <label for="ic_mes">Mês:&nbsp;</label>
                <select id="ic_mes" class="form-control form-control-sm" name="ic_mes">
                    <option value=""></option>
                    <option value="01">Janeiro</option>
                    <option value="02">Fevereiro</option>
                    <option value="03">Março</option>
                    <option value="04">Abril</option>
                    <option value="05">Maio</option>
                    <option value="06">Junho</option>
                    <option value="07">Julho</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for='ds_ano'>Ano:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_ano' maxlength="4" name='ds_ano' required >
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="leads_pk">Colaborador:&nbsp;</label>
                <select id="colaboradores_pk" class="form-control form-control-sm" name="colaboradores_pk" id="colaboradores_pk">
                    <option value=""></option>
                </select>
            </div>
        </div>
        <p>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Voltar</button>
                <button type="submit" class="btn btn-primary" id="cmdEnviar">Gerar Relatório</button>                
            </div>
        </div>
        <br>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

<?
require_once "../inc/php/header.php";
?>

<script src="nota_fiscal_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Nota Fiscal</h2>
            <hr>
        </div>
    </div>
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
                <label for='ds_tipo_servico'>Servico:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_tipo_servico' name='ds_tipo_servico' required >
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='dt_faturamento'>Data Faturamento:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='dt_faturaemtno' name='dt_faturamento' required >
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='dt_emissao'>Data Emissao:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='dt_emissao' name='dt_emissao' required >
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='vl_bruto'>VL Bruto.:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='vl_bruto' name='vl_bruto' required >
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='vl_liquido'>VL Liquido:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='vl_liquido' name='vl_liquido' required >
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='dt_cancelamento'>Cliente:&nbsp;</label>
                <select class='form-control form-control-sm'  id='leads_pk' name='leads_pk' />
                            <option></option>
               </select>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_xml'>Contrato:&nbsp;</label>
                <select class='form-control form-control-sm'  id='ds_xml' name='ds_xml' />
                    <option></option>
                </select>
            </div>
        </div>
    <br>
        <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='obs'> Observação:&nbsp;</label>
                        <textarea  rows="5" cols="30" id="obs" name="obs"></textarea>
                    </div>
                </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="Right">
            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            <br>
                <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                &nbsp;
                <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarCondutor">Salvar</button>                
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

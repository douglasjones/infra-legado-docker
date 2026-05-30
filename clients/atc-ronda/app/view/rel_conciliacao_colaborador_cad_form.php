<?
require_once "../inc/php/header.php";
?>
<script src="rel_conciliacao_colaborador_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container col-md-10">
    <p>
    <div class="row">
        <div class="col-md-4">
            &nbsp;
        </div>
        <div class="col-md-4" align="center">
            <button type="button" class="btn btn-secondary" id="cmdCancelar">Voltar</button>
            <button type="button" class="btn btn-primary" id="cmdExport">Export</button>            
        </div>
    </div>
    <p>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id='form'>
        <table>
            <tr>
                <td>
                    <h4><div id="ds_colaborador"></div></h4>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <b>Dt Emissão:</b>
                </td>
                <td>
                    <div id="dt_emissao"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Mês:</b>
                </td>
                <td>
                   <div id="ic_mes"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Ano:</b>
                </td>
                <td>
                   <div id="ds_ano"></div>
                </td>
            </tr>
        </table>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12">
                <div id="form_grid">
                    <div id="grid"></div>
                </div>
            </div>
        </div>
    </form>    
</div>
<?
require_once "../inc/php/footer.php";
?>

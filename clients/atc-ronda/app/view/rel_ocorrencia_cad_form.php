<?
require_once "../inc/php/header.php";
?>
<script src="rel_ocorrencia_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                     <h4>Relatório de Ocorrências</h4>
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
            <tr borer>
                <td>
                    <b>Lead:</b>
                </td>
                <td>
                    <div id="ds_lead"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Tipo Ocorrência:</b>
                </td>
                <td>
                    <div id="ds_tipo_oc"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Usuário Cadastro:</b>
                </td>
                <td>
                    <div id="ds_usuario_cadastro"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Agendado Para:</b>
                </td>
                <td>
                    <div id="ds_usuario_agendado_para"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Data Abertura Oc:</b>
                </td>
                <td>
                    <div id="dt_abertura_oc_ini_fim"></div>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Status Ocorrência:</b>
                </td>
                <td>
                    <div id="ds_status_oc"></div>
                </td>
            </tr>
        </table>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12">
               <div id="grid"></div>
            </div>
        </div>
    </form>
</div>

<?
require_once "../inc/php/footer.php";
?>

<?
require_once "../inc/php/header.php";

?>
<script src="rel_titulo_plano_contas_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container col-md-12">
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
    <form action="arquivoExcel.php" method="post" target="_blank" id="FormularioExportacao">
        <input type="hidden" id="dados_a_enviar" name="dados_a_enviar" />
    </form>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id='form'>
        <table>
            <tr>
                <td>
                    <b>Relatório:</b>
                </td>
                <td>
                    Títulos por Plano de Contas
                </td>
            </tr>
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
                    <b>Usuário Emissão:</b>
                </td>
                <td>
                    <div id="dt_usuario"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Período Vencimento:</b>
                </td>
                <td>
                   <div id="dt_periodo"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Tipo Lançamento:</b>
                </td>
                <td>
                   <div id="ds_tipo_lancamento"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Empresas:</b>
                </td>
                <td>
                   <div id="ds_empresa"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Grupo Origem do Lançamento:</b>
                </td>
                <td>
                   <div id="ds_tipo_grupo"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Recebido de ? / Pago de ?:</b>
                </td>
                <td>
                   <div id="ds_grupo_leancamento"></div>
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
                     <b>Status:</b>
                </td>
                <td>
                   <div id="ds_ic_status"></div>
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

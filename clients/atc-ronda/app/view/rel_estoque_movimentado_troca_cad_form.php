<?
require_once "../inc/php/header.php";

?>
<script src="rel_estoque_movimentado_troca_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
    
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id='form'>
        <table>
            <tr>
                <td>
                    <b>Relatório:</b>
                </td>
                <td>
                    Estoque Movimentado Troca
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
                    <b>Dt Troca:</b>
                </td>
                <td>
                   <div id="dt_troca"></div>
                </td>
            </tr>

            <tr>
                <td>
                     <b>Lead:</b>
                </td>
                <td>
                   <div id="ds_lead"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Colaborador:</b>
                </td>
                <td>
                   <div id="ds_colaborador"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Categoria:</b>
                </td>
                <td>
                   <div id="ds_categoria"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Produto:</b>
                </td>
                <td>
                   <div id="ds_produto"></div>
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

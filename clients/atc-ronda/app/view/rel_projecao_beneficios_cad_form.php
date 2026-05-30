<?
require_once "../inc/php/header.php";

?>
<script src="rel_projecao_beneficios_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="jquery.btechco.excelexport.js"></script>
<script src="jquery.base64.js"></script>

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
       <!--- <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>-->
        <form id='form' name="form">
            <table id="export">
                <table id="head" class="row" style='width:100%; margin:1em'>
                        <tr>
                            <td>
                                <b>Relatório:</b>
                            </td>
                            <td>
                                Projeção de Beneficios
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
                                <b>Colaborador:</b>
                            </td>
                            <td>
                                <div id="ds_colaborador"></div>
                            </td>
                            <td>
                                <div></div>
                            </td>
                            <td>
                                <b>Periodo Benef:</b>
                            </td>
                            <td>
                                <div id="ds_periodo"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Posto de Trabalhado:</b>
                            </td>
                            <td>
                                <div id="ds_lead"></div>
                            </td>
                            
                            <td>
                                <div></div>
                            </td>
                            <td>
                                <b>Qualificação:</b>
                            </td>
                            <td>
                                <div id="ds_qualificacao"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Turno:</b>
                            </td>
                            <td>
                                <div id="ds_turno"></div>
                            </td>
                        </tr>
                </table>
                <hr style='background-color:#14074F; margin: 1em;'>
                <div class="row"  style=' align-items: center'>
                   <table id="grid" class='table table-bordered' style='width:98%; margin:1em;' id='tblResultado'></table>
                </div>
            </table>
        </form>  
        
</div>
<?
require_once "../inc/php/footer.php";
?>

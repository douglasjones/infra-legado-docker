<?
require_once "../inc/php/header.php";

?>
<script src="ponto_rel_sintetico_dados_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                        <b>Dt Início:</b>
                    </td>
                    <td>
                       <div id="dt_ini"></div>
                    </td>
                </tr>
                <tr>
                    <td>
                         <b>Dt Fim:</b>
                    </td>
                    <td>
                       <div id="dt_fim"></div>
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
            </table>
            <div class="row col-md-12" align="center">
                <div class="col-md-5">
                    &nbsp;
                </div> 
                <div class="col-md-2 ">
                    <div class="text-center" >
                        <b>Legenda</b>
                    </div>
                </div>
                <div class="col-md-3">
                    &nbsp;
                </div> 
            </div>
            <p>
            <div class="row col-md-12" align="center">
                <div class="col-md-1">
                    &nbsp;
                </div> 
                <div class="col-md-2 " style="background-color:c3c3c1">
                    <div class="text-center" >
                        <font> Atraso de 1 Min até 9:59 Min</font> 
                    </div>
                </div> 
                <div class="col-md-2 " style="background-color:e6df55">
                    <div class="text-center" >
                        <font> Atraso de 10 Min até 14:59 Min</font> 
                    </div>
                </div> 
                <div class="col-md-2 "  style="background-color:f99856;">
                    <div class="text-center">
                         <font>Atraso de 15 Min até 24:59 Min</font> 
                    </div>
                </div> 
                <div class="col-md-2 "  style="background-color:ec1c24;">
                    <div class="text-center">
                         <font color='#fff' >Atraso acima de 25 Min</font> 
                    </div>
                </div>

                <div class="col-md-2 "  style="background-color:34ac54;">
                    <div class="text-center">
                         <font color='#fff' >Tempo Positivo</font> 
                    </div>
                </div>
            </div>
            <p>
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

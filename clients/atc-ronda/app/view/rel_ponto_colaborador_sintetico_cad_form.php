<?
require_once "../inc/php/header.php";

?>
<script src="rel_ponto_colaborador_sintetico_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
    .titulo_calendario_anterior{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_grid_produto_servico{
        background-color: #c3c3c3;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_atual{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_seguinte{
        background-color: #e0e0e0;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .subtitulo_calendario{
        text-align: center;
    }
    .corpo{
        border-right-style: dashed;
        border-right-width: thin;        
    }
    .modal-content1{
        width: 1200px;
    }
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
.galeria img:hover {
  -webkit-transform: scale(3.3);
  -moz-transform: scale(3.3);
  -o-transform: scale(3.3);
  -ms-transform: scale(3.3);
  transform: scale(3.3);
}
</style>
<div id="loader"></div>
<div class="container col" id="exibir" style="display:none">
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
            <br>
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
                         <font >Atraso acima de 25 Min</font> 
                    </div>
                </div>
                <div class="col-md-1">
                    &nbsp;
                </div> 
                <div class="col-md-2 "  style="background-color:34ac54;">
                    <div class="text-center">
                         <font >Tempo Positivo</font> 
                    </div>
                </div>
            </div>
            <br>
            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            <p>
            <div class="row">
                <div class="col-md-12">
                    <div id="grid"></div>
                </div>
            </div>
        </form>    
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="janela_modal_mapa" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="janela_contatosLabel">Maps</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class='col-md-12'>
                        <div id="html_maps"></div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?
require_once "../inc/php/footer.php";
?>

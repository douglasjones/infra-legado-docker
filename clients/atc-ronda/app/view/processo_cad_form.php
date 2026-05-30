<?
include_once "../inc/php/header.php";
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<script src="processo_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
    td.details-control {
        background: url('../img/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../img/details_close.png') no-repeat center center;
    }     
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
.label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 350px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -webkit-appearance:none;
  border-radius:0;
}

.label-float input:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input::placeholder{
  color:transparent;
}

.label-float label{
  pointer-events: none;
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 13px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
}

.label-float input:required:invalid + label{
  color: red;
}
.label-float input:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input:focus + label,
.label-float input:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
    .titulo_calendario_anterior{
        background-color: #DFF0D8;
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
        background-color: #9fd3f6;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_seguinte{
        background-color: #FCF8E3;
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
    .borda{
        width:100px;
        height:100px;
        border:solid 1px;
        
      }
      
    .scroll { 
      overflow-x: scroll;
      overflow-y: hidden;
      white-space:nowrap;
    } 

</style>
<div id="loader"></div>
<div class="container" id="exibir" style="display:none">
    <div class="row">
        <div class="col-md-12">
            <h4>Processo Operacional</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        <div class='row'>
            <div >
                <label class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;<b>ID Lead:</b> </label>
            </div>
            <div class='col-md-2'>
                <div class=' leads_pk_cad'></div>
            </div>
        </div>
         <div class='row'>
            <div class="">
                <label class="col-xs-2 control-label"><b>&nbsp;&nbsp;&nbsp;&nbsp;Lead:</b> </label>
            </div>
            <div class='col-md-8'>
                <div class=' ds_lead_cad'></div>
            </div>
        </div>
        <div class='row'>
            <div class="">
                <label class="col-xs-2 control-label"><b>&nbsp;&nbsp;&nbsp;&nbsp;Processo:</b> </label>
            </div>
            <div class='col-md-2'>
                <div id="ds_processo"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="right">
                &nbsp;
                <button type="button" class="btn btn-secondary" id="cmdCancelarProcesso1">Retornar ao Lead</button>
            </div>
        </div>
       <div class="row">
            <div class="col-md-12">
                <div>
                    <hr>
                    <!--ETAPA 1-->
                    <h4 id="etapas_1"></h4>
                    <div id="inc_etapas_1"></div>  
                    <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_1' name='processos_etapas_pk_1'>
                    <br>
                
                    <!--ETAPA 2-->
                    <h4 id="etapas_2"></h4>
                    <?include_once("contrato_operacional_res_form.php")?>
                    <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_2' name='processos_etapas_pk_2'>
                    <br>

                     <!--ETAPA 4-->
                    <h4 id="etapas_3"></h4>
                    <?include_once("inc_agenda_escala_res_form.php")?>
                    <input type='hidden' class='form-control form-control-sm'  id='processos_etapas_pk_4' name='processos_etapas_pk_4'>
                </div>
            </div>
        </div>
        <p>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12" align="right">
                &nbsp;
                <button type="button" class="btn btn-secondary" id="cmdCancelarProcesso">Retornar ao Lead</button>
            </div>
        </div>       
    </form>
    <!--MODAL CONTRATOS-->
    <style>
        .modal .modal-dialog { width: 100%; } 
    </style>
</div>
<?
include_once "../inc/php/footer.php";
?>

<?
require_once "../inc/php/header.php";
?>
<script src="rel_ponto_colaborador_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>
    @import "bourbon";
      .label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input[type=text]{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 300px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  
  border-radius:0;
}

.label-float input[type=text]:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input[type=text]:placeholder{
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

.label-float input[type=text]:required:invalid + label{
  color: red;
}
.label-float input[type=text]:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input[type=text]:focus + label,
.label-float input[type=text]:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}


</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Relatório de Ponto</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='ds_tel'>Ponto De: </label>
                <input type='text' class='form-control form-control-sm'  id='dt_ini' name='dt_ini'>
            </div>
            <div class='col-md-2'>
                <label for='ds_tel'>Ponto Até: </label>
                <input type='text' class='form-control form-control-sm'  id='dt_fim' name='dt_ate'>
            </div>
        </div>
        <p>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for='clientes_pk'>Leads</label>
                <select class='form-control form-control-sm chzn-select'  id='ds_lead' name='ds_lead'>
                    <option></option>
                </select>
            </div>
        </div>
        <p>
        <p>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for='clientes_pk'>Colaboradores</label>
                <select class='form-control form-control-sm chzn-select'  id='colaboradores_pk' name='colaboradores_pk'>
                    <option></option>
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

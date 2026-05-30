<?
require_once "../inc/php/header.php";
?>
<script src="rel_sla_ocorrencia_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
            <h4>Relatório SLA Ocorrência(s)</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for='clientes_pk'>Período Abertura Oc:</label>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                <input class='form-control form-control-sm'  id='dt_abertura_ini' name='dt_abertura_ini'>
            </div>
            <div class="col-md-2">
                <input class='form-control form-control-sm'  id='dt_abertura_fim' name='dt_abertura_fim'>
            </div>
        </div> 
        <p>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for='clientes_pk'>Período Execução Oc:</label>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                <input class='form-control form-control-sm'  id='dt_execucao_ini' name='dt_execucao_ini'>
            </div>
            <div class="col-md-2">
                <input class='form-control form-control-sm'  id='dt_execucao_fim' name='dt_execucao_fim'>
            </div>
        </div> 
        <p>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for='clientes_pk'>Período Fechamento Oc:</label>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                <input class='form-control form-control-sm'  id='dt_fechamento_ini' name='dt_fechamento_ini'>
            </div>
            <div class="col-md-2">
                <input class='form-control form-control-sm'  id='dt_fechamento_fim' name='dt_fechamento_fim'>
            </div>
        </div> 
        <p>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_tel'>Equipe: </label>
                <select type='text' class='form-control form-control-sm chzn-select'  id='equipes_pk' name='equipes_pk'>
                    <option></option>
                </select>
            </div>            
        </div>
        <p>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_tel'>Leads: </label>
                <select type='text' class='form-control form-control-sm chzn-select'  id='leads_pk' name='leads_pk'>
                    <option></option>
                </select>
            </div>            
        </div>
        <p>
        
        <br>
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

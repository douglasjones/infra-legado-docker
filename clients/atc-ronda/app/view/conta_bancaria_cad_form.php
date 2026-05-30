<?
require_once "../inc/php/header.php";
?>

<script src="conta_bancaria_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
            <h4>Conta Bancária</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    <form id="form" class="form">
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipo_conta_pk'>Tipo de Conta:&nbsp;</label>
                 <select class='form-control form-control-sm'  id='tipo_conta_pk' name='tipo_conta_pk'/>
                    <option></option>
                    <option  value="1">Conta Corrente</option>
                    <option  value="2">Poupança</option>
                    <option  value="3">Investimento</option>
                    <option  value="4">Caixinha</option>
                </select>         
             </div>
        </div>
        <div class="row">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ic_contrato'>Empresa:&nbsp;</label>
                <select id="empresas_pk" name="empresas_pk" class="form-control form-control-sm">
                </select>
            </div>                                                             
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='bancos_pk'>Banco(s):&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='bancos_pk' name='bancos_pk' />
                    <option></option>
                </select>    
            </div>            
        </div>
        <!----------------------ALERT------------------>
        <div class='row' id="alert_banco" style="display:none">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <strong style="color: red">Por favor, informe Banco(s)</strong>
            </div>
        </div>
        
        
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-6'>
                <label for='ds_conta_bancaria'>Nome Conta:&nbsp;</label>
                <input type="text" id="ds_conta_bancaria" class='form-control form-control-sm' name="ds_conta_bancaria" maxlength="100" />       
             </div>
        </div>
        <!----------------------ALERT------------------>
        <div class='row' id="alert_ds_conta" style="display:none">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <strong style="color: red">Por favor, informe Nome Conta</strong>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='ds_agencia'>Agência:&nbsp;</label>
                <input type="text" id="ds_agencia" class='form-control form-control-sm' name="ds_agencia" maxlength="16"  />   
            </div>
        </div>
        <!----------------------ALERT------------------>
        <div class='row' id="alert_agencia" style="display:none">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <strong style="color: red">Por favor, informe Agência</strong>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for='ds_agencia'>Conta:&nbsp;</label>
                <input type="text" id="ds_conta" class='form-control form-control-sm' name="ds_conta" maxlength="16"  />   
            </div>
        </div>
        <!----------------------ALERT------------------>
        <div class='row' id="alert_conta" style="display:none">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <strong style="color: red">Por favor, informe Conta</strong>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='vl_saldo_inicial'>VL Inicial:&nbsp;</label>
                <input type="text" id="vl_saldo_inicial" class='form-control form-control-sm' name="vl_saldo_inicial" maxlength="16"  />   
            </div>
        </div>
        <div class='row' id="alert_vl_inicial" style="display:none">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <strong style="color: red">Por favor, informe VL Inicial</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-3">
                <label for="ic_status">Status:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </div>
        </div>   
        <p>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>                
                &nbsp;
                <button type="submit" class="btn btn-primary" id="cmdEnviar">Salvar</button>
                
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

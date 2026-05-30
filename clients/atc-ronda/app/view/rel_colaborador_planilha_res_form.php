<?
require_once "../inc/php/header.php";
?>
<script src="rel_colaborador_planilha_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
            <h4>Relatório</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
       <!--<div class="row">                        
            <div class='col-md-4'>
                &nbsp;                                             
            </div>
            <div class='col-md-4'>
                <label for='agenda_contratos_pk'>Posto de Trabalho: </label>
                <select class='form-control form-control-sm'  id='leads_pk_agenda' name='leads_pk_agenda' >
                    <option><option>
                </select>
            </div>
        </div>  -->
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-2'>                                    
                <!--<label for='dt_inicio_agenda'>Dt Período Iní: </label>
                <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_inicio' name='dt_inicio'>-->
                <label for='dt_inicio_agenda'>Mês Corrente: </label>
                <select id="mes_pk" name="mes_pk">
                    <option value=""></option>
                    <option value="1">JAN</option>
                    <option value="2">FEV</option>
                    <option value="3">MAR</option>
                    <option value="4">ABR</option>
                    <option value="5">MAI</option>
                    <option value="6">JUN</option>
                    <option value="7">JUL</option>
                    <option value="8">AGO</option>
                    <option value="9">SET</option>
                    <option value="10">OUT</option>
                    <option value="11">NOV</option>
                    <option value="12">DEZ</option>                    
                </select>
            </div>                                
            <div class='col-md-2'>
                <!--<label for='dt_fim_agenda'>Dt Período Fim: </label>
                <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_fim' name='dt_fim'>-->
                <label for='dt_fim_agenda'>Ano Corrente: </label>
                <select id="ano_pk" name="ano_pk">
                    <option value=""></option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>        
        </div> 
        <div class="row">                        
            <div class='col-md-4'>
                &nbsp;                                             
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Posto de Trabalho&nbsp;</label>
                <select class=" form-control form-control-sm chzn-select" id="leads_pk" name="leads__pk"><option></option></select>
            </div>
        </div>  
        <div class="row">                        
            <div class='col-md-4'>
                &nbsp;                                             
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Colaborador&nbsp;</label>
                <select class=" form-control form-control-sm chzn-select" id="colaborador_pk" name="colaborador_pk"><option></option></select>
            </div>
        </div>   
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="produtos_servicos_pk">Qualificação:&nbsp;</label>
                <select id="produtos_servicos_pk" class="form-control form-control-sm" name="produtos_servicos_pk">
                    <option value=""></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="produtos_servicos_pk">Turno:&nbsp;</label>
                <select class='form-control form-control-sm'  id='turnos_pk' name='turnos_pk'>
                    <option></option>
                    <option value="4">Dia Inteiro</option>
                    <option value="1">Manhã</option>
                    <option value="2">Tarde</option>
                    <option value="3">Noite</option>
                </select>
            </div>
        </div>       
       
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

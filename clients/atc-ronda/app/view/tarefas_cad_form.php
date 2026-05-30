<?
require_once "../inc/php/header.php";
?>
<script src="tarefas_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
.oc_modal{
    cursor:pointer;
}
.doc_modal{
    cursor:pointer;
}
.processo_modal{
    cursor:pointer;
}

</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Cadastro de Tarefa</h4>
            <hr>
        </div>
    </div>
    <form id="form" class="form">     
        <input type="hidden"  id="agenda_colaborador_padrao_pk" name="agenda_colaborador_padrao_pk" value="">
        <input type="hidden"  id="agenda_colaborador_terafas_pk" name="agenda_colaborador_terafas_pk" value="">
        <div class="row">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class='col-md-8'>
                <label for="ds_colaborador">Identificação da Tarefa:&nbsp;</label>
                <input type='text' class='form-control form-control-sm'   id='ds_tarefa' name='ds_tarefa' >
            </div>            
        </div> 
        <div class='row' id="alert_ds_tarefa" style="display:none">
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <strong style="color: red">Por favor, sinforme a indentificação da tarefa!</strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Posto de Trabalho:&nbsp;</label>
                <select class="form-control form-control-sm " id="leads_pk" >
                    <option></option>
                </select>
            </div> 
            <div class='col-md-3'>
                <label for="ds_colaborador">Setor:&nbsp;</label>
                <select class="form-control form-control-sm " id="tarefas_local_pk" name="tarefas_local_pk">
                    <option></option>
                </select>
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Área:&nbsp;</label>
                <select class="form-control form-control-sm " id="tarefas_area_pk" name="tarefas_area_pk">
                    <option></option>
                </select>
            </div>
        </div>   
        <div class='row' id="alert_leads_pk" style="display:none">
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <strong style="color: red">Por favor, selecione o Posto de Trabalho!</strong>
            </div>
        </div>
        <div class='row' id="alert_tarefas_local_pk" style="display:none">
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-7'>
                <strong style="color: red">Por favor, selecione o Setor da tarefa!</strong>
            </div>
        </div>
        <div class='row' id="alert_tarefas_area_pk" style="display:none">
            <div class='col-md-7'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <strong style="color: red">Por favor, selecione a Área da tarefa!</strong>
            </div>
        </div>            
        <div class="row">
            <div class="col-md-1">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Colaborador:&nbsp;</label>
                <select class="form-control form-control-sm " id="colaborador_pk" name="colaborador_pk">
                    <option></option>
                </select>
            </div>            
        </div>   

        <p>
        <div class="row">
            <div class="col-md-1">
                &nbsp;
            </div>      
            <div class='col-md-3'>
                <label for="ds_colaborador">Tarefas:&nbsp;</label>
                <select class="form-control form-control-sm " id="tarefas_tipos_servicos_pk" name="tarefas_tipos_servicos_pk">
                    <option></option>
                </select>
            </div>

            <div class='col-md-8'>                                    
                <table width="70%">
                    <tr>
                        <td>
                            Dias da Semana
                        </td>
                        <td>
                            Hr Início
                        </td>
                        <td>
                            Hr Termino
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            <input type="checkbox" id="ic_dom" name="ic_dom" value="1">&nbsp;DOM
                        </td>
                        <td>
                            <input type="text" id="hr_ini_dom" name="hr_ini_dom" size="5" disabled="true">
                        </td>
                        <td>
                            <input type="text" id="hr_fim_dom" name="hr_fim_dom" size="5" disabled="true">
                        </td>
                    </tr>  
                    <tr>
                        <td>
                            <input type="checkbox" id="ic_seg" name="ic_seg" value="1" >&nbsp;SEG
                        </td>
                        <td>
                            <input type="text" id="hr_ini_seg" name="hr_ini_seg" size="5" disabled="true">
                        </td>
                        <td>
                            <input type="text" id="hr_fim_seg" name="hr_fim_seg" size="5" disabled="true">
                        </td>
                    </tr>  
                    <tr>
                        <td>
                            <input type="checkbox" id="ic_ter" name="ic_ter" value="1" >&nbsp;TER
                        </td>
                        <td>
                            <input type="text" id="hr_ini_ter" name="hr_ini_ter" size="5" disabled="true">
                        </td>
                        <td>
                            <input type="text" id="hr_fim_ter" name="hr_fim_ter" size="5" disabled="true">
                        </td>
                    </tr>  
                    <tr>
                        <td>
                            <input type="checkbox" id="ic_qua" name="ic_qua" value="1" >&nbsp;QUA
                        </td>
                        <td>
                            <input type="text" id="hr_ini_qua" name="hr_ini_qua" size="5" disabled="true">
                        </td>
                        <td>
                            <input type="text" id="hr_fim_qua" name="hr_fim_qua" size="5" disabled="true">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="ic_qui" name="ic_qui" value="1" >&nbsp;QUI
                        </td>
                        <td>
                            <input type="text" id="hr_ini_qui" name="hr_ini_qui" size="5" disabled="true">
                        </td>
                        <td>
                            <input type="text" id="hr_fim_qui" name="hr_fim_qui" size="5" disabled="true">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="ic_sex" name="ic_sex" value="1" >&nbsp;SEX
                        </td>
                        <td>
                            <input type="text" id="hr_ini_sex" name="hr_ini_sex" size="5" disabled="true">
                        </td>
                        <td>
                            <input type="text" id="hr_fim_sex" name="hr_fim_sex" size="5" disabled="true">
                        </td>
                    </tr>    
                    <tr>
                        <td>
                            <input type="checkbox" id="ic_sab" name="ic_sab" value="1" >&nbsp;SAB
                        </td>
                        <td>
                            <input type="text" id="hr_ini_sab" name="hr_ini_sab" size="5" disabled="true">
                        </td>
                        <td>
                            <input type="text" id="hr_fim_sab" name="hr_fim_sab" size="5" disabled="true">
                        </td>
                    </tr>
                </table>    

            </div> 
        </div> 
        <div class='row' id="alert_tarefas_tipos_servicos_pk" style="display:none">
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <strong style="color: red">Por favor, selecione a Tarefa !</strong>
            </div>
        </div>  
         
        
        <div class='row'>
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='obs_faturamento'> Observação:&nbsp;</label>
                <textarea id="obs" name="obs_tarefa" rows="3" cols="50"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class='row'>
            <div class="col-md-12" align="center" >
                <button type="button" class="btn btn-secondary" id="cmdCancelar" data-dismiss="modal">Voltar</button>&nbsp;
                <button type='button' class="btn btn-primary" id='cmdIncluirNovaTarefa'>Incluir Tarefa</button>                
            </div>
        </div>
</div>        
        <p>
        <hr>    
        <div class="row">   
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                    <thead>
                        <tr>
                            <th>Cód</th>    
                            <th>Identifi Tarefa</th>
                            <th>Posto de Trab</th> 
                            <th>leads_pk</th> 
                            <th>Setor</th>
                            <th>tarefas_local_pk</th> 
                            <th>Área</th>
                            <th>tarefas_area_pk</th> 
                            <th>Colaborador</th>
                            <th>colaborador_pk</th> 
                            <th>Tarefa</th>
                            <th>colaborador_pk</th> 
                            <th>Dias Taredas</th>                            
                            <th>Descrição</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        
    </form>




<?

require_once "../inc/php/footer.php";
?>

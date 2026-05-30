<?php 
require_once "../inc/php/header.php";
?> 
<script src="inc_agenda_escala_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
	<br>
    <div class="row">            
        <div class="col-md-12">
            <div  id="abrir" tabindex="-1" role="dialog" aria-labelledby="modal-set-ramalLabel" >       
                <div class="col-lg"  style="max-width:1000px;margin-left: auto;margin-right: auto;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">	
                            <div class="row">
                                <div class='col-sm-6' align="left">
                                    <h6 class="m-0 font-weight-bold text-primary">Agenda de Escala(s) Colaboradores</h6>
                                </div> 
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_padrao'>
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-primary btn-sm" id="btn_modal_agenda">Novo</button>                       
                                </div>
                                <div class='col-sm-6' align="Right" id='bt_titulo_ab_modal'  style="display:none">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdFecharModalLead">Fechar</button>                    
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdSalvarModalLead">Incluir</button>                    
                                </div>
                            </div>
                        </div>
                        <div id="x"></div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_caonta">Posto de Trabalho:&nbsp;</label>
                                <select class='form-control form-control-sm chzn-select'  id='leads_pk_pesq_agenda' name='leads_pk_pesq_agenda' />
                                    <option></option>
                                </select>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_caonta">Setor:&nbsp;</label>
                                <select class='form-control form-control-sm chzn-select'  id='setor_contratos_pk' name='setor_contratos_pk' />
                                    <option></option>
                                </select>  
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_caonta">Colaborador:&nbsp;</label>
                                <select class='form-control form-control-sm chzn-select'  id='colaborador_pk_pesq_agenda' name='colaborador_pk_pesq_agenda' />
                                    <option></option>
                                </select>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_caonta">Periodo:&nbsp;</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-2'>
                            <input type="text" class='form-control form-control-sm' id="dt_periodo_ini_agenda_pesq" name="dt_periodo_ini_agenda_pesq" maxlength="10">

                            </div>
                            <div class='col-md-2'>

                                <input type="text" class='form-control form-control-sm ' id="dt_periodo_fim_agenda_pesq" name="dt_periodo_fim_agenda_pesq" maxlength="10">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_caonta">Escala:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='escala_pesq_agenda' name='escala_pesq_agenda' >
                                <option value=''></option>
                                <option value='1D'>1D</option>
                                <option value='2D'>2D</option>
                                <option value='3D'>3D</option>
                                <option value='4D'>4D</option>
                                <option value='5D'>5D</option>
                                <option value='6X1'>6X1</option>
                                <option value='12x36'>12x36</option>
                                </select>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_caonta">Função / Qualificação:&nbsp;</label>
                                <select class='form-control form-control-sm chzn-select'  id='produtos_pesq_agenda' name='produtos_pesq_agenda' />
                                    <option></option>
                                </select>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_caonta">Tipo Escala:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='tipo_escala_pesq_agenda' name='tipo_escala_pesq_agenda' />
                                    <option></option>
                                    <option value="1">Impar</option>
                                    <option value="2">Par</option>
                                </select>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-3">
                                <label for="ic_status">Status:&nbsp;</label>
                                <select id="ic_status_pesq_agenda" class="form-control form-control-sm chzn-select" name="ic_status_pesq_agenda">
                                    <option value=""></option>
                                    <option value="1">Ativo</option>
                                    <option value="2">Inativo</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4" align="center">
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisarAgenda">Pesquisar</button>                         
                                </div>
                            </div>
                            <p>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <p>
                            <div class="row" >
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap " style="width:100%" id="tblAgenda">
                                        <thead >
                                            <tr>
                                            <th>Cód</th>         
                                            <th>Posto de Trabalho</th>
                                            <th>Setor</th>
                                            <th>Colaborador</th>
                                            <th>Função</th>
                                            <th>Escala</th>                    
                                            <th>Status</th>
                                            <th>DT Período Escala</th> 
                                            <th>DT Cancelamento</th>
                                            <th>Motivo Cancelamento</th>
                                            <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="exibir_campos_pesq_hidden" style="display:none">
                                <div class='row'>
                                    <div class='col-md-12' align="center">
                                        <button type="button" id="btn_modal_agenda" class="btn btn-primary" >Incluir Nova Escala</button>
                                    </div>
                                </div>
                                <input type="hidden" id="leads_pk_pesq_agenda">
                                <input type="hidden" id="colaborador_pk_pesq_agenda">
                                <input type="hidden" id="dt_periodo_ini_agenda_pesq">
                                <input type="hidden" id="dt_periodo_fim_agenda_pesq">
                                <input type="hidden" id="escala_pesq_agenda">
                                <input type="hidden" id="produtos_pesq_agenda">
                                <input type="hidden" id="tipo_escala_pesq_agenda">
                                <input type="hidden" id="ic_status_pesq_agenda">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
	</div>
</div>























<?
include("inc_agenda_escala_cad_form.php");
?>
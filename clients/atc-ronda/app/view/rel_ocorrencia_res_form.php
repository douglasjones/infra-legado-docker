<?
require_once "../inc/php/header.php";
?>

<script src="rel_ocorrencia_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Relatório de Ocorrências</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form method="post" >
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-6'>
                <label for="ds_lead">Lead:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_lead">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Tipo Ocorrência&nbsp;</label>
                <select class='form-control form-control-sm'  id='tipo_ocorrencia_res_pk' name='tipo_ocorrencia_res_pk' />
                    <option></option>
                </select>
            </div>  
           
        </div>
        
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Usuário de Cadastro&nbsp;</label>
                <select class='form-control form-control-sm'  id='usuario_cadastro_res_pk' name='usuario_cadastro_res_pk' />
                    <option></option>
                </select>    
            </div>    
        </div>        
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='tipo_ocorrencia_pk'>Agendado Para: &nbsp;</label>
                <select class='form-control form-control-sm'  id='usuario_agendado_para' name='usuario_agendado_para' />
                    <option></option>
                </select>    
            </div>    
        </div>        
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Data Abertura Oc Ini</label>
                    <input type='text' class=" form-control form-control-file" id="dt_cadastro" name="dt_cadastro"/>
                </div>
            </div>  
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Data Abertura Oc Fim</label>
                    <input type='text' class=" form-control form-control-file" id="dt_cadastro_fim" name="dt_cadastro_fim"/>
                </div>    
            </div>
                  
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-2">
                <label for="ic_status">Status Ocorrências:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value=""></option>
                    <option value="1">Aberta</option>
                    <option value="2">Fechada</option>
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
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Voltar</button>  &nbsp;&nbsp;                
                <button type="button" class="btn btn-primary" id="cmdEnviar">Gerar Relatório</button>
            </div>
        </div>
    </form>
</div>
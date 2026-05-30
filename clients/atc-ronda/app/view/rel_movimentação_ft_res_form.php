<?
require_once "../inc/php/header.php";
?>

<script src="rel_movimentação_ft_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Relatório Movimentação FT</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form method="post" >
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='leads_pk'>Posto de trabalho&nbsp;</label>
                <select class='form-control form-control-sm'  id='leads_pk' name='leads_pk'>
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
                    <label for="dt_cadastro">Data Inicio</label>
                    <input type='text' class=" form-control form-control-file" id="dt_ini" name="dt_ini"/>
                </div>
            </div>  
            <div class='col-md-2'>
                <div class="form-group">
                    <label for="dt_cadastro">Data Fim</label>
                    <input type='text' class=" form-control form-control-file" id="dt_fim" name="dt_fim"/>
                </div>    
            </div>         
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='colaboradores_pk'>Colaborador:&nbsp;</label>
                <select class='form-control form-control-sm'  id='colaboradores_pk' name='colaboradores_pk'>
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
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Voltar</button>  &nbsp;&nbsp;                
                <button type="button" class="btn btn-primary" id="cmdEnviar">Gerar Relatório</button>
            </div>
        </div>
    </form>
</div>
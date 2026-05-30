<?
require_once "../inc/php/header.php";
?>
<script src="colaborador_recibo_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Colaboradores Recibos</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="colaborador_pk">Tipo de Recibo:&nbsp;</label>
                <select class="form-control form-control-sm chzn-select" id="tipos_recibo_pk" >
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_colaborador">Colaborador:&nbsp;</label>
                <select class="form-control form-control-sm chzn-select" id="colaborador_pk">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_colaborador">Posto de Trabalho:&nbsp;</label>
                <select class="form-control form-control-sm chzn-select" id="leads_pk" >
                    <option></option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
           <div class='col-md-2'>
               <label for='ds_uf'>DT Emissão Recibo Ini:&nbsp;</label>
               <input type='text' class='form-control form-control-sm'  id='dt_registro_ini' name='dt_registro_ini' />
           </div>
           <div class='col-md-2'>
               <label for='ds_uf'>DT Emissão Recibo Fim:&nbsp;</label>
               <input type='text' class='form-control form-control-sm'  id='dt_registro_fim' name='dt_registro_fim' />
           </div>
       </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
                &nbsp;
                <button type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Incluir</button>
            </div>
        </div>
    </form>
            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
            <thead>
                <tr>
                    <th>Cód</th>                    
                    <th>Tipo<br>Recibo</th>
                    <th>Colaborador</th>
                    <th>Posto<br>Trabalho</th>
                    <th>DT<br>Emissão</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?
require_once "../inc/php/footer.php";
?>

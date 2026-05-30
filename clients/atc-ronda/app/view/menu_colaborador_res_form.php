<?
require_once "../inc/php/header.php";
?>
<script src="menu_colaborador_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <h2><div class="ds_usuario" ></div></h2>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <p>
    
    <form method="post">
        <input type="hidden" id="leads_pk">
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_colaborador">Posto de Trabalho:&nbsp;</label>
                <select class="form-control form-control-sm chzn-select" id="leads_usuarios_pk" >
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
            <div class='col-md-4'>
                <label for="ds_colaborador">Pin:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_pin" >
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Status acesso App Ponto:&nbsp;</label>
                <select id="ic_status_app" class="form-control form-control-sm" name="ic_status_app">
                    <option value=""></option>
                    <option value="1">Liberado</option>
                    <option value="2">Pendente</option>

                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for="ds_colaborador">RE:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_re" >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='generos_pk'>Gênero:&nbsp;</label>
                <select class='form-control form-control-sm'  id='generos_pk' name='generos_pk' >
                    <option></option>
                </select>
            </div>
        </div>
        <br>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for='ds_rg'>Reserva:&nbsp;</label>
                <input type='checkbox'  id='ic_reserva' name='ic_reserva' >
            </div>        
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Origem:&nbsp;</label>
                <select id="ic_origem" class="form-control form-control-sm" name="ic_origem">
                    <option value=""></option>
                    <option value="">Sistema</option>
                    <option value="2">Site</option>

                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4">
                <label for="ic_status">Status:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value=""></option>
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class="col-md-4" align="center">
                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
               
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
                    <th>Código</th>
                    <th>Colaborador</th>
                    <th>Pin</th>
                    <th>Re</th>
                    <th>Cel</th>
                    <th>Status App</th>                      
                    <th>Origem</th>
                    <th>Status</th>
                    <th>Cel 2</th>
                    <th>Função</th>
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

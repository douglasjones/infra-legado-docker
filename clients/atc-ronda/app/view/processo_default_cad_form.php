<?
require_once "../inc/php/header.php";
?>

<script src="processo_default_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Processos default</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_processo_default'>Processo:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_processo_default' name='ds_processo_default' required >
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
        <div class='row'>
            <div class='col-md-4'>
                <h5>Etapas</h5>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblEtapas">
                    <thead>
                        <tr>
                            <th>Ordem</th>
                            <th>Processo</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12' align="center"> 
                <button type="button" class="btn btn-primary" id="cmdIncluir" name="cmdIncluir">Incluir Etapas</button>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                <h5>Módulos</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblModulo">
                    <thead>
                        <tr>
                            <th>Ordem</th>
                            <th>Módulo</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12' align="center"> 
                <button type="button" class="btn btn-primary" id="cmdIncluirModulo" name="cmdIncluirModulo">Incluir Modulo</button>
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

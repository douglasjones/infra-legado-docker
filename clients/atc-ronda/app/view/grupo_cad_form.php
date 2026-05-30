<?
require_once "../inc/php/header.php";
?>

<script src="grupo_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Grupos</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">

        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_grupo'>Grupo: </label>
                <input type='text' class='form-control form-control-sm' id='ds_grupo' name='ds_grupo' required >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblPermissoes">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Cons</th>
                            <th>Ins</th>
                            <th>Upd</th>
                            <th>Del</th>
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
                <button type="button" class="btn btn-primary" id="cmdIncluir" name="cmdIncluir">Incluir Permissão</button>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'> 
                &nbsp;
            </div>
        </div>
  
        <p>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12" align="center">                
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary" id="cmdEnviar">Salvar</button>
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

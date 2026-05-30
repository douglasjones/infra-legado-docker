<?
require_once "../inc/php/header.php";
?>
<script src="menu_documentos_cliente.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>
   
</head>    




<br><br>
<div class="container">
<div class="row">  
    <div class="col-md-12">
        <h4>Lead - Documento(s)</h4>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    </div>        
</div>
<br>
<form method="post">
     <input type="hidden" id="leads_pk">
    <div class='row'>
        <div class='col-md-4'>
            <label for="ds_colaborador">Posto de Trabalho:&nbsp;</label>
            <select class="form-control form-control-sm chzn-select" id="leads_usuarios_pk" >
                <option></option>
            </select>
        </div>
    </div>
    </form>        
    <br>
    <!--<p>
    <div class="row">
        <div class="col-md-12" >
            <button type="button" class="btn btn-primary" id="cmdIncluirDocumento">Incluir Documento</button>
        </div>
    </div>
    <p>-->

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblDocumentos">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Documento</th>
                        <th>Observação</th>
                        <th>Nome Original</th>
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
</div>
<?
require_once "documentos_cad_form.php";
require_once "../inc/php/footer.php";
?>
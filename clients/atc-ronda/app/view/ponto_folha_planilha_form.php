<?
require_once "../inc/php/header.php";
?>

<script src="ponto_folha_planilha_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<title>Gepros - CRM</title>
<div class="container">
        <div class='col-md-12' align='center'>
            &nbsp;
        </div>
    <div class='row'>

        <div class='col-md-12' align='center' >
            <button type="button" class="btn btn-secondary" id="cmdCancelar">Voltar</button>
            &nbsp;
            <button type="button" class="btn btn-primary" id="cmdGerar" name="cmdGerar">Gerar</button>
        </div>
    </div>    
    <body>
    <form id="gerar" name="gerar">    
        <div id="areaGerar" name="areaGerar">    
        </div>
    </form>    
</div>   
<?
require_once "../inc/php/footer.php";
?>

<?
require_once "../inc/php/header.php";
?>
<script src="colaborador_recibo_print_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
@page {
   size: 7in 9.25in;
   margin: 27mm 16mm 27mm 16mm;
}




</style>
<div class="container">
    <div class='row'>
        <div class='col-md-12' align='center'>
           &nbsp;
        </div>
    </div>  
</div>   
<div class="container">
    <div class='row'>

        <div class='col-md-12' align='center' >
            <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Retornar ao Inicio</button>
            &nbsp;
            <button type="button" class="btn btn-primary" id="cmdImprimirModal"  name="cmdPrint">Imprimir</button>
        </div>
    </div>    
    <body>

    <form id="impressao" name="impressao">    
        <div id="areaImpressao" anme="area_impressao" style="width: 21cm; height: 29.7cm">    
            
        </div>
    </form>    
</div>   
<?
require_once "../inc/php/footer.php";
?>

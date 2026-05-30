<?
require_once "../inc/php/header.php";
?>
<script src="form_ordem_servico_form_cad.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
@media print{
   #noprint{
       display:none;
       size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
   }
   .break { page-break-before: always; }
}
</style>
<div id="noprint">
    <br>
    <div class="row" >
        <br>
        <div class="col-md-12" align="center" >
            <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-primary" id="cmdImprimir" data-dismiss="modal">Imprimir</button>
        </div>
    </div>
    <br>
</div>
<page size='A4'>
    <div class='container'>
  
        
        
        
        <div class="row">
            <div class="col-md-12">
                <div id="v_html"></div>                    
            </div>
        </div>   
           
    </div>
</page>    
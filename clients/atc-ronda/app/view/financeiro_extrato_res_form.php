<?
require_once "../inc/php/header.php";
?>
<script src="financeiro_extrato_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
/*html {
    font-family: verdana;
    font-size: 10pt;
    line-height: 25px;
}
table {
    border-collapse: collapse;
    width: 300px;
    height:350px;
    overflow-x: scroll;
    display: block;
}
thead {
    background-color: #EFEFEF;
}
thead, tbody {
    display: block;
}
tbody {
    overflow-y: scroll;
    overflow-x: hidden;
    height: 260px;
}
td, th {
    min-width: 100px;
    width:300px;
    height: 25px;
    border: dashed 1px lightblue;
}*/
</style>

<div class="row">
    <div class="col-md-12">
        <h4>Extrato Conta(s)</h4>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    </div>
</div>    
<p>
<div class='row'>
    <div class='col-sm-1'>
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <div id="combo"></div>
            </div>
        </div> 
    </div>
    <div class='col-sm-6' align="left">
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-1" role="group" aria-label="First group">
              <button type="button" class="btn btn-primary" id="ic_jan">JAN</button>
              <button type="button" class="btn btn-primary" id="ic_fev">FEV</button>
              <button type="button" class="btn btn-primary" id="ic_mar">MAR</button>
              <button type="button" class="btn btn-primary" id="ic_abr">ABR</button>
              <button type="button" class="btn btn-primary" id="ic_mai">MAI</button>
              <button type="button" class="btn btn-primary" id="ic_jun">JUN</button>
              <button type="button" class="btn btn-primary" id="ic_jul">JUL</button>
              <button type="button" class="btn btn-primary" id="ic_ago">AGO</button>
              <button type="button" class="btn btn-primary" id="ic_set">SET</button>
              <button type="button" class="btn btn-primary" id="ic_out">OUT</button>
              <button type="button" class="btn btn-primary" id="ic_nov">NOV</button>
              <button type="button" class="btn btn-primary" id="ic_dez">DEZ</button>
              <input type="hidden" id="ic_mes" value="ic_mes" >                                      
            </div>
        </div>  
    </div>
</div>  
<p>
<div class='row'>   
    <div class='col-sm-4'>
        <label for='bancos_pk'>Empresa(s):&nbsp;</label>
        <select class='form-control form-control-sm'  id='empresas_pk' name='empresas_pk' />
            <option></option>
        </select>
    </div>
    <div class='col-sm-4'>
        <label for='bancos_pk'>Conta(s):&nbsp;</label>
        <select class='form-control form-control-sm'  id='contas_pk' name='contas_pk' />
            <option></option>
        </select> 
    </div>
</div>
<p>

<div id="extrato">  
      
</div>
<div class='row'>   
    <div class="col-md-12">
        &nbsp;
    </div>       
</div> 
<div class='row'>   
    <div class="col-md-12">
        &nbsp;
    </div>       
</div> 
<hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>

<?
require_once "../inc/php/footer.php";
?>

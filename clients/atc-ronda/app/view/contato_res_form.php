<?
require_once "../inc/php/header.php";
?>
<script src="contato_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<div class="row">  
    <div class="col-md-12">
        <h4>Lead - Contatos</h4>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    </div>        
</div> 
<div class='row'>
    <div class='col-md-12'>                        
        <div id="ds_lead_titulo_contatos"></div>
        <br>
    </div>
</div>
<div class='row'>
    <div class='col-md-2'>                        
        <div id="id_lead_contatos"></div>    
    </div>
    <div class='col-md-3'>                        
        <div id="dt_cadastro_lead_contatos"></div>    
    </div>  
    <div class='col-md-3'>                        
        <div id="dt_ult_atualizacao_lead_contatos"></div>    
    </div> 
    <div class='col-md-4'>                        
        <div id="ds_usuario_cadastro_contatos"></div>    
    </div> 
</div>
<div class='row'>
    <div class="col-md-12">                    
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    </div>        
</div> 
<p> 
<div class='row'>
    <div class='col-md-12'>
        <button type="button" id="cmdIncluirContato" class="btn btn-primary btn-sm" >Incluir Contato</button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblContatos">
            <thead >
                <tr>
                <th>Cód</th>
                <th>Contato</th>
                <th>Email</th>
                <th>Cel</th>
                <th>Whatsapp</th>
                <th>ic_whatsapp</th>
                <th>Tel</th>
                <th>Função</th>
                <th>cargos_pk</th>
                <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<?
require_once "contato_cad_form.php";
require_once "../inc/php/footer.php";
?>

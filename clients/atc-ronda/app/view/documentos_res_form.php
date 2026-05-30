<?require_once "../inc/php/header.php";
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

set_time_limit(65536);
?>
<script src="documentos_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="row">  
    <div class="col-md-12">
        <h4>Lead - Documento(s)</h4>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    </div>        
</div>
<div class='row'>
    <div class='col-md-12'>                        
        <div id="ds_lead_titulo_documentos"></div>
        <br>
    </div>
</div>
<div class='row'>
    <div class='col-md-2'>                        
        <div id="id_lead_documentos"></div>    
    </div>
    <div class='col-md-3'>                        
        <div id="dt_cadastro_lead_documentos"></div>    
    </div>  
    <div class='col-md-3'>                        
        <div id="dt_ult_atualizacao_lead_documentos"></div>    
    </div> 
    <div class='col-md-4'>                        
        <div id="ds_usuario_cadastro_documentos"></div>    
    </div> 
</div>
<div class='row'>
    <div class="col-md-12">                    
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    </div>        
</div>
<p>
<div class="row">
    <div class="col-md-12" >
        <button type="button" class="btn btn-primary" id="cmdIncluirDocumento">Incluir Documento</button>
    </div>
</div>
<p>
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

<?
require_once "documentos_cad_form.php";
require_once "../inc/php/footer.php";
?>
<?require_once "../inc/php/header.php";?>

<script src="agenda_painel_comercial_res.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
</head>   
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="modal fade bd-example-modal-lg"  id="agenda_painel_comercial">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" >
                        <div class="card-header py-3">
                            <div class="row">
                                <div class='col-sm-10' align="left">
                                    <h6 class="font-weight-bold text-primary">Lead - Agenda</h6>
                                </div>
                                <div class='col-sm-2' align="right">
                                    <button type="button" class="btn btn-secondary btn-sm" id="cmdFecharModalAgenda" data-dismiss="modal">Fechar</button>  
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class='row'>
                                <div class='col-md-12'>                        
                                    <div id="ds_lead_titulo_agenda"></div>
                                    <input type='hidden' id="modulos_pk_agenda_painel">
                                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                    <br>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-2'>                        
                                    <div id="id_lead_agenda"></div>    
                                </div>
                                <div class='col-md-3'>                        
                                    <div id="dt_cadastro_lead_agenda"></div>    
                                </div>  
                                <div class='col-md-3'>                        
                                    <div id="dt_ult_atualizacao_lead_agenda"></div>    
                                </div> 
                                <div class='col-md-4'>                        
                                    <div id="ds_usuario_cadastro_agenda"></div>    
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
                                    <button type="button" id="cmdIncluirAgenda" class="btn btn-primary btn-sm" >Incluir Agenda</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblPainelAgenda">
                                        <thead>
                                            <tr>
                                                <th>Cód</th>              
                                                <th>Tipo Agenda</th>
                                                <th>Data Hora Agenda</th>
                                                <th>Usuário Cadastro</th>
                                                <th>Data Cadastro</th>
                                                <th>Status Agenda</th> 
                                                <th>Observação</th>              
                                                <th>Ação</th>                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?
require_once "agenda_cad_form.php";
echo "<script>var ic_abertura = 3;</script>";
require_once "../inc/php/footer.php";
?>


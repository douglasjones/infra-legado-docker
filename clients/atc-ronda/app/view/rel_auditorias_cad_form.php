<?
require_once "../inc/php/header.php";
require_once '../inc/php/scripts.php';
?>
<script src="rel_auditorias_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head> 
<div class="container col-md-10 ">
    <p>
    <div class="row">
        <div class="col-md-4">
            &nbsp;
        </div>
        <div class="col-md-4" align="center">
            <button type="button" class="btn btn-secondary" id="cmdCancelar">Voltar</button>
            <button type="button" class="btn btn-primary" id="cmdExport">Export</button>            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>Auditorias</h4>
        </div>
    </div>
    <p>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <table>
            <tr>
                <td>
                    <b>Relatório:</b>
                </td>
                <td >
                    Auditorias
                </td>
            </tr>
            <tr>
                <td>
                    <b>Dt Emissão:</b>
                </td>
                <td>
                    <div id="dt_emissao"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Supervisor:</b>
                </td>
                <td>
                   <div id="ds_supervisor"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Posto de Trabalho:</b>
                </td>
                <td>
                   <div id="ds_lead"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Categorias:</b>
                </td>
                <td>
                   <div id="ds_categorias"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Tipos categorias:</b>
                </td>
                <td>
                   <div id="ds_tipos_categorias"></div>
                </td>
            </tr>
            <tr>
                <td>
                     <b>Dt Cadastro:</b>
                </td>
                <td>
                   <div id="dt_cadastro"></div>
                </td>
            </tr>
        </table>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12">
                <div id="grid">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="modal fade bd-example-modal-lg"  id="janela_auditoria_form">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content" >
                                <div class="card-header py-3">
                                    <h6 class="font-weight-bold text-primary">Auditoria Formulário</h6>
                                </div>
							    <form id="form_colaborador">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class='col-md-12'>
                                                <div id='auditoria_categoria_form'>
                                                </div>                                                             
                                            </div>                                                             
                                        </div>
									    <hr>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="modal fade bd-example-modal-lg"  id="janela_auditoria_documentos">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content" >
                                <div class="card-header py-3">
                                    <h6 class="font-weight-bold text-primary">Auditoria Documentos</h6>
                                </div>
							    <form id="form_documentos">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class='col-md-12'>
                                                <div id="tbldocs">
                                                </div>
                                            </div>                                                             
                                        </div>
									    <hr>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?
require_once "../inc/php/footer.php";
?>

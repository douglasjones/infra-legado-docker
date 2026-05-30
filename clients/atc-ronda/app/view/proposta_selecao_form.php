<?
require_once "../inc/php/header.php";
?>
<script src="proposta_selecao_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>
</head>
<div class="container">
    <br>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Tipo de Proposta</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>                      
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class='row'>
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='ic_tipo_proposta'>Tipo Proposta:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='ic_tipo_proposta' name='ic_tipo_proposta'>          
                                <option value=""></option>                  
                                <option value="1">Proposta Detalhada</option>  
                                <!--option value="2">Proposta Básica</option-->  
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4' id="alert_ic_tipo_proposta" style="display:none">
                            <span aling="center" style="color: red">Por favor, informe o Tipo Proposta!</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4" align="center">
                            <button type="button" class="btn btn-primary btn-sm" id="cmdGerarProposta">Gerar</button>                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
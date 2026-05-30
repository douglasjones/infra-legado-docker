<script src="contato_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>

    <!-- Custom fonts for this template-->
    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
	
    <?require_once '../inc/php/scripts.php';?>
</head>
<form id="form_contato" class="form">
    <div class="modal fade bd-example-modal-lg" id="janela_contatos" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="m-0 font-weight-bold text-primary">Lead - Contato</h6>  
                    <div align='right'>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" aria-label="Close">Fechar</button>  
                        <button type="submit" class="btn btn-primary btn-sm" id="cmdEnviarContato"  name="cmdEnviarContato">Salvar</button>

                    </div> 
                </div>
                <div class="modal-body">
                    <input type='hidden' class='form-control form-control-sm'  id='contatos_pk' name='contatos_pk'>
                    <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                    
                    <div class="row">
                        <div class='col-md-4'>
                            <label for='ds_contato'>Contato: </label>
                            
                            <input type='text' class='form-control form-control-sm'  id='ds_contato' name='ds_contato' required>
                        </div>
                        <div class='col-md-4'>
                            <label for='ds_cel'>Celular: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_cel' name='ds_cel' required>
                        </div>                                
                        <div class='col-md-2'>
                            <label for='ic_whatsapp'>Whatsapp: </label>
                            <select class='form-control form-control-sm'  id='ic_whatsapp' name='ic_whatsapp' required>
                                <option value=""></option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>
                            </select>
                        </div>
                        <div id='alert_contato'></div>
                        <div class='col-md-4' >
                            <label for='ds_tel'>Telefone: </label>
                            <input type='text' class='form-control form-control-sm' size='20' attrname='ds_tel_contato' id='ds_tel_contato' name='ds_tel_contato'>
                        </div>                                
                        <div class='col-md-4'>
                            <label for='ds_email'>E-mail: </label>
                            <input type='text' class='form-control form-control-sm'  id='ds_email' name='ds_email'  >
                            
                        </div>     
                        <div class='col-md-3'>
                            <label for='cargos_pk'>Função: </label>
                            <select class='form-control form-control-sm'  id='cargos_pk' name='cargos_pk' >
                                <option></option>
                            </select>
                        </div>
                    </div>

                    <br>       
                    <hr>
                    <br>
                    <br>                           
                </div>  
            </div>
        </div>
    </div>        
</form>
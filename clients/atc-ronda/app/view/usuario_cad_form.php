<?
require_once "../inc/php/header.php";
?>
<script src="usuario_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                            <h6 class="m-0 font-weight-bold text-primary">Usuários </h6>     
                        </div>       
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdEnviar">Salvar</button>                          
                        </div>
                    </div>   
				</div>
				<div class="card-body">
                <div class="row">
     
        </div> 
        <hr>
        <div class="tab-content">
            <form id="form" class="form">        
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='grupos_pk'>Conta:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='contas_pk' name='contas_pk' />                            
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='grupos_pk'>Grupo:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk' />
                            <option></option>
                        </select>
                    </div>
                </div>
                <div id='exibir_lead' style='display:none'>
                    <div class="row" >
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class='col-md-3'>
                            <label for='clientes_pk'>Lead</label>
                            <select class='form-control form-control-sm chzn-select'  id='leads_pk' name='leads_pk'>
                                <option></option>
                            </select>

                        </div>
                    </div>
                    <div class='row' id="alert_ds_lead" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-3'>
                            <strong style="color: red">Por favor, informe Lead</strong>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_usuario'>Usuário:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_usuario' name='ds_usuario' required >
                    </div>
                </div>
                '<div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ds_login'>Login/E-mail:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_email' name='ds_email' required >
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class="form-group">
                        <label for='ds_senha'>&nbsp;&nbsp;&nbsp;&nbsp;Redefinir Senha:</label>
                    </div>
                    <div class='col-md-2'>
                        <input  type='checkbox' id='ic_senha' name='ic_senha' />
                        <input class='form-control form-control-sm' type='hidden' id='ds_senha' name='ds_senha' />
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cel'>Cel:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_cel' name='ds_cel' >
                    </div>

                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ic_status'>Status:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_status' name='ic_status' />
                            <option value="1">Ativo</option>
                            <option value="2">Inativo</option>
                        </select>
                    </div>
                </div>
                <p>
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                <p>              
            </form>                 
        </div>   
        <div class="row">
            <div class="col-md-12" align="Right">
            
                <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                &nbsp;
                <button type="button" class="btn btn-primary btn-sm" id="cmdEnviar">Salvar</button>                
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
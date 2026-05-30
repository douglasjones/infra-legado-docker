<?
require_once "../inc/php/header.php";
?>
<script src="usuario_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>

<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Usuários</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Novo</button>                       
                        </div>
                    </div>
				</div>
				<div class="card-body">
                    <form method="post">
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-3'>
                                <label for='grupos_pk'>Conta:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='contas_pk' name='contas_pk' />                            
                                    <option value=""></option>                       
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-3'>
                                <label for='grupos_pk'>Grupos de Acesso:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='grupos_pk' name='grupos_pk' />          
                                    <option value=""></option>                  
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_usuario">Usuário:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="ds_usuario" required="true">
                            </div>
                        </div>
 
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="ic_status">Status:&nbsp;</label>
                                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                                    <option value=""></option>
                                    <option value="1">Ativo</option>
                                    <option value="2">Inativo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4" align="center">
                            <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisar">Pesquisar</button>                         
                        </div>
                    </div>
                    <p>
                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    <p>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                <thead>
                                    <tr>
                                        <th>Cód</th>                    
                                        <th>Usuário</th>
                                        <th>Login</th>                                        
                                        <th>Conta</th>
                                        <th>Grupo</th>
                                        <th>Email</th>
                                        <th>Cel</th>
                                        <th>Status</th>                                        
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
<?
require_once "../inc/php/footer.php";
?>

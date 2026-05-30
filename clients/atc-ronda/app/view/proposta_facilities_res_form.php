<?
require_once "../inc/php/header.php";
?>
<script src="proposta_facilities_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                            <h6 class="m-0 font-weight-bold text-primary">Propostas</h6>
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
                            <div class='col-md-4'>
                                <label for='leads_pk'>Leads:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='leads_pk' name='leads_pk'>                            
                                    <option value=""></option>                       
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='ic_status'>Status:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='ic_status' name='ic_status'>          
                                    <option value=""></option>                  
                                    <option value="1">Cadastrada</option>                  
                                    <option value="2">Enviada para o Cliente</option>                  
                                    <option value="3">Previsão de Fechamento</option>                  
                                    <option value="4">Proposta Aprovada</option>                  
                                    <option value="5">Cancelada</option>                  
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='usuario_cadastro_pk'>Usuário Cadastro:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='usuario_cadastro_pk' name='usuario_cadastro_pk'>          
                                    <option value=""></option>                  
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="usuario_responsavel_comercial_pk">Responsável Comercial:&nbsp;</label>
                                <select id="usuario_responsavel_comercial_pk" class="form-control form-control-sm" name="usuario_responsavel_comercial_pk">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <label for="dt_cadastro">Dt Cadastro:&nbsp;</label>
                                <input class='form-control form-control-sm' maxlength="10" id='dt_cadastro' name='dt_cadastro'>
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
                                        <th>Versão</th>
                                        <th>Proposta Pai</th>
                                        <th>Lead</th>
                                        <th>Status Proposta</th>                                        
                                        <th>Usuário Cadastro</th>
                                        <th>Responsável Comercial</th>
                                        <th>Dt. fechamento</th>
                                        <th>Vl. Proposta</th>                                 
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
echo "<script>var ic_abertura = 1;</script>";
?>

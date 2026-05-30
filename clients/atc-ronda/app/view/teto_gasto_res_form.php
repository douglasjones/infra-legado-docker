<?
require_once "../inc/php/header.php";
?>
<script src="teto_gasto_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Teto de Gastos</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Novo</button>                       
                        </div>
                    </div>
				</div>
				<div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for="tipo_grupo_pk">Grupo de Origem Lançamento:&nbsp;</label>
                            <select id="tipo_grupo_pk" class="form-control form-control-sm" name="tipo_grupo_pk">
                                <option value=""></option>
                                <option value="1">Clientes</option>
                                <option value="2">Colaboradores</option>
                                <option value="3">Fornecedores</option>
                            </select>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <label for="grupo_leancamento_pk">Lançamento Para:&nbsp;</label>
                            <select id="grupo_leancamento_pk" class="form-control form-control-sm" name="grupo_leancamento_pk">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row" id="div_grupo_lancamento_centro_custo" style="display:none">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <label for="grupo_lancamento_centro_custo_pk">Cliente:&nbsp;</label>
                            <select id="grupo_lancamento_centro_custo_pk" class="form-control form-control-sm" name="grupo_lancamento_centro_custo_pk">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <label for="posto_trabalho_pk">Posto de Trabalho:&nbsp;</label>
                            <select id="posto_trabalho_pk" class="form-control form-control-sm" name="posto_trabalho_pk">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <label for="contratos_pk">Contrato(s):&nbsp;</label>
                            <select id="contratos_pk" class="form-control form-control-sm" name="contratos_pk">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <label for="ds_ano_vigente_teto">Ano de Vigencia:&nbsp;</label>
                            <select id="ds_ano_vigente_teto" class="form-control form-control-sm" name="ds_ano_vigente_teto">
                                <option value=""></option>
                                <option value="1">2023</option>
                                <option value="2">2024</option>
                                <option value="3">2025</option>
                                <option value="4">2026</option>
                                <option value="5">2027</option>
                                <option value="6">2028</option>
                                <option value="7">2029</option>
                                <option value="8">2030</option>
                            </select>
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
                    <p>  
                    <div class="row">                                                
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4" align="center">
                                <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisar">Pesquisar</button>                         
                            </div>
                        </div>
                    </div>    
                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    <p>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                <thead>
                                    <tr>
                                        <th>Cód</th>
                                        <th>Grupo Origem</th>                                       
                                        <th>Lançamento para </th>
                                        <th>Posto de Trabalho </th>
                                        <th>Contrato </th>                                 
                                        <th>Ano de Vigência</th>
                                        <th>Vl Teto</th>                                                                          
                                        <th>Vl Utilizado Atual</th>                                                                          
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
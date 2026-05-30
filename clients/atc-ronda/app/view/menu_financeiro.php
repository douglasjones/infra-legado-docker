<?
session_start();
$_SESSION['link'] = "menu_financeiro.php";
include "../inc/php/header.php";
$token = $_REQUEST['token'];
echo $_REQUEST['ds_usuario'];

?>

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

	<?if(permissao("faturamento_modulo", "cons", $token)){?>
		<div class="row">
			<div class="col-lg">
				<p>
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">Faturamento</h6>
					</div>			
					<div class="card-body">
						<div class="row">
							<div class="col-sm">
								<h6>Faturamento</h6> 
								<hr>
				
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('faturamento_res_form.php');">
											<!--<img src=../img/faturamento.png width="40">&nbsp;Novo Faturamento-->
											<i class="bi bi-currency-dollar" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Controle Faturamento</label>
										</a>
									</div>
								</div> 
							</div> 
							-<div class="col-sm"> 
								<h6>Controle de Emissões</h6> 
								<hr>									
								<!--<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('');">
											
											<i class="bi bi-card-checklist" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Faturas</label>
											
										</a>
									</div>
								</div>    	
								<p>-->
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('nota_fiscal_res_form.php');">
											
											<i class="bi bi-receipt-cutoff" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Nota(s) Fiscais</label>
										</a>
									</div>
								</div>   
								<!--<p>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('');">											
											<i class="bi bi-ticket-perforated" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Boletos</label>
										</a>
									</div>
								</div>-->    	
							</div> 				  
						</div>
					</div>
					
				</div>
			</div>
		</div>
	<?}?>
	<?if(permissao("teto_gastos_modulo", "cons", $token)){?>
		<div class="row">
			<div class="col-lg">
				<p>
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">Teto de Gastos</h6>
					</div>			
					<div class="card-body">
						<div class="row">
							<div class="col-sm">
								<h6>Teto de Gastos</h6> 
								<hr>				
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('teto_gasto_res_form.php');">
											<i class="bi bi-ui-checks-grid" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Controle de Teto de Gastos</label>
										</a>
									</div>
								</div> 
							</div>  						  
						</div>
					</div>
				</div>
			</div>
		</div>
	<?}?>
	<?if(permissao("analise_financeira_modulo", "cons", $token)){?>
		<div class="row">
			<div class="col-lg">
				<p>
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">PAF - Análise Financeira</h6>
					</div>			
					<div class="card-body">
						<div class="row">
							<div class="col-sm">
								<h6>Análise Financeira</h6> 
								<hr>
				
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('analise_financeira_res_form.php');">
											<i class="bi bi-search" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Controle Análise Financeira</label>
										</a>
									</div>
								</div> 
							</div>  						  
						</div>
					</div>
				</div>
			</div>
		</div>
	<?}?>
	<?if(permissao("financeiro_lancamentos_usuarios_modulo", "cons", $token)){?>
		<div class="row">
			<div class="col-lg">
				<p>
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">Lançamento Financeiro</h6>
					</div>			
					<div class="card-body">
						<div class="row">
							<div class="col-sm">
								<h6>Lançamentos</h6> 
								<hr>				
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('financeiro_usuarios_lancamentos_res_form.php');">
											<i class="bi bi-ui-checks-grid" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Controle de Lançamento(s) Financeiros</label>
										</a>
									</div>
								</div> 
							</div>  						  
						</div>
					</div>
				</div>
			</div>
		</div>
	<?}?>
    <div class="row">
        <div class="col-lg">
            <p>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Importação de Lançamentos</h6>
                </div>			
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <h6>Importação</h6> 
                            <hr>				
                            <div class="text-left">
                                <div class=' col-sm text-left'>
                                    <!--<a href="javascript: abrirMenu('financeiro_import_lancamentos_res.php');">-->
                                    <a href="javascript: abrirMenu('financeiro_lote_lancamentos_res.php');">   
                                        <i class="bi bi-filetype-csv" style="font-size:30px; color:black"></i>
                                        <label  style="font-size: 15px">Importação Lançamentos</label>
                                    </a>
                                </div>
                            </div> 
                        </div>  						  
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?if(permissao("financeiro_controle_moodulo", "cons", $token)){?>	
		<div class="row">
			<div class="col-lg">
				<p>
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">Financeiro</h6>
					</div>					
					<div class="card-body">
						<div class="row">
							<div class="col-sm">
								<h6>Contas / Plano de Contas / Fornecedores</h6> 
								<hr>
								<?if(permissao("contas_bancarias", "cons", $token)){?>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('conta_bancaria_res_form.php');">
											<!--<img src=../img/contas_bancarias.png width="40">-->
											<i class="bi bi-bank" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Contas Bancarias</label>
										</a>
									</div>
								</div>  
								<?}?>
								<p>
								<?if(permissao("plano_contas", "cons", $token)){?>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('plano_contas_res_form.php');">
											<!--<img src=../img/plano_contas.png width="40">&nbsp;Tipo Operação / Planos Conta-->
											<i class="bi bi-list-columns" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Tipo Operação / Planos Conta</label>
										</a>
									</div>
								</div>
								<?}?>    
								<p>
								<div class="text-left">
									<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('fornecedor_res_form.php');">
										<i class="bi bi-buildings" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Fornecedores</label>		
									</a>
								</div>
							</div>                      
						    </div>  
                            <div class="col-sm"> 
								<div class="col-sm"> 
									<h6>Concilicição Bancária</h6> 
									<hr>									
									<div class="text-left">
										<div class=' col-sm text-left'>
											<a href="javascript: abrirMenu('financeiro_conciliacao_banco_res_form.php');">
												<!--<img src=../img/visao_grafico.png width="40">-->
												<i class="bi bi-filetype-doc" style="font-size:30px; color:black"></i>
												<label  style="font-size: 15px">Concilição Bancária</label>
											</a>
										</div>
									</div>    	
								</div>
							</div>    
							<div class="col-sm"> 
								<div class="col-sm"> 
									<h6>Controle Despesas e Receitas</h6> 
									<hr>									
									<div class="text-left">
										<div class=' col-sm text-left'>
											<a href="javascript: abrirMenu('financeiro_contas_pagar_res_form.php');">
												<!--<img src=../img/visao_grafico.png width="40">-->
												<i class="bi bi-cash-coin" style="font-size:30px; color:black"></i>
												<label  style="font-size: 15px">Contas a Pagar e Receber</label>
											</a>
										</div>
									</div>    	
								</div>
							</div>    
						</div>
					</div>
				</div>
			</div>
		</div>
	<?}?>								
</div>
<?
include "../inc/php/footer.php";
?>

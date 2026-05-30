<?
session_start();
$_SESSION['link'] = "menu_cadastros.php";
include "../inc/php/header.php";
$token = $_REQUEST['token'];
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

    <!-- Custom styles for this template-->
    <!--<link href="../inc/css/themas/sb-admin-2.min.css" rel="stylesheet">--->
	
    <?require_once '../inc/php/scripts.php';?>
</head>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Compras / Produtos - Estoque / Moviment de Estoque</h6>
				</div>
				<div class="card-body">
					<div class="row">  
						<div class="col-sm"> 
							<h6>Solicitação de Compras / Compras</h6> 
							<hr>
							<div class="text-left">
								<div class=' col-sm text-left'>		
									<a href="javascript: abrirMenu('compras_solicitacao_res_form.php');">																	
										<i class="bi bi-credit-card-2-front" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Solicitação de Compras</label>
									</a>
								</div>
							</div> 
							<p>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('compra_res_form.php');">
										<i class="bi bi-cart-check" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Compras</label>										
									</a>
								</div>
							</div> 
						</div> 	
						<div class="col-sm"> 
							<h6>Produtos Materiais / Estoque</h6> 
							<hr>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('produto_res_form.php');">										
										<i class="bi bi-node-plus" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Produtos - Materiais - Insumos</label>			
									</a>
								</div>
							</div>
							<p>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('entrada_estoque_res_form.php');">
										<i class="bi bi-boxes" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Estoque</label>												
									</a>
								</div>
							</div>                        							               
						</div>   
						<div class="col-sm"> 
							<h6>Movimentação Estoque </h6> 
							<hr>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenuMovimentar('inc_movimentar_material_prod_res_form.php');">										
										<i class="bi bi-arrow-down-up" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Movimentação de Estoque</label>		
									</a>
								</div>
							</div>   
							<!-----<div class="col-sm"> 
							<h6>Baixa Estoque </h6> 
							<hr>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('estoque_baixa_res_form.php');">
										<img src=../img/leitorQrcode.png width="60">&nbsp;Baixa Estoque 
									</a>
								</div>
							</div>                       
						</div>  ----->                           
						</div>         
					</div>
				</div>
			</div>
		</div>
	</div>

	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Cadastros Categorias / Fornecedores</h6>
				</div>
				<div class="card-body">
					<div class="row">  
					<div class="col-sm"> 
							<h6>Categoria/Fornecedor</h6> 
							<hr>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('categoria_produto_res_form.php');">
										<i class="bi bi-tags" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Categorias de Produtos, Materiais e Insumeos</label>		
									</a>
								</div>
							</div>  
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
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>    
    
<?
include "../inc/php/footer.php";
?>

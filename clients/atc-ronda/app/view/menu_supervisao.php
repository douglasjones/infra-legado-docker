<?php
session_start();
$_SESSION['link'] = "menu_operacao.php";
include "../inc/php/header.php";
//include "apontamento_colaborador_res_form.php";

$token = $_REQUEST['token'];
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<script>

</script>
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
					<h6 class="m-0 font-weight-bold text-primary">Supervisão</h6>
				</div>
				<div class="card-body">
					<div class="col">
						<div class="row">
							<div class="col-sm"> 
								<h6>Visitas - Rotas / Auditórias</h6> 								
								<hr>
                                <div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('auditoria_supervisao_postos_trabalho_res_form.php');">
											<label  style="font-size: 15px"><img src="../img/segmento.png" width="45"> Auditória de Postos de Trabalho</label>
										</a>
									</div>
								</div>  	
								<p>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('lead_res_form.php');">
											<label  style="font-size: 15px"><img src="../img/reagendamento.png" width="40"> Controle de Visitas - Rotas</label>
										</a>
									</div>
								</div>  	
								<p>  					
								<!-----------<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('teste_localizacao.php');">
											<label  style="font-size: 15px"><img src="../img/reagendamento.png" width="40"> Teste Localização</label>
										</a>
									</div>
								</div> ---> 					
							</div>
							<!-----------<div class="col-sm"> 
								<h6>Checklist</h6> 
								<hr>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('colaborador_res_form.php');">
											<label  style="font-size: 15px"><img src="../img/lista-de-controle.png" width="40">Controle de Checklist(s)</label>
										</a>
									</div>
								</div>	           
							</div> --------->
							<!-----------<div class="col-sm"> 
								<h6>Solicitações</h6>
								<hr>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: fcAbrirPopUpAtraso();">
											<label  style="font-size: 15px"><img src="../img/carrinho_compra.jpg" width="50">Solicitações</label>
										</a>
									</div>
								</div>
								
							</div>  
							<p>--------->
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include "../inc/php/footer.php";
?>

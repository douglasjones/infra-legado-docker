<?
session_start();
$_SESSION['link'] = "menu_relatorios.php";
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
					<h6 class="m-0 font-weight-bold text-primary">Relatórios</h6>
				</div>
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm"> 
							<h6>Operacional</h6>
							<hr>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('menu_relatorios_lead.php');">
										<i class="bi bi-building-add" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Clientes / Posto(s) de Trabalho / Contrato(s)</label>
									</a>
								</div>
							</div>  
							<br>
							<div class=' col-sm text-left'>
								<a href="javascript: abrirMenu('menu_relatorios_colaborador.php');">
									<i class="bi bi-person-square" style="font-size:30px; color:black"></i>
									<label  style="font-size: 15px">Colaboradores</label>
								</a>
							</div>
							<!--<br>
							<div class=' col-sm text-left'>
								<a href="javascript: abrirMenu('menu_relatorios_escala.php');">
									<i class="bi bi-journal-text" style="font-size:30px; color:black"></i>
									<label  style="font-size: 15px">Escalas</label>
								</a>
							</div>-->
                            <br>
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('menu_relatorios_supervisao.php');">
         							<i class="bi bi-person-check-fill" style="font-size:30px; color:black"></i>
									<label  style="font-size: 15px">Supervisão</label>
                                </a>
                            </div>
						</div> 
						<div class="col-sm"> 
							 <h6>Serviços</h6>
							 <hr>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('menu_relatorios_ponto_falta.php');">
										<i class="bi bi-clock-history" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Registros de Ponto e Faltas</label>
									</a>
								</div>
							</div>  
							<br>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('menu_relatorios_estoque.php');">
										<i class="bi bi-boxes" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Estoque</label>		
									</a>
								</div>
							</div>  
							<br>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('menu_relatorios_financeiro.php');">										
										<i class="bi bi-cash-coin" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Financeiro</label>
									</a>
								</div>
							</div>
							<!--<br>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('menu_relatorios_ocorrencia.php');">										
										<i class="bi bi-list-task" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Ocorrências</label>
									</a>
								</div>
							</div>  -->
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

<?php
session_start();
$_SESSION['link'] = "menu_leads.php";
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
    <?require_once '../inc/php/scripts.php';?>
</head>  

<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
		
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Comercial</h6>
				</div>
				<div class="card-body">
					<div class="col">
						<div class="row">
							<div class="col-sm"> 
								<h6>Comercial</h6> 
								<hr>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('lead_res_form.php');">
                                            <p>
                                                <i class="bi bi-building-add" style="font-size:30px; color:black"></i>
                                                <label  style="font-size: 15px">Leads</label>
                                            </p>										
                                        </a>
									</div>
								</div>  
								<p>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenuMovimentar('painel_leads_res_form.php');">
                                            <p>
                                                <i class="bi bi-card-text" style="font-size:30px; color:black"></i>
                                                <label  style="font-size: 15px"> Painel Leads</label>
                                            </p>
										</a>
									</div>               
								</div> 
							</div>
                            <div class="col-sm"> 
								<h6>Gestão ADM</h6>
								<hr>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenuMovimentar('contrato_operacional_res_form.php');">
                                            <p>
                                                <i class="bi bi-folder-plus" style="font-size:30px; color:black"></i>
                                                <label  style="font-size: 15px"> Contratos</label>
                                            </p>
										</a>
									</div>               
								</div>
								<p>
						    </div>	
						   <div class="col-sm"> 
							   &nbsp;
						   </div>
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

<?
session_start();
$_SESSION['link'] = "menu_cpainel.php";
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
    <script src="processa_escala.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
</head>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Controle de Contas Clientes</h6>
				</div>
				<div class="card-body">
					<div class="row">  
                     <div class="col-sm">
                        <h6>Contas Cliente</h6> 
						<hr>
						<div class=' col-sm text-left'>
							<a href="javascript: abrirMenu('conta_res_form.php');">
									<i class="bi bi-person-gear" style="font-size:30px; color:black"></i>
									<label  style="font-size: 15px">Contas Cliente </label>
								</a>
						</div>  

                        
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
					<h6 class="m-0 font-weight-bold text-primary">Cpainel</h6>
				</div>
				<div class="card-body">
					<div class="row">  
                     <div class="col-sm">
                        <h6>Configurações Basicas</h6> 
						<hr>
						<div class=' col-sm text-left'>
							<a href="javascript: abrirMenu('modulo_res_form.php');"> 
								<i class="bi bi-border-all" style="font-size:30px; color:black"></i>
								<label  style="font-size: 15px">Módulos do Sistema</label>
							</a>
						</div>  
						<p>
						<div class=' col-sm text-left'>
						<a href="javascript: abrirMenu('grupo_res_form.php');">
								<i class="bi bi-person-vcard" style="font-size:30px; color:black"></i>
								<label  style="font-size: 15px">Pefis de Acesso e Permissões</label>
							</a>
						</div>                            
                        
                        
                    </div>
                    <div class="col-sm"> 
                        <h6>Configurações de Processos e Acesso</h6> 
						<hr>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
								<a href="javascript: abrirMenu('processo_default_res_form.php');">	
                                    <i class="bi bi-cpu" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Processos e Worflow</label>
                                </a>
                            </div>
                        </div>  
                        <p>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
								<a href="javascript: abrirMenu('processo_default_config_res.php');">
                                    <i class="bi bi-box-arrow-right" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Configuração Workflow por Setor</label>
                                </a>
                            </div>
                        </div>
    
                    </div>    
					<div class="col-sm"> 
                        <h6>Configurações Temporárias de Ajustes</h6> 
						<hr>
                        <div class="text-left">
                   
							<div class=' col-sm text-left' onclick='fc_processa_escala()'>
				
                                    <i class="bi bi-journal-text" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Atualizar Base de Escalas</label>
                          
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

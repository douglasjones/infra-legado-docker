<?
session_start();
$_SESSION['link'] = "menu_administracao.php";
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
					<h6 class="m-0 font-weight-bold text-primary">Administração - Controle do Sistema</h6>
				</div>
				<div class="card-body">
					<div class="row">  
                     <div class="col-sm">
                        <h6>Usuários</h6> 
						<hr>
                         <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('usuario_res_form.php');">                                
                                    <i class="bi bi-people" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Usuários</label>
                                </a>
                            </div>                             
                        </div>   
                        
                    </div>
                    <div class="col-sm"> 
                        <h6>Serviço / Ocorrências</h6> 
						<hr>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('produto_servico_res_form.php');">
                                    <i class="bi bi-database-fill-check" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Serviços</label>
                                </a>
                            </div>
                        </div>  
                        <p>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('tipo_ocorrencia_res_form.php');">
                                    <i class="bi bi-list-columns" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Tipos Ocorrências</label>
                                </a>
                            </div>
                        </div>
                        <!--<p>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('processo_default_config_res.php');">
                                    <p><i class="fa fa-cogs" style="font-size: 40px;"></i>&nbsp; Processos Padrão</p> 
                                </a>
                            </div>
                        </div>-->
                    </div>
                    <div class="col-sm"> 
                        <h6>Equipes</h6> 
						<hr>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('equipe_res_form.php');">
                                    <i class="bi bi-microsoft-teams" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Equipes</label>
                                </a>
                            </div>
                        </div>                
                   
                    </div>
                </div>
				</div>
			</div>
		</div>
	</div>
    <p>
    <div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Supervisão Configurações</h6>
				</div>
				<div class="card-body">
					<div class="row">  
                     <div class="col-sm">
                        <h6>Audítoria Categorias / Tipo Auditórias</h6> 
						<hr>
                         <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('auditoria_categoria_res_form.php');">
                                    <i class="bi bi-search" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Categorias Auditorias </label>
                                </a>
                            </div>                             
                        </div>    
                        <p>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('auditoria_categoria_tipos_res_form.php');">
                                    <i class="bi bi-list-columns" style="font-size:30px; color:black"></i>
								    <label  style="font-size: 15px">Tipos de Auditorias </label>
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

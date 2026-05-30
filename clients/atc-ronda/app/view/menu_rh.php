<?
session_start();
$_SESSION['link'] = "menu_rh.php";
include "../inc/php/header.php";
include "apontamento_colaborador_cad_form.php";
$token = $_REQUEST['token'];
?>

<script>


function fcAbrirPopUpAtraso(){   
    
    var width = 1432;
    var height = 600;

    var left = 250;
    var top = 150;
    var URL = "painel_atraso_cad_form.php?token="+ token;
    window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
           
}
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

    <!-- Custom styles for this template-->
    <!--<link href="../inc/css/themas/sb-admin-2.min.css" rel="stylesheet">--->
	
    <?require_once '../inc/php/scripts.php';?>
</head>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<p>
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Controles de Recursos Humanos</h6>
				</div>
				<div class="card-body">
					<div class="row">  
						 <div class="col-sm">
						 	<h6>Colaboradores / App Liberação</h6> 
								<hr>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('colaborador_res_form.php');">
											<i class="bi bi-person-square" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Colaboradores</label>
										</a>
									</div>
								</div>
								<p>
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('rel_colaboradores_aniversariantes_res_form.php');">
										<i class="bi bi bi-balloon" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Colaboradores Aniversariantes do Mês </label>
									</a>
                            	</div>						
								<p>
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('rel_colaborador_curso_res_form.php');">
										<i class="bi bi-clipboard-check" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Vencimento de Exames e Cursos </label>
									</a>
								</div>	
								<p>
								<div class="text-left">
									<div class='col-sm'>
										<a href="javascript: abrirMenu('solicitacao_liberacao_app_res_form.php');">											
											<i class="bi bi-unlock" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Liberar acesso ao App Ponto</label>                                 
										</a>
									</div>
								</div>
								<!--<p>
								<div class=' col-sm text-left'>
                                	<a href="javascript: abrirMenu('rel_colaborador_ferias_res_form.php');">
                                    	<i class="bi bi-clipboard2-data" style="font-size:30px; color:black"></i>
                                    	<label  style="font-size: 15px">Colaboradores em Férias</label>
                                	</a>
                            	</div>-->
								<!--<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('colaborador_recibo_res_form.php');">											
											<i class="bi bi-receipt-cutoff" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Recibos</label>                                 
										</a>
										
									</div>
								</div> --> 		 
						</div>
						<div class="col-sm"> 
							<h6>Escalas / Apontamentos</h6>
							<hr>	 
							<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenuMovimentar('inc_agenda_escala_res_form.php');">
											<i class="bi bi-journal-text" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Escalas</label>
										</a>
									</div>
								</div>  
								<p>		
								<div class="text-left">
									<div class=' col-sm text-left'>
										<!----<a href="javascript: fcAbrirModalPainelApontamento('','','','');">---->
										<a href="javascript: fcAbrirApontamento('','');">
                                            <label  style="font-size: 15px">&nbsp;<img src="../img/apontamento_colaborador.png" width=25 height=40>&nbsp; Apontamento(s) por Colaborador</label>
										</a>
									</div>
								</div>  
						</div>
						<div class="col-sm"> 
							<h6>Controle de Folha de Ponto</h6>
							<hr>	 
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('ponto_folha_res_form.php');">										
										<i class="bi bi-clock" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Folha de Ponto</label>    
									</a>
								</div>
							</div>
						</div>
					
					</div>
				</div>
			</div>
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Cadastros / Configurações</h6>
				</div>
				<div class="card-body">
					<div class="row">
						 <div class="col-sm">
							<h6>Funções / Benefícios / Exames e Cursos</h6> 
							<hr>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('produto_servico_res_form.php');">
										<i class="bi bi-database-fill-check" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Funções / Serviçoes</label>
									</a>
								</div>
							</div> 
							<p> 
							<div class="text-left">
								<div class='col-sm'>
									<a href="javascript: abrirMenu('beneficio_res_form.php');">
										<i class="bi bi-folder-plus" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Benefícios</label>
									</a>
								</div>
							</div>							                 
							<p>
							<div class="text-left">
								<div class=' col-sm text-left'>
									<a href="javascript: abrirMenu('curso_res_form.php');">
										<i class="bi bi-bandaid" style="font-size:30px; color:black"></i>
										<label  style="font-size: 15px">Exames/Curcos</label>
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

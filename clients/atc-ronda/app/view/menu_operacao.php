<?php
session_start();
$_SESSION['link'] = "menu_operacao.php";
include "../inc/php/header.php";
//include "apontamento_colaborador_res_form.php";
include "apontamento_colaborador_cad_form.php";
$token = $_REQUEST['token'];
?>
<!---<script src="apontamento_colaborador_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>--->

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
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
		
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Operacional</h6>
				</div>
				<div class="card-body">
					<div class="col">
						<div class="row">
							<div class="col-sm"> 
								<h6>Lead´s / Ocorrências</h6> 
								<hr>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('lead_res_form.php?ic_abertura=1');">
											<i class="bi bi-building-add" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Lead's / Postos de Trabalho</label>
										</a>
									</div>
								</div>
								<p>  
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenu('ocorrencia_res_form_old.php');">
											<i class="bi bi-list-task" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Ocorrências</label>
										</a>
									</div>
								</div>
								<!--<p>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: abrirMenuMovimentar('contrato_operacional_res_form.php');">
											<label  style="font-size: 15px"><img src="../img/contrato.png" width="40"> Contrato(s)</label>
										</a>
									</div>               
								</div> -->
							</div>
							<div class="col-sm"> 
								<h6>Colaboradores / Apontamentos</h6> 
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
								<h6>Controle de Escalas</h6>
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
										<a href="javascript: abrirMenuMovimentar('calendario_escala_cad_form.php');">				
											<i class="bi bi-calendar2-week" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Calendário de Escalas</label>
										</a>
									</div>
								</div>
								<!--<p>
                                <div class="texte-left"> 
                                    <div class='col-sm text-left'>
                                        <a href="javascript: abrirMenuMovimentar('mesa_operacional_res_form.php');">                                            
											<i class="bi bi-chat-left-text" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Mesa Operacional</label>
                                        </a>    
                                    </div>
                                </div>-->
								<p>
								<div class="text-left">
									<div class=' col-sm text-left'>
										<a href="javascript: fcAbrirPopUpAtraso();">
											<i class="bi bi-card-text" style="font-size:30px; color:black"></i>
											<label  style="font-size: 15px">Acompanhamento de ponto/atrasos</label>											
										</a>
									</div>
								</div>               
							</div>  
							<p>
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

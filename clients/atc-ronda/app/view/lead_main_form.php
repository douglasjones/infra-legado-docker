<?
require_once "../inc/php/header.php";
?>
<script src="lead_main_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
    <p>
	<div class="row">
        <input type="hidden" id="leads_pk">
		<div class="col-lg">
			<div class="card shadow mb-4">
                <div class="card-header py-3">					
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Lead - Principal</h6>          
                        </div>       
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltarLead">Voltar</button>                    
                        </div>
                    </div> 
		        </div>
				<div>
                    <ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">                     
                        <li class="nav-item">
                            <a class="nav-link active" id="dados_cadastrais_lead-tab" data-toggle="tab" href="#dados_cadastrais_lead" role="tab" aria-controls="dados_cadastrais_lead" aria-selected="true">Dados Cadastrais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contatos_lead-tab" data-toggle="tab" href="#contatos_lead" role="tab" aria-controls="contatos_lead" aria-selected="false">Contato(s)</a>
                        </li>              
                        <li class="nav-item">
                            <a class="nav-link" id="agendas_lead-tab" data-toggle="tab" href="#agendas_lead" role="tab" aria-controls="agendas_lead" aria-selected="false">Agenda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="comercial_lead-tab" data-toggle="tab" href="#comercial_lead" role="tab" aria-controls="comercial_lead" aria-selected="false">Comercial</a>
                        </li>  
                        <li class="nav-item">
                            <a class="nav-link" id="operacional_lead-tab" data-toggle="tab" href="#operacional_lead" role="tab" aria-controls="operacional_lead" aria-selected="false">Operacional</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="financeiro_lead-tab" data-toggle="tab" href="#financeiro_lead" role="tab" aria-controls="financeiro_lead" aria-selected="false">Financeiro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ocorrencias_lead-tab" data-toggle="tab" href="#ocorrencias_lead" role="tab" aria-controls="ocorrencias_lead" aria-selected="false">Ocorrências</a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" id="documentos_lead-tab" data-toggle="tab" href="#documentos_lead" role="tab" aria-controls="documentos_lead" aria-selected="false">Documento(s)</a>
                        </li>

                    </ul>
                    <hr>
				</div>
				<div class="card-body">
                    <div class="tab-content">
                        <!--Dados Lead-->
                        <div class="tab-pane fade show active" id="dados_cadastrais_lead" role="tabpanel" aria-labelledby="dados_cadastrais_lead-tab">
                            <?include("lead_det_form.php");?>          
                        </div>
                        <!--Contato Lead-->
                        <div class="tab-pane fade" id="contatos_lead" role="tabpanel" aria-labelledby="contatos_lead-tab">      
                            <?include("contato_res_form.php");?>
                        </div>  
                        <div class="tab-pane fade" id="agendas_lead" role="tabpanel" aria-labelledby="agendas_lead-tab">      
                            <?include("agenda_res_form.php");?>
                        </div>  
                        <div class="tab-pane fade" id="comercial_lead" role="tabpanel" aria-labelledby="comercial_lead-tab">      
                            <?
                                include("comercial_res_form.php");
                            ?>
                        </div>  
                        
                        <!---div class="tab-pane fade" id="operacional_lead" role="tabpanel" aria-labelledby="operacional_lead-tab">      
                            Operacional
                            <?
                                //include("lead_midia_social_res_form.php");
                            ?>
                        </div> 
                        <-Financeiro Lead->
                        <div class="tab-pane fade" id="financeiro_lead" role="tabpanel" aria-labelledby="financeiro_lead-tab">      
                            Financeiro
                            <?
                                //include("lead_midia_social_res_form.php");
                            ?>
                        </div---> 
                        <!--Ocorencias Lead-->
                        <div class="tab-pane fade" id="ocorrencias_lead" role="tabpanel" aria-labelledby="ocorrencias_lead-tab">        
                        <? include("ocorrencia_res_form.php");?>
                        </div> 
                        <!--Documentos Lead-->
                        <div class="tab-pane fade" id="documentos_lead" role="tabpanel" aria-labelledby="documentos_lead-tab">
                            <?include("documentos_res_form.php");?>
                        </div>                         
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>

<?
echo "<script>var ic_abertura = 3;</script>";
include "../inc/php/footer.php";
?>

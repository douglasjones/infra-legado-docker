<?
require_once "../inc/php/header.php";
?>

<script src="teste_modal.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
  

<div class="row">

    <div class="col-md-12">
        <div  id="abrir" tabindex="-1" role="dialog"aria-labelledby="modal-set-ramalLabel">
            <div class="modal-dialog" role="document" style="max-width:1000px;">
                <div class="modal-content">
				<div >
                    <ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">                     
                        <li class="nav-item">
                            <a class="nav-link active" id="dados_cadastrais_lead-tab" data-toggle="tab" href="#dados_cadastrais_lead" role="tab" aria-controls="dados_cadastrais_lead" aria-selected="true">Dados Cadastrais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contatos_lead-tab" data-toggle="tab" href="#contatos_lead" role="tab" aria-controls="contatos_lead" aria-selected="false">Contato(s)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="midias_sociais_lead-tab" data-toggle="tab" href="#midias_sociais_lead" role="tab" aria-controls="midias_sociais_lead" aria-selected="false">Mídias Sociais</a>
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
                            <?
                                //include("lead_det_from.php");
                            ?>          
                        </div>
                        <!--Contato Lead-->
                        <div class="tab-pane fade" id="contatos_lead" role="tabpanel" aria-labelledby="contatos_lead-tab">      
                            <?
                                //include("contato_res_form.php");
                            ?>
                        </div>  
                        <!--Midias Sociais Lead-->
                         <div class="tab-pane fade" id="midias_sociais_lead" role="tabpanel" aria-labelledby="midias_sociais_lead-tab">      
                            <?
                                //include("lead_midia_social_res_form.php");
                            ?>
                        </div>  
                         <!--Agendas Lead-->
                        <div class="tab-pane fade" id="agendas_lead" role="tabpanel" aria-labelledby="agendas_lead-tab">      
                             Agenda
                            <?
                                //include("lead_midia_social_res_form.php");
                            ?>
                        </div>  
                          <!--Comercial Lead-->
                        <div class="tab-pane fade" id="comercial_lead" role="tabpanel" aria-labelledby="comercial_lead-tab">      
                             Comercial
                            <?
                                //include("lead_midia_social_res_form.php");
                            ?>
                        </div>  
                         <!--Operacional Lead-->
                        <div class="tab-pane fade" id="operacional_lead" role="tabpanel" aria-labelledby="operacional_lead-tab">      
                             Operacional
                            <?
                                //include("lead_midia_social_res_form.php");
                            ?>
                        </div> 
                         <!--Financeiro Lead-->
                        <div class="tab-pane fade" id="financeiro_lead" role="tabpanel" aria-labelledby="financeiro_lead-tab">      
                             Financeiro
                            <?
                                //include("lead_midia_social_res_form.php");
                            ?>
                        </div> 
                         <!--Ocorencias Lead-->
                         <div class="tab-pane fade" id="ocorrencias_lead" role="tabpanel" aria-labelledby="ocorrencias_lead-tab">        
                            <?
                                //include("ocorrencia_res_form.php");
                            ?>
                        </div> 
                         <!--Documentos Lead-->
                         <div class="tab-pane fade" id="ocorrencias_lead" role="tabpanel" aria-labelledby="ocorrencias_lead-tab">      
                            Documentos
                            <?
                                //include("lead_midia_social_res_form.php");
                            ?>
                        </div>                         
                    </div>    
				</div>

                </div>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-primary" id="cmd1"  name="cmd1">Abrir Modal</button>
<?
require_once "../inc/php/footer.php";
?>
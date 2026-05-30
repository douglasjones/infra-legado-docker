<?
require_once "../inc/php/header.php";
?>

<script src="faturamento_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">


<script src="../inc/assets/js/pages/form-wizard.js"></script>
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


</head>

<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Novo Faturamento</h6>     
                        </div>       
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdGerarFaturamento">Gerar</button>                          
                        </div>
                    </div>   
				</div>
				<div class="card-body">
                <div class="row">
     
        </div> 
        <hr>
        <div class="tab-content">

            <form id="form_lead" class="form">
                <input type="hidden" id="faturamento_pk" name="faturamento_pk">
                <input type="hidden" id="qtde_contas" name="qtde_contas">

                <div class='row'>
                    <div class='col-md-3'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='dt_faturamento_ini'>Dt Inicio Faturamento:&nbsp;</label>
                        <input type="text" class='form-control form-control-sm' id="dt_faturamento_ini" name="dt_faturamento_ini">
                     </div>
                     <div class='col-md-3'>
                        <label for='dt_faturamento_fim'>Dt Fim Faturamento:&nbsp;</label>
                        <input type="text" class='form-control form-control-sm' id="dt_faturamento_fim" name="dt_faturamento_fim">
                    </div>
                </div>
                <p>  
                <div class='row'>
                    <div class='col-md-3'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                    Empresa(s)  
                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>  
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <div id="listar_contas"></div>
                    </div>
                </div>

                <p>  
                <div class='row'>
                    <div class='col-md-3'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                    Tipos de Contrato(s)  
                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>  
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_contrato_fixo'> Contratos Fixos:&nbsp;</label>
                        <input  type='checkbox' id='ic_contrato_fixo' name='ic_contrato_fixo' />
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_contrato_aditivo'>Contratos Aditivos:&nbsp;</label>
                        <input  type='checkbox' id='ic_contrato_aditivo' name='ic_contrato_aditivo' />
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_contrato_servico_extra'>Contratos Servicos Extras:&nbsp;</label>
                        <input  type='checkbox' id='ic_contrato_servico_extra' name='ic_contrato_servico_extra' />
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                    Emissões  
                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>  
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_gerar_boleto'> Gerar Fatura:&nbsp;</label>
                        <input  type='checkbox' id='ic_gerar_fatura' name='ic_gerar_fatura' />
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_gerar_boleto'> Gerar Boletos:&nbsp;</label>
                        <input  type='checkbox' id='ic_gerar_boleto' name='ic_gerar_boleto' />
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_gerar_nota_fiscal'>Gerar Notas Fiscais:&nbsp;</label>
                        <input  type='checkbox' id='ic_gerar_nota_fiscal' name='ic_gerar_nota_fiscal' />
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                    Dados Cmplemantáres  
                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>  
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='obs'> Observação:&nbsp;</label>
                        <textarea  rows="5" cols="30" id="obs" name="obs"></textarea>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-4'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ic_status'> Status:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ic_status' name='ic_status' />
                            <option value=1>Faturamento Gerado</option>
                            <option value=2>Faturamento Cancelado</option>
                        </select>
                    </div>
                </div>
            </form>           

        </div>   
        <div class="row">
            <div class="col-md-12" align="Right">
            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            <br>
                <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                &nbsp;
                <button type="button" class="btn btn-primary btn-sm" id="cmdGerarFaturamento">Gerar</button>                
        </div>
                </div>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
   


<div class='row' id="dados_faturamento_div" style="display:none">
    <table class='table' border="0" align="center" style='width:95%;' >
        <tr>
            <td width="1%">
                &nbsp;
            </td>
            <td >


                <?
                   // include("faturamento_item_res_form.php");
                ?>    
            </td>
        </tr>
    </table>
</div>


<?
require_once "../inc/php/footer.php";
?>

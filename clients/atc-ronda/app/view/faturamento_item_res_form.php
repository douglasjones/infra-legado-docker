<?
require_once "../inc/php/header.php";
?>
<script src="https://cdn.jsdelivr.net/gh/AmagiTech/JSLoader/amagiloader.js"></script>
<script src="faturamento_item_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
</head>  
<style>
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="loader" id='loader' style='display:none'></div>
<div id='exibir'>
    <body>   
        <p>
        <div class="card shadow"  style="margin:12px" >
            <div class="card-header">
                <h6 class="font-weight-bold text-primary">Faturamento - Dados</h6>
            </div>
        </div>     
    </body>
    <br>
    <div id="DadosFaturamento">
        <div class="row">
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-10'>
                <h4>Dados de Configuração do Faturamento</h4>
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            </div>
        </div>
        <div class="row">
        <div class="col-1">&nbsp;</div>
        
            <div class="col-11">
                <table width='100%'  >
                    <tr>
                        <td width='50%' >
                            <div class="row">
                                <div class='col-md-6'>
                                    <label for='usuarioCadastro'><b>Usuário Cadastro:</b>&nbsp;</label>                   
                                    <label id="dsUsuarioCadastro"></label>
                                </div>
                                <div class='col-md-6'>
                                    <label for='usuarioCadastro'><b>Dt Cadastro:</b>&nbsp;</label>                   
                                    <label id="dtCadastro"></label>
                                </div>
                            </div>    
                        </td>

                        <td width='50%'>
                            <div class="row">
                                <div class='col-md-6'>
                                    <label for='usuarioCadastro'><b>Usuário Atualização:</b>&nbsp;</label>                   
                                    <label id="dsUsuarioAtualizacao"></label>
                                </div>
                                <div class='col-md-6'>
                                    <label for='usuarioCadastro'><b>Dt Atualizacao:</b>&nbsp;</label>                   
                                    <label id="dtAtualizacao"></label>
                                </div>
                            </div>    
                        </td>
                    </tr>
                    <tr>
                        <td width='50%' >
                            <div class="row">
                                <div class='col-md-6'>
                                    <label for='usuarioCadastro'><b>Cód Faturamento:</b>&nbsp;</label>                   
                                    <label id="pkFaturamento"></label>
                                </div>
                                <div class='col-md-6'>
                                    <label for='usuarioCadastro'><b>Período Faturamento:</b>&nbsp;</label>                   
                                    <label id="periodoFaturamento"></label>
                                </div>
                            </div>    
                        </td>
                        <td width='50%'>
                            <div class="row">
                                <div class='col-md-6'>
                                    <label for='usuarioCadastro'><b>Status Faturamento:</b>&nbsp;</label>                   
                                    <label id="dsStatusFaturamento"></label>
                                </div>
                                <div class='col-md-6'>
                                    <label for='usuarioCadastro'><b>Dt Processamento:</b>&nbsp;</label>                   
                                    <label id="dtProcessamento"></label>
                                </div>
                            </div>    
                        </td>                    
                    </tr>
                    <tr>
                        <td width='50%' >
                            <div class="row">
                                <div class='col-12'>
                                    <label for='usuarioCadastro'><b>Tipo de Contratos:</b>&nbsp;</label>    
                                    <div class="form-group m-6 p-6">                                                          
                                        <label id="dsTiposContratos"></label>         
                                    </div>
                                </div>
                
                            </div>    
                        </td>
                        <td width='50%'>
                            <div class="row">
                                <div class='col-12'>
                                    <label for='usuarioCadastro'><b>Emissões:</b>&nbsp;</label>    
                                    <div class="form-group m-6 p-6">                                                          
                                        <label id="dsEmissoes"></label>
                                    </div>                                    
                                </div>                           
                            </div>    
                        </td>                    
                    </tr>
                    <tr>
                        <td width='50%' >
                            <div class="row">
                                <div class='col-12'>
                                    <label for='usuarioCadastro'><b>Empresas:</b>&nbsp;</label>  
                                    <div class="form-group m-6 p-6">                                                          
                                        <label id="dsContas"></label>  
                                    </div>                                
                                </div>
                            </div>    
                        </td>
                        <td width='50%'>
                            <div class="row">
                                <div class='col-12' style='vertical-align: text-top;'>
                                    <label for='usuarioCadastro'><b>Observação:</b>&nbsp;</label>  
                                    <div class="form-group m-6 p-6">                                                          
                                        <label id="dsObs"></label>  
                                    </div>                                
                                </div>
                            </div>    
                        </td>                    
                    </tr>
            
                </table>
            </div>       
        </div> 
        <!--<div class="row">
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-md-10'>        
                <hr style="box-shadow: 2px 2px 2px grey;">
            </div>
        </div>       -->
    </div>

    <p>
    <div id="DadosComposicaoFaturamento">
        <div class="row">
            <div class='col-md-1'>
                &nbsp;
            </div>
            <div class='col-10'>
                <h4>Composição Faturamento</h4>
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            </div>
        </div>    
        <p>
        <div id="composicao_faturamento"></div>
    </div>

    <div class="row">
        <div class='col-md-6'>
            &nbsp;
        </div>
        <div class='col-md-5'  align='right'>
            Total Geral Faturamento: R$ <span id='vl_total_geral_faturamento'></span>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class='col-md-6'>
            &nbsp;
        </div>
        <div class='col-md-5'  align='right'>
            <button class='btn btn-primary' id='cmdSalvar'>Salvar</button>
            <button class='btn btn-success' id='cmdProcessar'>Processar</button>
        </div>
    </div>
    <br>
    <br>
    <br>
</div>

<?
require_once "../inc/php/footer.php";
?>

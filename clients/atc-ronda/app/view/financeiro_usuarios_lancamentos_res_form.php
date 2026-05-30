<?
require_once "../inc/php/header.php";
include_once "../inc/php/public.php";
include_once "../inc/classes/bestflow/DataBase.php";

$arrDados = array();
$arrDados = tratarToken($token);
$usuarios_pk =  $arrDados['usuarios_pk'];

?>
<script src="financeiro_usuarios_lancamentos_res_form.js" type="text/javascript" charset="utf-8"></script>
<script src="financeiro_usuario_documento_res_form.js" type="text/javascript" charset="utf-8"></script>
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

    <br>
    <form id="dados">
        <input type='hidden' id='usuario_pk' value='<?=$usuarios_pk;?>'>
        <div class="row">
            <div class="col-lg">
                <p>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">	
                        <div class="row">
                            <div class='col-sm-6' align="left">
                                <h6 class="m-0 font-weight-bold text-primary">Controle Lançamento(s) Financeiro</h6>
                            </div> 
                            <div class='col-sm-6' align="Right">
                                <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltarUsuario">Voltar</button>                             
                            </div>
                        </div>
                    </div>		
                    <div class="card-body">
                        <div class="row">						
                            &nbsp;
                        </div>
                        <div class="row" > 
                            <div class="col-md-12" >
                                <div class='row'>
                                    <div class='col-sm-2'>
                                        <button type='button' class="btn btn-primary" id='cmdNovoLencamento'>Novo Lançamento</button>    
                                    </div>
                                </div> 
                            </div>         
                        </div> 
                        <div class="row">						
                            &nbsp;
                        </div>
                        <div class="row" > 
                            <div class="col-md-12" >
                                <? include_once("financeiro_grid_usuarios_res_form.php");?>       
                            </div>         
                        </div> 
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
<?
include_once "correcao_usuario_analise_financeira_form_res.php";  
require_once "financeiro_contas_pagar_cad_form.php";
require_once "financeiro_documentos_cad_form.php";
require_once "financeiro_documento_historico_res_form.php";
require_once "../inc/php/footer.php";
?>
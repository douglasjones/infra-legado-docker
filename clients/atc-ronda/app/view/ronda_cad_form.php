<?php

function encontrarMainInclude(){
    $arrURL = explode("/", $_SERVER["REQUEST_URI"]);
    $strURL = "";
    $url = "";   

    $intRetorno = 0;
    for($i = (count($arrURL)-1); $i > 0; $i--){

        $strURL .= "../";
        $url = $strURL."inc/php/maininclude.php";
        
        //Verifica se o arquivo libs/maininclude existe;
        if(is_file($url)){
            break;
        }
    }
    return $strURL;    
}
//Determina o caminho de todos os includes
$strPath = encontrarMainInclude();
session_start();
define("PATH", $strPath);
    
$posto_trabalho =  $_REQUEST['posto'];
$ponto_ronda = $_REQUEST['local'];

?>
<html>
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM - Nova Senha</title>

    <!-- Custom fonts for this template-->
    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../inc/css/themas/sb-admin-2.min.css" rel="stylesheet">
	
    <?php include_once '../inc/php/scripts.php';?>
</head>  

<script src="ronda_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Ronda</h2>
            <hr>
        </div>
    </div>
    <form id="form" class="form">
        <input type="hidden" id="local_ronda_pk" name="local_ronda_pk" value="<?=$ponto_ronda;?>">
        <input type="hidden" id="leads_pk" name="leads_pk" value="<?=$posto_trabalho;?>">
        <div class='row'>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='leads_pk'>Posto de Trabalho:&nbsp;</label>
                <?echo $posto_trabalho;?>

            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='local_ronda_pk'> Ronda:&nbsp;</label>
                <? echo $ponto_ronda;?>
            </div>
        </div>

        <!--<div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='dt_ronda'>Dt Hora Ronda:&nbsp;</label>
                <? echo $dt_hora_ronda;?>
            </div>
        </div>-->


        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="center">
                <hr>
                <button type="submit" class="btn-primary" id="cmdEnviar">Enviar</button>
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

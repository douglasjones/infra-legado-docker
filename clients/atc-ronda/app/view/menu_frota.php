<?
session_start();
$_SESSION['link'] = "menu_frota.php";
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
    <?require_once '../inc/php/scripts.php';?>

</head>
<div class="container">
    
	<br>
    <?if(permissao("frota_controle", "cons", $token)){?>
        <div class="row">
            <div class="col-lg">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Controle de Frota e Coondutores</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">  
                            <div class="col-sm">
                                <div class="text-left">
                                    <div class=' col-sm text-left'>
                                        <a href="javascript: abrirMenu('condutor_res_form.php');">
                                            <label  style="font-size: 15px"><img src="../img/responsavel.png" width="50"> &nbsp;Condutores</label>
                                        </a>
                                    </div>                             
                                </div>   
                                <p>  
                            </div>
                        </div>
                        <div class="row">  
                            <div class="col-sm">
                                <div class="text-left">
                                    <div class=' col-sm text-left'>
                                        <a href="javascript: abrirMenu('veiculo_res_form.php');">
                                            <label  style="font-size: 15px"><img src="../img/frota.png" width="50">&nbsp;Veículos</label>
                                        </a>
                                    </div>                             
                                </div>   
                                <p>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?}?>    
    <?if(permissao("frota_checklist", "cons", $token)){?>
        <div class="row">
            <div class="col-lg">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Frota</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">  
                            <div class="col-sm">
                                <div class="text-left">
                                    <div class=' col-sm text-left'>
                                        <a href="javascript: abrirMenu('frota_res_form.php');">
                                            <label  style="font-size: 15px"><img src="../img/frota.png" width="50"> &nbsp;Checklist</label>
                                        </a>
                                    </div>                             
                                </div>   
                                <p>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?}?>
</div>

<?
include "../inc/php/footer.php";
?>

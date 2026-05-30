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

$ds_login = $_REQUEST['ds_login'];
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
<script src="nova_senha.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>  
<style>
	.logo{
		display: flex;
	    justify-content: center;
	    align-items: center;
	    height: 25rem;
	    width: 50%;
	}
    @media(min-width: 1000px) and (max-width: 1200px){
        .container{
            margin-top: 5em;
        }
    }
    @media(min-width: 1200px){
        .container{
            margin-top: 10em;
        }
    }
</style>
<body style="background-color:#14074F;">
	<div class="container">
		<div class="row justify-content-center">
		
			<div class="col-xl-10 col-lg-12 col-md-9">
			
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
				 
						<div class="row">
							<div class="logo" align="center">
							  <img id="ds_img_cliente" src="" width="70%" >
							</div>
							<div class="col-lg-6">
								<div class="p-5">
									<div>
										<h1 class="h4 text-gray-900 mb-4" align="center">Registre uma nova senha!</h1>
									</div>
									<form id="form_trocar_senha" class="user"> 
										<div class="form-group">
											<input type="text" name="ds_login" class="form-control form-control-user" disabled id="ds_login" value="<?=$ds_login?>">
                                            
                                        </div>
										<div class="form-group">
											<input type="password" name="ds_nova_senha" id="ds_nova_senha" class="form-control form-control-user" placeholder="Senha">
                                            <div align="center" id="alert_ds_nova_senha" style="display:none">
												<span style="color: red">Por favor, informe o Nova Senha</span>
											</div>
                                        </div>
										<div class="form-group">
											<input type="password" name="ds_confirmar_senha" id="ds_confirmar_senha" class="form-control form-control-user" placeholder="Confirme a senha">
                                            <div align="center" id="alert_ds_confirmar_senha" style="display:none">
												<span style="color: red">Por favor, informe a Confirmar Senha</span>
											</div>
                                            <div align="center" id="alert_incorreta" style="display:none">
												<span style="color: red">As senhas informadas são diferentes</span>
											</div>
                                        </div>
										<button type="button" class="btn btn-primary btn-user btn-block" id="cmdConfirmarSenhaNova">Enviar</button>
										<hr>
										<div class="row">
											<div class="col" align="right" >
												<img width="80" height="20" src="../img/nlogo.png" >
											</div> 
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
//include_once "../inc/php/footer.php";
?>
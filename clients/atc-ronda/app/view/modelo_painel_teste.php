<?
include "../inc/php/header.php";
$token = $_REQUEST['token'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
</head>
<body>
    <div class="row">
        <div class="modal-content" style="box-shadow: 2px 2px 5px grey;"> 
            <div class="modal-body"> 
                <div class="row">  
                     <div class="col-sm"> 
                        <h5>Usuários </h5> 
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('usuario_res_form.php');">
                                    <img src=../img/usuarios.png width="40">&nbsp;Usuários
                                </a>
                            </div>
                        </div>                           
                    </div> 
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?
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
?>
<html>
    <head>
    <?require_once '../inc/php/scripts.php';?>
    </head>
<style>
    @import "bourbon";

    .wrapper {
        margin-top: 80px;
        margin-bottom: 80px;
    }
    .form-signin {
      max-width: 380px;
      padding: 15px 35px 45px;
      margin: 0 auto;
      background-color: #fff;
      border: 1px solid rgba(0,0,0,0.1);
    }
    .login-wrap .login-input {
        position: relative;
      }
      .form-group {
        position: relative;
        margin-bottom: 1.5rem;
      }

      .form-control-placeholder {
        position: absolute;
        top: 0;
        padding: 7px 0 0 13px;
        transition: all 200ms;
        opacity: 0.5;
      }

      .form-control:focus + .form-control-placeholder,
      .form-control:valid + .form-control-placeholder {
        font-size: 75%;
        transform: translate3d(0, -100%, 0);
        opacity: 1;
      }
      .label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 300px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -webkit-appearance:none;
  border-radius:0;
}

.label-float input:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input::placeholder{
  color:transparent;
}

.label-float label{
  pointer-events: none;
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 13px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
}

.label-float input:required:invalid + label{
  color: red;
}
.label-float input:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input:focus + label,
.label-float input:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
</style>
<script src="tarefas_login.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>  


<br><br><br><br><br><br><br>
<div class="container">
    <div class="wrapper">
         <form id="form" class="form-signin" >
            <input type="hidden" id="pk" name="pk" value="<?=$_REQUEST['pk'];?>">
            <div class="row">
                <div class="col" align="center">
                     <img src="../img/nlogo.png"  width="100%">
                </div>              
            </div>
            <div class="row">
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class='col-md-12'>
                    <div class="label-float">
                        <input type="text" id="ds_login" name="ds_login"  placeholder=" "/>
                        <label>Pin</label>
                    </div>
                </div>
            </div>
            <div class="row" id="alert_login" style="display:none">
                <div class='col-md-12'>
                    <strong style="color: red">Por favor, informe o Pin!</strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col" align="center">
                    <button type="button" class="btn btn-lg btn-primary btn-block" id="cmdEnviar">Login</button>
                </div>               
            </div>
            <div class="row">
                <div class="col" align="right" style="font-size:12px; text-align: rigth">
                    <label><span id="ds_versao"></span></label>
                </div>               
            </div>
        </form>
    </div>
</div>
</html>
<?
//require_once "../inc/php/footer.php";
?>

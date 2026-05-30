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
    <?require_once '../inc/php/public.php';?>
    </head>
<?   
    $ds_colaborador = $_REQUEST['ds_colaborador'];
    $ds_pin = $_REQUEST['ds_pin'];
    $colaborador_pk = $_REQUEST['colaborador_pk'];
?>

<script src="colaborador_holerite_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="container">
    <form id="form_holerite" class="form">
        <input type="hidden" id='ds_colaborador_nome' value="<?=$ds_colaborador;?>">  
        <input type="hidden" id='ds_colaborador_pin' value="<?=$ds_pin;?>">  
        <input type="hidden" id='colaborador_pk' value="<?=$colaborador_pk;?>">  
        <br>
        <div class="row">
            <div class="col" align="center">
                    <img src="../img/nlogo.png"  width="10%">
            </div>              
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <h4>Holerites</h4>
            </div>
            <div class="col-md-6" align="right">
                <button type="button" class="btn btn-primary" id="cmdSair">Sair</button> 
            </div>
        </div>
        <hr>
        <div class='row'>
            <div class='col-md-1'>
                <label for='ds_colaborador0'>Colaborador:&nbsp;</label>                
            </div>
            <div class='col-md-3'>
                <div id='ds_colaborador_div'></div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-1'>
                <label for='ds_colaborador2'>PIN:&nbsp;</label>
            </div>
            <div class='col-md-3'>
                <div id='ds_pin_div'></div>
            </div> 
        </div>
        <hr>  
        <div class="row" id="div_ano" >
            <div class="col-md-2">
                &nbsp;
            </div>
            <div class="col-md-8">
               <div id='div_table_ano'></div>
            </div>
        </div>  
        <div class="row" id="div_meses"   style="display:none">
            <div class="col-md-2">
                &nbsp;
            </div>
             <div class="col-md-8">
               <div id='div_table_meses'></div>
            </div>
        </div>  
        <div class="row" id="div_holerites_mes"   style="display:none">
            <div class="col-md-2">
                &nbsp;
            </div>
             <div class="col-md-8">
               <div id='div_table_holerite_mes'></div>
            </div>
        </div>  
    </form>  
</div>
</html>
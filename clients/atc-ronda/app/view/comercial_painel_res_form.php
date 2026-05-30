<?
include "../inc/php/header.php";
require_once '../inc/php/scripts.php';
?>

<script src="comercial_painel_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
</head>  
<style>
    /*Cards e boxes*/
    .parent {
        color: black;
        display: flex;
        font-family: sans-serif;
        font-weight: bold;
        flex-direction: row;
        /*margin: 2em;*/
    }
    .box {
        background-color: #EBECF0;
        padding: 10px;
        margin-right:0.5em;
        width: 22em;
        /*align-items: center;*/
        border-radius: 2px;
    }
    .tituloCartao{
        border: none;
        background-color: #EBECF0;
    }
    .head_card{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .menu{ 
        filter: alpha(opacity=50);
        opacity: 0.5;
        -moz-opacity: 0.5;
        -webkit-opacity: 0.5;
        border: none;
    }
    .menu:hover{
        background-color: #DADBE2;
        border-radius: 3px;
    }
    .draggable {
        background-color: #ffff;
        font-weight: normal;
        padding: 10px;
        width: 20em;
        margin: 15px 10px;
        border-radius: 2px;
        box-shadow: 0px 0.5px #888888;
        overflow:auto; 
        overflow-x: hidden;
    }

    .draggable:hover {
        background-color: #EBECF0;
        height: auto;
    }

    .nested {
        display: none;
    }

    .active {
        display: block;
    }

    .item_menu{
        background-color:#000; 
        opacity: 0.8; 
        border-radius:3px;
        margin: 5px;
        padding: 7px;

    }
    .menu_suspenso{
        position: fixed;
    }
</style>
<body>
    
        <p>
        <div class="card shadow"  style="margin:12px" >
            <div class="card-header">
                <h6 class="font-weight-bold text-primary">Painel de Controle Comercial</h6>
            </div>
        </div>
        <form>
            <input type="hidden" id="origem" name="origem" value="">
            <div class="card-body">
                <div>
                    <button type="button" class="btn btn-primary" id="cmdEnviarLead"  name="cmdEnviarLead">+ Novo Lead</button>
                    <button type="button" class="btn btn-primary" id="cmdBuscarLead"  name="cmdBuscarLead">Buscar Lead's</button>
                    <hr>
                </div>
            </div>

            <div id="parent" name="parent" class="parent">
            </div>

        </form>
    </div>    
</body>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?
include "lead_res_form.php";
include "agenda_painel_comercial_res.php";
echo "<script>var ic_abertura = 2;</script>";
include "apontamento_colaborador_cad_form.php";
?>

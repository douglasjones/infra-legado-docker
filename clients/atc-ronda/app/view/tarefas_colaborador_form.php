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

?>
<head>
    <?
    require_once '../inc/php/scripts.php';
    ?>
    </head>
<script src="tarefas_colaborador_form.js?" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class='row' >
        &nbsp;
    </div>
    <div class='row' >
        &nbsp;
    </div>
    <form id="form" class="form-signin" >
        <input type="hidden" id="colaborador_pk" name="colaborador_pk" value="<?=$_REQUEST['colaborador_pk']?>">
        <input type="hidden" id="ds_colaborador" name="ds_colaborador" value="<?=$_REQUEST['ds_colaborador']?>">
        <input type="hidden" id="tarefas_pk" name="tarefas_pk" value="<?=$_REQUEST['tarefas_pk']?>">
                <div class="row">
            <div class="col-md-12"  align="center">
                <h5>Bem vindo</h5>
                <div id="ds_colaborador_logado"></div>
            </div>
        </div>   
        <p>
        <div class="row">
            <div class="col-md-12"  align="center">
                <h4>Tarefas</h4>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Identificação da Tarefa:&nbsp;</label>
            </div>    
            <div class='col-sm-3'>
                <div id="ds_identificacao_tarefa"></div>
            </div>          
        </div> 
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Posto de trabalho:&nbsp;</label>
            </div>    
            <div class='col-md-3'>
                <div id="ds_posto_trabalho"></div>
            </div>          
        </div> 
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Setor:&nbsp;</label>
            </div> 
            <div class='col-md-3'>
                <div id="ds_setor"></div>
            </div>   
        </div> 
       <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Área:&nbsp;</label>
            </div>  
            <div class='col-md-3'>
                <div id="ds_area"></div>
            </div> 
        </div> 
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Tarefa:&nbsp;</label>
            </div>  
            <div class='col-md-3'>
                <div id="ds_tarefa"></div>
            </div> 
        </div> 
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">Dia e HR:&nbsp;</label>
            </div>  
            <div class='col-md-3'>
                <div id="ds_dias_hr"></div>
            </div> 
        </div> 
        <div class="row">
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">OBS:&nbsp;</label>
            </div>  
            <div class='col-md-3'>
                <div id="ds_obs"></div>
            </div> 
        </div>     
        <p>
        <div class="row" id="linha_separacao"  style="display:none">
            <div class="col-md-12"  align="center">
                <hr>
               
            </div>
        </div>    
        <div class="row" id="dt_inicio_execucao"  style="display:none">            
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">DT/HR inicio Tarefa:&nbsp;</label>
            </div> 
            <div class='col-md-3'>
                <div id="dt_ini_execucao"></div>
            </div> 
        </div> 
        <div class="row" id="dt_termino_execucao"  style="display:none">            
            <div class="col-md-4">
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for="ds_colaborador">DT/HR Termino Tarefa:&nbsp;</label>
            </div> 
            <div class='col-md-3'>
                <div id="dt_fim_execucao"></div>
            </div> 
        </div> 
        <div class="row" id="btn_termino_tarefa" style="display:none">
            <div class="col-md-12"  align="center">            
                <button type='button' class="btn btn-primary" id='cmdTerminoTarefa'>Finalizar Tarefa</button>   
            </div>
        </div>                
        <div class="row" id="btn_inicio_tarefa">
            <div class="col-md-12"  align="center">            
                <button type='button' class="btn btn-primary" id='cmdInicioTarefa'>Iniciar Tarefa</button>   
            </div>
        </div>
    </form>  
    <div class="row">
        <div class="col-md-12"  align="center">
            <hr>
            <button type="button" class="btn btn-secondary" id="cmdCancelar" data-dismiss="modal">Sair</button>
        </div>
    </div>
</div> 



<?

//recebe o token 
$token = $_REQUEST['token'];
//função para determinar o path dos arquivos de include.
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

define("PATH", $strPath);

require_once PATH."inc/php/config.php";
require_once PATH."inc/php/public.php";

//Verifica se o login é válido.


?>
<html>
    <head>

    <?require_once PATH.'inc/php/scripts.php';?>
    <script>

        <?        
            criarConstantesPost();     
        ?>
        </script>

<script src="form_site_colaborador_cad.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
  
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>FICHA DE CADASTRO</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        <input type="hidden" name="tokne" id="token" value="99" >
        <div class='row'>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>   
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                <div class="row">
                    <div class="col-md-2">
                        &nbsp;
                    </div>
                    <div class="col-md-4">
                        <label for="produtos_servicos_pk">Cargo Pretendido:&nbsp;</label>
                        <select id="produtos_servicos_pk" class="form-control form-control-sm" name="produtos_servicos_pk">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class='row' id="alert_produtos_servicos_pk" style="display:none">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <strong style="color: red">Por favor, selecion o Cargo</strong>
                    </div>
                </div>
                
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <div class="label-float">
                            <label>Nome do Candidato</label>
                            <input type="text" id="ds_colaborador" class='form-control form-control-sm' name="ds_colaborador" maxlength="100" placeholder=" " />                            
                        </div>
                    </div>                    
                </div>
                <div class='row' id="alert_ds_colaborador" style="display:none">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <strong style="color: red">Por favor, informe o Nome Completo</strong>
                    </div>
                </div>
                
                
                 <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='dt_nascimento'>Data Nasc.:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="10" id='dt_nascimento' name='dt_nascimento' >
                    </div> 
                     
                    <div class='col-md-2'>
                        <label for='generos_pk'>Gênero:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='generos_pk' name='generos_pk' required>
                            <option></option>
                        </select>
                    </div>    
                </div>    
                <div class='row' id="alert_dt_nascimento" style="display:none">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <strong style="color: red">Por favor, informe a Data de Nascimento</strong>
                    </div>
                </div>
               <div class='row' id="alert_generos_pk" style="display:none">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <strong style="color: red">Por favor, selecione o Gênero</strong>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_cpf'>CPF:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="14" id='ds_cpf' name='ds_cpf' >
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_rg'>RG/RNE:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="9" id='ds_rg' name='ds_rg' >
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ds_cel2'>Nome do Pai:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nome_pai' name='ds_nome_pai'  >
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ic_whatsapp2'>Nome da Mãe:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_nome_mae' name='ds_nome_mae'  >
                    </div>
                </div>
               
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <div class="label-float">
                            <label for='ds_cel'>Cel:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm'  maxlength="14" id='ds_cel' name='ds_cel'  required>                     
                        </div>
                    </div>
                       <div class='col-md-2'>
                        <div class="label-float">
                            <label for='ds_cel'>Telefone p/ Recado:&nbsp;</label>
                            <input type='text' class='form-control form-control-sm'  maxlength="14" id='ds_cel2' name='ds_cel2'  required>                     
                        </div>
                    </div>
                </div>
                <div class='row' id="alert_ds_cel" style="display:none">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <strong style="color: red">Por favor, informe Celular</strong>
                    </div>
                </div>
                <div class='row' id="alert_ds_cel2" style="display:none">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <strong style="color: red">Por favor, informe o Telefone</strong>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ds_email'>E-mail:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_email' name='ds_email' >
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_cep'>CEP:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' maxlength="9" id='ds_cep' name='ds_cep' >
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <label for='ds_endereco'>Endereço:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_endereco' name='ds_endereco' >
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-1'>
                        <label for='ds_numero'>Número:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_numero' name='ds_numero' >
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_complemento'>Complemento:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_complemento' name='ds_complemento' >
                    </div>
                    <div class='col-md-3'>
                        <label for='ds_bairro'>Bairro:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_bairro' name='ds_bairro' >
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for='ds_cidade'>Cidade:&nbsp;</label>
                        <input type='text' class='form-control form-control-sm' id='ds_cidade' name='ds_cidade' >
                    </div>
                    <div class='col-md-2'>
                        <label for='ds_uf'>UF:&nbsp;</label>
                        <select class='form-control form-control-sm'  id='ds_uf' name='ds_uf'>
                            <option></option>
                            <option>AC</option>
                            <option>AL</option>
                            <option>AP</option>
                            <option>AM</option>
                            <option>BA</option>
                            <option>CE</option>
                            <option>DF</option>
                            <option>ES</option>
                            <option>GO</option>
                            <option>MA</option>
                            <option>MT</option>
                            <option>MS</option>
                            <option>MG</option>
                            <option>PA</option>
                            <option>PB</option>
                            <option>PR</option>
                            <option>PE</option>
                            <option>PI</option>
                            <option>RJ</option>
                            <option>RN</option>
                            <option>RS</option>
                            <option>RO</option>
                            <option>RR</option>
                            <option>SC</option>
                            <option>SP</option>
                            <option>SE</option>
                            <option>TO</option>                            
                        </select>
                    </div> 
                </div>

                <div class='row' id="alert_ds_razao_social" style="display:none">
                    <div class='col-md-2'>
                        &nbsp;
                    </div>
                    <div class='col-md-8'>
                        <strong style="color: red">Por favor, informe a Razão Social</strong>
                    </div>
                </div>
                
            </div> 
            <p>    
            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'> 
            <p>
            <div class="row">
                <div class="col-md-12" align="center">                
                    <!--<button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>
                    &nbsp;      -->          
                    <button type="button" class="btn btn-primary" id="cmdEnviarTudo">ENVIAR</button>
                </div>
            </div>
        </form>
</div>

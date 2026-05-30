<?
require_once "../inc/php/header.php";
?>

<script src="fornecedor_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Fornecedor</h4>
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
        <br>
        <div class="row">
            <div class='col-md-2'>
                &nbsp;
            </div> 
            <div class="col-md-10">
                <h5>Dados do Fornecedor</h5>
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <label for="ds_fornecedor">Fornecedor:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_fornecedor" required="true">
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <label for="ds_fornecedor">Razão Social:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_razao_social" required="true">
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <label for="ds_fornecedor">CPF/CNPJ:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" maxlength="18" id="ds_cpf_cnpj" required="true">
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_fornecedor'>Categoria:&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='categorias_produto_pk' name='categorias_produto_pk' requered/>
                    <option></option>
                </select>    
           </div>
        </div>
        
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-3'>
                <label for='ds_tel'>Telefone:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_tel" required="true">
            </div>
        </div>

        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-5'>
                <label for='ds_email'>E-mail:&nbsp;</label>
                <input type="text" class="form-control form-control-sm" id="ds_email" required="true">
            </div>
        </div>
        <p>
        <div class="row">
            <div class='col-md-2'>
                &nbsp;
            </div> 
            <div class="col-md-10">
                <h5>Dados Bancários</h5>
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
            </div>
        </div>                    
       <!--div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>     
            <div class='col-md-2'>
                <label for='ds_salario'>Salário R$:&nbsp;</label>
                <input type='text' class='form-control form-control-sm'  id='vl_salario' name='vl_salario' >
            </div> 
        </div--> 
       <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>     
                <div class='col-md-2'>
                <label for='generos_pk'>Tipo Conta:&nbsp;</label>
                <select class='form-control form-control-sm'  id='tipo_conta_bancaria' name='tipo_conta_bancaria'>
                    <option></option>
                    <option value="1">Conta Corrente</option>
                    <option value="2">Conta Poupança</option>
                </select>
            </div>
        </div> 
       <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>     
                <div class='col-md-2'>
                <label for='generos_pk'>Banco:&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='bancos_pk' name='bancos_pk'>
                    <option></option>
                </select>
            </div>
        </div> 
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-2'>
                <label for='ds_cel2'>Agência:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_agencia' maxlength="12" name='ds_agencia'  >
            </div>
            <div class='col-md-2'>
                <label for='ic_whatsapp2'>Conta:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="5" id='ds_conta' name='ds_conta'  >
            </div>
            <div class='col-md-2'>
                <label for='ic_whatsapp2'>Digito:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' maxlength="5"  id='ds_digito'  name='ds_digito'  >
            </div>
            <div class='col-md-4'>
                <label for='ic_whatsapp2'>PIX:&nbsp;</label>
                <input type='text' class='form-control form-control-sm'   id='ds_pix'  name='ds_pix'  >
            </div>
        </div>
        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_cel2'>Favorecido:&nbsp;</label>
                <input type='text' class='form-control form-control-sm' id='ds_conta_favorecido' name='ds_conta_favorecido'  >
            </div>
            
        </div>
        <p>
        <br>
        <div class="row">
            <div class='col-md-2'>
                &nbsp;
            </div> 
            <div class="col-md-10">
                <h5>Endereço do Fornecedor</h5>
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
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


        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
        </div>

        <div class='row'>
            <div class='col-md-2'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ic_status'>Status:&nbsp;</label>
                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </div>
        </div>
        <p>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>
                &nbsp;
                <button type="submit" class="btn btn-primary" id="cmdEnviar">Salvar</button>                
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>

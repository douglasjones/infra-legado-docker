<?
require_once "../inc/php/header.php";
?>

<script src="produto_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Novo Produto</h4>            
        </div>
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    <form id="form" class="form">
       <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='categorias_produto_pk'>Categorias:&nbsp;</label>                
                <select class='form-control form-control-sm chzn-select'  id='categorias_produto_pk' name='categorias_produto_pk'>
                    <option></option>
                </select>
             </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='processos_pk'>Produto / Materiais:&nbsp;</label>
                <input type='text' class=" form-control form-control-file" id="ds_produto" name="ds_produto"/>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='processos_pk'>Quantidade Mínima:&nbsp;</label>
                <input type='text' class=" form-control form-control-file" id="qtde_minima" name="qtde_minima"/>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='processos_pk'>Unidade:&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='tipo_unidade_pk' name='tipo_unidade_pk'>
                    <option></option>
                    <option value='1'>Caixa</option>
                    <option value='2'>Par</option>
                    <option value='3'>Unidade</option>
                    <option value='4'>Conjunto</option>
                    <option value='5'>Fardo</option>
                    <option value='6'>Bloco</option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='processos_pk'>Tempo Troca:&nbsp;</label>
                <select class='form-control form-control-sm chzn-select'  id='ic_tempo_troca' name='ic_tempo_troca'>
                    <option></option>
                    <option value='1'>1 Mês</option>
                    <option value='2'>2 Meses</option>
                    <option value='3'>3 Meses</option>
                    <option value='4'>4 Meses</option>
                    <option value='5'>5 Meses</option>
                    <option value='6'>6 Meses</option>
                    <option value='7'>7 Meses</option>
                    <option value='8'>8 Meses</option>
                    <option value='9'>9 Meses</option>
                    <option value='10'>10 Meses</option>
                    <option value='11'>11 Meses</option>
                    <option value='12'>12 Meses</option>
                    <option value='13'>13 Meses</option>
                    <option value='14'>14 Meses</option>
                    <option value='15'>15 Meses</option>
                    <option value='16'>16 Meses</option>
                    <option value='17'>17 Meses</option>
                    <option value='18'>18 Meses</option>
                    <option value='19'>19 Meses</option>
                    <option value='20'>20 Meses</option>
                    <option value='21'>21 Meses</option>
                    <option value='22'>22 Meses</option>
                    <option value='23'>23 Meses</option>
                    <option value='24'>24 Meses</option>
                    <option value='25'>25 Meses</option>
                    <option value='26'>26 Meses</option>
                    <option value='27'>27 Meses</option>
                    <option value='28'>28 Meses</option>
                    <option value='29'>29 Meses</option>
                    <option value='30'>30 Meses</option>
                    <option value='31'>31 Meses</option>
                    <option value='32'>32 Meses</option>
                    <option value='33'>33 Meses</option>
                    <option value='34'>34 Meses</option>
                    <option value='35'>35 Meses</option>
                    <option value='36'>36 Meses</option>
                    <option value='37'>37 Meses</option>
                    <option value='38'>38 Meses</option>
                    <option value='39'>39 Meses</option>
                    <option value='40'>40 Meses</option>
                    <option value='41'>41 Meses</option>
                    <option value='42'>42 Meses</option>
                    <option value='43'>43 Meses</option>
                    <option value='44'>44 Meses</option>
                    <option value='45'>45 Meses</option>
                    <option value='46'>46 Meses</option>
                    <option value='47'>47 Meses</option>
                    <option value='48'>48 Meses</option>
                </select>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
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
        <div class="row">
            <div class='col-md-4'>
                &nbsp;
            </div>                                                             
            <div class='col-md-6'>
                <div class="form-group">
                    <label for="obs">Observação:</label>
                    <textarea  class=" form-control form-control-file" id="obs" name="obs"></textarea>
                </div>
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

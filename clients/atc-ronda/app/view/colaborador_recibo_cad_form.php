<?
require_once "../inc/php/header.php";
?>

<script src="colaborador_recibo_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
@page {
   size: 7in 9.25in;
   margin: 27mm 16mm 27mm 16mm;
}




</style>
<div class="container">
    <div id="div_form">
        <div class="row">
            <div class="col-md-12">
                <h4>Colaboradores Recibos</h4>
            </div>
        </div>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <form id="form" class="form">
            <input type="hidden" id='total_linhas' value="">
            <div class='row'>
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for="colaborador_pk">Tipo de Recibo:&nbsp;</label>
                    <select class="form-control form-control-sm" id="tipos_recibo_pk" >
                        <option></option>
                    </select>
                </div>
            </div>        
            

            <div class="row">
                 <div class="col-md-4">
                     &nbsp;
                 </div>
                 <div class='col-md-4'>
                     <label for="ds_colaborador">Tipo Colaborador:&nbsp;</label>
                     <select class="form-control form-control-sm" id="colaborador_cadastrado">
                         <option></option>
                         <option value="1">Cadastrado</option>
                         <option value="2">Não Cadastrado</option>
                     </select>
                 </div>
             </div> 
          
            <div  id="div_cadastrado" style="display:none">
                <div class="row">
                    <div class="col-md-4">
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for="ds_colaborador">Colaborador Cadastrado:&nbsp;</label>
                        <select class="form-control form-control-sm" id="colaborador_pk">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div> 
            
            <div  id="div_nao_cadastrado" style="display:none">
                <div class="row">
                    <div class="col-md-4">
                        &nbsp;
                    </div>
                    <div class='col-md-4'>
                        <label for="ds_colaborador">Colaborador:&nbsp;</label>
                        <input type="text" id="ds_nome_colaborador"  size="40">
                    </div>
                    <div class="col-md-1">
                        &nbsp;
                    </div>
                    <div class='col-md-2'>
                        <label for="ds_colaborador">CPF:&nbsp;</label>
                         <input type='text' class='form-control form-control-sm' maxlength="14" id='ds_cpf' name='ds_cpf' >
                    </div>
                </div>
            </div>  
            

            <!--Formulario FT-->
            <div  id="div_form_ft" style="display:none">
                <p>
                 <div class="row">
                    <div class="col-md-12">
                        <h4>Recibo de FT</h4>
                    </div>              
                 </div>                 
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Período</h4>
                    </div>              
                 </div>                 
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                <div class="row">   
                    <div class='col-md-3'>
                        <label for="ds_colaborador">Mêses Inicio:&nbsp;</label>
                        <select class="form-control form-control-sm" id="mes_ini_pk" >
                            <option ></option>
                            <option value='01'>Jan</option>
                            <option value='02'>Fev</option>
                            <option value='03'>Mar</option>
                            <option value='04'>Abr</option>
                            <option value='05'>Mai</option>
                            <option value='06'>Jun</option>
                            <option value='07'>Jul</option>
                            <option value='08'>Ago</option>
                            <option value='09'>Set</option>
                            <option value='10'>Out</option>
                            <option value='11'>Nov</option>
                            <option value='12'>Dez</option>
                        </select>
                    </div>
                    <div class='col-md-3'>
                        <label for="ds_colaborador">Ano Inicio:&nbsp;</label>
                        <select class="form-control form-control-sm" id="ano_ini_pk" >
                            <option ></option>
                            <option value='2021'>2021</option>
                            <option value='2022'>2022</option>
                            <option value='2023'>2023</option>
                            <option value='2024'>2024</option>
                            <option value='2025'>2025</option>                       
                        </select>
                    </div>
                    <div class='col-md-3'>
                        <label for="ds_colaborador">Mêses Fim:&nbsp;</label>
                        <select class="form-control form-control-sm" id="mes_fim_pk" >
                            <option ></option>
                            <option value='01'>Jan</option>
                            <option value='02'>Fev</option>
                            <option value='03'>Mar</option>
                            <option value='04'>Abr</option>
                            <option value='05'>Mai</option>
                            <option value='06'>Jun</option>
                            <option value='07'>Jul</option>
                            <option value='08'>Ago</option>
                            <option value='09'>Set</option>
                            <option value='10'>Out</option>
                            <option value='11'>Nov</option>
                            <option value='12'>Dez</option>
                        </select>
                    </div>
                    <div class='col-md-3'>
                        <label for="ds_colaborador">Ano Fim:&nbsp;</label>
                        <select class="form-control form-control-sm" id="ano_fim_pk" >
                            <option ></option>
                            <option value='2021'>2021</option>
                            <option value='2022'>2022</option>
                            <option value='2023'>2023</option>
                            <option value='2024'>2024</option>
                            <option value='2025'>2025</option>                       
                        </select>
                    </div>
                </div>  
                <br>
                <div class="row" align='center'>
                    <div class='col-md-12' >
                        <button type="button" class="btn btn-primary" id="cmdBuscarMeses"  name="cmdBuscarMeses">Buscar</button>
                    </div>                
                </div>
                <p>

                <div class="row">
                    <div class="col-md-12">
                        <h4>Dia(s) Período Mês Inicio / Fim</h4>
                    </div>              
                 </div>                 
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                <div class="row">
                    <div class='col-md-12'>
                        <label for="ds_colaborador">Dia(s) Mês e Ano Inicio:&nbsp;</label>
                        <div id="div_dias_inicio"></div>                    
                    </div>                
                </div>
                <br>
               <div class="row">
                    <div class='col-md-12'>
                        <label for="ds_colaborador">Dia(s) Mês e Ano Fim:&nbsp;</label>
                        <div id="div_dias_fim"></div>                    
                    </div>                
                </div>
                <p>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Preencher Dados Recibo</h4>
                    </div>              
                 </div>                 
                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'> 
                <p>
                <!--<div class="row" align='center'>
                    <div class='col-md-12'>
                        <button type="button" class="btn btn-primary" id="cmdDadosRecibo">Preencher Dados Recibo</button>    

                    </div>                
                </div>-->
                <p>
                <div class="row" >
                    <div class='col-md-12' align='center'>
                       <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado" align='center'>
                            <thead>
                                <tr>
                                    <th>#</th>      
                                    <th>Data</th>                    
                                    <th>Semana</th>                              
                                    <th>Posto<br>Trabalho</th>
                                    <th>Função</th>
                                    <th>HR Entrada</th>
                                    <th>HR Saída</th>    
                                    <th>Horas</th> 
                                    <th>Valor</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody >

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan='7'>&nbsp;</td>
                                    <td align='center'><b>Total</b></td>
                                    <!--<td align='center'><b><div id='div_total_hr'></div><input type='hidden' id='vl_total_hr' value=''></b></td>-->
                                    <td align='center'><b><div id='div_total'></div><input type='hidden' id='vl_total_recibo' value=''></b></td>
                                    <td align='center'>&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>                
                </div>    
            </div>
            <div class="row">
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                 <div class="col-md-12" align="right" >
                    <hr>
                    <button type="button" class="btn btn-primary" id="cmdCancelar">Voltar</button>
                    &nbsp;
                    <button type="button" class="btn btn-primary" id="cmdEnviar">Salvar</button>
                               
                </div>
                <!--<div class="col-md-12" align="right" >
                    <hr>
                    <button type="button" class="btn btn-primary" id="cmdLimparTela">Voltar</button>
                    &nbsp;
                    <button type="button" class="btn btn-primary" id="cmdImprimir">Imprimir</button>
                    <!--<button type="submit" class="btn btn-primary" id="cmdEnviar">Salvar</button>              
                </div>-->
            </div>
        </form>
    </div>
    <div id="div_print" style="display:none" >
        <br>
        <div class='row'>

             <div class='col-md-12' align='center' >
                 <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>
                 &nbsp;
                 <button type="button" class="btn btn-primary" id="cmdImprimirModal"  name="cmdPrint">Imprimir</button>
             </div>
         </div>  
        <div id="areaImpressao" anme="area_impressao" style="width: 21cm; height: 29.7cm">    
            
        </div>    
    </div>    
</div>
<?
require_once "../inc/php/footer.php";
?>

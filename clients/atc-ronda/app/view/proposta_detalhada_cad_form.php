<?
require_once "../inc/php/header.php";
?>
<script src="proposta_detalhada_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

    <title>Gepros CRM</title>
</head>

<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Proposta Detalhada</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>                     
                            <button type="button" class="btn btn-primary btn-sm" id="cmdSalvaProposta">Salvar</button>                     
                        </div>
                    </div>
				</div>
				<div class="card-body">
                    <form method="post">
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <h4>Itens Proposta</h4>
                            </div>
                            &nbsp;&nbsp;&nbsp;
                            <div class='col-md-1' align='rigth'>
                                <b>%</b>
                            </div>
                            &nbsp;&nbsp;
                            <div class='col-md-2' align='rigth'>
                                <b>Totais de Seleções</b>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-10'>
                                <hr style='border: solid 1px black'>
                            </div>
                        </div>
                        
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='leads_pk'><b>Leads:&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <select class='form-control form-control-sm'  id='leads_pk' name='leads_pk'>                            
                                    <option value=""></option>                       
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='ic_tipo_proposta'><b>Tipo de Propostas:&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <select class='form-control form-control-sm'  id='ic_tipo_proposta' name='ic_tipo_proposta'>                            
                                    <option value=""></option>                       
                                    <option value="1">Mão de Obra</option>                          
                                    <option value="2">Mão de Obra e equipamentos</option>                          
                                    <option value="3">Mão de Obra e produtos</option>              
                                    <option value="4">Mão de Obra, equipamentos e Produtos</option>                   
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='produtos_servicos_pk'><b>Serviço a ser Prestado:&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <select class='form-control form-control-sm'  id='produtos_servicos_pk' name='produtos_servicos_pk'>                            
                                    <option value=""></option>                                      
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='ds_qtde_efetivo'><b>Quantidade a Contratar:&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <input class='form-control form-control-sm'  id='ds_qtde_efetivo' name='ds_qtde_efetivo'>   
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='ds_qtde_hr_semanais'><b>Quantidade de Horas Semanais:&nbsp;</b></label> 
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <input class='form-control form-control-sm'  id='ds_qtde_hr_semanais' name='ds_qtde_hr_semanais'>   
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='ic_escala'><b>Frequência Semanal (Escala):&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <select class='form-control form-control-sm'  id='ic_escala' name='ic_escala'>                            
                                    <option value=''></option>
                                    <option value='1D'>1D</option>
                                    <option value='2D'>2D</option>
                                    <option value='3D'>3D</option>
                                    <option value='4D'>4D</option>
                                    <option value='4x1'>4x1</option>
                                    <option value='4x2'>4x2</option>
                                    <option value='5x1'>5x1</option>
                                    <option value='5x2'>5x2</option>
                                    <option value='6X1'>6X1</option>
                                    <option value='12x36'>12x36</option>                                      
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='convencao_coletiva_pk'><b>Convenção Coletiva do Trabalho:&nbsp;</b></label>
                            </div> 
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <select class='form-control form-control-sm'  id='convencao_coletiva_pk' name='convencao_coletiva_pk'>                            
                                    <option value=""></option>                                      
                                    <option value="1">Item 1</option>                                      
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='dt_base_categoria'><b>Data Base da Categoria:&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <input class='form-control form-control-sm'  id='dt_base_categoria' name='dt_base_categoria'>   
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='ds_num_registro_mte'><b>Número do Registro do MTE:&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <input class='form-control form-control-sm'  id='ds_num_registro_mte' name='ds_num_registro_mte'> 
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='vl_salario_piso_categoria'><b>Valor Salário(Piso CAT - normativo de categoria):&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' class='form-control form-control-sm'>
                            </div>
                            &nbsp;&nbsp;&nbsp;<div class='col-md-2' align='rigth'>
                                <input class='form-control form-control-sm'  id='vl_salario_piso_categoria' name='vl_salario_piso_categoria'> 
                            </div>
                        </div>
                        <br>
                        <div id='itens'>

                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-10'>
                                <h4>Totais Valores Mensais</h4>
                                <hr style='border: solid 1px black'>
                            </div>
                        </div>
                        <div id='totais_itens'>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='vl_salario_piso_categoria'><b>Valor Total Proposta:&nbsp;</b></label>
                            </div>
                            %<div class='col-md-1' align='rigth'>
                                <input type='text' id='vl_total_percentual_proposta' name='vl_total_percentual_proposta' class='form-control form-control-sm'>
                            </div>
                            R$<div class='col-md-2' align='rigth'>
                                <input type='text' class='form-control form-control-sm'  id='vl_total_proposta' name='vl_total_proposta'> 
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-3">	
                        <div class="row"> 
                            <div class='col-sm-12' align="right">
                                <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>                     
                                <button type="button" class="btn btn-primary btn-sm" id="cmdSalvaProposta">Salvar</button>                     
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?
require_once "../inc/php/footer.php";
?>

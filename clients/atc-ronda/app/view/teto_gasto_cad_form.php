<?
require_once "../inc/php/header.php";
?>

<script src="teto_gasto_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>

    <!-- Custom fonts for this template-->
    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <?require_once '../inc/php/scripts.php';?>
</head>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Teto de Gastos - Novo</h6>     
                        </div>       
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>                     
                        </div>
                    </div>   
				</div>
				<div class="card-body">
                    <div class="row">
                    </div> 
                    <div class="tab-content">
                        <form id="form_lead" class="form">
                            <input type="hidden" name="pk" id="pk">
                            <div class='row'>
                                <div class='col-md-1'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <label for='tipo_grupo_pk'>Grupo de Origem Lançamento:&nbsp;</label>
                                    <select id="tipo_grupo_pk" class="form-control form-control-sm" name="tipo_grupo_pk">
                                        <option value=""></option>
                                        <option value="1">Clientes</option>
                                        <option value="2">Colaboradores</option>
                                        <option value="3">Fornecedores</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row' id="div_clientes" style="display:none">
                                <div class='col-md-1'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <label for='leads_clientes_pk'>Pago para\ Recebido de:&nbsp;</label>
                                    <select id="leads_clientes_pk" class="form-control form-control-sm" name="leads_clientes_pk">
                                            <option value=""></option>
                                    </select>
                                </div>
                                <div class='col-md-3'>
                                    <label for='leads_posto_trabalho_pk'>Posto de Trabalho:&nbsp;</label>
                                    <select id="leads_posto_trabalho_pk" class="form-control form-control-sm" name="leads_posto_trabalho_pk">
                                            <option value=""></option>
                                    </select>
                                </div>
                                <div class='col-md-3'>
                                    <label for='leads_contratos_pk'>Contrato(s):&nbsp;</label>
                                    <select id="leads_contratos_pk" class="form-control form-control-sm" name="leads_contratos_pk">
                                            <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class='row' id="div_colaborador" style="display:none">
                                <div class='col-md-1'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <label for='colaborador_pk'>Pago para\ Recebido de:&nbsp;</label>
                                    <select id="colaborador_pk" class="form-control form-control-sm" name="colaborador_pk">
                                            <option value=""></option>
                                    </select>
                                </div>
                                <div class='col-md-3'>
                                    <label for='grupo_lancamento_centro_custo_colaborador_pk'>Cliente:&nbsp;</label>
                                    <select class='form-control form-control-sm '  id='grupo_lancamento_centro_custo_colaborador_pk' name='grupo_lancamento_centro_custo_colaborador_pk' requered/>
                                        <option value=""></option>
                                    </select>  
                                </div>
                                <div class='col-md-3'>
                                    <label for='colaborador_posto_trabalho_pk'>Posto de Trabalho:&nbsp;</label>
                                    <select id="colaborador_posto_trabalho_pk" class="form-control form-control-sm" name="colaborador_posto_trabalho_pk">
                                            <option value=""></option>
                                    </select>
                                </div>
                                <div class='col-md-12'>
                                    <div class="row">
                                        <div class='col-md-1'>
                                            &nbsp;
                                        </div>
                                        <div class='col-md-3'>
                                            <label for='colaborador_contratos_pk'>Contrato(s):&nbsp;</label>
                                            <select id="colaborador_contratos_pk" class="form-control form-control-sm" name="colaborador_contratos_pk">
                                                    <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row' id="div_fornecedor" style="display:none">
                                <div class='col-md-1'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <label for='fornecedor_pk'>Pago para / Recebido de:&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='fornecedor_pk' name='fornecedor_pk' requered/>
                                        <option value=""></option>
                                    </select>  
                                </div>    
                                <div class='col-md-3'>
                                    <label for='grupo_lancamento_centro_custo_fornecedor_pk'>Cliente:&nbsp;</label>
                                    <select class='form-control form-control-sm '  id='grupo_lancamento_centro_custo_fornecedor_pk' name='grupo_lancamento_centro_custo_fornecedor_pk' requered/>
                                        <option value=""></option>
                                    </select>  
                                </div>     
                                <div class='col-md-3'>
                                    <label for='fornecedor_posto_trabalho_pk'>Posto de Trabalho:&nbsp;</label>
                                    <select class='form-control form-control-sm'  id='fornecedor_posto_trabalho_pk' name='fornecedor_posto_trabalho_pk' requered/>
                                        <option value=""></option>
                                    </select>  
                                </div>  
                                <div class='col-md-12'>
                                    <div class="row">
                                        <div class='col-md-1'>
                                            &nbsp;
                                        </div>
                                        <div class='col-md-3'>
                                            <label for='fornecedor_contratos_pk'>Contrato(s):&nbsp;</label>
                                            <select class='form-control form-control-sm'  id='fornecedor_contratos_pk' name='fornecedor_contratos_pk' requered/>
                                                <option value=""></option>
                                            </select>  
                                        </div>  
                                    </div>  
                                </div>  
                            </div> 
                            <div class='row'>
                                <div class='col-md-1'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <label for='ds_ano_vigente_teto'>Ano de vigencia Teto:&nbsp;</label>
                                    <select id="ds_ano_vigente_teto" class="form-control form-control-sm" name="ds_ano_vigente_teto">
                                            <option value=""></option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                    </select>
                                </div>
                                <div class='col-md-3'>
                                    <label for='vl_total_teto'>Vl Total Teto:&nbsp;</label>
                                    <input id="vl_total_teto" class="form-control form-control-sm" name="vl_total_teto">
                                </div>
                                <div class='col-md-3'>
                                    <label for='vl_utilizado_atual'>Vl Teto Utilizado Atual:&nbsp;</label>
                                    <input id="vl_utilizado_atual" class="form-control form-control-sm" readonly name="vl_utilizado_atual">
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-1'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <label for='ic_status'>Status:&nbsp;</label>
                                    <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                                        <option value=""></option>
                                        <option value="1">Ativo</option>
                                        <option value="2">Inativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-1'>
                                    &nbsp;
                                </div>
                                <div class='col-md-3'>
                                    <label for='obs'>Observação:&nbsp;</label>
                                    <textarea id="obs" class="form-control form-control-sm" name="obs">
                                    </textarea>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-1'>
                                    &nbsp;
                                </div>
                                <div class='col-md-11'>
                                    <hr>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-5'>
                                    &nbsp;
                                </div>
                                <div class='col-md-5'>
                                    <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarTetoGastos">Salvar</button>     
                                </div>
                            </div>
                            <br><br>
                            <div id='informacoesItens' style="display:none">
                                <div class='row'>
                                    <div class='col-md-1'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-11'>
                                        <h6><b>Itens Teto de Gastos</b></h6>
                                        <hr>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-1'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='tipos_operacao_pk'>Tipo de Lançamento:&nbsp;</label>
                                        <select id="tipos_operacao_pk" class="form-control form-control-sm" name="tipos_operacao_pk">
                                                <option value=""></option>
                                                <option value="7">Custo Fixo</option>
                                                <option value="8">Custo Variável</option>
                                                <option value="2">Despesa Fixa</option>
                                                <option value="3">Despesa Variável</option>
                                                <option value="4">Imposto</option>
                                                <option value="5">Transferência</option>
                                                <option value="6">Caixinha</option>
                                        </select>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='categoria_operacao_pk'>Categoria(s):&nbsp;</label>
                                        <select id="categoria_operacao_pk" class="form-control form-control-sm" name="categoria_operacao_pk">
                                                <option value=""></option>
                                        </select>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='operacao_pk'>Planos de Conta:&nbsp;</label>
                                        <select id="operacao_pk" class="form-control form-control-sm" name="operacao_pk">
                                                <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-1'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='dt_ini_teto'>Dt Ini Validade Teto:&nbsp;</label>
                                        <input id="dt_ini_teto" class="form-control form-control-sm" name="dt_ini_teto">
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='dt_fim_teto'>Dt fim Validade Teto:&nbsp;</label>
                                        <input id="dt_fim_teto" class="form-control form-control-sm" name="dt_fim_teto">
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-1'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='vl_teto_anual'>Vl Teto Anual:&nbsp;</label>
                                        <input id="vl_teto_anual" class="form-control form-control-sm" name="vl_teto_anual">
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='vl_teto_mensal'>Vl Teto Mensal:&nbsp;</label>
                                        <input id="vl_teto_mensal" class="form-control form-control-sm" name="vl_teto_mensal">
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-1'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='obs_teto_itens'>Observação:&nbsp;</label>
                                        <textarea id="obs_teto_itens" class="form-control form-control-sm" name="obs_teto_itens">
                                        </textarea>
                                    </div>
                                </div>
                                <br>
                                <div class='row'>
                                    <div class="col-md-12" align="center">
                                        <button type="button" class="btn btn-primary btn-sm" id="cmdIncluirItem">Incluir Item</button>              
                                    </div>
                                </div>
                                <br>
                                <div class='row'>
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultadoItens">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tipo Lançamento</th>                                       
                                                    <th>Categoria</th>
                                                    <th>Planos de Contas</th>                                 
                                                    <th>Dt Ini Teto</th>
                                                    <th>Dt Fim Teto</th>
                                                    <th>Vl Teto Anual</th>                                                                          
                                                    <th>Vl Teto Mensal</th>          
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>                      
                    </div>   
                    <div class="row">
                        <div class="col-md-12" align="Right">
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            <br>
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Voltar</button>
                            &nbsp;   
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<?
require_once "../inc/php/footer.php";
?>

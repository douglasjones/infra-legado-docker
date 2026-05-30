<?
require_once "../inc/php/header.php";
?>
<script src="inc_receita_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>
.tableFixHead          { overflow: auto; height:540px; }
.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
.menu_fixo { background:#ffffff; }

/* Just common table stuff. Really. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
</style>
<br>  
<div id="exibir_grid_receita_dia">
    <div class="row" > 
        <div class="col-md-12" style="background-color: #ffffff; ">
            <p>
            <div class="row">
                <div class="col-md-12">
                    <h4>Lançamento(s) Receita(s) Dia - <span class="DataAtual"></span></h4>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Código:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' id="pk_dia" name="pk_dia"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Cadastro  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_ini_dia" name="dt_cadastro_ini_dia"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Cadastro Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_fim_dia" name="dt_cadastro_fim_dia"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Faturamento  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_ini_dia" name="dt_faturamento_ini_dia"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Faturamento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_fim_dia" name="dt_faturamento_fim_dia"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Vencimento  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_ini_dia" name="dt_vencimento_ini_dia"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Vencimento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_fim_dia" name="dt_vencimento_fim_dia"/> 
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Empresa para o lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='empresa_pk_dia' name='empresa_pk_dia'/>
                        <option value=""></option>
                    </select>  
                </div> 
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipo_grupo_pk'>Grupo Origem Lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_pk_dia' name='tipo_grupo_pk_dia'/>
                        <option value=""></option>
                        <option value="1">Leads (Clientes)</option>
                        <option value="2">Colaboradores</option>
                        <option value="3">Fornecedores</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' class='recebido_de_pago_para'>&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='grupo_leancamento_pk_dia' name='grupo_leancamento_pk_dia'/>
                        <option value=""></option>
                    </select>  
                </div>
            </div>

            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Status:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='ic_status_dia' name='ic_status_dia' />
                        <option value=""></option>
                        <option value="1">Pago</option>
                        <option value="2">Pendente</option>
                        <option value="3">Aprovado</option>
                        <option value="4">Atrasado</option>
                        <option value="5">Cancelado</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Usuário Cadastro:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='usuario_cadastro_pk_dia' name='usuario_cadastro_pk_dia' />
                        <option value=""></option>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-4" align="center">
                    <button type="button" class="btn btn-link" id="cmdPesquisarDia"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>

                </div>
            </div>
            <div id="gridVencimentoDia"></div>
        </div>
        <div class='col-sm-1'>
            &nbsp;
        </div>
    </div>
</div>
<div id="exibir_grid_despesa_dia">
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <br>
    <div class="row" > 
        <div class="col-md-12" style="background-color: #ffffff; ">
            <p>
            <div class="row">
                <div class="col-md-12">
                    <h4>Lançamento(s) Despesa(s) Dia - <span class="DataAtual"></span></h4>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Código:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' id="pk_despesa_dia" name="pk_despesa_dia"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Cadastro Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm'   maxlength="10" id="dt_cadastro_ini_despesa_dia" name="dt_cadastro_ini_despesa_dia"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Cadastro Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_fim_despesa_dia" name="dt_cadastro_fim_despesa_dia"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Faturamento  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_ini_despesa_dia" name="dt_faturamento_ini_despesa_dia"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Faturamento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_fim_despesa_dia" name="dt_faturamento_fim_despesa_dia"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Vencimento  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_ini_despesa_dia" name="dt_vencimento_ini_despesa_dia"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Vencimento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_fim_despesa_dia" name="dt_vencimento_fim_despesa_dia"/> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Empresa para o lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='empresa_pk_despesa_dia' name='empresa_pk_despesa_dia'/>
                        <option value=""></option>
                    </select>  
                </div> 
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipo_grupo_pk'>Grupo Origem Lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_pk_despesa_dia' name='tipo_grupo_pk_despesa_dia'/>
                        <option value=""></option>
                        <option value="1">Leads (Clientes)</option>
                        <option value="2">Colaboradores</option>
                        <option value="3">Fornecedores</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' class='recebido_de_pago_para'>&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='grupo_leancamento_pk_despesa_dia' name='grupo_leancamento_pk_despesa_dia'/>
                        <option value=""></option>
                    </select>  
                </div>
            </div>

            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Status:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='ic_status_despesa_dia' name='ic_status_despesa_dia' />
                        <option value=""></option>
                        <option value="1">Pago</option>
                        <option value="2">Pendente</option>
                        <option value="3">Aprovado</option>
                        <option value="4">Atrasado</option>
                        <option value="5">Cancelado</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Usuário Cadastro:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='usuario_cadastro_pk_despesa_dia' name='usuario_cadastro_pk_despesa_dia' />
                        <option value=""></option>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-4" align="center">
                    <button type="button" class="btn btn-link" id="cmdPesquisarDespesaDia"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>

                </div>
            </div>
            <div id="gridVencimentoDespesaDia"></div>
        </div>
        <div class='col-sm-1'>
            &nbsp;
        </div>
    </div>
</div>
<div id="exibir_grid_receita_atrasado">
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <br>
    <div class="row" > 
        <div class="col-md-12" style="background-color: #ffffff; ">
            <p>
            <div class="row">
                <div class="col-md-12">
                    <h4>Lançamento(s) Receita(s) Atrasados - <span class="DataAtual"></span></h4>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Código:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' id="pk_atrasado" name="pk_atrasado"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Cadastro Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_ini_atrasado" name="dt_cadastro_ini_atrasado"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Cadastro Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_fim_atrasado" name="dt_cadastro_fim_atrasado"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Faturamento Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_ini_atrasado" name="dt_faturamento_ini_atrasado"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Faturamento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_fim_atrasado" name="dt_faturamento_fim_atrasado"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Vencimento  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_ini_atrasado" name="dt_vencimento_ini_atrasado"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Vencimento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_fim_atrasado" name="dt_vencimento_fim_atrasado"/> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Empresa para o lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='empresa_pk_atrasado' name='empresa_pk_atrasado'/>
                        <option value=""></option>
                    </select>  
                </div> 
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipo_grupo_pk'>Grupo Origem Lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_pk_atrasado' name='tipo_grupo_pk_atrasado'/>
                        <option value=""></option>
                        <option value="1">Leads (Clientes)</option>
                        <option value="2">Colaboradores</option>
                        <option value="3">Fornecedores</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' class='recebido_de_pago_para'>&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='grupo_leancamento_pk_atrasado' name='grupo_leancamento_pk_atrasado'/>
                        <option value=""></option>
                    </select>  
                </div>
            </div>

            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Status:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='ic_status_atrasado' name='ic_status_atrasado' />
                        <option value=""></option>
                        <option value="1">Pago</option>
                        <option value="2">Pendente</option>
                        <option value="3">Aprovado</option>
                        <option value="4">Atrasado</option>
                        <option value="5">Cancelado</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Usuário Cadastro:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='usuario_cadastro_pk_atrasado' name='usuario_cadastro_pk_atrasado' />
                        <option value=""></option>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-4" align="center">
                    <button type="button" class="btn btn-link" id="cmdPesquisarAtrasado"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>

                </div>
            </div>
            <div id="gridAtrasado"></div>

        </div>  
        <div class='col-sm-1'>
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
</div>
<div id="exibir_grid_despesa_atrasado">
    <br>
    <div class="row" > 
        <div class="col-md-12" style="background-color: #ffffff; ">
            <p>
            <div class="row">
                <div class="col-md-12">
                    <h4>Lançamento(s) Despesa(s) Atrasados - <span class="DataAtual"></span></h4>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Código:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' id="pk_despesa_atrasado" name="pk_despesa_atrasado"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Cadastro Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_ini_despesa_atrasado" name="dt_cadastro_ini_despesa_atrasado"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Cadastro Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_fim_despesa_atrasado" name="dt_cadastro_fim_despesa_atrasado"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Faturamento Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_ini_despesa_atrasado" name="dt_faturamento_ini_despesa_atrasado"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Faturamento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_fim_despesa_atrasado" name="dt_faturamento_fim_despesa_atrasado"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Vencimento  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_ini_despesa_atrasado" name="dt_vencimento_ini_despesa_atrasado"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Vencimento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_fim_despesa_atrasado" name="dt_vencimento_fim_despesa_atrasado"/> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Empresa para o lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='empresa_pk_despesa_atrasado' name='empresa_pk_despesa_atrasado'/>
                        <option value=""></option>
                    </select>  
                </div> 
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipo_grupo_pk'>Grupo Origem Lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_pk_despesa_atrasado' name='tipo_grupo_pk_despesa_atrasado'/>
                        <option value=""></option>
                        <option value="1">Leads (Clientes)</option>
                        <option value="2">Colaboradores</option>
                        <option value="3">Fornecedores</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' class='recebido_de_pago_para'>&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='grupo_leancamento_pk_despesa_atrasado' name='grupo_leancamento_pk_atrasado'/>
                        <option value=""></option>
                    </select>  
                </div>
            </div>

            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Status:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='ic_status_despesa_atrasado' name='ic_status_atrasado' />
                        <option value=""></option>
                        <option value="1">Pago</option>
                        <option value="2">Pendente</option>
                        <option value="3">Aprovado</option>
                        <option value="4">Atrasado</option>
                        <option value="5">Cancelado</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Usuário Cadastro:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='usuario_cadastro_pk_despesa_atrasado' name='usuario_cadastro_pk_atrasado' />
                        <option value=""></option>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-4" align="center">
                    <button type="button" class="btn btn-link" id="cmdPesquisarDespesaAtrasado"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>

                </div>
            </div>
            <div id="gridDespesaAtrasado"></div>

        </div>  
        <div class='col-sm-1'>
            &nbsp;
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <br>
</div>
<div id="exibir_grid_lancamento_mes">
    <div class="row" > 
        <div class="col-md-12" style="background-color: #ffffff; ">
            <p>
            <div class="row">
                <div class="col-md-12">
                    <h4>Lançamento(s)do Mês</h4>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Código:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' id="pk_mes" name="pk_mes"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Cadastro Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_ini_mes" name="dt_cadastro_ini_mes"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Cadastro Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_fim_mes" name="dt_cadastro_fim_mes"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Faturamento Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_ini_mes" name="dt_faturamento_ini_mes"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Faturamento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_fim_mes" name="dt_faturamento_fim_mes"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Vencimento  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_ini_mes" name="dt_vencimento_ini_mes"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Vencimento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_fim_mes" name="dt_vencimento_fim_mes"/> 
                </div>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento'>Data Pagamento  Inicío:&nbsp;</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_pagamento_ini_mes" name="dt_pagamento_ini_mes"/> 
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' >Data Pagamento Fim</label>
                    <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_pagamento_fim_mes" name="dt_pagamento_fim_mes"/> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Tipo Lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='tipo_lancamento_pk_mes' name='tipo_lancamento_pk_mes' />
                        <option value=""></option>
                        <option value="1">Receita</option>
                        <option value="2">Despesa Fixa</option>
                        <option value="3">Despesa Variável</option>
                        <option value="4">Imposto</option>
                        <option value="5">Transferência</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Empresa para o lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='empresa_pk_mes' name='empresa_pk_mes'/>
                        <option value=""></option>
                    </select>  
                </div> 
            </div>
            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipo_grupo_pk'>Grupo Origem Lançamento:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_pk_mes' name='tipo_grupo_pk_mes'/>
                        <option value=""></option>
                        <option value="1">Leads (Clientes)</option>
                        <option value="2">Colaboradores</option>
                        <option value="3">Fornecedores</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='vl_lancamento' class='recebido_de_pago_para'>&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='grupo_leancamento_pk_mes' name='grupo_leancamento_pk_mes'/>
                        <option value=""></option>
                    </select>  
                </div>
            </div>

            <div class='row'>
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Status:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='ic_status_mes' name='ic_status_mes' />
                        <option value=""></option>
                        <option value="1">Pago</option>
                        <option value="2">Pendente</option>
                        <option value="3">Aprovado</option>
                        <option value="4">Atrasado</option>
                        <option value="5">Cancelado</option>
                    </select>  
                </div>
                <div class='col-md-2'>
                    <label for='tipos_operacao_pk'>Usuário Cadastro:&nbsp;</label>
                    <select class='form-control form-control-sm chzn-select'  id='usuario_cadastro_pk_mes' name='usuario_cadastro_pk_mes' />
                        <option value=""></option>
                    </select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    &nbsp;
                </div>
                <div class="col-md-4" align="center">
                    <button type="button" class="btn btn-link" id="cmdPesquisarMes"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>

                </div>
            </div>
            <div id="gridLancamentosMes"></div>

        </div>  
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
    </div>
</div>
    
<?
require_once "../inc/php/footer.php";
?>

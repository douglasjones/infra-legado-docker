<script src="financeiro_despesa_grid_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="row">
    <div class="col-md-12">
        <h4>Consulta de Despesa(s)</h4>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
    </div>
</div> 
<p>
<div class='row'>
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento'>Código:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' id="pk_lancamento_despesa" name="pk_lancamento_despesa"/> 
    </div>
    <div class='col-md-2'>
        <label for='tipos_operacao_pk'>Status:&nbsp;</label>
        <select class='form-control form-control-sm'  id='ic_status_pagamento_despesa' name='ic_status_pagamento_despesa' />
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
        <select class='form-control form-control-sm'  id='usuario_cadastro_despesa_pk' name='usuario_cadastro_despesa_pk' />
            <option value=""></option>
        </select>  
    </div>
</div>
<div class='row'> 
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='ds_num_documento_despesa'>Identificação do Documento:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' id="ds_num_documento_despesa" name="ds_num_documento_despesa"/> 
    </div>
    <div class='col-md-2'>
        <label for='ic_tipo_num_documento_despesa'>Identificação do Documento:&nbsp;</label> 
        <select class='form-control form-control-sm'  id='ic_tipo_num_documento_despesa' name='ic_tipo_num_documento_despesa'>
            <option value=""></option>                               
            <option value="1">Num Boleto</option>
            <option value="2">Num NF</option>
        </select>
    </div>
</div>
<div class="row"  >
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='tipos_operacao_pk'>Empresa:&nbsp;</label>
        <select class='form-control form-control-sm'  id='empresa_despesa_pk' name='empresa_despesa_pk'/>
            <option value=""></option>
        </select>  
    </div>
    <div class='col-md-2'>
        <label for='bancos_pk'>Conta(s):&nbsp;</label>
        <select class='form-control form-control-sm'  id='contas_despesa_pk' name='contas_despesa_pk' />
            <option></option>
        </select>  
    </div>
    <div class='col-md-2'>
        <label for='bancos_pk'>Status Analise(s):&nbsp;</label>
        <select class='form-control form-control-sm'  id='ic_status_analise' name='ic_status_analise' />
            <option></option>
            <option value="1">Aprovado</option>
        </select>  
    </div>
</div>    


<div class="row">
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='tipo_grupo_pk'>Grupo de Origem Lançamento:&nbsp;</label>
        <select class='form-control form-control-sm'  id='tipo_grupo_despesa_pk' name='tipo_grupo_despesa_pk'/>
            <option value=""></option>
            <option value="1">Leads (Clientes)</option>
            <option value="2">Colaboradores</option>
            <option value="3">Fornecedores</option>
        </select>  
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' class='recebido_de_pago_para'>Recebido de ? </label>
        <select class='form-control form-control-sm'  id='grupo_leancamento_despesa_pk' name='grupo_leancamento_despesa_pk'/>
            <option value=""></option>
        </select>  
    </div>            
</div>  
<div class='row'>
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento'>Data Cadastro  Inicío:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_ini_despesa" name="dt_cadastro_ini_despesa"/> 
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' >Data Cadastro Fim</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_fim_despesa" name="dt_cadastro_fim_despesa"/> 
    </div>            
</div>
<div class='row'>
     <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento'>Data Faturamento  Inicío:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_ini_despesa" name="dt_faturamento_ini_despesa"/> 
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' >Data Faturamento Fim</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_fim_despesa" name="dt_faturamento_fim_despesa"/> 
    </div>
</div>
<div class='row'>
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento'>Data Vencimento  Inicío:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_ini_despesa" name="dt_vencimento_ini_despesa"/> 
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' >Data Vencimento Fim</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_fim_despesa" name="dt_vencimento_fim_despesa"/> 
    </div>
</div>
<div class='row'>
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento'>Data Pagamento  Inicío:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_pagamento_ini_despesa" name="dt_pagamento_ini_despesa"/> 
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' >Data Pagamento Fim</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_pagamento_fim_despesa" name="dt_pagamento_fim_despesa"/> 
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-4">
        &nbsp;
    </div>
    <div class="col-md-4" align="center">                
        <button type='button' class="btn btn-primary" id='cmdPesqDespesa'>Pesquisar</button>    
    </div>
</div> 
<div class="row">
    <div class="col-md-12">        
        <hr>
    </div>
</div>
<div id="grid_despesa"></div>
<div class="row">
    <div class="col-md-12">        
       &nbsp;
    </div>
</div>
<hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>


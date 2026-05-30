<script src="financeiro_receita_grid_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<div class="row">
    <div class="col-md-12">
        <h4>Consulta de Receira(s)</h4>
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
        <input type="text" class='form-control form-control-sm' id="pk_lancamento_receita" name="pk_lancamento_receita"/> 
    </div>
    <div class='col-md-2'>
        <label for='tipos_operacao_pk'>Status:&nbsp;</label>
        <select class='form-control form-control-sm'  id='ic_status_pagamento_receita' name='ic_status_pagamento_receita' />
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
        <select class='form-control form-control-sm'  id='usuario_cadastro_receita_pk' name='usuario_cadastro_receita_pk' />
            <option value=""></option>
        </select>  
    </div>
</div>
<div class='row'> 
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='ds_num_documento_receita'>Identificação do Documento:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' maxlength="80" id="ds_num_documento_receita" name="ds_num_documento_receita"/> 
    </div>
    <div class='col-md-2'>
        <label for='ic_tipo_num_documento_receita'>Identificação do Documento:&nbsp;</label> 
        <select class='form-control form-control-sm'  id='ic_tipo_num_documento_receita' name='ic_tipo_num_documento_receita'>
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
        <select class='form-control form-control-sm'  id='empresa_receita_pk' name='empresa_receita_pk'/>
            <option value=""></option>
        </select>  
    </div>
    <div class='col-md-2'>
        <label for='bancos_pk'>Conta(s):&nbsp;</label>
        <select class='form-control form-control-sm'  id='contas_receita_pk' name='contas_receita_pk' />
            <option></option>
        </select>  
    </div>
</div>    


<div class="row">
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='tipo_grupo_pk'>Grupo de Origem Lançamento:&nbsp;</label>
        <select class='form-control form-control-sm'  id='tipo_grupo_receita_pk' name='tipo_grupo_receita_pk'/>
            <option value=""></option>
            <option value="1">Leads (Clientes)</option>
            <option value="2">Colaboradores</option>
            <option value="3">Fornecedores</option>
        </select>  
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' class='recebido_de_pago_para'>Recebido de ? </label>
        <select class='form-control form-control-sm'  id='grupo_leancamento_receita_pk' name='grupo_leancamento_receita_pk'/>
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
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_ini_receita" name="dt_cadastro_ini_receita"/> 
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' >Data Cadastro Fim</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_cadastro_fim_receita" name="dt_cadastro_fim_receita"/> 
    </div>            
</div>
<div class='row'>
     <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento'>Data Faturamento  Inicío:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_ini_receita" name="dt_faturamento_ini_receita"/> 
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' >Data Faturamento Fim</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_faturamento_fim_receita" name="dt_faturamento_fim_receita"/> 
    </div>
</div>
<div class='row'>
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento'>Data Vencimento  Inicío:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_ini_receita" name="dt_vencimento_ini_receita"/> 
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' >Data Vencimento Fim</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_vencimento_fim_receita" name="dt_vencimento_fim_receita"/> 
    </div>
</div>
<div class='row'>
    <div class="col-md-3">
        &nbsp;
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento'>Data Pagamento  Inicío:&nbsp;</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_pagamento_ini_receita" name="dt_pagamento_ini_receita"/> 
    </div>
    <div class='col-md-2'>
        <label for='vl_lancamento' >Data Pagamento Fim</label>
        <input type="text" class='form-control form-control-sm' maxlength="10" id="dt_pagamento_fim_receita" name="dt_pagamento_fim_receita"/> 
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-4">
        &nbsp;
    </div>
    <div class="col-md-4" align="center">                
        <button type='button' class="btn btn-primary" id='cmdPesqReceita'>Pesquisar</button>    
    </div>
</div> 
<div class="row">
    <div class="col-md-12">        
        <hr>
    </div>
</div>
<div id="grid_receita"></div>
<div class="row">
    <div class="col-md-12">        
       &nbsp;
    </div>
</div>
<hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>


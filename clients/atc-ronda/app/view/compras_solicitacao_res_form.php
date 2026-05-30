<?
require_once "../inc/php/header.php";
$token = $_REQUEST['token'];
$arrToken = tratarToken($token);
$usuarios_pk = $arrToken['usuarios_pk'];
?>
<script src="compras_solicitacao_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<style>
@import "bourbon";
      .label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input[type=text]{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 300px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  
  border-radius:0;
}

.label-float input[type=text]:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input[type=text]:placeholder{
  color:transparent;
}

.label-float label{
  pointer-events: none;
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 13px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
}

.label-float input[type=text]:required:invalid + label{
  color: red;
}
.label-float input[type=text]:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input[type=text]:focus + label,
.label-float input[type=text]:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
.oc_modal{
    cursor:pointer;
}
.doc_modal{
    cursor:pointer;
}
.processo_modal{
    cursor:pointer;
}

</style>

<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Solicitação de Compras </h6>     
                        </div> 
                    </div>
                </div>
				<div class="card-body">
                    <form method="post">
                        <input type="hidden" id="usuario_logado_pk" name="usuario_logado_pk" value="<?=$usuarios_pk;?>">
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='tipos_operacao_pk'>Empresa:&nbsp;</label>
                                <select class='form-control form-control-sm chzn-select'  id='empresa_pk' name='empresa_pk' />
                                    <option value=""></option>
                                </select> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='solicitante_pk'>Solicitante:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select"  id='solicitante_pk' name='solicitante_pk' />
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='solicitante_pk'>Aprovadores:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select"  id='usuario_aprovacao_pk' name=usuario_aprovacao_pk' />
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='tipo_grupo_centro_custo_pk'> Grupo de Centro de Custos:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='tipo_grupo_centro_custo_pk' name='tipo_grupo_centro_custo_pk' />
                                    <option value=""></option>
                                    <option value="1">Leads (Clientes)</option>
                                    <option value="2">Colaboradores</option>
                                    <!--<option value="3">Fornecedores</option>-->
                                    <option value="4">Centro de Custo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='grupo_lancamento_centrocusto_pk'>Centro de Custo:&nbsp;</label>
                                <select class='form-control form-control-sm chzn-select'  id='grupo_lancamento_centrocusto_pk' name='grupo_lancamento_centrocusto_pk' />
                                    <option></option>
                                </select>
                            </div>
                        </div>        
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="ic_status">Status da Solicitação:&nbsp;</label>
                                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                                    <option value=""></option>
                                    <option value="1">Aguardando Análise</option>
                                    <option value="2">Aprovada</option>
                                    <option value="2">Reprovada</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <label for="dt_periodo_ini">Dt Solicitação Ini:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_solicitacao_ini' name='dt_solicitacao_ini' value="">                
                            </div>
                            <div class="col-md-2">
                                <label for="dt_periodo_fim">Dt Solicitação Fim:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_solicitacao_fim' name='dt_solicitacao_fim' value="">         
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <label for="dt_periodo_ini">Dt Aprovação Ini:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_aprovacao_ini' name='dt_aprovacao_ini' value="">                
                            </div>
                            <div class="col-md-2">
                                <label for="dt_periodo_fim">Dt aprovação Fim:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_aprovacao_fim' name='dt_aprovacao_fim' value="">         
                            </div>
                        </div>        
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4" align="center">
                                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
                                &nbsp;
                                <button type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Incluir</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                            <thead>
                                <tr>
                                    <th>Cód</th>
                                    <th>Empresa</th>                    
                                    <th>Solicitante</th>
                                    <th>solicitante_pk</th>
                                    <th>Aprovador</th>    
                                    <th>aprovador_pk</th>    
                                    <th>Dt da Solicit</th>
                                    <th>Status Aprovação</th>
                                    <th>Titulo da Compra</th>
                                    <th>Dt Aprovação</th>
                                    <th>Grupo de Centro de Custos</th>
                                    <th>Centro de Custo</th> 
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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

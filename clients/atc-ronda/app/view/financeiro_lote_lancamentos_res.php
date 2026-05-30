<?
include_once "../inc/php/header.php";
?>
<script src="financeiro_lote_lancamentos_res.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Importação de Lançamentos</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdImportar">Novo</button>                       
                        </div>
                    </div>
				</div>
				<div class="card-body">
                    <form method="post">
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='usuario_cadastro_pk'>Usuário Cadastro:&nbsp;</label>
                                <select class='form-control form-control-sm' id='usuario_cadastro_pk' name='usuario_cadastro_pk'>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-2' align="left">
                                <label for='dt_cadastro'>Data da Cadastro:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="dt_cadastro">
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='ic_status'>Status:&nbsp;</label>
                                <select class='form-control form-control-sm' id='ic_status' name='ic_status'>
                                    <option></option>
                                    <option value="1">Dados Processados</option>
                                    <option value="2">Dados não Processados</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4" align="center">
                                <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisar">Pesquisar</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Identificação Lote</th>
                                    <th>Usuário de Cadastro</th>
                                    <th>Data Cadastro</th>
                                    <th>Status</th>
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
include_once "../inc/php/footer.php";
?>

<?
include_once "../inc/php/header.php";
?>
<script src="financeiro_import_lote_lancamento_cad.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                        </div>
                    </div>
				</div>
				<div class="card-body" align="center">
                    <button type="button" class="btn btn-primary btn-sm" id="cmdLote">Cadastrar em Lote</button>   
                    <button type="button" class="btn btn-primary btn-sm" id="cmdImport">Importar Planilha</button>   
                </div>
            </div>
        </div>
    </div>
</div>
<?
include "../inc/php/header.php";
$token = $_REQUEST['token'];
?>
<script>
    
    
function fcCancelar(){
    sendPost("menu_relatorios.php", {token: token});
}
</script>
<title>Gepros CRM</title>
<div>
    &nbsp;
</div>
<div class="container">
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Ocorrência(s)</h6>
				</div>
				<div class="card-body py-3">
                    <div class="col-sm"> 
                        <div class="row">
                            <div class="col-sm">
                                <div class="text-left">
                                    <div class=' col-sm text-left'>
                                        <a href="javascript: abrirMenu('rel_ocorrencia_res_form.php');">
                                            <img src="../img/relatorio-de-negocios.png" width="40">&nbsp;Relatório de Ocorrências
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <div class="text-left">
                                    <div class=' col-sm text-left'>
                                        <a href="javascript: abrirMenu('rel_ocorrencia_tempo_res_form.php');">
                                            <img src="../img/relatorio-de-negocios.png" width="40">&nbsp;Ocorrências Tempo
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <div class="text-left">
                                    <div class=' col-sm text-left'>
                                        <a href="javascript: abrirMenu('rel_sla_ocorrencia_res_form.php');">
                                            <img src="../img/relatorio-de-negocios.png" width="40">&nbsp;SLA Ocorrência(s)
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="text-align: end;">
       <button type="button" class="btn btn-secondary" onclick='fcCancelar()' id="cmdCancelar">Voltar</button>
    </div>       
</div>
    
<?
include "../inc/php/footer.php";
?>

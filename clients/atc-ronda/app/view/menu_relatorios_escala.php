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
					<h6 class="m-0 font-weight-bold text-primary">Escala(s)</h6>
				</div>
				<div class="card-body py-3">
                    <div class="col-sm"> 
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_escala_servico_dia_res_form.php');">
                                    <img src="../img/relatorio-de-negocios.png" width="40">&nbsp;Escala de Serviço por Dia
                                </a>
                            </div>
                        </div> 
                        <br>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_posto_trabalho_x_colaborador_res_form.php');">
                                    <img src="../img/relatorio-de-negocios.png" width="40">&nbsp;Posto Trabalho x Colaborador
                                </a>
                            </div>
                        </div> 
                        <br>
                        <div class="text-left">
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_colaborador_sem_escala_res_form.php');">
                                    <img src="../img/relatorio-de-negocios.png" width="40">&nbsp;Colaboradores Sem Escala
                                </a>
                            </div>
                        </div> 
                    </div>
                    <div class="col-sm"> 
                        &nbsp;
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

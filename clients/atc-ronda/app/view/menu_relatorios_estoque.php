<?
session_start();
$_SESSION['link'] = "menu_relatorios.php";
include "../inc/php/header.php";
$token = $_REQUEST['token'];
?>
<script>  
    
    function fcCancelar(){
        sendPost("menu_relatorios.php", {token: token});
    }
    </script>
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

    <!-- Custom styles for this template-->
    <!--<link href="../inc/css/themas/sb-admin-2.min.css" rel="stylesheet">--->
	
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
                            <h6 class="m-0 font-weight-bold text-primary">Estoque</h6>
                        </div> 
                        <div class='col-sm-6' align="Right" >
                            <button type="button" class="btn btn-secondary btn-sm" onclick='fcCancelar()'  id="cmdVoltarLead">Voltar</button>                            
                        </div>                        
                    </div>
                </div>    
				<div class="card-body">
					<div class="row"> 
						<div class="col-sm"> 
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_estoque_res_form.php');">
                                    <i class="bi bi-clipboard2-data" style="font-size:30px; color:black"></i>
                                    <label  style="font-size: 15px">Estoque Sintético</label>
                                </a>
                            </div>
                            <br>
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_estoque_atual_res_form.php');">
                                    <i class="bi bi-clipboard2-data" style="font-size:30px; color:black"></i>
                                    <label  style="font-size: 15px">Posição Estoque Análitico por Data</label>
                                </a>
                            </div>  
                            <br>
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_estoque_minimo_res_form.php');">
                                    <i class="bi bi-clipboard2-data" style="font-size:30px; color:black"></i>
                                    <label  style="font-size: 15px">Acompanhamento de Estoque Mínimo</label>
                                </a>
                            </div>
							         
						</div> 
						<div class="col-sm"> 
    
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_estoque_movimentado_troca_res_form.php');">
                                    <i class="bi bi-clipboard2-data" style="font-size:30px; color:black"></i>
                                    <label  style="font-size: 15px">Acompanhamento Movimentação Estoque</label>
                                </a>
                            </div>
                            <br>
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_estoque_carga_res_form.php');">
                                    <i class="bi bi-clipboard2-data" style="font-size:30px; color:black"></i>
                                    <label  style="font-size: 15px">Acompanhamento Estoque Carga Inicio Posto Análitico</label>
                                </a>
                            </div>
                            <br>
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_movimentacao_produto_contrato.php');">
                                    <i class="bi bi-clipboard2-data" style="font-size:30px; color:black"></i>
                                    <label  style="font-size: 15px">Extrato de Movimentação de Produtos por Contrato</label>
                                </a>
                            </div>
                            <br>
                            <div class=' col-sm text-left'>
                                <a href="javascript: abrirMenu('rel_estoque_custo_medio.php');">
                                    <i class="bi bi-clipboard2-data" style="font-size:30px; color:black"></i>
                                    <label  style="font-size: 15px">Extrato de Movimentação de Produtos por Fornecedor</label>
                                </a>
                            </div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?
include "../inc/php/footer.php";
?>

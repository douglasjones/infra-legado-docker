<?
$excel = $_REQUEST['excel'];
if($excel == "S"){
	$arquivo = 'planilha.xls';

	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php" ;
//Verifica se o usuario é o administrador
if(!permissao("tabela_dinamica_ocorrencia", "cons")){
	javascriptalert("Permissão Negada.", "../branco.php");
	exit(0);
}
//Pega os parametros recebidos
if($_REQUEST['cod_polo'] > 0)	
$cod_polo = $_REQUEST['cod_polo'];

if($_REQUEST['codtipoocorrencialead'] > 0)
$razaosocial = $_REQUEST['codtipoocorrencialead'];

if($_REQUEST['datacadastrode'] > 0)
$datacadastrode = $_REQUEST['datacadastrode'];

if($_REQUEST['datacadastroate'] > 0)
$datacadastroate = $_REQUEST['datacadastroate'];

if($_REQUEST['datafechamentode'] > 0)
$datafechamentode = $_REQUEST['datafechamentode'];

if($_REQUEST['datafechamentoate'] > 0)
$datafechamentoate = $_REQUEST['datafechamentoate'];

if($_REQUEST['codusuariointerno'] > 0)
$abertopor = $_REQUEST['codusuariointerno'];

if($_REQUEST['grupousuariointerno'] > 0)
$equipe = $_REQUEST['grupousuariointerno'];

if($_REQUEST['codgerenteconta'] > 0)
$codgerenteconta = $_REQUEST['codgerenteconta'];

if($_REQUEST['codatendente'] > 0)
$codatendente = $_REQUEST['codatendente'];

if(!empty($_REQUEST['codtipoocorrencialead']))
   $codtipoocorrencialead = $_REQUEST['codtipoocorrencialead'];



?>
<html>
<head>
    <link rel="stylesheet"  href="../../extras/public1.css" type="text/css" />
    <script src="../js/public.js"></script>
    <script language="JavaScript" src="ocorrencia_res.js"></script>
    
	<link rel="stylesheet" type="text/css" href="../../js/pivot_tables/dist/pivot.css">
	<script type="text/javascript" src="../../js/pivot_tables/ext/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="../../js/pivot_tables/ext/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="../../js/pivot_tables/dist/pivot.js"></script>
    
    <script>
		function exportar(){
				location.href = "<?= $_SERVER['REQUEST_URI'];?>&excel=S";
		}
    </script>
</head>
<body onload="carregar()">
<form name="frm" method="post">

<h1><font face='arial'>Agendamento</font></h1>
<table border="0" align="left" cellpadding="1" cellspacing="1" width="100%">
	<tr>
		<td>
			<table align="left">
				<tr>
					<th>
						Critérios de Pesquisa
					</th>
				</tr>
				<tr>
					<td>
						<table align="center" class="form">
							<tr>
								<td>
									Relatório gerado em :
								
									<?
									$sql ="select date_format(sysdate(),'%d/%m/%Y %H:%i:%s') datahora ";
									$result = mysql_query($sql);
									$row = mysql_fetch_array($result);
									echo $row['datahora'];
									mysql_free_result($result);
									?>
								</td>
							</tr>
                            <?
                                if(!empty($_REQUEST['cod_polo'])){
                            ?>
                                    <tr>
                                        <td class="parametros">
                                        <?	
                                            $sql = "Select 
                                                    p.cod_polo
                                                    ,p.n_polo
                                                     from polo p";
                                            $sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
                                            $sql .= " Order By p.n_polo ";
                                            $q = mysql_query($sql);
                                            $polo = mysql_fetch_array($q);
                                            echo "Polo: ".$polo['n_polo'];
                                        ?>
                                        </td>
                                    </tr>
                            <? 
                                }                                
                                if(!empty($_REQUEST['codtipoocorrencialead'])){
                            ?>
                                    <tr>
                                        <td class="parametros">
                                            <?	
                                                  $sql = "Select Descricao
                                                          From tipoocorrenciaslead
                                                          Where CodTipoOcorrenciaLead = ".mysqlnull($_REQUEST['codtipoocorrencialead']);
                                                  $sql .= " Order By Descricao";
                                                  $result = mysql_query($sql);
                                                  $tipo = mysql_fetch_array($result);
                                                  echo "Tipo Ocorrência = ".$tipo['Descricao'];
                                            ?>
                                        </td>
                                    </tr>
							<?
                                }                                
                                if(!empty($_REQUEST['datacadastrode'])){                                    
							?>							
                                    <tr>
                                        <td class="parametros">
                                            <b>Faixa de Datas de Abertura: <?=$_REQUEST['datacadastrode'];?> até <?=$_REQUEST['datacadastroate'];?></b>
                                        </td>
                                    </tr>
							<?	
                                }
                                if(!empty($_REQUEST['datafechamentode'])){
							?>
                                    <tr>
                                        <td class="parametros">
                                            Faixa de Datas de Fechamento: <?=$_REQUEST['datafechamentode'];?> até <?=$_REQUEST['datafechamentoate'];?>
                                        </td>
                                    </tr>
							<?
                                }
                                if(!empty($_REQUEST['codusuariointerno'])){
							?>
                                    <tr>
                                        <td class="parametros">
							<?
                                            $sql = "Select nome
                                                    From usuariosinternos
                                                    Where codusuariointerno = ".mysqlnull($_REQUEST['codusuariointerno']);
                                            $result = mysql_query($sql);
                                            $apor = mysql_fetch_array($result);
                                            echo "Aberta Por = ".$apor['nome'];
                            ?>
                                        </td>
                                   </tr>           
                            <?                
								}
                                if(!empty($_REQUEST['grupousuariointerno'])){
							?>
                                    <tr>
                                        <td class="parametros">
							<?
                                            $sql = "Select 
                                                        nome 
                                                    from gruposusuariosinternos
                                                    where CodGrupoUsuarioInterno = ".mysqlnull($_REQUEST['grupousuariointerno']);
                                            $result = mysql_query($sql);
                                            $grupo = mysql_fetch_array($result);
                                            echo "Equipe = ".$grupo['nome'];
                            ?>
                                        </td>
                                   </tr>           
                            <?                
								}
                                if(!empty($_REQUEST['codgerenteconta'])){
							?>
                                    <tr>
                                        <td class="parametros">
							<?
                                            $sql = "Select nome
                                            From usuariosinternos
                                            Where codusuariointerno = ".mysqlnull($_REQUEST['codgerenteconta']);
                                            $result = mysql_query($sql);
                                            $consultor = mysql_fetch_array($result);
                                            echo "Consultor = ".$consultor['nome'];
                            ?>
                                        </td>
                                   </tr>           
                            <?                
								}
                                 if(!empty($_REQUEST['codatendente'])){
							?>
                                    <tr>
                                        <td class="parametros">
							<?
                                            $sql = "Select nome
                                            From usuariosinternos
                                            Where codusuariointerno = ".mysqlnull($_REQUEST['codatendente']);
                                            $result = mysql_query($sql);
                                            $Operador = mysql_fetch_array($result);
                                            echo "Atendente = ".$Operador['nome'];
                            ?>
                                        </td>
                                   </tr>           
                            <?                
								}
                            ?>		
								
						</table>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>			
		<!-- Inicio -->						
        <script type="text/javascript">
             //alert("ocorrencia_json.php?cod_polo=<?= $cod_polo;?>&codtipoocorrencialead=<?= $codtipoocorrencialead;?>&datacadastrode=<?= $datacadastrode;?>&datacadastroate=<?= $datacadastroate;?>&datafechamentode=<?= $datafechamentode;?>&datafechamentoate=<?= $datafechamentoate;?>&abertopor=<?= $abertopor;?>&equipe=<?= $equipe;?>&codgerenteconta=<?= $codgerenteconta;?>&agendadopara=<?= $agendadopara;?>&codatendente=<?= $codatendente;?>")
              $(function(){
                var derivers = $.pivotUtilities.derivers;
                $.getJSON("ocorrencia_json.php?cod_polo=<?= $cod_polo;?>&codtipoocorrencialead=<?= $codtipoocorrencialead;?>&datacadastrode=<?= $datacadastrode;?>&datacadastroate=<?= $datacadastroate;?>&datafechamentode=<?= $datafechamentode;?>&datafechamentoate=<?= $datafechamentoate;?>&abertopor=<?= $abertopor;?>&equipe=<?= $equipe;?>&codgerenteconta=<?= $codgerenteconta;?>&agendadopara=<?= $agendadopara;?>&codatendente=<?= $codatendente;?>", function(mps) {
                    $("#output").pivotUI(mps, {

                    });
                });
             });
        </script>
       
        <div id="output" style="margin: 30px;"></div>
        <!-- Fim -->			
		</td>
	</tr>
</table>
</form>
</body>
</html>
<?
include_once "../libs/desconectar.php";
?>


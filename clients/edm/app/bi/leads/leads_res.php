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
if(!permissao("tabela_dinamica_leads", "cons")){
	javascriptalert("Permissão Negada.", "../branco.php");
	exit(0);
}

//Pega os parametros recebidos


if($_REQUEST['cod_polo'] > 0)	
$cod_polo = $_REQUEST['cod_polo'];

if($_REQUEST['razaosocial'] > 0)
$razaosocial = $_REQUEST['razaosocial'];

if(!empty($_REQUEST['tipo_pessoa']))
$tipo_pessoa = $_REQUEST['tipo_pessoa'];

if($_REQUEST['codstatusclassificacaolead'] > 0)
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];

if($_REQUEST['codequipe'] > 0)
$codequipe = $_REQUEST['codequipe'];

if($_REQUEST['codgerenteconta'] > 0)
$codgerenteconta = $_REQUEST['codgerenteconta'];

if($_REQUEST['codatendente'] > 0)
$codatendente = $_REQUEST['codatendente'];

if($_REQUEST['mailing_pk'] > 0)
$mailing_pk = $_REQUEST['mailing_pk'];	

if($_REQUEST['cod_operadora'] > 0)
$cod_operadora = $_REQUEST['cod_operadora'];

if(!empty($_REQUEST['cidade']))
$cidade = $_REQUEST['cidade'];

if(!empty($_REQUEST['segmento']))
$segmento = $_REQUEST['segmento'];

if(!empty($_REQUEST['cep']))
$cep = $_REQUEST['cep'];



?>
<html>
<head>
    <link rel="stylesheet"  href="../../extras/public1.css" type="text/css" />
    <script src="../js/public.js"></script>
    <script language="JavaScript" src="leads_res.js"></script>
    
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

<h1><font face='arial'>Leads</font></h1>
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
                                if(!empty($_REQUEST['tipo_pessoa'])){
                            ?>
                                    <tr>
                                        <td class="parametros">
                                            <?                                                
                                                if($_REQUEST['tipo_pessoa']=='PJ'){
                                                    echo "Tipo Pessoa: PJ";  
                                                }else{
                                                    echo "Tipo Pessoa: PF";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                            <?  }
                                if(!empty($_REQUEST['codstatusclassificacaolead'])){
                            ?>
                                    <tr>
                                        <td class="parametros">
                                            <?	
                                                $sql = "Select 
                                                        sc.descricao
                                                         from statusclassificacaolead sc";
                                                $sql .= " where sc.codstatusclassificacaolead=".$_REQUEST['codstatusclassificacaolead'];

                                                $q = mysql_query($sql);
                                                $statuslead = mysql_fetch_array($q);
                                                echo "Status Lead: ".$statuslead['descricao'];
                                            ?>
                                        </td>
                                    </tr>
							<?
                                }
                                if(!empty($_REQUEST['codequipe'])){
                            ?>
                                    <tr>
                                        <td class="parametros">
                                        <?									
                                            $sql = "SELECT 
                                                    tbe.Vc_Nome
                                                    FROM tb_equipesvendas tbe
                                                    where tbe.Tk_Equipe=".$_REQUEST['codequipe'];
                                           
                                            $q = mysql_query($sql);
                                           
                                            $row = mysql_fetch_array($q);
                                            echo "Equipe: ". $row['Vc_Nome'];                                      
                                            
                                            mysql_free_result($q);
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
                                        $sql = "select nome from usuariosinternos where codusuariointerno= ".$_REQUEST['codgerenteconta'];
                                        $q = mysql_query($sql);
                                        echo "Consultor: ";
                                        while($row = mysql_fetch_array($q)){
                                            echo $row['nome']." ";
                                        }
                                        mysql_free_result($q);?>                              
                                	</td>
                                </tr>	        
                            <?            
								}
                                if(!empty($_REQUEST['codatendente'])){
							?>							
                                    <tr>
                                        <td class="parametros">
							<?	
								
                                            $sql = "select nome from usuariosinternos where codusuariointerno= ".$_REQUEST['codatendente'];
                                            $q = mysql_query($sql);
                                            echo "Atendente: ";
                                            while($row = mysql_fetch_array($q)){
                                                echo $row['nome']." ";
                                            }
                                            mysql_free_result($q);
                            ?>
                                        </td>
                                    </tr>        
                            <?   
                                }
                                if(!empty($mailing_pk)){
							?>
                                    <tr>
                                        <td class="parametros">
							<?
                                            $sql ="";
                                            $sql.="SELECT m.pk, m.dsc_mailing
                                                          FROM mailing m
                                                         WHERE m.dt_cancelamento IS NULL

                                                    and pk=".$mailing_pk;

                                            $m = mysql_query($sql);
                                            $mailing = mysql_fetch_array($m);
                                            echo "Mailing: ".$mailing['dsc_mailing'];
                            ?>
                                        </td>
                                   </tr>           
                            <?                
								}
                                if(!empty($_REQUEST['cod_operadora'])){
                            ?>
										
                                    <tr>
                                        <td class="parametros">
							<?	
                                        $sql = "Select
                                                op.dsc_operadora
                                                from operadoras op
                                                where op.cod_operadora= ".$_REQUEST['cod_operadora'];
                                        $q = mysql_query($sql);
                                        echo "Operadora: ";
                                        while($row = mysql_fetch_array($q)){
                                            echo $row['dsc_operadora']." ";
                                        }
                                        mysql_free_result($q);
                            ?>
                                        </td>
                                    </tr>                               
                            <?                
								}
                                if(!empty($_REQUEST['cidade'])){
                                    
							?>
							
                                    <tr>
                                        <td class="parametros">
                                            Cidade: <?=$_REQUEST['cidade'];?> 
                                        </td>
                                    </tr>
							<?	
                                }
                                 if(!empty($_REQUEST['cep'])){
                                    
							?>
							
                                    <tr>
                                        <td class="parametros">
                                            Cidade: <?=$_REQUEST['cep'];?> 
                                        </td>
                                    </tr>
							<?	
                                }
                                if(!empty($_REQUEST['segmento'])){
							?>
                                    <tr>
                                        <td class="parametros">
                                            Segmento: <?=$_REQUEST['segmento'];?>
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
                
              $(function(){
                var derivers = $.pivotUtilities.derivers;
                $.getJSON("leads_json.php?cod_polo=<?= $cod_polo;?>&codstatusclassificacaolead=<?= $codstatusclassificacaolead;?>&tipo_pessoa=<?= $tipo_pessoa;?>&codequipe=<?= $codequipe;?>&codgerenteconta=<?= $codgerenteconta;?>&codatendente=<?= $codatendente;?>&mailing_pk=<?= $mailing_pk;?>&cod_operadora=<?= $cod_operadora;?>&cidade=<?= $cidade;?>&segmento=<?= $segmento;?>&cep=<?= $cep;?>", function(mps) {
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


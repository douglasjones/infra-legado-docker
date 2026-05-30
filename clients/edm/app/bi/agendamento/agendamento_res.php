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
/*if(!permissao("tabela_dinamica_atendimentos", "cons")){
	javascriptalert("Permissão Negada.", "../branco.php");
	exit(0);
}*/

//Pega os parametros recebidos


if($_REQUEST['cod_polo'] > 0)	
$cod_polo = $_REQUEST['cod_polo'];

if($_REQUEST['codstatusclassificacaolead'] > 0)
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];

if($_REQUEST['codtipo'] > 0)
$codtipo = $_REQUEST['codtipo'];

if($_REQUEST['datacadastrode'] > 0)
$datacadastrode = $_REQUEST['datacadastrode'];

if($_REQUEST['datacadastroate'] > 0)
$datacadastroate = $_REQUEST['datacadastroate'];

if($_REQUEST['datavisitade'] > 0)
$datavisitade = $_REQUEST['datavisitade'];

if($_REQUEST['datavisitaate'] > 0)
$datavisitaate = $_REQUEST['datavisitaate'];

if($_REQUEST['codequipe'] > 0)
$codequipe = $_REQUEST['codequipe'];

if($_REQUEST['codgerenteconta'] > 0)
$codgerenteconta = $_REQUEST['codgerenteconta'];

if($_REQUEST['codusuariointerno'] > 0)
$codusuariointerno = $_REQUEST['codusuariointerno'];

if($_REQUEST['agendadopara'] > 0)
$agendadopara = $_REQUEST['agendadopara'];

if($_REQUEST['grupousuariointerno'] > 0)
$grupousuariointerno = $_REQUEST['grupousuariointerno'];

if($_REQUEST['codstatus'] > 0)
$codstatus = $_REQUEST['codstatus'];

if($_REQUEST['mailing_pk'] > 0)
$mailing_pk = $_REQUEST['mailing_pk'];



?>
<html>
<head>
    <link rel="stylesheet"  href="../../extras/public1.css" type="text/css" />
    <script src="../js/public.js"></script>
    <script language="JavaScript" src="agendamento_res.js"></script>
    
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
                                if(count($_REQUEST['codstatus'])>0){
                            ?>
                                    <tr>
                                        <td class="parametros">
                                        <?									
                                            $sql = "select descricao from statusagendamento where codstatus in ( ";
                                            for($i=0;$i<count($codstatus);$i++){
                                                
                                                $values[] = $_REQUEST['codstatus'][$i];
                                                $sql.= $_REQUEST['codstatus'][$i].",";
                                                // monta critério se for sem classificacao
                                                if($_REQUEST['codstatus'][$i] == "0"){
                                                    $descricao2 = " Sem Classificação ";
                                                }
                                            }
                                            $sql.=" 0) ";
                                            $q = mysql_query($sql);
                                            echo "Status: ";
                                            while($row = mysql_fetch_array($q)){
                                                echo $row['descricao']."; ";
                                            }
                                            echo $descricao2;
                                            mysql_free_result($q);
                                            
                                            $codstatusagendamento = implode(",", $values);
                                            
                                            
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

                                            $sql = "select nome from gruposusuariosinternos where codgrupousuariointerno= ".$_REQUEST['grupousuariointerno'];
                                            $q = mysql_query($sql);
                                            echo "Grupo Usuário Agendamento: ";
                                            while($row = mysql_fetch_array($q)){
                                                echo $row['nome']." ";
                                            }
                                            mysql_free_result($q);

                                        ?>
                                        </td>
                                    </tr>
                            <?
                                }
                                if(!empty($_REQUEST['codusuariointerno'])){
                            ?>
                                    <tr>
                                        <td class="parametros">
                                            <? $sql = "select nome from usuariosinternos where codusuariointerno= ".$_REQUEST['codusuariointerno'];
                                                $q = mysql_query($sql);
                                                echo "Agendado por: ";
                                                while($row = mysql_fetch_array($q)){
                                                    echo $row['nome']." ";
                                                }
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
                                if(!empty($_REQUEST['agendadopara'])){
							?>							
                                    <tr>
                                        <td class="parametros">
							<?	
								
                                            $sql = "select nome from usuariosinternos where codusuariointerno= ".$_REQUEST['agendadopara'];
                                            $q = mysql_query($sql);
                                            echo "Agendado para: ";
                                            while($row = mysql_fetch_array($q)){
                                                echo $row['nome']." ";
                                            }
                                            mysql_free_result($q);
                            ?>
                                        </td>
                                    </tr>        
                            <?   
                                }
                                if(!empty($_REQUEST['codtipo'])){
                            ?>
										
                                    <tr>
                                        <td class="parametros">
							<?	
                                        $sql = "select codtipo, descricao from tipoagendamento where codtipo = ".$_REQUEST['codtipo'];
                                        $q = mysql_query($sql);
                                        echo "Tipo Agendamento: ";
                                        while($row = mysql_fetch_array($q)){
                                            echo $row['descricao']." ";
                                        }
                                        mysql_free_result($q);
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
                                            $sql = "Select Vc_Nome from tb_equipesvendas where Tk_Equipe = ".$_REQUEST['codequipe'];
                                            $q = mysql_query($sql);
                                            $equipe = mysql_fetch_array($q);
                                            echo "Equipe: ".$equipe['Vc_Nome'];
							?>
                                    	</td>
                                    </tr>
                            <?                
                                }
                                if(!empty($_REQUEST['datacadastrode'])){
                                    
							?>
							
                                    <tr>
                                        <td class="parametros">
                                            <b>Faixa de Datas do Agendamento: <?=$_REQUEST['datacadastrode'];?> até <?=$_REQUEST['datacadastroate'];?></b>
                                        </td>
                                    </tr>
							<?	
                                }
                                if(!empty($_REQUEST['datavisitade'])){
							?>
                                    <tr>
                                        <td class="parametros">
                                            Faixa de Datas de Visita: <?=$_REQUEST['datavisitade'];?> até <?=$_REQUEST['datavisitaate'];?>
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
            //alert("agendamento_json.php?cod_polo=<?= $cod_polo;?>&codstatusclassificacaolead=<?= $codstatusclassificacaolead;?>&codtipo=<?= $codtipo;?>&datacadastrode=<?= $datacadastrode;?>&datacadastroate=<?= $datacadastroate;?>&datavisitade=<?= $datavisitade;?>&datavisitaate=<?= $datavisitaate;?>&codequipe=<?= $codequipe;?>&codgerenteconta=<?= $codgerenteconta;?>&codusuariointerno=<?= $codusuariointerno;?>&agendadopara=<?= $agendadopara;?>&grupousuariointerno=<?=$grupousuariointerno;?>&mailing_pk=<?=$mailing_pk;?>&codstatus='<?=$codstatusagendamento;?>'");
              $(function(){
                var derivers = $.pivotUtilities.derivers;
                $.getJSON("agendamento_json.php?cod_polo=<?= $cod_polo;?>&codstatusclassificacaolead=<?= $codstatusclassificacaolead;?>&codtipo=<?= $codtipo;?>&datacadastrode=<?= $datacadastrode;?>&datacadastroate=<?= $datacadastroate;?>&datavisitade=<?= $datavisitade;?>&datavisitaate=<?= $datavisitaate;?>&codequipe=<?= $codequipe;?>&codgerenteconta=<?= $codgerenteconta;?>&codusuariointerno=<?= $codusuariointerno;?>&agendadopara=<?= $agendadopara;?>&grupousuariointerno=<?=$grupousuariointerno;?>&mailing_pk=<?=$mailing_pk;?>&codstatus='<?=$codstatusagendamento;?>'", function(mps) {
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


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
include_once "../../libs/cla.equipes.php";
include_once "../../libs/datas.php";

$cod_polo = $_REQUEST['cod_polo'];
$codatendente = $_REQUEST['codatendente'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$cod_operadora = $_REQUEST['cod_operadora'];
$vencimentocontratode = $_REQUEST['vencimentocontratode'];
$vencimentocontratoate = $_REQUEST['vencimentocontratoate'];
$qtde_dias = $_REQUEST['qtde_dias'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
$cidade = $_REQUEST['cidade'];
$codstatusclassificacaolead_pk = "";
$codequipe = $_REQUEST['codequipe'];
$mailing_pk = $_REQUEST['mailing_pk'];
$dt_ini_oc = $_REQUEST['dt_ini_oc'];
$dt_fim_oc = $_REQUEST['dt_fim_oc'];
$cod_operador = $_REQUEST['cod_operador'];

$acao = 'cs';
if(!(($acao == 'cs' && permissao('funil_pesq.php', 'cs')) || ($acao == 'upd' && permissao('funil_pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}

?>
<html>
<head>
<!--Include CSS-->
<?
if($excel != "S"){
?>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<script src="../../extras/tabela.js"></script>
<?
}
?>
</head>
<!--HTML-->
<body leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>
<?
}
?>
<table align="center">
	<tr>
		<td class="form"><font size="4">Relatório Consolidado</font></td>
	</tr>
</table>
<table>
	<tr>
		<td class="form">
			<b>Parâmetros:</b><br><br>
			
			<?if(!empty($cod_polo)){			?>
			Pólo: <?
				$sql = "select n_polo from polo where cod_polo = $cod_polo ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['n_polo'];
				mysql_free_result($result);
				echo "<br>";				
			}?>
			<?
			if(!empty($vencimentocontratode)){
				echo "Data Vencimento Contrato maior ou igual a $vencimentocontratode ";
				echo "<br>";
			}
			?>
			<?
			if(!empty($vencimentocontratoate)){
				echo "Data Vencimento Contrato menor ou igual a $vencimentocontratoate ";
				echo "<br>";				
			}
			?>
			<?		
			if(!empty($codgerenteconta)){
			?>
			Consultor: <?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
				echo "<br>";				
			}?>
			<?
			if($codgerenteconta == "0"){
				echo "Consultor: Nenhum ";
				echo "<br>";
			}
			?>
			<?if(!empty($codatendente)){?>
			Atendente:
			<?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codatendente ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);			
				echo "<br>";				
			}?>
			<?
			if($codatendente == "0"){
				echo "Atendente: Nenhum ";
				echo "<br>";				
			}
			?>
			<?if (!empty($cod_operadora)){?>
			Operadora:
			<?
				$sql = "select dsc_operadora from operadoras where cod_operadora = $cod_operadora ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['dsc_operadora'];
				mysql_free_result($result);
				echo "<br>";				
			}
			?>
			<?if(count($codstatusclassificacaolead)>0){?>
			Status:
			<?
				$sql = "select descricao from statusclassificacaolead where codstatusclassificacaolead in ( ";
				for($i = 0; $i<count($codstatusclassificacaolead);$i++){
					$sql.=$codstatusclassificacaolead[$i].", ";
					$codstatusclassificacaolead_pk.=$codstatusclassificacaolead[$i].", ";
				}
				$sql.="0) ";
				$codstatusclassificacaolead_pk.="0";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result))
					echo $row['descricao']."; ";
				mysql_free_result($result);			
				echo "<br>";
			}?>
			<?
			if(!empty($qtde_dias)){
				echo "Qtde Dias Ult. Ocorrência: $qtde_dias ";
				echo "<br>";				
			}
			?>
			<?
			if(!empty($cidade)){
				echo "Cidade: $cidade ";
				echo "<br>";				
			}
			?>	
            <?
		
			if(!empty($mailing_pk)){
			$sql ="";
			$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						
					and pk=".$mailing_pk;
					
			$m = mysql_query($sql);
			$mailing = mysql_fetch_array($m);
			echo "Mailing: ".$mailing['dsc_mailing'];
		}
		?>
            			<?
			if(!empty($dt_ini_oc)){
				echo "Data Ultima Ocorrência $dt_ini_oc ";
				echo "<br>";
			}
			?>
			<?
			if(!empty($dt_fim_oc)){
				echo "Data Ultima Ocorrência $dt_fim_oc ";
				echo "<br>";				
			}
			?>
		</td>
	</tr>
</table>
<br>
<br>
<table width="100%" border="1" cellpadding="0" cellspacing="0" class="sortable">
	<thead>
	<tr>
		<th class="titulo" bgcolor="#8080FF">
			Equipe
		</th>
        <?
            $sql = "";
            $sql.= "SELECT o.dsc_operador
                            FROM operador o
                                 INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                          ORDER BY o.dsc_operador";
            $result = mysql_query($sql);   

            while($row = mysql_fetch_array($result)){
                echo "<th class='titulo' bgcolor='#8080FF'>";                
                if($row['dsc_operador']=='Claro' || $row['dsc_operador']=='Tim' || $row['dsc_operador']=='Vivo' || $row['dsc_operador']=='Nextel' || $row['dsc_operador']=='Oi' ){                    
                    echo $row['dsc_operador']." Nov/Port/Inc"; 
                }else{                   
                    echo $row['dsc_operador'];              
                }
                echo "</th>";                
            }
            mysql_free_result($result);
            
        ?>
        
	</tr>
	</thead>
	<tbody>
<?
$where = "";

	if(!empty($cod_operadora)){
		$where.=" and l.codlead in (";
		$where.="  select lo.codlead ";
		$where.="    from leads_operadoras lo ";
		$where.="   where lo.cod_operadora = $cod_operadora ";
		$where.=" ) ";
	}
	
    
    if(!empty($codequipe)){
		$where.="  and ui.codusuariointerno in (";
		$where.=" select e.fk_usuario ";
		$where.="   from tb_usuarioequipe e ";
		$where.="  where fk_equipe = $codequipe ) ";
	}
    
	if(!empty($codgerenteconta)){
		$where.=" and l.codgerenteconta = $codgerenteconta ";
	}
	
	if($codgerenteconta == "0"){
		$where.=" and l.codgerenteconta is null ";
	}
	
	if($codatendente == "0"){
		$where.=" and l.codatendente is null ";
	}
	
	if($codstatusclassificacaolead_pk!=""){
		$where.=" and l.codstatusclassificacaolead in (".$codstatusclassificacaolead_pk.") ";
	}

	if(!empty($vencimentocontratode))
		$where.=" and ndp.vl_data_proposta >= '".DataYMD($vencimentocontratode)." 00:00:00' ";
	
	if(!empty($vencimentocontratoate))
		$where.=" and ndp.vl_data_proposta <= '".DataYMD($vencimentocontratoate)." 23:59:59' ";
		
	if(!empty($cidade))
		$where.=" and cidade like '%".$cidade."%' ";
		
	if(!empty($mailing_pk)){
   		$where.=" and l.mailing_pk =".$mailing_pk;
   	}
    
    if(!empty($cod_operador)){
   		$where.=" and np.operador_pk =".$operador_pk;
   	}
    
    
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$where.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	

	$sql = "SELECT eq.Tk_Equipe AS cod,
                    eq.Vc_nome AS equipe,
                    u.Nome AS lider,
                    u2.Nome AS gerente
               FROM tb_equipesvendas eq
                    INNER JOIN usuariosinternos u ON u.CodUsuarioInterno = eq.Fk_lider
                    LEFT JOIN usuariosinternos u2 ON u2.CodUsuarioInterno = eq.Fk_Gerente
              WHERE 1";
	//$sql.=$where;
	//$sql.=" group by l.codlead,np.pk";
    
	$result = mysql_query($sql);
    

	while($row = mysql_fetch_array($result)){
		echo "<tr>";
            echo "<td align='center' class='form'>&nbsp;".$row['equipe']."&nbsp;</td>";
          
            $sql = "";
            $sql.= "SELECT      o.cod_operador,
                                o.dsc_operador
                            FROM operador o
                                 INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                          ORDER BY o.dsc_operador";
            
            $results = mysql_query($sql);   

            while($rows = mysql_fetch_array($results)){
                echo "<td class='form'>";
                
                $sql = "";
                $sql.= "Select 
                        sum(np.vl_total_proposta) valor   
                              from leads l 
                                    inner JOIN n_propostas np ON l.CodLead = np.leads_pk and np.dt_cancelamento is null	
                            LEFT JOIN n_itens_propostas nip on np.pk = nip.propostas_pk
                            LEFT JOIN n_itens_propostas_operadoras nipo on nip.pk = nipo.itens_propostas_pk
                            INNER JOIN usuariosinternos ui  ON   l.CodGerenteConta = ui.CodUsuarioInterno AND ui.GerenteContas = '1' AND ui.Desativado = '-1'	
                            LEFT JOIN tb_usuarioequipe tbu ON ui.CodUsuarioInterno = tbu.Fk_Usuario
                            INNER JOIN tb_equipesvendas tbe ON tbu.Fk_Equipe = tbe.Tk_Equipe
                            inner join operador o on np.operador_pk = o.cod_operador
                              where 1=1";
                $sql.= " and o.cod_operador =".$rows['cod_operador'];
                $sql.= " and tbe.Tk_Equipe =".$row['cod'];
                if($rows['cod_operador']==1){
                    $sql.= " and nipo.tipo_linha_pk in (7,8,10)";
                }
                    
                $sql.= " and np.dt_cancelamento is null
                        group by tbe.Tk_Equipe";
                echo $sql;
                $rs = mysql_query($sql);   

                $rw = mysql_fetch_array($rs);
                
                echo "R$ ".number_format($rw['valor'],2,",",".");
                mysql_free_result($rs);
                echo "</td>";                
            }
            mysql_free_result($results);
       
            
		echo "</tr>";
        $total ++;
	}
?>
	</tbody>
	<tfoot>
	<tr>
		<th class="titulo" bgcolor="#8080FF" colspan="13">
			<?= $total;?> registro(s)
		</th>
	</tr>
	</tfoot>
</table>
</body>
<?
include_once "../../libs/desconectar.php";
?>




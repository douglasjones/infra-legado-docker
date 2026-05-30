<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';
	
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/x-msexcel");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.equipes.php";
	
$cod_polo = $_REQUEST['cod_polo'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$cod_operadora = $_REQUEST['cod_operadora'];
$codequipe = $_REQUEST['codequipe'];
$mailing_pk = $_REQUEST['mailing_pk'];
$dt_periodo_de = $_REQUEST['dt_periodo_de'];
$dt_periodo_ate = $_REQUEST['dt_periodo_ate'];

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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>

<?
}
?>
<br>
<table width="100%" align="center"  height="5"  cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<font size="+2" face="Arial">Resultado Vendas Equipe</font>
		</td>	
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="0" class="form">	
	<tr>		
		<td class="parametros">
		<?	if(!empty($cod_polo)){
			$sql = "Select 
					p.cod_polo
					,p.n_polo
					 from polo p";
			$sql .= " where p.cod_polo= $cod_polo ";
			$sql .= " Order By p.n_polo ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['n_polo'];
			}?>		
		</td>
	</tr>	
	
	<tr>		
		<td class="parametros">
		<?	if(!empty($codgerenteconta)){
				$sql = "Select Nome From usuariosinternos Where CodUsuarioInterno = $codgerenteconta";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					echo "Consultor: ".$row['nome'];
				}
				mysql_free_result($result);
			
			}?>		
		</td>
	</tr>	
	<tr>		
		<td class="parametros">
		<?	if(!empty($cod_operadora)){
				$sql = "select dsc_operadora from operadoras where cod_operadora = $cod_operadora ";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					echo "Operadora: ".$row['dsc_operadora'];
				}
				mysql_free_result($result);
			
			}?>		
		</td>
	</tr>			
	<tr>		
		<td class="parametros">
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
		</td>
	</tr>
    	<?	
	if(!empty($_REQUEST['dt_periodo_de'])){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas do Perído:</dt>
				<dd><?=date('d/m/Y', strtotime(dataYMD($_REQUEST['dt_periodo_de'])));?> até <?=date('d/m/Y', strtotime(dataYMD($_REQUEST['dt_periodo_ate'])));?></dd>
		</td>
	</tr>
	<?	
	}

	?>

	<tr>		
		<td class="parametros">
			Relatório gerado em 
				<?
				//Pega a data de geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
				mysql_free_result($rs_geracao);
				?>		
		</td>	
	</tr>
</table>
<br>
<br>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <?
        $sql ="";
        $sql.="SELECT e.Tk_Equipe,
                e.Vc_Nome,
                e.Fk_Lider,
                e.Fk_Gerente
           FROM tb_equipesvendas e";
        if(!empty($codequipe)){
            $sql.=" WHERE e.Tk_Equipe =".$codequipe;
        }
        $result1 = mysql_query($sql);
        while($row1 = mysql_fetch_array($result1)){
            echo "<tr>";
            echo    "<td colspan=11>";
            echo    "<font size='+1' face='Arial'>Equipe: ".$row1['Vc_Nome']."</font>";
            echo    "</td>";
            echo "</tr>";
        ?>
            <tr>
                <td>
                    <table width="1180" border="1" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%" class="titulo" bgcolor="#8080FF">
                                    Consultor
                                </th>
                                <th class="titulo" bgcolor="#8080FF">
                                    Sem Interesse
                                </th>
                                <th  class="titulo" bgcolor="#8080FF">
                                    Trgt Lead(s)
                                </th>	
                                <th  class="titulo" bgcolor="#8080FF">
                                    0% Lead(s)
                                </th>
                                <th  class="titulo" bgcolor="#8080FF">
                                    25% Lead(s)
                                </th>		
                                <th  class="titulo" bgcolor="#8080FF">
                                    50% Linha(s)
                                </th>  
                                <th  class="titulo" bgcolor="#8080FF">
                                    75% Linha(s)
                                </th>
                                <th  class="titulo" bgcolor="#8080FF">
                                    80% Linha(s)
                                </th>		
                                <th  class="titulo" bgcolor="#8080FF">
                                    90% Linha(s)
                                </th>		
                                <th  class="titulo" bgcolor="#8080FF">
                                    Aprovados
                                </th>	
                                <th  class="titulo" bgcolor="#8080FF">
                                    Em Analise
                                </th>	
                                 <th  class="titulo" bgcolor="#8080FF">
                                    Reprovados
                                </th>
                                <th class="titulo" bgcolor="#8080FF">
                                    Cliente(s)
                                </th>
                            </tr>

                        <?
                            $cor = "white";
                            $i = 0;
                            $sql = "";
                            $sql.="select ui.codusuariointerno,ui.nome gerenteconta, ui.desativado, count(*) total ";
                            $sql.="  from usuariosinternos ui ";
                            $sql.="       left join leads l on l.codgerenteconta = ui.codusuariointerno ";
                           // $sql.="       left join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";
                            $sql.="       inner join tb_usuarioequipe tbe on ui.codusuariointerno = tbe.fk_usuario ";
                            $sql.=" where ui.GerenteContas = 1 ";
                            $sql.=" and tbe.fk_equipe = ".$row1['Tk_Equipe'];
                            if(!permissao('visualizar_todos_consultores', 'cs'))
                                $sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";

                            //parametros de filtro
                            if(!empty($codgerenteconta))
                                $sql.=" and l.codgerenteconta = $codgerenteconta ";

                            if(!empty($mailing))
                                $sql.="  and l.mailing_pk = ".$mailing_pk;	

                            if(!empty($_REQUEST['cod_polo']))
                                $sql.=" and l.cod_polo =". $_REQUEST['cod_polo'];

                            if(!empty($cod_operadora)){
                                $sql.= " and l.codlead in (select lo.codlead from leads_operadoras lo where lo.cod_operadora = $cod_operadora) ";
                            }        

                            //fim dos parametros

                            $sql.=" group by ui.nome, ui.desativado";
                            $sql.=" order by ui.desativado, ui.nome ";

                            $result = mysql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                $t_linha = "0";
                                if($cor == '#dbdbdb'){
                                    $cor = "white";
                                }
                                else{
                                    $cor = "#dbdbdb";
                                } 
                                echo "<tr bgcolor=".$cor.">";
                                echo    "<td width='20%' class='form' >";
                                            if($row['desativado']==1){
                                                echo "<font color='#990000'>".$row['gerenteconta']."</font>";
                                            }else{
                                                echo "<font color='#009900'>".$row['gerenteconta']."</font>";
                                            }
                                echo    "</td>";
                                    //SEM INTERESSE
                                    $sql ="";
                                    $sql.="SELECT scl.descricao, count(*) total
                                            FROM statusclassificacaolead scl
                                                 INNER JOIN leads l
                                                    ON l.codstatusclassificacaolead = scl.codstatusclassificacaolead
                                           WHERE l.codgerenteconta=".$row['codusuariointerno'];
                                    $sql.="  and l.CodStatusClassificacaoLead=1";
                                    if(!empty($dt_periodo_de)){
                                        $sql.="  and l.datacadastro >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and l.datacadastro <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }
                                    $sql.="      GROUP BY scl.descricao";

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_seminteresse = ($t_seminteresse + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //TARGET
                                    $sql ="";
                                    $sql.="SELECT scl.descricao, count(*) total
                                            FROM statusclassificacaolead scl
                                                 INNER JOIN leads l
                                                    ON l.codstatusclassificacaolead = scl.codstatusclassificacaolead
                                           WHERE l.codgerenteconta=".$row['codusuariointerno'];
                                    $sql.="  and l.CodStatusClassificacaoLead=2";
                                    if(!empty($dt_periodo_de)){
                                        $sql.="  and l.datacadastro >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and l.datacadastro <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }
                                    $sql.="      GROUP BY scl.descricao";

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_target = ($t_target + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);

                                    //0%
                                    $sql ="";
                                    $sql.="SELECT scl.descricao, count(*) total
                                            FROM statusclassificacaolead scl
                                                 INNER JOIN leads l
                                                    ON l.codstatusclassificacaolead = scl.codstatusclassificacaolead
                                           WHERE l.codgerenteconta=".$row['codusuariointerno'];
                                    $sql.="  and l.CodStatusClassificacaoLead=3";
                                    if(!empty($dt_periodo_de)){
                                        $sql.="  and l.datacadastro >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and l.datacadastro <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }
                                    $sql.="      GROUP BY scl.descricao";

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_zero = ($t_zero + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //25%
                                    $sql ="";
                                    $sql.="SELECT scl.descricao, count(*) total
                                            FROM statusclassificacaolead scl
                                                 INNER JOIN leads l ON l.codstatusclassificacaolead = scl.codstatusclassificacaolead
                                                 INNER JOIN agendaslead a on l.codlead = a.codlead
                                           WHERE l.codgerenteconta=".$row['codusuariointerno'];
                                    $sql.="  and l.CodStatusClassificacaoLead=4";

                                    if(empty($dt_periodo_de)){
                                        $sql.="  and a.datacadastro >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and a.datacadastro <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }
                                    $sql.="      GROUP BY scl.descricao";

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_25 = ($t_25 + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //50%
                                    $sql ="";
                                    $sql.="SELECT sum(nip.n_qtde) total
                                                FROM n_propostas np
                                                     INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                     INNER JOIN n_produtos npr
                                                        ON nip.produtos_pk = npr.pk AND npr.produtos_tipo_pk = 1
                                                     INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                     INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
                                               WHERE l.CodStatusClassificacaoLead =5";
                                    $sql.="           AND l.CodGerenteConta =".$row['codusuariointerno'];                                                        
                                    $sql.="            AND ndp.data_proposta_operador_pk = (Select n_data_proposta_operador.pk from n_data_proposta_operador where n_data_proposta_operador.operador_pk=2 and n_data_proposta_operador.dt_cancelamento is null and n_data_proposta_operador.statusclassificacaolead_pk=5)";                                                            
                                    $sql.="            AND  np.dt_cancelamento IS NULL";
                                    if(!empty($dt_periodo_de)){
                                        $sql.="  and ndp.vl_data_proposta >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and ndp.vl_data_proposta <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_50 = ($t_50 + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //75%
                                    $sql ="";
                                    $sql.="SELECT sum(nip.n_qtde) total
                                                FROM n_propostas np
                                                     INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                     INNER JOIN n_produtos npr
                                                        ON nip.produtos_pk = npr.pk AND npr.produtos_tipo_pk = 1
                                                     INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                     INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
                                               WHERE l.CodStatusClassificacaoLead =6";
                                    $sql.="           AND l.CodGerenteConta =".$row['codusuariointerno'];                                                        
                                    $sql.="            AND ndp.data_proposta_operador_pk = (Select n_data_proposta_operador.pk from n_data_proposta_operador where n_data_proposta_operador.operador_pk=2 and n_data_proposta_operador.dt_cancelamento is null and n_data_proposta_operador.statusclassificacaolead_pk=6)";                                                            
                                    $sql.="            AND  np.dt_cancelamento IS NULL";
                                    if(!empty($dt_periodo_de)){
                                        $sql.="  and ndp.vl_data_proposta >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and ndp.vl_data_proposta <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_75 = ($t_75 + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //80%
                                    $sql ="";
                                    $sql.="SELECT sum(nip.n_qtde) total
                                                FROM n_propostas np
                                                     INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                     INNER JOIN n_produtos npr
                                                        ON nip.produtos_pk = npr.pk AND npr.produtos_tipo_pk = 1
                                                     INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                     INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
                                               WHERE l.CodStatusClassificacaoLead =10";
                                    $sql.="           AND l.CodGerenteConta =".$row['codusuariointerno'];                                                        
                                    $sql.="            AND ndp.data_proposta_operador_pk = (Select n_data_proposta_operador.pk from n_data_proposta_operador where n_data_proposta_operador.operador_pk=2 and n_data_proposta_operador.dt_cancelamento is null and n_data_proposta_operador.statusclassificacaolead_pk=10)";                                                            
                                    $sql.="            AND  np.dt_cancelamento IS NULL";
                                    if(!empty($dt_periodo_de)){
                                        $sql.="  and ndp.vl_data_proposta >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and ndp.vl_data_proposta <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_75 = ($t_75 + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //90%
                                    $sql ="";
                                    $sql.="SELECT sum(nip.n_qtde) total
                                                FROM n_propostas np
                                                     INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                     INNER JOIN n_produtos npr
                                                        ON nip.produtos_pk = npr.pk AND npr.produtos_tipo_pk = 1
                                                     INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                     INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
                                               WHERE l.CodStatusClassificacaoLead =12";
                                    $sql.="           AND l.CodGerenteConta =".$row['codusuariointerno'];                                                        
                                    $sql.="            AND ndp.data_proposta_operador_pk = (Select n_data_proposta_operador.pk from n_data_proposta_operador where n_data_proposta_operador.operador_pk=2 and n_data_proposta_operador.dt_cancelamento is null and n_data_proposta_operador.statusclassificacaolead_pk=12)";                                                            
                                    $sql.="            AND  np.dt_cancelamento IS NULL";
                                    if(!empty($dt_periodo_de)){
                                        $sql.="  and ndp.vl_data_proposta >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and ndp.vl_data_proposta <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }
                                    
                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_90 = ($t_0 + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //APROVADOS
                                    $sql ="";
                                    $sql.="SELECT 
                                               ndp.data_proposta_operador_pk,
                                               ndp.dt_cadastro
                                             FROM n_datas_proposta ndp
                                                  INNER JOIN n_propostas np ON ndp.propostas_pk = np.pk
                                                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                  INNER JOIN leads l ON np.leads_pk = l.CodLead
                                            WHERE     l.CodStatusClassificacaoLead = 12
                                                  AND np.dt_cancelamento IS NULL";
                                     $sql.="      AND l.CodGerenteConta =".$row['codusuariointerno'];
                                     //$sql.="    AND ndp.data_proposta_operador_pk IN (205,190)";
                                     $sql.=" order by ndp.dt_cadastro";
                                     $result1 = mysql_query($sql);                                     
                                     while($row1 = mysql_fetch_array($result1)){
                                        if($row1['dt_cadastro']){

                                        }
                                     }
                                     mysql_free_result($result);
                                    
                                    
                                    
                                    
                                    $sql ="";
                                    $sql.="SELECT nip.n_qtde total
                                             FROM n_datas_proposta ndp
                                                  INNER JOIN n_propostas np ON ndp.propostas_pk = np.pk
                                                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                  INNER JOIN leads l ON np.leads_pk = l.CodLead
                                            WHERE     l.CodStatusClassificacaoLead = 12
                                                  AND np.dt_cancelamento IS NULL";
                                     $sql.="      AND l.CodGerenteConta =".$row['codusuariointerno'];
                                     $sql.="      AND ndp.data_proposta_operador_pk IN (205,190)";
                                     $sql.=" group by ndp.propostas_pk";

                                    $result0 = mysql_query($sql);
                                    $aprovados = "";
                                    while($row0 = mysql_fetch_array($result0)){
                                        $aprovados = $aprovados + $row0['total']; 
                                        $t_aprovado = ($t_aprovado + $row0['total']);
                                    }
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($aprovados)){
                                            echo $aprovados;
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //EM ANALISE
                                    $sql ="";
                                    $sql.="SELECT nip.n_qtde total
                                             FROM n_datas_proposta ndp
                                                  INNER JOIN n_propostas np ON ndp.propostas_pk = np.pk
                                                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                  INNER JOIN leads l ON np.leads_pk = l.CodLead
                                            WHERE     l.CodStatusClassificacaoLead = 12
                                                  AND np.dt_cancelamento IS NULL";
                                     $sql.="      AND l.CodGerenteConta =".$row['codusuariointerno'];
                                     $sql.="      AND ndp.data_proposta_operador_pk IN (206,207,208,209)";
                                     $sql.=" group by ndp.propostas_pk";

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    $em_analise = "";
                                    while($row0 = mysql_fetch_array($result0)){
                                        $em_analise = $em_analise + $row0['total']; 
                                        $t_em_analise = ($t_em_analise + $row0['total']);
                                    }
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($em_analise)){
                                            echo $em_analise;
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    //REPROVADO
                                    $sql ="";
                                    $sql.="SELECT nip.n_qtde total
                                             FROM n_datas_proposta ndp
                                                  INNER JOIN n_propostas np ON ndp.propostas_pk = np.pk
                                                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                  INNER JOIN leads l ON np.leads_pk = l.CodLead
                                            WHERE     l.CodStatusClassificacaoLead = 12
                                                  AND np.dt_cancelamento IS NULL";
                                     $sql.="      AND l.CodGerenteConta =".$row['codusuariointerno'];
                                     $sql.="      AND ndp.data_proposta_operador_pk IN (204,210,211,216,212,213,214,215)";


                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    $reprovados = "";
                                    while($row0 = mysql_fetch_array($result0)){
                                        $reprovados = $reprovados + $row0['total']; 
                                        $t_reprovado = ($t_reprovado + $row0['total']);
                                    }
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($reprovados)){
                                            echo $reprovados;
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                    
                                    //CLIENTE
                                    $sql ="";
                                    $sql.="SELECT sum(nip.n_qtde) total
                                                FROM n_propostas np
                                                     INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                     INNER JOIN n_produtos npr
                                                        ON nip.produtos_pk = npr.pk AND npr.produtos_tipo_pk = 1
                                                     INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                     INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
                                               WHERE l.CodStatusClassificacaoLead =15";
                                    $sql.="           AND l.CodGerenteConta =".$row['codusuariointerno'];                                                        
                                    $sql.="            AND ndp.data_proposta_operador_pk = (Select n_data_proposta_operador.pk from n_data_proposta_operador where n_data_proposta_operador.operador_pk=2 and n_data_proposta_operador.dt_cancelamento is null and n_data_proposta_operador.statusclassificacaolead_pk=15)";                                                            
                                    $sql.="            AND  np.dt_cancelamento IS NULL";
                                    if(!empty($dt_periodo_de)){
                                        $sql.="  and ndp.vl_data_proposta >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                    }
                                    if(!empty($dt_periodo_ate)){
                                        $sql.="  and ndp.vl_data_proposta <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                    }

                                    $result0 = mysql_query($sql);
                                    $row0 = mysql_fetch_array($result0);
                                    echo "<td width='100' align='center' class='form' >";
                                        if(!empty($row0['total'])){
                                            echo $row0['total'];
                                            $t_cliente = ($t_cliente + $row0['total']); 
                                        }else{
                                            echo "0";
                                        }
                                    echo "</td>";
                                    mysql_free_result($result0);
                                echo "</tr>";    
                            }    
                        ?>
                </table> 
                </td>        
            </tr>    
            
        <?                
         }
        ?> 
            
    </table>        
</body>
</html>


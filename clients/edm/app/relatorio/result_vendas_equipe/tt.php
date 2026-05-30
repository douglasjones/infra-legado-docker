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
            <table width="100%" border="1" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="400" nowrap class='titulo' bgcolor='#8080FF'>Consultor</th>
                    <?
                    $arrStatus = array();
                    $arrStatusTotal = array();
                    $arrTitulo = array();

                    $arrTitulo[1]= 'Sem Inter Lead(s)';
                    $arrTitulo[2]= 'Trgt Lead(s)';
                    $arrTitulo[3]= '0% Lead(s)';
                    $arrTitulo[4]= '25% Lead(s)';
                    $arrTitulo[5]= '50% Linha(s)';
                    $arrTitulo[6]= '75% Linha(s)';
                    $arrTitulo[10]= '80% Linha(s)';
                    $arrTitulo[12]= '90% Linha(s)';                    
                    //$arrTitulo[15]= 'Cliente Linha(s)';

                    $sql = "";
                    $sql.= "select descricao, codstatusclassificacaolead from statusclassificacaolead order by codstatusclassificacaolead ";
                    $result = mysql_query($sql);
                    while($row = mysql_fetch_array($result)){
                        if($row['codstatusclassificacaolead']>12){
                            echo "<th class='titulo' bgcolor='#8080FF'>Aprovados</th>";
                            echo "<th class='titulo' bgcolor='#8080FF'>Em Analise</th>";
                            echo "<th class='titulo' bgcolor='#8080FF'>Reprovados</th>";
                            echo "<th class='titulo' bgcolor='#8080FF'>Cliente Linha(s)</th>";
                        }else{
                            echo "<th class='titulo' bgcolor='#8080FF'>".$arrTitulo[$row['codstatusclassificacaolead']]."</th>";
                        }
                        $arrStatus[$row['descricao']] = 0;
                        $arrStatusTotal[$row['descricao']] = 0;
                    }
                    mysql_free_result($result);
                    ?>
                    <th class="titulo" bgcolor="#8080FF">
                        Total
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
                                
                                $tl_si = "0";
                                $tl_tg = "0";
                                $tl_0 = "0";
                                $tl_25 = "0";
                                $tl_50 = "0";
                                $tl_75 = "0";
                                $tl_80 = "0";
                                $tl_90 = "0";
                                $tg_aprovado = "0";
                                $tg_em_analise = "0";
                                $tg_reprovado = "0";
                                $tg_cli = "0";
                                $t_linha = "0";
                                $total_g = "0";
                            while($row = mysql_fetch_array($result)){
                                $t_linha = "0";
                                if($cor == '#dbdbdb'){
                                    $cor = "white";
                                }
                                else{
                                    $cor = "#dbdbdb";
                                }	
                               
                            ?>
                                <tr bgcolor="<?=$cor;?>">
                                    <td class='form' >
                                        <?
                                            if($row['desativado']==1){
                                                echo "<font color='#990000'>".$row['gerenteconta']."</font>";
                                            }else{
                                                echo "<font color='#009900'>".$row['gerenteconta']."</font>";
                                            }
                                        ?>
                                    </td>
                                    <?
                                    
                                        $sql ="";
                                        $sql.="Select
                                                sc.CodStatusClassificacaoLead
                                                from statusclassificacaolead sc";
                                        $result2 = mysql_query($sql);
                                        while($row2 = mysql_fetch_array($result2)){
                                        if($row2['CodStatusClassificacaoLead']>12){
                                            //APROVADOS
                                            $sql ="";
                                            $sql.="SELECT nip.n_qtde total
                                                     FROM n_datas_proposta ndp
                                                          INNER JOIN n_propostas np ON ndp.propostas_pk = np.pk
                                                          INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                          INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                    WHERE     l.CodStatusClassificacaoLead >= 12
                                                          AND np.dt_cancelamento IS NULL";
                                             $sql.="      AND l.CodGerenteConta =".$row['codusuariointerno'];
                                             $sql.="      AND ndp.data_proposta_operador_pk IN (205,190)";
                                             $sql.=" group by ndp.propostas_pk";
                                             //echo $sql."<br>";
                                             
                                             $result5 = mysql_query($sql);
                                             $tl_aprovado = "0";
                                             while($row5 = mysql_fetch_array($result5)){
                                               $tl_aprovado  = ($tl_aprovado + $row5['total']);
                                             }
                                             
                                            if(!empty($tl_aprovado)){
                                               $tg_aprovado  = ($tg_aprovado + $tl_aprovado); 
                                               echo "<td align='center' class='form' >"; 
                                               echo $tl_aprovado;
                                               echo "</td>";
                                            }else{
                                               echo "<td align='center' class='form' >"; 
                                               echo "0"; 
                                               echo "</td>";
                                            }
                                            mysql_free_result($result5);
                                            //EM ANALISE
                                            $sql ="";
                                            $sql.="SELECT nip.n_qtde total
                                                     FROM n_datas_proposta ndp
                                                          INNER JOIN n_propostas np ON ndp.propostas_pk = np.pk
                                                          INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                          INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                    WHERE     l.CodStatusClassificacaoLead >= 12
                                                          AND np.dt_cancelamento IS NULL";
                                             $sql.="      AND l.CodGerenteConta =".$row['codusuariointerno'];
                                             $sql.="      AND ndp.data_proposta_operador_pk IN (206,207,208,209)";
                                             $sql.=" group by ndp.propostas_pk";
                                             
                                             $result5 = mysql_query($sql);
                                             $tl_em_analise = "0";
                                             while($row5 = mysql_fetch_array($result5)){
                                               $tl_em_analise  = ($tl_em_analise + $row5['total']);
                                             }
                                            if(!empty($tl_em_analise)){
                                               $tg_em_analise  = ($tg_em_analise + $tl_em_analise); 
                                               echo "<td align='center' class='form' >"; 
                                               echo $tl_em_analise;
                                               echo "</td>";
                                            }else{
                                               echo "<td align='center' class='form' >"; 
                                               echo "0"; 
                                               echo "</td>";
                                            }
                                            mysql_free_result($result5);
                                            //REPROVADOS
                                            $sql ="";
                                            $sql.="SELECT nip.n_qtde total
                                                     FROM n_datas_proposta ndp
                                                          INNER JOIN n_propostas np ON ndp.propostas_pk = np.pk
                                                          INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                          INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                    WHERE     l.CodStatusClassificacaoLead >= 12
                                                          AND np.dt_cancelamento IS NULL";
                                             $sql.="      AND l.CodGerenteConta =".$row['codusuariointerno'];
                                             $sql.="      AND ndp.data_proposta_operador_pk IN (204,210,211,216,212,213,214,215)";
                                            
                                             $result5 = mysql_query($sql);
                                             $tl_reprovado = "0";
                                             while($row5 = mysql_fetch_array($result5)){
                                               $tl_reprovado  = ($tl_reprovado + $row5['total']);
                                             }
                                            if(!empty($tl_reprovado)){
                                              $tg_reprovado  = ($tg_reprovado + $tl_reprovado); 
                                               echo "<td align='center' class='form' >"; 
                                               echo $tl_reprovado;
                                               echo "</td>";
                                            }else{
                                               echo "<td align='center' class='form' >"; 
                                               echo "0"; 
                                               echo "</td>";
                                            }
                                            mysql_free_result($result5);
                                            
                                            
                                        
                                        }
                                            
                                            echo "<td align='center' class='form' >";
                                                if($row2['CodStatusClassificacaoLead']==1 or $row2['CodStatusClassificacaoLead']==2 or $row2['CodStatusClassificacaoLead']==3){
                                                    $sql ="";
                                                    $sql.="SELECT scl.descricao, count(*) total
                                                            FROM statusclassificacaolead scl
                                                                 INNER JOIN leads l
                                                                    ON l.codstatusclassificacaolead = scl.codstatusclassificacaolead
                                                           WHERE l.codgerenteconta=".$row['codusuariointerno'];
                                                    $sql.="  and l.CodStatusClassificacaoLead=".$row2['CodStatusClassificacaoLead'];
                                                    if(!empty($dt_periodo_de)){
                                                        $sql.="  and l.datacadastro >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                                    }
                                                    if(!empty($dt_periodo_ate)){
                                                        $sql.="  and l.datacadastro <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                                    }
                                                    $sql.="      GROUP BY scl.descricao";
                                                     
                                                    $result3 = mysql_query($sql);
                                                    $row3 = mysql_fetch_array($result3);
                                                    
                                                    if(!empty($row3['total'])){
                                                        
                                                        if($row2['CodStatusClassificacaoLead']==1){
                                                           echo $row3['total'];                                                        
                                                            $t_linha = ($t_linha + $row3['total']); 
                                                           $tl_si = ($tl_si + $row3['total']);   
                                                        }
                                                        if($row2['CodStatusClassificacaoLead']==2){  
                                                           echo $row3['total'];                                                        
                                                           $t_linha = ($t_linha + $row3['total']); 
                                                           $tl_tg = ($tl_tg + $row3['total']);
                                                        }
                                                        if($row2['CodStatusClassificacaoLead']==3){ 
                                                          echo $row3['total'];                                                        
                                                          $t_linha = ($t_linha + $row3['total']);  
                                                          $tl_0  = ($tl_0 + $row3['total']); 
                                                        }                                                       
                                                        
                                                    }else{
                                                        echo "0";
                                                    }
                                                    mysql_free_result($result3);
                                                }elseif ($row2['CodStatusClassificacaoLead']==4) {
                                                    
                                                    $sql ="";
                                                    $sql.="SELECT scl.descricao, count(*) total
                                                            FROM statusclassificacaolead scl
                                                                 INNER JOIN leads l ON l.codstatusclassificacaolead = scl.codstatusclassificacaolead
                                                                 INNER JOIN agendaslead a on l.codlead = a.codlead
                                                           WHERE l.codgerenteconta=".$row['codusuariointerno'];
                                                    $sql.="  and l.CodStatusClassificacaoLead=".$row2['CodStatusClassificacaoLead'];
                                                    
                                                    if(empty($dt_periodo_de)){
                                                        $sql.="  and a.datacadastro >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                                    }
                                                    if(!empty($dt_periodo_ate)){
                                                        $sql.="  and a.datacadastro <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                                    }
                                                    $sql.="      GROUP BY scl.descricao";
                                                     
                                                    $result3 = mysql_query($sql);
                                                    $row3 = mysql_fetch_array($result3);
                                                    if(!empty($row3['total'])){    
                                                        if($row2['CodStatusClassificacaoLead']==4){
                                                           echo $row3['total'];
                                                           $t_linha = ($t_linha + $row3['total']);
                                                           $tl_25 = ($tl_25 + $row3['total']);   
                                                        }
                                                    }else{
                                                        echo "0";
                                                    }
                                                    mysql_free_result($result3);
                                                }elseif ($row2['CodStatusClassificacaoLead']==5 or $row2['CodStatusClassificacaoLead']==6 or $row2['CodStatusClassificacaoLead']==10 or $row2['CodStatusClassificacaoLead']==12 or $row2['CodStatusClassificacaoLead']==15){
                                                    $sql ="";
                                                    $sql.="SELECT sum(nip.n_qtde) total
                                                                FROM n_propostas np
                                                                     INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                                                                     INNER JOIN n_produtos npr
                                                                        ON nip.produtos_pk = npr.pk AND npr.produtos_tipo_pk = 1
                                                                     INNER JOIN leads l ON np.leads_pk = l.CodLead
                                                                     INNER JOIN n_datas_proposta ndp ON np.pk = ndp.propostas_pk
                                                               WHERE l.CodStatusClassificacaoLead =".$row2['CodStatusClassificacaoLead'];
                                                    $sql.="           AND l.CodGerenteConta =".$row['codusuariointerno'];                                                        
                                                    $sql.="            AND ndp.data_proposta_operador_pk = (Select n_data_proposta_operador.pk from n_data_proposta_operador where n_data_proposta_operador.operador_pk=2 and n_data_proposta_operador.dt_cancelamento is null and n_data_proposta_operador.statusclassificacaolead_pk=".$row2['CodStatusClassificacaoLead'].")";                                                            
                                                    $sql.="            AND  np.dt_cancelamento IS NULL";
                                                    if(!empty($dt_periodo_de)){
                                                        $sql.="  and ndp.vl_data_proposta >= '".DataYMD($dt_periodo_de)." 00:00:00' ";
                                                    }
                                                    if(!empty($dt_periodo_ate)){
                                                        $sql.="  and ndp.vl_data_proposta <= '".DataYMD($dt_periodo_ate)." 23:59:59' ";
                                                    }
                                                   
                                                    $result4 = mysql_query($sql);
                                                    $row4 = mysql_fetch_array($result4);
                                                    if(!empty($row4['total'])){                                                          
                                                        if($row2['CodStatusClassificacaoLead']==5){
                                                           echo $row4['total']; 
                                                           $t_linha = ($t_linha + $row4['total']);
                                                           $tl_50 = ($tl_50 + $row4['total']);   
                                                        }
                                                        if($row2['CodStatusClassificacaoLead']==6){
                                                           echo $row4['total']; 
                                                           $t_linha = ($t_linha + $row4['total']);
                                                           $tl_75 = ($tl_75 + $row4['total']);   
                                                        }
                                                        if($row2['CodStatusClassificacaoLead']==10){
                                                           echo $row4['total'];
                                                           $t_linha = ($t_linha + $row4['total']);
                                                           $tl_80 = ($tl_80 + $row4['total']);   
                                                        }
                                                        if($row2['CodStatusClassificacaoLead']==12){
                                                           echo $row4['total']; 
                                                           $t_linha = ($t_linha + $row4['total']);
                                                           $tl_90 = ($tl_90 + $row4['total']);
                                                        }                                                         
                                                        if($row2['CodStatusClassificacaoLead']==15){
                                                           echo $row4['total']; 
                                                           $t_linha = ($t_linha + $row4['total']);
                                                           $tl_cli = ($tl_cli + $row4['total']);   
                                                        }
                                                    }else{
                                                        echo "0";
                                                    }
                                                    mysql_free_result($result4);
                                                }
                                            echo "</td>";
                                        }
                                        mysql_free_result($result2);
                                        $total_g = ($total_g + $t_linha);
                                    ?>
                                    <td align='center' class='form'>
                                        <?
                                            echo $t_linha;
                                            $t_linha = "0";
                                        ?>
                                    </td>
                                </tr>  
                             
                            <?}
                        echo    "<tr>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>Total</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_si."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_tg."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_0."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_25."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_50."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_75."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_80."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_90."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tg_aprovado."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tg_em_analise."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tg_reprovado."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$tl_cli."</td>";
                        echo        "<td class='titulo' bgcolor='#8080FF'>".$total_g."</td>";
                        echo    "</tr>";     
                        echo "</table>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo " <td>";
        echo "            &nbsp;";
        echo "        </td>";
        echo "    </tr>";
    }
	?>    


    </table>        
</body>
</html>


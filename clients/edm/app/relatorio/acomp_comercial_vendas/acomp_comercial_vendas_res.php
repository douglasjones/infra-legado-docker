<?
$excel = $_REQUEST['excel'];
if($excel == "S"){
	$arquivo = 'planilha.xls';
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}
include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;
include_once( "../../libs/cla.equipes.php" ) ;


//PARAMTROS DE PESQUISA
$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codatendente = $_REQUEST['codatendente'];
$dtrecebpedidode = $_REQUEST['dtrecebpedidode'];
$dtrecebpedidoate = $_REQUEST['dtrecebpedidoate'];
$ativacaode = $_REQUEST['dtativacaode'];
$ativacaoate = $_REQUEST['dtativacaoate'];
$cod_operador = $_REQUEST['cod_operador'];
$npedido = $_REQUEST['numpvc'];

//$dtentreagade = $_REQUEST['dtentreagade'];
//$dtentreagaate = $_REQUEST['dtentreagaate'];

//FUNCAO BUSCA QTDE DE LINHAS
function linhas($strVariavel, $codlead, $codproposta, $codversao,$id){
	$sql ="";
    $sql ="select mp.id, (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) total,mpr.rotulo ";
    $sql.="  from modulosproposta mp ";
    $sql.="  inner join modulosproduto mpr on mp.id = mpr.ID ";
	$sql.=" where mp.codlead = ".$codlead;
	$sql.="   AND mp.codproposta = ".$codproposta;
	$sql.="   AND mp.versao = ".$codversao;
    $sql.="   AND mpr.rotulo is not null ";
    $sql.="   AND mp.id=' ".$id."'";		
	$sql.="   AND  (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) > 0 " ;
    $sql.="   AND mpr.rotulo like '%".$strVariavel."'";
    
	$rs_variavel = mysql_query($sql);
	while($row_variavel = mysql_fetch_array($rs_variavel)){
		$strRetorno = $row_variavel['total'];
	}
	mysql_free_result($rs_variavel);
	return $strRetorno;
}
//BUSCA VALOR
    function valor($rotulo, $codlead, $codproposta, $codversao){

	$sql ="";
    $sql ="select (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) calculado ";
    $sql.="  from modulosproposta mp ";
    $sql.="  inner join modulosproduto mpr on mp.id = mpr.ID ";
	$sql.=" where mp.codlead = ".$codlead;
	$sql.="   AND mp.codproposta = ".$codproposta;
	$sql.="   AND mp.versao = ".$codversao;
    $sql.="   AND mpr.rotulo='".$rotulo."'";	
    
	$rs_var = mysql_query($sql);
	while($row_var = mysql_fetch_array($rs_var)){		    
		$idRetorno = $row_var['calculado'];            
	}
	mysql_free_result($rs_var);
	return $idRetorno;
} 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<table cellspacing="0" cellpadding="0" align="left" border="0">	
<tr>
	<td class="form" align="center">
		<font size="+2">Acompanhamento 80% 90% e Cliente</font>
	</td>
</tr>
</table>
<br>
<br>
<table width="50%" border="0" cellpadding="0" cellspacing="0" class='form'>
	<tr>
    	<td class="parametros">
			Parâmetros 
		</td>
	</tr>
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
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['cod_polo'])){
			$sql = "Select 
    				p.cod_polo
					,p.n_polo
					 from polo p";
			$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
			$sql .= " Order By p.n_polo ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>			
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codatendente)){
			$sql = "select nome from usuariosinternos where codusuariointerno= $codatendente ";
			$q = mysql_query($sql);
			echo "Atendente: ";
			while($row = mysql_fetch_array($q)){
				echo $row['nome']." ";
			}
			mysql_free_result($q);
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codgerenteconta)){
			$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
			$q = mysql_query($sql);
			echo "Consultor: ";
			while($row = mysql_fetch_array($q)){
				echo $row['nome']." ";
			}
			mysql_free_result($q);
		}
		?>
		</td>
	</tr>							
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codequipe'])){
			$sql = "Select Vc_Nome from tb_equipesvendas where Tk_Equipe = ".$_REQUEST['codequipe'];
			$q = mysql_query($sql);
			$equipe = mysql_fetch_array($q);
			echo "Equipe: ".$equipe['Vc_Nome'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['numpvc'])){
		
			echo "Número Pedido: ".$npedido;
		}
		?>
		</td>
	</tr>    
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['cod_operador'])){
			$sql = "Select dsc_operador from operador where cod_operador = ".$_REQUEST['cod_operador'];
			$q = mysql_query($sql);
			$operador = mysql_fetch_array($q);
			echo "Operadora: ".$operador['dsc_operador'];
		}
		?>
		</td>
	</tr>
	<?	
	if(!empty($dtrecebpedidode)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Recebimento Pedido:&nbsp;<?=date('d/m/Y', strtotime(dataYMD($dtrecebpedidode)));?> até <?=date('d/m/Y', strtotime(dataYMD($dtrecebpedidoate)));?></dt>
		</td>
	</tr>
	<?	
	}
	?>
	<?	
	if(!empty($ativacaode)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Ativação:&nbsp;<?=date('d/m/Y', strtotime(dataYMD($ativacaode)));?> até <?=date('d/m/Y', strtotime(dataYMD($ativacaoate)));?></dt>
		</td>
	</tr>
	<?	
	}
	?>    
</table>
<br />  
	<?   
    $sql =" ";
    $sql.="SELECT date_format(np.dt_cadastro, '%d/%m/%Y') datacadastroproposta,
				   scl.descricao statuslead,
				   l.razaosocial,
				   ui.nome gerenteconta,
				   ui1.nome atendente,
				   l.codlead,
				   np.pk propostas_pk,             
				   nip.produtos_pk,
				   op.dsc_operador,
				   npa.aparelhos_pk
			  FROM leads l
				   INNER JOIN statusclassificacaolead scl
					  ON l.codstatusclassificacaolead = scl.codstatusclassificacaolead
				   LEFT JOIN usuariosinternos ui
					  ON l.codgerenteconta = ui.codusuariointerno
				   LEFT JOIN usuariosinternos ui1
					  ON l.codatendente = ui1.codusuariointerno
				   INNER JOIN n_propostas np ON np.leads_pk = l.codlead
				   LEFT join n_itens_propostas nip on np.pk = nip.propostas_pk
				   LEFT JOIN n_produtos npr ON npr.pk = nip.produtos_pk
				   LEFT JOIN n_combos nc ON nc.pk  = nip.combos_pk
				   LEFT JOIN n_propostas_aparelhos npa ON np.pk = npa.propostas_pk
				   LEFT JOIN n_aparelhos nap ON nap.pk = npa.aparelhos_pk";
				   if(!empty($cod_operador)){
						$sql.=" LEFT JOIN operador op ON npr.operador_pk = op.cod_operador or nc.operador_pk = op.cod_operador OR op.cod_operador = nap.operador_pk and op.cod_operador=".$cod_operador;
				   }
		
	 
     if(!empty($dtrecebpedidode)){
		$sql.="  INNER JOIN n_datas_proposta ndp  ON ( ndp.propostas_pk = np.pk             
                AND ndp.data_proposta_operador_pk in (select pk from n_data_proposta_operador where ds_label_data='recebe_assinatura'))";
	}

    
	if(!empty($ativacaode)){
        $sql.="  INNER JOIN n_datas_proposta ndp  ON ( ndp.propostas_pk = np.pk             
                AND ndp.data_proposta_operador_pk in (select pk from n_data_proposta_operador where ds_label_data='entrega_aparelho'))";
	}
    

		
	$sql.=" where np.dt_cancelamento IS NULL 
            And l.CodStatusClassificacaoLead in (10,12,15)";
            
    if(!empty($dtrecebpedidode)){
		$sql.=" and (ndp.vl_data_proposta between '".DataYMD($dtrecebpedidode)."' and '".DataYMD($dtrecebpedidoate)."' ) ";
	}
            
	if(!empty($ativacaode)){
		$sql.=" and (ndp.vl_data_proposta between '".DataYMD($ativacaode)."' and '".DataYMD($ativacaoate)."' ) ";
	}

	
    //numero do pedido = 
	if(!empty($npedido)){
		$sql.=" and p.NumPVC=".$npedido;
	}   
	//parametros de pesquisa
	if(!empty($_REQUEST['cod_polo'])){
		$sql.="  and l.cod_polo =".$_REQUEST['cod_polo'];
	}	
	if(!empty($codequipe)){
		$sql.="  and l.codgerenteconta in (";
		$sql.=" select e.fk_usuario ";
		$sql.="   from tb_usuarioequipe e ";
		$sql.="  where fk_equipe = $codequipe ) ";
	}
	
	if(!empty($codgerenteconta)){
		$sql.=" and l.codgerenteconta = $codgerenteconta ";
	}
	if(!empty($codatendente)){
		$sql.=" and l.codatendente = $codatendente ";   
     } 
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs')){
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	}	
		
	if(!permissao('visualizar_todos_atendentes', 'cs')){
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";  
	}
    $sql.=" and npr.produtos_tipo_pk=1";
	$sql.=" GROUP BY np.pk";
	
    $result = mysql_query($sql);
	
	$cont = 1;
    $totalvalor = 0;
    $totalnegocios = 0;
    $total_linhas = 0; 
	while($row = mysql_fetch_array($result)){
	        
            //DATA ATIVACAO            
			$sql ="";
			$sql.="Select
						ndpo.ds_data,
						date_format(ndp.vl_data_proposta, '%d/%m/%Y') data
					from n_datas_proposta ndp
						inner join n_data_proposta_operador ndpo on ndp.data_proposta_operador_pk = ndpo.pk";
			$sql.="	where ndp.propostas_pk=".$row['propostas_pk'];
			$sql.="	AND ndp.data_proposta_operador_pk in (select pk from n_data_proposta_operador where ds_label_data='cliente')";
			            
			$rs_data = mysql_query($sql);
			$dataenvio = "";
			while($row_data = mysql_fetch_array($rs_data)){
			  $totalnegocios ++; 
            }
            
            mysql_free_result($rs_data);
            $sql = "";
           
				$sql.="SELECT nip.pk,
						   nip.dt_cadastro,						   
						   nip.vl_unitario,
						   nip.n_qtde,
						   npr.ds_produto,
						   nc.ds_combo,
						   npt.ds_tipo_produto,
						   nipo.vl_franquia,
						   nipo.tipo_linha_pk
					  FROM n_itens_propostas nip
						   LEFT JOIN n_produtos npr ON nip.produtos_pk = npr.pk
						   LEFT JOIN n_combos nc ON nip.combos_pk = nc.pk
						   LEFT JOIN n_produtos_tipo npt ON npr.produtos_tipo_pk = npt.pk
						   LEFT JOIN n_itens_propostas_operadoras nipo ON nipo.itens_propostas_pk = nip.pk
					 WHERE nip.propostas_pk=".$row['propostas_pk'];	
                $sql.=" and npr.produtos_tipo_pk=1";
				/*$sql.=" Union
						SELECT npa.pk,
						   npa.dt_cadastro,
						   npa.vl_unitario,
						   npa.n_qtde,
						   na.ds_aparelho,
						   '' ds_combo,
						   'Aparelhos' ds_tipo_produto,
						   '' vl_franquia,
						   '' tipo_linha_pk
					  FROM n_propostas_aparelhos npa
						   LEFT JOIN n_aparelhos na ON npa.aparelhos_pk = na.pk
					 WHERE npa.propostas_pk =".$row['propostas_pk'] ;*/

    		$rs_mp = mysql_query($sql);   
            $valor = 0; 
                   
    		while($row_mp = mysql_fetch_array($rs_mp)){    		 
;					$ativacao = "";
                    $totalvalor = $totalvalor + ($row_mp['vl_franquia']+($row_mp['vl_unitario']*$row_mp['n_qtde']))    ;           
					$total_linhas = $total_linhas + $row_mp['n_qtde'];
					
                    $html.="<tr>";
                	$html.="<td class='form' align='center'>".($cont++)."</td>";
        			$html.="<td class='form' align='center'>".$row['codlead']."</td>";
        			$html.="<td class='form' align='center'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
        			$html.="<td class='form' align='center'>".$row['gerenteconta']."</td>";
        			$html.="<td class='form' align='center'>".$row['atendente']."</td>";
                   //DATA PEDIDO
        			$sql ="";
        			$sql.="Select
								ndpo.ds_data,
								date_format(ndp.vl_data_proposta, '%d/%m/%Y') data
						from n_datas_proposta ndp
						inner join n_data_proposta_operador ndpo on ndp.data_proposta_operador_pk = ndpo.pk";
					$sql.="	where ndp.propostas_pk=".$row['propostas_pk'];
					$sql.="	AND ndp.data_proposta_operador_pk in (select pk from n_data_proposta_operador where ds_label_data='recebe_assinatura')";
                    
                    
        			$rs_dt = mysql_query($sql);
        			$dtpedido = "";
        			while($row_dt = mysql_fetch_array($rs_dt)){        				
        			         $dtpedido = $row_dt['data'];        				
        			}                            
        			mysql_free_result($rs_dt);
        			$html.="<td class='form' align='center'>&nbsp;".$dtpedido."&nbsp;</td>";
                    
                    //DATA ATIVACAO
        			$sql ="";
        			$sql.="Select
								ndpo.ds_data,
								date_format(ndp.vl_data_proposta, '%d/%m/%Y') data
							from n_datas_proposta ndp
								inner join n_data_proposta_operador ndpo on ndp.data_proposta_operador_pk = ndpo.pk";
					$sql.="	where ndp.propostas_pk=".$row['propostas_pk'];
					$sql.="	AND ndp.data_proposta_operador_pk in (select pk from n_data_proposta_operador where ds_label_data='entrega_aparelho')";
                    
        			$rs_data = mysql_query($sql);
        			$dataenvio = "";
        			while($row_data = mysql_fetch_array($rs_data)){        				
        			   $ativacao = $row_data['data'];         			   
        			   if($row_mp['ds_tipo_produto']=="Voz"){
							$t_voz = $t_voz + number_format(($row_mp['vl_franquia']+($row_mp['vl_unitario']*$row_mp['n_qtde'])),2);
					   }
        			   if($row_mp['ds_tipo_produto']=="Dados"){
							$t_dados = $t_dados + number_format(($row_mp['vl_unitario']*$row_mp['n_qtde']),2);
					   }  
					   if($row_mp['ds_combo']=="Combos"){
							$t_combos = $t_combos + number_format(($row_mp['vl_unitario']*$row_mp['n_qtde']),2);							
					   }    
					   if($row_mp['ds_tipo_produto']=="Modulos"){
							$t_modulos = $t_modulos + number_format(($row_mp['vl_unitario']*$row_mp['n_qtde']),2);
					   }
					   if($row_mp['ds_tipo_produto']=="Aparelhos"){
							$t_aparelhos = $t_aparelhos + number_format(($row_mp['vl_unitario']*$row_mp['n_qtde']),2);
					   }
					    			                       
        			}                            
        			mysql_free_result($rs_data);
        			$html.="<td class='form' align='center'>&nbsp;".$ativacao."&nbsp;</td>";        			
                    $html.="<td class='form' align='center'>".$row['npedidooperadora']."</td>";			
        			$html.="<td class='form' align='center'>".$row['propostas_pk']."</td>";  
                    $html.="<td class='form' align='center'>".$row['dsc_operador']."</td>"; 
                    if(!empty($row_mp['ds_produto'])){              
						$html.="<td class='form' align='center'>".$row_mp['ds_produto']."</td>";
					}else{
						$html.="<td class='form' align='center'>".$row_mp['ds_combo']."</td>";
					}	
					if(!empty($row_mp['ds_tipo_produto'])){
						$html.="<td class='form' align='center'>".$row_mp['ds_tipo_produto']."</td>";    
					}else{
						$html.="<td class='form' align='center'>Combo</td>";    
					}
					$html.="<td class='form' align='center'>".$row_mp['n_qtde']."</td>"; 	
					$html.="<td class='form' align='right'>".number_format(($row_mp['vl_franquia']+($row_mp['vl_unitario']*$row_mp['n_qtde'])),2)."&nbsp;</td>";              
                    //LINHAS 
                    
                    if(!empty($row_mp['tipo_linha_pk'])){
						$sql = "";
						$sql .= "SELECT 
									nptl.dsc_tipo_linha
								  FROM n_produto_tipo_linha nptl
								 WHERE nptl.pk =".$row_mp['tipo_linha_pk'];    
						
						$rs_tipo_linhas = mysql_query($sql);		
						$row_li = mysql_fetch_array($rs_tipo_linhas);
						$ds_tipo_linha = $row_li['dsc_tipo_linha'];                
					}
                     
                    if(!empty($row_mp['tipo_linha_pk'])){
						if(!empty($ativacao)){
							$total_li_ativas = $total_li_ativas + $row_mp['n_qtde'];   
						}
						if($ds_tipo_linha=="LI Novas"){                        
							$html.="<td class='form' align='center'>".$row_mp['n_qtde']."</td>";
							$qtde_lin = $qtde_lin + $row_mp['n_qtde']; 
						}else{
							$html.="<td class='form' align='center'>&nbsp</td>";
						}	
                        if($ds_tipo_linha=="LI Adição"){                        
							$html.="<td class='form' align='center'>".$row_mp['n_qtde']."</td>";
							$qtde_liad = $qtde_liad + $row_mp['n_qtde']; 
						}else{
							$html.="<td class='form' align='center'>&nbsp</td>";
						}
						if($ds_tipo_linha=="LI Portabilidade"){                        
							$html.="<td class='form' align='center'>".$row_mp['n_qtde']."</td>";
							$qtde_lip = $qtde_lip + $row_mp['n_qtde'];
						}else{
							$html.="<td class='form' align='center'>&nbsp</td>";
						}
						if($ds_tipo_linha=="LI Renovação"){                        
							$html.="<td class='form' align='center'>".$row_mp['n_qtde']."</td>";
							$qtde_lir = $qtde_lir + $row_mp['n_qtde'];
						}else{
							$html.="<td class='form' align='center'>&nbsp</td>";
						}
						if($ds_tipo_linha=="LI Migração"){                        
							$html.="<td class='form' align='center'>".$row_mp['n_qtde']."</td>";
							$qtde_lim = $qtde_lim + $row_mp['n_qtde'];
						}else{
							$html.="<td class='form' align='center'>&nbsp</td>";
						}
						if($ds_tipo_linha=="LI Transferência"){                        
							$html.="<td class='form' align='center'>".$row_mp['n_qtde']."</td>";
							$qtde_lit = $qtde_lit + $row_mp['n_qtde'];
						}else{
							$html.="<td class='form' align='center'>&nbsp</td>";
						}
                    }else{
                        $html.="<td class='form' align='center'>&nbsp</td>";
                        $html.="<td class='form' align='center'>&nbsp</td>";
                        $html.="<td class='form' align='center'>&nbsp</td>";
                        $html.="<td class='form' align='center'>&nbsp</td>";
                        $html.="<td class='form' align='center'>&nbsp</td>";
                        $html.="<td class='form' align='center'>&nbsp</td>";                                                   
                    }                    
                    $html.="<td class='form' align='center'>".$row['statuslead']."</td>";
                                             
                    $html.="</tr>";	
            }	
	}
	mysql_free_result($result);
	?>
<table width="400" border="0" cellpadding="0" cellspacing="0" class='form'>
    <tr>
        <td colspan="2">
            &nbsp;
        </td>
    </tr>
   <!-- <tr>
        <td colspan="2">
            <font size="+1">Resumo Ativações *</font>
        </td>
    </tr>
    <tr>
        <td>
           <!-- <table width="100%" border="1" cellpadding="0" cellspacing="0" class='form'>    
                <tr>
                    <td align="center" class=titulo bgcolor=#8080FF >
                        <b>Descrição</b
                    </td>
                    <td align="center" class=titulo bgcolor=#8080FF>
                        <b>Valor</b>
                    </td>
                    <td align="center" class=titulo bgcolor=#8080FF>
                        <b>Média **</b>
                    </td>                    
                </tr>
                <tr>
                    <td width="150">
                        &nbsp;Valor Total 
                    </td>
                    <td align="right">
                        &nbsp;<b>R$ <?=number_format($totalvalor,2);?></b>
                    </td>
                    <td align="right">						
                        &nbsp;<?=number_format(($totalvalor/ $totalnegocios),2);?>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;Total de Linhas
                    </td>
                    <td align="right">
                        &nbsp;<b><?=$total_li_ativas;?></b>
                    </td>
                    <td align="right">
                        &nbsp;<?if(!empty($total_li_ativas)){
                                    echo ($total_li_ativas  / $totalnegocios );
                                   }?>
                    </td>
                </tr> 
                <tr>
                    <td>
                        &nbsp;Valor Total Voz
                    </td>
                    <td align="right">
                        &nbsp;<b>R$ <?=number_format($t_voz,2);?></b>
                    </td>
                    <td align="right">
                        &nbsp;<?= @number_format( ($t_voz / $totalnegocios) , 2 , ',' , '.' ) ;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;Valor Total Combos
                    </td>
                    <td align="right">
                        &nbsp;<b>R$ <?=number_format($t_combos,2);?></b> 
                    </td>
                    <td align="right">
                        &nbsp;<?= @number_format( ($t_combos / $totalnegocios) , 2 , ',' , '.' ) ;?>
                    </td>
                </tr> 
                <tr>
                    <td>
                        &nbsp;Valor Total Dados
                    </td>
                    <td align="right">
                        &nbsp;<b>R$ <?=number_format($t_dados,2);?></b> 
                    </td>
                    <td align="right">
                        &nbsp;<?= @number_format( ($t_dados / $totalnegocios) , 2 , ',' , '.' ) ;?>
                    </td>
                </tr>                 
                <tr>
                    <td>
                        &nbsp;Valor Total Modulos
                    </td>
                    <td align="right">
                        &nbsp;<b>R$ <?=number_format($t_modulos,2);?></b>
                    </td>
                    <td align="right">
                        &nbsp;<?= @number_format( ($t_modulos / $totalnegocios) , 2 , ',' , '.' ) ;?>
                    </td>
                </tr>
                <?if($cod_operador=-3){?>
                    <tr>
                        <td>
                            &nbsp;Valor Total Aparelhos
                        </td>
                        <td align="right">
                            &nbsp;<b>R$ <?=number_format($t_aparelhos,2);?></b>
                        </td>
                        <td align="right">
                            &nbsp;<?= @number_format( ($t_aparelhos/ $totalnegocios) , 2 , ',' , '.' ) ;?>
                        </td>
                    </tr>
                <?}?>  
                <tr>
                    <td>
                        &nbsp;Total de Negocios
                    </td>
                    <td align="right">
                        &nbsp;<b><?=$totalnegocios;?></b>
                    </td>
                    <td align="right">
                        &nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            * Resumo com base nas proposta com <b>Data de Ativação</b>.
        </td>
    </tr>
    <tr>
        <td colspan="3">
            ** Média aritimética onde o denominador é o <b>Total de Negócios</b>.
        </td>
    </tr>     -->
    <tr>
        <td colspan="20">
            &nbsp;
        </td>
    </tr>     
    <!--<tr>
        <td colspan="20">
            <font size="+1">Vendas por Produto</font>
        </td>
    </tr> -->
                                 
</table>  
<table  cellspacing="0" cellpadding="0" align="center" border="1" width="2100" class="sortable">

	<thead>
		<tr>
			<td class="titulo" bgcolor="#8080FF">#</td>
			<td class="titulo" bgcolor="#8080FF">Cód Lead</td>
			<td class="titulo" bgcolor="#8080FF">Lead</td>
			<td class="titulo" bgcolor="#8080FF">Consultor</td>
			<td class="titulo" bgcolor="#8080FF">Atendente</td>
			<td class="titulo" bgcolor="#8080FF">Dt Receb Pedido</td>
			<td class="titulo" bgcolor="#8080FF">Dt Ativação</td>
            <td class="titulo" bgcolor="#8080FF">N Pedido</td>			
			<td class="titulo" bgcolor="#8080FF">Proposta</td>
            <td class="titulo" bgcolor="#8080FF">Operadora</td>
            <td class="titulo" bgcolor="#8080FF">Produto</td>
            <td class="titulo" bgcolor="#8080FF">Tipo</td>
            <td class="titulo" bgcolor="#8080FF">Qtde</td>
            <td class="titulo" bgcolor="#8080FF">Valor</td>
			<td class="titulo" bgcolor="#8080FF">Li Novas</td>
			<td class="titulo" bgcolor="#8080FF">Li Adição</td>
			<td class="titulo" bgcolor="#8080FF">Li Portabilidade</td>
			<td class="titulo" bgcolor="#8080FF">Li Renovação</td>
		    <td class="titulo" bgcolor="#8080FF">Li Migração</td>
			<td class="titulo" bgcolor="#8080FF">Li Transferência</td>
			<td class="titulo" bgcolor="#8080FF">Status</td>
		</tr>
	</thead>
	<tbody>  
        <?=$html;?>  
	</tbody>
	<tfoot>
		<tr class="link_cinza"  >
			<td align="center" class="titulo" bgcolor="#8080FF" colspan="12">&nbsp;</td>
            <td align="center" class="titulo" bgcolor="#8080FF" ><?=$total_linhas;?></td>
            <td align="center" class="titulo" bgcolor="#8080FF" ><?=number_format($totalvalor,2);?></td>
            <td align="center" class="titulo" bgcolor="#8080FF" ><?=$qtde_lin;?></td>
            <td align="center" class="titulo" bgcolor="#8080FF" ><?=$qtde_liad;?></td>
            <td align="center" class="titulo" bgcolor="#8080FF" ><?=$qtde_lip;?></td>
            <td align="center" class="titulo" bgcolor="#8080FF" ><?=$qtde_lir;?></td>
            <td align="center" class="titulo" bgcolor="#8080FF" ><?=$qtde_lim;?></td>
            <td align="center" class="titulo" bgcolor="#8080FF" ><?=$qtde_lit;?></td>
            <td align="center" class="titulo" bgcolor="#8080FF" >&nbsp;</td>    
		</tr>
	</tfoot>
</table>

</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

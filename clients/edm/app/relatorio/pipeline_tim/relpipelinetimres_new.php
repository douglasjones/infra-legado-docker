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

$tipo_linha = $_REQUEST['tipo_linha_pk'];

for($i = 0; $i<count($tipo_linha);$i++){
        
    $tipo_linha.=$tipo_linha[$i].", ";
}
$tipo_linha_pk.="0";

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
		<td class="form"><font size="4">Relatório Pipeline TIM</font></td>
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
			Data da criação da Oportunidade
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Mês - Previsão Fechamento
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Regional
		</th>	
		<th class="titulo" bgcolor="#8080FF">
			Território
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Gerência
		</th>		
		<th class="titulo" bgcolor="#8080FF">
			Executivo Responsável
		</th>  
		<th class="titulo" bgcolor="#8080FF">
			Parceiro (Razão Social)
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Vendedor TBP
		</th>		
		<th class="titulo" bgcolor="#8080FF">
			Razão Social Empresa (Cliente)
		</th>		
        <th class="titulo" bgcolor="#8080FF">
			VOZ
		</th>	
        <th class="titulo" bgcolor="#8080FF">
			WEB
		</th>	
         <th class="titulo" bgcolor="#8080FF">
			TOTAL
		</th>
        <th class="titulo" bgcolor="#8080FF">
			Observações da Oportunidade
		</th>        
         <th class="titulo" bgcolor="#8080FF">
			Código do Status
		</th>	
        <th class="titulo" bgcolor="#8080FF">
			Probabilidade em %
		</th>	
        <th class="titulo" bgcolor="#8080FF">
			Razão pelo Sucesso ou Perda
		</th>	
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
   		$where.=" and np.operador_pk =".$cod_operador;
   	}
    
     if(!empty($_REQUEST['tipo_linha_pk']))	{	
		$sql .= " and nipo.tipo_linha_pk in( ".$tipo_linha.")";
	}       
    
	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$where.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
	

	$sql = "Select 
                 ui.Nome Consultor,
                 tbe.Vc_Nome Equipe,
				 l.codlead, 
				 l.razaosocial,
                 date_format(l.datacadastro,'%d/%m/%Y') dt_cadastro,
				 date_format(l.dt_ult_ocorrencia,'%d/%m/%Y') dt_ult_oc,
                 date_format(np.dt_cadastro,'%d/%m/%Y') dt_cad_proposta,
                 np.pk cod_proposta,
                 m.dsc_mailing Mailing,
				 sc.descricao status,
                 np.vl_total_proposta,
                 ntl.dsc_tipo_linha,
                 l.codgerenteconta,
                 o.dsc_operador,
                 l.codstatusclassificacaolead,
                 l.codmotivo
			from leads l 
				  inner join statusclassificacaolead sc on l.codstatusclassificacaolead = sc.codstatusclassificacaolead
				  LEFT JOIN n_propostas np ON l.CodLead = np.leads_pk and np.dt_cancelamento is null	
                  LEFT JOIN n_itens_propostas nip on np.pk = nip.propostas_pk
                  LEFT JOIN n_itens_propostas_operadoras nipo on nip.pk = nipo.itens_propostas_pk
                  LEft JOIN n_produto_tipo_linha ntl on nipo.tipo_linha_pk = ntl.pk
				  INNER JOIN usuariosinternos ui  ON   l.CodGerenteConta = ui.CodUsuarioInterno AND ui.GerenteContas = '1' AND ui.Desativado = '-1'	
                  LEFT JOIN mailing m ON l.mailing_pk = m.pk
                  LEFT JOIN tb_usuarioequipe tbu ON ui.CodUsuarioInterno = tbu.Fk_Usuario
                  LEFT JOIN tb_equipesvendas tbe ON tbu.Fk_Equipe = tbe.Tk_Equipe
                  LEFT join operador o on np.operador_pk = o.cod_operador
			where 1=1
            and l.codstatusclassificacaolead not in (2,3)";
	$sql.=$where;
	$sql.=" group by l.codlead,np.pk";

	$result = mysql_query($sql);
    

	while($row = mysql_fetch_array($result)){
		echo "<tr>";
            echo "<td align='center' class='form'>&nbsp;".$row['dt_cadastro']."&nbsp;</td>";           
            if(!empty($row['cod_proposta'])){
                $sql = "";
                $sql.="Select
                        date_format(ndp.vl_data_proposta, '%d/%m/%Y') dt_prev_fechamento
                        from n_datas_proposta ndp
                        where ndp.propostas_pk=".$row['cod_proposta'];
                $sql.="  and ndp.data_proposta_operador_pk=187";
               
                $results = mysql_query($sql);
                $rows = mysql_fetch_array($results);
                echo "<td align='center' class='form'>&nbsp;".$rows['dt_prev_fechamento']."&nbsp;</td>";
                mysql_free_result($results);
            }else{
                echo "<td align='center' class='form'>&nbsp;</td>";
            }
            
            echo "<td align='center' class='form'>TSP</td>";
            echo "<td align='center' class='form'>SP CAPITAL</td>";
            echo "<td align='center' class='form'>ROBERTA DE SOUZA LOPES</td>";
            echo "<td align='center' class='form'>MARCOS LIBANORI BARBOSA</td>";
            echo "<td align='center' class='form'>GRUPO EDM COMERCIO EQUIPAMENTOS DE TELEFONIA LTDA</td>";
            echo "<td align='center' class='form'>&nbsp;".$row['Consultor']."&nbsp;</td>";	
            echo "<td align='center' class='form'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
            
            //QTDE VOZ
            $sql ="";
            $sql.="SELECT nip.vl_unitario, nip.n_qtde
                    FROM n_produtos_tipo npt
                         INNER JOIN n_produtos np ON npt.pk = np.produtos_tipo_pk
                         INNER JOIN n_itens_propostas nip ON nip.produtos_pk = np.pk
                   WHERE npt.pk = 1 AND nip.propostas_pk =".$row['cod_proposta'];
            $results = mysql_query($sql);
            $qtde_voz =0;
            while($row2 = mysql_fetch_array($results)){
                $qtde_voz = $vl_voz + $row2['n_qtde'];
            }
            mysql_free_result($results);            
            echo "<td align='center' class='form'>&nbsp;".$qtde_voz."&nbsp;</td>";	

            //QTDE WEB
            $sql ="";
            $sql.="SELECT nip.vl_unitario, nip.n_qtde
                    FROM n_produtos_tipo npt
                         INNER JOIN n_produtos np ON npt.pk = np.produtos_tipo_pk
                         INNER JOIN n_itens_propostas nip ON nip.produtos_pk = np.pk
                   WHERE npt.pk = 3 AND nip.propostas_pk =".$row['cod_proposta'];
            $results = mysql_query($sql);
            $qtde_web =0;
            while($row2 = mysql_fetch_array($results)){
                $qtde_web = $qtde_web + $row2['n_qtde'];
            }
            mysql_free_result($results);   
            
            echo "<td align='center' class='form'>&nbsp;".$qtde_web."&nbsp;</td>";           
            echo "<td align='center' class='form'>&nbsp;".($qtde_voz+$qtde_web)."&nbsp;</td>";
            //echo "<td align='center' class='form'>&nbsp;</td>";
            if($row['codstatusclassificacaolead']==1){
                $sql="";
                $sql.="SELECT ml.Descricao
                        FROM motivoslead ml
                       WHERE ml.CodMotivoLead =".$row['codmotivo'];
                
                $results = mysql_query($sql);
                $rows = mysql_fetch_array($results);                
                
                $motivo = $rows['Descricao'];
                mysql_free_result($results);
                
                //Ocorrencias
                $sql="";
                $sql.="SELECT o.Descricao
                        FROM ocorrenciaslead o
                       WHERE o.CodTipoOcorrenciaLead = 5 AND o.CodLead =".$row['codlead'];
                
                $results = mysql_query($sql);
                $rows = mysql_fetch_array($results);                
                
                $desc_ocorrencia = $rows['Descricao'];
                mysql_free_result($results);
                
                echo "<td align='center' class='form'>".$motivo." - ".$desc_ocorrencia."&nbsp;</td>";    
                
                
            }elseif($row['codstatusclassificacaolead']==2 || $row['codstatusclassificacaolead']==3 || $row['codstatusclassificacaolead']==4){
                $desc = "";
                $sql="";
                $sql.="SELECT max(o.Descricao)Descricao_oc, t.Descricao
                        FROM ocorrenciaslead o
                             INNER JOIN tipoocorrenciaslead t
                                ON o.CodTipoOcorrenciaLead= t.CodTipoOcorrenciaLead
                       WHERE o.CodTipoOcorrenciaLead = 30
                       and o.CodLead =".$row['codlead'];              
                $results = mysql_query($sql);
                $rows = mysql_fetch_array($results);                
                $desc = $rows['Descricao_oc'];
                mysql_free_result($results);   
                
                if(empty($desc_agenda)){
                    $sql="";
                    $sql.="SELECT max(o.Descricao) Descricao_oc, t.Descricao
                            FROM ocorrenciaslead o
                                 INNER JOIN tipoocorrenciaslead t
                                    ON o.CodTipoOcorrenciaLead= t.CodTipoOcorrenciaLead
                           WHERE o.CodLead =".$row['codlead'];                
                    $results = mysql_query($sql);
                    $rows = mysql_fetch_array($results);                
                    $desc = $rows['Descricao']." - ".$rows['Descricao_oc'];
                    mysql_free_result($results);
                }   
                
                echo "<td align='center' class='form'>".$desc."&nbsp;</td>";
            }elseif ($row['codstatusclassificacaolead']==5) {
                $sql="";
                $sql.="SELECT max(o.Descricao)Descricao_oc, t.Descricao
                        FROM ocorrenciaslead o
                             INNER JOIN tipoocorrenciaslead t
                                ON o.CodTipoOcorrenciaLead= t.CodTipoOcorrenciaLead
                       WHERE o.CodTipoOcorrenciaLead = 7
                       and o.CodLead =".$row['codlead'];
                
                $results = mysql_query($sql);
                $rows = mysql_fetch_array($results);                
                $desc = $rows['Descricao']." - ".$rows['Descricao_oc'];
                mysql_free_result($results);
                
                echo "<td align='center' class='form'>".$desc."&nbsp;</td>";
            }elseif ( $row['codstatusclassificacaolead']==6 ) {
                $sql="";
                $sql.="SELECT max(o.Descricao)Descricao_oc, t.Descricao
                        FROM ocorrenciaslead o
                             INNER JOIN tipoocorrenciaslead t
                                ON o.CodTipoOcorrenciaLead= t.CodTipoOcorrenciaLead
                       WHERE o.CodTipoOcorrenciaLead in ( 	11)
                       and o.CodLead =".$row['codlead'];
                
                $results = mysql_query($sql);
                $rows = mysql_fetch_array($results);                
                $desc = $rows['Descricao']." - ".$rows['Descricao_oc'];
                mysql_free_result($results);
                
                echo "<td align='center' class='form'>".$desc."&nbsp;</td>";             
            }elseif ( $row['codstatusclassificacaolead']==10 || $row['codstatusclassificacaolead']==12 || $row['codstatusclassificacaolead']==15 ) {
                  $sql="";
                $sql.="SELECT max(o.Descricao)Descricao_oc, t.Descricao
                        FROM ocorrenciaslead o
                             INNER JOIN tipoocorrenciaslead t
                                ON o.CodTipoOcorrenciaLead= t.CodTipoOcorrenciaLead
                       WHERE o.CodTipoOcorrenciaLead in (12,1200,56)
                       and o.CodLead =".$row['codlead'];
                
                $results = mysql_query($sql);
                $rows = mysql_fetch_array($results);                
                $desc = $rows['Descricao']." - ".$rows['Descricao_oc'];
                mysql_free_result($results);
                
                echo "<td align='center' class='form'>".$desc."&nbsp;</td>";   
            }   
            
            if($row['codstatusclassificacaolead']==1){
                echo "<td align='center' class='form'>PERDIDA</td>";
            }elseif ($row['codstatusclassificacaolead']==2 ) {
                echo "<td align='center' class='form'>EM NEGOCIAÇÃO</td>"; 
            }elseif ($row['codstatusclassificacaolead']==3) {
                echo "<td align='center' class='form'>EM NEGOCIAÇÃO</td>";  
            }elseif ($row['codstatusclassificacaolead']==4) {
                echo "<td align='center' class='form'>EM NEGOCIAÇÃO</td>";      
            }elseif ($row['codstatusclassificacaolead']==5) {
                echo "<td align='center' class='form'>EM NEGOCIAÇÃO</td>";     
            }elseif ($row['codstatusclassificacaolead']==6) {
                echo "<td align='center' class='form'>EM NEGOCIAÇÃO</td>";  
            }elseif ( $row['codstatusclassificacaolead']==10 || $row['codstatusclassificacaolead']==12 || $row['codstatusclassificacaolead']==15 ) {
                echo "<td align='center' class='form'>FECHADA</td>";
            }
            
            if($row['codstatusclassificacaolead']==1){
                echo "<td align='center' class='form'>0%</td>";
            }elseif ($row['codstatusclassificacaolead']==2 || $row['codstatusclassificacaolead']==3 || $row['codstatusclassificacaolead']==4 ) {
                echo "<td align='center' class='form'>25%</td>";
            }elseif ($row['codstatusclassificacaolead']==5 ) {
                echo "<td align='center' class='form'>50%</td>";  
            }elseif ($row['codstatusclassificacaolead']==6 ) {
                echo "<td align='center' class='form'>75%</td>";   
            }elseif ($row['codstatusclassificacaolead']==6 || $row['codstatusclassificacaolead']==10 || $row['codstatusclassificacaolead']==12 || $row['codstatusclassificacaolead']==15 ) {
                echo "<td align='center' class='form'>100%</td>";
            }
            
            echo "<td align='center' class='form'>&nbsp;</td>";           
		echo "</tr>";
		$total ++;
	}
?>
	</tbody>
	<tfoot>
	<tr>
		<th class="titulo" bgcolor="#8080FF" colspan="16">
			<?= $total;?> registro(s)
		</th>
	</tr>
	</tfoot>
</table>
</body>
<?
include_once "../../libs/desconectar.php";
?>




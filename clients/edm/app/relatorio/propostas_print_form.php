<?
    include("../../libs/mpdf/mpdf.php");
	
	
	
	//Faz a conexão com o banco de dados.
	$con = mysql_connect("localhost","geprosco_5T", "gepros15082008") or die('Não foi possível conectar: ' . mysql_error());
	mysql_query("SET time_zone = '-03:00';",$con);
	mysql_query("SET NAMES 'latin1';",$con);
	mysql_query("SET character_set_connection=utf8';",$con);
	mysql_query("SET character_set_client=utf8';",$con);
	mysql_query("SET character_set_results=utf8';",$con);
	mysql_query("SET SQL_BIG_SELECTS=1;",$con);
	mysql_select_db("geprosco_5T");
	
	$leads_pk = $_REQUEST['codlead'];
	$proposta_pk = $_REQUEST['pk'];
	
	$sql = "";
	$sql.="SELECT dsc_operador,
			   nom.dsc_titulo,
			   nom.dsc_proposta,
			   e.cidade,
			   nom.dsc_rodape,
			   np.trade_in,
			   np.vl_total_proposta,
			   DATE_FORMAT(np.dt_validade, '%d/%m/%Y') dt_validade,
			   l.razaosocial
		  FROM operador o
			   INNER JOIN n_propostas np ON o.cod_operador = np.operador_pk
			   left join leads l on np.leads_pk = l.codlead
			   INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
			   INNER JOIN empresa e ON eo.cod_empresa = e.cod_empresa			   
			   LEFT JOIN n_operador_modelo_proposta nom
				  ON o.cod_operador = nom.operador_pk
		 WHERE np.pk =".$proposta_pk;
		if(!empty($_SESSION['cod_polo'])){		
			$sql.=" AND cod_polo =".$_SESSION['cod_polo'];
		}
        
		$result = mysql_query($sql);

		$row = mysql_fetch_array($result);
		$v_operadora = $row['dsc_operador'];
		$v_titulo = $row['dsc_titulo'];
		$v_dsc_proposta = $row['dsc_proposta'];
		$v_dsc_rodape = $row['dsc_rodape'];
		$v_cidade = $row['cidade'];
		$bgcolor="bgcolor='#CCCCCC'";
		$vl_total_proposta = $row['vl_total_proposta'];
		$dt_validade = $row['dt_validade'];
		$razaosocial = $row['razaosocial'];
	mysql_free_result($result);	    
	    
	    
	    
$data = date('D');

    $mes = date('M');

    $dia = date('d');

    $ano = date('Y');

 

    $semana = array(

        'Sun' => 'Domingo', 

        'Mon' => 'Segunda-Feira',

        'Tue' => 'Terca-Feira',

        'Wed' => 'Quarta-Feira',

        'Thu' => 'Quinta-Feira',

        'Fri' => 'Sexta-Feira',

                'Sat' => 'Sábado'

    );

 

    $mes_extenso = array(

        'Jan' => 'Janeiro',

        'Feb' => 'Fevereiro',

        'Mar' => 'Marco',

        'Apr' => 'Abril',

        'May' => 'Maio',

        'Jun' => 'Junho',

        'Jul' => 'Julho',

        'Aug' => 'Agosto',

        'Nov' => 'Novembro',

        'Sep' => 'Setembro',

        'Oct' => 'Outubro',

        'Dec' => 'Dezembro'

    );			
		    $html .="<html><head>
					<style>
					table {
						font-family: sans-serif;
						border: 1mm solid aqua;
						border-collapse: collapse;
						width:80%;											
					}
					table.sub {
						font-family: sans-serif;
						border: 1mm solid aqua;
						border-collapse: collapse;
						width:100%;						
					}
					table.subtable {
						font-family: sans-serif;
						border: 1mm solid aqua;
						border-collapse: collapse;
						width:100%;						
					}
					td {
						
						border: 1mm solid white;
						
					}
					td.grid{
						border: thin solid gray;
						font-family: Calibri;
						FONT-SIZE: 10px;
						text-transform:uppercase;
					}
					td.grid1{
						border: thin solid gray;
						font-family: Calibri;
						FONT-SIZE: 10px;
					}
					td.texto{						
						font-family: Calibri;
						FONT-SIZE: 10px;
					}
					</style>
					</head>";
				
			$header .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0' >";
			$header .=	"<tr>";
			$header .=		"<td width='50%' align='left'>";
			$header .=			"<div><img src='../../images/logo/logo.png' alt='' width='120'  /></div>";
			$header .=		"</td>";
			$header .=		"<td  align='right'>";
			$header .=			"<div><img src='../../images/logo/".$v_operadora.".png' alt='' width='120' width='120'  /></div>";
			$header .=		"</td>";
			$header .=	"</tr>";
			$header .="</table>";
			
			$html .="<p>";			
			$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td  align='right'>";
			$html .=			"<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>";
			$html .=				$v_cidade."&nbsp;,".$dia."&nbsp;de&nbsp;".$mes_extenso["$mes"]."&nbsp;de&nbsp;".$ano;
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	 "</tr>";
			$html .="</table>";		
				
			$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td width='50%' align='center' >";
			$html .=			"<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>";
			$html .=				"<b>".$v_titulo."</b>";
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	"</tr>";							
			$html .="</table>";
			$html .="<p>";	
			$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td width='50%' align='left' >";
			$html .=			"<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>";
			$html .=				"<b>Á ".$razaosocial."</b>";
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	"</tr>";							
			$html .="</table>";
			$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td width='50%' align='justify'>";
			$html .=			"<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>";
			$html .=				$v_dsc_proposta;
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	"</tr>";							
			$html .="</table>";
			
            //quebra de pagina
			$html .="<pagebreak />";
						
			$sql = "";	        
			$sql.="SELECT npt.ds_tipo_produto,
						   nc.pk combo,
						   npr.produtos_tipo_pk,
						   npt.pk
					  FROM n_itens_propostas nip
						   LEFT JOIN n_produtos npr ON nip.produtos_pk = npr.pk
						   LEFT JOIN n_combos nc ON nip.combos_pk = nc.pk 
						   LEFT JOIN n_produtos_tipo npt ON npr.produtos_tipo_pk = npt.pk or nc.produtos_tipo_pk = npt.pk
					 WHERE nip.propostas_pk=".$proposta_pk;
			$sql .= " group by npt.pk ";
			$sql .= " order by npt.n_ordem,nc.pk";
			$result = mysql_query($sql);
						
			while($row = mysql_fetch_array($result)){	
				if($row['ds_tipo_produto']=="Voz"){	
					
					$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
					$html .=	"<tr>";
					$html .=		"<td  align='center' ".$texto_caixa_alta.">";
					$html .=			"".$row['ds_tipo_produto'];
					$html .=		"</td>";
					$html .=	"</tr>";
					$html .="</table>";
					
					
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
					$html .=	"<tr ".$bgcolor."  align='center'>";
					$html .=		"<td class='grid'  width='150' bordercolor='gray'  align='center' ".$texto_caixa_alta." >";
					$html .=			"Produto";
					$html .=		"</td>";
					$html .=		"<td class='grid'  width='88' align='center' >";
					$html .=			"Tipo Linha";
					$html .=		"</td>";	
					$html .=		"<td  class='grid'  width='88' align='center' >";								
					$html .=			"Qtde";
					$html .=		"</td>";
					$html .=		"<td  class='grid'  width='88' align='center' >";
					$html .=			"Valor Unit";
					$html .=		"</td>";												
					$html .=		"<td class='grid'  width='88'  align='center' >";
					$html .=			"Assinatura";
					$html .=		"</td>";
					$html .=		"<td class='grid'  width='88'  align='center' >";
					$html .=			"Franquia";
					$html .=		"</td>";
					$html .=		"<td  class='grid' width='88' align='center' >";
					$html .=			"Total";
					$html .=		"</td>";
					$html .=	"</tr>";
					$html .="</table>";	
					$sql = "";
					$sql.="SELECT nip.pk,
								   nip.produtos_pk,
								   npr.ds_produto,
								   nip.n_qtde,
								   nip.vl_unitario,
								   nipo.vl_franquia,
								   ntl.dsc_tipo_linha  
							  FROM n_itens_propostas nip
								   INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
								   left JOIN n_itens_propostas_operadoras nipo ON nipo.itens_propostas_pk = nip.pk
								   left join n_produto_tipo_linha ntl on nipo.tipo_linha_pk = ntl.pk
							where nip.propostas_pk=".$proposta_pk;
									
							$sql .= " and npr.produtos_tipo_pk=".$row['produtos_tipo_pk'];	
					$results = mysql_query($sql);
					while($row1 = mysql_fetch_array($results)){	
						$v_total_qtde = $v_total_qtde + $row1['n_qtde'];
										
						$v_total_voz = $v_total_voz +($row1['vl_franquia']+ ($row1['n_qtde'] * $row1['vl_unitario'])); 
						$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";											  
						$html .="		<tr align='center'>";
						$html .="			<td class='grid1' width='150'  align='center'>";
						$html .=					$row1['ds_produto'];
						$html .="			</td>";
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					$row1['dsc_tipo_linha'];
						$html .="			</td>";
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					$row1['n_qtde'];
						$html .="			</td>";		
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					number_format($row1['vl_unitario'],2,',','.');
						$html .="				</font>";
						$html .="			</td>";														
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					number_format($row1['vl_unitario'],2,',','.');
						$html .="			</td>";
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					number_format($row1['vl_franquia'],2,',','.');													
						$html .="			</td>";
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					number_format($row1['vl_franquia']+ ($row1['n_qtde'] * $row1['vl_unitario']),2,',','.');
						$html .="			</td>";
						$html .="		</tr>";
						$html .="</table>";	
					}
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";		
					$html .="		<tr  ".$bgcolor.">";					
					$html .="			<td align='right' class='grid'  width='238'  colspan=2 >";
					$html .="				Qtde";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='88' >";
					$html .=					$v_total_qtde;
					$html .="			</td>";
					$html .="			<td align='right' class='grid'  width='264'  colspan=3 >";
					$html .="				Total";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='88' >";
					$html .=					number_format($v_total_voz,2,',','.');
					$html .="			</td>";
					$html .="		</tr>";
					$html .="</table>";
					$html .="<p>";
					mysql_free_result($results);
					
				}
				if(!empty($row['combo'])){
					$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";	
					$html .=	"<tr>";
					$html .=		"<td  align='center'>";
					$html .=			"<font face='Verdana, Arial, Helvetica, sans-serif' size='4'>Combo</font>";
					$html .=		"</td>";
					$html .=	"</tr>";
					$html .="</table>";					
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
					$html .=	"<tr ".$bgcolor."  align='center'>";
					$html .=		"<td class='grid'  width='150' bordercolor='gray'  align='center' ".$texto_caixa_alta." >";
					$html .=			"Produto";
					$html .=		"</td>";						
					$html .=		"<td  class='grid'  width='176' align='center' >";								
					$html .=			"Qtde";
					$html .=		"</td>";
					$html .=		"<td  class='grid'  width='176' align='center' >";
					$html .=			"Valor Unit";
					$html .=		"</td>";												
					$html .=		"<td  class='grid' width='176' align='center' >";
					$html .=			"Total";
					$html .=		"</td>";
					$html .=	"</tr>";
					$html .="</table>";	
					$sql = "";
					$sql.="SELECT nip.pk,       
								   nip.combos_pk,
								   nc.ds_combo,
								   nip.n_qtde,
								   nip.vl_unitario
							  FROM n_itens_propostas nip      
							  INNER JOIN n_combos nc ON nip.combos_pk = nc.pk       
							 WHERE nip.propostas_pk=".$proposta_pk;
					$results = mysql_query($sql);
					while($row1 = mysql_fetch_array($results)){	
						$v_total_qtde_combo = $v_total_qtde_combo + $row1['n_qtde'];
						$v_total_combo = $v_total_combo +($row1['n_qtde'] * $row1['vl_unitario']);  
						$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";											  
						$html .="		<tr align='center'>";
						$html .="			<td class='grid1' width='150'  align='center'>";
						$html .=					$row1['ds_combo'];
						$html .="			</td>";
						$html .="			<td class='grid1' width='176' align='center'>";
						$html .=					$row1['n_qtde'];
						$html .="			</td>";
						$html .="			<td class='grid1' width='176' align='center'>";
						$html .=					number_format($row1['vl_unitario'],2,',','.');
						$html .="			</td>";		
						$html .="			<td class='grid1' width='176' align='center'>";
						$html .=					number_format($row1['vl_franquia']+ ($row1['n_qtde'] * $row1['vl_unitario']),2,',','.');
						$html .="				</font>";
						$html .="			</td>";														
						$html .="		</tr>";
						$html .="</table>";	
					}
					mysql_free_result($results);
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";		
					$html .="		<tr  ".$bgcolor.">";					
					$html .="			<td align='right' class='grid'  width='150'  >";
					$html .="				Qtde";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='176' >";
					$html .=					$v_total_qtde_combo;
					$html .="			</td>";
					$html .="			<td align='right' class='grid'  width='176'  >";
					$html .="				Total";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='176' >";
					$html .=					number_format($v_total_combo,2,',','.');
					$html .="			</td>";
					$html .="		</tr>";
					$html .="	</table>";	
					
					
					
					$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";					
					$html .=	"<tr>";
					$html .=		"<td  align='center'>";
					$html .=			"<font face='Verdana, Arial, Helvetica, sans-serif' size='4'>Produtos e serviços Combo</font>";
					$html .=		"</td>";
					$html .=	"</tr>";
					$html .="</table>";		
					
					$sql = "";
					$sql .="SELECT 
								np.ds_produto
							FROM n_itens_combo nic
							  inner join n_produtos np on nic.produtos_pk = np.pk
							  inner join n_itens_propostas nip on nip.combos_pk = nic.combos_pk
							WHERE nip.propostas_pk=".$proposta_pk;
					$results = mysql_query($sql);
						
					while($row2 = mysql_fetch_array($results)){	
						
						$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";	
						$html .=	"<tr>";
						$html .=		"<td  align='left'>";
						$html .=			"<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>";
						$html .=				$row2['ds_produto'];
						$html .=			"</font>";
						$html .=		"</td>";
						$html .=	"</tr>";
						$html .="</table>";	
					}
					mysql_free_result($results);
				$html .="<p>";	
				}	
				$sql = "SELECT nip.pk,
						   nip.produtos_pk,
						   npr.ds_produto,
						   nip.n_qtde,
						   nip.vl_unitario,
						   nipo.vl_franquia,
						   ntl.dsc_tipo_linha  
				  FROM n_itens_propostas nip
					   INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
					   inner join n_produtos_tipo npt on npr.produtos_tipo_pk = npt.pk
					   left JOIN n_itens_propostas_operadoras nipo ON nipo.itens_propostas_pk = nip.pk
					   left join n_produto_tipo_linha ntl on nipo.tipo_linha_pk = ntl.pk					   
				where nip.propostas_pk=".$proposta_pk;
				$sql .= " and npt.pk=".$row['pk'];
				$sql .= " and npt.pk not in (1)";
				$tipo = mysql_query($sql);
				$num = mysql_num_rows($tipo);
				
				if(!empty($num)){
					$html .="<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>";
					$html .=	"<tr>";
					$html .=		"<td  align='center' ".$texto_caixa_alta.">";
					$html .=			"".$row['ds_tipo_produto'];
					$html .=		"</td>";
					$html .=	"</tr>";
					$html .="</table>";	
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
					$html .=	"<tr ".$bgcolor."  align='center'>";
					$html .=		"<td class='grid'  width='150' bordercolor='gray'  align='center' ".$texto_caixa_alta." >";
					$html .=			"Produto";
					$html .=		"</td>";						
					$html .=		"<td  class='grid'  width='176' align='center' >";								
					$html .=			"Qtde";
					$html .=		"</td>";
					$html .=		"<td  class='grid'  width='176' align='center' >";
					$html .=			"Valor Unit";
					$html .=		"</td>";												
					$html .=		"<td  class='grid' width='176' align='center' >";
					$html .=			"Total";
					$html .=		"</td>";
					$html .=	"</tr>";
					$html .="</table>";	
					$results = mysql_query($sql);
					$v_total_qtde_produtos = "";
					$v_total_produtos = "";
					while($row1 = mysql_fetch_array($results)){	
						$v_total_qtde_produtos = $v_total_qtde_produtos + $row1['n_qtde'];
						$v_total_produtos = $v_total_produtos+($row1['n_qtde'] * $row1['vl_unitario']);	
						$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";											  
						$html .="		<tr align='center'>";
						$html .="			<td class='grid1' width='150'  align='center'>";
						$html .=					$row1['ds_produto'];
						$html .="			</td>";
						$html .="			<td class='grid1' width='176' align='center'>";
						$html .=					$row1['n_qtde'];
						$html .="			</td>";
						$html .="			<td class='grid1' width='176' align='center'>";
						$html .=					number_format($row1['vl_unitario'],2,',','.');
						$html .="			</td>";		
						$html .="			<td class='grid1' width='176' align='center'>";
						$html .=					number_format($row1['vl_franquia']+ ($row1['n_qtde'] * $row1['vl_unitario']),2,',','.');
						$html .="				</font>";
						$html .="			</td>";														
						$html .="		</tr>";
						$html .="</table>";	
					}
					mysql_free_result($results);
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";		
					$html .="		<tr  ".$bgcolor.">";					
					$html .="			<td align='right' class='grid'  width='150'  >";
					$html .="				Qtde";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='176' >";
					$html .=					$v_total_qtde_produtos;
					$html .="			</td>";
					$html .="			<td align='right' class='grid'  width='176'  >";
					$html .="				Total";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='176' >";
					$html .=					number_format($v_total_produtos,2,',','.');
					$html .="			</td>";
					$html .="		</tr>";
					$html .="</table>";
					$html .="<p>";
				}
			}	
			
			$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
			$html .=			"<tr ".$bgcolor.">";
			$html .=				"<td align='right' class='grid'>";
			$html .=						"Total Produtos mais Serviços&nbsp;";
			$html .=				"</td>";
			$html .=				"<td align='center' class='grid' width='176	'>";
			$html .=						number_format($v_total_voz + $v_total_produtos + $v_total_combo,2,',','.');
			$html .=				"</td>";
			$html .=			"</tr>";
			$html .="</table>";	
			$html .="<p>";
			$sql = "SELECT npa.pk,
					   npa.n_qtde,
					   npa.vl_unitario,
					   npa.aparelhos_pk,
					   na.ds_aparelho,
					   npr.dsc_parcelamento,
					   nfa.dsc_forma_aquisicao,
					   npa.vl_desconto_aparelho
				  FROM n_propostas_aparelhos npa
					  inner join n_aparelhos na on npa.aparelhos_pk = na.pk
					  left join n_parcelamento npr on npa.parcelamento_pk = npr.pk 
					  left join n_forma_aquisicao nfa on npa.forma_aquisicao_pk  = nfa.pk
				 WHERE npa.propostas_pk=".$proposta_pk;	
			$results = mysql_query($sql);
			
			$num = mysql_num_rows($results);	
										
			if(!empty($num)){
					
				$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
				$html .=	"<tr>";
				$html .=		"<td  align='center' ".$texto_caixa_alta.">";
				$html .=			"Aparelhos";
				$html .=		"</td>";
				$html .=	"</tr>";
				$html .="</table>";
				$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
				$html .=	"<tr ".$bgcolor."  align='center'>";
				$html .=		"<td class='grid'  width='150' bordercolor='gray'  align='center' ".$texto_caixa_alta." >";
				$html .=			"Aparelho";
				$html .=		"</td>";						
				$html .=		"<td  class='grid'  width='88' align='center' >";								
				$html .=			"Qtde";
				$html .=		"</td>";
				$html .=		"<td  class='grid'  width='88' align='center' >";
				$html .=			"Valor Unit";
				$html .=		"</td>";	
				$html .=		"<td  class='grid'  width='88' align='center' >";
				$html .=			"Forma de Aquisição";
				$html .=		"</td>";	
				$html .=		"<td  class='grid'  width='88' align='center' >";
				$html .=			"Parcelamento";
				$html .=		"</td>";
				$html .=		"<td  class='grid'  width='88' align='center' >";
				$html .=			"Desconto";
				$html .=		"</td>";																								
				$html .=		"<td  class='grid' width='88' align='center' >";
				$html .=			"Total";
				$html .=		"</td>";
				$html .=	"</tr>";
				$html .="</table>";	
				while($row1 = mysql_fetch_array($results)){	
					$v_total_qtde_aparelho = $v_total_qtde_aparelhos + $row1['n_qtde'];
					$v_total_aparelho = ($v_total_aparelho +($row1['n_qtde'] * $row1['vl_unitario'] - $row1['vl_desconto_aparelho'])); 
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";											  
						$html .="		<tr align='center'>";
						$html .="			<td class='grid1' width='150'  align='center'>";
						$html .=					$row1['ds_aparelho'];
						$html .="			</td>";
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					$row1['n_qtde'];
						$html .="			</td>";
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					number_format($row1['vl_unitario'],2,',','.');
						$html .="			</td>";	
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					$row1['dsc_forma_aquisicao'];
						$html .="			</td>";	
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					$row1['dsc_parcelamento'];
						$html .="			</td>";		
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					number_format($row1['vl_desconto_aparelho'],2,',','.');
						$html .="			</td>";	
						$html .="			<td class='grid1' width='88' align='center'>";
						$html .=					number_format((($row1['n_qtde'] * $row1['vl_unitario'] - $row1['vl_desconto_aparelho'])),2,',','.');
						$html .="				</font>";
						$html .="			</td>";														
						$html .="		</tr>";
						$html .="</table>";	
				}
				mysql_free_result($results);
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";		
					$html .="		<tr  ".$bgcolor.">";					
					$html .="			<td align='right' class='grid'  width='150'  >";
					$html .="				Qtde";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='88' >";
					$html .=					$v_total_qtde_aparelho;
					$html .="			</td>";
					$html .="			<td align='right' class='grid' colspan=4 width='352'  >";
					$html .="				Total";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='88' >";
					$html .=					number_format($v_total_aparelho,2,',','.');
					$html .="			</td>";
					$html .="		</tr>";
					$html .="</table>";
					$html .="<p>";
					
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
					$html .=			"<tr ".$bgcolor.">";
					$html .=				"<td align='right' class='grid'>";
					$html .=						"Valor Total Plano(s) + Aparelho(s)&nbsp;";
					$html .=				"</td>";
					$html .=				"<td align='center' class='grid' width='176	'>";
					$html .=						number_format($v_total_voz + $v_total_produtos + $v_total_combo = $v_total_aparelho,2,',','.');
					$html .=				"</td>";
					$html .=			"</tr>";
					$html .="</table>";	
					$html .="<p>";
					
			}
		$sql = "Select
				         np.trade_in
						from n_propostas np
						where np.pk=".$proposta_pk;
			
			$result = mysql_query($sql);		
			$row = mysql_fetch_array($result);	
		
		//Trade In
		if(!empty($row['trade_in'])){	
			$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td class='texto' align='rigth' ".$texto_caixa_alta.">";
			$html .="		DESCONTO DE ".$row['trade_in']." MES(ES) NO VALOR CONTRATADO DA FRANQUIA.";
			$html .=		"</td>";
			$html .=	"</tr>";
			$html .="</table>";
			$html .="<p>";
		}
		mysql_free_result($result);		

		//Data Validade		
		$html .="<table  width='680' border='0' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
		$html .=	"<tr>";
		$html .=		"<td class='texto'  align='rigth' ".$texto_caixa_alta.">";
		$html .="		PROPOSTA VÁLIDA ATE: ".$dt_validade;
		$html .=		"</td>";
		$html .=	"</tr>";
		$html .="</table>";
		//Gerente 		
		$html .=	"<p>";			
		$sql = "";
		$sql.= " Select
					ui.nome,
					ui.email,
					ui.ddd_tel,
					ui.tel
				 from usuariosinternos ui
					inner join leads l on ui.codusuariointerno = l.codgerenteconta
				 Where l.codlead=".$leads_pk;
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$gerenteconta = $row['nome'];
		$gerenteemail = $row['email'];
		$ddd_tel = $row['ddd_tel'];
		$tel = $row['tel'];
		mysql_free_result($result);	
		
		$footer.="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
		if(!empty($gerenteconta)){	            
			
			$footer .=	"<tr>";
			$footer .=		"<td class='texto' align='left' >";
			$footer .=			"<b>";
			$footer .=			$gerenteconta;
			$footer .=			"</b>";					
			$footer .=		"</td>";
			$footer .=	"</tr>";
			if(!empty($tel)){
				$footer .=	"<tr>";
				$footer .=		"<td class='texto'  align='left' >";
				$footer .=			"<b> ";
				$footer .=			"Cel.: (".$ddd_tel.") ".$tel;
				$footer .=			"</b>";					
				$footer .=		"</td>";
				$footer .=	"</tr>";
			}			

			if(!empty($gerenteemail)){
				$footer .=	"<tr>";
				$footer .=		"<td class='texto' align='left' >";
				$footer .=			"<b>";
				$footer .=			"Email: ".$gerenteemail;
				$footer .=			"</b>";					
				$footer .=		"</td>";
				$footer .=	"</tr>";
			}				
		}	
		$footer.=	"<tr>";
		$footer.=		"<td class='texto' align='center' >";	
		$footer.=			"&nbsp;";			
		$footer.=		"</td>";
		$footer.=	"</tr>";
		$footer.=	"<tr>";
		$footer.=		"<td  class='texto' align='center' >";
		$footer.=			$v_dsc_rodape;
		$footer.=		"</td>";
		$footer.=	"</tr>";	
		$footer.=	"<tr>";
		$footer.=		"<td class='texto'  align='right' >";
		$footer.=			'{PAGENO}/{nb}';
		$footer.=		"</td>";
		$footer.=	"</tr>";					
		$footer.="</table>";
		$mpdf=new mPDF('', // mode - default '' 
						'',    // format - A4, for example, default '' 
						0,     // font size - default 0 
						'',    // default font family 
						15,    // margin_left
						15,    // margin right 
						45,     // margin top
						45,    // margin bottom 
						9,     // margin header 
						2,     // margin footer 
						'L' );
	$mpdf->charset_in='iso-8859-1';
	$mpdf->SetHTMLHeader($header);	
    $mpdf->SetHTMLFooter($footer);
	 
	$mpdf->WriteHTML($html);
	$mpdf->Output();

	exit();

	mysql_close($con);

?>

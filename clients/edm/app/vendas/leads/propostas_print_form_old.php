<?
    include_once("../../libs/mpdf/mpdf.php");
	include_once '../../libs/conectar.php';
	
	conectar();
	
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
			   l.razaosocial,
               cl.nomecontato
		  FROM operador o
			   INNER JOIN n_propostas np ON o.cod_operador = np.operador_pk
			   left join leads l on np.leads_pk = l.codlead
               left join contatoslead cl on l.codlead = cl.codlead
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
        $nomecontato = $row['nomecontato'];
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

                'Sat' => 'SÃ¡bado'

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
						border: thin solid #FF9900;
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
						font-family: Tahoma;
						FONT-SIZE: 12px;
					}
                    td.grid_especial{
                        background: #FCD5B4;
						border: thin solid #FF9900;                        
						font-family: Calibri;
						FONT-SIZE: 10px;
						text-transform:uppercase;
					}
                    
					</style>
					</head>";
				
			$header .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0' >";
			$header .=	"<tr>";
			$header .=		"<td width='50%' align='left'>";
			$header .=			"<div><img src='../../images/logo/logo_proposta.png' alt=''   /></div>";
			$header .=		"</td>";
			$header .=	"</tr>";
			$header .="</table>";			
           	
			$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td width='50%' align='left' >";
			$html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'>";
			$html .=				"Razão Social - ".$razaosocial;
			$html .=			"</font>";
			$html .=		"</td>";            
			$html .=	"</tr>";
            if(!empty($nomecontato)){
                $html .=	"<tr>";
                $html .=		"<td width='50%' align='left' >";
                $html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'>";
                $html .=				"A/C - ".$nomecontato;
                $html .=			"</font>";
                $html .=		"</td>";            
                $html .=	"</tr>";
            }
			$html .="</table>";
            
             $html .="<p>";
            $html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td width='50%' align='center' >";
			$html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='4'>";
			$html .=				"<b>".$v_titulo."</b>";
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	"</tr>";							
			$html .="</table>";
			$html .="<p>";		
            
            /*$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td width='50%' align='justify'>";
			$html .=			"<font face=',Verdana, Arial, Helvetica, sans-serif' size='3' color=red>";
			$html .=				"<b>B4C - BUSINESS FOR COMMUNICATIONS<b>";
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	"</tr>";							
			$html .="</table>";*/
            $html .="<p>";
			$html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td width='50%' align='justify'>";
			$html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='4'>";
			$html .=				$v_dsc_proposta;
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	"</tr>";							
			$html .="</table>";
			
            //quebra de pagina
			$html .="<pagebreak />";
					
            
            $html .="<table width='680' border='0' align='center' cellpadding='0' cellspacing='0'>";
			$html .=	"<tr>";
			$html .=		"<td width='50%' align='justify'>";
			$html .=			"<font face=',Verdana, Arial, Helvetica, sans-serif' size='3' >";
			$html .=				"<b>PROPOSTA:<b>";
			$html .=			"</font>";
			$html .=		"</td>";
			$html .=	"</tr>";							
			$html .="</table>";
           	
			$sql = "";	        
			$sql.="SELECT npt.ds_tipo_produto,
						   nc.pk combo,
						   npr.produtos_tipo_pk,
						   npt.pk,
                           npr.pk produtos_pk,
                           nip.pk itens_proposta_pk
					  FROM n_itens_propostas nip
						   LEFT JOIN n_produtos npr ON nip.produtos_pk = npr.pk
						   LEFT JOIN n_combos nc ON nip.combos_pk = nc.pk 
						   LEFT JOIN n_produtos_tipo npt ON npr.produtos_tipo_pk = npt.pk or nc.produtos_tipo_pk = npt.pk
                          
					 WHERE nip.propostas_pk=".$proposta_pk;
            
			$sql .= " group by npt.pk ";
			$sql .= " order by npt.n_ordem,nc.pk";
			
			$result = mysql_query($sql);
						
			while($row = mysql_fetch_array($result)){	
				//if($row['ds_tipo_produto']=="Voz"){	
							
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
					$html .=	"<tr   align='center'>";
					$html .=		"<td class='grid'  width='280' bordercolor='RED'  align='center' ".$texto_caixa_alta." >";
					$html .=			"Descrição";
					$html .=		"</td>";
					$html .=		"<td  class='grid'  width='133' align='center' >";								
					$html .=			"Qtde";
					$html .=		"</td>";
					$html .=		"<td  class='grid'  width='133' align='center' >";
					$html .=			"Valor Unitário";
					$html .=		"</td>";	
					$html .=		"<td  class='grid' width='133' align='center' >";
					$html .=			"Valor Total";
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
								   ntl.dsc_tipo_linha,  
                                   npr.produtos_tipo_pk
							  FROM n_itens_propostas nip
								   INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
								   left JOIN n_itens_propostas_operadoras nipo ON nipo.itens_propostas_pk = nip.pk
								   left join n_produto_tipo_linha ntl on nipo.tipo_linha_pk = ntl.pk                                   
							where nip.propostas_pk=".$proposta_pk;
                     $sql.=" and npr.produtos_tipo_pk = 1
                             order by nip.pk";
                    
					$results = mysql_query($sql);
                    $_v = 0;   
					while($row1 = mysql_fetch_array($results)){	                        
                        $valor_franqui_total += $row1['vl_franquia'];
                        $valor_unitario_total += $row1['vl_unitario'];
                        $valor_unitario_multiplicado += ($row1['n_qtde'] * $row1['vl_unitario']);
                        $qtde += $row1['n_qtde'];
                    }                      
                    mysql_free_result($results);
                    
                    $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";											  
						
                    if(!empty($valor_franqui_total)){

                        $vl_franquia = $valor_franqui_total;
                        $html .="		<tr align='center'>";
                        $html .="			<td class='grid' width='280'  align='letf'>";
                        $html .=		    "Franquia";
                        $html .="			</td>";                              
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=                "1";
                        $html .="			</td>";		
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=					"R$ ".number_format($valor_franqui_total,2,',','.');
                        $html .="				</font>";
                        $html .="			</td>";	
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=					"R$ ".number_format($valor_franqui_total,2,',','.');
                        $html .="			</td>"; 
                        $html .="		</tr>"; 
                        $html .="		<tr align='center'>";
                        $html .="			<td class='grid' width='280'  align='letf'>";
                        $html .=					"Assinatura";
                        $html .="			</td>";
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=					$qtde;
                        $html .="			</td>";		
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=					"R$ ".number_format($valor_unitario_total,2,',','.');
                        $html .="				</font>";
                        $html .="			</td>";	
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=					"R$ ".number_format($valor_unitario_multiplicado,2,',','.');             
                        $html .="			</td>";
                        $html .="		</tr>";
                        
                    }
                    $sql= "";
                    $sql.="SELECT nip.pk,
								   nip.produtos_pk,
								   npr.ds_produto,
								   nip.n_qtde,
								   nip.vl_unitario,
								   nipo.vl_franquia,
								   ntl.dsc_tipo_linha,  
                                   npr.produtos_tipo_pk
							  FROM n_itens_propostas nip
								   INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
								   left JOIN n_itens_propostas_operadoras nipo ON nipo.itens_propostas_pk = nip.pk
								   left join n_produto_tipo_linha ntl on nipo.tipo_linha_pk = ntl.pk                                   
							where nip.propostas_pk=".$proposta_pk;
                    $sql.=" and npr.produtos_tipo_pk <> 1
                             order by nip.pk";
					$results = mysql_query($sql);
                    $_v = 0;  
                    $vl_internet = 0;
                    while($row1 = mysql_fetch_array($results)){	
						$v_total_qtde = $v_total_qtde + $row1['n_qtde'];
						
                       
                        $valor_modulos_total += ($row1['n_qtde'] * $row1['vl_unitario']);
                      
                       //IDENTIFICA OS PRODUTOS DE DADOS PARA RETIRAR O VALOR DO  DESCONTO CLARO 
                       if($row1['produtos_tipo_pk']==3){
                           $vl_internet +=  ($row1['n_qtde'] * $row1['vl_unitario']);
                       }                     

                        $html .="		<tr align='center'>";
                        $html .="			<td class='grid' width='280'  align='letf'>";
                        $html .=					$row1['ds_produto'];
                        $html .="			</td>";
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=					$row1['n_qtde'];
                        $html .="			</td>";		
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=					"R$ ".number_format($row1['vl_unitario'],2,',','.');
                        $html .="				</font>";
                        $html .="			</td>";	
                        $html .="			<td class='grid' width='133' align='center'>";
                        $html .=					"R$ ".number_format($row1['vl_franquia']+ ($row1['n_qtde'] * $row1['vl_unitario']),2,',','.');
                        $html .="			</td>";
                        $html .="		</tr>";                      
					}
                   $v_total_voz = ($valor_modulos_total + $valor_franqui_total + $valor_unitario_multiplicado);
                   $v_total_p = ($valor_modulos_total + $valor_franqui_total + $valor_unitario_multiplicado);
                    $html .="</table>";	
					$html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";		
					$html .="		<tr  >";					
					$html .="			<td align='left' class='grid'  width='280'   >";
					$html .="				TOTAL";
					$html .="			</td>";
					$html .="			<td class='grid' align='center' colspan=2  >";
					$html .=					"&nbsp;";
					$html .="			</td>";
					$html .="			<td class='grid' align='center'  width='133' >";
					$html .=					"R$ ".number_format($v_total_voz,2,',','.');
					$html .="			</td>";
					$html .="		</tr>";
					$html .="</table>";
					$html .="<br>";
					mysql_free_result($results);
                    
                    $sql = "";
                    $sql.=" SELECT  npo.visualiza_vc1_local,
                            npo.dsc_vc1_local,
                            npo.vl_vc1_local,
                            npo.visualiza_vc2_local,
                            npo.dsc_vc2_local,
                            npo.vl_vc3_local,
                            npo.visualiza_vc3_local,
                            npo.dsc_vc3_local,
                            npo.vl_vc2_local,
                            npo.visualiza_vc1_Estad,
                            npo.dsc_vc1_Estad,
                            npo.vl_vc1_Estad,
                            npo.visualiza_vc2_Estad,
                            npo.dsc_vc2_Estad,
                            npo.vl_vc2_Estad,
                            npo.visualiza_vc3_Estad,
                            npo.dsc_vc3_Estad,
                            npo.vl_vc3_Estad
                    FROM n_produtos_operadoras npo
                    WHERE npo.produtos_pk =".$row['produtos_pk'];
                    
                   $rs = mysql_query($sql); 
				   $num = mysql_num_rows($rs);	
                   $rss = mysql_fetch_array($rs);
                   
                   if(!empty($num)){
                    $sql = "";   
                    $sql.= "Select
                                ipo.pk,
                                ipo.vl_vc1_local,
                                ipo.vl_vc2_local,
                                ipo.vl_vc3_local,
                                ipo.vl_vc1_Inter_Estad,
                                ipo.vl_vc2_Inter_Estad,
                                ipo.vl_vc3_Inter_Estad
                            from n_itens_propostas_operadoras ipo
                            where ipo.itens_propostas_pk=".$row['itens_proposta_pk'];
                            
                            $results = mysql_query($sql);
                            $row2 = mysql_fetch_array($results);  
                            $exdente = '0.04';
                        $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
                        $html .=	"<tr   align='center'>";
                        $html .=		"<td class='grid'   align='left' colspan=4 ".$texto_caixa_alta." >";
                        $html .=			"<b>Tarifa local (VC1)<b/>";
                        $html .=		"</td>";                  
                        $html .=	"</tr>";
                        $html .=	"<tr   align='center'>";
                        $html .=		"<td class='grid'   align='left'  width='280'>";
                        $html .=			"Fixo: <b>R$ ".number_format($row2['vl_vc1_local'],2,",",".")."</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='left' width='133'>";
                        $html .=			"Móvel: <b>R$ ".number_format($row2['vl_vc2_local'],2,",",".")."</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='left'  width='133'>";
                        $html .=			"Intra-rede:  <b>R$ ".number_format($row2['vl_vc3_local'],2,",",".")."</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='left'  width='133'>";
                        $html .=			"Excedente:  <b>R$ ".number_format(($row2['vl_vc1_local']+$exdente),2,",",".")."</b>";
                        $html .=		"</td>";
                        $html .=	"</tr>";
                        $html .=	"<tr align='center'>";
                        $html .=		"<td class='grid'   align='left' colspan=4 ".$texto_caixa_alta." >";
                        $html .=			"<b>Tarifa longa distância (VC2/VC3)<b/>";
                        $html .=		"</td>";                  
                        $html .=	"</tr>";
                        $html .=	"<tr   align='center'>";
                        $html .=		"<td class='grid'   align='left'  width='280'>";
                        $html .=			"Fixo: <b>R$ ".number_format($row2['vl_vc1_Inter_Estad'],2,",",".")."</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='left' width='133'>";
                        $html .=			"Móvel: <b>R$ ".number_format($row2['vl_vc2_Inter_Estad'],2,",",".")."</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='left'  width='133'>";
                        $html .=			"Intra-rede:  <b>R$ ".number_format($row2['vl_vc3_Inter_Estad'],2,",",".")."</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='left'  width='133'>";
                        $html .=			"Excedente:  <b>R$ ".number_format(($row2['vl_vc1_Inter_Estad']+$exdente),2,",",".")."</b>";
                        $html .=		"</td>";
                        $html .=	"</tr>";
                        $html .="</table>";	    
                        mysql_free_result($results);	
                   }
                    $html .="<br>";
					mysql_free_result($rs);
                    
                    $sql = "Select
				         np.trade_in,
                         np.vl_ult_conta,
                         np.vl_desconto_claro
						from n_propostas np
						where np.pk=".$proposta_pk;
			
                    $results = mysql_query($sql);		
                    $row5 = mysql_fetch_array($results);	
                    
                    $trade_in = $row5['trade_in'];
                    $vl_ult_conta = $row5['vl_ult_conta'];
                    $vl_desconto_claro = $row5['vl_desconto_claro'];
                    mysql_free_result($results);
                    
                    $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td class='grid'   align='left'  colspan=4 >";
                    $html .=			"<b>Benefícios<b/>";
                    $html .=		"</td>";                  
                    $html .=	"</tr>";
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td class='grid'   align='left'  width='280'>";
                    $html .=			"<b>Trade - In</b>";
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='center' width='133'>";
                    $html .=			$trade_in;
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='center'  width='133'>";
                    $html .=			"R$ ".number_format($vl_franquia ,2,',','.');
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='center'  width='133'>";
                    $html .=			"R$ ".number_format(($vl_franquia *$trade_in),2,',','.');
                    $html .=		"</td>";
                    $html .=	"</tr>";
                    if($vl_desconto_claro != 0){
                        $v_desconto_claro= (($v_total_voz - $vl_internet)*2);
                       // $vl_desc_claro = ($vl_desc_claro + (($v_total_p - $vl_internet) / 20));
                         $vl_desc_claro = ($vl_desc_claro + (($v_total_p - $vl_internet) / 20));
                        $html .=	"<tr   align='center'>";
                        $html .=		"<td class='grid'   align='left'  width='280'>";
                        $html .=			"<b>Desconto Claro </b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center' width='133'>";
                        $html .=			"20";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center'  width='133'>";
                        $html .=			"R$ ".number_format(($v_desconto_claro / 20),2,',','.');
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center'  width='133'>";
                        $html .=			"R$ ".number_format(($v_total_voz * 2),2,',','.');
                        $html .=		"</td>";
                        $html .=	"</tr>";  
                    }
                    $html .="</table>";	
                    $html .="<br>"; 
                    if($vl_desconto_claro != 0){
                        $vl_desconto_total = (($vl_franquia*$trade_in)+$v_total_p);
                        $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
                        $html .=	"<tr   align='center'>";
                        $html .=		"<td class='grid'   align='left'  width='280'>";
                        $html .=			"<b>Total Descontos</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center' width='133' colspan=2>";
                        $html .=            "&nbsp;";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center'  width='133'>";                    
                        $html .=			"R$ ".number_format(($vl_desconto_total),2,',','.');
                        $html .=		"</td>";
                        $html .=	"</tr>";                                  
                        $html .="</table>";
                    }
                    $html .="<br>";
                    
                    $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td class='grid'   align='left'  colspan=4 >";
                    $html .=			"<b>Economia<b/>";
                    $html .=		"</td>";                  
                    $html .=	"</tr>";
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td class='grid'   align='left' colspan=2 >";
                    $html .=			"<b>Valor ultima conta *** Cliente</b>";
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='right' colspan=2 >";
                    $html .=			"R$ ".number_format($vl_ult_conta,2,',','.')."&nbsp;";
                    $html .=		"</td>";                    
                    
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
                        while($row1 = mysql_fetch_array($results)){	
                            $v_total_qtde_aparelho = $v_total_qtde_aparelhos + $row1['n_qtde'];
                            $v_total_aparelho = ($v_total_aparelho +($row1['n_qtde'] * $row1['vl_unitario'] )); 
                            $parcelamento = $row1['dsc_parcelamento'];
                            $vl_unitario = $row1['vl_unitario'];
                        
                           
                        }
                        mysql_free_result($results);
                         $vl_parcelamento_cel = ($v_total_aparelho/$parcelamento);
                    }
                    $desc = ($v_total_p /20);
                    $soma_proposta = (($v_total_voz + $vl_parcelamento_cel) - $desc);
                    $html .=	"</tr>";
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td class='grid'   align='left'  width='280'>";
                    $html .=			"<b>Período</b>";
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='center' width='133'>";
                    $html .=			"12";
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='center'  width='133'>";
                    $html .=			"24";
                    $html .=		"</td>";
                    $html .=		"<td class='grid_especial'   align='center'  width='133'>";
                    $html .=			"<b>REDUÇÃO</b>";
                    $html .=		"</td>";
                    $html .=	"</tr>"; 
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td class='grid'   align='left'  width='280'>";
                    $html .=			"<b>Valor estimado</b>";
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='center' width='133'>";
                    if($vl_ult_conta==0){
                        $html .=			"R$ 0,00";
                    }else{
                        
                        $html .=			"R$ ".number_format((($vl_ult_conta-$v_total_voz)*12),2,',','.');
                    }
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='center'  width='133'>";
                    if($vl_ult_conta==0){
                        $html .=			"R$ 0,00";
                    }else{
                        $html .=			"R$ ".number_format((($vl_ult_conta-$v_total_voz)*24),2,',','.');
                    }
                    $html .=		"</td>";
                    $html .=		"<td class='grid_especial'   align='center'  width='133'>";
                    if($vl_ult_conta==0){
                        $html .=			"0%";
                    }else{
                        $percentual = (100 - (($soma_proposta/$vl_ult_conta)*100));
                        $html .=			"<font color=red><b>".number_format($percentual,2,',','.')." %</b></font>";
                    }
                    $html .=		"</td>";
                    $html .=	"</tr>";       
                    $html .="</table>";                    
                    $html .="<br>";
                    
                    

                    if(!empty($num)){   
                       
                        
                        
                        $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
                        $html .=	"<tr   align='center'>";
                        $html .=		"<td class='grid'   align='left'  colspan=4 >";
                        $html .=			"<b>Aparelhos<b/>";
                        $html .=		"</td>";                  
                        $html .=	"</tr>";
                        /*$html .=	"<tr   align='center'>";
                        $html .=		"<td class='grid'   align='left'  width='280'>";
                        $html .=			"<b>Sim card</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center' width='133'>";
                        $html .=			$v_total_qtde_aparelho;
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center'  width='133'>";
                        $html .=			"R$ 10,00";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center'  width='133'>";
                        $html .=			"R$ ".number_format($v_total_aparelho,2,',','.');
                        $html .=		"</td>";
                        $html .=	"</tr>"; */
                        $html .=	"<tr   align='center'>";
                        $html .=		"<td class='grid'   align='left'  width='280'>";
                        $html .=			"<b>Parcelamento</b>";
                        $html .=		"</td>";
                        $html .=		"<td class='grid'   align='center' width='133'>";
                        $html .=			$parcelamento;
                        $html .=		"</td>";          
                        $html .=		"<td class='grid'   align='center' colspan=2  width='266'>";
                        $html .=			number_format(($v_total_aparelho/$parcelamento),2,',','.');
                        $html .=		"</td>";
                        $html .=	"</tr>";       
                        $html .="</table>";
                        $html .="<br>";                                                         
                    }
                    
                    $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td class='grid'   align='left' colspan=3>";
                    $html .=			"<b>Total proposta + aparehos + desc mensal </b>";
                    $html .=		"</td>";
                    $html .=		"<td class='grid'   align='center'  width='133'>";                        
                    $html .=			"R$ ".number_format((($v_total_voz) + $vl_parcelamento_cel - $vl_desc_claro),2,',','.');
                    $html .=		"</td>";
                    $html .=	"</tr>";       
                    $html .="</table>";	
                    $html .="<br>";
                    
                    $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";                       
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td  align='left' colspan=3>";
                    $html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'><b>DIFERENCIAIS:</b></font>";
                    $html .=		"</td>";
                    $html .=	"</tr>";   
                    $html .=	"<tr   align='center'>";
                    $html .=		"<td   align='left' colspan=3>";
                    $html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'>";
                    $html .=			"<li><em> Trade In é a isenção do valor da franquia contratada por 1 (um) ou mais meses, mediante regra vigente.</em></li>";
                    $html .=			"<li> Modalidade Desconto Claro*, valor total contratado (exceto modem e roteador) multiplicado por 2 (dois), para desconto no valor total da fatura ou desconto na aquisição de aparelhos. *benefício concedido a partir da 5ª fatura.</li>";
                    $html .=			"<li> O consumo de Ligações Locais ou Longa Distância (Nacional ou Internacional) é abatido da Franquia contratada.</li>";
                    $html .=			"<li> Gestor Online, a operadora Claro é a única que possui o módulo de gestão que permite o gerenciamento de todos os serviços contratados em tempo real.</li>";
                    $html .=		"</font>";
                    $html .=		"</td>";
                    $html .=	"</tr>";   
                    $html .="</table>";	  
                    
				//}		
				
			}	
        
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
            
            $html .="<pagebreak />";
            $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";                       
            $html .=	"<tr   align='center'>";
            $html .=		"<td  align='left' colspan=3>";
            $html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'><b>APARELHOS E SUAS CARACTERÍSTICAS</b></font>";
            $html .=		"</td>";
            $html .=	"</tr>";   
            $html .="</table>";
            $html .="<br>";
            
            $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";                       
            $html .=	"<tr   align='center'>";
            $html .=		"<td class='grid' width='170'  align='center' colspan=3>";
            $html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'><b>QTDE</b></font>";
            $html .=		"</td>";
            $html .=		"<td class='grid' width='170' align='center' colspan=3>";
            $html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'><b>Modelo</b></font>";
            $html .=		"</td>";
            $html .=		"<td class='grid' width='170' align='center' colspan=3>";
            $html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'><b>Valor (unit)</b></font>";
            $html .=		"</td>";
            $html .=		"<td class='grid' width='170' align='center' colspan=3>";
            $html .=			"<font face='Tahoma,Verdana, Arial, Helvetica, sans-serif' size='3'><b>Promocional</b></font>";
            $html .=		"</td>";
            $html .=	"</tr>";  
            
            while($row1 = mysql_fetch_array($results)){	

                $html .=	"<tr   align='center'>";
                $html .=		"<td class='grid' width='170'  align='center' colspan=3>";
                $html .=			$row1['n_qtde'];
                $html .=		"</td>";
                $html .=		"<td class='grid' width='170' align='center' colspan=3>";
                $html .=			$row1['ds_aparelho'];
                $html .=		"</td>";
                $html .=		"<td class='grid' width='170' align='center' colspan=3>";
                $html .=			"R$ ".number_format($row1['vl_unitario'],2,',','.');
                $html .=		"</td>";
                $html .=		"<td class='grid' width='170' align='center' colspan=3>";
                $html .=			"";
                $html .=		"</td>";
                $html .=	"</tr>"; 
                $cont ++;
            }
            mysql_free_result($results);
            $html .="</table>";            
            $html .="<br>";    
            
            $html .="<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
              

            $cont = 1;
            $contador = 1;
            $contador1 = 1;
            $pk_arr = array();            
            $pk_arr1 = array(); 
            for($i =1; $i <= $num; $i++){
                if($cont==1 ){
                    $html .=	"<tr   align='center'>"; 
                    $html .=        "<td>";
                    $html .=            "<table  width='680' border='1' align='center' bordercolor='write' cellpadding='0' cellspacing='0'>";
                    $html .=                "<tr   align='center'>"; 
                    for($g =1; $g <= 3; $g++){
                        $sql = "SELECT npa.pk,
                                        npa.n_qtde,
                                        npa.vl_unitario,
                                        npa.aparelhos_pk,
                                        na.ds_aparelho,
                                        npr.dsc_parcelamento,
                                        nfa.dsc_forma_aquisicao,
                                        npa.vl_desconto_aparelho,
                                        na.nom_imagem_cel
                                   FROM n_propostas_aparelhos npa
                                       inner join n_aparelhos na on npa.aparelhos_pk = na.pk
                                       left join n_parcelamento npr on npa.parcelamento_pk = npr.pk 
                                       left join n_forma_aquisicao nfa on npa.forma_aquisicao_pk  = nfa.pk
                                  WHERE npa.propostas_pk=".$proposta_pk;
                        if($contador != 1){
                          $arr = implode(", ", $pk_arr);  
                          $sql.=" and npa.pk not in (".$arr.")";
                        }

                        $results = mysql_query($sql);
                        $row1 = mysql_fetch_array($results);
                        if(!empty($row1['pk'])){
                            $pk_arr[] = $row1['pk'];    
                        }

                        $html .= "<td class='grid' align='center'  width='226'>"; 
                        if(!empty($row1['nom_imagem_cel'])){                    
                            $html .=	"<div><img src='../../operacao/n_aparelhos/aparelhos/".$row1['nom_imagem_cel']."' alt='' width='15%'  /></div>";
                        }else{
                             $html .="";
                        }
                        $html .=		"</td>"; 
                        $contador ++;
                    }
                    $html .=        "</tr>";                   
                    mysql_free_result($results);
                    
                    $html .=        "<tr   align='center'>"; 
                    for($h =1; $h <= 3; $h++){
                        $sql = "SELECT npa.pk,
                                        npa.n_qtde,
                                        npa.vl_unitario,
                                        npa.aparelhos_pk,
                                        na.ds_aparelho,
                                        npr.dsc_parcelamento,
                                        nfa.dsc_forma_aquisicao,
                                        npa.vl_desconto_aparelho,
                                        na.nom_imagem_cel
                                   FROM n_propostas_aparelhos npa
                                       inner join n_aparelhos na on npa.aparelhos_pk = na.pk
                                       left join n_parcelamento npr on npa.parcelamento_pk = npr.pk 
                                       left join n_forma_aquisicao nfa on npa.forma_aquisicao_pk  = nfa.pk
                                  WHERE npa.propostas_pk=".$proposta_pk;
                        if($contador1 != 1){
                          $arr1 = implode(", ", $pk_arr1);  
                          $sql.=" and npa.pk not in (".$arr1.")";
                        }
                        
                        $results = mysql_query($sql);
                        $row1 = mysql_fetch_array($results);
                        if(!empty($row1['pk'])){
                            $pk_arr1[] = $row1['pk'];    
                        }

                        $html .= "<td class='grid' align='center'  width='226'>"; 
                        if(!empty($row1['nom_imagem_cel'])){                    
                            $html .= "<b>".$row1['ds_aparelho']."</b>"	;
                        }else{
                             $html .="";
                        }
                        $html .=		"</td>"; 
                        $contador1 ++;
                    } 
                    $html .=        "</tr>";
                    $html .=    "</table >";
                    $html .=    "</td>"; 
                    $html .=	"</tr>";
                    $html .=	"<tr>";
                    $html .=	"<td colspan=3>";
                    $html .=	"&nbsp;";
                    $html .=	"</td>";
                    $html .=	"</tr>";
                }    
                $cont++;
                if($cont >=3){
                    $cont=1;
                }
            }   
      
            $html .="</table>";
        }    
            
		
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
		$footer.=		"<td   align='center' >";
        $footer.=			"<font face=',Verdana, Arial, Helvetica, sans-serif' size='1' >";
		$footer.=			$v_dsc_rodape;
        $footer.=		"</font>";
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
						28,     // margin top
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

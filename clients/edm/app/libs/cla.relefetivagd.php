<?
class relefetivagd
{
	function sql1( $codgrupo )
	{
		$sql1 = "SELECT g.CodUsuarioInterno codusr ,
						u.Nome usuario 
				   FROM gruposusuariosinternos_usuariosinternos g
			 INNER JOIN usuariosinternos u 
					 ON g.CodUsuarioInterno = u.CodUsuarioInterno 
				  WHERE CodGrupoUsuarioInterno = {$codgrupo}" ;
		  
		return sql_query( $sql1 ) ;
		
	}	
				  
	function sql2( $codUser , $codpolo = null , $dti = null , $dtf = null )
	{	
		$sql2 = "SELECT sa.Descricao status_ag ,
						   sc.Descricao status_lead , 
						   l.RazaoSocial Lead , 
						   l.CodLead , 
						   al.CodStatus codstatus_ag ,
						   l.CodStatusClassificacaoLead codstatus_ld , 
						   ta.Descricao tipo_ag
					  FROM leads l
				INNER JOIN agendaslead al 
						ON l.CodLead = al.CodLead
				 LEFT JOIN statusagendamento sa 
				 		ON sa.CodStatus = al.CodStatus
				 LEFT JOIN tipoagendamento ta 
				 		ON ta.CodTipo = al.CodTipo
				INNER JOIN statusclassificacaolead sc 
						ON sc.CodStatusClassificacaoLead = l.CodStatusClassificacaoLead
					 WHERE al.CodTipo IN (1, 4)
					   AND ( al.CodStatus in ( 1 , 2 ) or al.CodStatus is null )
					   AND ( ( al.CodUsuarioInterno = {$codUser} and al.AgendadoPara is null ) or al.AgendadoPara = {$codUser} )" ;
			
			if ( $codpolo != 100 && $codpolo != null ) 
				$sql2 .= " AND ( l.cod_polo = {$codpolo} or l.cod_polo = 100 ) " ;
				
			if ( $dti && $dtf )
				$sql2 .= " AND al.DataCadastro between '" . date( "Y-m-d" , $dti ) . " 00:00:00' and '" . date( "Y-m-d" , $dtf ) . " 23:59:59'" ;
				
			if( $dti )
				$sql2 .= " AND al.DataCadastro > '" . date( "Y-m-d" , $dti ) . " 00:00:00'" ;
				
			if( $dtf )
				$sql2 .= " AND al.DataCadastro < '" . date( "Y-m-d" , $dtf ) . " 23:59:59'" ;
				
			$sql2 .= " ORDER BY al.DataCadastro" ;

			return sql_query( $sql2 ) ;	   
	}
	
	function sql3( $codLead )
	{
		$sql3 = "SELECT p.DataEnvioContrato
				   FROM propostas p
			 INNER JOIN leads l 
					 ON l.CodLead = p.CodLead
				  WHERE l.CodLead = {$codLead}
				    AND p.DataEnvioContrato IS NOT NULL" ;
							   
		return sql_query( $sql3 ) ;					   
	}
	
	
	function analitico( $codgrupo , $nomegrupo = null , $codpolo = null , $dti = null , $dtf = null )
	{
		$cor = '' ;
		$ret = array();
		$ret['html'	   ] = '';
		$ret['toteqp'  ] = 0 ;
		$ret['toteqp1' ] = 0 ;
		$ret['toteqp2' ] = 0 ;
		$ret['toteqp3' ] = 0 ;
		$ret['toteqp4' ] = 0 ;
		$ret['toteqp5' ] = 0 ;
		$ret['toteqp6' ] = 0 ;
		$ret['toteqp7' ] = 0 ;
		$ret['toteqp8' ] = 0 ;
		$ret['toteqp9' ] = 0 ;
		$ret['totSemCl'] = 0 ;
		
		$grupo = relefetivagd::sql1( $codgrupo ) ;
		$i = 0 ;

		while( $usr = mysql_fetch_array( $grupo ) )
		{
			$tot = array() ;
			$tot['produtivo'  ] = 0 ;
			$tot['improdutivo'] = 0 ;
			$tot['indefinido' ] = 0 ;
			$tot['semint'	  ] = 0 ;
			$tot['statld25'	  ] = 0 ;
			$tot['statld50'	  ] = 0 ;
			$tot['statld75a'  ] = 0 ;
			$tot['statld75b'  ] = 0 ;
			$tot['statld100'  ] = 0 ;
			$tot['agd'		  ] = 0 ;
			$j = 0 ;
			
			$result = relefetivagd::sql2( $usr['codusr'] , $codpolo , $dti , $dtf ) ;
			
			while ( $agdrows = mysql_fetch_array( $result ) )
			{
				if ( $i == 0 && $j == 0 )
					$ret['html'] .= "<tr class='Rgrid'><th colspan='10'>Grupo: $nomegrupo</th></tr>" ;

				if ( $j == 0 )
				{
					$ret['html'] .= "<tr class='Rgrid'><th colspan='10'>Usu&#225;rio: ".$usr['usuario']."</th></tr>" ;
					$ret['html'] .= "<tr class='Rtitulo_grid'>" ;
					$ret['html'] .= "<td><b>Lead</b></td>" ;
					$ret['html'] .= "<td colspan='3'><b>Status do Agendamento</b></td>" ;
					$ret['html'] .= "<td colspan='3'><b>Status do Lead</b></td>" ;
					$ret['html'] .= "<td colspan='3'><b>Tipo de Agendamento</b></td>" ;
					$ret['html'] .= "</tr>" ;
				}
				
				$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;
				
				$ret['html'] .= "<tr>" ;
				$ret['html'] .= "<td>" . $agdrows['Lead'] . "</td>" ;
				$ret['html'] .= "<td colspan='3'>" . $agdrows['status_ag'] . "</td>" ;
				
				if ( $agdrows['codstatus_ld'] == 6 )
				{					
					$q = relefetivagd::sql3( $agdrows['CodLead'] ) ;
					
					if ( mysql_fetch_row( $q ) )
						$ret['html'] .= "<td colspan='3'>" . $agdrows['status_lead'] . " enviado para a Operadora</td>" ;
					else					
						$ret['html'] .= "<td colspan='3'>" . $agdrows['status_lead'] . " n&#227;o enviado para a Operadora</td>" ;
						
					mysql_free_result( $q ) ;
					
				}
				else
					$ret['html'] .= "<td colspan='3'>" . $agdrows['status_lead'] . "</td>" ;
					
				$ret['html'] .= "<td colspan='3'>" . $agdrows['tipo_ag'] . "</td>" ;
				$ret['html'] .= "</tr>" ;
				$tot['agd']++ ;
				
				if ( $agdrows['codstatus_ag'] == 1 )
					$tot['produtivo']++ ;
				elseif ( $agdrows['codstatus_ag'] == 2 )
					$tot['improdutivo']++ ;
				else
					$tot['indefinido']++ ;
					
				if ( $agdrows['codstatus_ld'] == 1 )
					$tot['semint']++ ;
				elseif ( $agdrows['codstatus_ld'] == 4 )
					$tot['statld25']++ ;
					elseif ( $agdrows['codstatus_ld'] == 5 )
						$tot['statld50']++ ;
						elseif ( $agdrows['codstatus_ld'] == 6 )
						{
							$q = relefetivagd::sql3( $agdrows['CodLead'] ) ;
							
							if ( mysql_fetch_row( $q ) ) 
								$tot['statld75b']++ ;
							else
								$tot['statld75a']++ ;
								
							mysql_free_result($q);
						}
							elseif( $agdrows['codstatus_ld'] == 7 )
								$tot['statld100']++ ;
			
			if ( $tot['agd'] > 0 ) 
				$j++ ;
			}
			
			if( $tot['agd'] > 0 )
			{
				$ret['html'] .= "<tr class='Rsub_total'>" ;
				$ret['html'] .= 	"<td><b>Totaliza&#231;&#227;o por Usu&#225;rio:</b></td>" ;
				$ret['html'] .= 	"<td><b>Prod.</b></td>" ;
				$ret['html'] .= 	"<td><b>Improd.</b></td>" ;
				$ret['html'] .= 	"<td><b>Indef.</b></td>" ;
				$ret['html'] .= 	"<td><b>SI</b></td>" ;
				$ret['html'] .= 	"<td><b>25%</b></td>" ;
				$ret['html'] .= 	"<td><b>50%</b></td>" ;
				$ret['html'] .= 	"<td><b>75% &#241; env.</b></td>" ;
				$ret['html'] .= 	"<td><b>75% env.</b></td>" ;
				$ret['html'] .= 	"<td><b>Cliente</b></td>" ;
				$ret['html'] .= "</tr>" ;
				$ret['html'] .= "<tr class='Rsub_total'>" ;
				$ret['html'] .= 	"<td>" . $tot['agd'] . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['produtivo'  ] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['improdutivo'] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['indefinido' ] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['semint'	  ] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['statld25'	  ] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['statld50'	  ] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['statld75a'  ] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['statld75b'  ] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $tot['statld100'  ] , $tot['agd'] ) . "</td>" ;
				$ret['html'] .= "</tr>" ;
				$ret['html'] .= "<tr><td colspan='10'><hr></td></tr>" ;
			}
			$ret['toteqp' ] += $tot['agd'	     ] ;
			$ret['toteqp1'] += $tot['produtivo'  ] ;
			$ret['toteqp2'] += $tot['improdutivo'] ;
			$ret['toteqp3'] += $tot['indefinido' ] ;
			$ret['toteqp4'] += $tot['semint'	 ] ;
			$ret['toteqp5'] += $tot['statld25'	 ] ;
			$ret['toteqp6'] += $tot['statld50'	 ] ;
			$ret['toteqp7'] += $tot['statld75a'  ] ;
			$ret['toteqp8'] += $tot['statld75b'  ] ;
			$ret['toteqp9'] += $tot['statld100'  ] ;

			if( $ret['toteqp'] > 0 ) 
				$i++ ;
		}
		
		mysql_free_result( $grupo ) ;
	
		return $ret ;
	
	}
	
	function sintetico( $codgrupo , $nomegrupo = null , $codpolo = null , $dti = null , $dtf = null )
	{
		$cor = '' ;
		$ret = array();
		$ret['html'	   ] = '';
		$ret['toteqp'  ] = 0 ;
		$ret['toteqp1' ] = 0 ;
		$ret['toteqp2' ] = 0 ;
		$ret['toteqp3' ] = 0 ;
		$ret['toteqp4a'] = 0 ;
		$ret['toteqp4b'] = 0 ;
		$ret['toteqp5' ] = 0 ;
		$ret['toteqp6' ] = 0 ;
		$ret['toteqp7' ] = 0 ;
		$ret['toteqp8' ] = 0 ;
		$ret['toteqp9' ] = 0 ;
		$ret['totSemCl'] = 0 ;
		
		$grupo = relefetivagd::sql1( $codgrupo ) ;
		
		$i = 0 ;
		while( $usr = mysql_fetch_array( $grupo ) )
		{

			$retusr  = 0 ;
			$retusr1 = 0 ;
			$retusr2 = 0 ;
			$retusr3 = 0 ;
			$retusr4 = 0 ;
			$retusr5 = 0 ;
			$retusr6 = 0 ;
			$retusr7 = 0 ;
			$retusr8 = 0 ;
			$retusr9 = 0 ;
			$rettot2 = 0 ; 

			$tot = array();
			$tot['stat0'	] = 0 ;
			$tot['stat1'	] = 0 ;
			$tot['stat2'    ] = 0 ;
			$tot['statld0a'	] = 0 ;
			$tot['statld0b'	] = 0 ;
			$tot['statld25'	] = 0 ;
			$tot['statld50'	] = 0 ;
			$tot['statld75a'] = 0 ;
			$tot['statld75b'] = 0 ;
			$tot['statld100'] = 0 ;
			$tot['sClasImp' ] = 0 ;
			$tot['agd'      ] = 0 ;
			$j = 0 ;
			
			$result = relefetivagd::sql2( $usr['codusr'] , $codpolo , $dti , $dtf ) ;
			
			while( $agdrows = mysql_fetch_array( $result ) )
			{
				if( $i == 0 && $j ==0 )
				{
					$ret['html'] .= "<tr class='Rgrid'><th colspan='12'>Grupo: $nomegrupo</th></tr>";
					$ret['html'] .= "<tr class='Rtitulo_grid'>" ;
					$ret['html'] .= 	"<td><b>Usu&#225;rio</b>" ;
					$ret['html'] .= 	"<td><b>Total por Usu&#225;rio:</b></td>" ;
					$ret['html'] .= 	"<td><b>Prod.</b></td>" ;
					$ret['html'] .= 	"<td><b>Improd.</b></td>" ;
					$ret['html'] .= 	"<td><b>Indef.</b></td>" ;
					$ret['html'] .= 	"<td><b>SI I</b></td>" ;
					$ret['html'] .= 	"<td><b>SI P</b></td>" ;
					$ret['html'] .= 	"<td><b>25%</b></td>" ;
					$ret['html'] .= 	"<td><b>50%</b></td>" ;
					$ret['html'] .= 	"<td><b>75% &#241; env.</b></td>" ;
					$ret['html'] .= 	"<td><b>75% env.</b></td>" ;
					$ret['html'] .= 	"<td><b>Cliente</b></td>" ;
				   	$ret['html'] .= "</tr>" ;
				}

				$tot['agd']++;
				if ( $agdrows['codstatus_ag'] == 1 )
					$tot['stat0']++ ;

				elseif ( $agdrows['codstatus_ag'] == 2 )
					$tot['stat1']++ ;

					else
						$tot['stat2']++ ;

				if ( $agdrows['codstatus_ld'] == 1 && $agdrows['codstatus_ag'] == 2 )
					$tot['statld0a']++ ;

				elseif ( $agdrows['codstatus_ld'] == 1 && $agdrows['codstatus_ag'] == 1 )
					$tot['statld0b']++ ;
					
					elseif ( $agdrows['codstatus_ld'] == 1 && $agdrows['codstatus_ag'] == null )
						$tot['sClasImp']++ ;
						
						elseif ( $agdrows['codstatus_ld'] == 4 )
							$tot['statld25']++ ;
	
							elseif ( $agdrows['codstatus_ld'] == 5 )
								$tot['statld50']++ ;
	
								elseif ( $agdrows['codstatus_ld'] == 6 )
								{
									$q = relefetivagd::sql3( $agdrows['CodLead'] ) ;
	
									if ( mysql_fetch_row( $q ) )
										$tot['statld75b']++ ;
	
									else
										$tot['statld75a']++ ;
	
									mysql_free_result( $q ) ;
	
								}
									elseif ( $agdrows['codstatus_ld'] == 7 )
										$tot['statld100']++ ;
			
			
			$retusr   = $tot['agd'		];
			$retusr1  = $tot['stat0'	];
			$retusr2  = $tot['stat1'	];
			$retusr3  = $tot['stat2'	];
			$retusr4a = $tot['statld0a'	];
			$retusr4b = $tot['statld0b'	];
			$sClasImp = $tot['sClasImp' ];
			$retusr5  = $tot['statld25'	];
			$retusr6  = $tot['statld50'	];
			$retusr7  = $tot['statld75a'];
			$retusr8  = $tot['statld75b'];
			$retusr9  = $tot['statld100'];

			$rettot2   = $retusr - $tot['sClasImp'] ;
			
				if($tot['agd'] > 0 ) 
					$j++ ;
			}

			if ( $retusr != 0 )
			{
				$cor = ( $cor == "#dfdfdf" ) ? "#ffffff" : "#dfdfdf" ;

			   	$ret['html'] .= "<tr>";
				$ret['html'] .= 	"<td><b>$usr[1]</b></td>" ;
				$ret['html'] .= 	"<td>$retusr</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr1  , $retusr  ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr2  , $retusr  ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr3  , $retusr  ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr4a , $rettot2 ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr4b , $rettot2 ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr5  , $rettot2 ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr6  , $rettot2 ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr7  , $rettot2 ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr8  , $rettot2 ) . "</td>" ;
				$ret['html'] .= 	"<td>" . relefetivagd::porcentagem( $retusr9  , $rettot2 ) . "</td>" ;
				$ret['html'] .= "</tr>" ;
			}

			$ret['toteqp'  ] += $tot['agd'		];
			$ret['totSemCl'] += ( $tot['agd'] - $tot['sClasImp' ] );
			$ret['toteqp1' ] += $tot['stat0'	];
			$ret['toteqp2' ] += $tot['stat1'	];
			$ret['toteqp3' ] += $tot['stat2'	];
			$ret['toteqp4a'] += $tot['statld0a' ];
			$ret['toteqp4b'] += $tot['statld0b' ];
			$ret['toteqp5' ] += $tot['statld25' ];
			$ret['toteqp6' ] += $tot['statld50' ];
			$ret['toteqp7' ] += $tot['statld75a'];
			$ret['toteqp8' ] += $tot['statld75b'];
			$ret['toteqp9' ] += $tot['statld100'];

			if( $ret['toteqp'] > 0 )
				$i++;
		}

	mysql_free_result($grupo);
	return $ret;
	}
	
	function porcentagem( $Ipercent , $total )
	{
		return  $Ipercent . "( "  . @number_format( ( $Ipercent  * 100 / $total  ) , 2 , ',' , '.' ) . "%)" ;
	}
}
?>
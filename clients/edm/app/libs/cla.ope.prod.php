<?php

class Operacao_Produto
{

	public function pega_produto( $codigo_do_produto )
	{
		$sql = "SELECT Nome ,
					   CodModelo ,
					   Descricao ,
					   Desativado
				  FROM produtos
				 WHERE CodProduto = " . mysqlnull( $codigo_do_produto ) ;

		$qry = sql_query( $sql ) ;

		$resultado = array() ;

		while ( $result =  mysql_fetch_object( $qry ) )
		{
			$resultado['Nome'      ] = $result->Nome 	   ;
			$resultado['CodModelo' ] = $result->CodModelo  ;
			$resultado['Descricao' ] = $result->Descricao  ;
			$resultado['Desativado'] = $result->Desativado ;
		}
		mysql_free_result( $qry );
		return $resultado ;
	}

	public function constroi_produto( $codigo_do_produto )
	{
	$sql = "SELECT mp.* ,
				   tm.nome nometipo ,
				   if( Eval = 1 , 'Sim' , 'Não' ) Avaliar ,
				   if( ValorFixo = 1 , 'Sim' , 'Não' ) Fixo ,
				   if( Obrigatorio = 1 , 'Sim' , 'Não' ) Obriga ,
				   if( Hidden = 1, 'Sim' , 'Não' ) Esconder
			  FROM modulosproduto mp ,
			  	   tipomodulo tm
			 WHERE mp.Tipo = tm.CodTipoModulo
			   AND mp.CodProduto = " . mysqlnull( $codigo_do_produto ) . "
		  ORDER BY mp.Grupo ,
		  		   mp.Nome ,
		  		   mp.ID ,
		  		   mp.Tipo " ;
	$qry = sql_query( $sql ) ;

	$html = array() ;
		while ( $result = mysql_fetch_object( $qry ) )
		{
			$valor = stripslashes( htmlentities( $result->Valor ) ) ;
			$grupo = ( !empty( $result->Grupo ) ? $result->Grupo . '.' : '' ) ;
			if ( $result->Tipo == 8 || $result->Tipo == 9 )
			{
				$valor1 = str_replace( '|' 		 , '<br />' , $valor  ) ;
				$valor1 = str_replace( chr( 13 ) , '<br />' , $valor1 ) ;
			}
			else
			{
				$valor1 = $valor ;
			}

			$html['html'] .=  "<tr>
								<td>
									<input type='radio' name='rd' value='" . $result->ID . "' />
									<input type='hidden' name='modulos[" .  $result->ID . "][id]' 		  	      value='" . $result->ID ."' 			/>
									<input type='hidden' name='modulos[" .   $result->ID . "][nome]' 		  value='" . $result->Nome . "' 		/>
									<input type='hidden' name='modulos[" .   $result->ID . "][grupo]' 	      value='" . $result->Grupo . "' 		/>
									<input type='hidden' name='modulos[" .   $result->ID . "][tipo]' 		  value='" . $result->Tipo . "' 		/>
									<input type='hidden' name='modulos[" .   $result->ID . "][valor]' 	      value='" . $valor . "'  				/>
									<input type='hidden' name='modulos[" .   $result->ID . "][eval]' 		  value='" . $result->Eval . "' 		/>
									<input type='hidden' name='modulos[" .   $result->ID . "][valorfixo]'     value='" . $result->ValorFixo . "' 	/>
									<input type='hidden' name='modulos[" .   $result->ID . "][obrigatorio]'   value='" . $result->Obrigatorio . "' 	/>
									<input type='hidden' name='modulos[" .   $result->ID . "][hidden]' 	      value='" . $result->Hidden . "' 		/>
								</td>
								<td>" . htmlentities( $grupo ) . $result->ID . "</td>
								<td>" . htmlentities( $result->Nome ) .		   "</td>
								<td>" . $result->nometipo . 				   "</td>
								<td>" . $valor1 . 							   "</td>
								<td>" . $result->Avaliar . 					   "</td>
								<td>" . $result->Fixo . 					   "</td>
								<td>" . $result->Obriga . 					   "</td>
								<td>" . $result->Esconder . 				   "</td>
							</tr> " ;

		}
		mysql_free_result( $qry );
		return $html ;
	}

	public function detalhe_produto( $codigo_do_produto )
	{
		$sql = "SELECT Nome ,
					   CodModelo ,
					   Descricao ,
					   Desativado
				  FROM produtos
				 WHERE Codproduto = $codigo_do_produto " ;

		$qry = sql_query( $sql ) ;

		$resultado = mysql_fetch_assoc( $qry ) ;

		$resultado['Desativado'] = ( $resultado['Desativado'] == 1 ) ? 'Sim' : 'Não' ;

		mysql_free_result( $qry ) ;

		return  $resultado ;
	}

	public function modelo_nome( $codigo_modelo )
	{
		$sql = "SELECT Nome
				  FROM modelos
				 WHERE codmodelo = " . mysqlnull( $codigo_modelo ) ;
		$qry = sql_query( $sql ) ;

		$nome = mysql_result( $qry , 0 , 0 ) ;

		mysql_free_result( $qry ) ;

		return $nome ;
	}

	public function monta_corpo_detalhe( $codigo_do_produto )
	{
		$sql = "SELECT ID ,
					   Grupo ,
					   Nome ,
					   Tipo ,
					   Valor ,
					   ValorFixo
				  FROM modulosproduto
				 WHERE CodProduto = " . mysqlnull( $codigo_do_produto ) . "
			  ORDER BY Grupo, Nome " ;

		$qry = sql_query( $sql ) ;
		$html = array() ;

		while ( $result = mysql_fetch_assoc( $qry ) )
		{
			$html['html'] .= "<tr>
								<td>" . $result['ID'] 							 . "</td>
								<td>" . htmlentities( $result['Grupo'] ) 		 . "</td>
								<td>" . htmlentities( $result['Nome' ] ) 		 . "</td>
								<td>" . $result['Tipo'] 						 . "</td>
								<td>" . htmlentities( $result['Valor'] ) 		 . "</td>
								<td>" . ( $result['ValorFixo'] ? 'Sim' : 'Não' ) . "</td>
							  </tr>" ;
		}

		mysql_free_result( $qry ) ;

		return $html ;
	}

}

?>
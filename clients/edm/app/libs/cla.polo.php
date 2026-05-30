<?php

include_once ( "combo.php" ) ;

class polo 
{
	
	function mostra_polo( $Cod_Polo_Session , $Cod_Lead_Request , $Cod_Polo_Request , $Nome_Do_Combo , $Texto_Inicial = null , $Valor_Inicial = null )
	{
		if (  $Cod_Polo_Session != 100 )
		{
			//Usuario Padrao
			
			$sql = "SELECT p.cod_polo , 
						   c.dsc_cidade 
					  FROM polo p
			    INNER JOIN cidade c 
			            ON p.cod_cidade = c.cod_cidade 
			         WHERE p.cod_polo = " . $Cod_Polo_Session . "
			      ORDER BY c.dsc_cidade " ;
			
			if ( $Cod_Lead_Request == "" )
			{ ?>
				<input type="hidden" name="cod_polo" id="cod_polo" value="<?= $Cod_Polo_Session ; ?>">
				<? combo_disabled( $sql , $Nome_Do_Combo , $Cod_Polo_Session , $Texto_Inicial , "disabled" ) ; ?>
				<input type="hidden" name="cod_polo" id="cod_polo" value="<?= $Cod_Polo_Request ; ?>">
				<? combo_disabled( $sql , $Nome_Do_Combo , $Cod_Polo_Request , $Texto_Inicial , "disabled" ) ;
			}
		}
		else
		{
			//Usuario Diferenciado
			$sql = "SELECT p.cod_polo , 
						   c.dsc_cidade 
					  FROM polo p
			    INNER JOIN cidade c 
			            ON p.cod_cidade = c.cod_cidade
			         WHERE p.cod_polo != 100
			      ORDER BY c.dsc_cidade " ;
			
			combo( $sql , $Nome_Do_Combo , $Cod_Polo_Request , $Texto_Inicial , $Complemento , $Valor_Inicial ) ;
		}
	}
}							


?>
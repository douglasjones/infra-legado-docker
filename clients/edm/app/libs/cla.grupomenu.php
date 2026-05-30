<? include_once ( "../../libs/datas.php"    ) ;
   include_once ( "../../libs/cla.logg.php" ) ;
   
class grupomenu {

	function adicionar($value){
			 
		$sql = "delete from grupo_menu where codgrupousuariointerno=".$value['codgrupousuariointerno'];
		sql_query($sql);		
		
		foreach($value['cod_menu'] as $value['cod_menu']){
			$cod_menu=$value['cod_menu'];
			$codgrupousuariointerno=$value['codgrupousuariointerno'];

			$sql = "Insert Into grupo_menu(cod_menu, codgrupousuariointerno) Values ($cod_menu,$codgrupousuariointerno)";

			sql_query($sql);
		}
		
		foreach ($value['ac']as $value['ac']){
			
			$sql = "update grupo_menu set acessar=".$value['ac'];
			$sql .= " where codgrupousuariointerno=".$value['codgrupousuariointerno'];
			$sql .= " and cod_menu=".$value['ac']; 
	
			sql_query($sql);
		
		}

		//logg::insert(2, $codgrupousuariointerno);

		return $codgrupousuariointerno;

	}	
}
?>


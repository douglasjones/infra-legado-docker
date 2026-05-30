<?
class menu {
	function adicionar($value){

		$sql   = " Select max(ordem) from menu ";
		$ordem = mysql_result(sql_query($sql),0);
		$ordem += 1 ;
		if(!isset( $value['dsc_menu'  ] ) ) return false;
		if(!isset( $value['cod_status'] ) ) return false;
		if(!isset( $value['dat_cad'   ] ) ) $value[ 'dat_cad' ] = 'SYSDATE()';
		$fields = array();
		$fields['dsc_menu'  ] = $value['dsc_menu'  ];
		$fields['cod_status'] = $value['cod_status'];
		$fields['dat_cad'   ] = $value['dat_cad'   ];
		$fields['ordem'     ] = $ordem              ;

		$sql = sqlinsert( 'menu' , $fields );
		sql_query($sql);
		$codmenu = mysql_insert_id();
		return $codmenu;
	}

	function alterar($value){
		if(!isset( $value['dsc_menu'  ] ) ) return false ;
		if(!isset( $value['cod_status'] ) ) return false ;
		if(!isset( $value['ordem'     ] ) ) return false ;
		$fields = array();
		$fields['dsc_menu'  ] = $value['dsc_menu'  ];
		$fields['cod_status'] = $value['cod_status'];
		$fields['ordem'     ] = $value['ordem'     ];

		$sql = sqlupdate( 'menu' , $fields , 'cod_menu = '.$value['codmenu']) ;
		sql_query($sql);
		return true;
	}

	function excluir($codmenu){
		if(!$codmenu) return false;
		if(sql_query("delete from menu where cod_menu = $codmenu"));
		return true;

		return false;
	}

	function adicionar_sub_menu( $value )
	{
		$sql = " Select max(ordem) from submenu where ";
		if($value['cod_menu']) $sql .= "cod_menu = ".$value['cod_menu'];
		elseif($value['cod_submenu_pai']) $sql .= "cod_submenu_pai = ".$value['cod_submenu_pai'];

		$ordem = mysql_result(sql_query($sql),0);
		$ordem += 1 ;

		if( !isset( $value['dsc_submenu' ] ) ) return false ;
		if( !isset( $value['link'        ] ) ) return false ;
		if( !isset( $value['dat_cad'     ] ) ) $value[ 'dat_cad' ] = 'SYSDATE()' ;
	
		
			
		$fields = array() ;

		$fields['cod_menu'        ] = $value['cod_menu'        ] ;
		$fields['dsc_submenu'     ] = $value['dsc_submenu'     ] ;
		$fields['cod_submenu_pai' ] = $value['cod_submenu_pai' ] ;
		$fields['cod_status'      ] = $value['status'          ] ;
		$fields['dat_cad'         ] = $value['dat_cad'         ] ;
		$fields['link'            ] = $value['link'            ] ;
		$fields['target'          ] = $value['target'          ] ;
		$fields['width'           ] = $value['width'           ] ;
		$fields['height'          ] = $value['height'          ] ;
		$fields['cod_acao'        ] = $value['cod_acao'        ] ;
		$fields['cod_modulo_menu' ] = $value['cod_modulo_menu' ] ;
		$fields['cod_relacionador'] = $value['cod_relacionador'] ;
		$fields['ordem'           ] = $ordem ;
		$fields['status'          ] = $value['status'          ] ;

		$sql         = sqlinsert( 'submenu' , $fields ) ;
		sql_query($sql);
		$codsubmenu  = mysql_insert_id();
		return $codsubmenu ;
	}
	function alterar_sub_menu($value){

		if( !isset( $value['cod_menu' ] ) && !isset( $value['cod_submenu_pai' ]  ) ) return false ;
		if( !isset( $value['dsc_submenu' ] ) ) return false ;
		if( !isset( $value['link'        ] ) ) return false ;
		if( !isset( $value['dat_cad'     ] ) ) $value[ 'dat_cad' ] = 'SYSDATE()' ;

		$fields = array() ;

		$fields['cod_menu'        ] = $value['cod_menu'        ] ;
		$fields['dsc_submenu'     ] = $value['dsc_submenu'     ] ;
		$fields['cod_submenu_pai' ] = $value['cod_submenu_pai' ] ;
		$fields['cod_status'      ] = $value['status'          ] ;
		$fields['dat_cad'         ] = $value['dat_cad'         ] ;
		$fields['link'            ] = $value['link'            ] ;
		$fields['target'          ] = $value['target'          ] ;
		$fields['width'           ] = $value['width'           ] ;
		$fields['height'          ] = $value['height'          ] ;
		$fields['cod_acao'        ] = $value['cod_acao'        ] ;
		$fields['cod_relacionador'] = $value['cod_relacionador'] ;
		$fields['ordem'           ] = $value['ordem'           ] ;
		$fields['status'          ] = $value['status'          ] ;

		$sql = sqlupdate( 'submenu' , $fields , 'cod_submenu = '.$value['codsubmenu']);
		sql_query($sql);
		return true;
	}


	function excluir_sub_menu($codsubmenu){
		if(!$codsubmenu) return false;
		if(sql_query("delete from submenu where cod_submenu = $codsubmenu"));
		return true;

		return false;
	}

	function adicionar_relacionador( $value )
	{
		if( !isset( $value['dsc_tabela'      ] ) ) return false ;
		if( !isset( $value['dsc_relacionador'] ) ) return false ;
			
		$fields = array() ;

		$fields['dsc_relacionador'] = $value['dsc_relacionador'] ;
		$fields['dsc_tabela'      ] = $value['dsc_tabela'      ] ;
		$fields['status'          ] = $value['status'          ] ;

		$sql         = sqlinsert( 'relacionador' , $fields ) ;
		sql_query($sql);
		$cod_rel  = mysql_insert_id();
		return $cod_rel ;
	}
}
?>


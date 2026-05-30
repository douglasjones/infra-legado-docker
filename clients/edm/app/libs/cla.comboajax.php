<?php

/**
 *	Created on 09/02/2009 by Rogério Avelino da Silva
 *
 */

class ComboAjax
{	
	public static function getJavascript()
	{
		echo "<script language='javascript'>
				function vaiAjax( campo , campo2 , campo3 )
				{	
						
					var url = '../../libs/ajaxcombo.php?campo=' + campo + '&campo2=' + campo2 + '&campo3=' + campo3 ;
					var pars = null ;
					var myAjax = new Ajax.Updater( 'span' + campo , url , { method: 'get' , parameters: pars } ) ;
					\$( 'esc_' + campo ).style.display = 'none' ;
					
				}
			</script>" ;
	}
	
	public static function getCarregando()
	{
		echo "<span id='msg' style='display:none;''>Carregando...<img src='../../imagens/spinner.gif' /></span>" ;
	}
	
	public static function getPolo( $sessao , $codpolo )
	{
		echo "<span id='spanpolo'></span>
			  <input type='button' id='esc_polo' value='Escolher' onclick='vaiAjax( \"polo\" , \"$sessao\" , \"$codpolo\" )' />" ;
	}
	
	public static function getStatus()
	{
		echo "<span id='spanstatus'></span>
			  <input type='button' id='esc_status' value='Escolher' onclick='vaiAjax( \"status\" );'>" ;
	}
	
	public static function getGerente()
	{
		echo "<span id='spangerente'></span>
			  <input type='button' id='esc_gerente' value='Escolher' onclick='vaiAjax( \"gerente\" )'/>" ;
	}
	
	public static function getAtendente()
	{
		echo "<span id='spanatendente' ></span>
			  <input type='button' id='esc_atendente' value='Escolher' onclick='vaiAjax( \"atendente\" , \"$Atendente\" )'/> " ;
	}
	
	public static function getMailing()
	{
		echo "<span id='spanmailing'></span>
			  <input type='button' id='esc_mailing' value='Escolher' onclick='vaiAjax( \"mailing\" )'/>" ;
	}
	
	public static function getTipo()
	{
		echo "<span id='spantipo'></span>
			  <input type='button' id='esc_tipo' value='Escolher' onclick='vaiAjax( \"tipo\" )'/>" ;
	}
	
	public static function getEquipe( $gerequipe = null , $GerenteContas = null )
	{
		echo "<span id='spanequipe'></span>
			  <input type='button' id='esc_equipe' value='Escolher' onclick='vaiAjax( \"equipe\" , \"$gerequipe\" , \"$GerenteContas\" )'/>" ;
	}
	
	public static function getConsEq( $GerenteContas )
	{
		echo "<span id='spanconseq'></span>
			  <input type='button' id='esc_conseq' value='Escolher' onclick='vaiAjax( \"conseq\" , \"$GerenteContas\" )'/>" ;
	}
		
}
?>
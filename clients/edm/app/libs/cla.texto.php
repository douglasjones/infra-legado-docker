<?

class GeraTxt
{
	var $diretorio;
	var $arquivo ;
	var $texto ;

	public function diretorio_existe( $diretorio )
	{

		$this->diretorio = $diretorio ;
		if ( !is_dir( $this->diretorio ) )
		{
			$this->diretorio = false ;
		}

		return $this->diretorio ;
	}

	public function arquivo_existe( $arquivo )
	{
		$this->arquivo = $this->diretorio . $arquivo . ".txt" ;

		if ( file_exists( $this->arquivo ) )
		{
			$this->arquivo = false ;
		}
		return $this->arquivo ;
	}

	public function geraTxt( $texto )
	{
		$cria    = fopen( $this->arquivo , "w" ) ;
		$escreve = fwrite( $cria , $texto ) ;

		fclose( $cria ) ;

		return true ;
	}
}
?>
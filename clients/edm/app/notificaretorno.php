<?	include_once "libs/maininclude.php";
	date_default_timezone_set('America/Sao_Paulo');
	$data =  date('d/m/y');
	$hora = date('H:i:s');			
	
	$data =  date('y-m-d');
	$horarioverao = $data." ".$hora; 
  
    $sql = "SELECT oc.codocorrencialead
            FROM leads l
                INNER JOIN ocorrenciaslead oc ON l.codlead = oc.codlead
                INNER JOIN usuariosinternos ui ON oc.agendadopara = ui.CodUsuarioInterno
            WHERE oc.dt_retorno_fechamento IS NULL
                AND oc.dt_retorno<='$horarioverao'";
    $sql .= "   AND ui.codusuariointerno =". mysqlnull($_SESSION['codusuario']);
    $sql .= "  ORDER BY oc.dt_retorno";
    
	$rs = sql_query($sql, null, false);
	$left = 0;
	if($row = mysql_fetch_array($rs)){ ?>
		<script type="text/javascript" language="javascript">
			window.open('retornos.php', 
				'listaretornos',
				'top=100,left=50,height=600,width=800,scrollbars=yes');
		</script>
<?	}
	
mysql_free_result($rs); 
include_once "libs/desconectar.php";
?>
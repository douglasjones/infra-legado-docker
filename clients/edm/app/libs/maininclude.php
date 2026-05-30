<?session_start();

define('VERSION', '1.1.0.74');
define('INS', 'ins');
define('UPD', 'upd');
define('DEL', 'del');

include_once "conectar.php";
conectar();

$GerenteContas = false;
$Atendente = false;
$Root = false;
$Admin = false;

$operador = " <> ";
$bloqueado = 0;
$sql = "select max(bloqueado) bloqueado from empresa ";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$bloqueado = $row["bloqueado"];
mysql_free_result($result);

if($bloqueado == 1){
    $operador = " > ";
}

if(!empty($_SESSION['codusuario'])){
	
	mysql_select_db($bd);
	$sql = "select CodUsuarioInterno, Nome, Login from usuariosinternos where login = '" . mysql_real_escape_string($_SESSION['login']) . "' and CodUsuarioInterno = '" . mysql_real_escape_string($_SESSION['codusuario']) . "' And Desativado ".$operador." 1";
	$result = mysql_query($sql) or die (mysql_error());
	$row = mysql_fetch_array($result);
	if (!$row){
		$_SESSION['bd'] = null;
		$_SESSION['codusuario'] = null;
		$_SESSION['nomeusuario'] = null;
		$_SESSION['login'] = null;
		?>
			<script type="text/javascript" language="javascript">
				parent.location.href = '/index.php'
			</script>
		<?
		exit(0);
	}
}
else{
	//Se não existir a sessão, mata qualquer sessão existente.
	session_destroy();
	
	//redireciona para a tela de login.
	?>
	<script>
		top.location.href = "/index.php";
	</script>
	<?
	exit(0);
}
 
$sql = "select CodUsuarioInterno, GerenteContas, Atendente from usuariosinternos where CodUsuarioInterno =".mysqlnull($_SESSION['codusuario']);
$result = mysql_query($sql) or die (mysql_error());
$row = mysql_fetch_array($result);

$sql = "Select * from gruposusuariosinternos_usuariosinternos where CodUsuarioInterno = " . mysqlnull($_SESSION['codusuario']) . " And CodGrupoUsuarioInterno = 1";
$rs = sql_query($sql);
$num = mysql_num_rows($rs);
mysql_free_result($rs);

$GerenteContas = $row['GerenteContas'] && $num == 0;
$Atendente = $row['Atendente'] && $num == 0;
$Root = ($row['CodUsuarioInterno'] == 1);
$Admin = $num > 0;
$NomeUsuario = $_SESSION['nomeusuario'];

//RENOVA SESSAO se não for popup de retornos.
$pagina = $_SERVER['PHP_SELF'] ;
if ( !eregi( '(retornos|notificaretorno)\.php$' , $pagina ) )
{	//javascriptalert( "Entrou" , false , false ) ;
	$_SESSION['tempo'] = $_SERVER['REQUEST_TIME'] ;
}


function get_dbnames(){
	$dbnames = array();
		$dbnames[$bd] = $bd;
	return $dbnames;
}

function empresa_operador($cod_operador){
	$sql = "Select  
				eo.cod_operador
			from empresa_operador eo
			where dat_canc is null";
	$result = sql_query($sql);
	//$operador = array();
	while($row = mysql_fetch_array($result)){			
		$operador = $row['cod_operador']; 			
		if($operador == $cod_operador){
			
			return $operador;
		}
	}		
}

function permissao($pagina, $tipo = array('ic', 'al', 'ex', 'cs', 'dt')){
	global $Root;
	global $Admin;	
	if($Root || $Admin)
		return true;
	if(!is_array($pagina))
		$pagina = array($pagina);
	if(!is_array($tipo))
		$tipo = array($tipo);

	$sql = "";
	$sql .= "Select " . implode(", ", $tipo) . " From gruposusuariosinternos_paginas gup ";
	$sql .= " Inner Join gruposusuariosinternos_usuariosinternos guu on gup.CodGrupoUsuarioInterno = guu.CodGrupoUsuarioInterno ";
	$sql .= " Inner Join paginas p on gup.CodPagina = p.CodPagina ";
	$sql .= " Where guu.CodUsuarioInterno = ".$_SESSION['codusuario'];
	$sql .= " And p.Nome In ('".implode("', '", $pagina)."')";
	
	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		foreach($row as $campo){
			$permissao = ($permissao || ($campo == 1));
			if($permissao){
				mysql_free_result($result);
				return $permissao;
			}
		}
	}
	mysql_free_result($result);
	return $permissao;
}

function mysqlnull($value){
	if($value == 'null')
		return $value;
	elseif(ereg('^[a-zA-Z_][0-9a-zA-Z]*\([^}]*)$', $value))
		return $value;
	elseif(is_null($value))
		return "null";
    elseif(trim($value) == "")
        return "null";
	else
		return "'" . mysql_escape_string($value) . "'";
}

function ismysqlnull($value){

	if($value == 'null')

		return true;

	elseif(ereg('^[a-zA-Z_][0-9a-zA-Z]*\(', $value))

		return true;

	elseif(is_null($value))

		return true;

	else

		return false;

}


//FUNCTION LOG
function registra_log($tipo,$table,$fields,$campos,$set,$where){
	if($tipo==1 || $tipo==2){
        $sql = "Select
                  lb.tabela,
                  lb.n_fx,
                  lb._pk
                from log_nome_table lb
                where lb.tabela='".$table."'";    

    	$result = mysql_query($sql);        
        if($row = mysql_fetch_array($result)){
           $sqll = "Select";
           $sqll .=" ".$row['_pk']." as codlead";
           $sqll .=" from ".$table;
           $sqll .=" where ".$where; 

           $result1 = mysql_query($sqll);           
           if($row1 = mysql_fetch_array($result1)){    
				
                $codlead  = $row1['codlead'];
                if($tipo==2){
                    $sql2 = "Select
                            l.razaosocial
                            from leads l
                            where l.codlead=".$codlead;
                   	$result2 = mysql_query($sql2);
                    if($row2 = mysql_fetch_array($result2)){
                        $razaosocial = $row2['razaosocial'];
                    }    
                }
                
           }  
        }     
    }
    if(empty($codlead)){
        $codlead = "null";
    }
    //ALTERACAO
	if($tipo==1){
		$res = mysql_query('select 0,'.$campos.'  from '.$table ." where $where");	
	
		if($row = mysql_fetch_array($res)){
			array_merge($row, $_REQUEST);
			$_REQUEST = $row;
		}
		$into = array();
		$values = array();
		$memo = array();
		$c = '0';
		foreach($fields as $field => $value){
			
			if($c=='0'){
				$campo = mysql_field_name($res, 1);
				$valor = @$_REQUEST[mysql_field_name($res, 1)];			
				$c ++;
			}else{
				$campo = mysql_field_name($res, $c);
				$valor = @$_REQUEST[mysql_field_name($res, $c)];
			}					
				if($valor == $value){
				    $memo[] = "<tr align=left><td><b>". $campo ."</b>=". $valor."</td></tr>";
					$memo_novo[] = "<tr align=left><td><b>".$field ."</b>=".$value."</td></tr>";
				}else{  
					$memo[] = "<tr align=left><td><b>". $campo ."</b>=". $valor."</td></tr>";
					$memo_novo[] = "<tr align=left><td><b>".$field ."</b>=<font color=#ff0000>".$value."</font></td></tr>";
				}
					$c ++;
			if($valor =! $value){
				$vazio = 1;
			}
			
		}
		
			//RETIRA AS ASPAS DO CAMPO REFERENCIA
			$fk = str_replace ("'", "", $where); 		
			//INSERT LOG			
            $sql = "insert into log (cod_tipolog,tabela,fk,c_atual,c_novo,codusuariointerno,dt_log,fk_lead) values ($tipo,'".$table."','".$fk."','".implode(" ",$memo)."','".implode(" ",$memo_novo)."',".$_SESSION['codusuario'].",SYSDATE(),".$codlead.")";

            sql_query($sql);
     
		
	}
	//EXCLUSAO
	if($tipo=='2'){
		$fk = str_replace ("'", "", $where); 		
		$sql = "insert into log (cod_tipolog,tabela,codusuariointerno,dt_log,fk_lead,fk) values ($tipo,'".$table."',".$_SESSION['codusuario'].",SYSDATE(),'".$fields."','".$razaosocial."')";

        sql_query($sql);		
	}
}
//FUNCAO INSERT 
function sqlinsert($table, $fields){
	if(empty($table)) return null;
 
	if(!is_array($fields)) return null;

	$into = array();
	$values = array();
	foreach($fields as $field => $value){
		$value = (!is_null($value) && empty($value) && $value != 0?'null':$value);
		if(!empty($value) || $value == '0'){
			$into[] = $field;
			$values[] = mysqlnull($value);
		}
	}
	$into = implode(", ", $into);
	$values = implode(", ", $values);

	$sql = "Insert Into $table ($into) Values (" . $values . ")";
	return $sql;
}
//FUNCAO UPDATE
function sqlupdate($table, $fields, $where = null){

	if(empty($table)) return null;
	if(!is_array($fields)) return null;
	$set = array();
	$into = array();
	foreach($fields as $field => $value){
		$value = (!is_null($value) && empty($value) && $value != 0?'null':$value);
		$campos[] = $field;
		$into[] = $field;
		if(!empty($value) || $value == '0')
			$set[] = "$field = " . mysqlnull($value);
	}
	if(empty($set)) return null;
	
	$into = implode(",", $into);
	$campos = implode(",", $campos);
	
	$sql = "Update $table Set ". implode(", ", $set);
	//print $sql."<br>";
	 
	//LOG
	registra_log(1,$table,$fields,$campos,$set,$where);
	if(!empty($where))
		$sql .= " Where $where";		
	return $sql;
}

//FUNCAO DELETE
function sqldelete($table,$where){

	$sql = "select codlead  from $table where ".$where;

	$result = sql_query($sql);
	$num = $num = mysql_num_rows($result);
	
	if($num>'0') {

		if($row = mysql_fetch_array($result)){
			array_merge($row, $_REQUEST);
			$_REQUEST = $row;
		}
		$fields = $row['codlead'];
	}
	
	$sql = "delete from $table where ".$where;

	registra_log(2,$table,$fields,$campos,$set,$where);
	return $sql;
}



function moduloValor($modulos, $mdl, $campo = null, $format = false, $forcar = false){

	if(!isset($modulos[$mdl]))

		return null;

	$modulo = $modulos[$mdl];

	$tmp = null;

	$tmp = $modulo['valor'];

	if($modulo['tipo'] == 12)

		return $tmp;

	if($modulo['eval'] == 1){

		if(!$forcar && !in_array($modulo['tipo'], array(8, 9, 10, 11, 12)) && !empty($modulo['calculado'])){

			$tmp = $modulo['calculado'];

		}else{

			//#[php|javascript]

			$tmp = ereg_replace('(#\[([^]|]*)(\|([^]]*))?\])', '\2', $tmp);

			//#modulo;

			$reg = array();

			/*

			0 - Matched

			1 - Modulo

			2 - .Propriedade

			3 - Propriedade

			*/

			preg_match_all('/#([A-Za-z][A-Za-z0-9]+)(\.([A-Za-z0-9]+))?;/', $tmp, $reg);

			for($i = 0; $i < count($reg[0]); $i++){

				$val = moduloValor($modulos, $reg[1][$i], $reg[3][$i]);

				if(is_array($val)){

					foreach($val as $index => $val1){

						if(is_array($val1)){

							$val[$index] = array_pop($val1);

						}

					}

					$val = '$_tmp = array(' . implode(', ', $val) . ')';

				}

				$tmp = str_replace($reg[0][$i], $val, $tmp);

			}

			if(ereg('\|', $tmp)){

				$tmp = 'array('.ereg_replace('\|', ',', $tmp).')';

				$tmp = htmlentitiesdecode($tmp);

				$tmp1 = $tmp;

				$tmp = null;

				@eval('$tmp = ' . $tmp1 . ';');

				$tmp = implode('|', $tmp);

			}else{

				$tmp = htmlentitiesdecode($tmp);

				$tmp1 = $tmp;

				$tmp = null;

				@eval('$tmp = ' . $tmp1 . ';');

			}

		}

	}

	switch($modulo['tipo']){

		case 1: //String

			return $tmp;

			break;

		case 2: //Inteiro

			if($format)

				return number_format($tmp, 0, ',', '.');

			else

				return (empty($tmp)?0:$tmp);

			break;

		case 3: //Moeda

			if($format)

				return 'R$ '.number_format($tmp, 2, ',', '.');

			else

				return (empty($tmp)?0:$tmp);

			break;

		case 4: //Data

			switch($campo){

				case 'dia':

					return date('d', strtotime($tmp));

					break;

				case 'mes':

					return date('m', strtotime($tmp));

					break;

				case 'nomemes':

					$nomemes = array(1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro');

					return $nomemes[date('n', strtotime($tmp))];

					break;

				case 'ano':

					return date('Y', strtotime($tmp));

					break;

				default:

					return date('d/m/Y', strtotime($tmp));

					break;

			}

			break;

		case 5: //Hora

			switch($campo){

				case 'hora':

					return date('H', strtotime($tmp));

					break;

				case 'minuto':

					return date('i', strtotime($tmp));

					break;

				case 'segundo':

					return date('s', strtotime($tmp));

					break;

				default:

					return date('H:i:s', strtotime($tmp));

					break;

			}

			break;

		case 6: //Hora Curta

			switch($campo){

				case 'hora':

					return date('H', strtotime($tmp));

					break;

				case 'minuto':

					return date('i', strtotime($tmp));

					break;

				default:

					return date('H:i', strtotime($tmp));

					break;

			}

			break;

			break;

		case 7: //Ponto Flutuante

			if($format)

				return number_format($tmp, 2, ',', '.');

			else

				return $tmp * 1;

			break;

		case 8: //Lista

			$tmp = explode('|', $tmp);

			$ret = null;

			foreach($tmp as $opt){

				ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);

				$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);

				if(!empty($reg[1])){

					$ret[] = array($reg[2], $reg[3]);

					break;

				}

			}

			switch($campo){

				case 'chave':

					return $ret[0][0];

					break;

				case 'valor':

					return $ret[0][1];

					break;

				default:

					return $ret;

					break;

			}

			break;

		case 9: //Lista Múltipla

			$tmp = explode('|', $tmp);

			$ret = null;

			foreach($tmp as $opt){

				ereg('(\*?)([^=]*)=?(.*)', $opt, $reg);

				$reg[3] = (empty($reg[3])?$reg[2]:$reg[3]);

				if(!empty($reg[1])){

					switch($campo){

						case 'chave':

							$ret[] = $reg[2];

							break;

						case 'valor':

							$ret[] = $reg[3];

							break;

						default:

							$ret[] = array($reg[2], $reg[3]);

							break;

					}

				}

			}

			return $ret;

			break;

		case 10: //Array

			$tmp = explode('|', $tmp);

			$ret = null;

			foreach($tmp as $opt){

				ereg('([^=]*)=?(.*)', $opt, $reg);

				$reg[2] = (empty($reg[2])?$reg[1]:$reg[2]);

				$ret[$reg[1]] = $reg[2];

				if(!empty($campo) && $campo != 'chave' && $campo != 'valor'){

					if($campo == $reg[1])

						$ret[] = array($reg[1], $reg[2]);

				}else{

					switch($campo){

						case 'chave':

							$ret[] = $reg[1];

							break;

						case 'valor':

							$ret[] = $reg[2];

							break;

						default:

							$ret[] = array($reg[1], $reg[2]);

							break;

					}

				}

			}

			return $ret;

			break;

		case 11: //Valor x Quantidade

			$tmp = explode('|', $tmp);

			$valor = (isset($tmp[0])?$tmp[0]:null);

			$qtde = (isset($tmp[1])?$tmp[1]:null);

			$total = $valor * $qtde;

			if($format){

				$valor = 'R$ '.number_format($valor, 2, ',', '.');

				$qtde = number_format($qtde, 0, ',', '.');

				$total = 'R$ '.number_format($total, 2, ',', '.');

			}

			switch($campo){

				case 'valor':

					return $valor;

					break;

				case 'quantidade':

					return $qtde;

					break;

				default:

					return $total;

					break;

			}

			break;

	}

}



function modulosProposta($codproposta, $versao, $codlead){

	$modulos = null;

	$sql = "select * from modulosproposta where codproposta = " . mysqlnull($codproposta) . " and versao = " . mysqlnull($versao) . " and codlead = " . mysqlnull($codlead) . " Order By Grupo, Nome, ID";

	$result = sql_query($sql);

	$modulos = array();

	while($row = mysql_fetch_assoc($result)){

		$modulos[$row['ID']] = array();

		foreach($row as $campo => $valor){

			if(strtolower($campo) == 'valor'){

				$valor = stripslashes($valor);

			}

			$modulos[$row['ID']][strtolower($campo)] = $valor;

		}

	}

	mysql_free_result($result);

	return $modulos;

}



function moduloProposta($codproposta, $versao, $codlead, $mdl, $campo = null, $format = false, $forcar = false){

	$modulos = modulosProposta($codproposta, $versao, $codlead);

	return moduloValor($modulos, $mdl, $campo, $format, $forcar);

}



function totalProposta($codproposta, $versao, $codlead){

	return moduloProposta($codproposta, $versao, $codlead, 'totalproposta');

}

function htmlentitiesdecode($given_html, $quote_style = ENT_QUOTES){

	$trans_table = array_flip(get_html_translation_table(HTML_ENTITIES, $quote_style));

	$trans_table['&#39;'] = "'";

	$given_html = strtr($given_html,$trans_table);

	while(ereg('\&\#([0-9]+)\;', $given_html, $reg)){

		$given_html = str_replace($reg[0], chr($reg[1]), $given_html);

	}

	return $given_html;

}



function javascriptalert($message, $reload = true, $close = true){

	$reload = ($reload?'if(opener) opener.location.reload()':'');

	if($reload){

		$reload = <<<JAVASCRIPT

		if(opener){

			if(opener.top.pagina)

				opener.top.pagina.location.reload()

			else

				opener.location.reload()

		}

JAVASCRIPT;

	}

	$close = ($close?'self.close()':'');?>

	<script type="text/javascript" language="javascript">

		alert("<?=$message;?>")

		<?=$reload;?>

		<?=$close;?>

	</script>

<?

}



function emptynull($var) {

	if(is_integer($var)) {

		$ret = $var;

	}

	elseif(is_string($var) && strlen($var)>0) {

		$ret = '"'.str_replace("'", "\'", str_replace('"', '\"', trim($var))).'"';

	}

	elseif(is_string($var) && strlen($var)>=0) {

		$ret = 'null';

	}

	else {

		$ret = 'null';

	}

	return $ret;

}



if(!function_exists('scandir')){

	function scandir($path){

		$files = array();

		if (is_dir($path)) {

			if ($dir = opendir($path)) {

				while (($file = readdir($dir)) !== false) {

					$files[] = $file;

				}

				closedir($dir);

			}

		}

		return $files;

	}

}



function sql_query($query, $bd = null, $write_log = false){

	if(empty($bd)){

		$bd = $_SESSION['bd'];

	}

	if($bd != $_SESSION['bd']){

//		$link = mysql_connect('localhost', 'bestpart_bestpar', 'motorola') or die('Não foi possível conectar: ' . mysql_error());

		mysql_query("SET time_zone = '-03:00';");



//		mysql_select_db($bd, $link);

		mysql_select_db($bd);

//		$time_begin = getmicrotime();

		set_time_limit(100);

//		$result = mysql_query($query, $link) or die(mysql_error($link));

		$result = mysql_query($query) or die(mysql_error());

//		$time_end = getmicrotime();

		mysql_select_db($_SESSION['bd']);

	}else{

//		$time_begin = getmicrotime();

		$result = mysql_query($query) or die(mysql_error());

//		$time_end = getmicrotime();

	}

/*	if($write_log){

		write_log(array($bd, '"' . $query . '"', $time_end - $time_begin), 'sql', 'sql');

	}*/

	return $result;

}



function getmicrotime(){

   list($usec, $sec) = explode(" ", microtime());

   return ((float)$usec + (float)$sec);

}



function write_log($message, $type = 'log', $file = "log", $max_size = 2097152){

/*	$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $file . ".txt";

	if(is_string($message)){

		$message = array($message);

	}

	$msgs = array(date('Y-m-d H:i:s'), $_SESSION['codusuario'], $type);

	foreach($message as $msg){

		$msgs[] = $msg;

	}

	$msgs[] = "\n";

	$handle = fopen($file, 'a');

	fwrite($handle, implode($msgs, '; '));

	fclose($handle);*/

}



function capitalize($str){

	return ucwords(strtolower($str));

}


function retornarHora($minutos){
	
	$retorno = "";
	
	if($minutos < 60){
		if($minutos < 10)
			$retorno = "00:0$minutos";
		else
			$retorno = "00:$minutos";
	}
	else{
		$hr_calc = floor($minutos / 60);
		$min_calc = ($minutos % 60);
		if ($min_calc < 10)
			$retorno = "$hr_calc:0$min_calc";
		else
			$retorno = "$hr_calc:$min_calc";
	}
	return $retorno;
}
//SOMAR DATA
function SomarData($data, $dias, $meses, $ano){
   $data = explode("/", $data);
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses,
     $data[0] + $dias, $data[2] + $ano) );
   return $newData;
}
//SUBTRAI DATA
function SubtrairData($data, $dias, $meses, $ano){
   $data = explode("/", $data);
   $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] - $meses,$data[0] + $dias, $data[2] + $ano) );   			
   return $newData;
}

function remover_quebra_linha($palavra){
	$palavra = str_replace(chr(10), ' ', str_replace(chr(13), " ", $palavra));
	return $palavra;
}

function remover_acentos($palavra){
  $palavra = ereg_replace("[^a-zA-Z0-9_] ", "", strtr($palavra, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC "));
  return $palavra;
}

function formatarSA3($palavra){
	return mb_strtoupper(remover_quebra_linha(remover_acentos($palavra)));
}

function result_to_array($sql){

	$linhas = array();
	$result = mysql_query($sql);
	while($row = mysql_fetch_row($result)){
		
		$linhas[] = $row;
	}
	mysql_free_result($result);
	return $linhas;
}

function result_to_jsarray($nomejsarray, $arr){
	
	$strRetorno = "";
	$strRetorno.="var $nomejsarray = [";
	for ($i = 0; $i <  count($arr); $i++){
		$strRetorno.="[";
 		for($j = 0; $j < count($arr[$i]); $j++){
 			$strRetorno.="'".$arr[$i][$j]."' ";
			if($j != (count($arr[$i]) -1)){
				$strRetorno.=", ";
			} 			
		}
		$strRetorno.="]";
		if($i != (count($arr) -1)){
			$strRetorno.=", ";
		}
	}
 	$strRetorno .= "];";
 	return $strRetorno;
}


function result_to_jsarray_id($nomejsarray, $arr){
	
	$strRetorno = "";
	//$strRetorno.="[";
	for ($i = 0; $i <  count($arr); $i++){
		$strRetorno.="[";
 		for($j = 0; $j < count($arr[$i]); $j++){
 			$strRetorno.="'".$arr[$i][$j]."' ";
			if($j != (count($arr[$i]) -1)){
				$strRetorno.=", ";
			} 			
		}
		$strRetorno.="]";
		if($i != (count($arr) -1)){
			$strRetorno.=", ";
		}
	}
 	$strRetorno .= "];";
 	return $strRetorno;
}



function criarCombo($v_id, $v_arr, $v_primeiro_item, $v_default, $v_complemento){
	$strRetorno ="";
	$strRetorno.="<select id='$v_id' name='$v_id' $v_complemento >";
	if($v_primeiro_item != "")
		$strRetorno.="<option value=''></option>";
	for($i = 0; $i < count($v_arr); $i++){
		if($v_default == $v_arr[$i][0])
			$strRetorno.="<option value='".$v_arr[$i][0]."' selected='true'>".$v_arr[$i][1]."</option>";
		else
			$strRetorno.="<option value='".$v_arr[$i][0]."'>".$v_arr[$i][1]."</option>";
	}
	$strRetorno.="</select>";
	return $strRetorno;
}


function moeda2float($moeda){
	$moeda = str_replace(".","", $moeda);
	$moeda = str_replace(",",".", $moeda);
	return $moeda;
}

?>

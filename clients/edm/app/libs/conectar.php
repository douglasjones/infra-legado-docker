<?require_once 'conectar_info.php';
    function conectar(){
            //PRODUCAO
            $bd = getDB();
            $local = getHost();
            $user = getUser();
            $password = getPass();

            $con = mysql_connect($local,$user, $password) or die('Não foi possível conectar: ' . mysql_error());
            mysql_query("SET time_zone = '-03:00';",$con);
            mysql_query("SET NAMES 'latin1';",$con);
            mysql_query("SET character_set_connection=utf8';",$con);
            mysql_query("SET character_set_client=utf8';",$con);
            mysql_query("SET character_set_results=utf8';",$con);
            mysql_query("SET SQL_BIG_SELECTS=1;",$con);
            mysql_select_db($bd);
            return $con;

    }
?>

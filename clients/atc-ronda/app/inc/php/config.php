<?session_start();

//Seta os parametros globais de timeout
ini_set('session.gc_maxlifetime', 2400); // 40 minutos
ini_set('session.cookie_lifetime', 2400);

//Define o cabecalho
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
// ini_set('default_charset','ISO-8859-1'); Padro do desenvolvimento são arquivos UTF-8

?>

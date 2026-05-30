<?php


/*$file = $_REQUEST['arquivo'];  
header("Content-type: application/save"); 
header("Content-Length:".filesize($file)); 
header('Content-Disposition: attachment; 
filename="./pasta/"."' . $file . '"'); 
header('Expires: 0'); 
header('Pragma: no-cache'); 

readfile("$file"); */


 define('DIR_DOWNLOAD', 'discador/'); // Aqui vale qualquer coisa :)
     

    $arquivo = $_GET['arquivo'];
   // if (stripos($arquivo, './') !== false || stripos($arquivo, '../') !== false || !file_exists($arquivo))
  //      exit('Operação não permitida.');
 
    $arquivo = DIR_DOWNLOAD.$arquivo; // Aqui a gente só junta o diretório com o nome do arquivo
 
    header('Content-type: octet/stream');
    header('Content-disposition: attachment; filename="'.basename($arquivo).'";');
    header('Content-Length: '.filesize($arquivo));
    readfile($arquivo);
    exit;
 ?>   

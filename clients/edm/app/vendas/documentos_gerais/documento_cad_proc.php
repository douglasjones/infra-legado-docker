<?php 

include_once "../../libs/maininclude.php";


//Função que verifica a extensão
function extensao($arquivo){
    $tam = strlen($arquivo);
    //ext de 3 chars
    if( $arquivo[($tam)-4] == '.' )
    {
    $extensao = substr($arquivo,-3);
    }

    //ext de 4 chars
    elseif( $arquivo[($tam)-5] == '.' )
    {
    $extensao = substr($arquivo,-4);
    }

    //ext de 2 chars
    elseif( $arquivo[($tam)-3] == '.' )
    {
    $extensao = substr($arquivo,-2);
    }

    //Caso a extensão não tenha 2, 3 ou 4 chars ele não aceita e retorna Nulo.
    else
    {
    $extensao = NULL;
    }
    return $extensao;
}

$codusuariointerno = $_SESSION['codusuario'];

//pega o nome do documento
$sql ="";
$sql.="select ifnull(max(pk),0) total from documentos_gerais ";
$result = sql_query($sql);
$row = mysql_fetch_array($result);
$total_arquivos = ($row['total'] + 1);
mysql_free_result($result);

$extensao = extensao($_FILES["ds_nome_documento1"]["name"]);
$nomearquivo = "$total_arquivos.$extensao";


//Efetua o upload dos arquivos
$ds_documento1 = isset($_POST["ds_documento1"]) ? $_POST["ds_documento1"] : "";
$total_arquivos++;
$nomearquivo = "$total_arquivos.$extensao";
$destino = "doc/$nomearquivo";
$ds_nome_original1 = $_FILES["ds_nome_documento1"]["name"];
if(move_uploaded_file($_FILES["ds_nome_documento1"]["tmp_name"],$destino)){
	$query = "insert into documentos_gerais (ds_nome_documento, ds_documento, datacadastro, codusuariointerno, ds_nome_original) values ('$destino', '$ds_documento1', sysdate(), $codusuariointerno, '$ds_nome_original1') ";
	$result = sql_query($query);	
	echo "<script>alert('Arquivo 1 gravado com sucesso!!!');</script>";
}
else{
	//echo "<script>alert('Erro ao gravar o arquivo 1');</script>";
}

$ds_documento2 = isset($_POST["ds_documento2"]) ? $_POST["ds_documento2"] : "";
$total_arquivos++;
$nomearquivo = "$total_arquivos.$extensao";
$destino = "doc/$nomearquivo";
$ds_nome_original2 = $_FILES["ds_nome_documento2"]["name"];
if(move_uploaded_file($_FILES["ds_nome_documento2"]["tmp_name"],$destino)){
	$query = "insert into documentos_gerais (ds_nome_documento, ds_documento, datacadastro, codusuariointerno, ds_nome_original) values ('$destino', '$ds_documento2', sysdate(), $codusuariointerno, '$ds_nome_original2') ";
	$result = sql_query($query);	
	echo "<script>alert('Arquivo 2 gravado com sucesso!!!'); </script>";
}
else{
	//echo "<script>alert('Erro ao gravar o arquivo 2');</script>";
}


$ds_documento3 = isset($_POST["ds_documento3"]) ? $_POST["ds_documento3"] : "";
$total_arquivos++;
$nomearquivo = "$total_arquivos.$extensao";
$destino = "doc/$nomearquivo";
$ds_nome_original3 = $_FILES["ds_nome_documento3"]["name"];
if(move_uploaded_file($_FILES["ds_nome_documento3"]["tmp_name"],$destino)){
	$query = "insert into documentos_gerais (ds_nome_documento, ds_documento, datacadastro, codusuariointerno, ds_nome_original) values ('$destino', '$ds_documento3', sysdate(), $codusuariointerno, '$ds_nome_original3') ";
	$result = sql_query($query);	
	echo "<script>alert('Arquivo 3 gravado com sucesso!!!');</script>";
}
else{
	//echo "<script>alert('Erro ao gravar o arquivo 3'); </script>";
}

$ds_documento4 = isset($_POST["ds_documento4"]) ? $_POST["ds_documento4"] : "";
$total_arquivos++;
$nomearquivo = "$total_arquivos.$extensao";
$destino = "doc/$nomearquivo";
$ds_nome_original4 = $_FILES["ds_nome_documento4"]["name"];
if(move_uploaded_file($_FILES["ds_nome_documento4"]["tmp_name"],$destino)){
	$query = "insert into documentos_gerais (ds_nome_documento, ds_documento, datacadastro, codusuariointerno, ds_nome_original) values ('$destino', '$ds_documento4', sysdate(), $codusuariointerno, '$ds_nome_original4') ";
	$result = sql_query($query);	
	echo "<script>alert('Arquivo 4 gravado com sucesso!!!');</script>";
}
else{
	//echo "<script>alert('Erro ao gravar o arquivo 4');</script>";
}

$ds_documento5 = isset($_POST["ds_documento5"]) ? $_POST["ds_documento5"] : "";
$total_arquivos++;
$nomearquivo = "$total_arquivos.$extensao";
$destino = "doc/$nomearquivo";
$ds_nome_original5 = $_FILES["ds_nome_documento5"]["name"];
if(move_uploaded_file($_FILES["ds_nome_documento5"]["tmp_name"],$destino)){
	$query = "insert into documentos_gerais (ds_nome_documento, ds_documento, datacadastro, codusuariointerno, ds_nome_original) values ('$destino', '$ds_documento5', sysdate(), $codusuariointerno, '$ds_nome_original5') ";
	$result = sql_query($query);	
	echo "<script>alert('Arquivo 5 gravado com sucesso!!!');</script>";
}
else{
	//echo "<script>alert('Erro ao gravar o arquivo 5');</script>";
}

echo "<script>opener.top.pagina.location.reload();</script>";
echo "<script>self.close();</script>";

include_once "../../libs/desconectar.php";

?>
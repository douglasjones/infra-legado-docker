<?
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=arquivoExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo $_POST[ 'dados_a_enviar' ];
?>
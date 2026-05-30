<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/grid.php";
	if(!permissao('config_polo', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">
<?	include_once "../../libs/head.php";?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="produtos">
<?	$sql = "Select
				p.cod_polo
				,p.n_polo
				,date_format(p.dat_cad,'%d-%m-%Y')as datacad
				,case when p.dat_canc is null then
					'Ativo'
				else
					'Desativado'
			end as status
			from polo p
			order by p.n_polo";
	$result = sql_query($sql);
	grid($result, "cod_polo", "Código//Polo//Data Cadastro//Status", "cod_polo//n_polo//datacad//status");
	mysql_free_result($result); ?>
</div>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

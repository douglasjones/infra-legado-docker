<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/grid.php";
	if(!permissao('config_emrpesa', 'cs')){
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
<?	$sql = "select
				e.cod_empresa
				,e.razao_social
				,e.nome_fantasia
				,concat(e.endereco,',',e.numero)endereco
				,p.n_polo as polo
				,te.dsc_tipo_empresa as tipo
                ,origem_email_agendamento_pk
                ,enviar_agenda_email_pk
                ,agenda_email
                ,origem_email_proposta_pk
                ,enviar_proposta_email_pk
                ,proposta_email
			from empresa e
				left join polo p on e.cod_polo = p.cod_polo
				left join tipo_empresa te on e.cod_tipo_empresa = te.cod_tipo_empresa
			order by e.cod_tipo_empresa";
				$result = sql_query($sql);
	grid($result, "cod_empresa", "Código//Razão Social//Nome Fantasia//Endereço//Cidade//Tipo", "cod_empresa//razao_social//nome_fantasia//endereco//polo//tipo");
	mysql_free_result($result); ?>
</div>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

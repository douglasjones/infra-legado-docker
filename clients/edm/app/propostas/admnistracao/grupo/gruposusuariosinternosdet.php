<?
/*
/---------------------------------------------------\
|						    						|
|DESCRIÇÃO: PRINCIPAIS FUNÇÕES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVISÕES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 24/09/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/
    include_once "../../libs/maininclude.php";
	if(!permissao('grupos', 'dt')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

	$codgrupousuariointerno = null;
	$nome = null;
	$gerente = null;

	if(!empty($_REQUEST['codgrupousuariointerno'])){
		$codgrupousuariointerno = $_REQUEST['codgrupousuariointerno'];
		
		//Faz a pesquisa no banco de dados.
		$sql = "select g.*, u.Nome Gerente ";
		$sql .= " from gruposusuariosinternos g left join usuariosinternos u on g.CodGerente = u.CodUsuarioInterno";
		$sql .= " where codgrupousuariointerno = $codgrupousuariointerno ";
		$result = sql_query($sql);
		while($row = mysql_fetch_array($result)){
			$nome = $row['Nome'];
			$gerente = $row['Gerente'];
		}
		mysql_free_result($result);
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    
    <!-- Cabeçalho -->
	<title>Grupos Usuários Internos</title>
<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Grupo de Usuários
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tbody>
   	<tr>
          <td>&nbsp;
              
          </td>
    </tr>
	<tbody>
		<tr>
			<td>&nbsp;Nome:</td>
			<td><?=$nome;?></td>
		</tr>
<?	if($gerente){ ?>
		<tr>
			<td>&nbsp;Gerente:</td>
			<td><?=$gerente;?></td>
		</tr>
<?	}?>
		<tr>
			<td colspan="2">
				<table cellpadding="0" cellspacing="0" border="0" class="form" >
					<thead>
						<tr>
							<th>Paginas</th>
							<th>IC</th>
							<th>AL</th>
							<th>EX</th>
							<th>CS</th>
							<th>DT</th>
						</tr>
					</thead>
					<tbody>
<?	$strcor = "#ededed";
	$sql = "select * ";
	$sql .= "  from paginas ";
	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		$sql = "select * from gruposusuariosinternos_paginas ";
		$sql .= "where codgrupousuariointerno=$codgrupousuariointerno ";
		$sql .= " and codpagina=".$row['CodPagina'];
		$result1 = sql_query($sql);
		$ic = 0;
		$al = 0;
		$ex = 0;
		$cs = 0;
		$dt = 0;
		while($row1 = mysql_fetch_array($result1)){
			$ic = $row1['IC'];
			$al = $row1['AL'];
			$ex = $row1['EX'];
			$cs = $row1['CS'];
			$dt = $row1['DT'];
		}
		mysql_free_result($result1);?>
							<tr>
								<td>&nbsp;<?=$row['Descricao'];?><input type=hidden name=codpagina value="<?=$row['CodPagina'];?>" /></td>
								<td>&nbsp;<?=($ic != 0?'S':null);?></td>
								<td>&nbsp;<?=($al != 0?'S':null);?></td>
								<td>&nbsp;<?=($ex != 0?'S':null);?></td>
								<td>&nbsp;<?=($cs != 0?'S':null);?></td>
								<td>&nbsp;<?=($dt != 0?'S':null);?></td>
							</tr>
<?		if($strcor=="#ededed")
			$strcor = "";
		else 
			$strcor = "#ededed";
	}
	mysql_free_result($result);?>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>

<tr>
			<td colspan="2" align="right">&nbsp;
				
			</td>
		</tr>
		
			<tr>
				<td colspan="2" align="right">
					<input type="button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;
				</td>
			</tr>


	</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

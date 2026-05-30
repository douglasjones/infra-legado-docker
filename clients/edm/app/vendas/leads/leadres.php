<?
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/grid.php";
include_once "../../libs/cla.equipes.php";
if(!permissao('leads', 'cs')){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">
<!-- Include CSS -->
<?	include_once "../../libs/head.php";?>
    <!-- Comandos Javascript -->
<script type="text/javascript" language="javascript">
	function abrirGrid(campo, valor){
		switch(campo){
			case 'RazaoSocial':
				window.top.pagina.location.href = "leadgerenciamentores.php?codlead=" + valor;
				break
			case 'Ocorrencias':
				NewWindow("leadhistoricoocorrencia.php?origem=resultado&codlead=" + valor,700,400)
				break
		}
	}
	function numero_pagina(){
		var d = document.forms[0];
		var end = d.endereco.value
		if (d.npagina.value==""){
			alert('Pagina não foi preenchido !');
		}
		
		url = ( end + "&pagina=" + d.npagina.value  ) ;

		window.location.href=url ;
		

	}
</script>
</head>
<BODY1 leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	
	$pagina = 1;
	$tam_pagina = 30;

	//$cod_polo = $_REQUEST['cod_polo'];
	$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
	$razaosocial = $_REQUEST['razaosocial'];
	$nomefantasia = $_REQUEST['nomefantasia'];
	$cnpj = $_REQUEST['cnpj'];
	$id_radio = $_REQUEST['id_radio'];
	$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
	$codgerenteconta = $_REQUEST['codgerenteconta'];
	$codatendente = $_REQUEST['codatendente'];
	$mailing_pk = $_REQUEST['mailing_pk'];
	$cod_campanha = $_REQUEST['cod_campanha'];
        
	$cod_operadora = $_REQUEST['cod_operadora'];
        $status_cliente_pk = $_REQUEST['status_cliente_pk'];
        $status_base_pk = $_REQUEST['status_base_pk'];
        $dt_ativacao_ini = $_REQUEST['dt_ativacao_ini'];
        $dt_ativacao_fim = $_REQUEST['dt_ativacao_fim'];
        $dt_venc_contrato_ini = $_REQUEST['dt_venc_contrato_ini']; 
        $dt_venc_contrato_fim = $_REQUEST['dt_venc_contrato_fim']; 
        $qtdeli_ini = $_REQUEST['qtdeli_ini']; 
        $qtdeli_fim = $_REQUEST['qtdeli_fim'];
        $qtdeli_dados_ini = $_REQUEST['qtdeli_dados_ini'];
        $qtdeli_dados_fim = $_REQUEST['qtdeli_dados_fim'];
 
        
	$cidade = $_REQUEST['cidade'];
	$dataini = $_REQUEST['dataini'];
	$datafim = $_REQUEST['datafim'];
	$busca = $_REQUEST['busca'];
	$tipo_pessoa = $_REQUEST['tipo_pessoa'];
	$ddd = $_REQUEST["ddd"];
	$tel = $_REQUEST["tel"];
	$segmento = $_REQUEST["segmento"];
	$cep = $_REQUEST['cep'];
	$bairro = $_REQUEST["bairro"];
	$pagina = $_REQUEST['pagina'];
	$ddd_cel = $_REQUEST['ddd_cel'];
	$cel = $_REQUEST['cel'];
	$dt_transf_ini = $_REQUEST['dt_transf_ini'];
	$dt_transf_fim = $_REQUEST['dt_transf_fim'];
	$codequipe = $_REQUEST['codequipe'];
	$id_fornecedor = $_REQUEST['id_fornecedor'];
	if(!empty($_REQUEST['cod_polo'])){        
        $cod_polo = $_REQUEST['cod_polo'];        
    }else{        
        $cod_polo = $_SESSION['cod_polo'];
    }
    
	if(empty($pagina))
		$pagina = 1;
	
	//calcula o registro de início e fim da página
	if($pagina == 1){
		$reg_inicio = 0;
		$reg_fim = 0;
	}
	else{
		$reg_inicio = ($pagina * $tam_pagina - $tam_pagina);
		$reg_fim = $reg_inicio;
	}
	$reg_fim += $tam_pagina;
	
		
	//monta a SQL para pesquisa
	$sql ="";
	$sql.="select l.codlead, l.razaosocial, scl.descricao statusclassificacaolead, ui.nome gerenteconta,ui1.nome as atendente,m.dsc_mailing mailing";
	$sql.="  from leads l ";
	$sql.="       inner join statusclassificacaolead scl on l.codstatusclassificacaolead = scl.codstatusclassificacaolead ";

	if(!empty($codequipe))
		$sql.=" inner join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";
	
	// só utilizará inner join com a tabela de usuários se o parâmetro gerente de conta for enviado
	if(!empty($codgerenteconta))
		$sql.="       inner ";
	else
		$sql.="       left ";
			
	$sql.="             join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
						left join usuariosinternos ui1 on l.codatendente = ui1.codusuariointerno";
	
	//fim do join com gerente de contas
	
	//faz join com contatos quando a o id do rádio for informado
	if(!empty($id_radio) || !empty($ddd_cel) || !empty($cel))
		$sql.=" inner join contatoslead cl on cl.codlead = l.codlead ";
	
	$sql.=" left join mailing m on l.mailing_pk = m.pk";
	$sql.=" where 1=1 ";
	
	//COLOCA OS DEMAIS PARÂMETROS
	if(!empty($codstatusclassificacaolead))
		$sql.= " and l.codstatusclassificacaolead = $codstatusclassificacaolead ";
		
	if(!empty($razaosocial))
		$sql.="  and l.razaosocial like '%$razaosocial%' ";
	
	if(!empty($busca))
		$sql.=" and (l.id_fornecedor like ".mysqlnull("%".$busca."%")." or l.razaosocial like " . mysqlnull("%".$busca."%") . " or l.nomefantasia Like " . mysqlnull("%".$busca."%") . " or l.cnpj_cpf Like " . mysqlnull("%{$_REQUEST['busca']}%")  . " or l.codlead = " . mysqlnull("".$busca."").") ";
	
	if(!empty($nomefantasia))
		$sql.=" and l.nomefantasia like '%$nomefantasia%' ";
	
	if(!empty($id_fornecedor))
		$sql.=" and l.id_fornecedor like '%".$id_fornecedor."%' ";
	
	if(!empty($cnpj))
		$sql.=" and l.cnpj_cpf like '%$cnpj%' ";
	
	if(!empty($id_radio))
		$sql.=" and cl.id_radio like '%$id_radio%' ";
		
	if(!empty($ddd_cel))
		$sql.=" and cl.ddd_cel like '%$ddd_cel%' ";
		
	if(!empty($cel))
		$sql.=" and cl.cel like '%$cel%' ";
		
	if(!empty($codequipe))
		$sql.=" and tbu.Fk_Equipe=".mysqlnull($codequipe);
		
	if($codgerenteconta > 0){
		$sql.=" and ui.codusuariointerno = $codgerenteconta ";
	}else{
		if($codgerenteconta == '0'){
			$sql.=" and ui.codusuariointerno is null";
		}
		/*else{
			if(!permissao('visualizar_todos_consultores', 'cs'))
				//if(empty($busca))
					$sql.="   and ui.codusuariointerno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
		}*/
	}			
		
	if($codatendente > 0){
		$sql.=" and l.codatendente = $codatendente ";
	}else{
		if($codatendente == '0'){
			$sql.=" and l.codatendente is null ";
		}
	}
	if(!empty($cod_campanha))
		$sql.=" and l.codlead in (select codlead from campanha_leads where cod_campanha =  $cod_campanha) " ;	
	
        
        if(!empty($cod_operadora)){
            //SE É CLIENTE DA OPERADORA OU NÃO OU SE FOI ATUALIZADO OU NÃO
            if($status_cliente_pk==1 or $status_cliente_pk==2){
                $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_cliente where operadora_pk = ".$cod_operadora." and lead_cliente=".$status_cliente_pk." )";
            }elseif ($status_cliente_pk==3){                
                $sql.=" and l.codlead not in (Select leads_pk from n_leads_dados_cliente where operadora_pk = ".$cod_operadora.")";
            }
            //SE É DA BASE OU NÃO POR OPERADORA
            if($status_base_pk==1 or $status_base_pk==2){
                $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_base where operadora_pk = ".$cod_operadora." and lead_cliente_base=".$status_base_pk." )";
            }elseif ($status_base_pk==3){ 
                $sql.=" and l.codlead not in (Select leads_pk from n_leads_dados_base where operadora_pk = ".$cod_operadora.")";
            }            
            
            if(!empty($dt_ativacao_ini) and !empty($dt_ativacao_fim)){                 
                $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_ativacao where operadora_pk = ".$cod_operadora." and dt_ativacao >= '".DataYMD($dt_ativacao_ini)." 00:00:00' and dt_ativacao <= '".DataYMD($dt_ativacao_fim)." 23:59:59' )";  
            }
            if(!empty($dt_venc_contrato_ini) and !empty($dt_venc_contrato_fim)){
                $sql.=" and l.codlead  in (Select leads_pk from n_leads_dados_vencimento where operadora_pk = ".$cod_operadora." and dt_vencimento >= '".DataYMD($dt_venc_contrato_ini)." 00:00:00' and dt_vencimento <= '".DataYMD($dt_venc_contrato_fim)." 23:59:59' )";                
            }
     
            if(!empty($qtdeli_ini) && !empty($qtdeli_fim)){
                $sql.=" and l.codlead  in (Select leads_pk from n_leads_qtde_voz where operadora_pk = ".$cod_operadora." and qtde_voz >=".$qtdeli_ini." and qtde_voz <= ".$qtdeli_fim.")";
            }
            if(!empty($qtdeli_dados_ini) && !empty($qtdeli_dados_fim)){
                $sql.=" and l.codlead  in (Select leads_pk from n_leads_qtde_dados where operadora_pk = ".$cod_operadora." and qtde_dados >=".$qtdeli_dados_ini." and qtde_dados <= ".$qtdeli_dados_fim.")";
            }
            
        } 
		
	if(!empty($mailing_pk))
		$sql.=" and l.mailing_pk =".$mailing_pk;
		
	if(!empty($dataini))
		$sql.=" and l.datacadastro >= '".DataYMD($dataini)." 00:00:00' ";
		
	if(!empty($datafim))
		$sql.=" and l.datacadastro <= '".DataYMD($datafim)." 23:59:59' ";
	
	if(!empty($cidade))
		$sql.=" and l.cidade like '%".$cidade."%' ";
	
	if(!empty($tipo_pessoa))
		$sql.=" and l.tipo_pessoa = '".$tipo_pessoa."' ";
		
	if(!empty($segmento))
		$sql.=" and l.segmento like '%".$segmento."%' ";
		
	if(!empty($bairro))
		$sql.=" and l.bairro like '%".$bairro."%' ";
		
	if(!empty($cep))
		$sql.=" and l.cep like '".$cep."%' ";
		
	if($cod_polo > 0){
		$sql.=" and l.cod_polo=".$cod_polo;
	}else{
		if($cod_polo == '0'){
			$sql.=" and l.cod_polo=0";
		}
	}
	
	if(!empty($ddd)){
		$sql.=" and l.ddd = '".$ddd."' ";
	}
	
	if(!empty($tel)){
		$sql.=" and l.tel like '%".$tel."%' ";
	}
	
	if(!empty($dt_transf_ini) && !empty($dt_transf_fim))
		$sql.=" and l.codlead in (select oc.codlead from ocorrenciaslead oc where oc.codtipoocorrencialead = 77 and oc.datacadastro between '".DataYMD($dt_transf_ini)." 00:00:00' and '".DataYMD($dt_transf_fim)." 23:59:59' ) ";
	
        $sql.=" group by l.codlead ";
	$sql.=" order by l.razaosocial ";

	$result = mysql_query($sql);
	$num = mysql_num_rows($result);	
	
	if($num < $reg_fim){
		$reg_fim = $num;
	}
	
	if($reg_fim == "0"){
		$reg_inicio = 0;
	}
	else{
		$reg_inicio++;
	}
?>	


<table class="borda_tabela" width="100%" align="center"  id="dados" border="1" cellpadding="0"  cellspacing="0" >
<form name="dados">
	<input type="Hidden" name="endereco" value="<?=$_SERVER['REQUEST_URI']?>">
	<tr>
		<td width="60%" nowrap class="font_grid">
			&nbsp;<strong>Exibindo <?=($reg_inicio);?> à <?=($reg_fim);?> de <?=$num;?> registros</strong>
		</td>
		<td nowrap class="font_grid">			
				&nbsp;&nbsp;Pagina <input type="Text" size=5 maxlength="12" name="npagina">&nbsp;<a href="javascript:numero_pagina()">Ir</>&nbsp;			
		</td>
		<td valign="baseline" class="font_grid" align="right">
			<?if ($num >= $reg_fim) {?>
				<a href="<?=$_SERVER['REQUEST_URI'];?>&pagina=1"><img src="../../images/start_off.gif" border="0"></a>
				<a href="<?=$_SERVER['REQUEST_URI'];?>&pagina=<?=($pagina - 1);?>"><img src="../../images/previous_off.gif" border="0"></a>
				<?
				//calcula o total de páginas
				$total_paginas = intval($num/$tam_pagina)+1;
				
				if ($total_paginas < 10){
					for($i = 1; $i < $total_paginas; $i++){
						if($i == $pagina)
							echo "<b>$i</b>&nbsp;";
						else					
							echo "<a href='".$_SERVER['REQUEST_URI']."&pagina=$i'>$i</a>&nbsp;";
					}
				}
				else{
								
					if($pagina == 1){
						$pagina_inicio = 1;
						$pagina_fim = 10;
					}
					else{
						$pagina_inicio = $pagina - 5;
						$pagina_fim = $pagina_inicio + 10;
						
						if($pagina_inicio < 1){
							$pagina_inicio = 1;
							$pagina_fim = 10;
						}
						
						if($total_paginas < $pagina_fim){
							$pagina_fim = $total_paginas + 1;
							$pagina_inicio = $pagina_fim - 10;
						}
					}
					
					for($i = $pagina_inicio; $i < $pagina_fim; $i++){
						if($i == $pagina)
							echo "<b>$i</b>&nbsp;";
						else
							echo "<a href='".$_SERVER['REQUEST_URI']."&pagina=$i'>$i</a>&nbsp;";
					}
				}
				?>
				<a href="<?=$_SERVER['REQUEST_URI'];?>&pagina=<?
				if($pagina == $total_paginas){
					echo $total_paginas;
				}
				else{
					echo $pagina + 1;
				}
				?>"><img src="../../images/next_off.gif" border="0"></a>
				<a href="<?=$_SERVER['REQUEST_URI'];?>&pagina=<?=$total_paginas;?>"><img src="../../images/end_off.gif" border="0"></a>
			<?
			}
			?>
		</td>
	</tr>
</form>
</table>

<table class="borda_tabela" width="100%" align="center"  id="dados" border="0" cellpadding="0"  cellspacing="0" >
	<tr class="font_grid">
		<td align="center">#</td>
		<td align="center">
			Código Lead
		</td>
		<td align="center">
			Razão Social
		</td>		
		<td align="center">
			Consultor
		</td>
		<td align="center">
			Atendente
		</td>				
		<td align="center">
			Status
		</td>	
		<td align="center">
			Mailing
		</td>		
		<td align="center">
			Ocorrências
		</td>				
	</tr>	
	<?
	$cor = "#ffffff";
	$pagina_atual = 1;
	$registro = 1;
	while($row = mysql_fetch_array($result)){
	
		if ($pagina_atual == $pagina){
	
			if($cor=="#dfdfdf"){
				$cor = "#ffffff";
			}
			else{
				$cor = "#dfdfdf";
			}	
		?>
		<tr class="link_cinza" bgcolor="<?=$cor?>" onclick="document.getElementsByName('rd')[<?= $registro-1;?>].checked=true">
			<td align="center" width="10">
				<input value="<?=$row['codlead'];?>" type="radio" name="rd" />
			</td>
			<td align="center">
				<a href="#" onclick="javascript:abrirGrid('RazaoSocial','<?= $row['codlead']?>')"><?= $row['codlead'];?></a>
			</td>
			<td>
				<a href="#" onclick="javascript:abrirGrid('RazaoSocial','<?= $row['codlead']?>')"><?= $row['razaosocial'];?></a>
			</td>		
			<td align="center">
				<?= $row['gerenteconta'];?>
			</td>
			<td align="center">
				<?= $row['atendente'];?>
			</td>
			<td align="center">
				<?= $row['statusclassificacaolead'];?>
			</td>
			<td align="center">
				<?= $row['mailing'];?>
			</td>		
				<td align="center">
					<a href="#" onclick="javascript:abrirGrid('Ocorrencias','<?= $row['codlead']?>')"><a href="#" onclick="javascript:abrirGrid('Ocorrencias','<?= $row['codlead']?>')"><img src="../../images/People_012.gif" border="0" /></a>
				</td>
			<?
			
			?>
		</tr>	
		<?
		}
		
		if($registro == $tam_pagina){
			$pagina_atual ++;
			$registro = 1;
		}
		else{
			$registro ++;
		}
		
	}
	mysql_free_result($result);
	?>
</table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

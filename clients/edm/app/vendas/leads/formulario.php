<?
include_once "../../libs/maininclude.php";
include_once( "../../operacao/produtos/variaveis_tim.php" ) ;
?>
<head>
<STYLE TYPE="text/css"> 
.folha { 
page-break-after: always; 
} 
</STYLE> 
<script>
	function imprimir(){
		window.print()
	}
</script>
</head>
<body onload="imprimir()">
</body>
<?

//IDENTIFICA A OPERADORA 
$sql = "Select 
			pd.cod_operador
		from propostas p
		inner join produtos pd on p.codproduto  = pd.codproduto
		where codproposta=".$_REQUEST['codproposta'];

		$result = sql_query($sql);
		$operador = mysql_fetch_array($result);


$codlead = $_REQUEST['codlead'];
$codproposta = $_REQUEST['codproposta'];
$res = mysql_query ("Select 
		  ui.nome as vendedor
		  ,l.razaosocial
		  ,l.nomefantasia
		  ,l.cnpj_cpf cnpj
		  ,l.ie
		  ,l.InscricaoMunicipal im
		  ,concat(l.endereco,',',l.numero) endereco
		  ,l.bairro
		  ,l.cidade
          ,l.cep
		  ,l.uf
		  ,concat('(',l.ddd,') ',l.tel) tel
		from  leads l
			left join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
			inner join propostas p on l.codlead = p.codlead
		where l.codlead=$codlead
		and p.codproposta=$codproposta");

		if($leads = mysql_fetch_array($res)){
			array_merge($leads, $_REQUEST);
			$_REQUEST = $leads;
		}

	
//FROMULARIO
$sql = "Select  
		  f.cod_formulario
		  ,fi.imagem
		  ,fi.comprimento
		  ,fi.largura
		from formulario f
		inner join formulario_imagem fi on f.cod_formulario = fi.cod_formulario
		where f.cod_operador=".$operador['cod_operador'];
		$sql.= " and fi.cod_formulario_imagem=1
		order by fi.ordem";
		
		$result  = mysql_query($sql);
		
		if(mysql_num_rows($result)==0){
			javascriptalert('Formulário Indisponível!!!' , false ); 
		}
		
		while($row = mysql_fetch_array($result)){
			print "<div class=folha>";
			print "	<img src=../../images/formulario/".$row['imagem']."  width=".$row['comprimento']." height=".$row['largura']."  style='position:absolute; margin: auto; left: 0px; top: 0px;'/>";
			print "</div";
		}
		//COMPOSICAO DO FORMULARIO
		$sql = "Select 
					  f.identificador
					  ,f.linha
					  ,f.coluna
					  ,f.tamanho
					from formulario_posicional f
					where cod_formulario=1";
			$result1  = mysql_query($sql);
			print "<body >";
			$n = '0';
			while($row1 = mysql_fetch_array($result1)){
				//NOME DA COLUNA DA SELECT DE DADSO
				$campo = mysql_field_name($res, $n);
				//VERIFICA SE O NOME DA COLUNA IGUAL AO IDENTIFICADOR
				if($row1['identificador'] == $campo){	
							
			?>
					<div style='position:absolute; margin: auto; left:<?=$row1['coluna'];?>px; top: <?=$row1['linha'];?>px; '>
						<font face="Courier New" size=3 color="#0000ff">					
							<?=$leads[$campo];?>
						</font>                                         
					</div>
			<?				
				}
				$n ++; 	

				
			}
			//PRODUTOS TIM
			if($operador['cod_operador']==2){
				$sql  = "Select 
						 mp.id
						 ,mp.valor
						 from modulosproposta mp
						 where mp.codproposta=$codproposta
						 and mp.codlead=$codlead " ;	
						 $sql.="   and mp.id in (";
						//pega as variaveis dos produtos
						for ($i = 0; $i < count($arrVariavelProduto); $i++){
							$sql.="'".$arrVariavelProduto[$i]."', ";
						}
						$sql.="'') ";
				$rs  = mysql_query($sql);
				
				$linha = "266";
				while($produto = mysql_fetch_array($rs)){
					if($produto['valor']>'0') {
				?>
						<div style='position:absolute; margin: auto; left:85px; top: <?=$linha;?>px; '>
							<font face="Courier New" size=3 color="#0000ff">					
								<?=$arrTituloProduto[$produto['id']];?>
							</font>                                         
						</div>
						<div style='position:absolute; margin: auto; left:740px; top: <?=$linha;?>px; '>
							<font face="Courier New" size=3 color="#0000ff">					
								<?=$produto['valor'];?>
							</font>                                         
						</div>
				<?		
						$linha = $linha + '30';
					}
				}
			}
?>




	
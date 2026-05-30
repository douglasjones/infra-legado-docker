<?
function combo($sql, $nomecombo, $valordefault = null, $textoinicial = null, $complemento = null, $valorinicial = null){
	
	$result = mysql_query($sql) or die (mysql_error());
		//$result = sql_query($sql) or die(mysql_error());?>
		<select id="<?=$nomecombo;?>" name="<?=$nomecombo;?>" <?=$complemento;?>>
<?		if(!empty($textoinicial)){?>
			<option value="<?=$valorinicial;?>"><?=$textoinicial;?></option>
<?		}
		while($row = mysql_fetch_array($result)){
			if ($row[0] == $valordefault){?>
			<option value="<?=$row[0];?>" selected="selected"><?= $row[1];?></option>
<?			}else{?>
			<option value="<?=$row[0];?>"><?=$row[1];?></option>
<?			}
		}?>
		</select>
<?		mysql_free_result($result);
}
function combo_disabled($sql, $nomecombo, $valordefault = null, $textoinicial = null, $complemento, $valorinicial = null){

		

		$result = mysql_query($sql) or die (mysql_error());

		//$result = sql_query($sql) or die(mysql_error());?>

		

		<select id="<?=$nomecombo;?>" name="<?=$nomecombo;?>" <?=$complemento;?>>

<?		if(!empty($textoinicial)){?>

			<option value="<?=$valorinicial;?>"><?=$textoinicial;?></option>

<?		}

		while($row = mysql_fetch_array($result)){

			if ($row[0] == $valordefault){?>

			<option value="<?=$row[0];?>" selected="selected"><?=$row[1];?></option>

<?			}else{?>

			<option value="<?=$row[0];?>"><?=$row[1];?></option>

<?			}

		}?>

		</select>

<?		mysql_free_result($result);

}

?>

	

	

<?	

function combo_tipos($sql, $nomecombo, $tipos, $valordefault = null, $textoinicial = null, $complemento = null, $valorinicial = null){

	//$result = sql_query($sql) or die(mysql_error());	

	$result = mysql_query($sql) or die (mysql_error());	

?>

		<select id="<?=$nomecombo;?>" name="<?=$nomecombo;?>" <?=$complemento;?>>

<?		



if(!empty($textoinicial)){?>

			<option value="<?=$valorinicial;?>" selected="selected"><?=$textoinicial;?></option>

<?		}



		while($row = mysql_fetch_array($result)){

			for($i=0;$i<$tipos['max'];$i++){

				if ($row[0] == $valordefault){

					if($row[2] == $tipos[$i]['valor']){?>

						<option value="<?=$row[0];?>" style="<?=$tipos[$i]['style'];?>" selected="selected"><?=$row[1];?></option>

<?					}

				}else{

					if($row[2] == $tipos[$i]['valor']){?>

						<option value="<?=$row[0];?>" style="<?=$tipos[$i]['style'];?>"><?=$row[1];?></option>

<?					}

				}

			}

		}?>

		</select>

<?		

mysql_free_result($result);

}

?>


<?	function combo_meta($sql, $nomecombo, $tipos, $valordefault = null, $textoinicial = null, $complemento = null, $valorinicial = null, $valorextra1 = null, $valorextra2 = null, $textoextra1 = null, $textoextra2 = null){
		$result = mysql_query($sql) or die (mysql_error());
		//$result = sql_query($sql) or die(mysql_error());?>
		<select id="<?=$nomecombo;?>" name="<?=$nomecombo;?>" <?=$complemento;?>>
<?		if(!empty($textoinicial)){?>
			<option value="<?=$valorinicial;?>" selected="selected"><?=$textoinicial;?></option>
<?		}
		if(!empty($textoextra1)){?>
			<option value="<?=$valorextra1;?>"><?=$textoextra1;?></option>
<?		}
		if(!empty($textoextra2)){?>
			<option value="<?=$valorextra2;?>"><?=$textoextra2;?></option>
<?		}
		while($row = mysql_fetch_array($result)){
			for($i=0;$i<$tipos['max'];$i++){
				if ($row[0] == $valordefault){
					if($row[2] == $tipos[$i]['valor']){?>
						<option value="<?=$row[0];?>" style="<?=$tipos[$i]['style'];?>" selected="selected"><?=$row[1];?></option>
<?					}
				}else{
					if($row[2] == $tipos[$i]['valor']){?>
						<option value="<?=$row[0];?>" style="<?=$tipos[$i]['style'];?>"><?=$row[1];?></option>
<?					}
				}
			}
		}?>

		</select>

<?		mysql_free_result($result);

	}

function combo_nenhum($sql, $nomecombo, $tipos, $valordefault = null, $textoinicial = null, $complemento = null, $valorinicial = null,$nenhum = null){
	//$result = sql_query($sql) or die(mysql_error());	
	$result = mysql_query($sql) or die (mysql_error());	
?>
		<select id="<?=$nomecombo;?>" name="<?=$nomecombo;?>" <?=$complemento;?>>
<?		
if(!empty($textoinicial)){?>
			<option value="<?=$valorinicial;?>" selected="selected"><?=$textoinicial;?></option>
<?}
if(!empty($nenhum)){?>
			<option value="0" <?if($valordefault == "0"){echo "selected";}?> ><?=$nenhum;?></option>
<?}
		while($row = mysql_fetch_array($result)){
			for($i=0;$i<$tipos['max'];$i++){
				if ($row[0] == $valordefault){
					if($row[2] == $tipos[$i]['valor']){?>
						<option value="<?=$row[0];?>" style="<?=$tipos[$i]['style'];?>" selected="selected"><?=$row[1];?></option>
<?					}
				}else{
					if($row[2] == $tipos[$i]['valor']){?>
						<option value="<?=$row[0];?>" style="<?=$tipos[$i]['style'];?>"><?=$row[1];?></option>
<?					}
				}
			}
	}?>
		</select>
<?		
mysql_free_result($result);
}?>
<?
function combo_cidade($nome_cidade=null){
	
?>
<select name=cidade id=cidade >
<option/></option>
<option value='Adamantina' <?if($nome_cidade =='Adamantina'){echo'selected';}?> />Adamantina  </option>
<option value='Adolfo' <?if($nome_cidade =='Adolfo'){echo'selected';}?> />Adolfo</option>
<option value='Aguaí' <?if($nome_cidade =='Aguaí'){echo'selected';}?> />Aguaí </option>
<option value='Águas da Prata' <?if($nome_cidade =='Águas da Prata'){echo'selected';}?> />Águas da Prata </option>
<option value='Águas de Lindóia' <?if($nome_cidade =='Águas de Lindóia'){echo'selected';}?> />Águas de Lindóia  </option>
<option value='Águas de Santa Bárbara' <?if($nome_cidade =='Águas de Santa Bárbara'){echo'selected';}?> />Águas de Santa Bárbara  </option>
<option value='Águas de São Pedro' <?if($nome_cidade =='Águas de São Pedro'){echo'selected';}?> />Águas de São Pedro</option>
<option value='Agudos' <?if($nome_cidade =='Agudos'){echo'selected';}?> />Agudos</option>
<option value='Ajapi' <?if($nome_cidade =='Ajapi'){echo'selected';}?> />Ajapi </option>
<option value='Alambari' <?if($nome_cidade =='Alambari'){echo'selected';}?> />Alambari </option>
<option value='Alfredo Guedes' <?if($nome_cidade =='Alfredo Guedes'){echo'selected';}?> />Alfredo Guedes </option>
<option value='Alfredo Marcondes' <?if($nome_cidade =='Alfredo Marcondes'){echo'selected';}?> />Alfredo Marcondes </option>
<option value='Altair' <?if($nome_cidade =='Altair'){echo'selected';}?> />Altair</option>
<option value='Altinópolis' <?if($nome_cidade =='Altinópolis'){echo'selected';}?> />Altinópolis </option>
<option value='Alumínio' <?if($nome_cidade =='Alumínio'){echo'selected';}?> />Alumínio </option>
<option value='Álvares Machado' <?if($nome_cidade =='Álvares Machado'){echo'selected';}?> />Álvares Machado</option>
<option value='Álvaro de Carvalho' <?if($nome_cidade =='Álvaro de Carvalho'){echo'selected';}?> />Álvaro de Carvalho</option>
<option value='Alvinlândia' <?if($nome_cidade =='Alvinlândia'){echo'selected';}?> />Alvinlândia </option>
<option value='Americana' <?if($nome_cidade =='Americana'){echo'selected';}?> />Americana</option>
<option value='Américo Brasiliense' <?if($nome_cidade =='Américo Brasiliense'){echo'selected';}?> />Américo Brasiliense  </option>
<option value='Américo de Campos' <?if($nome_cidade =='Américo de Campos'){echo'selected';}?> />Américo de Campos </option>
<option value='Amparo' <?if($nome_cidade =='Amparo'){echo'selected';}?> />Amparo</option>
<option value='Ana Dias' <?if($nome_cidade =='Ana Dias'){echo'selected';}?> />Ana Dias </option>
<option value='Analândia' <?if($nome_cidade =='Analândia'){echo'selected';}?> />Analândia</option>
<option value='Andradina' <?if($nome_cidade =='Andradina'){echo'selected';}?> />Andradina</option>
<option value='Angatuba' <?if($nome_cidade =='Angatuba'){echo'selected';}?> />Angatuba </option>
<option value='Anhumas' <?if($nome_cidade =='Anhumas'){echo'selected';}?> />Anhumas  </option>
<option value='Aparecida' <?if($nome_cidade =='Aparecida'){echo'selected';}?> />Aparecida</option>
<option value='Aparecida de Monte Alto' <?if($nome_cidade =='Aparecida de Monte Alto'){echo'selected';}?> />Aparecida de Monte Alto </option>
<option value='Apiaí' <?if($nome_cidade =='Apiaí'){echo'selected';}?> />Apiaí </option>
<option value='Araçariguama' <?if($nome_cidade =='Araçariguama'){echo'selected';}?> />Araçariguama</option>
<option value='Araçatuba' <?if($nome_cidade =='Araçatuba'){echo'selected';}?> />Araçatuba</option>
<option value='Araçoiaba da Serra' <?if($nome_cidade =='Araçoiaba da Serra'){echo'selected';}?> />Araçoiaba da Serra</option>
<option value='Aramina' <?if($nome_cidade =='Aramina'){echo'selected';}?> />Aramina  </option>
<option value='Arandu' <?if($nome_cidade =='Arandu'){echo'selected';}?> />Arandu</option>
<option value='Arapeí' <?if($nome_cidade =='Arapeí'){echo'selected';}?> />Arapeí</option>
<option value='Araraquara' <?if($nome_cidade =='Araraquara'){echo'selected';}?> />Araraquara  </option>
<option value='Araras' <?if($nome_cidade =='Araras'){echo'selected';}?> />Araras</option>
<option value='Areiópolis' <?if($nome_cidade =='Areiópolis'){echo'selected';}?> />Areiópolis  </option>
<option value='Ariranha' <?if($nome_cidade =='Ariranha'){echo'selected';}?> />Ariranha </option>
<option value='Artur Nogueira' <?if($nome_cidade =='Artur Nogueira'){echo'selected';}?> />Artur Nogueira </option>
<option value='Arujá' <?if($nome_cidade =='Arujá'){echo'selected';}?> />Arujá </option>
<option value='Aspásia' <?if($nome_cidade =='Aspásia'){echo'selected';}?> />Aspásia  </option>
<option value='Assis' <?if($nome_cidade =='Assis'){echo'selected';}?> />Assis </option>
<option value='Assistência' <?if($nome_cidade =='Assistência'){echo'selected';}?> />Assistência </option>
<option value='Atibaia' <?if($nome_cidade =='Atibaia'){echo'selected';}?> />Atibaia  </option>
<option value='Auriflama' <?if($nome_cidade =='Auriflama'){echo'selected';}?> />Auriflama</option>
<option value='Avaí' <?if($nome_cidade =='Avaí'){echo'selected';}?> />Avaí  </option>
<option value='Avanhandava' <?if($nome_cidade =='Avanhandava'){echo'selected';}?> />Avanhandava </option>
<option value='Avaré' <?if($nome_cidade =='Avaré'){echo'selected';}?> />Avaré </option>
<option value='Bady Bassitt' <?if($nome_cidade =='Bady Bassitt'){echo'selected';}?> />Bady Bassitt</option>
<option value='Bálsamo' <?if($nome_cidade =='Bálsamo'){echo'selected';}?> />Bálsamo  </option>
<option value='Bananal' <?if($nome_cidade =='Bananal'){echo'selected';}?> />Bananal  </option>
<option value='Barão Ataliba Nogueira' <?if($nome_cidade =='Barão Ataliba Nogueira'){echo'selected';}?> />Barão Ataliba Nogueira  </option>
<option value='Barão de Antonina' <?if($nome_cidade =='Barão de Antonina'){echo'selected';}?> />Barão de Antonina </option>
<option value='Barbosa' <?if($nome_cidade =='Barbosa'){echo'selected';}?> />Barbosa  </option>
<option value='Bariri' <?if($nome_cidade =='Bariri'){echo'selected';}?> />Bariri</option>
<option value='Barra Bonita' <?if($nome_cidade =='Barra Bonita'){echo'selected';}?> />Barra Bonita</option>
<option value='Barra do Chapéu' <?if($nome_cidade =='Barra do Chapéu'){echo'selected';}?> />Barra do Chapéu</option>
<option value='Barra do Turvo' <?if($nome_cidade =='Barra do Turvo'){echo'selected';}?> />Barra do Turvo </option>
<option value='Barretos' <?if($nome_cidade =='Barretos'){echo'selected';}?> />Barretos </option>
<option value='Barrinha' <?if($nome_cidade =='Barrinha'){echo'selected';}?> />Barrinha </option>
<option value='Barueri' <?if($nome_cidade =='Barueri'){echo'selected';}?> />Barueri  </option>
<option value='Bastos' <?if($nome_cidade =='Bastos'){echo'selected';}?> />Bastos</option>
<option value='Batatais' <?if($nome_cidade =='Batatais'){echo'selected';}?> />Batatais </option>
<option value='Batatuba' <?if($nome_cidade =='Batatuba'){echo'selected';}?> />Batatuba </option>
<option value='Bauru' <?if($nome_cidade =='Bauru'){echo'selected';}?> />Bauru </option>
<option value='Bebedouro' <?if($nome_cidade =='Bebedouro'){echo'selected';}?> />Bebedouro</option>
<option value='Bernardino de Campos' <?if($nome_cidade =='Bernardino de Campos'){echo'selected';}?> />Bernardino de Campos </option>
<option value='Bertioga' <?if($nome_cidade =='Bertioga'){echo'selected';}?> />Bertioga </option>
<option value='Bilac' <?if($nome_cidade =='Bilac'){echo'selected';}?> />Bilac </option>
<option value='Birigüi' <?if($nome_cidade =='Birigüi'){echo'selected';}?> />Birigüi  </option>
<option value='Biritiba-Mirim' <?if($nome_cidade =='Biritiba-Mirim'){echo'selected';}?> />Biritiba-Mirim </option>
<option value='Biritiba-Ussu' <?if($nome_cidade =='Biritiba-Ussu'){echo'selected';}?> />Biritiba-Ussu  </option>
<option value='Boa Esperança do Sul' <?if($nome_cidade =='Boa Esperança do Sul'){echo'selected';}?> />Boa Esperança do Sul </option>
<option value='Bocaina' <?if($nome_cidade =='Bocaina'){echo'selected';}?> />Bocaina  </option>
<option value='Bofete' <?if($nome_cidade =='Bofete'){echo'selected';}?> />Bofete</option>
<option value='Boituva' <?if($nome_cidade =='Boituva'){echo'selected';}?> />Boituva  </option>
<option value='Bom Fim do Bom Jesus' <?if($nome_cidade =='Bom Fim do Bom Jesus'){echo'selected';}?> />Bom Fim do Bom Jesus </option>
<option value='Bom Jesus dos Perdões' <?if($nome_cidade =='Bom Jesus dos Perdões'){echo'selected';}?> />Bom Jesus dos Perdões</option>
<option value='Bom Sucesso de Itararé' <?if($nome_cidade =='Bom Sucesso de Itararé'){echo'selected';}?> />Bom Sucesso de Itararé  </option>
<option value='Bonfim Paulista' <?if($nome_cidade =='Bonfim Paulista'){echo'selected';}?> />Bonfim Paulista</option>
<option value='Borá' <?if($nome_cidade =='Borá'){echo'selected';}?> />Borá  </option>
<option value='Boracéia' <?if($nome_cidade =='Boracéia'){echo'selected';}?> />Boracéia </option>
<option value='Borborema' <?if($nome_cidade =='Borborema'){echo'selected';}?> />Borborema</option>
<option value='Botucatu' <?if($nome_cidade =='Botucatu'){echo'selected';}?> />Botucatu </option>
<option value='Bragança Paulista' <?if($nome_cidade =='Bragança Paulista'){echo'selected';}?> />Bragança Paulista </option>
<option value='Braúna' <?if($nome_cidade =='Braúna'){echo'selected';}?> />Braúna</option>
<option value='Brodowski' <?if($nome_cidade =='Brodowski'){echo'selected';}?> />Brodowski</option>
<option value='Brotas' <?if($nome_cidade =='Brotas'){echo'selected';}?> />Brotas</option>
<option value='Bueno de Andrada' <?if($nome_cidade =='Bueno de Andrada'){echo'selected';}?> />Bueno de Andrada  </option>
<option value='Buri' <?if($nome_cidade =='Buri'){echo'selected';}?> />Buri  </option>
<option value='Buritama' <?if($nome_cidade =='Buritama'){echo'selected';}?> />Buritama </option>
<option value='Cabrália Paulista' <?if($nome_cidade =='Cabrália Paulista'){echo'selected';}?> />Cabrália Paulista </option>
<option value='Cabreúva' <?if($nome_cidade =='Cabreúva'){echo'selected';}?> />Cabreúva </option>
<option value='Caçapava' <?if($nome_cidade =='Caçapava'){echo'selected';}?> />Caçapava </option>
<option value='Cachoeira Paulista' <?if($nome_cidade =='Cachoeira Paulista'){echo'selected';}?> />Cachoeira Paulista</option>
<option value='Caconde' <?if($nome_cidade =='Caconde'){echo'selected';}?> />Caconde  </option>
<option value='Cafelândia' <?if($nome_cidade =='Cafelândia'){echo'selected';}?> />Cafelândia  </option>
<option value='Cafesópolis' <?if($nome_cidade =='Cafesópolis'){echo'selected';}?> />Cafesópolis </option>
<option value='Caiabu' <?if($nome_cidade =='Caiabu'){echo'selected';}?> />Caiabu</option>
<option value='Caibura' <?if($nome_cidade =='Caibura'){echo'selected';}?> />Caibura  </option>
<option value='Caieiras' <?if($nome_cidade =='Caieiras'){echo'selected';}?> />Caieiras </option>
<option value='Caiuá' <?if($nome_cidade =='Caiuá'){echo'selected';}?> />Caiuá </option>
<option value='Cajamar' <?if($nome_cidade =='Cajamar'){echo'selected';}?> />Cajamar  </option>
<option value='Cajati' <?if($nome_cidade =='Cajati'){echo'selected';}?> />Cajati</option>
<option value='Cajobi' <?if($nome_cidade =='Cajobi'){echo'selected';}?> />Cajobi</option>
<option value='Cajuru' <?if($nome_cidade =='Cajuru'){echo'selected';}?> />Cajuru</option>
<option value='Campina do Monte Alegre' <?if($nome_cidade =='Campina do Monte Alegre'){echo'selected';}?> />Campina do Monte Alegre </option>
<option value='Campinas' <?if($nome_cidade =='Campinas'){echo'selected';}?> />Campinas </option>
<option value='Campo Limpo Paulista' <?if($nome_cidade =='Campo Limpo Paulista'){echo'selected';}?> />Campo Limpo Paulista </option>
<option value='Campos de Cunha' <?if($nome_cidade =='Campos de Cunha'){echo'selected';}?> />Campos de Cunha</option>
<option value='Campos do Jordão' <?if($nome_cidade =='Campos do Jordão'){echo'selected';}?> />Campos do Jordão  </option>
<option value='Campos Novos Paulista' <?if($nome_cidade =='Campos Novos Paulista'){echo'selected';}?> />Campos Novos Paulista</option>
<option value='Cananéia' <?if($nome_cidade =='Cananéia'){echo'selected';}?> />Cananéia </option>
<option value='Canas' <?if($nome_cidade =='Canas'){echo'selected';}?> />Canas </option>
<option value='Cândido Mota' <?if($nome_cidade =='Cândido Mota'){echo'selected';}?> />Cândido Mota</option>
<option value='Canguera' <?if($nome_cidade =='Canguera'){echo'selected';}?> />Canguera </option>
<option value='Capão Bonito' <?if($nome_cidade =='Capão Bonito'){echo'selected';}?> />Capão Bonito</option>
<option value='Capela do Alto' <?if($nome_cidade =='Capela do Alto'){echo'selected';}?> />Capela do Alto </option>
<option value='Capivari' <?if($nome_cidade =='Capivari'){echo'selected';}?> />Capivari </option>
<option value='Caraguatatuba' <?if($nome_cidade =='Caraguatatuba'){echo'selected';}?> />Caraguatatuba  </option>
<option value='Carapicu&#237;ba' <?if($nome_cidade =='Carapicu&#237;ba'){echo'selected';}?> />Carapicu&#237;ba  </option>
<option value='Carapicuíba' <?if($nome_cidade =='Carapicuíba'){echo'selected';}?> />Carapicuíba </option>
<option value='Cardoso' <?if($nome_cidade =='Cardoso'){echo'selected';}?> />Cardoso  </option>
<option value='Caruara' <?if($nome_cidade =='Caruara'){echo'selected';}?> />Caruara  </option>
<option value='Casa Branca' <?if($nome_cidade =='Casa Branca'){echo'selected';}?> />Casa Branca </option>
<option value='Castilho' <?if($nome_cidade =='Castilho'){echo'selected';}?> />Castilho </option>
<option value='Catanduva' <?if($nome_cidade =='Catanduva'){echo'selected';}?> />Catanduva</option>
<option value='Catiguá' <?if($nome_cidade =='Catiguá'){echo'selected';}?> />Catiguá  </option>
<option value='Catucaba' <?if($nome_cidade =='Catucaba'){echo'selected';}?> />Catucaba </option>
<option value='Cedral' <?if($nome_cidade =='Cedral'){echo'selected';}?> />Cedral</option>
<option value='Cerqueira César' <?if($nome_cidade =='Cerqueira César'){echo'selected';}?> />Cerqueira César</option>
<option value='Cerquilho' <?if($nome_cidade =='Cerquilho'){echo'selected';}?> />Cerquilho</option>
<option value='Cesário Lange' <?if($nome_cidade =='Cesário Lange'){echo'selected';}?> />Cesário Lange  </option>
<option value='Charqueada' <?if($nome_cidade =='Charqueada'){echo'selected';}?> />Charqueada  </option>
<option value='Chavantes' <?if($nome_cidade =='Chavantes'){echo'selected';}?> />Chavantes</option>
<option value='Cipó-Guaçu' <?if($nome_cidade =='Cipó-Guaçu'){echo'selected';}?> />Cipó-Guaçu  </option>
<option value='Clementina' <?if($nome_cidade =='Clementina'){echo'selected';}?> />Clementina  </option>
<option value='Colina' <?if($nome_cidade =='Colina'){echo'selected';}?> />Colina</option>
<option value='Colômbia' <?if($nome_cidade =='Colômbia'){echo'selected';}?> />Colômbia </option>
<option value='Conceição de Monte Alegre  n>' <?if($nome_cidade =='Conceição de Monte Alegre  n>'){echo'selected';}?> />Conceição de Monte Alegre  n></option>
<option value='Conchal' <?if($nome_cidade =='Conchal'){echo'selected';}?> />Conchal  </option>
<option value='Conchas' <?if($nome_cidade =='Conchas'){echo'selected';}?> />Conchas  </option>
<option value='Cordeirópolis' <?if($nome_cidade =='Cordeirópolis'){echo'selected';}?> />Cordeirópolis  </option>
<option value='Coroados' <?if($nome_cidade =='Coroados'){echo'selected';}?> />Coroados </option>
<option value='Corredeira' <?if($nome_cidade =='Corredeira'){echo'selected';}?> />Corredeira  </option>
<option value='Corumbataí' <?if($nome_cidade =='Corumbataí'){echo'selected';}?> />Corumbataí  </option>
<option value='Cosmópolis' <?if($nome_cidade =='Cosmópolis'){echo'selected';}?> />Cosmópolis  </option>
<option value='Cosmorama' <?if($nome_cidade =='Cosmorama'){echo'selected';}?> />Cosmorama</option>
<option value='Cotia' <?if($nome_cidade =='Cotia'){echo'selected';}?> />Cotia </option>
<option value='Cravinhos' <?if($nome_cidade =='Cravinhos'){echo'selected';}?> />Cravinhos</option>
<option value='Cristais Paulista' <?if($nome_cidade =='Cristais Paulista'){echo'selected';}?> />Cristais Paulista </option>
<option value='Cruzeiro' <?if($nome_cidade =='Cruzeiro'){echo'selected';}?> />Cruzeiro </option>
<option value='Cubatão' <?if($nome_cidade =='Cubatão'){echo'selected';}?> />Cubatão  </option>
<option value='Cunha' <?if($nome_cidade =='Cunha'){echo'selected';}?> />Cunha </option>
<option value='Descalvado' <?if($nome_cidade =='Descalvado'){echo'selected';}?> />Descalvado  </option>
<option value='Diadema' <?if($nome_cidade =='Diadema'){echo'selected';}?> />Diadema  </option>
<option value='Dirce Reis' <?if($nome_cidade =='Dirce Reis'){echo'selected';}?> />Dirce Reis  </option>
<option value='Divinolândia' <?if($nome_cidade =='Divinolândia'){echo'selected';}?> />Divinolândia</option>
<option value='Dois Córregos' <?if($nome_cidade =='Dois Córregos'){echo'selected';}?> />Dois Córregos  </option>
<option value='Dourado' <?if($nome_cidade =='Dourado'){echo'selected';}?> />Dourado  </option>
<option value='Dracena' <?if($nome_cidade =='Dracena'){echo'selected';}?> />Dracena  </option>
<option value='Duartina' <?if($nome_cidade =='Duartina'){echo'selected';}?> />Duartina </option>
<option value='Echaporã' <?if($nome_cidade =='Echaporã'){echo'selected';}?> />Echaporã </option>
<option value='Eldorado' <?if($nome_cidade =='Eldorado'){echo'selected';}?> />Eldorado </option>
<option value='Elias Fausto' <?if($nome_cidade =='Elias Fausto'){echo'selected';}?> />Elias Fausto</option>
<option value='Elisiário' <?if($nome_cidade =='Elisiário'){echo'selected';}?> />Elisiário</option>
<option value='Embu' <?if($nome_cidade =='Embu'){echo'selected';}?> />Embu  </option>
<option value='Embu das Artes' <?if($nome_cidade =='Embu das Artes'){echo'selected';}?> />Embu das Artes </option>
<option value='Embu-Guaçu' <?if($nome_cidade =='Embu-Guaçu'){echo'selected';}?> />Embu-Guaçu  </option>
<option value='Emilianópolis' <?if($nome_cidade =='Emilianópolis'){echo'selected';}?> />Emilianópolis  </option>
<option value='Engenheiro Coelho' <?if($nome_cidade =='Engenheiro Coelho'){echo'selected';}?> />Engenheiro Coelho </option>
<option value='Engenheiro Schmidt' <?if($nome_cidade =='Engenheiro Schmidt'){echo'selected';}?> />Engenheiro Schmidt</option>
<option value='Espigão' <?if($nome_cidade =='Espigão'){echo'selected';}?> />Espigão  </option>
<option value='Espírito Santo do Pinhal' <?if($nome_cidade =='Espírito Santo do Pinhal'){echo'selected';}?> />Espírito Santo do Pinhal</option>
<option value='Estiva Gerbi' <?if($nome_cidade =='Estiva Gerbi'){echo'selected';}?> />Estiva Gerbi</option>
<option value='Euclides da Cunha Paulista ion>' <?if($nome_cidade =='Euclides da Cunha Paulista ion>'){echo'selected';}?> />Euclides da Cunha Paulista ion></option>
<option value='Fartura' <?if($nome_cidade =='Fartura'){echo'selected';}?> />Fartura  </option>
<option value='Fernando Prestes' <?if($nome_cidade =='Fernando Prestes'){echo'selected';}?> />Fernando Prestes  </option>
<option value='Fernandópolis' <?if($nome_cidade =='Fernandópolis'){echo'selected';}?> />Fernandópolis  </option>
<option value='Ferraz de Vasconcelos' <?if($nome_cidade =='Ferraz de Vasconcelos'){echo'selected';}?> />Ferraz de Vasconcelos</option>
<option value='Floreal' <?if($nome_cidade =='Floreal'){echo'selected';}?> />Floreal  </option>
<option value='Flórida Paulista' <?if($nome_cidade =='Flórida Paulista'){echo'selected';}?> />Flórida Paulista  </option>
<option value='Florínia' <?if($nome_cidade =='Florínia'){echo'selected';}?> />Florínia </option>
<option value='Franca' <?if($nome_cidade =='Franca'){echo'selected';}?> />Franca</option>
<option value='Francisco Morato' <?if($nome_cidade =='Francisco Morato'){echo'selected';}?> />Francisco Morato  </option>
<option value='Franco da Rocha' <?if($nome_cidade =='Franco da Rocha'){echo'selected';}?> />Franco da Rocha</option>
<option value='Gabriel Monteiro' <?if($nome_cidade =='Gabriel Monteiro'){echo'selected';}?> />Gabriel Monteiro  </option>
<option value='Garça' <?if($nome_cidade =='Garça'){echo'selected';}?> />Garça </option>
<option value='Gastão Vidigal' <?if($nome_cidade =='Gastão Vidigal'){echo'selected';}?> />Gastão Vidigal </option>
<option value='Gavião Peixoto' <?if($nome_cidade =='Gavião Peixoto'){echo'selected';}?> />Gavião Peixoto </option>
<option value='General Salgado' <?if($nome_cidade =='General Salgado'){echo'selected';}?> />General Salgado</option>
<option value='Getulina' <?if($nome_cidade =='Getulina'){echo'selected';}?> />Getulina </option>
<option value='Guaiçara' <?if($nome_cidade =='Guaiçara'){echo'selected';}?> />Guaiçara </option>
<option value='Guaíra' <?if($nome_cidade =='Guaíra'){echo'selected';}?> />Guaíra</option>
<option value='Guapiaçu' <?if($nome_cidade =='Guapiaçu'){echo'selected';}?> />Guapiaçu </option>
<option value='Guará' <?if($nome_cidade =='Guará'){echo'selected';}?> />Guará </option>
<option value='Guaraçaí' <?if($nome_cidade =='Guaraçaí'){echo'selected';}?> />Guaraçaí </option>
<option value='Guarantã' <?if($nome_cidade =='Guarantã'){echo'selected';}?> />Guarantã </option>
<option value='Guarapiranga' <?if($nome_cidade =='Guarapiranga'){echo'selected';}?> />Guarapiranga</option>
<option value='Guararapes' <?if($nome_cidade =='Guararapes'){echo'selected';}?> />Guararapes  </option>
<option value='Guararema' <?if($nome_cidade =='Guararema'){echo'selected';}?> />Guararema</option>
<option value='Guaratinguetá' <?if($nome_cidade =='Guaratinguetá'){echo'selected';}?> />Guaratinguetá  </option>
<option value='Guareí' <?if($nome_cidade =='Guareí'){echo'selected';}?> />Guareí</option>
<option value='Guariba' <?if($nome_cidade =='Guariba'){echo'selected';}?> />Guariba  </option>
<option value='Guarujá' <?if($nome_cidade =='Guarujá'){echo'selected';}?> />Guarujá  </option>
<option value='Guarulhos' <?if($nome_cidade =='Guarulhos'){echo'selected';}?> />Guarulhos</option>
<option value='Holambra' <?if($nome_cidade =='Holambra'){echo'selected';}?> />Holambra </option>
<option value='Holambra II' <?if($nome_cidade =='Holambra II'){echo'selected';}?> />Holambra II </option>
<option value='Hortolândia' <?if($nome_cidade =='Hortolândia'){echo'selected';}?> />Hortolândia </option>
<option value='Iacanga' <?if($nome_cidade =='Iacanga'){echo'selected';}?> />Iacanga  </option>
<option value='Iacri' <?if($nome_cidade =='Iacri'){echo'selected';}?> />Iacri </option>
<option value='Ibaté' <?if($nome_cidade =='Ibaté'){echo'selected';}?> />Ibaté </option>
<option value='Ibirá' <?if($nome_cidade =='Ibirá'){echo'selected';}?> />Ibirá </option>
<option value='Ibitinga' <?if($nome_cidade =='Ibitinga'){echo'selected';}?> />Ibitinga </option>
<option value='Ibiúna' <?if($nome_cidade =='Ibiúna'){echo'selected';}?> />Ibiúna</option>
<option value='Icém' <?if($nome_cidade =='Icém'){echo'selected';}?> />Icém  </option>
<option value='Iepê' <?if($nome_cidade =='Iepê'){echo'selected';}?> />Iepê  </option>
<option value='Igaraçu do Tietê' <?if($nome_cidade =='Igaraçu do Tietê'){echo'selected';}?> />Igaraçu do Tietê  </option>
<option value='Igarapava' <?if($nome_cidade =='Igarapava'){echo'selected';}?> />Igarapava</option>
<option value='Igaratá' <?if($nome_cidade =='Igaratá'){echo'selected';}?> />Igaratá  </option>
<option value='Iguape' <?if($nome_cidade =='Iguape'){echo'selected';}?> />Iguape</option>
<option value='Ilha Comprida' <?if($nome_cidade =='Ilha Comprida'){echo'selected';}?> />Ilha Comprida  </option>
<option value='Ilha Diana' <?if($nome_cidade =='Ilha Diana'){echo'selected';}?> />Ilha Diana  </option>
<option value='Ilha Solteira' <?if($nome_cidade =='Ilha Solteira'){echo'selected';}?> />Ilha Solteira  </option>
<option value='Ilhabela' <?if($nome_cidade =='Ilhabela'){echo'selected';}?> />Ilhabela </option>
<option value='Indaiatuba' <?if($nome_cidade =='Indaiatuba'){echo'selected';}?> />Indaiatuba  </option>
<option value='Indiana' <?if($nome_cidade =='Indiana'){echo'selected';}?> />Indiana  </option>
<option value='Inúbia Paulista' <?if($nome_cidade =='Inúbia Paulista'){echo'selected';}?> />Inúbia Paulista</option>
<option value='Ipaussu' <?if($nome_cidade =='Ipaussu'){echo'selected';}?> />Ipaussu  </option>
<option value='Iperó' <?if($nome_cidade =='Iperó'){echo'selected';}?> />Iperó </option>
<option value='Ipeúna' <?if($nome_cidade =='Ipeúna'){echo'selected';}?> />Ipeúna</option>
<option value='Ipiguá' <?if($nome_cidade =='Ipiguá'){echo'selected';}?> />Ipiguá</option>
<option value='Iporanga' <?if($nome_cidade =='Iporanga'){echo'selected';}?> />Iporanga </option>
<option value='Iracemápolis' <?if($nome_cidade =='Iracemápolis'){echo'selected';}?> />Iracemápolis</option>
<option value='Irapuã' <?if($nome_cidade =='Irapuã'){echo'selected';}?> />Irapuã</option>
<option value='Irapuru' <?if($nome_cidade =='Irapuru'){echo'selected';}?> />Irapuru  </option>
<option value='Itaberá' <?if($nome_cidade =='Itaberá'){echo'selected';}?> />Itaberá  </option>
<option value='Itaí' <?if($nome_cidade =='Itaí'){echo'selected';}?> />Itaí  </option>
<option value='Itajobi' <?if($nome_cidade =='Itajobi'){echo'selected';}?> />Itajobi  </option>
<option value='Itanhaém' <?if($nome_cidade =='Itanhaém'){echo'selected';}?> />Itanhaém </option>
<option value='Itapecerica da Serra' <?if($nome_cidade =='Itapecerica da Serra'){echo'selected';}?> />Itapecerica da Serra </option>
<option value='Itapetininga' <?if($nome_cidade =='Itapetininga'){echo'selected';}?> />Itapetininga</option>
<option value='Itapeva' <?if($nome_cidade =='Itapeva'){echo'selected';}?> />Itapeva  </option>
<option value='Itapevi' <?if($nome_cidade =='Itapevi'){echo'selected';}?> />Itapevi  </option>
<option value='Itapira' <?if($nome_cidade =='Itapira'){echo'selected';}?> />Itapira  </option>
<option value='Itapirapuã Paulista' <?if($nome_cidade =='Itapirapuã Paulista'){echo'selected';}?> />Itapirapuã Paulista  </option>
<option value='Itápolis' <?if($nome_cidade =='Itápolis'){echo'selected';}?> />Itápolis </option>
<option value='Itaporanga' <?if($nome_cidade =='Itaporanga'){echo'selected';}?> />Itaporanga  </option>
<option value='Itapuí' <?if($nome_cidade =='Itapuí'){echo'selected';}?> />Itapuí</option>
<option value='Itapura' <?if($nome_cidade =='Itapura'){echo'selected';}?> />Itapura  </option>
<option value='Itaquaquecetuba' <?if($nome_cidade =='Itaquaquecetuba'){echo'selected';}?> />Itaquaquecetuba</option>
<option value='Itararé' <?if($nome_cidade =='Itararé'){echo'selected';}?> />Itararé  </option>
<option value='Itariri' <?if($nome_cidade =='Itariri'){echo'selected';}?> />Itariri  </option>
<option value='Itatiba' <?if($nome_cidade =='Itatiba'){echo'selected';}?> />Itatiba  </option>
<option value='Itatinga' <?if($nome_cidade =='Itatinga'){echo'selected';}?> />Itatinga </option>
<option value='Itirapina' <?if($nome_cidade =='Itirapina'){echo'selected';}?> />Itirapina</option>
<option value='Itirapuã' <?if($nome_cidade =='Itirapuã'){echo'selected';}?> />Itirapuã </option>
<option value='Itu' <?if($nome_cidade =='Itu'){echo'selected';}?> />Itu</option>
<option value='Itupeva' <?if($nome_cidade =='Itupeva'){echo'selected';}?> />Itupeva  </option>
<option value='Ituverava' <?if($nome_cidade =='Ituverava'){echo'selected';}?> />Ituverava</option>
<option value='Jaborandi' <?if($nome_cidade =='Jaborandi'){echo'selected';}?> />Jaborandi</option>
<option value='Jaboticabal' <?if($nome_cidade =='Jaboticabal'){echo'selected';}?> />Jaboticabal </option>
<option value='Jacaré' <?if($nome_cidade =='Jacaré'){echo'selected';}?> />Jacaré</option>
<option value='Jacareí' <?if($nome_cidade =='Jacareí'){echo'selected';}?> />Jacareí  </option>
<option value='Jaci' <?if($nome_cidade =='Jaci'){echo'selected';}?> />Jaci  </option>
<option value='Jacupiranga' <?if($nome_cidade =='Jacupiranga'){echo'selected';}?> />Jacupiranga </option>
<option value='Jaguariúna' <?if($nome_cidade =='Jaguariúna'){echo'selected';}?> />Jaguariúna  </option>
<option value='Jales' <?if($nome_cidade =='Jales'){echo'selected';}?> />Jales </option>
<option value='Jambeiro' <?if($nome_cidade =='Jambeiro'){echo'selected';}?> />Jambeiro </option>
<option value='Jandira' <?if($nome_cidade =='Jandira'){echo'selected';}?> />Jandira  </option>
<option value='Jardinópolis' <?if($nome_cidade =='Jardinópolis'){echo'selected';}?> />Jardinópolis</option>
<option value='Jarinu' <?if($nome_cidade =='Jarinu'){echo'selected';}?> />Jarinu</option>
<option value='Jaú' <?if($nome_cidade =='Jaú'){echo'selected';}?> />Jaú</option>
<option value='Jeriquara' <?if($nome_cidade =='Jeriquara'){echo'selected';}?> />Jeriquara</option>
<option value='Joanópolis' <?if($nome_cidade =='Joanópolis'){echo'selected';}?> />Joanópolis  </option>
<option value='João Ramalho' <?if($nome_cidade =='João Ramalho'){echo'selected';}?> />João Ramalho</option>
<option value='Jordanésia' <?if($nome_cidade =='Jordanésia'){echo'selected';}?> />Jordanésia  </option>
<option value='José Bonifácio' <?if($nome_cidade =='José Bonifácio'){echo'selected';}?> />José Bonifácio </option>
<option value='Jumirim' <?if($nome_cidade =='Jumirim'){echo'selected';}?> />Jumirim  </option>
<option value='Jundia&#237;' <?if($nome_cidade =='Jundia&#237;'){echo'selected';}?> />Jundia&#237;</option>
<option value='Jundiaí' <?if($nome_cidade =='Jundiaí'){echo'selected';}?> />Jundiaí  </option>
<option value='Junqueirópolis' <?if($nome_cidade =='Junqueirópolis'){echo'selected';}?> />Junqueirópolis </option>
<option value='Juquiá' <?if($nome_cidade =='Juquiá'){echo'selected';}?> />Juquiá</option>
<option value='Juquiratiba' <?if($nome_cidade =='Juquiratiba'){echo'selected';}?> />Juquiratiba </option>
<option value='Juquitiba' <?if($nome_cidade =='Juquitiba'){echo'selected';}?> />Juquitiba</option>
<option value='Lagoinha' <?if($nome_cidade =='Lagoinha'){echo'selected';}?> />Lagoinha </option>
<option value='Laranjal Paulista' <?if($nome_cidade =='Laranjal Paulista'){echo'selected';}?> />Laranjal Paulista </option>
<option value='Lavínia' <?if($nome_cidade =='Lavínia'){echo'selected';}?> />Lavínia  </option>
<option value='Lavrinhas' <?if($nome_cidade =='Lavrinhas'){echo'selected';}?> />Lavrinhas</option>
<option value='Leme' <?if($nome_cidade =='Leme'){echo'selected';}?> />Leme  </option>
<option value='Lençóis Paulista' <?if($nome_cidade =='Lençóis Paulista'){echo'selected';}?> />Lençóis Paulista  </option>
<option value='Limeira' <?if($nome_cidade =='Limeira'){echo'selected';}?> />Limeira  </option>
<option value='Lindóia' <?if($nome_cidade =='Lindóia'){echo'selected';}?> />Lindóia  </option>
<option value='Lins' <?if($nome_cidade =='Lins'){echo'selected';}?> />Lins  </option>
<option value='Lorena' <?if($nome_cidade =='Lorena'){echo'selected';}?> />Lorena</option>
<option value='Louveira' <?if($nome_cidade =='Louveira'){echo'selected';}?> />Louveira </option>
<option value='Lucélia' <?if($nome_cidade =='Lucélia'){echo'selected';}?> />Lucélia  </option>
<option value='Lucianópolis' <?if($nome_cidade =='Lucianópolis'){echo'selected';}?> />Lucianópolis</option>
<option value='Luís Antônio' <?if($nome_cidade =='Luís Antônio'){echo'selected';}?> />Luís Antônio</option>
<option value='Luiziânia' <?if($nome_cidade =='Luiziânia'){echo'selected';}?> />Luiziânia</option>
<option value='Lupércio' <?if($nome_cidade =='Lupércio'){echo'selected';}?> />Lupércio </option>
<option value='Lusitânia' <?if($nome_cidade =='Lusitânia'){echo'selected';}?> />Lusitânia</option>
<option value='Lutécia' <?if($nome_cidade =='Lutécia'){echo'selected';}?> />Lutécia  </option>
<option value='Macaubal' <?if($nome_cidade =='Macaubal'){echo'selected';}?> />Macaubal </option>
<option value='Magda' <?if($nome_cidade =='Magda'){echo'selected';}?> />Magda </option>
<option value='Mailasqui' <?if($nome_cidade =='Mailasqui'){echo'selected';}?> />Mailasqui</option>
<option value='Mairinque' <?if($nome_cidade =='Mairinque'){echo'selected';}?> />Mairinque</option>
<option value='Mairiporã' <?if($nome_cidade =='Mairiporã'){echo'selected';}?> />Mairiporã</option>
<option value='Manduri' <?if($nome_cidade =='Manduri'){echo'selected';}?> />Manduri  </option>
<option value='Marabá Paulista' <?if($nome_cidade =='Marabá Paulista'){echo'selected';}?> />Marabá Paulista</option>
<option value='Maraçaí' <?if($nome_cidade =='Maraçaí'){echo'selected';}?> />Maraçaí  </option>
<option value='Marapoama' <?if($nome_cidade =='Marapoama'){echo'selected';}?> />Marapoama</option>
<option value='Maresias' <?if($nome_cidade =='Maresias'){echo'selected';}?> />Maresias </option>
<option value='Mariápolis' <?if($nome_cidade =='Mariápolis'){echo'selected';}?> />Mariápolis  </option>
<option value='Marília' <?if($nome_cidade =='Marília'){echo'selected';}?> />Marília  </option>
<option value='Maristela' <?if($nome_cidade =='Maristela'){echo'selected';}?> />Maristela</option>
<option value='Martinópolis' <?if($nome_cidade =='Martinópolis'){echo'selected';}?> />Martinópolis</option>
<option value='Matão' <?if($nome_cidade =='Matão'){echo'selected';}?> />Matão </option>
<option value='Mau&#225;' <?if($nome_cidade =='Mau&#225;'){echo'selected';}?> />Mau&#225;</option>
<option value='Mauá' <?if($nome_cidade =='Mauá'){echo'selected';}?> />Mauá  </option>
<option value='Mendonça' <?if($nome_cidade =='Mendonça'){echo'selected';}?> />Mendonça </option>
<option value='Meridiano' <?if($nome_cidade =='Meridiano'){echo'selected';}?> />Meridiano</option>
<option value='Miguelópolis' <?if($nome_cidade =='Miguelópolis'){echo'selected';}?> />Miguelópolis</option>
<option value='Mineiros do Tietê' <?if($nome_cidade =='Mineiros do Tietê'){echo'selected';}?> />Mineiros do Tietê </option>
<option value='Mira Estrela' <?if($nome_cidade =='Mira Estrela'){echo'selected';}?> />Mira Estrela</option>
<option value='Miracatu' <?if($nome_cidade =='Miracatu'){echo'selected';}?> />Miracatu </option>
<option value='Mirandópolis' <?if($nome_cidade =='Mirandópolis'){echo'selected';}?> />Mirandópolis</option>
<option value='Mirante do Paranapanema' <?if($nome_cidade =='Mirante do Paranapanema'){echo'selected';}?> />Mirante do Paranapanema </option>
<option value='Mirassol' <?if($nome_cidade =='Mirassol'){echo'selected';}?> />Mirassol </option>
<option value='Mococa' <?if($nome_cidade =='Mococa'){echo'selected';}?> />Mococa</option>
<option value='Mogi das Cruzes' <?if($nome_cidade =='Mogi das Cruzes'){echo'selected';}?> />Mogi das Cruzes</option>
<option value='Mogi Guaçu' <?if($nome_cidade =='Mogi Guaçu'){echo'selected';}?> />Mogi Guaçu  </option>
<option value='Mogi Mirim' <?if($nome_cidade =='Mogi Mirim'){echo'selected';}?> />Mogi Mirim  </option>
<option value='Mogi-Guaçu' <?if($nome_cidade =='Mogi-Guaçu'){echo'selected';}?> />Mogi-Guaçu  </option>
<option value='Mogi-Mirim' <?if($nome_cidade =='Mogi-Mirim'){echo'selected';}?> />Mogi-Mirim  </option>
<option value='Mombuca' <?if($nome_cidade =='Mombuca'){echo'selected';}?> />Mombuca  </option>
<option value='Monções' <?if($nome_cidade =='Monções'){echo'selected';}?> />Monções  </option>
<option value='Mongaguá' <?if($nome_cidade =='Mongaguá'){echo'selected';}?> />Mongaguá </option>
<option value='Monte Alegre do Sul' <?if($nome_cidade =='Monte Alegre do Sul'){echo'selected';}?> />Monte Alegre do Sul  </option>
<option value='Monte Alto' <?if($nome_cidade =='Monte Alto'){echo'selected';}?> />Monte Alto  </option>
<option value='Monte Aprazível' <?if($nome_cidade =='Monte Aprazível'){echo'selected';}?> />Monte Aprazível</option>
<option value='Monte Azul Paulista' <?if($nome_cidade =='Monte Azul Paulista'){echo'selected';}?> />Monte Azul Paulista  </option>
<option value='Monte Cabrão' <?if($nome_cidade =='Monte Cabrão'){echo'selected';}?> />Monte Cabrão</option>
<option value='Monte Mor' <?if($nome_cidade =='Monte Mor'){echo'selected';}?> />Monte Mor</option>
<option value='Monteiro Lobato' <?if($nome_cidade =='Monteiro Lobato'){echo'selected';}?> />Monteiro Lobato</option>
<option value='Morro Agudo' <?if($nome_cidade =='Morro Agudo'){echo'selected';}?> />Morro Agudo </option>
<option value='Morungaba' <?if($nome_cidade =='Morungaba'){echo'selected';}?> />Morungaba</option>
<option value='Narandiba' <?if($nome_cidade =='Narandiba'){echo'selected';}?> />Narandiba</option>
<option value='Natividade da Serra' <?if($nome_cidade =='Natividade da Serra'){echo'selected';}?> />Natividade da Serra  </option>
<option value='Nazaré Paulista' <?if($nome_cidade =='Nazaré Paulista'){echo'selected';}?> />Nazaré Paulista</option>
<option value='Neves Paulista' <?if($nome_cidade =='Neves Paulista'){echo'selected';}?> />Neves Paulista </option>
<option value='Nhandeara' <?if($nome_cidade =='Nhandeara'){echo'selected';}?> />Nhandeara</option>
<option value='Nipoã' <?if($nome_cidade =='Nipoã'){echo'selected';}?> />Nipoã </option>
<option value='Nossa Senhora do Remédio' <?if($nome_cidade =='Nossa Senhora do Remédio'){echo'selected';}?> />Nossa Senhora do Remédio</option>
<option value='Nova Aliança' <?if($nome_cidade =='Nova Aliança'){echo'selected';}?> />Nova Aliança</option>
<option value='Nova Campina' <?if($nome_cidade =='Nova Campina'){echo'selected';}?> />Nova Campina</option>
<option value='Nova Canaã Paulista' <?if($nome_cidade =='Nova Canaã Paulista'){echo'selected';}?> />Nova Canaã Paulista  </option>
<option value='Nova Castilho' <?if($nome_cidade =='Nova Castilho'){echo'selected';}?> />Nova Castilho  </option>
<option value='Nova Europa' <?if($nome_cidade =='Nova Europa'){echo'selected';}?> />Nova Europa </option>
<option value='Nova Granada' <?if($nome_cidade =='Nova Granada'){echo'selected';}?> />Nova Granada</option>
<option value='Nova Odessa' <?if($nome_cidade =='Nova Odessa'){echo'selected';}?> />Nova Odessa </option>
<option value='Novais' <?if($nome_cidade =='Novais'){echo'selected';}?> />Novais</option>
<option value='Novo Horizonte' <?if($nome_cidade =='Novo Horizonte'){echo'selected';}?> />Novo Horizonte </option>
<option value='Nuporanga' <?if($nome_cidade =='Nuporanga'){echo'selected';}?> />Nuporanga</option>
<option value='Olímpia' <?if($nome_cidade =='Olímpia'){echo'selected';}?> />Olímpia  </option>
<option value='Oriente' <?if($nome_cidade =='Oriente'){echo'selected';}?> />Oriente  </option>
<option value='Orindiúva' <?if($nome_cidade =='Orindiúva'){echo'selected';}?> />Orindiúva</option>
<option value='Orlândia' <?if($nome_cidade =='Orlândia'){echo'selected';}?> />Orlândia </option>
<option value='Osasco' <?if($nome_cidade =='Osasco'){echo'selected';}?> />Osasco</option>
<option value='Osvaldo Cruz' <?if($nome_cidade =='Osvaldo Cruz'){echo'selected';}?> />Osvaldo Cruz</option>
<option value='Ourinhos' <?if($nome_cidade =='Ourinhos'){echo'selected';}?> />Ourinhos </option>
<option value='Ouro Verde' <?if($nome_cidade =='Ouro Verde'){echo'selected';}?> />Ouro Verde  </option>
<option value='Ouroeste' <?if($nome_cidade =='Ouroeste'){echo'selected';}?> />Ouroeste </option>
<option value='Pacaembu' <?if($nome_cidade =='Pacaembu'){echo'selected';}?> />Pacaembu </option>
<option value='Palestina' <?if($nome_cidade =='Palestina'){echo'selected';}?> />Palestina</option>
<option value='Palmares Paulista' <?if($nome_cidade =='Palmares Paulista'){echo'selected';}?> />Palmares Paulista </option>
<option value='Palmital' <?if($nome_cidade =='Palmital'){echo'selected';}?> />Palmital </option>
<option value='Panorama' <?if($nome_cidade =='Panorama'){echo'selected';}?> />Panorama </option>
<option value='Paraguaçu Paulista' <?if($nome_cidade =='Paraguaçu Paulista'){echo'selected';}?> />Paraguaçu Paulista</option>
<option value='Paraibuna' <?if($nome_cidade =='Paraibuna'){echo'selected';}?> />Paraibuna</option>
<option value='Paraíso' <?if($nome_cidade =='Paraíso'){echo'selected';}?> />Paraíso  </option>
<option value='Paranapanema' <?if($nome_cidade =='Paranapanema'){echo'selected';}?> />Paranapanema</option>
<option value='Parapuã' <?if($nome_cidade =='Parapuã'){echo'selected';}?> />Parapuã  </option>
<option value='Pardinho' <?if($nome_cidade =='Pardinho'){echo'selected';}?> />Pardinho </option>
<option value='Pariquera-Açu' <?if($nome_cidade =='Pariquera-Açu'){echo'selected';}?> />Pariquera-Açu  </option>
<option value='Parisi' <?if($nome_cidade =='Parisi'){echo'selected';}?> />Parisi</option>
<option value='Paruru' <?if($nome_cidade =='Paruru'){echo'selected';}?> />Paruru</option>
<option value='Patrocínio Paulista' <?if($nome_cidade =='Patrocínio Paulista'){echo'selected';}?> />Patrocínio Paulista  </option>
<option value='Paulicéia' <?if($nome_cidade =='Paulicéia'){echo'selected';}?> />Paulicéia</option>
<option value='Paulínia' <?if($nome_cidade =='Paulínia'){echo'selected';}?> />Paulínia </option>
<option value='Paulistânia' <?if($nome_cidade =='Paulistânia'){echo'selected';}?> />Paulistânia </option>
<option value='Pederneiras' <?if($nome_cidade =='Pederneiras'){echo'selected';}?> />Pederneiras </option>
<option value='Pedra Bela' <?if($nome_cidade =='Pedra Bela'){echo'selected';}?> />Pedra Bela  </option>
<option value='Pedregulho' <?if($nome_cidade =='Pedregulho'){echo'selected';}?> />Pedregulho  </option>
<option value='Pedreira' <?if($nome_cidade =='Pedreira'){echo'selected';}?> />Pedreira </option>
<option value='Pedrinhas Paulista' <?if($nome_cidade =='Pedrinhas Paulista'){echo'selected';}?> />Pedrinhas Paulista</option>
<option value='Pedro Barros' <?if($nome_cidade =='Pedro Barros'){echo'selected';}?> />Pedro Barros</option>
<option value='Pedro de Toledo' <?if($nome_cidade =='Pedro de Toledo'){echo'selected';}?> />Pedro de Toledo</option>
<option value='Penápolis' <?if($nome_cidade =='Penápolis'){echo'selected';}?> />Penápolis</option>
<option value='Pereira Barreto' <?if($nome_cidade =='Pereira Barreto'){echo'selected';}?> />Pereira Barreto</option>
<option value='Pereiras' <?if($nome_cidade =='Pereiras'){echo'selected';}?> />Pereiras </option>
<option value='Peruíbe' <?if($nome_cidade =='Peruíbe'){echo'selected';}?> />Peruíbe  </option>
<option value='Piacatu' <?if($nome_cidade =='Piacatu'){echo'selected';}?> />Piacatu  </option>
<option value='Piedade' <?if($nome_cidade =='Piedade'){echo'selected';}?> />Piedade  </option>
<option value='Pilar do Sul' <?if($nome_cidade =='Pilar do Sul'){echo'selected';}?> />Pilar do Sul</option>
<option value='Pindamonhangaba' <?if($nome_cidade =='Pindamonhangaba'){echo'selected';}?> />Pindamonhangaba</option>
<option value='Pindorama' <?if($nome_cidade =='Pindorama'){echo'selected';}?> />Pindorama</option>
<option value='Pinhalzinho' <?if($nome_cidade =='Pinhalzinho'){echo'selected';}?> />Pinhalzinho </option>
<option value='Piquerobi' <?if($nome_cidade =='Piquerobi'){echo'selected';}?> />Piquerobi</option>
<option value='Piquete' <?if($nome_cidade =='Piquete'){echo'selected';}?> />Piquete  </option>
<option value='Piracaia' <?if($nome_cidade =='Piracaia'){echo'selected';}?> />Piracaia </option>
<option value='Piracicaba' <?if($nome_cidade =='Piracicaba'){echo'selected';}?> />Piracicaba  </option>
<option value='Piraju' <?if($nome_cidade =='Piraju'){echo'selected';}?> />Piraju</option>
<option value='Pirajuí' <?if($nome_cidade =='Pirajuí'){echo'selected';}?> />Pirajuí  </option>
<option value='Pirangi' <?if($nome_cidade =='Pirangi'){echo'selected';}?> />Pirangi  </option>
<option value='Pirapora do Bom Jesus' <?if($nome_cidade =='Pirapora do Bom Jesus'){echo'selected';}?> />Pirapora do Bom Jesus</option>
<option value='Pirapozinho' <?if($nome_cidade =='Pirapozinho'){echo'selected';}?> />Pirapozinho </option>
<option value='Pirassununga' <?if($nome_cidade =='Pirassununga'){echo'selected';}?> />Pirassununga</option>
<option value='Piratininga' <?if($nome_cidade =='Piratininga'){echo'selected';}?> />Piratininga </option>
<option value='Pitangueiras' <?if($nome_cidade =='Pitangueiras'){echo'selected';}?> />Pitangueiras</option>
<option value='Planalto' <?if($nome_cidade =='Planalto'){echo'selected';}?> />Planalto </option>
<option value='Platina' <?if($nome_cidade =='Platina'){echo'selected';}?> />Platina  </option>
<option value='Poá' <?if($nome_cidade =='Poá'){echo'selected';}?> />Poá</option>
<option value='Polvilho' <?if($nome_cidade =='Polvilho'){echo'selected';}?> />Polvilho </option>
<option value='Pompéia' <?if($nome_cidade =='Pompéia'){echo'selected';}?> />Pompéia  </option>
<option value='Pontal' <?if($nome_cidade =='Pontal'){echo'selected';}?> />Pontal</option>
<option value='Pontalinda' <?if($nome_cidade =='Pontalinda'){echo'selected';}?> />Pontalinda  </option>
<option value='Porangaba' <?if($nome_cidade =='Porangaba'){echo'selected';}?> />Porangaba</option>
<option value='Porto Feliz' <?if($nome_cidade =='Porto Feliz'){echo'selected';}?> />Porto Feliz </option>
<option value='Porto Ferreira' <?if($nome_cidade =='Porto Ferreira'){echo'selected';}?> />Porto Ferreira </option>
<option value='Potim' <?if($nome_cidade =='Potim'){echo'selected';}?> />Potim </option>
<option value='Potirendaba' <?if($nome_cidade =='Potirendaba'){echo'selected';}?> />Potirendaba </option>
<option value='Pradópolis' <?if($nome_cidade =='Pradópolis'){echo'selected';}?> />Pradópolis  </option>
<option value='Praia Grande' <?if($nome_cidade =='Praia Grande'){echo'selected';}?> />Praia Grande</option>
<option value='Presidente Alves' <?if($nome_cidade =='Presidente Alves'){echo'selected';}?> />Presidente Alves  </option>
<option value='Presidente Bernardes' <?if($nome_cidade =='Presidente Bernardes'){echo'selected';}?> />Presidente Bernardes </option>
<option value='Presidente Epitácio' <?if($nome_cidade =='Presidente Epitácio'){echo'selected';}?> />Presidente Epitácio  </option>
<option value='Presidente Prudente' <?if($nome_cidade =='Presidente Prudente'){echo'selected';}?> />Presidente Prudente  </option>
<option value='Presidente Venceslau' <?if($nome_cidade =='Presidente Venceslau'){echo'selected';}?> />Presidente Venceslau </option>
<option value='Primavera' <?if($nome_cidade =='Primavera'){echo'selected';}?> />Primavera</option>
<option value='Promissão' <?if($nome_cidade =='Promissão'){echo'selected';}?> />Promissão</option>
<option value='Quadra' <?if($nome_cidade =='Quadra'){echo'selected';}?> />Quadra</option>
<option value='Quatá' <?if($nome_cidade =='Quatá'){echo'selected';}?> />Quatá </option>
<option value='Queluz' <?if($nome_cidade =='Queluz'){echo'selected';}?> />Queluz</option>
<option value='Quintana' <?if($nome_cidade =='Quintana'){echo'selected';}?> />Quintana </option>
<option value='Rafard' <?if($nome_cidade =='Rafard'){echo'selected';}?> />Rafard</option>
<option value='Rancharia' <?if($nome_cidade =='Rancharia'){echo'selected';}?> />Rancharia</option>
<option value='Redenção da Serra' <?if($nome_cidade =='Redenção da Serra'){echo'selected';}?> />Redenção da Serra </option>
<option value='Regente Feijó' <?if($nome_cidade =='Regente Feijó'){echo'selected';}?> />Regente Feijó  </option>
<option value='Reginópolis' <?if($nome_cidade =='Reginópolis'){echo'selected';}?> />Reginópolis </option>
<option value='Registro' <?if($nome_cidade =='Registro'){echo'selected';}?> />Registro </option>
<option value='Ribeir&#227;o Preto' <?if($nome_cidade =='Ribeir&#227;o Preto'){echo'selected';}?> />Ribeir&#227;o Preto  </option>
<option value='Ribeirão Bonito' <?if($nome_cidade =='Ribeirão Bonito'){echo'selected';}?> />Ribeirão Bonito</option>
<option value='Ribeirão Branco' <?if($nome_cidade =='Ribeirão Branco'){echo'selected';}?> />Ribeirão Branco</option>
<option value='Ribeirão Pires' <?if($nome_cidade =='Ribeirão Pires'){echo'selected';}?> />Ribeirão Pires </option>
<option value='Ribeirão Preto' <?if($nome_cidade =='Ribeirão Preto'){echo'selected';}?> />Ribeirão Preto </option>
<option value='Rincão' <?if($nome_cidade =='Rincão'){echo'selected';}?> />Rincão</option>
<option value='Rinópolis' <?if($nome_cidade =='Rinópolis'){echo'selected';}?> />Rinópolis</option>
<option value='Rio Claro' <?if($nome_cidade =='Rio Claro'){echo'selected';}?> />Rio Claro</option>
<option value='Rio das Pedras' <?if($nome_cidade =='Rio das Pedras'){echo'selected';}?> />Rio das Pedras </option>
<option value='Rio Grande da Serra' <?if($nome_cidade =='Rio Grande da Serra'){echo'selected';}?> />Rio Grande da Serra  </option>
<option value='Riolândia' <?if($nome_cidade =='Riolândia'){echo'selected';}?> />Riolândia</option>
<option value='Riversul' <?if($nome_cidade =='Riversul'){echo'selected';}?> />Riversul </option>
<option value='Rosana' <?if($nome_cidade =='Rosana'){echo'selected';}?> />Rosana</option>
<option value='Roseira' <?if($nome_cidade =='Roseira'){echo'selected';}?> />Roseira  </option>
<option value='Rubiácea' <?if($nome_cidade =='Rubiácea'){echo'selected';}?> />Rubiácea </option>
<option value='Rubião Júnior' <?if($nome_cidade =='Rubião Júnior'){echo'selected';}?> />Rubião Júnior  </option>
<option value='Rubinéia' <?if($nome_cidade =='Rubinéia'){echo'selected';}?> />Rubinéia </option>
<option value='S&#227;o Bernardo do Campo ion>' <?if($nome_cidade =='S&#227;o Bernardo do Campo ion>'){echo'selected';}?> />S&#227;o Bernardo do Campo ion></option>
<option value='S&#227;o Paulo' <?if($nome_cidade =='S&#227;o Paulo'){echo'selected';}?> />S&#227;o Paulo </option>
<option value='Sales' <?if($nome_cidade =='Sales'){echo'selected';}?> />Sales </option>
<option value='Sales Oliveira' <?if($nome_cidade =='Sales Oliveira'){echo'selected';}?> />Sales Oliveira </option>
<option value='Salesópolis' <?if($nome_cidade =='Salesópolis'){echo'selected';}?> />Salesópolis </option>
<option value='Saltinho' <?if($nome_cidade =='Saltinho'){echo'selected';}?> />Saltinho </option>
<option value='Salto' <?if($nome_cidade =='Salto'){echo'selected';}?> />Salto </option>
<option value='Salto de Pirapora' <?if($nome_cidade =='Salto de Pirapora'){echo'selected';}?> />Salto de Pirapora </option>
<option value='Salto Grande' <?if($nome_cidade =='Salto Grande'){echo'selected';}?> />Salto Grande</option>
<option value='Sandovalina' <?if($nome_cidade =='Sandovalina'){echo'selected';}?> />Sandovalina </option>
<option value='Santa Adélia' <?if($nome_cidade =='Santa Adélia'){echo'selected';}?> />Santa Adélia</option>
<option value='Santa Albertina' <?if($nome_cidade =='Santa Albertina'){echo'selected';}?> />Santa Albertina</option>
<option value='Santa Bárbara D Oeste' <?if($nome_cidade =='Santa Bárbara D Oeste'){echo'selected';}?> />Santa Bárbara D Oeste</option>
<option value='Santa Branca' <?if($nome_cidade =='Santa Branca'){echo'selected';}?> />Santa Branca</option>
<option value='Santa Cruz da Conceição' <?if($nome_cidade =='Santa Cruz da Conceição'){echo'selected';}?> />Santa Cruz da Conceição </option>
<option value='Santa Cruz da Esperança' <?if($nome_cidade =='Santa Cruz da Esperança'){echo'selected';}?> />Santa Cruz da Esperança </option>
<option value='Santa Cruz das Palmeiras' <?if($nome_cidade =='Santa Cruz das Palmeiras'){echo'selected';}?> />Santa Cruz das Palmeiras</option>
<option value='Santa Cruz do Rio Pardo' <?if($nome_cidade =='Santa Cruz do Rio Pardo'){echo'selected';}?> />Santa Cruz do Rio Pardo </option>
<option value='Santa Ernestina' <?if($nome_cidade =='Santa Ernestina'){echo'selected';}?> />Santa Ernestina</option>
<option value='Santa Fé do Sul' <?if($nome_cidade =='Santa Fé do Sul'){echo'selected';}?> />Santa Fé do Sul</option>
<option value='Santa Gertrudes' <?if($nome_cidade =='Santa Gertrudes'){echo'selected';}?> />Santa Gertrudes</option>
<option value='Santa Isabel' <?if($nome_cidade =='Santa Isabel'){echo'selected';}?> />Santa Isabel</option>
<option value='Santa Lúcia' <?if($nome_cidade =='Santa Lúcia'){echo'selected';}?> />Santa Lúcia </option>
<option value='Santa Maria da Serra' <?if($nome_cidade =='Santa Maria da Serra'){echo'selected';}?> />Santa Maria da Serra </option>
<option value='Santa Mercedes' <?if($nome_cidade =='Santa Mercedes'){echo'selected';}?> />Santa Mercedes </option>
<option value='Santa Rita do Passa Quatro ion>' <?if($nome_cidade =='Santa Rita do Passa Quatro ion>'){echo'selected';}?> />Santa Rita do Passa Quatro ion></option>
<option value='Santa Rosa de Viterbo' <?if($nome_cidade =='Santa Rosa de Viterbo'){echo'selected';}?> />Santa Rosa de Viterbo</option>
<option value='Santana de Parnaíba' <?if($nome_cidade =='Santana de Parnaíba'){echo'selected';}?> />Santana de Parnaíba  </option>
<option value='Santo Anastácio' <?if($nome_cidade =='Santo Anastácio'){echo'selected';}?> />Santo Anastácio</option>
<option value='Santo André' <?if($nome_cidade =='Santo André'){echo'selected';}?> />Santo André </option>
<option value='Santo Antônio de Posse' <?if($nome_cidade =='Santo Antônio de Posse'){echo'selected';}?> />Santo Antônio de Posse  </option>
<option value='Santo Antônio do Aracanguá ion>' <?if($nome_cidade =='Santo Antônio do Aracanguá ion>'){echo'selected';}?> />Santo Antônio do Aracanguá ion></option>
<option value='Santo Antônio do Jardim' <?if($nome_cidade =='Santo Antônio do Jardim'){echo'selected';}?> />Santo Antônio do Jardim </option>
<option value='Santo Antônio do Pinhal' <?if($nome_cidade =='Santo Antônio do Pinhal'){echo'selected';}?> />Santo Antônio do Pinhal </option>
<option value='Santo Expedito' <?if($nome_cidade =='Santo Expedito'){echo'selected';}?> />Santo Expedito </option>
<option value='Santópolis do Aguapeí' <?if($nome_cidade =='Santópolis do Aguapeí'){echo'selected';}?> />Santópolis do Aguapeí</option>
<option value='Santos' <?if($nome_cidade =='Santos'){echo'selected';}?> />Santos</option>
<option value='São Bento do Sapucaí' <?if($nome_cidade =='São Bento do Sapucaí'){echo'selected';}?> />São Bento do Sapucaí </option>
<option value='São Bernardo do Campo' <?if($nome_cidade == 'São Bernardo do Campo'){echo'selected';}?> />São Bernardo do Campo</option>
<option value='São Caetano do Sul' <?if($nome_cidade =='São Caetano do Sul'){echo'selected';}?> />São Caetano do Sul</option>
<option value='São Carlos' <?if($nome_cidade =='São Carlos'){echo'selected';}?> />São Carlos  </option>
<option value='São Francisco' <?if($nome_cidade =='São Francisco'){echo'selected';}?> />São Francisco  </option>
<option value='São Francisco Xavier' <?if($nome_cidade =='São Francisco Xavier'){echo'selected';}?> />São Francisco Xavier </option>
<option value='São João da Boa Vista' <?if($nome_cidade =='São João da Boa Vista'){echo'selected';}?> />São João da Boa Vista</option>
<option value='São João Novo' <?if($nome_cidade =='São João Novo'){echo'selected';}?> />São João Novo  </option>
<option value='São Joaquim da Barra' <?if($nome_cidade =='São Joaquim da Barra'){echo'selected';}?> />São Joaquim da Barra </option>
<option value='São José da Bela Vista' <?if($nome_cidade =='São José da Bela Vista'){echo'selected';}?> />São José da Bela Vista  </option>
<option value='São José do Barreiro' <?if($nome_cidade =='São José do Barreiro'){echo'selected';}?> />São José do Barreiro </option>
<option value='São José do Rio Pardo' <?if($nome_cidade =='São José do Rio Pardo'){echo'selected';}?> />São José do Rio Pardo</option>
<option value='São José do Rio Preto' <?if($nome_cidade =='São José do Rio Preto'){echo'selected';}?> />São José do Rio Preto</option>
<option value='São José dos Campos' <?if($nome_cidade =='São José dos Campos'){echo'selected';}?> />São José dos Campos  </option>
<option value='São Lourenço da Serra' <?if($nome_cidade =='São Lourenço da Serra'){echo'selected';}?> />São Lourenço da Serra</option>
<option value='São Luiz do Paraitinga' <?if($nome_cidade =='São Luiz do Paraitinga'){echo'selected';}?> />São Luiz do Paraitinga  </option>
<option value='São Manuel' <?if($nome_cidade =='São Manuel'){echo'selected';}?> />São Manuel  </option>
<option value='São Miguel Arcanjo' <?if($nome_cidade =='São Miguel Arcanjo'){echo'selected';}?> />São Miguel Arcanjo</option>
<option value='São Paulo' <?if($nome_cidade =='São Paulo'){echo'selected';}?> />São Paulo</option>
<option value='São Pedro' <?if($nome_cidade =='São Pedro'){echo'selected';}?> />São Pedro</option>
<option value='São Pedro do Turvo' <?if($nome_cidade =='São Pedro do Turvo'){echo'selected';}?> />São Pedro do Turvo</option>
<option value='São Roque' <?if($nome_cidade =='São Roque'){echo'selected';}?> />São Roque</option>
<option value='São Sebastião' <?if($nome_cidade =='São Sebastião'){echo'selected';}?> />São Sebastião  </option>
<option value='São Sebastião da Grama' <?if($nome_cidade =='São Sebastião da Grama'){echo'selected';}?> />São Sebastião da Grama  </option>
<option value='São Simão' <?if($nome_cidade =='São Simão'){echo'selected';}?> />São Simão</option>
<option value='São Vicente' <?if($nome_cidade =='São Vicente'){echo'selected';}?> />São Vicente </option>
<option value='Sarapuí' <?if($nome_cidade =='Sarapuí'){echo'selected';}?> />Sarapuí  </option>
<option value='Sebastianópolis do Sul' <?if($nome_cidade =='Sebastianópolis do Sul'){echo'selected';}?> />Sebastianópolis do Sul  </option>
<option value='Serra Azul' <?if($nome_cidade =='Serra Azul'){echo'selected';}?> />Serra Azul  </option>
<option value='Serra Negra' <?if($nome_cidade =='Serra Negra'){echo'selected';}?> />Serra Negra </option>
<option value='Serrana' <?if($nome_cidade =='Serrana'){echo'selected';}?> />Serrana  </option>
<option value='Sertãozinho' <?if($nome_cidade =='Sertãozinho'){echo'selected';}?> />Sertãozinho </option>
<option value='Sete Barras' <?if($nome_cidade =='Sete Barras'){echo'selected';}?> />Sete Barras </option>
<option value='Severínia' <?if($nome_cidade =='Severínia'){echo'selected';}?> />Severínia</option>
<option value='Silveiras' <?if($nome_cidade =='Silveiras'){echo'selected';}?> />Silveiras</option>
<option value='Socorro' <?if($nome_cidade =='Socorro'){echo'selected';}?> />Socorro  </option>
<option value='Sorocaba' <?if($nome_cidade =='Sorocaba'){echo'selected';}?> />Sorocaba </option>
<option value='Sud Mennucci' <?if($nome_cidade =='Sud Mennucci'){echo'selected';}?> />Sud Mennucci</option>
<option value='Sumaré' <?if($nome_cidade =='Sumaré'){echo'selected';}?> />Sumaré</option>
<option value='Suzanápolis' <?if($nome_cidade =='Suzanápolis'){echo'selected';}?> />Suzanápolis </option>
<option value='Suzano' <?if($nome_cidade =='Suzano'){echo'selected';}?> />Suzano</option>
<option value='Tabapuã' <?if($nome_cidade =='Tabapuã'){echo'selected';}?> />Tabapuã  </option>
<option value='Tabatinga' <?if($nome_cidade =='Tabatinga'){echo'selected';}?> />Tabatinga</option>
<option value='Taboão da Serra' <?if($nome_cidade =='Taboão da Serra'){echo'selected';}?> />Taboão da Serra</option>
<option value='Taciba' <?if($nome_cidade =='Taciba'){echo'selected';}?> />Taciba</option>
<option value='Taguaí' <?if($nome_cidade =='Taguaí'){echo'selected';}?> />Taguaí</option>
<option value='Tambaú' <?if($nome_cidade =='Tambaú'){echo'selected';}?> />Tambaú</option>
<option value='Tanabi' <?if($nome_cidade =='Tanabi'){echo'selected';}?> />Tanabi</option>
<option value='Tapiratiba' <?if($nome_cidade =='Tapiratiba'){echo'selected';}?> />Tapiratiba  </option>
<option value='Taquaral' <?if($nome_cidade =='Taquaral'){echo'selected';}?> />Taquaral </option>
<option value='Taquaritinga' <?if($nome_cidade =='Taquaritinga'){echo'selected';}?> />Taquaritinga</option>
<option value='Taquarituba' <?if($nome_cidade =='Taquarituba'){echo'selected';}?> />Taquarituba </option>
<option value='Taquarivaí' <?if($nome_cidade =='Taquarivaí'){echo'selected';}?> />Taquarivaí  </option>
<option value='Tarabai' <?if($nome_cidade =='Tarabai'){echo'selected';}?> />Tarabai  </option>
<option value='Tarumã' <?if($nome_cidade =='Tarumã'){echo'selected';}?> />Tarumã</option>
<option value='Tatu&#237;' <?if($nome_cidade =='Tatu&#237;'){echo'selected';}?> />Tatu&#237;  </option>
<option value='Tatuí' <?if($nome_cidade =='Tatuí'){echo'selected';}?> />Tatuí </option>
<option value='Taubaté' <?if($nome_cidade =='Taubaté'){echo'selected';}?> />Taubaté  </option>
<option value='Teodoro Sampaio' <?if($nome_cidade =='Teodoro Sampaio'){echo'selected';}?> />Teodoro Sampaio</option>
<option value='Terra Roxa' <?if($nome_cidade =='Terra Roxa'){echo'selected';}?> />Terra Roxa  </option>
<option value='Tietê' <?if($nome_cidade =='Tietê'){echo'selected';}?> />Tietê </option>
<option value='Timburi' <?if($nome_cidade =='Timburi'){echo'selected';}?> />Timburi  </option>
<option value='Torre de Pedra' <?if($nome_cidade =='Torre de Pedra'){echo'selected';}?> />Torre de Pedra </option>
<option value='Torrinha' <?if($nome_cidade =='Torrinha'){echo'selected';}?> />Torrinha </option>
<option value='Tremembé' <?if($nome_cidade =='Tremembé'){echo'selected';}?> />Tremembé </option>
<option value='Três Fronteiras' <?if($nome_cidade =='Três Fronteiras'){echo'selected';}?> />Três Fronteiras</option>
<option value='Tuiuti' <?if($nome_cidade =='Tuiuti'){echo'selected';}?> />Tuiuti</option>
<option value='Tupã' <?if($nome_cidade =='Tupã'){echo'selected';}?> />Tupã  </option>
<option value='Tupi Paulista' <?if($nome_cidade =='Tupi Paulista'){echo'selected';}?> />Tupi Paulista  </option>
<option value='Turmalina' <?if($nome_cidade =='Turmalina'){echo'selected';}?> />Turmalina</option>
<option value='Ubatuba' <?if($nome_cidade =='Ubatuba'){echo'selected';}?> />Ubatuba  </option>
<option value='Uchoa' <?if($nome_cidade =='Uchoa'){echo'selected';}?> />Uchoa </option>
<option value='União Paulista' <?if($nome_cidade =='União Paulista'){echo'selected';}?> />União Paulista </option>
<option value='Urânia' <?if($nome_cidade =='Urânia'){echo'selected';}?> />Urânia</option>
<option value='Urupês' <?if($nome_cidade =='Urupês'){echo'selected';}?> />Urupês</option>
<option value='Valentim Gentil' <?if($nome_cidade =='Valentim Gentil'){echo'selected';}?> />Valentim Gentil</option>
<option value='Valinhos' <?if($nome_cidade =='Valinhos'){echo'selected';}?> />Valinhos </option>
<option value='Valparaíso' <?if($nome_cidade =='Valparaíso'){echo'selected';}?> />Valparaíso  </option>
<option value='Vargem' <?if($nome_cidade =='Vargem'){echo'selected';}?> />Vargem</option>
<option value='Vargem Grande do Sul' <?if($nome_cidade =='Vargem Grande do Sul'){echo'selected';}?> />Vargem Grande do Sul </option>
<option value='Vargem Grande Paulista' <?if($nome_cidade =='Vargem Grande Paulista'){echo'selected';}?> />Vargem Grande Paulista  </option>
<option value='Várzea Paulista' <?if($nome_cidade =='Várzea Paulista'){echo'selected';}?> />Várzea Paulista</option>
<option value='Vera Cruz' <?if($nome_cidade =='Vera Cruz'){echo'selected';}?> />Vera Cruz</option>
<option value='Vinhedo' <?if($nome_cidade =='Vinhedo'){echo'selected';}?> />Vinhedo  </option>
<option value='Viradouro' <?if($nome_cidade =='Viradouro'){echo'selected';}?> />Viradouro</option>
<option value='Vista Alegre do Alto' <?if($nome_cidade =='Vista Alegre do Alto'){echo'selected';}?> />Vista Alegre do Alto </option>
<option value='Votorantim' <?if($nome_cidade =='Votorantim'){echo'selected';}?> />Votorantim</option>
<option value='Votuporanga' <?if($nome_cidade =='Votuporanga'){echo'selected';}?> />Votuporanga </option>
</select>
<?
}
?>

<?
class extras{
	function checkbox($sql, $nome, $default = null, $outros = null){
		$checked = explode("|",$default);

		$result = mysql_query($sql) or die (mysql_error());

		while($row = mysql_fetch_array($result)){
			if (array_search($row[0],$checked)){?>
			<input type="checkbox" name="<?=$nome;?>[]" value="<?=$row[0];?>" checked><?=$row[1];?><br>
<?			}else{ ?>
			<input type="checkbox" name="<?=$nome;?>[]" value="<?=$row[0];?>"><?=$row[1];?><br>
<?			}
		}
		mysql_free_result($result);
		if($outros){ ?>
			<input type="checkbox" name="<?=$nome;?>[]" value="x" <?=(array_search("x", $checked)?"checked":'');?>><?=$outros;?><input type="text" name="<?=$nome;?>[]" size="35" value="<?=(array_search("x", $checked)?array_pop($checked):'');?>">;
<?		}
	}
	function checkbox2($sql, $nome, $default = null, $extra = null){
		$checked = explode("|",$default);

		$result = mysql_query($sql) or die (mysql_error());

		while($row = mysql_fetch_array($result)){
			if (array_search($row[0],$checked) || $checked == "all"){?>
			<input type="checkbox" name="<?=$nome;?>[]" value="<?=$row[0];?>" checked><?=$row[1];?><br>
<?			}else{ ?>
			<input type="checkbox" name="<?=$nome;?>[]" value="<?=$row[0];?>"><?=$row[1];?><br>
<?			}
		}
		mysql_free_result($result);
		foreach($extra as $text => $value){ ?>
			<input type="checkbox" name="<?=$nome;?>[]" value="<?=$value;?>" <?=(array_search($value, $checked)||$checked == "all"?"checked":'');?>><?=$text;?>
<?		}
	}
	function radiobutton($sql, $nome, $default = null){
		$result = mysql_query($sql) or die (mysql_error());

		while($row = mysql_fetch_array($result)){
			if ($row[0]==$default){?>
			<input type="radio" name="<?=$nome;?>" value="<?=$row[0];?>" checked><?=$row[1];?><br>
<?			}else{ ?>
			<input type="radio" name="<?=$nome;?>" value="<?=$row[0];?>"><?=$row[1];?><br>
<?			}
		}
		mysql_free_result($result);
	}
}
?>
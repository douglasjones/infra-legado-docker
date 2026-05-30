<?
include_once "libs/maininclude.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type: text/html; charset=ISO-8859-1" />
</head>	
<?
 $sql = "Select 
			l.cnpj_cpf
			,l.razaosocial
			,l.cidade
			,l.ddd
			,l.tel
			,l.dddfax
			,l.fax	
			,cl.ddd_fone		
			,cl.Fone	
			,cl.DDD_Cel
			,cl.Cel
			,cl1.ddd_fone	c_dddfone	
			,cl1.Fone	  c_fone
			,cl1.DDD_Cel c_dddcel
			,cl1.Cel c_cel
			,cl.NomeContato
			,cl.email
			,l.DS
			,l.qtde_linhas
			,l.codlead
			,l.ativacao
		from leads l
		left join contatoslead cl on l.codlead = cl.CodLead 
    left join contatoslead cl1 on l.codlead = cl1.CodLead 
		where l.mailing='MAILING_ TIM'
    and cl.CodContatoLead <> cl1.CodContatoLead
		group by l.cnpj_cpf";

	$result = mysql_query($sql);
	$v= 1;
	while($row = mysql_fetch_array($result)){
		 
		 $q_cnpj =  strlen(trim(str_replace("-", "",str_replace("/", "",str_replace(".", "",$row['cnpj_cpf'])))));
		 $q_razao =  strlen(trim($row['razaosocial']));
		 $q_cidade =  strlen(trim($row['cidade']));
		 $q_tel =  strlen(trim(str_replace("-", "",($row['ddd'].$row['tel']))));
		 $q_fone =  strlen(trim(str_replace("-", "",($row['ddd_fone'].$row['Fone']))));	
		 $q_fax =  strlen(trim(str_replace("-", "",($row['dddfax'].$row['fax']))));	
		 $q_c_cel =  strlen(trim(str_replace("-", "",($row['DDD_Cel'].$row['Cel']))));	 
		 $q_fone1 =  strlen(trim(str_replace("-", "",($row['c_dddfone'].$row['c_fone']))));	
		 $q_c_cel1 =  strlen(trim(str_replace("-", "",($row['c_dddcel'].$row['c_cel']))));	 		 
		 //$q_fax =  strlen(trim(str_replace("-", "",$row['fax'])));
		 $q_responsavel =  strlen(trim($row['NomeContato']));
		 $q_email =  strlen(trim($row['email']));
		 $q_dt =  strlen(trim($row['ativacao']));
		 $q_url =  strlen(rtrim("http://sistema.globaltelecomm.com.br/vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']));
		 $v_tel  = $row['ddd'].$row['tel'];
		 $v_fax  = $row['dddfax'].$row['fax'];	
		 $v_fone  = $row['ddd_fone'].$row['Fone'];
		 $v_cel = $row['DDD_Cel'].$row['Cel'];
		 $v_fone1  = $row['c_dddfone'].$row['c_fone'];
		 $v_cel1 = $row['c_dddcel'].$row['c_cel'];
	
		 //contador
		 
		 
		 $v_count =  str_pad($v, 10,"*", STR_PAD_RIGHT);
		 
		 
		 //cnpj
		 if($q_cnpj < 14){			 
			$cnpj =  str_pad(trim(str_replace("-", "",str_replace("/", "",str_replace(".", "",$row['cnpj_cpf'])))), 14,"*", STR_PAD_RIGHT);
		 }else{			
		   $cnpj = trim(str_replace("-", "",str_replace("/", "",str_replace(".", "",$row['cnpj_cpf']))));
		 }
		 //razaosocial
		 if($q_razao < 70){	
			$razaosocial =  str_pad(trim($row['razaosocial']),70,"*", STR_PAD_RIGHT);
		 }else{			
		    $razaosocial =  $row['razaosocial'];
		 }
		 
		 //cidade
		 if($q_cidade < 30){			 
			$cidade =  str_pad(rtrim($row['cidade']),30,"*", STR_PAD_RIGHT);
		 }else{			
		   $cidade = $row['cidade'];
		 }

		 //Tel
		 if($q_tel < 13){			 
			$tel =  str_pad(trim(str_replace("-", "",$v_tel)), 13,"*", STR_PAD_RIGHT);
		 }else{			
		   $tel =  trim(str_replace("-", "",$v_tel));
		 }
		 
		 //Tel2
		 if($q_fax < 13){			 
			$fax =  str_pad(trim(str_replace("-", "",$v_fax)), 13,"*", STR_PAD_RIGHT);
		 }else{			
		   $fax = trim(str_replace("-", "",$v_fax));
		 }
		 
		 //Tel1
		 if($q_fone < 13){			 
			$fone =  str_pad(trim(str_replace("-", "",$v_fone)), 13,"*", STR_PAD_RIGHT);
			
		 }else{		
			 
		    $fone = trim(str_replace("-", "",$v_fone));
		 } 
		 
		 //Cel Contato
		 if($q_c_cel < 13){			 
			$cel =  str_pad(trim(str_replace("-", "",$v_cel)), 13,"*", STR_PAD_RIGHT);
		 }else{			
		   $cel = trim(str_replace("-", "",$$v_cel));
		 } 
		 
		 //Tel2
		 if($q_fone1 < 13){			 
			$fone1 =  str_pad(trim(str_replace("-", "",$v_fone1)), 13,"*", STR_PAD_RIGHT);
		 }else{			
		   $fone1 = trim(str_replace("-", "",$v_fone1));
		 } 
		 
		 //Cel Contato 2
		 if($q_c_cel1 < 13){			 
			$cel1 =  str_pad(trim(str_replace("-", "",$v_cel1)), 13,"*", STR_PAD_RIGHT);
		 }else{			
		   $cel1 = trim(str_replace("-", "",$$v_cel1));
		 } 
		 
		 
		 
		 //Responsável
		 if($q_responsavel < 70){			 
			$responsavel =  str_pad(rtrim($row['NomeContato']), 70,"*", STR_PAD_RIGHT);
		 }else{			
		   $responsavel = $row['NomeContato'];
		 } 
		 
		//Email
		 if($q_email < 70){			 
			$email =  str_pad(rtrim($row['email']), 70,"*", STR_PAD_RIGHT);
		 }else{			
		   $eamil = $row['email'];
		 } 
		 
		 //Data Ativacao
		 if($q_dt < 20){			 
			$dt =  str_pad(rtrim($row['DS']), 20,"*", STR_PAD_RIGHT);
		 }else{			
		   $dt = $row['DS'];
		 } 
		 
		  //Qtde Linhas
		 if($q_linhas < 10){			 
			$linhas =  str_pad(rtrim($row['qtde_linhas']), 10,"*", STR_PAD_RIGHT);
		 }else{			
		   $linhas = $row['qtde_linhas'];
		 } 
		 
		  //url
		 if($q_url < 150){			 
			$url =  str_pad(rtrim("http://sistema.globaltelecomm.com.br/vendas/leads/disc.php?codlead=".$row['codlead']), 150,"*", STR_PAD_RIGHT);
		 }else{			
		   $url = rtrim("http://sistema.globaltelecomm.com.br/vendas/leads/disc.php?codlead=".$row['codlead']);
		 } 

		 
		 echo $v_count.$cnpj.$razaosocial.$cidade.$tel.$fax.$fone.$cel.$fone1.$cel1.$responsavel.$email.$dt.$linhas.$url."BR<br>";
		 $v ++;

	}
	mysql_free_result($result);			
?>
</thml>

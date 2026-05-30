<?
$excel = $_REQUEST['excel'];
if($excel == "S"){
	$arquivo = 'planilha.xls';
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.equipes.php";
include_once "../../libs/cla.relefetivagd.php";


$dataagde = $_REQUEST['dataagde'];
$dataagate = $_REQUEST['dataagate']; 
function porcentagem( $Ipercent , $total )
{
	return  $Ipercent . "( "  . @number_format( ( $Ipercent  * 100 / $total  ) , 2 , ',' , '.' ) . "%)" ;
}
//PARAMTROS DE PESQUISA
$cod_polo = $_REQUEST['cod_polo'];
$tipo = $_REQUEST['tipo'];
error_reporting( E_ALL ) ;

	$codpolo	= ( @$_REQUEST['cod_polo'		    ] ? $_REQUEST['cod_polo'		   ] : null ) ;
	$codgrupo	= ( @$_REQUEST['grupousuariointerno'] ? $_REQUEST['grupousuariointerno'] : null ) ;
	$dataagde	= ( @$_REQUEST['dataagde'		    ] ? $_REQUEST['dataagde'		   ] : null ) ;
	$dataagate	= ( @$_REQUEST['dataagate'		    ] ? $_REQUEST['dataagate'		   ] : null ) ;

	if ( $dataagde )
	{
		$dataagde	= explode( '/' , $dataagde ) ;
		$dataagde	= strtotime( $dataagde[1] . '/' . $dataagde[0] . '/' . $dataagde[2] ) ;
	}
	if ( $dataagate )
	{
		$dataagate	= explode( '/' , $dataagate ) ;
		$dataagate	= strtotime( $dataagate[1] . '/' . $dataagate[0] . '/' . $dataagate[2] ) ;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
<?
if($excel != "S"){
?>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<script src="../../extras/tabela.js"></script>
<?
}
?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>
<?
}
?>
<br>
<table cellspacing="0" cellpadding="0" align="left" border="0">	
    <tr>
    	<td class="form" align="center">
    		<font size="+2">Efetividade de Agendamento</font>
    	</td>
    </tr>
</table>
<br>
<br>
<table width="50%" border="0" cellpadding="0" cellspacing="0" class='form'>
	<tr>
    	<td class="parametros">
			Parâmetros 
		</td>
	</tr>
	<tr>
		<td class="parametros">
				Relatório gerado em 
				<?
				//Pega a data de geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
				mysql_free_result($rs_geracao);
				?>				
		</td>
	</tr>
    <tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['cod_polo'])){
			$sql = "Select 
    				p.cod_polo
					,p.n_polo
					 from polo p";
			$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
			$sql .= " Order By p.n_polo ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>
    <tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['grupousuariointerno'])){
			$sql = "SELECT 
                    Nome grupo,
                    CodGrupoUsuarioInterno codgrupo
                FROM gruposusuariosinternos o
                where o.CodGrupoUsuarioInterno= ".$_REQUEST['grupousuariointerno'];
			$q = mysql_query($sql);
			$grupo = mysql_fetch_array($q);
			echo "Grupo: ".$grupo['grupo'];
		}
		?>
		</td>
	</tr>    
    <tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['grupousuariointerno'])){
			$sql = "SELECT 
                    Nome grupo,
                    CodGrupoUsuarioInterno codgrupo
                FROM gruposusuariosinternos o
                where o.CodGrupoUsuarioInterno= ".$_REQUEST['grupousuariointerno'];
			$q = mysql_query($sql);
			$grupo = mysql_fetch_array($q);
			echo "Grupo: ".$grupo['grupo'];
		}
		?>
		</td>
	</tr>  
	<?	
	if(!empty($dataagde)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas Agendamento:&nbsp;<?=$_REQUEST['dataagde'];?> até <?=$_REQUEST['dataagate'];?></dt>
		</td>
	</tr>
	<?	
	}
	?> 
    <tr>
		<td class="parametros">
		<?	
		if($_REQUEST['tipo']=='analit'){
			echo "Tipo: Analítico";
		}else{
		    echo "Tipo: Sintético";
		}
		?>
		</td>
	</tr>       		
 </table>   
<br>
<br>
<table  cellspacing="0" cellpadding="0" align="center" border="0" width="1500" class="sortable">
    <?	
        $vtot_prdutivo = 0 ; 
        $vtot_improdutivo = 0;
        $vtot_semclassificacao = 0;
        $vtot_si = 0; 
        $vtot_seminteresse = 0;
        $vtot_25 = 0; 
        $vtot_50 = 0;
        $vtot_75 = 0;
        $vtot_80 = 0;
        $vtot_90 = 0;
        $vtot_cliente = 0; 
        $vli = 0;   
        $sql = "SELECT 
                    Nome grupo,
                    CodGrupoUsuarioInterno codgrupo
                FROM gruposusuariosinternos 
                WHERE CodGrupoUsuarioInterno NOT IN (12, 16, 4 )";
    	if($codgrupo) $sql .= " AND CodGrupoUsuarioInterno = $codgrupo";

	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result)){		
		while($row = mysql_fetch_array($result)){            
            //echo "<thead>";
            echo    "<tr>";
            echo        "<td><font face='Arial'><em><b>Grupo: ".$row['grupo']."</b></em></font></td>";
            echo     "</tr>";            
            //echo "</thead>";
            
            if($tipo=='analit'){
                $sql = "SELECT 
                            g.CodUsuarioInterno codusr,
    					    u.Nome usuario 
    			        FROM gruposusuariosinternos_usuariosinternos g
    		                 INNER JOIN usuariosinternos u  ON g.CodUsuarioInterno = u.CodUsuarioInterno 
    			        WHERE CodGrupoUsuarioInterno = {$row['codgrupo']}" ;
                $usuario = mysql_query($sql) or die(mysql_error());  
                if(mysql_num_rows($usuario)){		
		          while($user = mysql_fetch_array($usuario)){
                  
                    echo "<tr>";
                    echo    "<td><font face='Arial'><em><b>Usuario:".$user['usuario']."</b></em></font></td>";
                    echo "</tr>";
                    
                 	$sql2 = "SELECT sa.Descricao status_ag ,
    						   sc.Descricao status_lead , 
    						   l.RazaoSocial Lead , 
    						   l.CodLead , 
    						   al.CodStatus codstatus_ag ,
    						   l.CodStatusClassificacaoLead codstatus_ld , 
    						   ta.Descricao tipo_ag
    					  FROM leads l
    				        INNER JOIN agendaslead al ON l.CodLead = al.CodLead
    				        LEFT JOIN statusagendamento sa ON sa.CodStatus = al.CodStatus
    				        LEFT JOIN tipoagendamento ta ON ta.CodTipo = al.CodTipo
    				        INNER JOIN statusclassificacaolead sc ON sc.CodStatusClassificacaoLead = l.CodStatusClassificacaoLead
    					 WHERE al.CodTipo IN (1, 4)
    					   AND ( al.CodStatus in ( 1 , 2 ) or al.CodStatus is null )
    					   AND ( ( al.CodUsuarioInterno = {$user['codusr']} and al.AgendadoPara is null ) or al.AgendadoPara = {$user['codusr']} )" ;
            			
                        if ( $codpolo != 100 && $codpolo != null ) 
            				$sql2 .= " AND ( l.cod_polo = {$codpolo} or l.cod_polo = 100 ) " ;
            				
            			if ( $dataagde && $dataagate )
            				$sql2 .= " AND al.DataCadastro between '" . date( "Y-m-d" , $dataagde ) . " 00:00:00' and '" . date( "Y-m-d" , $dataagate ) . " 23:59:59'" ;
            				
            			if( $dataagde )
            				$sql2 .= " AND al.DataCadastro > '" . date( "Y-m-d" , $dataagde ) . " 00:00:00'" ;
            				
            			if( $dataagate )
            				$sql2 .= " AND al.DataCadastro < '" . date( "Y-m-d" , $dataagate ) . " 23:59:59'" ;
            				
            			$sql2 .= " ORDER BY al.DataCadastro" ;
                    $agendamento = mysql_query($sql2) or die(mysql_error());
                        $tot_prdutivo = 0 ;                        
                        $tot_improdutivo = 0;
                        $tot_semclassificacao = 0;
                        $tot_si = 0; 
                        $tot_seminteresse = 0;
                        $tot_25 = 0; 
                        $tot_50 = 0;
                        $tot_75 = 0;
                        $tot_80 = 0;
                        $tot_90 = 0;
                        $tot_cliente = 0;                        
                        
                        if(mysql_num_rows($agendamento)){
                            echo  "<tr>";
                            echo  "<td>";
                            echo  "<table  cellspacing=0 cellpadding=0 align=center border=1 width='100%' class=sortable>";
                            echo  "<tr>";
                            echo  "<td class=titulo bgcolor=#8080FF width='5%'>#</td>";
                            echo  "<td class=titulo bgcolor=#8080FF>Lead</td>";
                            echo  "<td class=titulo bgcolor=#8080FF width='20%'>Status Agendamento</td>";
                            echo  "<td class=titulo bgcolor=#8080FF width='20%'>Status Lead</td>";
                            echo  "<td class=titulo bgcolor=#8080FF width='20%'>Tipo Agendamento</td>";                                                                    
                            echo  "</tr>";  

                            $li = 0 ;
                            while($age = mysql_fetch_array($agendamento)){
                                //TOTAL STATUS AGENDAMENTO
                                if ( $age['codstatus_ag'] == 1 )
		                          $tot_prdutivo ++ ;
                                elseif ( $age['codstatus_ag'] == 2 )
					              $tot_improdutivo ++ ;  
                  	            else
					               $tot_semclassificacao ++ ;                                  
                                if ( $age['codstatus_ld'] == 1 )
					               $tot_si ++ ; 
                                
                                if ( $age['codstatus_ld'] == 1 )
                                  $tot_seminteresse++ ;
                                elseif ( $age['codstatus_ld'] == 4 )
					              $tot_25 ++ ;  
                                elseif ( $age['codstatus_ld'] == 5 )
						          $tot_50 ++ ;   
                                elseif ( $age['codstatus_ld'] == 6 )
						          $tot_75 ++ ;     
                                elseif ( $age['codstatus_ld'] == 10 )
						          $tot_80 ++ ;
                                elseif ( $age['codstatus_ld'] == 12 )
						          $tot_90 ++ ;
                                elseif ( $age['codstatus_ld'] == 15 )
						          $tot_cliente++ ;  
                                  
                                      
                                $li ++;
                                echo  "<tr>";
                                echo  "<tr>";
                                echo "<td class='form' align='center' width='5%'>".$li."</td>";     
                                echo "<td class='form' align='center'>".$age['Lead']."</td>";
                                echo "<td class='form' align='center'>".$age['status_ag']."</td>";
                                echo "<td class='form' align='center'>".$age['status_lead']."</td>";
                                echo "<td class='form' align='center'>".$age['tipo_ag']."</td>";                                                                    
                                echo  "</tr>"; 
                                 
                            }     
                                echo "</table>";
                                echo "</td>";
                                echo "</tr>";                                                                            	
                           
                            echo  "<tr>";
                            
                            echo  "<td >&nbsp;</td>";                                                               
                            echo  "</tr>";
                            echo  "<tr>"; 
                            echo  "<td>";                           
                            echo  "<table   cellspacing=0 cellpadding=0 align=left border=0 width='60%' class=sortable>";
                            echo  "<tr>";                            
                            echo  "</tr>";
                            echo  "<td width=140 align='center'><font face='Arial'><em><b>Total por Usuário</b></em></font></td>";     
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>Prod.</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>Improd.</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>Sem Cl.</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>SI</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>25%</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>50%</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>75%</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>80%</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>90%.</b></em></font></td>";
                            echo  "<td width=70 align='center'><font face='Arial'><em><b>Cliente</b></em></font></td>";
                            echo "</tr>";
                            echo "</table>";                                                      
                            echo  "</tr>"; 
                            echo  "<tr>";
                            echo  "<td>";
                            echo  "<table   cellspacing=0 cellpadding=0 align=left border=0 width='60%' class=sortable>";
                            echo  "<tr>";                            
                            echo  "</tr>";
                            echo "<td width=140 class='form' align='center'>".$li."</td>";     
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_prdutivo,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_improdutivo,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_semclassificacao,$li)."</td>";                            
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_seminteresse,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_25,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_50,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_75,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_80,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_90,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_cliente,$li)."</td>";                           
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td colspan=11 ><b><hr></b></td>";
                            echo "</tr>";    
                            echo "</table>";
                            echo  "</td>";                                                               
                            echo  "</tr>";       
                            $vli = ($vli + $li);
                            $vtot_prdutivo =  ($vtot_prdutivo + $tot_prdutivo);                                              
                            $vtot_improdutivo = ($vtot_improdutivo + $tot_improdutivo);
                            $vtot_semclassificacao = ($vtot_semclassificacao + $tot_semclassificacao);
                            $vtot_seminteresse = ($vtot_seminteresse + $tot_seminteresse);
                            $vtot_25 = ($vtot_25 + $tot_25);
                            $vtot_50 = ($vtot_50 + $tot_50);
                            $vtot_75 = ($vtot_75 + $tot_75);
                            $vtot_80 = ($vtot_80 + $tot_80);
                            $vtot_90 = ($vtot_90 + $tot_90);
                            $vtot_cliente = ($vtot_cliente + $tot_cliente); 
                            
                        }else{
                            echo "<tr>";
                            echo "<td>Nenhum registro encontrado</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td>&nbsp;</td>";
                            echo "</tr>";                            
                        }   	
                  }  
                }  
            }else{  
                                     
                echo  "<tr>";                            
                echo  "<td >&nbsp;</td>";                                                               
                echo  "</tr>";
                echo  "<tr>"; 
                echo  "<td>";                           
                echo  "<table   cellspacing=0 cellpadding=0 align=left border=0 width='70%' class=sortable>";
                echo  "<tr>";                            
                echo  "</tr>";
                echo  "<td class=titulo bgcolor=#8080FF width=140 align='center'>Usuário</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=140 align='center'>Total por Usuário</td>";     
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'>Prod.</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'>Improd.</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'>Sem Cl.</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'>SI</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'>25%</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'>50%</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'>75%</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'><b>80%</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'><b>90%.</td>";
                echo  "<td class=titulo bgcolor=#8080FF width=70 align='center'>Cliente</td>";
                echo "</tr>";
                echo "</table>";                                                      
                echo  "</tr>";
                $sql = "SELECT 
                        g.CodUsuarioInterno codusr,
    				    u.Nome usuario 
    		        FROM gruposusuariosinternos_usuariosinternos g
    	                 INNER JOIN usuariosinternos u  ON g.CodUsuarioInterno = u.CodUsuarioInterno 
    		        WHERE CodGrupoUsuarioInterno = {$row['codgrupo']}" ;
  
                $usuario = mysql_query($sql) or die(mysql_error()); 
                            $tli = 0;
                            $ttot_prdutivo =  0;                                              
                            $ttot_improdutivo = 0;
                            $ttot_semclassificacao = 0;
                            $ttot_seminteresse = 0;
                            $ttot_25 = 0;
                            $ttot_50 = 0;
                            $ttot_75 = 0;
                            $ttot_80 = 0;
                            $ttot_90 = 0;
                            $ttot_cliente = 0;  
                if(mysql_num_rows($usuario)){		
		          while($user = mysql_fetch_array($usuario)){
                
                        $sql2 = "SELECT sa.Descricao status_ag ,
    						   sc.Descricao status_lead , 
    						   l.RazaoSocial Lead , 
    						   l.CodLead , 
    						   al.CodStatus codstatus_ag ,
    						   l.CodStatusClassificacaoLead codstatus_ld , 
    						   ta.Descricao tipo_ag
    					  FROM leads l
    				        INNER JOIN agendaslead al ON l.CodLead = al.CodLead
    				        LEFT JOIN statusagendamento sa ON sa.CodStatus = al.CodStatus
    				        LEFT JOIN tipoagendamento ta ON ta.CodTipo = al.CodTipo
    				        INNER JOIN statusclassificacaolead sc ON sc.CodStatusClassificacaoLead = l.CodStatusClassificacaoLead
    					 WHERE al.CodTipo IN (1, 4)
    					   AND ( al.CodStatus in ( 1 , 2 ) or al.CodStatus is null )
    					   AND ( ( al.CodUsuarioInterno = {$user['codusr']} and al.AgendadoPara is null ) or al.AgendadoPara = {$user['codusr']} )" ;
                        if ( $codpolo != 100 && $codpolo != null ) 
            				$sql2 .= " AND ( l.cod_polo = {$codpolo} or l.cod_polo = 100 ) " ;
            				
            			if ( $dataagde && $dataagate )
            				$sql2 .= " AND al.DataCadastro between '" . date( "Y-m-d" , $dataagde ) . " 00:00:00' and '" . date( "Y-m-d" , $dataagate ) . " 23:59:59'" ;
            				
            			if( $dataagde )
            				$sql2 .= " AND al.DataCadastro > '" . date( "Y-m-d" , $dataagde ) . " 00:00:00'" ;
            				
            			if( $dataagate )
            				$sql2 .= " AND al.DataCadastro < '" . date( "Y-m-d" , $dataagate ) . " 23:59:59'" ;
            				
            			$sql2 .= " ORDER BY al.DataCadastro" ; 
                         
                            $agendamento = mysql_query($sql2) or die(mysql_error());
                            $tot_prdutivo = 0 ;                        
                            $tot_improdutivo = 0;
                            $tot_semclassificacao = 0;
                            $tot_si = 0; 
                            $tot_seminteresse = 0;
                            $tot_25 = 0; 
                            $tot_50 = 0;
                            $tot_75 = 0;
                            $tot_80 = 0;
                            $tot_90 = 0;
                            $tot_cliente = 0;                       

                            $li = 0 ;
                            while($age = mysql_fetch_array($agendamento)){
                                //TOTAL STATUS AGENDAMENTO
                                if ( $age['codstatus_ag'] == 1 )
		                          $tot_prdutivo ++ ;
                                elseif ( $age['codstatus_ag'] == 2 )
					              $tot_improdutivo ++ ;  
                  	            else
					               $tot_semclassificacao ++ ;                                  
                                if ( $age['codstatus_ld'] == 1 )
					               $tot_si ++ ; 
                                
                                if ( $age['codstatus_ld'] == 1 )
                                  $tot_seminteresse++ ;
                                elseif ( $age['codstatus_ld'] == 4 )
					              $tot_25 ++ ;  
                                elseif ( $age['codstatus_ld'] == 5 )
						          $tot_50 ++ ;   
                                elseif ( $age['codstatus_ld'] == 6 )
						          $tot_75 ++ ;     
                                elseif ( $age['codstatus_ld'] == 10 )
						          $tot_80 ++ ;
                                elseif ( $age['codstatus_ld'] == 12 )
						          $tot_90 ++ ;
                                elseif ( $age['codstatus_ld'] == 15 )
						          $tot_cliente++ ;                                  
                                      
                                $li ++;
                            }     
                            
                            echo  "<tr>";
                            echo  "<td>";
                            echo  "<table   cellspacing=0 cellpadding=0 align=left border=0 width='70%' class=sortable>";
                            echo  "<tr>";                            
                            echo "<td width=140 class='form' align='center'>".$user['usuario']."</td>";
                            echo "<td width=140 class='form' align='center'>".$li."</td>";     
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_prdutivo,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_improdutivo,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_semclassificacao,$li)."</td>";                            
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_seminteresse,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_25,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_50,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_75,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_80,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_90,$li)."</td>";
                            echo "<td width=70 class='form' align='center'>".porcentagem($tot_cliente,$li)."</td>";                           
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td colspan=12 ><b><hr></b></td>";
                            echo "</tr>";    
                            echo "</table>";
                            echo  "</td>";                                                               
                            echo  "</tr>"; 
                            $tli = ($tli + $li);
                            $ttot_prdutivo =  ($ttot_prdutivo + $tot_prdutivo);                                              
                            $ttot_improdutivo = ($ttot_improdutivo + $tot_improdutivo);
                            $ttot_semclassificacao = ($ttot_semclassificacao + $tot_semclassificacao);
                            $ttot_seminteresse = ($ttot_seminteresse + $tot_seminteresse);
                            $ttot_25 = ($ttot_25 + $tot_25);
                            $ttot_50 = ($ttot_50 + $tot_50);
                            $ttot_75 = ($ttot_75 + $tot_75);
                            $ttot_80 = ($ttot_80 + $tot_80);
                            $ttot_90 = ($ttot_90 + $tot_90);
                            $ttot_cliente = ($ttot_cliente + $tot_cliente); 

                    }
                }

                    echo  "<tr>"; 
                    echo  "<td>";                           
                    echo  "<table   cellspacing=0 cellpadding=0 align=left border=0 width='70%' class=sortable>";
                    echo  "<tr>";                            
                    echo  "<td width=140 align='center'><font face='Arial'><em><b>&nbsp;</b></em></font></td>";
                    echo  "<td width=140 align='center'><font face='Arial'><em><b>Total Grupo</b></em></font></td>";     
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>Prod.</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>Improd.</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>Sem Cl.</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>SI</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>25%</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>50%</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>75%</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>80%</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>90%.</b></em></font></td>";
                    echo  "<td width=70 align='center'><font face='Arial'><em><b>Cliente</b></em></font></td>";
                    echo "</tr>";
                    echo  "<tr>";                            
                    echo "<td width=140 class='form' align='center'>&nbsp;</td>";
                    echo "<td width=140 class='form' align='center'>".$tli."</td>";     
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_prdutivo,$tli)."</td>";
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_improdutivo,$tli)."</td>";
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_semclassificacao,$tli)."</td>";                            
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_seminteresse,$tli)."</td>";
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_25,$tli)."</td>";
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_50,$tli)."</td>";
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_75,$tli)."</td>";
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_80,$tli)."</td>";
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_90,$tli)."</td>";
                    echo "<td width=70 class='form' align='center'>".porcentagem($ttot_cliente,$tli)."</td>";                           
                    echo "</tr>";
                    echo "<tr>";                    
                    echo "<td colspan=12 ><b><hr></b></td>";
                    echo "</tr>";                                         
                    echo "</table>"; 
                    echo "</td>";                                                     
                    echo  "</tr>";                    
                    echo  "<tr>";
                    echo  "<td>&nbsp;</td>";                            
                    echo  "</tr>"; 
                            $vli = ($vli + $tli);
                            $vtot_prdutivo =  ($vtot_prdutivo + $ttot_prdutivo);                                              
                            $vtot_improdutivo = ($vtot_improdutivo + $ttot_improdutivo);
                            $vtot_semclassificacao = ($vtot_semclassificacao + $ttot_semclassificacao);
                            $vtot_seminteresse = ($vtot_seminteresse + $ttot_seminteresse);
                            $vtot_25 = ($vtot_25 + $ttot_25);
                            $vtot_50 = ($vtot_50 + $ttot_50);
                            $vtot_75 = ($vtot_75 + $ttot_75);
                            $vtot_80 = ($vtot_80 + $ttot_80);
                            $vtot_90 = ($vtot_90 + $ttot_90);
                            $vtot_cliente = ($vtot_cliente + $ttot_cliente); 
            }  
            
        }      
	}
	mysql_free_result($result);
            echo  "<tr>";
            echo  "<td>&nbsp;</td>";
            echo  "</tr>";
            echo  "<tr>"; 
            echo  "<tr>";
            echo  "<td>&nbsp;</td>";
            echo  "</tr>";
            echo  "<tr>"; 
            echo  "<td>";                           
            echo  "<table   cellspacing=0 cellpadding=0 align=left border=0 width='60%' class=sortable>";
            echo  "<tr>";                            
            echo  "<td width=140 align='center'><font face='Arial'><em><b>Total Geral Grupo</b></em></font></td>";     
            echo  "<td width=70 align='center'><font face='Arial'><em><b>Prod.</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>Improd.</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>Sem Cl.</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>SI</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>25%</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>50%</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>75%</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>80%</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>90%.</b></em></font></td>";
            echo  "<td width=70 align='center'><font face='Arial'><em><b>Cliente</b></em></font></td>";
            echo "</tr>";
            echo "</table>";  
            echo  "</td>";                                                                    
            echo  "</tr>"; 
            echo  "<tr>";
            echo  "<td>";
            echo  "<table   cellspacing=0 cellpadding=0 align=left border=0 width='60%' class=sortable>";
            echo  "<tr>";                           
            echo "<td width=140 class='form' align='center'>".$vli."</td>";     
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_prdutivo,$vli)."</td>";
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_improdutivo,$vli)."</td>";
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_semclassificacao,$vli)."</td>";                            
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_seminteresse,$vli)."</td>";
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_25,$vli)."</td>";
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_50,$vli)."</td>";
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_75,$vli)."</td>";
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_80,$vli)."</td>";
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_90,$vli)."</td>";
            echo "<td width=70 class='form' align='center'>".porcentagem($vtot_cliente,$vli)."</td>";                           
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan=11 ><b><hr></b></td>";
            echo "</tr>";    
            echo "</table>";
            echo  "</td>";                                                               
            echo  "</tr>";  
            echo "<tr>";
            echo "<td>&nbsp;</td>";
            echo "</tr>";       
    ?>
	</tbody>
  </table>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
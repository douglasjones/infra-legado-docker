<?
header('Content-Type: text/html; charset=ISO-8859-1');
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";
$agendadia = $_REQUEST['agendas'];
$dtvisita = $_REQUEST['datavisita'];
if(!((permissao('imprime_vista', 'ic')) || (permissao('imprime_vista', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
?>
<link rel="stylesheet" href="../../extras/public1.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<?include_once "../../libs/head.php";?>

<form name="dados" id="dados"  method="post">
<table width="" cellpadding="" class=form cellspacing=""></table>
    <?
    //echo "<br>"; 
    $sql ="Select a.CodAgendaLead,
                a.CodLead,
                a.CodUsuarioInterno,
                s.Descricao Status,
                a.AgendadoPara,
                a.DataHorario,
                a.CodStatus,
                a.CodReagendamento,
                a.Descricao,
                a.cod_tamanho_visita,
                t.Descricao Tipo,
                l.RazaoSocial,
                u1.Nome AgendadoPor ,
                sc.Descricao as statuslead, 
                cl.nomecontato,
                a.endereco,
               a.cep,
               a.numero,
               a.complemento,
               a.bairro,
               a.cidade,
               a.uf 
           from agendaslead a 
                inner join leads l on a.CodLead = l.CodLead  
                inner join usuariosinternos u1 on a.CodUsuarioInterno = u1.CodUsuarioInterno 
                inner join tipoagendamento t on a.CodTipo = t.CodTipo 
                inner join statusclassificacaolead sc on l.codstatusclassificacaolead = sc.CodStatusClassificacaoLead 
                left join statusagendamento s on a.CodStatus = s.CodStatus
                inner join contatoslead cl on a.codcontatolead = cl.codcontatolead
           where a.codagendalead in(".$agendadia.")";
    $sql.=" order by a.DataHorario";
    $linha = "";
    $result = mysql_query($sql);
	//$row1 = mysql_fetch_array($result);
	
    echo "<table width=100% class=form cellpadding=0 cellspacing=0 border=1>";
    echo    "<thead>";
    echo    "<tr>";
    echo        "<td colspan=2>";
    echo            "<table width=100% class=form cellpadding=0 cellspacing=0 border=0>";
    echo                "<tr >";
    echo                    "<td>";
    echo                        "<img border=0 src='../../images/logo/logo.png' width=100  >";
    echo                    "</td>";
    echo                    "<td aling=center valign=middle>";
    echo                        "<face='verdana' size='5'><b>Data  ".$dtvisita."</b></font>";     
    echo                    "</td>"; 
    echo                    "<td valign=top align=right>";
    echo                        "<input type='button' value='Imprimir' onclick='window.print()' />";     
    echo                    "</td>";         
    echo                "</tr>";   
    echo                "<tr >";
    echo                    "<td  colspan=3>";
    echo                        "&nbsp;"; 
    echo                    "</td>";     
    echo                "</tr>";
    echo            "</table>";  
    echo        "</td>";
    echo    "</tr>";  
    echo    "</head>";
    echo    "<tbody>";
    while($row = mysql_fetch_array($result)){
        echo    "<tr>";
        echo        "<td colspan=2>";
        echo            "<table width=100% class=form cellpadding=0 cellspacing=0 border=0>";
        echo                "<tr>";
        echo                    "<td width=28%>";
        echo                        "&nbsp;Horário:";   
        echo                    "</td>";
        echo                    "<td>";
        echo                        "&nbsp;<font face='verdana' size='2'><b>".date('H:i', strtotime($row['DataHorario']))." / ".$row['Tipo']."</b></font>";   
        echo                    "</td>";
        echo                "</tr>";
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Consultor:";   
        echo                    "</td>";
        echo                    "<td>";
                                    if(!empty($row['CodAgendaLead'])){
                                        $consultor = array();
                                        $sql = "Select
                                                  ui.Nome as gerente
                                                from agendagerenteconta ag
                                                inner join usuariosinternos ui on ag.CodGerenteConta = ui.CodUsuarioInterno
                                                where ag.CodAgendaLead=".$row['CodAgendaLead'];
                                        
                                        $results = mysql_query($sql);
                                        while($rs = mysql_fetch_array($results)){
                                           $consultor[] = $rs['gerente'];     
                                        }
                                        $consultor = implode(" - ", $consultor);
                                        echo "&nbsp;".$consultor;            
                                    }
                                    mysql_free_result($results);
        echo                    "</td>";
        echo                "</tr>";  
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Agendado Por:";   
        echo                    "</td>";
        echo                    "<td>";
        echo                        "&nbsp;".$row['AgendadoPor'];   
        echo                    "</td>";        
        echo                "</tr>";                
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Razão Social:";   
        echo                    "</td>";
        echo                    "<td>";
        echo                        "&nbsp;".$row['RazaoSocial']."";   
        echo                    "</td>";
        echo                "</tr>";
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Nome Fantasia:";   
        echo                    "</td>";
        echo                    "<td>";
        echo                        "&nbsp;".$row['NomeFantasia']."";   
        echo                    "</td>";        
        echo                "</tr>";
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Endereço:";   
        echo                    "</td>";
        echo                    "<td>";
        echo                        "&nbsp;".$row['endereco'].",".$row['numero']." - ".$row['Bairro']."  ".$row['complemento']."  ".$row['cep']."  ".$row['cidade'].""; 
        echo                    "</td>";        
        echo                "</tr>";
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Contato:";   
        echo                    "</td>";
        echo                    "<td>";
        echo                        "&nbsp;".$row['nomecontato']."";   
        echo                    "</td>";        
        echo                "</tr>";
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Operadoras contratadas:";   
        echo                    "</td>";
        echo                    "<td>";
            						$sql = "select op.cod_operadora codigo, op.dsc_operadora nome
            							from operadoras op
            							inner join leads_operadoras lo ON lo.cod_operadora = op.cod_operadora
            							where lo.CodLead =".$row['CodLead'];
            						
                                    $results = sql_query($sql);
            						while($rs = mysql_fetch_array($results))
            						{
            							echo "&nbsp;".$rs["nome"]."&nbsp;&nbsp;&nbsp;";
            						}
            						mysql_free_result($results);
        echo                    "</td>";        
        echo                "</tr>";
      
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Tamanho da Visita:";   
        echo                    "</td>";
        echo                    "<td>";
                                    if($row['cod_tamanho_visita']==1){
                                        echo "&nbsp;Pequena";            
                                    }else if($row['cod_tamanho_visita']==2){
                                        echo "&nbsp;Média";
                                    }else if($row['cod_tamanho_visita']==3){
                                        echo "&nbsp;Grande";
                                    }    
        echo                    "</td>";        
        echo                "</tr>"; 
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Observação:";   
        echo                    "</td>";
        echo                    "<td>";
        echo                        "&nbsp;".nl2br($row['Descricao']);   
        echo                    "</td>";        
        echo                "</tr>";                          
        echo                "<tr>";
        echo                    "<td>";
        echo                        "&nbsp;Status Visita:";   
        echo                    "</td>";
        echo                    "<td class='select'>";
        echo                        "&nbsp;<b>Produtivo</b> <input type='checkbox'  /> <b>Improdutivo</b> <input type='checkbox'  />  ";   
        echo                    "</td>";        
        echo                "</tr>";
        echo                "<tr>";
        echo                    "<td colspan=2 align=center>";
        echo                        "&nbsp;";   
        echo                    "</td>";
        echo                "</tr>";             
        echo                "<tr>";
        echo                    "<td colspan=2 align=center>";
        echo                        "<b>Anotações</b>";   
        echo                    "</td>";
        echo                "</tr>";
        echo                "<tr>";
        echo                    "<td colspan=2 align=center>";
        echo                        "<br><hr width=98%></hr><br><hr width=98%></hr>";   
        echo                    "</td>";
        echo                "</tr>";
        echo            "</table>";
        echo        "</td>";
        echo    "</tr>";

    }
    echo "  </tbody>";
    echo "</table>";
    ?>
     
</form>

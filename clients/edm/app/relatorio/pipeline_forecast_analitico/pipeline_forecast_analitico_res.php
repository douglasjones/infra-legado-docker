<?
$excel = $_REQUEST['excel'];
if($excel == "S"){
	$arquivo = 'planilha.xls';
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}
include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;
include_once( "../../libs/cla.equipes.php" ) ;


//PARAMTROS DE PESQUISA
$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codatendente = $_REQUEST['codatendente'];
$dtrecebpedidode = $_REQUEST['dtrecebpedidode'];
$dtrecebpedidoate = $_REQUEST['dtrecebpedidoate'];
$ativacaode = $_REQUEST['dtativacaode'];
$ativacaoate = $_REQUEST['dtativacaoate'];
$cod_operador = $_REQUEST['cod_operador'];
$npedido = $_REQUEST['numpvc'];

//$dtentreagade = $_REQUEST['dtentreagade'];
//$dtentreagaate = $_REQUEST['dtentreagaate'];

//FUNCAO BUSCA QTDE DE LINHAS
function linhas($strVariavel, $codlead, $codproposta, $codversao,$id){
	$sql ="";
    $sql ="select mp.id, (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) total,mpr.rotulo ";
    $sql.="  from modulosproposta mp ";
    $sql.="  inner join modulosproduto mpr on mp.id = mpr.ID ";
	$sql.=" where mp.codlead = ".$codlead;
	$sql.="   AND mp.codproposta = ".$codproposta;
	$sql.="   AND mp.versao = ".$codversao;
    $sql.="   AND mpr.rotulo is not null ";
    $sql.="   AND mp.id=' ".$id."'";		
	$sql.="   AND  (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) > 0 " ;
    $sql.="   AND mpr.rotulo like '%".$strVariavel."'";
    
	$rs_variavel = mysql_query($sql);
	while($row_variavel = mysql_fetch_array($rs_variavel)){
		$strRetorno = $row_variavel['total'];
	}
	mysql_free_result($rs_variavel);
	return $strRetorno;
}
//BUSCA VALOR
    function valor($rotulo, $codlead, $codproposta, $codversao){

	$sql ="";
    $sql ="select (ifnull(mp.valor,0) +  ifnull(mp.calculado,0)) calculado ";
    $sql.="  from modulosproposta mp ";
    $sql.="  inner join modulosproduto mpr on mp.id = mpr.ID ";
	$sql.=" where mp.codlead = ".$codlead;
	$sql.="   AND mp.codproposta = ".$codproposta;
	$sql.="   AND mp.versao = ".$codversao;
    $sql.="   AND mpr.rotulo='".$rotulo."'";	
    
	$rs_var = mysql_query($sql);
	while($row_var = mysql_fetch_array($rs_var)){		    
		$idRetorno = $row_var['calculado'];            
	}
	mysql_free_result($rs_var);
	return $idRetorno;
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
		<font size="+2">Pipeline Forecast Análitico</font>
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
		if(!empty($codatendente)){
			$sql = "select nome from usuariosinternos where codusuariointerno= $codatendente ";
			$q = mysql_query($sql);
			echo "Atendente: ";
			while($row = mysql_fetch_array($q)){
				echo $row['nome']." ";
			}
			mysql_free_result($q);
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codgerenteconta)){
			$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
			$q = mysql_query($sql);
			echo "Consultor: ";
			while($row = mysql_fetch_array($q)){
				echo $row['nome']." ";
			}
			mysql_free_result($q);
		}
		?>
		</td>
	</tr>							
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codequipe'])){
			$sql = "Select Vc_Nome from tb_equipesvendas where Tk_Equipe = ".$_REQUEST['codequipe'];
			$q = mysql_query($sql);
			$equipe = mysql_fetch_array($q);
			echo "Equipe: ".$equipe['Vc_Nome'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['numpvc'])){
		
			echo "Número Pedido: ".$npedido;
		}
		?>
		</td>
	</tr>    
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['cod_operador'])){
			$sql = "Select dsc_operador from operador where cod_operador = ".$_REQUEST['cod_operador'];
			$q = mysql_query($sql);
			$operador = mysql_fetch_array($q);
			echo "Operadora: ".$operador['dsc_operador'];
		}
		?>
		</td>
	</tr>
	<?	
	if(!empty($dtrecebpedidode)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Recebimento Pedido:&nbsp;<?=date('d/m/Y', strtotime(dataYMD($dtrecebpedidode)));?> até <?=date('d/m/Y', strtotime(dataYMD($dtrecebpedidoate)));?></dt>
		</td>
	</tr>
	<?	
	}
	?>
	<?	
	if(!empty($ativacaode)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Ativação:&nbsp;<?=date('d/m/Y', strtotime(dataYMD($ativacaode)));?> até <?=date('d/m/Y', strtotime(dataYMD($ativacaoate)));?></dt>
		</td>
	</tr>
	<?	
	}
	?>    
</table>
<br />  
<table  cellspacing="0" cellpadding="0" align="center" border="1" width="2100" class="sortable">

    <thead>
            <tr>
                <td class="titulo" bgcolor="#8080FF">#</td>
                <td class="titulo" bgcolor="#8080FF">Cód Lead</td>
                <td class="titulo" bgcolor="#8080FF">Lead</td>
                <td class="titulo" bgcolor="#8080FF">Status</td>                
                <td class="titulo" bgcolor="#8080FF">Consultor</td>
                <td class="titulo" bgcolor="#8080FF">Atendente</td>	
                <td class="titulo" bgcolor="#8080FF">Proposta</td>                
                <td class="titulo" bgcolor="#8080FF">Operadora</td>
                <td class="titulo" bgcolor="#8080FF">Produto</td>
                <td class="titulo" bgcolor="#8080FF">Qtde Linhas</td>	

            </tr>
    </thead>   
    <?
        $sql =" ";
        $sql.="SELECT date_format(np.dt_cadastro, '%d/%m/%Y') datacadastroproposta,
                scl.descricao statuslead,
                l.razaosocial,
                ui.nome gerenteconta,
                ui1.nome atendente,
                l.codlead,
                np.pk propostas_pk,             
                nip.produtos_pk,
                op.dsc_operador,
                npa.aparelhos_pk,
                npr.ds_produto
            FROM leads l
                     INNER JOIN statusclassificacaolead scl
                            ON l.codstatusclassificacaolead = scl.codstatusclassificacaolead
                     LEFT JOIN usuariosinternos ui
                            ON l.codgerenteconta = ui.codusuariointerno
                     LEFT JOIN usuariosinternos ui1
                            ON l.codatendente = ui1.codusuariointerno
                     INNER JOIN n_propostas np ON np.leads_pk = l.codlead
                     LEFT join n_itens_propostas nip on np.pk = nip.propostas_pk
                     LEFT JOIN n_produtos npr ON npr.pk = nip.produtos_pk
                     LEFT JOIN n_combos nc ON nc.pk  = nip.combos_pk
                     LEFT JOIN n_propostas_aparelhos npa ON np.pk = npa.propostas_pk
                     LEFT JOIN n_aparelhos nap ON nap.pk = npa.aparelhos_pk";
                     if(!empty($cod_operador)){
                                  $sql.=" LEFT JOIN operador op ON npr.operador_pk = op.cod_operador or nc.operador_pk = op.cod_operador OR op.cod_operador = nap.operador_pk and op.cod_operador=".$cod_operador;
                     }		
	 
            if(!empty($dtrecebpedidode)){
                       $sql.="  INNER JOIN n_datas_proposta ndp  ON ( ndp.propostas_pk = np.pk             
                       AND ndp.data_proposta_operador_pk in (select pk from n_data_proposta_operador where ds_label_data='recebe_assinatura'))";
               }


               if(!empty($ativacaode)){
               $sql.="  INNER JOIN n_datas_proposta ndp  ON ( ndp.propostas_pk = np.pk             
                       AND ndp.data_proposta_operador_pk in (select pk from n_data_proposta_operador where ds_label_data='entrega_aparelho'))";
               }



               $sql.=" where np.dt_cancelamento IS NULL 
                   And l.CodStatusClassificacaoLead in (4,5,6)";

           if(!empty($dtrecebpedidode)){
                       $sql.=" and (ndp.vl_data_proposta between '".DataYMD($dtrecebpedidode)."' and '".DataYMD($dtrecebpedidoate)."' ) ";
               }

               if(!empty($ativacaode)){
                       $sql.=" and (ndp.vl_data_proposta between '".DataYMD($ativacaode)."' and '".DataYMD($ativacaoate)."' ) ";
               }

	
        //numero do pedido = 
            if(!empty($npedido)){
                    $sql.=" and p.NumPVC=".$npedido;
            }   
            //parametros de pesquisa
            if(!empty($_REQUEST['cod_polo'])){
                    $sql.="  and l.cod_polo =".$_REQUEST['cod_polo'];
            }	
            if(!empty($codequipe)){
                    //$sql.="  and l.codgerenteconta in (";
                    //$sql.=" select e.fk_usuario ";
                    //$sql.="   from tb_usuarioequipe e ";
                    //$sql.="  where fk_equipe = $codequipe ) ";
            }

            if(!empty($codgerenteconta)){
                    //$sql.=" and l.codgerenteconta = $codgerenteconta ";
            }
            if(!empty($codatendente)){
                    $sql.=" and l.codatendente = $codatendente ";   
         } 
            //COLOCA OS DEMAIS PARÂMETROS
            if(!permissao('visualizar_todos_consultores', 'cs')){
                    //$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";
            }	

            if(!permissao('visualizar_todos_atendentes', 'cs')){
                    //$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";  
            }
            //$sql.=" and npr.produtos_tipo_pk=1";
            $sql.=" GROUP BY l.codlead";

            $result = mysql_query($sql);

            $cont = 1;
            $totalvalor = 0;
            $totalnegocios = 0;
            $total_linhas = 0
                    ; 
        while($row = mysql_fetch_array($result)){
            echo "<tr>";
            echo    "<td class='form' align='center'>".$cont."</td>";
            echo    "<td class='form' align='center'>".$row['codlead']."</td>";
            echo    "<td class='form' align='center'>".$row['razaosocial']."</td>";
            echo    "<td class='form' align='center'>".$row['statuslead']."</td>";
            echo    "<td class='form' align='center'>".$row['gerenteconta']."</td>";
            echo    "<td class='form' align='center'>".$row['atendente']."</td>";           
            echo    "<td class='form' align='center'>".$row['propostas_pk']."</td>";
            echo    "<td class='form' align='center'>".$row['dsc_operador']."</td>";
            echo    "<td class='form' align='center'>".$row['ds_produto']."</td>";
            $sql="";
            $sql.="SELECT nip.pk,
                            nip.dt_cadastro,						   
                            nip.vl_unitario,
                            nip.n_qtde,
                            npr.ds_produto,
                            nc.ds_combo,
                            npt.ds_tipo_produto,
                            nipo.vl_franquia,
                            nipo.tipo_linha_pk
                   FROM n_itens_propostas nip
                            LEFT JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                            LEFT JOIN n_combos nc ON nip.combos_pk = nc.pk
                            LEFT JOIN n_produtos_tipo npt ON npr.produtos_tipo_pk = npt.pk
                            LEFT JOIN n_itens_propostas_operadoras nipo ON nipo.itens_propostas_pk = nip.pk
                  WHERE nip.propostas_pk=".$row['propostas_pk'];	
                $sql.=" and npr.produtos_tipo_pk=1";

                $rs_mp = mysql_query($sql);
                $qtde_linhas = 0;
                while($row_mp = mysql_fetch_array($rs_mp)){                    
                    $qtde_linhas +=  ($row_mp['n_qtde']);                    
                }
                 mysql_free_result($rs_mp);
            echo    "<td class='form' align='center'>".$qtde_linhas."</td>";
            echo "</tr>";
            $cont ++;
        }
        mysql_free_result($result);
                
    ?>
    <tbody>
        
    </tbody>
</table>            
<?	include_once "../../libs/desconectar.php";?>

<?	
require_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo_relatorios.php";
include_once "../../libs/cla.agenda.php";
include_once "../../libs/cla.equipes.php";
include_once "../../libs/cla.usuarios.php";

if(!permissao('agenda', 'cs')){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}
//
$sql = "Select
			o.cod_operador operador_pk
			,o.dsc_operador
		from operador o
			inner join empresa_operador eo on o.cod_operador = eo.cod_operador";
			
$rs = mysql_query($sql);
$n_operadora = mysql_num_rows($rs);

if($n_operadora==1){
	$operador = mysql_fetch_array($rs);
	$operador_pk = $operador['operador_pk'];
}
//pega a todas as variaveis

$mes = 0;
$ano = 0;


$mes=$_REQUEST['mes'];
$ano=$_REQUEST['ano'];

$codtipo=$_REQUEST['codtipo'];
$codstatus=$_REQUEST['codstatus'];
$codgerenteconta=$_REQUEST['codgerenteconta'];
$agendadopor=$_REQUEST['agendadopor'];
$agendadopara=$_REQUEST['agendadopara'];
$codgrupousuariointerno=$_REQUEST['codgrupousuariointerno'];
$codequipe=$_REQUEST['codequipe'];
$cod_polo=$_REQUEST['cod_polo'];
$codstatusclassificacaolead = $_REQUEST['codstatusclassificacaolead'];
$mailing_pk = $_REQUEST['mailing_pk'];
$cod_tamanho_visita = $_REQUEST['cod_tamanho_visita'];
$agenda_operador_pk = $_REQUEST['agenda_operador_pk'];

$nomemes = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$nomesemana = array(0 => 'Domingo', 1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta', 4 => 'Quinta', 5 => 'Sexta', 6 => 'Sabado');

if(!empty($_REQUEST['mes']))
	$mes = $_REQUEST['mes'];
	
if(!empty($_REQUEST['ano']))
	$ano = $_REQUEST['ano'];
	
if($mes <= 0 || $mes > 12)
	$mes = date('n');
	
if($ano <= 0)
	$ano = date('Y');
	
$dtinicio = mktime(0, 0, 0, $mes, 1, $ano);
$dtfim = mktime(0, 0, 0, $mes + 1, 0, $ano);

while(date('w', $dtinicio) != 0)
	$dtinicio = mktime(0, 0, 0, date('n', $dtinicio), date('d', $dtinicio) - 1, date('Y', $dtinicio));
	
while(date('w', $dtfim) != 6)
	$dtfim = mktime(0, 0, 0, date('n', $dtfim), date('d', $dtfim) + 1, date('Y', $dtfim));
	
$dtfim = mktime(0, 0, 0, date('n', $dtfim), date('d', $dtfim) + 1, date('Y', $dtfim));

//MOnta as datas para pesquisa baseado no mysql 
$sql = "SELECT LAST_DAY('".$ano."-".$mes."-01') dtfim; ";
$rs_data = mysql_query($sql);
$row = mysql_fetch_array($rs_data);
$dtfim_mysql = $row['dtfim'];
$dtinicio_mysql = $ano."-".$mes."-01";
mysql_free_result($rs_data);

$sql ="Select  a.CodAgendaLead,
               a.CodLead,
               a.CodUsuarioInterno,
               s.Descricao Status,
               a.AgendadoPara,
               a.DataHorario,
               a.CodStatus,
               a.CodReagendamento,
               a.CodTipo,
               t.Descricao Tipo,
               l.RazaoSocial,
               u1.Nome AgendadoPor,
               u2.Nome AgendadoPara,
               sc.Descricao AS statuslead,
               u3.nome AS AgendadoPor,
               a.endereco,
               a.cep,
               a.numero,
               a.complemento,
               a.bairro,
               a.cidade,
               a.uf,
               au.pk auditoria_pk,
               a.operador_pk";
$sql.="  from agendaslead a  ";
$sql.="       inner join leads l on a.CodLead = l.CodLead  ";
$sql.="       inner join usuariosinternos u1 on a.CodUsuarioInterno = u1.CodUsuarioInterno  ";
$sql.="       inner join tipoagendamento t on a.CodTipo = t.CodTipo ";
$sql.="       inner join statusclassificacaolead sc on l.codstatusclassificacaolead = sc.CodStatusClassificacaoLead ";
$sql.="       left join auditoria au on a.CodAgendaLead = au.agendavisita_pk ";

if(!permissao('visualizar_todos_consultores', 'cs')){
    if($codgerenteconta > "0")
   	    $sql.=" inner join agendagerenteconta agc on agc.codagendalead = a.codagendalead ";
    else
        $sql.=" left join agendagerenteconta agc on agc.codagendalead = a.codagendalead ";
}
else{
    $sql.=" left join agendagerenteconta agc on agc.codagendalead = a.codagendalead ";
} 
	

if(!empty($codgrupousuariointerno))
	$sql.=" inner join gruposusuariosinternos_usuariosinternos gu1 on gu1.CodUsuarioInterno = u1.CodUsuarioInterno ";

if(!empty($codequipe))
	$sql.=" inner join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";

$sql.="       left join usuariosinternos u2 on a.AgendadoPara = u2.CodUsuarioInterno  ";
$sql.="       left join usuariosinternos u3 on a.CodUsuarioInterno = u3.CodUsuarioInterno  ";
$sql.="       left join statusagendamento s on a.CodStatus = s.CodStatus ";
$sql.="where a.DataHorario Between '".$dtinicio_mysql." 00:00:00' And '".$dtfim_mysql." 23:59:59'";
 
//Regras de visualização de equipe de consultores
if(!permissao('visualizar_todos_consultores', 'cs'))
	$sql .= " and agc.CodGerenteConta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";

//regras de visualização de equipe de telemarketing
if(!permissao('visualizar_todos_atendentes','cs'))
	$sql .= " and a.CodUsuarioInterno in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).")";

//regras de visualização do polo
if(!empty($_SESSION['polo_pk']))
	$sql .= " and l.cod_polo = ".$_SESSION['polo_pk']." ";

//variaveis que chegam através dos parâmetros
if(!empty($codtipo))
	$sql .= " and a.codtipo = " . mysqlnull($codtipo);
	
if($codstatus == "0")
	$sql .= " and a.codstatus is null ";
elseif ($codstatus >= 1)
	$sql .= " and a.codstatus = " . mysqlnull($codstatus);

if($codgerenteconta == "0")
	$sql.="  and agc.codgerenteconta is null ";
elseif($codgerenteconta > 0)
	$sql.= " and agc.codgerenteconta = '".$codgerenteconta."'";
	
if($agendadopor == "0")
	$sql.= " and a.codusuariointerno is null ";
elseif($agendadopor > 0)
	$sql.= " and a.codusuariointerno = ".mysqlnull($agendadopor);
	
if($agendadopara == "0")
	$sql.="	 and a.agendadopara is null ";
elseif($agendadopara > 0)
	$sql.="	 and a.agendadopara = ".mysqlnull($agendadopara);

if(!empty($codgrupousuariointerno))
	$sql.=" and gu1.codgrupousuariointerno=".mysqlnull($codgrupousuariointerno);
	
if(!empty($cod_polo))
	$sql.=" and l.cod_polo = ".mysqlnull($cod_polo);

if(!empty($codequipe))
	$sql.=" and tbu.Fk_Equipe=".mysqlnull($codequipe);

if(!empty($codstatusclassificacaolead))
	$sql.=" and l.codstatusclassificacaolead=".mysqlnull($codstatusclassificacaolead);   
	
if(!empty($mailing_pk))
	$sql.=" and l.mailing_pk = ".$mailing_pk;
    
if(!empty($cod_tamanho_visita))
	$sql.=" and cod_tamanho_visita = ".$cod_tamanho_visita;    

if(!empty($agenda_operador_pk))
	$sql.=" and a.operador_pk = ".$agenda_operador_pk;    
    
$sql.=" order by a.DataHorario";

$dbnames = get_dbnames();
$agendas = array();
$cont = 0;
$qtde = array();
$qtde[str_pad($mes, 2, '0', STR_PAD_LEFT)] = 0;
//
foreach($dbnames as $dbname => $dbname1):
	$result = sql_query($sql, $dbname);
	while($row = mysql_fetch_array($result)):
		$sql1 = "Select u.CodUsuarioInterno, u.Nome from agendagerenteconta a Inner Join usuariosinternos u on a.CodGerenteConta = u.CodUsuarioInterno Where a.CodAgendaLead = {$row['CodAgendaLead']}";
		$rsgerente = sql_query($sql1, $dbname);
		while($rwgerente = mysql_fetch_array($rsgerente)):
			$row['GerenteConta'][$rwgerente['CodUsuarioInterno']] = $rwgerente['Nome'];
		endwhile;

		mysql_free_result($rsgerente);
		if($dbname != $BD)
			$row['OutraBase'] = $dbname1;
		$agendas[date('Ymd', strtotime($row['DataHorario']))][date('Hi', strtotime($row['DataHorario']))][] = $row;
		if(empty($qtde[date('m', strtotime($row['DataHorario']))])):
			$qtde[date('m', strtotime($row['DataHorario']))] = 0;
		endif;
		$qtde[date('m', strtotime($row['DataHorario']))]++;
		if(empty($qtde[date('Ymd', strtotime($row['DataHorario']))])):
			$qtde[date('Ymd', strtotime($row['DataHorario']))] = 0;
		endif;
		$qtde[date('Ymd', strtotime($row['DataHorario']))]++;
		$cont++;
	endwhile;
endforeach;
ksort($agendas);
//
foreach($agendas as $data => $agenda):
	ksort($agenda);
	$agendas[$data] = $agenda;
endforeach;
mysql_free_result($result);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Agenda</title>
 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">    	
	<link rel="stylesheet" href="../../extras/lytebox.css" type="text/css" media="screen" />
    <script type="text/javascript" language="javascript" src="../../extras/lytebox.js"></script>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">

        function editarAgenda(vlr){
        	NewWindow("../../vendas/leads/leadsagendanew.php?codagendalead="+vlr,590,560)
        }
        function classificar_visita(codagendalead,codlead,codtipo){
            NewWindow("../../vendas/leads/classifcacao_visita_cad_form.php?acao=salvar&codagendalead="+codagendalead+"&codlead="+codlead+"&codtipo="+codtipo,1160,500)
        }
        function reagendavisita(codagendalead,codlead){
        	NewWindow("../../vendas/leads/leadsagendanew.php?reagendar=Reagendar visita&codagendalead="+codagendalead+"&codlead="+codlead,590,560)
        }        
 
        function auditar_visita(codagendalead,codlead,auditoria_pk){
			
        	NewWindow("../../vendas/leads/auditoria_cad_form.php?reagendar=Reagendar visita&codagendalead="+codagendalead+"&codlead="+codlead+"&auditoria_pk="+auditoria_pk,590,560)
        }   
        
        function imprimeagenda(vlr,dtv){

        	NewWindow("imprime_visitas.php?agendas="+vlr+"&datavisita="+dtv,590,560)
        }
        //NOVA PROPOSTA
		function add_new_proposta(leads_pk,agendalead_pk,operador_pk){					
			NewWindow("../../vendas/leads/propostas_cad_form.php?acao=ins&codlead="+leads_pk+"&agendalead_pk="+agendalead_pk+"&operador_pk="+ operador_pk, 1160, 600)	
		}
	</script>
	<style type="text/css">
	a:link {
		text-decoration:none;
	}
	a:visited {
		text-decoration:none;
	}
	a:hover {
		text-decoration:underline;
	}
	.agendamento {
		margin-top:3px;
		margin-bottom:5px;
		border-bottom:solid 3px #FFFFFF;
	}
	.outrabase {
		background-color: rgb(100, 100, 100);
		color: white;
	}
	.outromes {
		color:gray;
	}
	.status1 {
		background:rgb(150, 255, 150);
	}
	.status2 {
		background:rgb(255, 150, 150);
	}

	.status3 {
		background:rgb(255, 255, 150);
	}
	.status4 {
		background:rgb(255, 50, 50);
		color:white;
	}
    .cliente {
		background:rgb(100, 100, 255);
	}
	.status6 {
        
        background-color:#00CCFF; 
		//background:rgb(56,176,222);
	}
	.style1 {color: #FFFFFF}
    </style>
    
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
	<form action="agenda.php" method="get">
		<input type="hidden" name="mes" value="<?=$mes;?>" />
		<input type="hidden" name="ano" value="<?=$ano;?>" />
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="grid">
	<tr>
		<td align="center">
			<a href="agenda.php?mes=<?=$mes;?>&ano=<?=$ano - 1;?><?=$filtro;?>">&#60;&#60; Ano</a>
		&nbsp;
		<a href="agenda.php?mes=<?=($mes == 1)?12:$mes - 1;?>&ano=<?=($mes == 1)?$ano - 1:$ano;?><?=$filtro;?>">&#60;&#60; Mês</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?=$nomemes[$mes].'/'.$ano;?>&nbsp;-&nbsp;
		<?=$qtde[str_pad($mes, 2, '0', STR_PAD_LEFT)] . ' Visita' . ($qtde[str_pad($mes, 2, '0', STR_PAD_LEFT)] == 1?null:'s');?>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="agenda.php?mes=<?=($mes == 12)?1:$mes + 1;?>&ano=<?=($mes == 12)?$ano + 1:$ano;?><?=$filtro;?>">Mês &#62;&#62;</a>
		&nbsp;
		<a href="agenda.php?mes=<?=$mes;?>&ano=<?=$ano + 1;?><?=$filtro;?>">Ano &#62;&#62;</a>
	</td>
</tr>
</table>
<!--<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
		&nbsp;<span class="style1">Filtro</span>		</td>
	</tr>
</table>-->
<!--FORMULARIO DE FILTROS-->
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form" >
    <tr>
        <td>
            <label for="codtipo">Tipo:</label>
        </td>
        <td>
            <? combo::tipo_agendamento($codtipo);?>
        </td>
        <td>
            <label for="codstatus">Status da Visita:</label>
        </td>
        <td>
            <?	combo::status_ag($codstatus);?> 
        </td>
    </tr>
    <tr>
        <td>
            <label for="codgerenteconta">Consultor:</label>
        </td>
        <td>
            <?	combo::consultor_equipe($codgerenteconta);?>
        </td>
			<td><label for="status">Status Lead:</label></td>
			<td>
			<?	
				$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead order by codstatusclassificacaolead ";
				combo($sql,"codstatusclassificacaolead", $codstatusclassificacaolead, " ", "");
			?>
			</td>
    </tr>
    <tr>
        <td>
            <label for="agendadopara">Agendado para Atendente:</label>
        </td>
        <td>
            <?	combo::agdo_para($agendadopara);?>
        </td>
        <td>
            <label for="codusuariointerno">Agendado por:</label>
        </td>
        <td>
            <?	combo::agdo_por($agendadopor)?>
        </td>
    </tr>
	
    <tr>
        <td>
            <label for="codequipe">Equipe Comercial:</label>
        </td>
        <td>
        <? 
			combo::equipe($codequipe);
		?>
        </td>
        <td align="left"><label for="codequipe">Polo:</label></td>
		<td>
			<? 
                            if(empty($_SESSION['polo_pk'])){
                                combo::polo($cod_polo); 
                            }
                        
                        
                        ?>
		</td>
    </tr>	
    <tr>
        <td><label for="grupousuariointerno">Grupo de Usuário:</label></td>
        <td>
            <?	combo::grupo($codgrupousuariointerno);?>
        </td>
	<td align="left"><label for="codequipe">Mailing:</label></td>
	<td>
		<?combo::combo_mailing($mailing_pk);?>
	</td>    
    </tr>
    <tr>
        <td>
            Agendado para Operadora:
        </td>
        <td>
            <?
                if(permissao('agendamento_para_operadora', 'ic')){
                    $sql = "Select
                                o.cod_operador agenda_operador_pk
                                ,o.dsc_operador
                            from operador o";
                    $sql .="	inner join empresa_operador eo on o.cod_operador = eo.cod_operador";
                    if(!empty($_SESSION['cod_empresa'])){
                        $sql .=" where eo.cod_empresa=".$_SESSION['cod_empresa'];
                    }
                    $sql .=" group by o.dsc_operador"; 
                    
                    combo($sql,"agenda_operador_pk", $agenda_operador_pk, " ", " ");
                }                      
            ?>

        </td>
        <td>
            <label for="tamanha_visita"></label>Tamanho da Visita:</label>
        </td>
        <td>
                <?
                    $sql = "";
                    $sql.= "SELECT tv.pk cod_tamanho_visita, tv.dsc_tamanho_visita
                            FROM n_tamanho_visita tv
                           WHERE tv.dt_cancelamento IS NULL
                          ORDER BY tv.pk";
                    combo($sql,"cod_tamanho_visita", $cod_tamanho_visita, " ", "");      
             
                ?>
        </td>
    </tr>			
    <tr>
        <th colspan="4"><input type="submit" value="Filtrar" /></th>
    </tr>
</table>

<!--CALENDARIO -->
<table cellspacing="0" cellpadding="0" height=300  width="100%" border="1" class="form" >
	<tr class="grid">
        <td style="width:14%">Domingo</td>
        <td style="width:14%">Segunda</td>
        <td style="width:14%">Terça</td>
        <td style="width:14%">Quarta</td>
        <td style="width:14%">Quinta</td>
        <td style="width:14%">Sexta</td>
        <td style="width:14%">Sabado</td>        
    </tr>
 

<?	$dia = $dtinicio;
	$primeirasemana = true;
	while($dia != $dtfim){
        $qtdedia = 0;
		if(!empty($qtde[date('Ymd', $dia)])){
			$qtdedia = $qtde[date('Ymd', $dia)];
		}
		if(date('w', $dia) == 0){?>			
            <tr>
		<?}?>
            <td style="vertical-align:top;width:14%;<?=($dia == mktime(0, 0, 0)?"border:solid 2px red;":"");?>">
             	<a name="<?=date('Ymd', $dia);?>"></a>
    			<strong>
		<? if(date('n', $dia) != $mes){?>
            <a href="../../vendas/agenda/agenda.php?mes=<?=date('n', $dia);?>&ano=<?=date('Y', $dia);?><?=$filtro;?>#<?=date('Ymd', $dia);?>">
		<? }?>
            <span>
            	<?=date('d', $dia);?><?=(!$primeirasemana?'/'.substr($nomesemana[date('w', $dia)], 0, 3):null);?><?=(!empty($qtdedia)?' - '.$qtdedia . ' visita'.($qtdedia == 1?null:'s'):null);?>
            </span>
		<? if(date('n', $dia) != $mes){?>
            </a>
		<? }?>
		</strong>
		<?if(date('n', $dia) == $mes){if($qtdedia > 0){
		      $values = array();
		      foreach($agendas[date('Ymd', $dia)] as $horario => $horarios){
                foreach($horarios as $agenda){
                    $values[] = $agenda['CodAgendaLead'];     
                }
              }
              $values = implode(", ", $values);
              $dtvisita =  date('d/m/Y', $dia);
              ?>
                
  		       <a href="javascript:imprimeagenda('<?=$values;?>','<?=$dtvisita?>')"><img border=0 src='../../images/impressora.png' width=20 height=20 title='Imprimir Visita(s)' ></a>
    

          <?foreach($agendas[date('Ymd', $dia)] as $horario => $horarios){
                foreach($horarios as $agenda){
				        $reagendamento = null;
				        if(!empty($agenda['CodReagendamento']) && $agenda['CodStatus'] != 3)					
                            $reagendamento = 'retorno';
                  ?>           
                            <div class="agendamento <?=(!empty($agenda['CodStatus'])?'status' . $agenda['CodStatus']:null);?> <?=$reagendamento;?>">
                                <a name="<?=$agenda['CodAgendaLead'];?>"></a>
    					        <!--HORARIO E TIPO DA VISITA-->
                                
                                <?if(permissao('agenda', array('al', 'dt'))){?>						
                                    <a href="javascript:editarAgenda(<?=$agenda['CodAgendaLead'];?>)"><font face="verdana" size="3"><?=date('H:i', strtotime($agenda['DataHorario']));?></font></a>
                                    <!--<a href="../../vendas/leads/leadsagendanew.php?codagendalead=<?=$agenda['CodAgendaLead'];?>&lytebox=1" class="lytebox" data-lyte-options="width:700 height:700"><font face="verdana" size="3"><?=date('H:i', strtotime($agenda['DataHorario']));?></font></a>-->
                                    
                                <?}else{?>
    						      <b><?=date('H:i', strtotime($agenda['DataHorario']));?></b>
    					        <?}?>&nbsp;<b><?=$agenda['Tipo'];?></b>
                                <?
                                    //if(permissao('visualizar_operadora_visita', 'dt')){
                                        if(!empty($agenda['operador_pk'])){
                                            $sql="";
                                            $sql.="SELECT imagem
                                                        FROM operador o
                                                       WHERE o.cod_operador =".$agenda['operador_pk'];
                                            $result = sql_query($sql);                                        
                                            $row = mysql_fetch_array($result);

                                                echo "<img border=0 src='../../images/".$row['imagem']."' width=30 >";
                                        }
                                    //}
                                    
                                
                                ?>
                                <br />
                                <!--LINK RAZAO SOCIAL ENDERECO-->
        				        <?if(permissao('leads', 'dt')){?>
        					       <a href="../../vendas/leads/leadgerenciamentores.php?codlead=<?=$agenda['CodLead'];?>" title="<?=$agenda['RazaoSocial'];?>">
        				        <?}elseif(permissao('leads', 'al')){?>
        					       <a href="javascript:editarLead()" title="<?=$agenda['RazaoSocial'];?>">
        				        <?}?>                    
                                <!--ENDERECO -->
    				            <b><?=agenda::razao_social($agenda['RazaoSocial']);?></b><?= (!empty($agenda['cidade'])?' ('.capitalize($agenda['endereco']).','.capitalize($agenda['numero']).'-'.capitalize($agenda['Bairro']) .','.capitalize($agenda['complemento']) . " - " . $agenda['cep']. " - " . $agenda['cidade'] . ')':null);?>
        				        <?if(permissao('leads', array('dt', 'al'))){?>
        					       </a>
        				        <?}
                                echo "<br>";
                                echo "<b>Status Lead: </b>".$agenda['statuslead'];
                                echo "<br>";
                                if(!empty($agenda['GerenteConta'])){?>
        					       <strong>Consultor: </strong> <?
                                    if(!empty($agenda['CodAgendaLead'])){
                                        $consultor = array();
                                        $sql = "Select
                                                  ui.Nome as gerente
                                                from agendagerenteconta ag
                                                inner join usuariosinternos ui on ag.CodGerenteConta = ui.CodUsuarioInterno
                                                where ag.CodAgendaLead=".$agenda['CodAgendaLead'];
                                        
                                        $results = mysql_query($sql);
                                        while($rs = mysql_fetch_array($results)){
                                           $consultor[] = $rs['gerente'];     
                                        }
                                        $consultor = implode(" - ", $consultor);
                                        echo $consultor."<br>";            
                                    }
                                    mysql_free_result($results);
    			                }
                                
    			                if(!empty($agenda['AgendadoPor'])){?>
    				                <strong>Agendado por: </strong>
                                    <?
                                        echo $agenda['AgendadoPor'];
                                    ?><br/>
    			              <?}
    			                if(!empty($agenda['AgendadoPara']) && $agenda['AgendadoPara'] != $agenda['AgendadoPor']){?>
    				                <strong>Operadora: </strong><?=$agenda['AgendadoPara'];?><br/>
    			              <?}?>     
                              
    			              <a href='http://maps.google.com.br/maps?f=q&source=s_q&hl=pt-BR&geocode=&q=<?= $agenda['endereco'];?>, <?= $agenda['numero'];?>, <?= $agenda['cidade'];?> - <?= $agenda['uf'];?>' target="_new"><img border=0 src='../../images/google_maps_tr.png' width=20 height=20 title="Ver Mapa Google" ></a>
                              
                              <?// permissão de cadastrar auditoria
								//if(permissao('auditoria', 'ic')){ 
									//if(!empty($agenda['auditoria_pk'])){										
							  ?>
										<!--<a href="javascript:auditar_visita(<?=$agenda['CodAgendaLead'];?>,<?=$agenda['CodLead'];?>,<?=$agenda['auditoria_pk'];?>)"><font face="verdana" size="3"></font><img border=0 src='../../images/auditoria2.jpg' width=22 height=22 title="Auditar Visita" ></a>	-->					
                              <?	//}else{?>
										<!--<a href="javascript:auditar_visita(<?=$agenda['CodAgendaLead'];?>,<?=$agenda['CodLead'];?>,0)"><font face="verdana" size="3"></font><img border=0 src='../../images/auditoria2.jpg' width=22 height=22 title="Auditar Visita" ></a>-->
                              <?
								//}
                              //}?>                              
                              <?
                                //CLASSIFICACAO DA VISITA
                                if(empty($agenda['CodStatus'])){
                                    $acao = "ins";                                   
                                    //if((($acao == 'ins' && permissao('informacaovisita', 'ic')) || ($acao == 'upd' && permissao('informacaovisita', 'al')))){
                                    if(permissao('informacaovisita', 'ic')){    
                              ?>
                                        <a href="javascript:classificar_visita(<?=$agenda['CodAgendaLead'];?>,<?=$agenda['CodLead'];?>,<?=$agenda['CodTipo'];?>)"><img border=0 src='../../images/classificacao_visita.png' width=20 height=20 title="Classificar Visita" ></a>
                                        <!--<a href="../../vendas/leads/classifcacao_visita_cad_form.php?codagendalead=<?=$agenda['CodAgendaLead'];?>&codlead=<?=$agenda['CodLead'];?>&codtipo=<?=$agenda['CodTipo'];?>&lytebox=1" class="lytebox" data-lyte-options="width:700 height:300"><img border=0 src='../../images/classificacao_visita.png' width=20 height=20 title="Classificar Visita" ></a>-->
                              <?
                                        
                                    }
                                    if(permissao('agenda', 'ic')){    
                              ?>
                                        <a href="javascript:reagendavisita(<?=$agenda['CodAgendaLead'];?>,<?=$agenda['CodLead'];?>)"><font face="verdana" size="3"></font><img border=0 src='../../images/reagendamento.png' width=22 height=22 title="Reagendar Visita" ></a>
                                        <?
                                        
                                    }
                                }else if($agenda['CodStatus']==6){
                                    if(permissao('proposta', 'ic')){
										if($n_operadora==1){
                              ?>
                                 <img border=0 src='../../images/proposta1.png' width=20 height=20 title="Adicionar Proposta" onClick="add_new_proposta(<?=$agenda['CodLead'];?>,<?=$agenda['CodAgendaLead'];?>,<?=$operador_pk?>)">&nbsp;                                                                                   
                              <?
									}else{
							  ?>
                                  <a href="seleciona_proposta.php?leads_pk=<?=$agenda['CodLead'];?>&agendalead_pk=<?=$agenda['CodAgendaLead'];?>&operador_pk=<?=$operador_pk;?>" class="lytebox" data-lyte-options="width:500 height:100"><img border=0 src='../../images/proposta1.png' width=20 height=20 title="Nova Proposta" ></a>                                                 
                              <?			
									}	
                                    }
                                }
                              ?>
                              <a href="../../vendas/leads/leadhistoricoocorrencia.php?codlead=<?=$agenda['CodLead'];?>&lytebox=1" class="lytebox" data-lyte-options="width:950 height:400"><img border=0 src='../../images/People_012.gif' width=20 height=20 title="Histórico de Ocorrências" ></a>
		          	        </div>
                            
		              <?}
	           }
            }?>
        
        <?}?>		
&nbsp;	
	</td>
	<?=(date('w', $dia) == 6?'</tr>':null);?>
<?if(date('w', $dia) == 6)
$primeirasemana = false;
$dia = mktime(0, 0, 0, date('n', $dia), date('d', $dia) + 1, date('Y', $dia));
}?>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="grid">
	<tr>
		<td align="center">
			<a href="agenda.php?mes=<?=$mes;?>&ano=<?=$ano - 1;?><?=$filtro;?>">&#60;&#60; Ano</a>
		&nbsp;
		<a href="agenda.php?mes=<?=($mes == 1)?12:$mes - 1;?>&ano=<?=($mes == 1)?$ano - 1:$ano;?><?=$filtro;?>">&#60;&#60; Mês</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?=$nomemes[$mes].'/'.$ano;?>&nbsp;-&nbsp;
		<?=$qtde[str_pad($mes, 2, '0', STR_PAD_LEFT)] . ' Visita' . ($qtde[str_pad($mes, 2, '0', STR_PAD_LEFT)] == 1?null:'s');?>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="agenda.php?mes=<?=($mes == 12)?1:$mes + 1;?>&ano=<?=($mes == 12)?$ano + 1:$ano;?><?=$filtro;?>">Mês &#62;&#62;</a>
		&nbsp;
		<a href="agenda.php?mes=<?=$mes;?>&ano=<?=$ano + 1;?><?=$filtro;?>">Ano &#62;&#62;</a>
	</td>
</tr>
</table>		
</form>

<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" class="form">
	<tr>
		<td colspan="5"  align="center">Legenda</td>
	</tr>
	<tr>
    	<table width="1000" align="center"  class="form">
        	<tr>
                <td width="200" align="center" class="status1">Agendamento Produtivo</td>
                <td width="200" align="center" class="status2">Agendamento Improdutivo</td>
                <td width="280" align="center" class="status6">Aguardando conta para análise</td>
                <td width="200" align="center" class="status3">Reagendado</td>             
                <td width="200" align="center" class="status4">Cancelado</td>
        	<tr>
        </table>
	</tr>
</table>

</body>

</html>
<?	include_once "../../libs/desconectar.php";?>


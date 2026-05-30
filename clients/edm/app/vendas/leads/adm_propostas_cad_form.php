<?
include_once "../../libs/maininclude.php";
include_once "adm_propostas_cla.php";
include_once "../../libs/combo.php";


	
        $acao = $_REQUEST['acao'];
        $leads_pk = $_REQUEST['codlead'];
        $propostas_pk = $_REQUEST['pk'];
        $operador_pk = $_REQUEST['operador_pk'];
        $email_consultor = $_REQUEST['email_consutor'];
        $Consultor = $_REQUEST['Consultor'];
        $dsc_processo = $_REQUEST['dsc_processo'];
        $razaosocial = $_REQUEST['razaosocial'];
        $cnpj_cpf = $_REQUEST['cnpj_cpf'];
        $nomeusuario = $_REQUEST['nomeusuario'];
        $email_usuario = $_REQUEST['email_usuario'];


if(!empty($pk)){
    
        $adm_propostas = new adm_propostas($pk);
        $pk = $adm_propostas->getpk();
        $dt_cadastro = $adm_propostas->getdt_cadastro();
        $vl_obs_data = $adm_propostas->getdt_cadastro();
        $usuario_cadastro_nome_pk = $adm_propostas->getusuario_cadastro_nome_pk();
        $dt_ult_atualizacao = $adm_propostas->getdt_ult_atualizacao();
        $usuario_ult_atualizacao_nome_pk = $adm_propostas->getusuario_ult_atualizacao_nome_pk();	
        $n_pedido = $adm_propostas->getn_pedido();
        $vl_pedido = $adm_propostas->getvl_pedido();
        $email_consultor = $adm_propostas->getemail_consultor();
        $Consultor = $adm_propostas->getConsultor();
        $dsc_processo = $adm_propostas->getdsc_processo();
        $razaosocial = $adm_propostas->getrazaosocial();
        $cnpj_cpf = $adm_propostas->getcnpj_cpf();
        $nomeusuario = $adm_propostas->getnomeusuario();
        $email_usuario = $adm_propostas->getemail_usuario();
    
}

									
        $sql = "";
        $sql.= "SELECT p.pk
                       , l.RazaoSocial
                       ,l.cnpj_cpf
                       , ui.Nome Consultor
                       , ui1.Nome nome_bko
                       ,p.n_pedido
                       , p.vl_pedido
                       ,ui.email email_consultor
                FROM n_propostas p
               INNER JOIN leads l ON p.leads_pk = l.CodLead
               left JOIN usuariosinternos ui ON l.CodGerenteConta = ui.CodUsuarioInterno
               LEFT JOIN usuariosinternos ui1 ON p.bko_pk = ui1.CodUsuarioInterno
            WHERE p.pk =".$propostas_pk;
        $sql.=" AND l.CodLead =".$leads_pk;

        $result = sql_query($sql);
        $row = mysql_fetch_array($result);
        $razaosocial =  $row['RazaoSocial'];
        $cnpj_cpf =  $row['cnpj_cpf'];
        $Consultor =  $row['Consultor'];
        $n_pedido =  $row['n_pedido'];
        $vl_pedido =  $row['vl_pedido'];
        $email_consultor =  $row['email_consultor'];
        $bko =  $row['nome_bko'];
        $nomeusuario = $_SESSION['nomeusuario'];
        
        $sql = "";
        $sql.="select 
                    nome,
                    email email_usuario
                    from usuariosinternos
                    where CodUsuarioInterno=" .$_SESSION['codusuario'];
        $result = sql_query($sql);
        $row1 = mysql_fetch_array($result);
        $email_usuario = $row1['email_usuario'];
        

       

mysql_free_result($result);
										

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<!--Cabeçalho-->
		<title>Processo ADM</title>	
		<!--Include CSS-->
		<link rel="stylesheet" href="../../extras/public.css" type="text/css">
		<link rel="stylesheet" href="../../extras/lytebox.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
		<?	include_once "../../libs/head.php";?>	
		<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
		<script type="text/javascript" language="JavaScript" src="adm_propostas_cad_form.js"></script>
		<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
		<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
		
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
		<form name="dados" method="post" action="adm_propostas_cad_proc.php">
			<input type='hidden' name='acao' id='acao' value='' />
			<input type='hidden' name='propotas_pk' value='<?=$propostas_pk;?>' />	
			<input type='hidden' name='operador_pk' value='<?=$operador_pk;?>' />
			<input type="hidden" name="leads_pk" id="leads_pk" value="<?=$leads_pk;?>" />		
			<input type="hidden" name="email_consultor" id="email_consultor" value="<?=$email_consultor;?>" />		
			<input type="hidden" name="Consultor" id="Consultor" value="<?=$Consultor;?>" />		
			<input type="hidden" name="nomeusuario" id="nomeusuario" value="<?=$_SESSION['nomeusuario'];?>" />
			<input type="hidden" name="nomeusuario" id="nomeusuario" value="<?=$nomeusuario;?>" />
			<input type="hidden" name="email_usuario" id="email_usuario" value="<?=$email_usuario;?>" />
            <input type='hidden' name='dsc_processo' id='dsc_processo' value=<?=$dsc_processo;?> />
            <input type='hidden' name='razaosocial' id='razaosocial' value=<?=$razaosocial;?> />
            <input type='hidden' name='cnpj_cpf' id='cnpj_cpf' value=<?=$cnpj_cpf;?> />
			<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
				
				<tr>
					<td  class="titulo">
						 <font color="ffffff">Processo ADM</font>
					</td>
				</tr>
			</table>
			<table width="100%"  align="center" border="0" cellpadding="1" cellspacing="0" class="form">
				<tr>
					<td colspan=2>
						<table width="100%" cellpadding="1" cellspacing="0" class="form">
							<tr>					
								<td width="15%">
                                    &nbsp;Código Lead:
								</td>
								<td>
									<?=$leads_pk;?>
								</td>
							</tr>
							<tr>
								<td>
                                    &nbsp;Razão Social:
								</td>
								<td>
									<?=$razaosocial;?>
								</td>
							</tr>
                            <tr>
                                <td>
                                   &nbsp;Consultor:
                                </td>    
                                <td>
                                    <?=$Consultor;?>
                                </td>    
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;Back Office :
                                </td>
                                <td>
                                    <?=$bko;?>
                                </td>
                            </tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan=2>
						<table width='100%' border=0 none; cellpadding='1' cellspacing='1' >													
							<tr>
								<td>									
                                    <table width="100%"  border='1' bordercolor="#CCCCCC" align="center" cellpadding="0" cellspacing="0" >
                                        <tr>
                                            <td align="center" class="grid">
                                                Processo
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%"  border='0' bordercolor="#CCCCCC" align="center" cellpadding="0" cellspacing="0" >	
                                                    <tread>
                                                        <tr >
                                                            <td width="20%">
                                                                &nbsp;Processo ADM:
                                                            </td>
                                                            <td>
                                                                <?$sql = "SELECT 
                                                                              dpo.pk , 
                                                                              dpo.ds_data,
                                                                              dpo.n_ordem,
                                                                              dp.vl_data_proposta,
                                                                              dpo.statusclassificacaolead_pk,
                                                                              dp.vl_data_proposta,
                                                                              p.nome permissao
                                                                        FROM n_data_proposta_operador dpo
                                                                        left join paginas p on dpo.ds_data = p.nome
                                                                        left join n_datas_proposta dp on dpo.pk = dp.data_proposta_operador_pk  and dp.propostas_pk=".$propostas_pk;	
                                                                    $sql .="	 WHERE  dpo.operador_pk =".$operador_pk; 
                                                                    $sql .="   AND dpo.ic_tipo = 1
                                                                               AND dpo.dt_cancelamento IS NULL
                                                                               group by dpo.pk
                                                                        ORDER BY dpo.n_ordem";
                                                                    $result = sql_query($sql);										
                                                                     $v_vlr_data_anterior = "";
                                                                    echo "<select name='data_proposta_operador_pk' id='data_proposta_operador_pk'>";
                                                                    echo "<option value=''></option>";	 
                                                                     while($row = mysql_fetch_array($result)){

                                                                            $v_style = '';	

                                                                            if(!empty($row['vl_data_proposta'])){															 
                                                                                //$ds = 'disabled';                                                                        
                                                                            }else{																		
                                                                                if($row['statusclassificacaolead_pk']!='0'){
                                                                                    if(!empty($v_ordem)){														
                                                                                        if(!empty($v_vlr_data_anterior_classificacao)){
                                                                                            $ds = '';
                                                                                            //$v_style = "style='color:#009900'";
                                                                                        }else{
                                                                                            //$ds = 'disabled';		
                                                                                        }
                                                                                    }else{
                                                                                        $ds = '';
                                                                                        //$v_style = "style='color:#009900'";
                                                                                    }	
                                                                                }else{
                                                                                    $ds = '';
                                                                                   // $v_style = "style='color:#009900'";
                                                                                }																		
                                                                            }		
                                                                        //if(permissao($row['permissao'], 'ic')){    
                                                                            echo "<option value=".$row['pk']." ".$ds." ".$v_style.">".mb_strtoupper($row['ds_data'])."</option>";  
                                                                        //}
                                                                        $v_ordem = $row['n_ordem'];
                                                                        if($row['statusclassificacaolead_pk']!='0'){	
                                                                            $v_vlr_data_anterior_classificacao = $row['vl_data_proposta'];
                                                                        }															    
                                                                     }								 
                                                                    echo "</select>";											  
                                                                 ?>
                                                            </td>	
                                                        </tr>
                                                        <tr >
                                                            <td>
                                                                &nbsp;Data Processo:
                                                            </td>
                                                            <td>
                                                                <input class="input" id="vl_data" name="vl_data" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
                                                            </td>	
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                &nbsp;N Cotação:
                                                            </td>
                                                            <td>
                                                                <?
                                                                  $disabled = 'disabled';
                                                                 // if(permissao($row['n_pedido_operadora'], 'ic')){  
                                                                     $disabled = ''; 
                                                                  //}  
                                                                ?>
                                                                <input type="text" size="20" <?=$disabled?> maxlength="30" name="n_pedido" id="n_pedido" value="<?=$n_pedido;?>"></input>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%">
                                                                &nbsp;Valor da Cotação:
                                                            </td>
                                                            <td>                                                                
                                                                <?
                                                                  $disabled = 'disabled';
                                                                     $disabled = ''; 
                                                                ?>
                                                                <input type="text" size="12" <?=$disabled?>  maxlength="12" name="vl_pedido" id="vl_pedido" value="<?=$vl_pedido;?>" onkeypress='mascara(this,Valor)'></input>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Descrição:
                                                            </td>
                                                            <td>
                                                                <textarea id="vl_obs_data" name="vl_obs_data" style="width:50%" rows="5" cols="20"></textarea>
                                                            </td>	
                                                        </tr>    
                                                    </tread>  
                                                    <tr>
                                                        <td>
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan=2 align="center">
                                                            <input type='button' value='Incluir Item' onclick='enviar();' />
                                                        </td>												
                                                    </tr>
                                                </table>
                                            </td>    
                                        </tr>                                        
                                    </table>
								</td>
							</tr>	
                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                            </tr>
  							<tr>
								<td colspan=2>
									<table width="100%"  border='1' bordercolor="#CCCCCC" align="center" cellpadding="0" cellspacing="0" >									
										<tr>
                                            <td colspan="5" align="center" class="grid">
                                                Histórico
                                            </td>
                                        </tr>
                                        <tr class="grid">
											<th width="250px" nowrap="true">
												Item
											</th>
											<th  nowrap="true">
												Dt Processo
											</th>
											<th  nowrap="true">
												Observação
											</th>	
											<th  nowrap="true">
												User Cadastro
											</th>	
											<th  nowrap="true">
												Dt Cadastro
											</th>							
											<!--<td width="30px" nowrap="true">
												Ação
											</td>-->
										</tr>										
										<tbody id="tbl_processo_datas_proposta">
											<?
												$sql ="Select
															ndp.pk,
															ndp.vl_data_proposta, 
															ndp.vl_obs_data,
															ndp.data_proposta_operador_pk,
															ndpo.ds_data,
															DATE_FORMAT(ndp.vl_data_proposta, '%d/%m/%Y') vl_data,
															ui.nome,
															DATE_FORMAT(ndp.dt_cadastro, '%d/%m/%Y') dtcadasro 
														from n_datas_proposta ndp
															inner join n_data_proposta_operador ndpo on ndp.data_proposta_operador_pk = ndpo.pk
															inner join usuariosinternos ui on ndp.usuario_cadastro_pk = ui.CodUsuarioInterno
														where  ic_tipo = 1
														and ndp.propostas_pk=".$propostas_pk;
												 $sql.=" Order by ndp.vl_data_proposta,ndp.dt_cadastro desc";
												$result = sql_query($sql);											
												while($row = mysql_fetch_array($result)){		
											?>
												<tr>
													<td align="center" width="230px" nowrap="true">
														<?=$row['ds_data'];?>																	
													</td>
													<td align="center" nowrap="true">
														<?=$row['vl_data'];?>
													</td>
													<td align="center" nowrap="true">
														<?=str_replace(chr(13), '<br />', htmlentities($row['vl_obs_data']));?>
													</td>	
													<td align="center" nowrap="true">
														<?=$row['nome'];?>
													</td>	
													<td align="center" nowrap="true">
														<?=$row['dtcadasro'];?>
													</td>							
												</tr>	
											<?}
											?>	
										</tbody>
									</table>									
								</td>
							</tr>	
                            <tr>
                            <td colspan="2">
                                &nbsp;
                            </td>
                        </tr>								
                    </table>			
                </form>
            </body>
        </html>
<?include_once "../../libs/desconectar.php";?>
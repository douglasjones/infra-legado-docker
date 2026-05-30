<?
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.combo.php";
include_once( "../../libs/cla.comboajax.php" ) ;
ini_set('default_charset','ISO-8859-1');  
//include_once "email_cla.php";

$acao = $_REQUEST['acao'];
$pk = $_REQUEST['pk'];

if(!empty($pk)){
	$n_email = new n_email($pk);
	$pk = $n_email->getpk();
	$dt_cadastro = $n_email->getdt_cadastro();
	$usuario_cadastro_nome_pk = $n_email->getusuario_cadastro_nome_pk();
	$dt_ult_atualizacao = $n_email->getdt_ult_atualizacao();
	$usuario_ult_atualizacao_nome_pk = $n_email->getusuario_ult_atualizacao_nome_pk();
	//$ds_mailing,email_modelo_pk = $n_email->getds_mailing,email_modelo_pk();

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<!--Cabe�alho-->
	<title>n_email</title>
	<!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
	<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
        <script type="text/javascript" language="JavaScript" src="email_cad_form.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form name="dados" method="post" action="email_cad_proc.php">
<input type='hidden' name='acao' id='acao' value='' />
<input type='hidden' name='pk' value='<?= $pk;?>' />
<input type='hidden' name='strEmails' id='strEmails'  />
<input type='hidden' name='codcontato' id='codcontato'  />

<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
    <tr>
        <td  class="titulo">
            Enviar E-mails
        </td>
    </tr>
</table>
<table width="95%" height="60" border="0"  align="center" border="0" cellpadding="1" cellspacing="1" class="modulo">           
    <tr>
        <td align="center">
            <table width="60%" class="modulo1"   align="center" border="0" cellpadding="1" cellspacing="1" >
                <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>
                <tr>                    
                    <td colspan="2" align="center">
                        Mailing 
                        <?	
                        $sql = "Select
                                l.Mailing
                                ,l.Mailing dsc_mailing
                                from leads l
                                inner join contatoslead cl on l.codlead = cl.codlead
                                where cl.email is not null
                                and cl.email <>''
                                Group by l.Mailing ";
                        combo($sql,"Mailing", $_REQUEST['Mailing'], "", "");
                    ?>
                    </td>
                </tr>
                <tr>
                   
                    <td colspan="2" align="center">
                        Modelo
                    <?	
                        $sql = "SELECT em.pk , em.ds_nome_modelo FROM email_modelo em ";
                        combo($sql,"email_modelo_pk", $_REQUEST['email_modelo_pk'], " ", "");
                    ?>
                    </td>
                </tr>
                <tr>                   
                    <td colspan="2" align="center">
                        Qtde
                        <input type="text" name="qtde" id="qtde" value="<?=$_REQUEST['qtde'];?>">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr> 
                <tr>
                    <td colspan="2" align="center">
                        <input type="Button" class="botao" value="Pesquisar" onclick="pesq_mailing()" />  
                        <input type="Button" class="botao" value="Selecionar Todos" onclick="selecionar()" /> 
                    </td>
                                                   
                </tr>
                <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="Button" class="botao" value="Enviar E-mail Best" onclick="enviar()" />  
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>
                 <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="Button" class="botao" value="Enviar_E-mail_Gepros" onclick="enviarGepros()" />  
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        &nbsp;
                    </td>
                </tr>

            </table>   
            <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                <tr>
                    <td  class="titulo">
                        Lista de E-mails
                    </td>
                </tr>
            </table>
            <table width="100%" class="modulo1"   align="center" border="0" cellpadding="1" cellspacing="1" >
                <tr>
                    <td colspan="2">
                        <table class="borda_tabela" width="100%" align="center"  id="dados" border="1" cellpadding="0"  cellspacing="0" >                            
                            <tr class="font_grid">
                                <td align="center">#</td>
                                 <td align="center">
                                    Qtde
                                </td>
                                <td align="center">
                                    C�digo
                                </td>
                                <td align="center">
                                    Lead
                                </td>		
                                <td align="center">
                                    Email
                                </td> 
                                <td align="center">
                                    DT Ult Envio
                                </td> 
                                <td align="center">
                                    A��o
                                </td>  
                            </tr>
                            <tbody id="tbl">
                            <?php                                
                                if(!empty($_REQUEST['Mailing'])){
                                  
                                    $sql ="";
                                    $sql.="Select
                                            l.CodLead,
                                            l.RazaoSocial,
                                            cl.Email,
                                            cl.CodContatoLead                                            
                                            from leads l
                                            inner join contatoslead cl on l.CodLead = cl.CodLead   
                                            
                                            where l.Mailing = '".$_REQUEST['Mailing']."'";                                    
                                    $sql.=" and cl.Email not in (Select emails_enviados.ds_email from emails_enviados where emails_enviados.modelo_envio_pk='".$_REQUEST['email_modelo_pk']."' )";
                                    $sql.=" and cl.Email is not null    
                                            group by cl.Email
                                            order by  l.RazaoSocial";
                                    if($_REQUEST['qtde']!=''){
                                        $sql.=" limit ".$_REQUEST['qtde'];
                                    }
                                   
                                $v = 0;
                                $q = 1;
                                $result = mysql_query($sql);
                                while($row = mysql_fetch_array($result)){
                            ?>
                                    <tr class="font_grid">
                                        
                                        <td align="center">
                                            <input type="checkbox" value="<?php echo $row['Email'];?>" name="codcontatolead<?php echo $v;?>" id="codcontatolead<?php echo $v;?>">
                                            <input type="hidden" value="<?php echo $row['CodContatoLead'];?>" name="codcontatolead<?php echo $v;?>" id="codcontatolead<?php echo $v;?>">    
                                        </td>
                                        <td align="center">
                                              <?php echo $q;?>
                                             
                                        </td>
                                        <td align="center">
                                              <?php echo $row['CodLead'];?>
                                              <input type="hidden" value="<?php echo $row['CodLead'];?>" name="codlead<?php echo $v;?>" id="codlead<?php echo $v;?>">
                                        </td>
                                        <td align="center">
                                              <?php echo $row['RazaoSocial'];?>
                                        </td>		
                                        <td align="center">
                                              <?php echo $row['Email'];?>
                                        </td>                               			
                                        <td align="center">
                                              <?php 
                                                $sql ="";
                                                $sql.="SELECT date_format(ee.dt_envio, '%d/%m/%Y %H:%i:%s') dt_cadastro
                                                        FROM emails_enviados ee INNER JOIN emails e ON ee.emails_pk = e.pk
                                                        WHERE ee.codlead =".$row['CodLead'];
                                                $sql.=" and ee.modelo_envio_pk=".$_REQUEST['email_modelo_pk'];        
                                             
                                                $results = mysql_query($sql);
                                                $rows = mysql_fetch_array($results);
                                                echo $rows['dt_cadastro'];
                                                mysql_free_result($results);
                                              ?>
                                        </td>
                                        <td align="center">
                                            <input type="Button" class="botao" value="Excluir Lead" onclick="excluir(<?php echo $row['CodContatoLead'];?>)" /> 
                                        </td>                                        
                                    </tr>
                            
                            <?php
                                $v ++;
                                $q ++;
                                }
                                mysql_free_result($result);
                             }
                            ?>
                            </tbody>
                        </table>    
                    </td>
                </tr>                
            </table>
        </td>		
    </tr> 
</table>  
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

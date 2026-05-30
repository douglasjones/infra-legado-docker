<?php
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.leads.php";
include_once "classifcacao_visita_cla.php";
include_once "../../libs/combo.php";	
$acao = $_REQUEST['acao'];
$agenda_visita_pk = $_REQUEST['codagendalead'];
$leads_pk = $_REQUEST['codlead'];
$cod_tipo = $_REQUEST['codtipo']; 

if(!empty($pk)){
	$classifcacao_visita = new classifcacao_visita($pk);
	$pk = $classifcacao_visita->getpk();
	$dt_cadastro = $classifcacao_visita->getdt_cadastro();
	$usuario_cadastro_nome_pk = $classifcacao_visita->getusuario_cadastro_nome_pk();
	$dt_ult_atualizacao = $classifcacao_visita->getdt_ult_atualizacao();
	$usuario_ult_atualizacao_nome_pk = $classifcacao_visita->getusuario_ult_atualizacao_nome_pk();
	$agenda_visita_pk = $classifcacao_visita->getagenda_visita_pk();
        $leads_pk = $classifcacao_visita->getleads_pk();
        $termino_visita = $classifcacao_visita->gettermino_visita();
        $status_classificacao_pk = $classifcacao_visita->getstatus_classificacao_pk();
        $descricao = $classifcacao_visita->getdescricao();
        $motivo_sem_interesse_pk = $classifcacao_visita->getmotivo_sem_interesse_pk();
        $qtde_linhas = $classifcacao_visita->getqtde_linhas();
        $vencimento_contrato = $classifcacao_visita->getvencimento_contrato();
        $operadoras_pk = $classifcacao_visita->getoperadoras_pk();
}

?>
<html>
    <head>
        <meta charset="iso-8859-1">
        <title>Classificação da Visita | Gepros</title>   
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="description" content="">
        <meta name="keywords" content="coco bootstrap template, coco admin, bootstrap,admin template, bootstrap admin,">
        <meta name="author" content="Huban Creative">

        <!-- Base Css Files -->
        <link href="../../assets/libs/jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
        <link href="../../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../../assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
        <link href="../../assets/libs/fontello/css/fontello.css" rel="stylesheet" />
        <link href="../../assets/libs/animate-css/animate.min.css" rel="stylesheet" />
        <link href="../../assets/libs/nifty-modal/css/component.css" rel="stylesheet" />
        <link href="../../assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" /> 
        <link href="../../assets/libs/ios7-switch/ios7-switch.css" rel="stylesheet" /> 
        <link href="../../assets/libs/pace/pace.css" rel="stylesheet" />
        <link href="../../assets/libs/sortable/sortable-theme-bootstrap.css" rel="stylesheet" />
        <link href="../../assets/libs/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
        <link href="../../assets/libs/jquery-icheck/skins/all.css" rel="stylesheet" />
        <!-- Code Highlighter for Demo -->
        <link href="../../assets/libs/prettify/github.css" rel="stylesheet" />        
                <!-- Extra CSS Libraries Start -->
        <link href="../../assets/css/style.css" rel="stylesheet" type="text/css" />
                <!-- Extra CSS Libraries End -->
        <link href="../../assets/css/style-responsive.css" rel="stylesheet" />
        <link href="../../assets/libs/bootstrap-validator/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />      
        <link href="../../assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="../../assets/css/style-responsive.css" rel="stylesheet" />
        <link rel="shortcut icon" href="../../assets/img/favicon.ico">
<?	include_once "../../libs/head.php";?>
    </head>
    <body class="fixed-left" >
        <div class="content">
           <!--<div class="page-heading">
            	<h1><i class='fa fa-bars'></i>Classificação da Visita</h1>
            </div>-->
                       

                    <div class="widget">
                        <div class="widget-header transparent">
                            <h2>Agendamento - <strong>Classificação da visita</strong></h2>
                        </div>
                        <div class="widget-content padding">							
                            <div id="basic-form">
                      
                                    <form name="dados" method="post" action="classifcacao_visita_cad_proc.php" class="form-horizontal">    
                                        <input type='hidden' name='acao' id='acao' value='' />                                   
                                        <input type='hidden' id='agenda_visita_pk' name='agenda_visita_pk' value='<?=$agenda_visita_pk;?>' />
                                        <input type='hidden' id='leads_pk' name='leads_pk' value='<?=$leads_pk;?>' />
                                        <input type='hidden' id='codtipo' name='codtipo' value='<?=$cod_tipo;?>' />
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Termino da Visita</label>
                                            <div class="col-sm-4">
                                               <input type="text" class="formulario_imput_text" name="termino" id="termino" size="5" maxlength="5" onkeypress="return horamask2(this,event)">
                                            </div>
                                        </div>                                      
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Classificação da visita</label>
                                            <div class="col-sm-3" >                                               
                                                <?	
                                                $sql  = "SELECT CodStatus ,
                                                                Descricao
                                                           FROM statusagendamento
                                                          WHERE CodStatus NOT IN ( 3 , 4 , 5 ,6)
                                                       ORDER BY Descricao desc" ;

                                                combo( $sql , "codstatus" , $agenda['CodStatus'] , " " , "onchange='seleciona_itens(this.value);' class='form-control' " ) ; 	
                                                ?>
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            <div id="div_seleciona_operadora"   style="display: none;">                                                
                                                <div class="widget-header transparent">
                                                    <h2>Agendamento - <strong>Gerar Proposta</strong></h2>
                                                </div>
                                                <label class="col-sm-3 control-label">Qual a operadora ?</label>
                                                                                             
                                                   <?     
                                                        $sql = "Select
                                                                    o.cod_operador operador_pk
                                                                    ,o.dsc_operador
                                                                from operador o";
                                                        $sql .="	inner join empresa_operador eo on o.cod_operador = eo.cod_operador";
                                                        if(!empty($_SESSION['cod_empresa'])){
                                                            $sql .=" where eo.cod_empresa=".$_SESSION['cod_empresa'];
                                                        }
                                                        $sql .=" group by o.dsc_operador";
                                                        $result = sql_query($sql);
                                                        $contador = "0";
                                                        while($row = mysql_fetch_array($result)){

                                                    ?>   
                                                        <div class="col-sm-2" >  
                                                               <?=$row['dsc_operador']?> <input type='radio' name='operador_pk' id='operador_pk_<?=$contador;?>' value='<?=$row['operador_pk'];?>' <?if($row['operador_pk']==$agenda['operador_pk']){echo "checked='checked'";}?> >&nbsp;
                                                        </div>        
                                                    <?  
                                                            $contador ++;
                                                        }
                                                        mysql_free_result($result);
                                                    ?>
                                                    <input type="hidden" id="qtde_operador" name="qtde_operador" value="<?=$contador;?>"> 
                                                                                               
                                            </div>                                             
                                        </div>  
                                        <div class="form-group">
                                            <div id="div_formulario_seminteresse"   style="display: none;">
                                                
                                                <div class="widget-header transparent">
                                                    <h2>Agendamento - <strong>Sem Interesse</strong></h2>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Motivo Sem Interesse</label>
                                                    <div class="col-sm-5" >                                               
                                                        <?	
                                                                $sql = "Select m.* ";
                                                                $sql .= " from motivoslead m ";
                                                                $sql .= " Order By m.Descricao ";
                                                                combo($sql, "codmotivolead", $codmotivolead, " ", "class='form-control'");
                                                        ?>
                                                    </div>
                                                </div>    
                                                 <?
                                                        $sql = "Select 
                                                                l.codlead
                                                                ,DATE_FORMAT(l.VencimentoContrato, '%Y-%m-%d') as datavencimento
                                                                ,qtde_linhas
                                                              from leads l
                                                              where l.codlead=".$codlead;

                                                            $rs = mysql_query($sql);
                                                            $row_rs = mysql_fetch_array($rs);
                                                            $dt_vencimento= $row_rs["datavencimento"];
                                                            $qtde_linha= $row_rs["qtde_linhas"];
                                                            mysql_free_result($rs);

                                                            if(!empty($dt_vencimento)){?>								
                                                                <input type="hidden" name="vencimento_contrato" value="<?=$dt_vencimento;?>" />			
                                                            <?}
                                                    ?>
                                            </div>  
                                            <div id="div_dados_operadoras"   style="display: none;">                                                
                                                    <form class='form-horizontal' role='form'>                                                    
                                                        <table id="datatables-1" class="table table-striped table-bordered" cellspacing="0" width="75%">
                                                            <tr class="titulo">
                                                                <th align="center">Item</th>
                                                            <?
                                                                $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                                        FROM operadoras op
                                                                             LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                                             where op.cod_operadora not in(7,8)
                                                                        GROUP BY op.dsc_operadora";

                                                                $result = sql_query($sql);
                                                                $v_coluna = "";
                                                                while($row = mysql_fetch_array($result)){

                                                            ?>
                                                                <th >
                                                                    <?=$row['dsc_operadora'];?>
                                                                </th>   
                                                            <?
                                                                $v_coluna ++;
                                                                }
                                                                mysql_free_result($result);
                                                            ?>
                                                            </tr>
                                                            <tr class="titulo">
                                                                <th align="center">Cliente</th>                       
                                                                <?
                                                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                                        FROM operadoras op
                                                                             LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                                             where op.cod_operadora not in(7,8)
                                                                        GROUP BY op.dsc_operadora";

                                                                    $result = sql_query($sql);
                                                                    $v_coluna = "";
                                                                    $cliente_operadora_pk ="";
                                                                    while($row = mysql_fetch_array($result)){
                                                                        $sql ="";
                                                                        $sql.="SELECT nldc.lead_cliente
                                                                                FROM n_leads_dados_cliente nldc
                                                                               WHERE nldc.leads_pk =".$leads_pk;  
                                                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                                                        $results = sql_query($sql);    
                                                                        $rows = mysql_fetch_array($results);
                                                                        $cliente_operadora_pk = $rows['lead_cliente']; 
                                                                        mysql_free_result($results);


                                                                ?>
                                                                    <td align="center">
                                                                        <select name="<?$row['dsc_operadora']?>"  id="<?$row['dsc_operadora']?>" class='form-control' onchange="cliente(this.value,<?=$row['cod_operadora'];?>,<?=$leads_pk;?>)">

                                                                            <option value=""></option>

                                                                            <option value="1" <?if($cliente_operadora_pk=='1'){echo "selected";}?>>Sim</option>
                                                                            <option value="2" <?if($cliente_operadora_pk=='2'){echo "selected";}?> >Não</option>
                                                                        </select>
                                                                    </td>   
                                                                <?

                                                                    $v_coluna ++;
                                                                    }
                                                                    mysql_free_result($result);
                                                                ?>
                                                            </tr>                                                          
                                                            
                                                            <tr class="titulo">
                                                                <th>DT Venc Contrato</th>                                                                                      
                                                                <?
                                                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                                        FROM operadoras op
                                                                             LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                                             where op.cod_operadora not in(7,8)
                                                                        GROUP BY op.dsc_operadora";
                                                                    $result = sql_query($sql);
                                                                    $dt_vencimento = "";
                                                                    while($row = mysql_fetch_array($result)){
                                                                        $sql ="";
                                                                        $sql.="SELECT DATE_FORMAT(nldc.dt_vencimento, '%d/%m/%Y') dt_vencimento
                                                                                FROM n_leads_dados_vencimento nldc
                                                                               WHERE nldc.leads_pk =".$leads_pk;  
                                                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                                                        $results = sql_query($sql);    
                                                                        $rows = mysql_fetch_array($results);
                                                                        $dt_vencimento = $rows['dt_vencimento']; 
                                                                        mysql_free_result($results);

                                                                ?>
                                                                    <td >
                                                                        <div class="col-sm-3" >  
                                                                            <input class="input" value="<?=$dt_vencimento;?>" id="dt_vencimento" name="dt_dt_vencimento" size="12" maxlength="10" onkeypress="mascara(this,datamask)"  onblur="vencimento_contrato(this.value,<?=$row['cod_operadora'];?>,<?=$leads_pk;?>)">
                                                                        </div>
                                                                    </td>   
                                                                <?
                                                                    $v_coluna ++;
                                                                    }
                                                                    mysql_free_result($result);
                                                                ?>
                                                            </tr>
                                                            <tr class="titulo">
                                                                <th>Qtde de linhas voz</th>                                                                        
                                                                <?
                                                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                                        FROM operadoras op
                                                                             LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                                             where op.cod_operadora not in(7,8)
                                                                        GROUP BY op.dsc_operadora";
                                                                    $result = sql_query($sql);
                                                                    $dt_vencimento = "";
                                                                    while($row = mysql_fetch_array($result)){
                                                                        $sql ="";
                                                                        $sql.="SELECT nldc.qtde_voz
                                                                                FROM n_leads_qtde_voz nldc
                                                                               WHERE nldc.leads_pk =".$leads_pk;  
                                                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                                                        $results = sql_query($sql);    
                                                                        $rows = mysql_fetch_array($results);
                                                                        $qtde_voz = $rows['qtde_voz']; 
                                                                        mysql_free_result($results);

                                                                ?>
                                                                    <td >
                                                                        <div class="col-sm-3" >  
                                                                            <input type="text" class="input" value="<?=$qtde_voz;?>" id="qtde_voz" name="qtde_voz" size="3" maxlength="5"  onblur="qtde_voz_lead(this.value,<?=$row['cod_operadora'];?>,<?=$leads_pk;?>)">
                                                                        </div>
                                                                    </td>   
                                                                <?
                                                                    $v_coluna ++;
                                                                    }
                                                                    mysql_free_result($result);
                                                                ?>
                                                            </tr> 
                                                            <tr class="titulo">
                                                                <th>Qtde de linhas Dados</th>                                                                                        
                                                                <?
                                                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                                                        FROM operadoras op
                                                                             LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                                             where op.cod_operadora not in(7,8)
                                                                        GROUP BY op.dsc_operadora";
                                                                    $result = sql_query($sql);
                                                                    $dt_vencimento = "";
                                                                    while($row = mysql_fetch_array($result)){
                                                                        $sql ="";
                                                                        $sql.="SELECT nldc.qtde_dados
                                                                                FROM n_leads_qtde_dados nldc
                                                                               WHERE nldc.leads_pk =".$leads_pk;  
                                                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                                                        $results = sql_query($sql);    
                                                                        $rows = mysql_fetch_array($results);
                                                                        $qtde_dados = $rows['qtde_dados']; 
                                                                        mysql_free_result($results);

                                                                ?>
                                                                    <td align="center">
                                                                        <div class="col-sm-3" >  
                                                                            <input type="text" class="input" value="<?=$qtde_dados;?>" id="qtde_dados" name="qtde_dados" size="3" maxlength="5"  onblur="qtde_dados_lead(this.value,<?=$row['cod_operadora'];?>,<?=$leads_pk;?>)">
                                                                        </div>
                                                                    </td>   
                                                                <?
                                                                    $v_coluna ++;
                                                                    }
                                                                    mysql_free_result($result);
                                                                ?>
                                                            </tr>  
                                                        </table>    
                                                    </form>  
                                                    
                                            </div>    
                                 
                                        <div class="form-group">
                                            <br>
                                            <label class="col-sm-3 control-label">Observação</label>
                                            <div class="col-sm-5" >                                               
                                                <textarea class="formulario_textarea"  rows="5" id="informacoes1" name="informacoes1" style="width:99%" validate="required"><?=$agenda['Informacoes'];?></textarea>
                                            </div>
                                        </div>                                          
                                            <div id="div_botao_seminteresse" class="botao_div" align="center" style="display: none;">   
                                                <div class="form-group">
                                                <button type="button" class="btn btn-primary" onclick="enviar();"  >Enviar</button>
                                                <button type="button" class="btn btn-primary" onclick="self.close()"  >Fechar</button>
                                                </div>
                                            </div>
                                            <div id="div_botao_proposta" class="botao_div" align="center" style="display: none;">   
                                                <div class="form-group">
                                                <button type="button" class="btn btn-primary" onclick="add_new_proposta();"  >Enviar</button>
                                                <button type="button" class="btn btn-primary" onclick="self.close()"  >Fechar</button>  
                                                </div>
                                            </div>   
                                    </form>
                            </div>
                        </div>
                    </div>

                
        
            <!--</div>-->
        </div>
        <div class="md-overlay"></div>
	<!-- End of eoverlay modal -->
	<script>
		var resizefunc = [];
	</script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../../assets/libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="../../assets/libs/bootstrap/js/bootstrap.min.js"></script>
	<script src="../../assets/libs/jqueryui/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="../../assets/libs/jquery-ui-touch/jquery.ui.touch-punch.min.js"></script>
	<script src="../../assets/libs/jquery-detectmobile/detect.js"></script>
	<script src="../../assets/libs/jquery-animate-numbers/jquery.animateNumbers.js"></script>
	<script src="../../assets/libs/ios7-switch/ios7.switch.js"></script>
	<script src="../../assets/libs/fastclick/fastclick.js"></script>
	<script src="../../assets/libs/jquery-blockui/jquery.blockUI.js"></script>
	<script src="../../assets/libs/bootstrap-bootbox/bootbox.min.js"></script>
	<script src="../../assets/libs/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="../../assets/libs/jquery-sparkline/jquery-sparkline.js"></script>
	<script src="../../assets/libs/nifty-modal/js/classie.js"></script>
	<script src="../../assets/libs/nifty-modal/js/modalEffects.js"></script>
	<script src="../../assets/libs/sortable/sortable.min.js"></script>
	<script src="../../assets/libs/bootstrap-fileinput/bootstrap.file-input.js"></script>
	<script src="../../assets/libs/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="../../assets/libs/bootstrap-select2/select2.min.js"></script>
	<script src="../../assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script> 
	<script src="../../assets/libs/pace/pace.min.js"></script>
	<script src="../../assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../../assets/libs/jquery-icheck/icheck.min.js"></script>	<!-- Demo Specific JS Libraries -->
	<script src="../../assets/libs/prettify/prettify.js"></script>
       <script src="jquery-2.1.4.min.js"></script>
       <script src="jquery.validate.min.js"></script>
       
       <link rel="stylesheet" type="text/css" href="extras/datepicker.css" />
	<!-- Page Specific JS Libraries -->

        <script src="classifcacao_visita_cad_form.js"></script>

        <script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>

    </body>
</html>     



<?
    include_once("../../libs/mpdf/mpdf.php");
	include_once '../../libs/conectar.php';
	
	conectar();
 

	$leads_pk  =   $_REQUEST['codlead'];
	$proposta_pk = $_REQUEST['pk'];
    
     $sql ="";
     $sql.="SELECT 
                e.razao_social
               ,e.enviar_agenda_email_pk
               ,e.origem_email_agendamento_pk
               ,e.agenda_email
               ,e.enviar_proposta_email_pk
               ,e.origem_email_proposta_pk
               ,e.proposta_email
           FROM empresa e";
    $results = mysql_query($sql);
    $row1 = mysql_fetch_array($results);
    
    
    
	$sql = "";
	$sql.="SELECT dsc_operador,
			   nom.dsc_titulo,
			   nom.dsc_proposta,
			   e.cidade,
			   nom.dsc_rodape,
			   np.trade_in,
			   np.vl_total_proposta,
			   DATE_FORMAT(np.dt_validade, '%d/%m/%Y') dt_validade,
			   l.razaosocial,
               l.CNPJ_CPF,
               l.ddd,
               l.tel,
               cl.nomecontato,
               cl.ddd_fone,
               cl.fone,
               cl.email email_contato,
               eo.cod_operador,
               cl.nomecontato
            FROM operador o
			   INNER JOIN n_propostas np ON o.cod_operador = np.operador_pk
			   left join leads l on np.leads_pk = l.codlead
               left join contatoslead cl on l.codlead = cl.codlead
			   INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
			   LEFT JOIN empresa e ON eo.cod_empresa = e.cod_empresa			   
			   LEFT JOIN n_operador_modelo_proposta nom ON o.cod_operador = nom.operador_pk
            WHERE np.pk =".$proposta_pk;
    
		if(!empty($_SESSION['cod_polo'])){		
			$sql.=" AND cod_polo =".$_SESSION['cod_polo'];
		}
        
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
        
		$v_operadora = $row['dsc_operador'];
		$v_titulo = $row['dsc_titulo'];
		$v_dsc_proposta = $row['dsc_proposta'];
        $v_cidade = $row['cidade'];
		$v_dsc_rodape = $row['dsc_rodape'];
		$bgcolor="bgcolor='#CCCCCC'";
		$vl_total_proposta = $row['vl_total_proposta'];
		$dt_validade = $row['dt_validade'];
		$razaosocial = $row['razaosocial'];
        $cnpj_cpf = $row['CNPJ_CPF'];
        $ddd = $row['ddd'];
        $tel = $row['tel'];
        $nomecontato = $row['nomecontato'];
        $ddd_fone = $row['ddd_fone'];
        $fone = $row['fone'];
        $email_contato = $row['email_contato'];
        $operador_pk = $row['cod_operador'];
        $nomecontato = $row['nomecontato'];
        
	mysql_free_result($result);
    
    
?>
        <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
		<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
		<?	include_once "../../libs/head.php";?>		
		<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
		<script type="text/javascript" language="JavaScript" src="propostas_cad_form.js"></script>
		<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
		<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
        <form name="dados" method="post" action="propostas_cad_proc.php">     
        <input type="hidden" name="leads_pk" id="leads_pk" value="<?=$leads_pk;?>" />
        <input type="hidden" name="operador_pk" id="operador_pk" value= "<?=$operador_pk;?>" /> 
        <input type="hidden" name="email_contato" id="email_contato" value= "<?=$email_contato;?>" /> 
        <input type="hidden" name="nomecontato" id="nomecontato" value= "<?=$nomecontato;?>" /> 
        <input type="hidden" name="razaosocial" id="razaosocial" value= "<?=$razaosocial;?>" /> 
        <input type="hidden" name="acao" id="acao" value= "" /> 
        

 <?

   
	    
    $data = date('D');

    $mes = date('M');

    $dia = date('d');

    $ano = date('Y');

 

    $semana = array(

        'Sun' => 'Domingo', 

        'Mon' => 'Segunda-Feira',

        'Tue' => 'Terca-Feira',

        'Wed' => 'Quarta-Feira',

        'Thu' => 'Quinta-Feira',

        'Fri' => 'Sexta-Feira',

        'Sat' => 'Sábado'

    );

 

    $mes_extenso = array(

        'Jan' => 'Janeiro',

        'Feb' => 'Fevereiro',

        'Mar' => 'Marco',

        'Apr' => 'Abril',

        'May' => 'Maio',

        'Jun' => 'Junho',

        'Jul' => 'Julho',

        'Aug' => 'Agosto',

        'Nov' => 'Novembro',

        'Sep' => 'Setembro',

        'Oct' => 'Outubro',

        'Dec' => 'Dezembro'

    );			
$endereco = $_SERVER['SERVER_NAME']; 
if($operador_pk==3){
         
$html .="<html>
             <head>
                <style>
                    table  {
                        font-family: sans-serif;
                        border: 1mm solid whtite;
                        border-collapse: collapse;
                        width:80%;											
                    }    
                    .titulo {
                        font-family: sans-serif;
                        font-size: 14px;
                        color: #ffffff;
                        background: #65009A; 
                        alignment-adjust:central;                
                    }                       

                   
                    .texto {font-family: sans-serif;
                        font-size: 12px;
                    }
                    
                    .texto_titulo {font-family: sans-serif;
                        font-size: 14px;
                    }
                    .tb_com_borda {
                        alignment-adjust: central;
                        border-color: #cccccc;
                        font-size: 9px;
                        color: #ffffff;
                        background: #65009A; 

                    }

                        </style>
                    </head>";


        
        if($row1[ enviar_proposta_email_pk ]==1){
        $header.="<table width=680 align=center border=0>";
        $header.="  <tr>";
        $header.="      <td>";
        $header.="          <table width=100% align=center border=0>";
        $header.="              <tr>";
        $header.="                  <td width=20 align=center >";
        $header.="                      <a href= #  onclick= e_email(".$operador_pk.") ><img src= ../../n_images/email.png  width= 20  title= Enviar proposta /></a>";
        $header.="                  </td>";
        $header.="              </tr>";
        $header.="              <tr align=center>";
        $header.="                  <td>";
        $header.="                      <h6> Enviar proposta por email<h6>";
        $header.="                  </td>";
        $header.="              </tr>";
        $header.="          </table>";
        $header.="      </td>";
        $header.="  </tr>";
        $header.="</table>";
    } 
        $html.="<table width=680 align=center border=0>";       
        $html.="    <thead>";
        $html.="        <tr>";
        $html.="            <td align=center>";
        $html.="                <table width=100% align=center>"; 
        $html.="                    <tr>";
        $html.="                        <td width=25% align=center>";
        $html.="                            <img src=http://".$endereco."/n_images/propostas/vivo/logo_vivo.jpg  width= 40% >";
        $html.="                        </td>";
        $html.="                        <td class=titulo align=center>";
        $html.="                            Proposta comercial Smart vivo";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="    </thead>";
        $html.="    <tbody>";
        $html.="        <tr>";
        $html.="            <td align=center>";
        $html.="                <table width=680 border=1 align=center>";	
        $html.="                    <tr class=texto_titulo>";
        $html.="                        <td width=48%>";
        $html.="                            <b>Razão Social</b><br>";
        $html.=                             $razaosocial;
        $html.="                        </td>";
        $html.="                        <td width=21%>";
        $html.="                            <b>CNPJ</b><br>";
        $html.=                             $cnpj_cpf;
        $html.="                        </td>";
        $html.="                        <td width=31%>";
        $html.="                            <b>Telefone</b><br>";
        $html.=                             "(".$ddd.") ".$tel;
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";          
        $html.="        </tr>";
        //PLANOS
        $sql="";
        $sql="SELECT nip.ddd,
                    npr.ds_produto,
                    nip.vl_unitario,
                    nip.n_qtde,
                    nipo.vl_franquia,
                    produtos_tipo_pk,
                    npr.total_minutos,
                    npr.total_internet
                 FROM n_propostas    np
                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                  LEFT JOIN n_itens_propostas_operadoras nipo ON nip.pk = nipo.itens_propostas_pk
                  INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                WHERE produtos_tipo_pk IN (1) AND np.pk =".$proposta_pk;
        $results = mysql_query($sql);
        $total_planos =  mysql_num_rows($results);
        if ($total_planos >0){
        $html.="        <tr>";        	
        $html.="            <td align=center>";
        $html.="                <table width=680 align=center border=0>";
        $html.="                    <tr>";
        $html.="                        <td align=center class=texto_titulo>";
        $html.="                            <b>Planos</b>";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="        <tr>";
        $html.="            <td align=center>";
        $html.="                <table width=680 align=center border=1 bgcolor=#65009A>";
        $html.="                    <tr>";
        $html.="                        <td width=100 class=tb_com_borda align=center >";
        $html.="                            DDD";
        $html.="                        </td>";
        $html.="                        <td width=100 class=tb_com_borda align=center >";
        $html.="                            LINHAS";
        $html.="                        </td>";
        $html.="                        <td width=244 class=tb_com_borda align=center >";
        $html.="                            DESCRIÇÃO";
        $html.="                        </td>";
        $html.="                        <td width=100 class=tb_com_borda align=center>";
        $html.="                            VALOR DO PLANO";
        $html.="                        </td>";
        $html.="                        <td width=100 class=tb_com_borda align=center >";
        $html.="                            VALOR FINAL PLANOS";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";     
        

        $result = mysql_query($sql);
        $total_linha=0;
        $total_proposta=0;
        $total_plano=0;
        $total_minutos=0;
        $total_internt=0;
    while($row = mysql_fetch_array($result)){
            
        $total_linha = ($total_linha + $row[ n_qtde ]);
        $total_proposta = ($total_proposta + ($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ]));
        $total_plano += (($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ]));
        $total_minutos += (($row[ total_minutos ]*$row[ n_qtde ]));
        $total_internet +=(($row[ total_internet ]));

        $html.="    <tr>";
        $html.="        <td align= center >";
        $html.="            <table width=680 align=center border=1>";
        $html.="                <tr class= texto>";
        $html.="                    <td width=100 class=texto align=center >";
        $html.=                         $row[ ddd ];
        $html.="                    </td>";
        $html.="                    <td width=100 class=texto align=center >";
        $html.=                        $row[ n_qtde ];
        $html.="                    </td>";
        $html.="                    <td width=244 class=texto align=center >";
        $html.=                        $row[ ds_produto ];
        $html.="                    </td>";
        $html.="                    <td width=100 class=texto align=center >";
        $html.=                        number_format($row[ vl_unitario ],2,",","."); 
        $html.="                    </td>";
        $html.="                    <td width=100 class=texto align=center >";
        $html.=                          number_format($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ],2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>"; 
    }
        
        mysql_free_result($result);

        $html.="            <tr>";
        $html.="                <td align= center >";
        $html.="                    <table width=680 align=center colspan=2 border=1 bgcolor=#65009A>";
        $html.="                        <tr>";
        $html.="                            <td width=144 align=right class=tb_com_borda colspan=4>";
        $html.="                                <b>VALOR TOTAL</b>";
        $html.="                            </td>";
        $html.="                            <td width=110 class=tb_com_borda align=center>";
        $html.=                                 number_format ($total_plano,2,",",".");
        $html.="                            </td>";
        $html.="                        </tr>";
        $html.="                     </table>";
        $html.="                </td>";
        $html.="             </tr>";
        }
        //RESUMO DA PROPOSTA
        $html.="    <tr>";
        $html.="        <td align= center >"; 
        $html.="            <table width=680 align=center border=0>";
        $html.="                <tr>";
        $html.="                    <td align=left class=texto>";
        $html.="                        <h6>Valores referenciados não considerados servioes adicionais ,excedentes ou parcelas de aparelhos</h6>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td align= center >";
        $html.="            <table width=680 align=center border=0>";
        $html.="                <tr>";
        $html.="                    <td align=center class=texto_titulo>";
        $html.="                        <b>Resumo de Proposta</b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=680 align=center border=1 bgcolor= #65009A >";
        $html.="                <tr>";
        $html.="                    <td width=76 class=tb_com_borda align=center>";
        $html.="                        Quantidade de linhas";
        $html.="                    </td>";
        $html.="                    <td width=76 class=tb_com_borda align=center>";
        $html.="                        Ligações Vivo X Vivo";
        $html.="                    </td>";
        $html.="                    <td width=76 class=tb_com_borda align=center>";
        $html.="                        Total minutos";                   	
        $html.="                    </td>";
        $html.="                    <td width=76 class=tb_com_borda align=center>";
        $html.="                        Total internet";
        $html.="                    </td>";
        $html.="                    <td width=76 class=tb_com_borda align=center>";
        $html.="                        Total SMS";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";        
        $html.="    </tr>";
        
            $minutos = "";
    if($total_minutos ==0 ){
        $minutos = "ILIMITADO";
    }else{
        $minutos = $total_minutos;
    }
            
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=680 align=center border=1 >";
        $html.="                <tr class=texto >";
        $html.="                    <td width=20% class=texto align=left>";
        $html.="                       <img src=http://".$endereco."/n_images/propostas/vivo/celvivo.jpg  valign= middle  widht= 2%  height= 30 >&nbsp;$total_linha";
        $html.="                    </td>";
        $html.="                    <td width=20% class=texto align=left>";
        $html.="                       <img src=http://".$endereco."/n_images/propostas/vivo/paisvivo.jpg  widht= 30  valign= middle  height= 25 > ILIMITADO";
        $html.="                    </td>";
        $html.="                    <td width=20% class=texto align=left>";
        $html.="                        <img src=http://".$endereco."/n_images/propostas/vivo/chatvivo.jpg  widht= 30%  height= 25 >&nbsp; $minutos";                   	
        $html.="                    </td>";
        $html.="                    <td width=20% class=texto align=left>";
        $html.="                        <img src=http://".$endereco."/n_images/propostas/vivo/arrobavivo.jpg  widht= 30%  height= 25 >&nbsp;$total_internet";
        $html.="                    </td>";
        $html.="                    <td width=20% class=texto align=left>";
        $html.="                        <img src=http://".$endereco."/n_images/propostas/vivo/emailvivo.jpg  widht= 30%  valign= middle  height= 25 > ILIMITADO";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";        
        $html.="    </tr>";
        $html.="     <tr>";
        $html.="         <td align= center >";
        $html.="             <table width=680 align=center border=0>";
        $html.="                 <tr>";
        $html.="                     <td align=left class=texto>";
        $html.="                         <h6>**Valor sem a inclusão da parcela de aparelho ou excedentes </h6>";
        $html.="                     </td>";
        $html.="                 </tr>";
        $html.="             </table>";
        $html.="       </td>";
        $html.="    </tr>";
        $sql="";
        $sql="SELECT 
                    npr.ds_produto,
                    nip.vl_unitario,
                    nip.n_qtde,
                    nipo.vl_franquia
                    produtos_tipo_pk
                 FROM n_propostas    np
                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                  LEFT JOIN n_itens_propostas_operadoras nipo ON nip.pk = nipo.itens_propostas_pk
                  INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                WHERE npr.produtos_tipo_pk IN (4) AND np.pk =".$proposta_pk;
        $results = mysql_query($sql);
        $total_servico =  mysql_num_rows($results);
     
        if ($total_servico >0){
        $html.="    <tr>";
        $html.="        <td align=center>";
        $html.="            <table width=680 align=center border=0>";
        $html.="                <tr>";
        $html.="                    <td align=center class=texto_titulo>";
        $html.="                        <b> Serviços adicionais </b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=680 align=center border=1 class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=25% align=center class=tb_com_borda >";
        $html.="                        Quantidade";                   	
        $html.="                    </td>";
        $html.="                    <td width=25% align=center class=tb_com_borda>";
        $html.="                        Descrição";
        $html.="                    </td>";
        $html.="                    <td width=25% align=center  class=tb_com_borda>";
        $html.="                        Valor serviço";
        $html.="                    </td>";
        $html.="                    <td width=25% align=center class=tb_com_borda>";
        $html.="                        Valor total serviço";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";

        $result = mysql_query($sql);
        $total_linha=0;
        $total_proposta=0;
        $total_servicos=0;
    while($row = mysql_fetch_array($result)){
            
        $total_linha=($total_linha + $row[ n_qtde ]);
        $total_proposta=($total_proposta + ($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ]));
        $total_servicos += (($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ]));
        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=680 align=center border=1>";
        $html.="                <tr class=texto>";
        $html.="                    <td width=76 class=texto align=center>";
        $html.=                        $row[ n_qtde ];
        $html.="                    </td>";
        $html.="                    <td width=76 class=texto align=center>";
        $html.=                        $row[ ds_produto ];
        $html.="                    </td>";
        $html.="                    <td width=76 class=texto align=center>";
        $html.=                        number_format($row[ vl_unitario ],2,",","."); 
        $html.="                    </td>";
        $html.="                    <td width=76 class=texto align=center>";
        $html.=                          number_format($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ],2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>"; 
        
    }    
        
        mysql_free_result($result);        
            
        $html.="      <tr>";
        $html.="            <td align=center >";
        $html.="               <table width=680 align=center colspan=2 border=1 bgcolor=#65009A>";
        $html.="                    <tr>";
        $html.="                        <td width=200 class=tb_com_borda align=right >";
        $html.="                            <b>VALOR TOTAL</b>";
        $html.="                        </td>";
        $html.="                        <td width=65 class=tb_com_borda align=center ><b>";
        $html.=                             number_format ($total_servicos,2,",",".");
        $html.="                        </b></td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="           </td>";
        $html.="     </tr>";
        }
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        $sql="";
        $sql="SELECT 
                    npr.ds_produto,
                    nip.vl_unitario,
                    nip.n_qtde,
                    nipo.vl_franquia
                    produtos_tipo_pk
                 FROM n_propostas    np
                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                  LEFT JOIN n_itens_propostas_operadoras nipo ON nip.pk = nipo.itens_propostas_pk
                  INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                WHERE npr.produtos_tipo_pk IN (3) AND np.pk =".$proposta_pk;
        $results = mysql_query($sql);
        $total_servico =  mysql_num_rows($results);
     
        if ($total_servico >0){
        $html.="    <tr>";
        $html.="        <td align=center>";
        $html.="            <table width=680 align=center border=0>";
        $html.="                <tr>";
        $html.="                    <td align=center class=texto_titulo>";
        $html.="                        <b> Dados </b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=680 align=center border=1 class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=25% align=center class=tb_com_borda>";
        $html.="                        Quantidade";                   	
        $html.="                    </td>";
        $html.="                    <td width=25% align=center class=tb_com_borda>";
        $html.="                        Descrição";
        $html.="                    </td>";
        $html.="                    <td width=25% align=center  class=tb_com_borda>";
        $html.="                        Valor dados";
        $html.="                    </td>";
        $html.="                    <td width=25% align=center class=tb_com_borda>";
        $html.="                        Valor total dados";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";

        $result = mysql_query($sql);
        $total_linha=0;
        $total_proposta=0;
        $total_dados=0;
    while($row = mysql_fetch_array($result)){
            
        $total_linha=($total_linha + $row[ n_qtde ]);
        $total_proposta=($total_proposta + ($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ]));
        $total_dados += (($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ]));
        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=680 align=center border=1>";
        $html.="                <tr class=texto>";
        $html.="                    <td width=76 class=texto align=center>";
        $html.=                        $row[ n_qtde ];
        $html.="                    </td>";
        $html.="                    <td width=76 class=texto align=center>";
        $html.=                        $row[ ds_produto ];
        $html.="                    </td>";
        $html.="                    <td width=76 class=texto align=center>";
        $html.=                        number_format($row[ vl_unitario ],2,",","."); 
        $html.="                    </td>";
        $html.="                    <td width=76 class=texto align=center>";
        $html.=                          number_format($row[ n_qtde ] * $row[ vl_unitario ] + $row[ vl_franquia ],2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>"; 
    }    
        
        mysql_free_result($result);        
            
        $html.="      <tr>";
        $html.="            <td align= center >";
        $html.="               <table width=680 align=center colspan=2 border=1 bgcolor=#65009A>";
        $html.="                    <tr>";
        $html.="                        <td width=200 class=tb_com_borda align=right>";
        $html.="                            <b>VALOR TOTAL</b>";
        $html.="                        </td>";
        $html.="                        <td width=65 class=tb_com_borda align= center><b>";
        $html.=                             number_format ($total_dados,2,",",".");
        $html.="                        </b></td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="           </td>";
        $html.="     </tr>";
        }
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="     <tr>";
        $html.="        <td align=center >";
        $html.="            <table width=680 align=center border=0>"; 
        $html.="                <tr>";
        $html.="                    <td align=center class=texto_titulo>";
        $html.="                        <b>Planos/Serviços</b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td align=center>";
        $html.="            <table width=680 align=center border=1 class=tb_com_borda >";
        $html.="                <tr>";
        $html.="                    <td width=50% align=center class=tb_com_borda>";
        $html.="                        Quantidade de linhas";
        $html.="                    </td>";
        $html.="                    <td width=50% align=center class=tb_com_borda>";
        $html.="                        Valor total de serviçoes**";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        
        $total_ps=0;
        $total_ps += ($total_plano + $total_servicos + $total_dados); 
        
        $html.="    <tr>";
        $html.="        <td align= center >";
        $html.="            <table width=680 align=center border=1 class=texto>";
        $html.="                <tr class=texto >";
        $html.="                    <td width=50% align=center class=texto>";
        $html.="                        <table width=680>";
        $html.="                            <tr class=texto>";
        $html.="                                <td align=left>";
        $html.="                                    <img src=http://".$endereco."/n_images/propostas/vivo/celvivo.jpg  widht=10%  height=35 >.$total_linha";
        $html.="                                </td>";
        $html.="                                <td align=center>";
        $html.=                                     number_format ($total_ps,2,",",".");
        $html.="                                </td>";
        $html.="                            </tr>";
        $html.="                        </table>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td align=center>";
        $html.="            <table width=680 align=center border=0>";
        $html.="                <tr>";
        $html.="                    <td align=center clas= texto>";
        $html.="                        <h6>** Valor sem a inclusão da parcela de aparelho ou excedentes </h6>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $sql=" select
                npa.n_qtde
                ,npa.vl_unitario
                ,nap.ds_aparelho
                ,nap. ds_aparelho
                ,npa. parcelamento_pk
                ,npa. vl_desconto_aparelho
                from n_propostas_aparelhos npa
                inner join n_aparelhos nap on npa.aparelhos_pk = nap.pk
                where npa.propostas_pk =".$proposta_pk;
        $results = mysql_query($sql);
        $valoraparelho =  mysql_num_rows($results);
        if ($valoraparelho >0){
        $html.="    <tr>";
        $html.="        <td align=center>";
        $html.="            <table width=680 align=center border=0>";
        $html.="                <tr>";
        $html.="                    <td align=center  class=texto_titulo>";
        $html.="                        <b> Aparelhos </b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td align=center>";
        $html.="            <table width=680 align=center border=1 class=tb_com_borda >";
        $html.="                <tr>";
        $html.="                    <td width=16% align=center class=tb_com_borda>";
        $html.="                        Quantindade";
        $html.="                    </td>";
        $html.="                    <td width=16% align=center class=tb_com_borda>";
        $html.="                        Modelo";
        $html.="                    </td>";
        $html.="                    <td width=16% align=center class=tb_com_borda>";
        $html.="                        Valor Aparelho";
        $html.="                    </td>";
        $html.="                    <td width=16% align=center class=tb_com_borda>";
        $html.="                        Parcelas";
        $html.="                    </td>";
        $html.="                    <td width=16% align=center class=tb_com_borda>";
        $html.="                        Total parcelas aparelho";
        $html.="                    </td>";
        $html.="                    <td width=16% align=center class=tb_com_borda>";
        $html.="                        Valor Total";
        $html.="                    </td>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        
        $result = mysql_query($sql);
        
    while($row = mysql_fetch_array($result)){
            
        $total_aparelhos += ($row[ vl_unitario ]*$row[ n_qtde ]);
        $total_parcelas +=($row[ vl_unitario ]*$row[ n_qtde ]/$row[ parcelamento_pk ]);
        
        $html.="    <tr>";
        $html.="        <td align=center >";
        $html.="            <table width=680 align=center border=1>";
        $html.="                <tr>";
        $html.="                    <td width=16% class=texto align=center>";
        $html.=                         $row[ n_qtde ];
        $html.="                    </td>";
        $html.="                    <td width=16% class=texto align=center>";
        $html.=                         $row[ ds_aparelho ];
        $html.="                    </td>";
        $html.="                    <td width=16% class=texto align=center>";
        $html.=                         number_format ($row[ vl_unitario ],2,",",".");
        $html.="                    </td>";
        $html.="                    <td width=16% class=texto align=center>";
        $html.=                         $row[ parcelamento_pk ];
        $html.="                    </td>";
        $html.="                    <td width=16% class=texto align=center>";
        $html.=                         number_format ($row[ vl_unitario ]*$row[ n_qtde ]/$row[ parcelamento_pk ],2,",",".");
        $html.="                    </td>";
        $html.="                    <td width=16% class=texto align=center>";
        $html.=                         number_format ($row[ vl_unitario ] * $row[ n_qtde ],2,",",".");
        $html.="                    </td>"; 
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
    } 
        }
       mysql_free_result($result);
       
        
        
        $html.="            <tr>";
        $html.="                <td align=center>";
        $html.="                    <table width=680 align=center colspan=2 border=1 bgcolor=#65009A >";
        $html.="                        <tr>";
        $html.="                            <td width=200 class=tb_com_borda align=right >";
        $html.="                                <b>VALOR TOTAL</b>";
        $html.="                            </td>";
        $html.="                            <td width=30 class=tb_com_borda align=right >";
        $html.=                                 number_format ($total_aparelhos,2,",",".");
        $html.="                            </td>";
        $html.="                        </tr>";
        $html.="                     </table>";
        $html.="                </td>";
        $html.="             </tr>";
        $html.="    <tr>";
        $html.="        <td align=center >";
        $html.="            <table width=680 align=center border=0>"; 
        $html.="                <tr>";
        $html.="                    <td align=center class=texto_titulo>";
        $html.="                        <br><b>Planos/Serviços/Aparelhos</b></br>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        
        
        $total_psa=0;
        $total_psa += ($total_plano + $total_servicos + $total_dados + $total_parcelas);
        
        $html.="    <tr>";
        $html.="        <td align= center >";
        $html.="            <table width=680 align=center border=1  class=texto>";
        $html.="                <tr class=texto1 >";
        $html.="                    <td width= 680  align= center  class=texto >";
        $html.=                       number_format ($total_psa,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="<div style= page-break-after: always > </div>";
        $html.="<table width= 680  align= center  border= 0 >";
        $html.="    <tr>";
        $html.="        <td align= center>";
        $html.="            <table width=100% align=center >";
        $html.="                <tr>";
        $html.="                    <td  align=center class=titulo class= tb_sem_borda >";
        $html.="                        <b> Conheça também outros serviços da Vivo </b>"; 
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100%  align=center  border=0 >";
        $html.="                <tr>";
        $html.="                    <td width=33%  align=center >";
        $html.="                        <img src=http://".$endereco."/n_images/propostas/vivo/3.jpg width=80% >"; 
        $html.="                    </td>";
        $html.="                    <td width= 33% >";
        $html.="                        <img src=http://".$endereco."/n_images/propostas/vivo/2.jpg width=80% >";
        $html.="                    </td>";
        $html.="                    <td width= 33% >";
        $html.="                        <img src=http://".$endereco."/n_images/propostas/vivo/1.jpg width=80% >";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $sql="  select 
                    vl_vc1_local
                    ,vl_vc2_local
                    ,vl_vc3_local
                    ,vl_vc1_Inter_Estad
                    ,vl_vc2_Inter_Estad
                    ,vl_vc3_Inter_Estad
                from n_itens_propostas_operadoras nipo
                    inner join  n_itens_propostas nip on nip.pk = nipo.itens_propostas_pk
                where nip.propostas_pk =".$propostas_pk;
                $result = mysql_query($sql);
            while($row = mysql_fetch_array($result)){
                    $vc1 = $row[ vl_vc1_local ];  
                    $vc2 = $row[ vl_vc2_local ];
                    $vc3 = $row[ vl_vc3_local ];
                    $vcIE = $row[ vl_vc1_Inter_Estad ];
                    $vc2I = $row[ vl_vc2_Inter_Estad ];
                    $vc3I = $row[ vl_vc3_Inter_Estad ];
            }
       
        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center border=0 >";
        $html.="                <tr>";
        $html.="                    <td align=left class=texto>";
        $html.="                        <b>Documentos Necessários</b>";
        $html.="                        <p>Cópia do cartão CNPJ;Cópia do RG e CPF do representante legal;Cópia do Contrato Social e Última Alteração Contratual (se tiver) ou documento que comprove a competência de assinatura do representante legal da empresa;Cópia da procuração (se aplicável).Em caso de necessidade, podem ser solicitados documetos adicionais </p>";
        $html.="                        <br><b> Condições gerais</b>";
        $html.="                        <br><p> A presente proposta não representa solicitação de pedido e tem como única função prover preços de referência. Para efetivação das condiçoes comerciais e contratação de serviços constante na empresa proposta, será necessário a devida assinatura do formulariode Solicitação de serviços, que é parte integrante do contrato registrado em cartório, e o envio do mesmo á Vivo. </p>";
        $html.="                        <br><b> A presente proposta tem uma vigência de 5 (cinco) dias a partir da data da emissão deste documento. Após este período, será obrigatória a revalidação dos custos e a Vivo não se compromete em manter os valores inicialmente apresentados.</b>";
        $html.="                        <br><p> Todos os valores informados a título de orçamento são suscetíveis a alteração quando da execução de estudo de viabilidade técnica do atendimento, após aceites por clientes. Aparelhos sujeitos á disponibilidade do estoque. Caso nâo haja disponibilidade na data da contratação, será realizada nova proposta com valores dos aparelhos disponiveis no estoque. Os valores da presente proposta incluem todos os tributos. Prazo de entrega de 20 dias úteis. Em caso de aquisições de aparelhos havendo rescisão contrataual antes do término do contrato, haverá a cobrança de valor residual do aparelho, correspondenre a seguinte equação: Valor do aparelho dividido pela quantidde de meses de contrato, multiplicado pelos meses restante do contrato. Ex: R$240,00 dividido por 24 meses de contrato=R410,00 Contrato cancelado com 22 meses=R$10,00 X 2 meses=R$20,00, valor residual </p> ";
        $html.="                        <br><b> Período de permanência nos planos contratados: 24 meses </b>";
        $html.="                        <br><b>Confidencialidade</b>";
        $html.="                        <br><p> A Vivo está ciente que as informações contidas neste documento são confidenciais e não deverão ser divulgadas fora do âmbito desta sem uma prévia autorização do cliente, ao mesmo tempo que, solicitamos do cliente tal consideração para as informações contidas nesta proposta. Da mesma maneira, não poderá ser objeto de empréstimo, aluguel ou qualquer forma de cessão de uso sem o consientimento prévio por escrito da vivo, titular do copyright. o não cumprimeto das limitações citadas, por qualquer pessoa que tenha acesso á documentação, estará sujeita as sensações prévias previstas </p>";
        $html.="                        <br><b>Próximos Passos</b>";
        $html.="                        <p> Entrega da documentação;Recebimento do termo de adesão e contrato;Assinatura do Contrato;Recebimento dos aparelhos e ativação do serviço.Em caso de dúvidas, entre com contato com o seu gerente de negócios ou com um parceiro homologado </p> <br></br>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $sql = "";
        $sql.= " Select
                ui.nome,
                ui.email,
                ui.ddd_tel,
                ui.tel
         from usuariosinternos ui
                inner join leads l on ui.codusuariointerno = l.codgerenteconta
         Where l.codlead=".$leads_pk;           

        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $gerenteconta = $row[ nome ];
        $gerenteemail = $row[ email ];
        $ddd_tel = $row[ ddd_tel ];
        $tel = $row[ tel ];
        mysql_free_result($result);	
        
		
	
    if(!empty($gerenteconta)){
        $html.="    <tr>";
        $html.="        <td align= center >";
        $html.="            <table width= 100%  align= center  border= 0  class= texto >";
        $html.=                 "<tr align= center >";
        $html.=                     "<td class= texto  align= left  >";
        $html.=			"<b> ";
        $html.=                             $gerenteconta;
        $html.=			"</b>";	
        $html.=                     "</td>";
        $html.=                 "</tr>";
    if(!empty($tel)){
        $html.=	"<tr align= center >";
        $html.=		"<td class= texto   align= left  >";
        $html.=			"<b> ";
        $html.=			"Cel.: (".$ddd_tel.") ".$tel;
        $html.=			"</b>";					
        $html.=		"</td>";
        $html.=	"</tr>";
    }	
    if(!empty($gerenteemail)){
        $html.=	"<tr align= center >";
        $html.=		"<td class= texto  align= left  >";
        $html.=			"<b>";
        $html.=			"Email: ".$gerenteemail;
        $html.=			"</b>";					
        $html.=		"</td>";
        $html.=	"</tr>";
    }		
        $html.=             "</table>";
        $html.="        </td>";
        $html.="   </tr>";
    }
		$html.=	"<tr>";
		$html.=		"<td align= center>";
        $html.=			"<font face= ,Verdana, Arial, Helvetica, sans-serif  size= 1  >";
		$html.=                            $v_dsc_rodape;
        $html.=                        "</font>";
		$html.=		"</td>";
		$html.=	"</tr>";						
		$html.="</table>";
        
        $html.="    </tbody>";
        $html.="</table>";
        $html.="</html>";
        
        echo $header;
        echo $html;
      ?>
         <input type="hidden" name="script_header" id="script_header" value= "<?=$header;?>" /> 
         <input type="hidden" name="html" id="script_html" value= "<?=$html;?>" /> 
        <?
	exit();
  
     mysql_close($con);
     
}elseif($operador_pk==2){

  $html .="<html>
            <head>
                <style>
            .titulo{
                font-family: sans-serif;
                font-size:15px;
                color:#ffffff;
                background: #043A76;
                
            }  
            .texto{
                font-family: sans-serif;
                font-size: 15px;                
           }
           .t{
                font-family: sans-serif;
                font-size:15px;
                color:#000000;
                border-color: #043A76;
                
            }  
            .sub{
                font-family: sans-serif;
                font-size: 10px;
            }
            .sub_c{
                font-family: sans-serif;
                font-size: 12;
                color: #FF0000
            }
            table {
                font-family: sans-serif;
                border: 1mm solid #043A76;
                border-collapse: collapse;
                width:80%;											
            }
            table.sub {
                font-family: sans-serif;
                border: 1mm solid ;
                border-collapse: collapse;
                width:100%;						
            }
            table.subtable {
                font-family: sans-serif;
                border: 1mm solid ;
                border-collapse: collapse;
                width:100%;						
            }
            td {
                 border: 1mm solid white;
            }
            td.grid{
                border: 1mm solid #043A76;
                font-family: Calibri;
                FONT-SIZE: 10px;
                
            }
            
            td.texto{						
                font-family: Tahoma;
                FONT-SIZE: 12px;
            }
            
        </style>
         </head>";
    
       if($row1[ enviar_proposta_email_pk ]==1){
        $header.="<table width=680 align=center border=0 >";
        $header.="      <tr>";
        $header.="          <td>";
        $header.="              <table width=100% align=center border=0 >";
        $header.="                   <tr>";
        $header.="                      <td width=20 align=center >";
        $header.="                          <a href= #  onclick= e_email(".$operador_pk.") ><img src= ../../n_images/email.png  width= 20  title= Enviar proposta /></a>";
        $header.="                      </td>";
        $header.="                  </tr>";
        $header.="                  <tr align=center>";
        $header.="                      <td>";
        $header.="                         <h6> Enviar proposta por email<h6>";
        $header.="                      </td>";
        $header.="                  </tr>";
        $header.="             </table>";
        $header.="          </td>";
        $header.="     </tr>";
        $header.="  </table>";
    }
        $html.="<table width=680 align=center border=0>";
        $html.="  <thead>";  
        $html.="      <tr>";
        $html.="          <td>";
        $html.="              <table widht=100% align=center border=0 >";
        $html.="                  <tr>";
        $html.="                      <td align=center >";
        $html.="                          <img src=http://".$endereco."/n_images/propostas/tim/tim.jpg align=center>";
        $html.="                      </td>";
        $html.="                  </tr>";
        $html.="              </table>";
        $html.="          </td>";
        $html.="      </tr>";
        $html.="  </thead>";

        
        $html.="<tbody>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table widht=150% align=center border=0>";
        $html.="                <tr>";
        $html.="                    <td width=671  align=center  class=titulo>";
        $html.="                        <b> PROPOSTA COMERCIAL</b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>"; 
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table widht=100% align=center border=0 >";
        $html.="                <tr>";
        $html.="                    <td class= texto >";
        $html.=                        $v_cidade."&nbsp;,".$dia."&nbsp;de&nbsp;".$mes_extenso["$mes"]."&nbsp;de&nbsp;".$ano;                              
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center border=0 >";
        $html.="                <tr>";
        $html.="                    <td align=left class=texto >";
        $html.="                        <b> Á ".$razaosocial."</b>";                              
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=680 align=center border=0 >";
        $html.="                <tr>";
        $html.="                    <td align=center  class=texto >";
        $html.="                        <p>Primeira operadora a ter presença nacional, a <b> Tim Brasil</b> trabalha com foco em inovação e qualidade, realizando constantes investimentos em tecnologia para melhor atendê-lo </p>";
        $html.="                        <p>Presente em mais de <b> 3,300 municípios do Brasil</b>, em todos os estados do país, a <b> Tim</b> atende hoje a mais de <b>75 milhões de clientes</b>";
        $html.="                        <p>Com uma das maiores coberturas em internet móvel do país,  serviços e planos exclusivos, é uma operadora cada vez mais completa, dedicada a melhora a qualidade, usabilidade em telefonia móvel e fixa, e facilitar o acesso a cada vez mais conteúdos</p>";
        $html.="                        <p> Sua empresa precisa se comunicar de forma cada vez mais eficiente.Por isso, a <b> Tim</b> traz as melhores ofertas e soluções em tele comunicação que se adéquem ao perfil de cada usuário.</p>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="</table>";
        $html.="<div style= page-break-after: always > </div>";
        
        $html.="<table widht=680 align=center border=0>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table widht=100% align=center border=0 >";
        $html.="                <tr>";
        $html.="                    <td align=center>";
        $html.="                        <img src=http://".$endereco."/n_images/propostas/tim/tim.jpg align=center>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $sql ="";
        $sql.="SELECT nip.pk,
                    nip.produtos_pk,
                    npr.ds_produto,
                    nip.n_qtde,
                    nip.vl_unitario,
                    nipo.vl_franquia,
                    ntl.dsc_tipo_linha,  
                    npr.produtos_tipo_pk
           FROM n_itens_propostas nip
                    INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                    left JOIN n_itens_propostas_operadoras nipo ON nipo.itens_propostas_pk = nip.pk
                    left join n_produto_tipo_linha ntl on nipo.tipo_linha_pk = ntl.pk                                   
         where nip.propostas_pk=".$proposta_pk;
        $sql.=" and npr.produtos_tipo_pk = 1
         order by nip.pk";
        
        $results = mysql_query($sql);
        $dadospedido =  mysql_num_rows($results);
        if ($dadospedido >0){
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table widht=100% align=center border=0>";
        $html.="                <tr>";
        $html.="                    <td align=center class=titulo>";
        $html.="                        <b>DADOS PEDIDO</b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td class=border>";
        $html .="           <table width=100% align=center>";
        $html .="               <tr align=center>";
        $html .="                   <td width=133 align=center class=titulo >";
        $html .="                       Descrição da Oferta";
        $html .="                   </td>";
        $html .="                   <td width=133 align=center class=titulo>";								
        $html .="                        Quantidade";
        $html .="                   </td>";
        $html .="                   <td width=133 align=center class=titulo>";
        $html .="                        Valor Unitário";
        $html .="                   </td>";		
        $html .="               </tr>";   
        

        $results = mysql_query($sql);
         $_v = 0;   
    while($row1 = mysql_fetch_array($results)){	                        
        $valor_franqui_total += $row1[ vl_franquia ];
        $valor_unitario_total += $row1[ vl_unitario ];
        $valor_unitario_multiplicado += ($row1[ n_qtde ] * $row1[ vl_unitario ]);
        $qtde += $row1[ n_qtde ]; 
        $vl_franquia = $valor_franqui_total;
        
        
        $html .="               <tr align=center >";
        $html .="                   <td class=t width=280  align=letf>";
        $html .=                        $row1[ ds_produto ];
        $html .="                   </td>";                              
        $html .="                   <td class=t width=133 align=center>";
        $html .=                        $row1[ n_qtde ];
        $html .="                   </td>";		
        $html .="                   <td class=t width=133 align=center >";
        $html .=                        "R$ ".number_format( $row1[ vl_unitario ],2,",",".");
        $html .="                   </td>";
        $html.="                </tr>";   
        $html .="           </table>";
        $html.="        </td>";
        $html.="    </tr>";
         }
         mysql_free_result($result);
        }
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center >";
        $html.="                <tr align=center>";
        $html .="                   <td width=133 align=center class=titulo>";
        $html .="                       Valor total";
        $html .="                   </td>";
        $html .="                   <td   width=133 align=center class=titulo>";
        $html .=                        "R$ ".number_format($valor_unitario_multiplicado,2,",",".");
        $html .="                   </td>"; 
        $html .="               </tr>";
        $html.="            </table>";
        $html.="       </td>";
        $html.="   </tr>";
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table widht=100% align=center border=0>";
        $html.="                    <tr>";
        $html.="                        <td class=sub>";
        $html.="                            <h5>(*) Os telefones podem variar de modelo e fabricante dependendo dos estoques na data da assinatura do contrato.</h5>";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table widht=100% align=center border=0 >";
        $html.="                    <tr>";
        $html.="                        <td align=center class=texto>";
        $html.="                            <b>Mecânica de serviços:</b>";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table width=680 align=center border=0 class=texto>";
        $html.="                    <tr>";
        $html.="                        <td>";
        $html.="                            <p>Os planos ofertados para as linhas que serão distribuídas na matriz, filiais da sua empresa possuíram os serviços de <b>ligações ilimitadas</b> para celular da <b>TIM</b> independente do DDD.</p>";
        $html.="                            <p>Os planos ofertados para as linhas que serão distribuídas na empresa <b>não possuem tarifação</b>em caso de viagens fora do <b>DDD</b> de origem da linha.</p>";
        $html.="                            <p>As linhas da empresa serão controladas via internet pelo <b>Gestor Web </b>, sendo assim o responsável por esta administração terá todo o controle das linhas.</p>";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table width=100% align=center border=0>";
        $html.="                    <tr>";
        $html.="                        <td align=left class= texto>";
        $html.="                            <b>Proposta válida por 30 dias.</b>";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table widht=680 align=center border=0 >"; 
        $html.="                    <tr>";
        $html.="                        <td class=sub_c>";
        $html.="                            ** Esta proposta invalida e substitui as enviadas anteriormente."; 
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table widht=100% align=center border=0>";
        $html.="                    <tr>";
        $html.="                        <td  aling=center class=titulo>";
        $html.="                            <b>OBSERVAÇÕES</b>";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table widht=680 align=center border=0>";
        $html.="                    <tr>";
        $html.="                        <td class=texto>";
        $html.="                            <p>1. Os preços ofertados nesta proposta já possuem os valores de impostos inclusos</p>";
        $html.="                            <p>2. Está proposta possui validade de 03 dias úteis após a sua emissão</p>";
        $html.="                            <p>3. Consulte também a tabela de tarifas vigentes com o seu consultor de vendas.</p>";
        $html.="                            <p>4. Ofertas validas mediante a assinatura de todos os contratos da operadora e sujeita à analise interna.</p>";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="    </tr>";
        $sql = "";
        $sql.= " Select
                ui.nome,
                ui.email,
                ui.ddd_tel,
                ui.tel
         from usuariosinternos ui
                inner join leads l on ui.codusuariointerno = l.codgerenteconta
         Where l.codlead=".$leads_pk;           

        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $gerenteconta = $row[ nome ];
        $gerenteemail = $row[ email ];
        $ddd_tel = $row[ ddd_tel ];
        $tel = $row[ tel ];
        mysql_free_result($result);	
        
		
	
    if(!empty($gerenteconta)){
        $html.="    <tr>";
        $html.="        <td align= center >";
        $html.="            <table width= 100%  align= center  border= 0  class= texto >";
        $html.=                 "<tr align= center >";
        $html.=                     "<td class= texto  align= left  >";
        $html.=			"<b> ";
        $html.=                             $gerenteconta;
        $html.=			"</b>";	
        $html.=                     "</td>";
        $html.=                 "</tr>";
    if(!empty($tel)){
        $html.=	"<tr align= center >";
        $html.=		"<td class= texto   align= left  >";
        $html.=			"<b> ";
        $html.=			"Cel.: (".$ddd_tel.") ".$tel;
        $html.=			"</b>";					
        $html.=		"</td>";
        $html.=	"</tr>";
    }	
    if(!empty($gerenteemail)){
        $html.=	"<tr align= center >";
        $html.=		"<td class= texto  align= left  >";
        $html.=			"<b>";
        $html.=			"Email: ".$gerenteemail;
        $html.=			"</b>";					
        $html.=		"</td>";
        $html.=	"</tr>";
    }		
        $html.=             "</table>";
        $html.="        </td>";
        $html.="   </tr>";
    }
		$html.=	"<tr>";
		$html.=		"<td   align= center  >";
        $html.=			"<font face= ,Verdana, Arial, Helvetica, sans-serif  size= 1  >";
		$html.=                            $v_dsc_rodape;
        $html.=                        "</font>";
		$html.=		"</td>";
		$html.=	"</tr>";						
		$html.="</table>";
        
        $html.="    </tbody>";
        $html.="</table>";
        $html.="</html>";
        
        
        echo $header;
        echo $html;
?>
         <input type="hidden" name="script_header" id="script_header" value= "<?=$header;?>" /> 
         <input type="hidden" name="html" id="script_html" value= "<?=$html;?>" /> 
        <?
	exit();
    
 mysql_close($con);   
}elseif($operador_pk==1){
     
$html.="<html>
    <head>
        <style>
            table  {
                        font-family: sans-serif;
                        border-collapse: collapse;
                    }    
                    .titulo {
                        font-family: sans-serif;
                        font-size: 18px;
                        alignment-adjust:central;                
                    }
                    .texto {font-family: sans-serif;
                        font-size: 14px;
                    }
                    
                    .valor {font-family: sans-serif;
                        font-size: 12px;
                        color: #4472C4
                    }
                    .tb_com_borda {
                        font-family: sans-serif;
                        alignment-adjust: central;
                        border-color: red;
                        font-size: 14px;

                    }
                    
            
        </style>
    </head>";
        if($row1[ enviar_proposta_email_pk ]==1){
        $header.="<table width=680 align=center border=0>";
        $header.="  <tr>";
        $header.="      <td>";
        $header.="          <table width=680 align=center border=0 >";
        $header.="              <tr>";
        $header.="                  <td width=20  align=center >";
        $header.="                      <a href= #  onclick= e_email(".$operador_pk.") ><img src= ../../n_images/email.png  width= 20  title= Enviar proposta /></a>";
        $header.="                  </td>";
        $header.="              </tr>";
        $header.="              <tr align=center>";
        $header.="                  <td>";
        $header.="                      <h6> Enviar proposta por email<h6>";
        $header.="                  </td>";
        $header.="              </tr>";
        $header.="          </table>";
        $header.="      </td>";
        $header.="  </tr>";
        $header.="</table>";
            }
        $html.="<table width=680 align=center border=0 >";
        $html.="    <thead>";  
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table widht=100%  align=center  border=0 >";
        $html.="                    <tr>";
        $html.="                        <td align=center>";
        $html.="                            <img src=http://".$endereco."/n_images/propostas/claro/teste.png  width= 100% >";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="    </thead>";
        $html.="</table>";
        $sql="";
        $sql="SELECT nip.ddd,
                    npr.ds_produto,
                    nip.vl_unitario,
                    nip.n_qtde,
                    nipo.vl_franquia,
                    produtos_tipo_pk,
                    npr.total_minutos,
                    npr.total_internet
                 FROM n_propostas    np
                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                  LEFT JOIN n_itens_propostas_operadoras nipo ON nip.pk = nipo.itens_propostas_pk
                  INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                WHERE produtos_tipo_pk IN (1) AND np.pk =".$proposta_pk;
        
        
        $html.="<table width=680 align=center border=0";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=90% align=left border=1 class=tb_com_borda>";
        $html.="                <tr class=titulo>";
        $html.="                    <td align=center>";
        $html.="                        <i><font color = #70ad47 >  PROPOSTA CLARO </font></i>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=90% align=left border=1 class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=30% align=center class=tb_com_borda>";
        $html.="                        <b><i>Descrição</i></b>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <b><i>Quantidade</i></b>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <b><i>Valor Unitário</i></b>";
        $html.="                    </td >";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <b><i>Valor Total</i></b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
                $vl_total_proposta_claro=  0;   
                $result = mysql_query($sql);
            while($row = mysql_fetch_array($result)){
                $vl_total_proposta_claro += $row[ vl_unitario ]*$row[ n_qtde ];
                
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=90% align=left border=1 class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=30% align=center class=tb_com_borda>";
        $html.=                         $row[ ds_produto ];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         $row[ n_qtde ];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         "R$".number_format($row[ vl_unitario ],2,",",".");
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         "R$".number_format ($row[ vl_unitario ] * $row[ n_qtde ],2,",","."); 
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
            }
    mysql_free_result($result);        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=90% align=left>";
        $html.="                <tr class=texto >";
        $html.="                    <td class= texto  >";
        $html.="                        <h6> <b>Total proposta</b></h6>";
        $html.="                    </td>";
        $html.="                    <td colspan=4 align=right class=texto>";
        $html.="                        <h6> <b>  R$".number_format ($vl_total_proposta_claro,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        $sql="";
        $sql="SELECT 
                    npr.ds_produto,
                    nip.vl_unitario,
                    nip.n_qtde,
                    nipo.vl_franquia
                    produtos_tipo_pk
                 FROM n_propostas    np
                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                  LEFT JOIN n_itens_propostas_operadoras nipo ON nip.pk = nipo.itens_propostas_pk
                  INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                WHERE npr.produtos_tipo_pk IN (3,4) AND np.pk =".$proposta_pk;
        $results = mysql_query($sql);
        $totalmodulos =  mysql_num_rows($results);
        if ($totalmodulos >0){
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=90% border=1 align=left class=tb_com_borda>";
        $html.="                <tr class=titulo>";
        $html.="                    <td align=center >";
        $html.="                        <i><font color = #70ad47 > MODULOS </font></i> ";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=90% align=left border=1 class=tb_com_borda >";
        $html.="                <tr>";
        $html.="                    <td width=20% align=center class= tb_com_borda >";
        $html.="                        <i><b>Quantidade</b></i>";
        $html.="                    </td> ";
        $html.="                    <td width=30% align=center class= tb_com_borda >";
        $html.="                        <i><b>Descrição</b></i>";
        $html.="                    </td> ";
        $html.="                    <td width=20% align=center class= tb_com_borda >";
        $html.="                        <i><b>Valor serviço</b></i>";
        $html.="                    </td> ";
        $html.="                    <td width=20% align=center class= tb_com_borda >";
        $html.="                        <i><b>Valor total de serviços</b></i>";
        $html.="                    </td> ";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $result = mysql_query($sql);
        $total_modulos = 0;
    while($row = mysql_fetch_array($result)){
        $total_modulos += $row[ vl_unitario ]*$row[ n_qtde ];
        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=90%  align=left  border=1 class= tb_com_borda >";
        $html.="                <tr align= center >";
        $html.="                    <td width=20%  class= tb_com_borda>";
        $html.=                         $row[ n_qtde ];
        $html.="                    </td > ";
        $html.="                    <td width=30% class= tb_com_borda>";
        $html.=                         $row[ ds_produto ];
        $html.="                    </td>";
        $html.="                    <td width=20% class= tb_com_borda>";
        $html.=                         "R$".number_format($row[ vl_unitario ],2,",",".");
        $html.="                    </td>";
        $html.="                    <td width=20% class= tb_com_borda>";
        $html.=                         "R$".number_format ($row[ vl_unitario ] * $row[ n_qtde ],2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
    }
        
    mysql_free_result($result); 
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=80% align=left>";
        $html.="                <tr class=texto >";
        $html.="                    <td  class=texto >";
        $html.="                        <h6> <b>Total modulos</b></h6>";
        $html.="                    </td>";
        $html.="                    <td colspan=4  align=right class=texto>";
        $html.="                        <h6> <b> R$".number_format ($total_modulos,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>"; 
        }
        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        $sql="";
        $sql=" select
                npa.n_qtde
                ,npa.vl_unitario
                ,nap. ds_aparelho
                ,npa. parcelamento_pk
                ,npa. vl_desconto_aparelho
                from n_propostas_aparelhos npa
                inner join n_aparelhos nap on npa.aparelhos_pk = nap.pk
                where npa.propostas_pk =".$proposta_pk;
         $results = mysql_query($sql);
        $taparelhos =  mysql_num_rows($results);
        if ($taparelhos >0){
        
       
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center border=1 class=tb_com_borda>";
        $html.="                <tr class=titulo >";
        $html.="                    <td align=center>";
        $html.="                        <i><font color =#4472C4 > APARELHOS </font></i>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center  border=1 class= tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=20% align=center class=tb_com_borda >";
        $html.="                       <i><b> Quantidade</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda >";
        $html.="                        <i><b>Descrição</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <i><b>Valor Unitário</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <i><b>Parcelas</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <i><b>Valor mensal</b></i>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        
        
    $total_aparelhos_claro=0;
          $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
            $total_aparelhos_claro+=$row[ vl_unitario ]*$row[ n_qtde ];
            
            
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center  border=1 class= tb_com_borda>";
        $html.="                <tr align= center >";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         $row[n_qtde];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         $row[ds_aparelho];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda >";
        $html.=                         "R$".$row[vl_unitario];
        $html.="                    </td >";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         $row[parcelamento_pk];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         "R$".number_format ($row[ vl_unitario ]/$row[ parcelamento_pk ],2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        }
        
        mysql_free_result($result);
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align= center>";
        $html.="                <tr class=texto >";
        $html.="                    <td  >";
        $html.="                        <h6> <b>Total aparelhos</b></h6>";
        $html.="                    </td>";
        $html.="                    <td colspan=4  align=right  class=texto>";
        $html.="                        <h6> <b> R$".number_format ($total_aparelhos_claro,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        }
        
        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100%  border=1 align=center class=tb_com_borda >";
        $html.="                <tr class=titulo>";
        $html.="                    <td align= center> ";
        $html.="                       <b><i> <font color=#8A30A0 > BENEFÍCIOS</i></b></font>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        
        
                $minutos = "";
    if($total_minutos ==0 ){
        $minutos = "Ilimitado";
    }else{
        $minutos = $total_minutos;
    }
    
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100%  border=1 align=center class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=40% class=tb_com_borda > ";
        $html.="                        Minutos para outras operadoras";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class=tb_com_borda>";
        $html.=                         $minutos;
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td width=40%  class=tb_com_borda> ";
        $html.="                        Minutos para claro";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class=tb_com_borda>";
        $html.="                        Ilimitado Nacional";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td width=40%  class=tb_com_borda> ";
        $html.="                        Isenção de deslocamento";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class= tb_com_borda>";
        $html.="                        Em todo o Brasil";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        
        
        $total_tudo =0;
        $total_tudo += $vl_total_proposta_claro + $total_aparelhos_claro + $total_modulos; 
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=680  border=1 align=center class=tb_com_borda >";
        $html.="                <tr class= texto >";
        $html.="                    <td width=40%  class=tb_com_borda>";
        $html.="                         <b> Valor total da proposta + Aparelhos </b>";
        $html.="                    </td>";
        $html.="                    <td width= 60%  align= right  class=tb_com_borda >";
        $html.="                        <b> R$".number_format($vl_total_proposta_claro + $total_aparelhos_claro + $total_modulos,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        $sql = "Select
				         np.trade_in,
                         np.vl_ult_conta,
                         np.vl_desconto_claro
						from n_propostas np
						where np.pk=".$proposta_pk;
$results = mysql_query($sql);
        $conta_atual =  mysql_num_rows($results);
        if ($conta_atual >0){
                
       
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center  border=1 class= tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=33% align=center class=tb_com_borda >";
        $html.="                       <i><b> Conta atual</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=33% align=center class=tb_com_borda >";
        $html.="                        <i><b>Economia em 12 meses</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=33% align=center class=tb_com_borda>";
        $html.="                        <i><b>Economia em 24 meses </b></i>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
          $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)){
        

        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center  border=1 class= tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=33% align=center class=tb_com_borda >";
        $html.="                       R$".number_format($row[vl_ult_conta],2,",",".");
        $html.="                    </td>";
        $html.="                    <td width=33% align=center class=tb_com_borda >";
        $html.="                        R$".number_format(($row[vl_ult_conta] - $total_tudo) * 12 ,2,",",".");
        $html.="                    </td>";
        $html.="                    <td width=33% align=center class=tb_com_borda>";
        $html.="                        R$".number_format(($row[vl_ult_conta] - $total_tudo) * 24 ,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
    mysql_free_result($result);
    }
        }
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center border=1 class=tb_com_borda >";
        $html.="                <tr class= titulo>";
        $html.="                    <td align=center>";
        $html.="                        <b> Documentação para contratação do plano</b>";				
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% border=1 class=tb_com_borda align= center>";
        $html.="                <tr>";
        $html.="                    <td widht=100% align=left class=tb_com_borda  >";
        $html.="                      <b> 1. Cópia do contrato social </b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td widht=100% align=left class=tb_com_borda >";
        $html.="                       <b>2. Cópia do RG E CPF ou CNH	</b>	";		
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td widht=100% align=left class=tb_com_borda >";
        $html.="                       <b> 3. Duas referências (fornecedor ou cliente)</b>";				
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td widht=100% align=left class=tb_com_borda >";
        $html.="                       <b> 4. Para contratação superior a 10 linhas ou total de aparelhos no valor superior a R$ 1.500,00 é necessário a documentação abaixo:</b>";			
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr >";
        $html.="                    <td widht=100% align=left class=tb_com_borda>";
        $html.="                       <b> 5. ECF - Escrituração contabil Fiscal.</b>	";			
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr >";
        $html.="                    <td widht=100% align=left class=tb_com_borda>";
        $html.="                      <b> 6. RAIS.	</b>";			
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        
        
        $sql = "";
        $sql.= " Select
                ui.nome,
                ui.email,
                ui.ddd_tel,
                ui.tel
         from usuariosinternos ui
                inner join leads l on ui.codusuariointerno = l.codgerenteconta
         Where l.codlead=".$leads_pk;           

        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $gerenteconta = $row[ nome ];
        $gerenteemail = $row[ email ];
        $ddd_tel = $row[ ddd_tel ];
        $tel = $row[ tel ];
        mysql_free_result($result);	
        
		
	
    if(!empty($gerenteconta)){
        $html.="    <tr>";
        $html.="        <td align= center >";
        $html.="            <table width= 100%  align= center  border= 0  class= texto >";
        $html.="                <tr align= center >";
        $html.="                    <td class= texto  align= left  >";
        $html.="                    <b> ";
        $html.=                         $gerenteconta;
        $html.="                    </b>";	
        $html.="                    </td>";
        $html.="                </tr>";
    if(!empty($tel)){
        $html.="                <tr align= center >";
        $html.="                    <td class= texto   align= left  >";
        $html.="                        <b> ";
        $html.="                        Cel.: (".$ddd_tel.") ".$tel;
        $html.="                        </b>";					
        $html.="                    </td>";
        $html.="                </tr>";
    }	
    if(!empty($gerenteemail)){
        $html.="                <tr align= center >";
        $html.="                    <td class= texto  align= left  >";
        $html.="                        <b>";
        $html.="                        Email: ".$gerenteemail;
        $html.="                        </b>";					
        $html.="                    </td>";
        $html.="                </tr>";
    }		
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
    }
		$html.="    <tr>";
		$html.="        <td   align= center  >";
        $html.="            <font face= ,Verdana, Arial, Helvetica, sans-serif  size= 1  >";
		$html.=                 $v_dsc_rodape;
        $html.="            </font>";
		$html.="        </td>";
		$html.="    </tr>";						
        
        $html.="</table>";
        $html.="</html>";
       
            echo $header;
            echo $html;
       ?>
         <input type="hidden" name="script_header" id="script_header" value= "<?=$header;?>" /> 
         <input type="hidden" name="html" id="script_html" value= "<?=$html;?>" /> 
        <?
	exit();

	mysql_close($con);
       
       
       
       
 
}elseif($operador_pk==6){
    
    $html .="<html>
            <head>
                <style>
                table  {
                        font-family:sans-serif;
                        border:1mm solid whtite;
                        border-collapse: collapse;
                        width:80%;											
                    }    
                    .titulo {
                        font-family:sans-serif;
                        font-size:18px;              
                    }
                    .tb_com_borda {
                        alignment-adjust:central;
                        border-color:#ffc000;
                        font-family:sans-serif;
                        font-size:15px; 

                   
                    .texto{
                            font-family:sans-serif;
                            font-size:10px;                
                    }
                    .sub_titulo{
                    font-family:sans-serif;
                            font-size:30px;       
                    }
        </style>
         </head>";
    
       if($row1[ enviar_proposta_email_pk ]==1){
        $header.="<table width=680  align=center  border=0 >";
        $header.="      <tr>";
        $header.="          <td>";
        $header.="              <table width=680  align=center  border=0 >";
        $header.="                   <tr>";
        $header.="                      <td width=20  align=center >";
        $header.="                          <a href= #  onclick= e_email(".$operador_pk.") ><img src= ../../n_images/email.png  width= 20  title= Enviar proposta /></a>";
        $header.="                      </td>";
        $header.="                  </tr>";
        $header.="                  <tr align= center >";
        $header.="                      <td>";
        $header.="                         <h6> Enviar proposta por email<h6>";
        $header.="                      </td>";
        $header.="                  </tr>";
        $header.="             </table>";
        $header.="          </td>";
        $header.="     </tr>";
        $header.="  </table>";
    }
        $html.="<table width=680 align=center border=0 >";
        $html.="    <thead>";  
        $html.="        <tr>";
        $html.="            <td>";
        $html.="                <table widht=100% align=center >";
        $html.="                    <tr>";
        $html.="                        <td align= center >";
        $html.="                            <img src=http://".$endereco."/n_images/oi2.png  width=100% height=350  >";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="    </thead>";
        $html.="</table>";
        
        
        $html.="<table width=680 align=center border=0 >";       
        $html.="    <thead>";
        $html.="        <tr>";
        $html.="            <td align=center  >";
        $html.="                <table width=100% align=center class=tb_com_borda border=1 >"; 
        $html.="                    <tr>";
        $html.="                        <td width=25% align=center class=tb_com_borda>";
        $html.="                            <img src=http://".$endereco."/n_images/oi.png  width= 25% >";
        $html.="                        </td>";
        $html.="                        <td align=center class=titulo>";
        $html.="                            <i><font color =#70ad47 ><b>PLANOS OI EMPRESAS</b><i></font>";
        $html.="                        </td>";
        $html.="                    </tr>";
        $html.="                </table>";
        $html.="            </td>";
        $html.="        </tr>";
        $html.="    </thead>";
        $sql="";
        $sql="SELECT nip.ddd,
                    npr.ds_produto,
                    nip.vl_unitario,
                    nip.n_qtde,
                    nipo.vl_franquia,
                    produtos_tipo_pk,
                    npr.total_minutos,
                    npr.total_internet
                 FROM n_propostas    np
                  INNER JOIN n_itens_propostas nip ON np.pk = nip.propostas_pk
                  LEFT JOIN n_itens_propostas_operadoras nipo ON nip.pk = nipo.itens_propostas_pk
                  INNER JOIN n_produtos npr ON nip.produtos_pk = npr.pk
                WHERE produtos_tipo_pk IN (1) AND np.pk =".$proposta_pk;
        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center border=1 class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=30% align=center class=tb_com_borda>";
        $html.="                        <b><i>Descrição</i></b>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <b><i>Quantidade</i></b>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <b><i>Valor Unitário</i></b>";
        $html.="                    </td >";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <b><i>Valor Total</i></b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $vl_total_proposta_oi=  0;   
                $result = mysql_query($sql);
            while($row = mysql_fetch_array($result)){
                $vl_total_proposta_oi += $row[ vl_unitario ]*$row[ n_qtde ];
        
        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center border=1 class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=30% align=center class=tb_com_borda>";
        $html.=                         $row[ ds_produto ];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         $row[ n_qtde ];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         "R$".number_format($row[ vl_unitario ],2,",",".");
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         "R$".number_format ($row[ vl_unitario ] * $row[ n_qtde ],2,",","."); 
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
            }
    mysql_free_result($result);        
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center>";
        $html.="                <tr class=texto >";
        $html.="                    <td class=texto  >";
        $html.="                        <h6> <b>Total proposta</b></h6>";
        $html.="                    </td>";
        $html.="                    <td colspan=4 align=right class=texto>";
        $html.="                        <h6> <b>  R$".number_format ($vl_total_proposta_oi,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        $sql="";
        $sql=" select
                npa.n_qtde
                ,npa.vl_unitario
                ,nap. ds_aparelho
                ,npa. parcelamento_pk
                ,npa. vl_desconto_aparelho
                from n_propostas_aparelhos npa
                inner join n_aparelhos nap on npa.aparelhos_pk = nap.pk
                where npa.propostas_pk =".$proposta_pk;
         $results = mysql_query($sql);
        $taparelhos =  mysql_num_rows($results);
        if ($taparelhos >0){
        
       
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center border=1 class=tb_com_borda>";
        $html.="                <tr class=titulo >";
        $html.="                    <td align=center>";
        $html.="                        <i><font color = #4472C4 > APARELHOS </font></i>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center  border=1 class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=20% align=center class=tb_com_borda >";
        $html.="                       <i><b> Quantidade</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda >";
        $html.="                        <i><b>Descrição</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <i><b>Valor Unitário</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <i><b>Parcelas</b></i>";
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.="                        <i><b>Valor mensal</b></i>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        
        
    $total_aparelhos_oi=0;
          $result = mysql_query($sql);
        while($row = mysql_fetch_array($result)){
            $total_aparelhos_oi+=$row[ vl_unitario ]*$row[ n_qtde ];
            
            
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center  border=1 class= tb_com_borda>";
        $html.="                <tr align= center >";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         $row[n_qtde];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         $row[ds_aparelho];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda >";
        $html.=                         "R$".$row[vl_unitario];
        $html.="                    </td >";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         $row[parcelamento_pk];
        $html.="                    </td>";
        $html.="                    <td width=20% align=center class=tb_com_borda>";
        $html.=                         "R$".number_format ($row[ vl_unitario ]/$row[ parcelamento_pk ],2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        }
        
        mysql_free_result($result);
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align=center>";
        $html.="                <tr class= texto >";
        $html.="                    <td  >";
        $html.="                        <h6> <b>Total aparelhos</b></h6>";
        $html.="                    </td>";
        $html.="                    <td colspan=4 align=right class=texto>";
        $html.="                        <h6> <b> R$".number_format ($total_aparelhos_oi,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        }
        
         $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100%  border=1 align=center class=tb_com_borda>";
        $html.="                <tr class=titulo >";
        $html.="                    <td align=center > ";
        $html.="                       <b><i> <font color=#8A30A0 > BENEFÍCIOS</i></b></font>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        
                $minutos = "";
    if($total_minutos ==0 ){
        $minutos = "Ilimitado";
    }else{
        $minutos = $total_minutos;
    }
    
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% border=1 align=center class=tb_com_borda>";
        $html.="                <tr>";
        $html.="                    <td width=40% class=tb_com_borda > ";
        $html.="                        Trade in (Insenção de franquia)";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class=tb_com_borda>";
        $html.=                         $minutos;
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td width=40% class=tb_com_borda> ";
        $html.="                        Pacote de minutos Flat (para qualquer operadora do Brasil)";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class= tb_com_borda>";
        $html.="                        Individual";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td width=40%  class= tb_com_borda> ";
        $html.="                        Pacotes de dados ilimitados Individuais";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class= tb_com_borda>";
        $html.="                        0";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td width=40%  class= tb_com_borda> ";
        $html.="                        10.000 Minutos Individual para ligações oi e Fixo";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class= tb_com_borda>";
        $html.="                        0";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td width=40%  class= tb_com_borda> ";
        $html.="                        Tarifa Zero a vontade";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class= tb_com_borda>";
        $html.="                        0";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td width=40%  class= tb_com_borda> ";
        $html.="                        1.500 SMS para celulares da Oi e 1.500 SMS para outras operadoras";
        $html.="                    </td>";
        $html.="                    <td width=40% align=center class= tb_com_borda>";
        $html.="                        0";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        
        
        $total_tudo =0;
        $total_tudo += $vl_total_proposta_oi + $total_aparelhos_oi; 
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100%  border=1 align= center class=tb_com_borda >";
        $html.="                <tr class=texto >";
        $html.="                    <td width=50%  class=tb_com_borda>";
        $html.="                         <b> Valor total da proposta + Aparelhos </b>";
        $html.="                    </td>";
        $html.="                    <td width=50%  align=right  class=tb_com_borda >";
        $html.="                        <b> R$".number_format($vl_total_proposta_oi + $total_aparelhos_oi,2,",",".");
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            &nbsp;";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% align= center border= 1 class=tb_com_borda >";
        $html.="                <tr class=titulo>";
        $html.="                    <td align= center>";
        $html.="                        <b> Documentação para contratação do plano</b>";				
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
        $html.="    <tr>";
        $html.="        <td>";
        $html.="            <table width=100% border= 1 class=tb_com_borda align= center>";
        $html.="                <tr>";
        $html.="                    <td widht=100% align=left class=tb_com_borda  >";
        $html.="                      <b>1. Cópia do contrato social</b>";
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td widht=100% align=left class=tb_com_borda>";
        $html.="                       <b>2. Cópia do RG E CPF ou CNH	</b>	";		
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="                <tr>";
        $html.="                    <td widht=100% align=left  class=tb_com_borda>";
        $html.="                       <b> 3. Enviar as duas faturas em nome da empresa (Telefonia Movel, Fixa ou Tv por assinatura), com os comprovantes de pagamento</b>";				
        $html.="                    </td>";
        $html.="                </tr>";
        $html.="            </table>";
        $html.="        </td>";
        $html.="    </tr>";
                
        
        $sql = "";
        $sql.= " Select
                ui.nome,
                ui.email,
                ui.ddd_tel,
                ui.tel
         from usuariosinternos ui
                inner join leads l on ui.codusuariointerno = l.codgerenteconta
         Where l.codlead=".$leads_pk;           

        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $gerenteconta = $row[ nome ];
        $gerenteemail = $row[ email ];
        $ddd_tel = $row[ ddd_tel ];
        $tel = $row[ tel ];
        mysql_free_result($result);	
        
		
	
    if(!empty($gerenteconta)){
        $html.="    <tr>";
        $html.="        <td align= center >";
        $html.="            <table width= 100%  align= center  border= 0  class= texto >";
        $html.=                 "<tr align= center >";
        $html.=                     "<td class= texto  align= left  >";
        $html.=			"<b> ";
        $html.=                             $gerenteconta;
        $html.=			"</b>";	
        $html.=                     "</td>";
        $html.=                 "</tr>";
    if(!empty($tel)){
        $html.=	"<tr align= center >";
        $html.=		"<td class= texto   align= left  >";
        $html.=			"<b> ";
        $html.=			"Cel.: (".$ddd_tel.") ".$tel;
        $html.=			"</b>";					
        $html.=		"</td>";
        $html.=	"</tr>";
    }	
    if(!empty($gerenteemail)){
        $html.=	"<tr align= center >";
        $html.=		"<td class= texto  align= left  >";
        $html.=			"<b>";
        $html.=			"Email: ".$gerenteemail;
        $html.=			"</b>";					
        $html.=		"</td>";
        $html.=	"</tr>";
    }		
        $html.=             "</table>";
        $html.="        </td>";
        $html.="   </tr>";
    }
		$html.=	"<tr>";
		$html.=		"<td   align= center  >";
        $html.=			"<font face= ,Verdana, Arial, Helvetica, sans-serif  size= 1  >";
		$html.=                            $v_dsc_rodape;
        $html.=                        "</font>";
		$html.=		"</td>";
		$html.=	"</tr>";						
        
        $html.="</table>";
        $html.="</html>";
       
        
        echo $header;
        echo $html;
?>
         <input type="hidden" name="script_header" id="script_header" value= "<?=$header;?>" /> 
         <input type="hidden" name="html" id="script_html" value= "<?=$html;?>" /> 
        <?
	exit();
    
 mysql_close($con);    
     

}
?>
</form>  


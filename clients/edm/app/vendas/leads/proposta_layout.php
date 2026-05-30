<?php
include_once("../../libs/mpdf/mpdf.php");
include_once '../../libs/conectar.php';
	
conectar();
	
$leads_pk = $_REQUEST['codlead'];
$proposta_pk = $_REQUEST['pk'];
	
$sql = "";
$sql.="SELECT 
            o.cod_operador
        FROM operador o
                   INNER JOIN n_propostas np ON o.cod_operador = np.operador_pk
                   left join leads l on np.leads_pk = l.codlead
                   left join contatoslead cl on l.codlead = cl.codlead
                   INNER JOIN empresa_operador eo ON o.cod_operador = eo.cod_operador
                   INNER JOIN empresa e ON eo.cod_empresa = e.cod_empresa			   
                   LEFT JOIN n_operador_modelo_proposta nom ON o.cod_operador = nom.operador_pk
         WHERE np.pk =".$proposta_pk;
        if(!empty($_SESSION['cod_polo'])){		
               $sql.=" AND cod_polo =".$_SESSION['cod_polo'];
        }
        
        $result = mysql_query($sql);

        $row = mysql_fetch_array($result);
        $operador_pk = $row['cod_operador'];

	mysql_free_result($result);

        
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .titulo {
                font-family: sans-serif;
                font-size: 14px;
                color: #ffffff;
                background: #65009A; 
                alignment-adjust:central;                
            }

            .tb_sem_borda {
                border-color: #ffffff;
                font-family: sans-serif;
                font-size: 12px;                
            }           
             .tb_com_borda {
                alignment-adjust: central;
                border-color: #000000;
                font-size: 9px;
                color: #ffffff;
                background: #65009A; 
                
            }
            .texto {font-family: sans-serif;
                   font-size: 12px;
            
            }
            .tex1 { font-family: sans-serif;
                    font-size:12px;
                    alignment-adjust:central;
            }      
                      
        </style>
    </head>
    <body>

        <table width="680" align="center" border="0"><!--TABELA BASE-->
           <!--PRIMEIRA LINHA-->
           <tr>
               <td class="tb_sem_borda">
                    <table width="100%" > 
                    <tr>
                       <td width="25%" align="center">
                           <img src="img/logo_vivo.jpg" width="40%">
                        </td>
                        <td class="titulo" align="center" >
                            Proposta comercial Smart vivo
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
                <td >
                    <table width="100%" border="1" >	
                        <tr>
                            <td width="48%" class="tb_sem_borda">
                                <b>Razão Social</b>
                                
                            </td>
                            <td width="21%" class="tb_sem_borda">
                                <b> CNPJ</b>
                            </td>
                            <td width="31%" class="tb_sem_borda">
                                <b>Telefone</b>
                            </td>
                         </tr>
                    </table>
              	</td>          
             </tr> 
          	<tr>
                    <td>
                        <table width="100%" align="center" border="1">
                            <tr>
                                <td width="48%" class="tb_sem_borda">
                                    <b>Parceiro</b>
                                </td>
                                <td width="21%"class="tb_sem_borda">
                                    <b>Email</b>
                                </td>
                                <td width="31%"class="tb_sem_borda">
                                    <b>Telefone</b>
                                </td>
                            </tr>
                        </table>
                    </td>         
                </tr>
          <tr>
                <td>
                    <table width="100%" align="center" border="0">
                            <tr>
                                 <td align="center" class="texto">
                                     <b><b>Vivo empresas</b></b>
                                 </td>
                            </tr> 
                            <tr>
                                 <td align="left" class="texto">    
                                    Os planos SmartVivo Empresas oferecem em um único pacote serviços de voz, dados e SMS ilimitado com vantagens exclusivas: ligações locais ou nacionais ilimitadas para a maior comunidade móvel do Brasil, possibilidade de compartilhamento de dados em todas as franquias de dados e SMS ilimitado para qualquer operadora. Tudo isso com a qualidade Vivo na maior e melhor cobertura 3G e 4G! Confira a proposta de valor abaixo pelo melhor custo benefício do mercado.
                                 </td>
                            </tr>
                    </table>
                </td>
           </tr>
        <tr>        	
            <td>
            <table width="100%" align="center" border="0">
                <tr>
                    <td align="center" class="texto">
                        <b>PLANOS</b>
                    </td>
                </tr>
            </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" align="center" border="1"  bgcolor="#65009A"  >
                    <tr   >
                        <td width="76" class="tb_com_borda" align="center">
                            UF
                        </td>
                        <td width="76"  class="tb_com_borda" align="center">
                            DDD
                        </td>
                        <td width="76"  class="tb_com_borda" align="center">
                            NEGOCIAÇÃO
                        </td>
                        <td width="76" class="tb_com_borda" align="center">
                            LINHAS
                        </td>
                        <td width="76" class="tb_com_borda" align="center">
                            DESCRIÇÃO
                        </td>
                        <td width="76" class="tb_com_borda" align="center">
                            VALOR SEM DESCONTO
                        </td>
                        <td width="76" class="tb_com_borda" align="center">
                            DESCONTO
                        </td>
                        <td width="76"class="tb_com_borda" align="center">
                            VALOR COM DESCONTO
                        </td>
                        <td width="76" class="tb_com_borda" align="center">
                            VALOR FINAL PLANOS
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--<tr>
            <td>
                <table width="100%" align="center" border="1">
                    <tr>
                        <td width="11%"class="tex1">
                        SP
                        </td>
                        <td width="11%" class="tex1">
                        11
                        </td>
                        <td width="11%">
                        Habilitação (ALTA)
                        </td>
                        <td width="11%" class="tex1">
                        1
                        </td>
                        <td width="11%" class="tex1"> 
                        Local smartivo EMP 20G 600           	
                        </td>
                        <td width="11%" class="tex1">
                        R$:251,99                    	
                        </td>
                        <td width="11%" class="tex1">
                        R$:110,00
                        </td>
                        <td width="11%" class="tex1">
                        R$:141,99
                        </td>
                        <td width="11%" class="tex1">
                        R$:141,99
                        </td>
                    </tr>
                </table>
            </td>
        </tr> -->
        <tr>
            <td> 
                <table width="100%" align="left" border="0">
                    <tr>
                        <td align="left" class="texto">
                             <h6> -Valores referenciados não considerados serviçoes adicionais ,excedentes ou parcelas de aparelhos </h6>

                        </td>
                    </tr>
                 </table>
            </td>
        </tr>
       <tr>
       	<td>
        	<table width="100%" align="center" border="0">
                    <td align="center" class="texto">
                	<b> Resumo de Proposta</b>
                </td>
            </table>
        </td>
       </tr>
       <tr>
       	<td>
        	<table width="100%" align="center" border="1" bgcolor="#65009A">
            	<tr>
                	<td width="76" class="tb_com_borda" align="center">
                    	Quantidade de linhas
                    </td>
                    <td width="76" class="tb_com_borda" align="center">
                    	Ligações Vivo X Vivo
                    </td>
                    <td width="76" class="tb_com_borda" align="center">
                     	Total minutos                   	
                    </td>
                    <td width="76" class="tb_com_borda" align="center">
                    	Total internet
                    </td>
                    <td width="76" class="tb_com_borda" align="center">
                    	Total SMS
                    </td>
                </tr>
            </table>
        </td>
       </tr>
       <tr>
       	<td>
        	<table width="100%" align="center" border="1">
            	<tr>
                    <td width="10%" class="tb_sem_borda">
                        <img src="img/celvivo.jpg" width="40%">
                    </td>
                    <td width="10%" align="center" class="tb_sem_borda">
                        &nbsp;
                    </td>
                    <td width="10%" class="tb_sem_borda">
                        <img src="img/paisvivo.jpg" width="40%"  
                    </td>
                    <td width="10%"class="tb_sem_borda">
                    	&nbsp;
                    </td>
                    <td width="10%"class="tb_sem_borda">
                    	<img src="img/chatvivo.jpg" width="40%"
                    </td>
                    <td width="10%"class="tb_sem_borda">
                    	&nbsp;
                    </td>
                    <td width="10%" class="tb_sem_borda">
                    	<img src="img/arrobavivo.jpg" width="40%"
                    </td>
                    <td width="10%" align="center" class="tb_sem_borda">
                    	&nbsp;
                    </td>
                    <td width="10%" class="tb_sem_borda">
                    	<img src="img/emailvivo.jpg" width="40%"
                    </td>
                    <td width="10%" align="center" class="tb_sem_borda">
                        &nbsp;
                    </td>                        
                </tr>
            </table>
        </td>
       </tr>
       <tr>
            <td>
                <table width="100%" align="left" border="0">
                    <tr>
                        <td align="left" class="texto">
                            <h6> **Valor sem a inclusão da parcela de aparelho ou excedentes </h6>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" align="center" border="0">
                    <tr>
                        <td align="center">
                            <b> Serviçoes adicionais </b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="1" class="tb_com_borda">
                        <tr>
                            <td width="25%" align="center" class="tb_com_borda">
                                Quantidade                    	
                            </td>
                            <td width="25%" align="center" class="tb_com_borda">
                                Descrição
                            </td>
                            <td width="25%" align="center" class="tb_com_borda">
                                Valor serviço
                            </td>
                            <td width="25%" align="center" class="tb_com_borda">
                                Valor total serviço
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="1"> 
                        <tr>
                            <td width="25%" align="center">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="1">
                        <tr>
                            <td width="25%" align="center">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="1">
                        <tr>
                            <td width="25%" align="center">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                            <td width="25%">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="0">
                        <tr>
                            <td align="center" class="texto">
                                <b>Valor Total </b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="1" class="tb_com_borda">
                        <tr>
                            <td width="50%" align="center" class="tb_com_borda">
                                Quantidade de linhas
                            </td>
                            <td width="50%" align="center" class="tb_com_borda">
                                Valor total de serviçoes**
                            </td>
                        </tr>
                    </table>
                 </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="1">
                        <tr>
                            <td width="16%" class="tb_sem_borda">
                                <img src="img/celvivo.jpg">
                            </td>
                            <td width="17%" align="center" class="tb_sem_borda">
                                &nbsp;
                            </td>
                            <td width="33%" align="center" class="tb_sem_borda">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="0">
                        <tr>
                            <td align="center" clas="texto">
                                <h6>** Valor sem a inclusão da parcela de aparelho ou excedentes </h6>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                 <td>
                     <table width="100%" align="center" border="0">
                        <tr>
                            <td align="center" class="texto">
                                <b> Aparelhos </b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="1" class="tb_com_borda">
                        <tr>
                            <td width="20%" align="center" class="tb_com_borda">
                                Quantindade
                            </td>
                            <td width="20%" align="center" class="tb_com_borda">
                                Modelo
                            </td>
                            <td width="20%" align="center" class="tb_com_borda">
                                Valor Aparelho
                            </td>
                            <td width="20%" align="center" class="tb_com_borda">
                                Parcelas
                            </td>
                            <td width="20%" align="center" class="tb_com_borda">
                                Total parcelas aparelho
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="1">
                        <tr>
                            <td width="20%" align="center" class="tb_sem borda">
                                &nbsp;
                            </td>
                            <td width="20%" class="tb_sem borda">
                                &nbsp;
                            </td>
                            <td width="20%" class="tb_sem borda">
                                &nbsp;
                            </td>
                            <td width="20%" class="tb_sem borda">
                                &nbsp;
                            </td>
                            <td width="20%" class="tb_sem borda">
                                &nbsp;
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table width="100%" align="center" border="0">
                        <tr>
                            <td width="50%" align="left" class="tb_sem_borda">
                                <h6> Total mensal aparelho</h6>
                            </td>
                            <td width="50%" align="right" class="tb_sem_borda">
                                <h6> R$45,00 </h6>
                            </td>
                        </tr>
                    </table>         
                </td>
            </tr>
 </table>
        <div style="page-break-after: always"></div>
    <table width="680" align="center" border="0">
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td  align="center" class="titulo" class="tb_sem_borda">
                            <b> Conheça também outros serviços da Vivo</b> 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" align="center" border="0">
                    <tr>
                        <td width="33%" align="center">
                            <img src="img/3.jpg" width="40%"> 
                        </td>
                        <td width="33%">
                            <img src="img/2.jpg" width="40%">
                        </td>
                        <td width="33%">
                            <img src="img/1.jpg" width="40%">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" align="center" border="0">
                    <tr>
                        <td width="25%">
                            <table border="1">
                                <tr>
                                    <td colspan="2" class="tb_com_borda">
                                        Valores excendentes
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb_com_borda">
                                       VC1 On Net
                                    </td>
                                    <td class="tb_sem_borda">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb_com_borda">
                                        VC1 Off Net
                                    </td>
                                    <td class="tb_sem_borda">
                                         &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb_com_borda">
                                        VC1 Móvel Fixo
                                    </td>
                                    <td class="tb_sem_borda">
                                         &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb_com_borda">
                                        VC2VC3 on Net
                                    </td>
                                    <td class="tb_sem_borda">
                                         &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb_com_borda">
                                       VC2/VC3 Off Net 
                                    </td>
                                    <td class="tb_sem_borda">
                                         &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb_com_borda">
                                        VC2/VC3 Móvel Fixo 
                                    </td>
                                    <td class="tb_sem_borda">
                                         &nbsp;

                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                </table>
            </td> 
        </tr>
        <tr>
            <td>
                <table width="100%" align="center" border="0">
                    <tr>
                        <td align=left" class="texto">
                            <b>Documentos Necessários</b>
                            <p>Cópia do cartão CNPJ;
                            Cópia do RG e CPF do representante legal;
                            Cópia do Contrato Social e Última Alteração Contratual (se tiver) ou documento que comprove a competência de assinatura do representante legal da
                            empresa;
                            Cópia da procuração (se aplicável).
                            Em caso de necessidade, podem ser solicitados documentos adicionais</p>
                            <br> <b> Condições gerais</b>
                            <br><p> A presente proposta não representa solicitação de pedido e tem como única função prover preços de referência.
                            Para efetivação das condições comerciais e contratação do serviço constante na presente proposta, será necessária a devida assinatura do formulário de
                            Solicitação de Serviço, que é parte integrante do contrato registrado em cartório, e o envio do mesmo á Vivo.
                            </p>
                            <br>
                            <b>A presente proposta tem uma vigência de 5 (cinco) dias a partir da data da emissão deste documento. Após este período, será obrigatória a
                            revalidação dos custos e a Vivo não se compromete em manter os valores inicialmente apresentados.
                            </b>
                            <br> <p> Todos os valores informados a título de orçamento são suscetíveis a alteração quando da execução de estudo de viabilidade técnica do atendimento, após
                            aceite por parte do cliente.
                            Aparelhos sujeitos à disponibilidade do estoque. Caso não haja disponibilidade na data da contratação, será realizada nova proposta com valores dos
                            aparelhos disponíveis em estoque.
                            Os valores da presente proposta incluem todos os tributos.
                            Prazo de entrega de 20 dias úteis.
                            Em casos de aquisição de aparelho e havendo rescisão contratual antes do término do contrato, haverá a cobrança de valor residual do aparelho,
                            correspondente a seguinte equação:
                            Valor do aparelho dividido pela quantidade de meses de contrato, multiplicado pelos meses restantes de contrato.
                            Ex: R$240,00 dividido por 24 meses de contrato=R$10,00
                            Contrato cancelado com 22 meses=R$10,00 X 2 meses=R$20,00 valor residual
                            </p>
                            <br>
                            <b>Período de permanência nos planos contratados: 24 meses.</b>
                            <br><b>Confidencialidade</b>
                            <br><p> A Vivo está ciente que as informações contidas neste documento são confidenciais e não deverão ser divulgadas fora do âmbito desta sem uma prévia
                            autorização do Cliente, ao mesmo tempo que, solicitamos do Cliente tal consideração para as informações contidas nesta proposta.
                            Da mesma maneira, não poderá ser objeto de empréstimo, aluguel ou qualquer forma de cessão de uso sem o consentimento prévio por escrito da Vivo,
                            titular do copyright. O não cumprimento das limitações citadas, por qualquer pessoa que tenha acesso à documentação, estará sujeito às sanções previstas previstas em lei.</p>
                            <br><b>Próximos Passos</b>
                            <p> Entrega da documentação;
                                Recebimento do termo de adesão e contrato;
                                Assinatura do Contrato;
                                Recebimento dos aparelhos e ativação do serviço.
                                Em caso de dúvidas, entre com contato com o seu gerente de negócios ou com um parceiro homologado Vivo.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
  
</html>

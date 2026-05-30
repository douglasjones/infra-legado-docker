<?
require_once "../inc/php/header.php";
?>
<script src="layout_admissao_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
@media print{
   #noprint{
       display:none;
   }
}


</style>
<div id="noprint">
    <br>
    <div class="row" >
        <br>
        <div class="col-md-12" align="center" >
            <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-primary" id="cmdImprimir" data-dismiss="modal">Imprimir</button>

        </div>

    </div>
    <br>
</div>
<page size='A4'>
    <div class='container'>
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% align='center' >
            <tr>
                <td width="25%" align='center'>
                    <!--img src='../img/nlogo.png' width='80%'-->
                </td>
                <td width="50%" align='center'>
                    <font size='2px'><b>FICHA DE FUNCIONÁRIO<br>
                        MATRÍCULA <span class='ds_matricula'></span><br>
                        E-Social <span class='ds_re'></span></b></font>
                </td>
                <td width="25%" align='right'>
                    <div class='ds_imagem'></div>
                </td>
            </tr>
        </table>
        <br>
        <table  width=100% style='border-style: solid;'>           
            <thead>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='4' width='60%' style='border-style: solid;'align=left>
                         <b>Nome Completo
                         </b>
                     </th>
                     <th  colspan='2' width='30%' style='border-style: solid;'align=left>
                         <b>Data de Nascimento / Local
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='4' width='60%' style='border-style: solid;'align=left>
                         <span class='ds_colaborador'></span>
                     </td>
                     <td colspan='2' width='30%' style='border-style: solid;'align=left>
                         <span class='dt_nascimento'></span> / <span class='ds_cidade'></span> / <span class='uf'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>CPF
                         </b>
                     </th>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>RG
                         </b>
                     </th>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Órgão Exped./Data de Exped
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='33%' style='border-style: solid;'align=left>
                         <span class='ds_cpf'></span>
                     </td>
                     <td colspan='2'  width='33%' style='border-style: solid;'align=left>
                         <span class='ds_rg'></span>
                     </td>
                     <td colspan='2' width='33%' style='border-style: solid;'align=left>
                         <span class='ds_uf_rg'></span> / <span class='ds_org_exp'></span> / <span class='dt_expedicao'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' style='border-style: solid;'align=left>
                         <b>Sexo:</b> <span class='ds_genero'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' style='border-style: solid;'align=left>
                         <b>Nome da Mãe:</b> <span class='ds_nome_mae'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' style='border-style: solid;'align=left>
                         <b>Nome do Pai:</b> <span class='ds_nome_pai'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' style='border-style: solid;'align=left>
                         <b>Título Eleitor:</b> <span class='ds_titulo_eleitoral'></span> / <b>Zona:</b> <span class='ds_zona_eleitoral'></span> / <b>Seção:</b> <span class='ds_secao'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='5' width='60%' style='border-style: solid;'align=left>
                         <b>Carteira Motorista
                         </b>
                     </th>
                     <th  width='30%' style='border-style: solid;'align=left>
                         <b>Tipo / Data de Validade
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='5' width='60%' style='border-style: solid;'align=left>
                         &nbsp;
                     </td>
                     <td  width='30%' style='border-style: solid;'align=left>
                        00/00/0000
                     </td>
                 </tr>

                 <tr style='border-style: solid;' align=left>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>CTPS / Data de Emissão
                         </b>
                     </th>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Série (CTPS) / Estado
                         </b>
                     </th>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>PIS/PASEP
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='33%' style='border-style: solid;'align=left>
                         <span class='ds_ctps'></span>
                     </td>
                     <td  colspan='2' width='33%' style='border-style: solid;'align=left>
                        <span class='ds_serie'></span>
                     </td>
                     <td  colspan='2' width='33%' style='border-style: solid;'align=left>
                        <span class='ds_pis'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='5' width='60%' style='border-style: solid;'align=left>
                         <b>Logradouro(Rua/Avenida)
                         </b>
                     </th>
                     <th  width='30%' style='border-style: solid;'align=left>
                         <b>Complemento
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='5' width='60%' style='border-style: solid;'align=left>
                       <span class='ds_endereco'></span> , <span class='ds_numero'></span>
                     </td>
                     <td  width='30%' style='border-style: solid;'align=left>
                       <span class='ds_complemento'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='5' width='60%' style='border-style: solid;'align=left>
                         <b>Bairro
                         </b>
                     </th>
                     <th  width='30%' style='border-style: solid;'align=left>
                         <b>Cep
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='5' width='60%' style='border-style: solid;'align=left>
                       <span class='ds_bairro'></span>
                     </td>
                     <td  width='30%' style='border-style: solid;'align=left>
                       <span class='ds_cep'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='5' width='80%' style='border-style: solid;'align=left>
                         <b>Cidade
                         </b>
                     </th>
                     <th  width='20%' style='border-style: solid;'align=left>
                         <b>UF
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='5' width='80%' style='border-style: solid;'align=left>
                       <span class='ds_cidade'></span>
                     </td>
                     <td  width='30%' style='border-style: solid;'align=left>
                       <span class='ds_uf'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' style='border-style: solid;'align=left>
                         <b>E-mail:</b><span class='ds_email'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th width='15%' style='border-style: solid;'align=left>
                         <b>Nº Sapato</b>
                         
                     </th>
                     <th  width='15%' style='border-style: solid;'align=left>
                         <b>Nº Calça</b>
                     </th>
                     <th  width='15%' style='border-style: solid;'align=left>
                         <b>Tamanho Camisa</b>
                     </th>
                     <th  width='15%' style='border-style: solid;'align=left>
                         <b>Banco
                         </b>
                     </th>
                     <th  width='15%' style='border-style: solid;'align=left>
                         <b>Agência
                         </b>
                     </th>
                     <th  width='15%' style='border-style: solid;'align=left>
                         <b>Op / Nº Conta
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td width='15%' style='border-style: solid;'align=left>
                        <span class='ds_n_sapato'></span>
                     </td>
                     <td  width='15%' style='border-style: solid;'align=left>
                        <span class='ds_n_camisa'></span> </b>
                     </td>
                     <td  width='15%' style='border-style: solid;'align=left>
                        <span class='ds_n_calca'></span>
                     </td>
                     <td  width='15%' style='border-style: solid;'align=left>
                         <span class='ds_banco'></span>
                     </td>
                     <td  width='15%' style='border-style: solid;'align=left>
                         <span class='ds_agencia'></span>
                     </td>
                     <td  width='15%' style='border-style: solid;'align=left>
                        <span class='ds_conta'></span> - <span class='ds_digito'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Telefone Residencial
                         </b>
                     </th>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Telefone Celula
                         </b>
                     </th>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Telefone para Recado
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='33%' style='border-style: solid;'align=left>
                         <span class='ds_cel'></span>
                     </td>
                     <td  colspan='2' width='33%' style='border-style: solid;'align=left>
                       <span class='ds_cel2'></span>
                     </td>
                     <td  colspan='2' width='33%' style='border-style: solid;'align=left>
                       <span class='ds_cel3'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='5' width='33%' style='border-style: solid;'align=left>
                         <b>Estado Civil 
                         </b>
                     </th>
                     <th  width='33%' style='border-style: solid;'align=left>
                         <b>Grau de Instrução
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='5' width='33%' style='border-style: solid;'align=left>
                        <span class='ds_estado_civil'></span>
                     </td>
                     <td   width='33%' style='border-style: solid;'align=left>
                       <span class='ds_escolaridade'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' width='33%' style='border-style: solid;'align=left>
                         <b>Nome do Cônjugue:</b> <span class='ds_nome_conjuge'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' width='33%' style='border-style: solid;'align=left>
                         <b>Quantidade de Dependentes:</b> <span class='qtde_filho'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='6' width='33%' style='border-style: solid;'align=left>
                         <b>Nome do Dependente / Dt de Nascimento / CPF
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' width='33%' style='border-style: solid;'align=left>
                         <span class='ds_nome_filho'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Função/CBO 
                         </b>
                     </th>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Posto de Trabalho
                         </b>
                     </th>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Salário Mensal
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='33%' style='border-style: solid;'align=left>
                         <span class='ds_produto_servico'></span>
                     </td>
                     <td  colspan='2' width='33%' style='border-style: solid;'align=left>
                       &nbsp;
                     </td>
                     <td  colspan='2' width='33%' style='border-style: solid;'align=left>
                       <span class='vl_salario'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='2' width='33%' style='border-style: solid;'align=left>
                         <b>Data de Admissão
                         </b>
                     </th>
                     <th colspan='1' width='33%' style='border-style: solid;'align=left>
                         <b>Vale Refeição (VR)
                         </b>
                     </th>
                     <th colspan='1' width='33%' style='border-style: solid;'align=left>
                         <b>Vale Transp Urb
                         </b>
                     </th>
                     <th colspan='1' width='33%' style='border-style: solid;'align=left>
                         <b>Vale Transp Met
                         </b>
                     </th>
                     <th colspan='1' width='33%' style='border-style: solid;'align=left>
                         <b>1º Emprego
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='33%' style='border-style: solid;'align=left>
                         <span class='dt_admissao'></span>
                     </td>
                     <td colspan='1' width='33%' style='border-style: solid;'align=left>
                        <span class='ds_vl_transporte'></span>
                     </td>
                     <td colspan='1' width='33%' style='border-style: solid;'align=left>
                         <span class='ds_vr'></span>
                         
                     </td>
                     <td colspan='1' width='33%' style='border-style: solid;'align=left>
                         &nbsp;
                     </td>
                     <td colspan='1' width='33%' style='border-style: solid;'align=left>
                         &nbsp;
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='5' width='33%' style='border-style: solid;'align=left>
                         <b>Horário de Trabalho
                         </b>
                     </th>
                     <th colspan='1' width='33%' style='border-style: solid;'align=left>
                         <b>Carga Hora
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='5' width='33%' style='border-style: solid;'align=left>
                        Turno: <span class='ds_turno'></span><br>
                        Iníno Expediente:  <span class='hr_inicio_expediente'></span><br>
                        Termino Expediente:  <span class='hr_termino_expediente'></span><br>
                        Escala:  <span class='n_qtde_dias_semana'></span><br>
                     </td>
                     <td  colspan='1' width='33%' style='border-style: solid;'align=left>
                      <span class='ds_carga_horaria_semanal'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' >
                     <th colspan='4' width='33%' style='border-style: solid;'align=left>
                         <b>GAIASOFT
                         </b>
                     </th>
                     <th colspan='2' style='border-style: solid;'align=left>
                         IMPRESSÃO: DIESSIC
                     </th>
                 </tr>

             </thead>
             <tbody>

                  <tr >
                      <td  colspan=3 align=center>
                          <br><br><b>________________________________________, _____/_____/________</b>
                      </td>
                      <td  colspan=3 align=center>
                          <br><br><b>______________________________________</b>
                      </td>
                  </tr>
                  <tr >
                      <td  colspan=3 align=center>
                          <b>Local e Data</b>
                      </td>
                      <td  colspan=3 align=center>
                          <b>Assinatura do Funcionário</b>
                      </td>
                  </tr>
                  <tr >
                      <td  colspan=6 align=center>
                          &nbsp;
                      </td>
                  </tr>
                  <tr >
                      <td  colspan=3 align=center>
                          &nbsp;
                      </td>
                      <td  colspan=3 align=center>
                         <b><span class='ds_colaborador'></span> - RG: <span class='ds_cpf'></span></b>
                      </td>
                  </tr>
                  <tr >
                      <td  colspan=6 align=center>
                          &nbsp;
                      </td>
                  </tr>
                  <tr >
                      <td  colspan=6 align=center>
                          &nbsp;
                      </td>
                  </tr>
             </tbody>
        </table> 
        
        
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% align='center'>
            <tr>
                <td width="25%" align='center'>
                    <!--img src='../img/nlogo.png' width='80%'-->
                </td>
                <td width="50%" align='center'>
                    <font size='2px'><H2>RECIBO</H2></font>
                </td>
            </tr>
        </table>
        <table  width=100%>           
            <thead>
                <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                 <tr  align=left>
                     <th colspan='6' width='60%' align=left>
                         <b>Recebi de:  <span class='ds_empresa'></span> - <span class='ds_cnpj'></span>
                         </b>
                     </th>
                 </tr>
                 <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                 <tr  align=left>
                     <th colspan='6' width='60%' align=left>
                         a importância de _______________________________________________________ R$ Referente a:________________________________________________________
                     </th>
                 </tr>
                 <tr  align=left>
                     <th colspan='6' width='60%' align=left>
                        _____________________________________________________________________________________________________________________________________________________
                     </th>
                 </tr>
                 <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                <tr  align=left>
                     <th colspan='3' width='60%' align=left>
                         <b>Nome: <span class='ds_colaborador'></span></b>
                     </th>
                     <th colspan='3' width='60%' align=left>
                         <b>CPF: <span class='ds_cpf'></span></b>
                     </th>
                 </tr>
                 <tr >
                      <td  colspan=3 align=center>
                          <br><br><b>________________________________________, _____/_____/________</b>
                      </td>
                      <td  colspan=3 align=center>
                          <br><br><b>______________________________________</b>
                      </td>
                  </tr>
                  <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                  <tr >
                      <td  colspan=3 align=center>
                          <b>Local e Data</b>
                      </td>
                      <td  colspan=3 align=center>
                          <b>Assinatura do Funcionário</b>
                      </td>
                  </tr>
            </thead>
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% align='center'>
            <tr>
                <td width="25%" rowspan="2" align='center'>
                    <!--img src='../img/nlogo.png' width='80%'-->
                </td>
                <td width="50%" align='center'>
                    <font size='4px'><B><span class='ds_empresa'></span></B></font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='center'>
                    <font size='3px'>Comprovante de Devolução da Carteira de Trabalho e Previdência Social</font>
                </td>
            </tr>
        </table>
        <table  width=100%>           
            <thead>
                <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                 <tr  align=left>
                     <th colspan='6' width='60%' align=left>
                         <b>Nome do Funcionário: <span class='ds_colaborador'></span>
                         </b>
                     </th>
                 </tr>
                 <tr  align=left>
                     <th colspan='3' width='60%' align=left>
                         <b>Carteira Profissional n.º: 
                         </b>
                     </th>
                 </tr>
                 <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                 <tr  align=left>
                     <th colspan='3' width='60%' align=left>
                         &nbsp;
                     </th>
                     <th colspan='2' width='60%' align=left>
                         <b>PROTOCOLO:</b>______________________________________________
                         
                     </th>
                 </tr>
                 
                 <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                 <tr >
                      <td  colspan=3 align=center>
                          <br><br><b>________________________________________, _____/_____/________</b>
                      </td>
                      <td  colspan=3 align=center>
                          <br><br><b>______________________________________</b>
                      </td>
                  </tr>
                  <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                  <tr >
                      <td  colspan=3 align=center>
                          <b>Local e Data</b>
                      </td>
                      <td  colspan=3 align=center>
                          <b>Assinatura do Funcionário</b>
                      </td>
                  </tr>
            </thead>
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% align='center'>
            <tr>
                <td width="25%" rowspan="2" align='center'>
                    <!--img src='../img/nlogo.png' width='80%'-->
                </td>
                <td width="50%" align='center'>
                    <font size='4px'><B><span class='ds_empresa'></span></B></font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='center'>
                    <font size='3px'>Matriz: <span class='ds_endereco_empresa'></span><br>
                        Fone: <span class='ds_tel_empresa'></span><br>
                        <span class='ds_email_empresa'></span>
                    </font>
                </td>
            </tr>
            
        </table>
        
        <table  width=100%>           
            <thead>
                <tr>
                    <td width="100%">
                        _________________________________________________________________________________________________________________________________________________________________
                    </td>
                </tr>
                <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                 <tr  align=center>
                     <th colspan='6' width='60%' align=center>
                         <b><u>DIRETRIZES</u></b>
                     </th>
                 </tr>
                 <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                 <tr  align=left>
                     <th colspan='6' width='100%' align=left>
                         <b><font size='4px'>01. ESTOU CIENTE DO CONTRATO DE EXPERIÊNCIA, BEM COMO DO SALÁRIO E ASSIDUIDADE;<br>
                            02. ESTOU CIENTE EM CASO DE FALTAS SEM AVISAR AEMPRESA, SUSPENSÃO DE ATÉ TRÊS DIAS E PASSIVO DE JUSTA<br>
                            CAUSA;<br>
                            03. ESTOU CIENTE QUE DEVO USAR UNIFORME;<br>
                            04. ESTOU CIENTE QUE DEVO USAR OS EPI´s, A TÍTULO DE EMPRÉSTIMO PARA MEU USO EXCLUSIVO E OBRIGATÓRIO<br>
                            NAS DEPENDÊNCIAS DA EMPRESA, CONFORME DETERMINADO NANR-6;<br>
                            05. ESTOU CIENTE QUE O SALÁRIO É PAGO NO QUINTO DIAÚTIL DE CADAMÊS;<br>
                            06. ESTOU CIENTE QUE AEMPRESANÃO FAZ ADIANTAMENTO;<br>
                            07. ESTOU CIENTE QUE DEVO MANTER O ASSEIO DURANTE MEU HORÁRIO DE TRABALHO;<br>
                            08. ESTOU CIENTE QUE A EMPRESA EXIGE RESPEITO DE FORMARIGOROSANOS HORÁRIOS DE TRABALHO;<br>
                            09. ESTOU CIENTE QUE NÃO É PERMITIDO FUMAR NAS DEPENDÊNCIAS DA EMPRESA, APENAS FORA DO LOCAL DE TRABALHO;<br>
                            10. ESTOU CIENTE QUE NÃO DEVO UTILIZAR O APARELHO CELULAR NO HORÁRIO DE TRABALHO, TELEFONEMAS<br>
                            PARTICULARES SE NECESSÁRIO, DEVEM SER COMUNICADOS PARAO ENCARREGADO E/OU SUPERVISOR;<br>
                         </font ></b>
                     </th>
                 </tr>
                 <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan=6 width="100%" align='left'>
                        <font size='3px'>Cliente:
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan=6 width="100%" align='left'>
                        <font size='3px'>Nome: <span class='ds_colaborador'></span>
                        </font>
                    </td>
                </tr>
                 
                 <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                 <tr >
                      <td  colspan=6 align=left>
                          <br><br><font size='3px'><b>Assinatura:______________________________________</b></font>
                      </td>
                  </tr>
                  <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                <tr >
                    <td  colspan=6 align=left>
                        <br><br><b>______________________________________</b>
                    </td>
                </tr>
                <tr>
                    <td colspan='2' width="25%">
                       &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                    <td colspan='2'>
                        &nbsp;
                    </td>
                </tr>
                  <tr >
                      <td  colspan=6 align=left>
                          <font size='3px'><b><span class='ds_empresa'></span><br> <span class='ds_cnpj'></span></b></font>
                      </td>
                  </tr>
            </thead>
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% align='center'>
            <tr>
                <td width="50%" align='center'>
                    <font size='4px'><B> ORDEM DE SERVIÇO - OS</B></font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='center'>
                    <font size='2px'>em cumprimento a normativa de número 1 (NR-01.b)<BR>
                            1.7 Cabe ao empregador: (a) cumprir e fazer cumprir as disposições legais e regulamentares sobre segurança e medicina do trabalho; b) elaborar ordens de serviço sobre segurança<BR>
                            e saúde no trabalho, dando ciência aos empregados por comunicados.

                    </font>
                </td>
            </tr>
            
        </table>
        
        <table  width=100% style='border-style: solid;'>           
            <thead>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>Empresa:<span class='ds_empresa'></span>
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='4' width='60%' style='border-style: solid;'align=left>
                         <b>Nome:<span class='ds_colaborador'></span>
                         </b>
                     </th>
                     <th colspan='2' width='60%' style='border-style: solid;'align=left>
                         <b>Cargo:<span class='ds_produto_servico'></span>
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>ATIVIDADES DESENVOLVIDAS
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'>romover a limpeza, asseio e higiene de ambientes diversos como salas, áreas comuns, salões entre outros, fazer varrição, coleta de lixo, passar panos<br>
                                        úmidos no chão, tirar poeira, limpar vidros, lavar panos, aplicar desinfetantes, detergentes e outros produtos de limpeza já diluídos, organizar ambientes.<br>
                                        Em situações específicas de prestação de serviços.

                        </font>
                    </td>
                </tr>
                 <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>RISCO DA OPERAÇÃO
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'>Riscos Químico: Produtos químicos na utilização para limpeza em geral;<br>
                                        Riscos Biológico:Microorganismos e parasitas infecciosos vivos e seus tóxicos.<br>
                                        Riscos Ergonômicos: Postura inadequada;<br>
                                        Riscos de acidentes: quedas, colisões, escorregões
                        </font>
                    </td>
                </tr>
                 <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>EPI's RECOMENDADOS
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'>Protetor Auricular (quando necessário).<br>
                                        Bota de segurança<br>
                                        Bota de PVC<br>
                                        Luvas (conforme a necessidade)<br>
                                        Uniforme Completo<br>
                                        Óculos de segurança (quando necessário)<br>
                                        Mascaras descartável (quando necessário)<br>
                                        Cinto de segurança
                        </font>
                    </td>
                </tr>
                <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>MEDIDAS PREVENTIVAS
                         </b>
                     </th>
                </tr>
                <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'> - Antes de iniciar seu trabalho verifique seus instrumento de trabalho se estão com defeito. Caso evidencia alguma falha comunique seu superior imediato e espere correção do problema;<br>
                                        - Não opere os equipamentos com alguma dúvida operacional ou sem treinamento;<br>
                                        - Não é permitido fazer ajustes ou reparos em equipamento com o mesmo em funcionamento;<br>
                                        - Éexpressamente proibido remover ou burlar qualquer dispositivo de segurança destinado a proteção dos usuários;<br>
                                        - Só é permitido realizar limpeza no equipamento totalmente desenergizado;<br>
                                        - Não realize nenhuma tarefa sem ter conhecimento;<br>
                                        - Respeitar sinalização de segurança;<br>
                                        - Não faça improvisações de qualquer natureza para executar as tarefas diárias;<br>
                                        - Não é permitido em hipótese alguma mexer em quadros de distribuição de energia ou painel energizado;<br>
                                        - Não faça ou permita fazer brincadeiras desnecessárias quando estiver laborando ;<br>
                                        - Informe ao responsável imediato qualquer irregularidade evidenciada no seu ambiente de trabalho;<br>
                                        - Proceder à frequente higienização das mãos;<br>
                                        - Manter os cabelos presos e arrumados e unhas limpas, aparadas e sem esmalte;<br>
                                        - Os profissionais do sexo masculino devem manter os cabelos curtos e barba feita;<br>
                                        - O uso de Equipamento de Proteção Individual (EPI) deve ser apropriado para a atividade a ser exercida;<br>
                                        - Para a limpeza de pisos, devem ser seguidas as técnicas de varredura úmida, ensaboar, enxaguar e secar;<br>
                                        - Todos os equipamentos deverão ser limpos a cada término da jornada de trabalho;<br>
                                        - Sempre sinalizar os corredores, deixando um lado livre para o trânsito de pessoal, enquanto se procede à limpeza do outro lado;<br>
                                        - Utilizar placas sinalizadoras e manter os materiais organizados, a fim de evitar acidentes e poluição visual;<br>
                                        - Trabalhe com os EPI's recomentados;<br>
                                        - Participar dos exames periódicos quando convocado;<br>
                                        - Não levantar nem transportar peso acima da sua capacidade física, se precisar peça ajuda;<br>
                                        - Cumprir as disposições legais e regulamentadoras sobre Segurança e Medicina do Trabalho;<br>
                                        - Maquinas não é transporte coletivo e nem escada use apenas para finalidade que se destina;<br>
                                        - Não improvise EPI's e EPC's;<br>
                        </font>
                    </td>
                </tr>
                <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>PROIBIÇÕES
                         </b>
                     </th>
                </tr>
                <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'> - É proibido o consumo de alimentos e bebidas nos postos de trabalho, devendo para tal usar os locais apropriados;<br>
                                            - É proibido obstruir com qualquer objeto o acesso aos extintores;<br>
                                            - É proibido guardar alimentos em locais inapropriados para esse fim;<br>
                                            - É proibido fumar, consumir bebidas alcoólicas ou substancias análogasno interior dos setores de trabalho.<br>
                        </font>
                    </td>
                </tr>
                <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>NORMAS INTERNAS
                         </b>
                     </th>
                </tr>
                <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'> - É proibido o uso de celulares no horário de expediente (salvo quando necessário) A empresa disponibilizara um telefone para recados pessoais.<br>
                                            - É proibido expor ou utilizar a imagem da empresa indevidamente<br>
                                            - Utiliza o uniforme com a logo da empres aapenas a trabalho<br>
                                            - Todo funcionário deverá ter o cuidado necessário com a sua apresentação pessoal, mantendo o seu uniforme limpo, e manter a higiene pessoal. (Manter cabelos, unhas, barba e bigodes aparados e limpos)
                        </font>
                    </td>
                </tr>
                 
            </thead>
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% align='center'>
            <tr>
                <td width="50%" align='center'>
                    <font size='4px'><B> ORDEM DE SERVIÇO - OS</B></font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='center'>
                    <font size='2px'>em cumprimento a normativa de número 1 (NR-01.b)<BR>
                            1.7 Cabe ao empregador: (a) cumprir e fazer cumprir as disposições legais e regulamentares sobre segurança e medicina do trabalho; b) elaborar ordens de serviço sobre segurança<BR>
                            e saúde no trabalho, dando ciência aos empregados por comunicados.

                    </font>
                </td>
            </tr>
            
        </table>
        
        <table  width=100% style='border-style: solid;'>           
            <thead>
                 <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>TREINAMENTO(S) NECESSÁRIO(S)
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'>- Palestra sobre Ergonomia NR-17<br>
                                        - Noções básicas de prevenção e combate a incêndios<br>
                                        - Uso guarda e conservação dos EPI's

                        </font>
                    </td>
                </tr>
                 <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>PROCEDIMENTO EM CASO DE ACIDENTE DE TRABALHO
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'>-  Comunicar imediatamente a supervisão quando da ocorrência de acidente do trabalho, de trajeto ou surgir qualquer tipo de doença profissional;<br>
                                        - Prestar informações verdadeiras para o preenchimento da ficha de investigação de acidente<br>

                        </font>
                    </td>
                </tr>
                 <tr style='border-style: solid;' align=center>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>TERMO DE RESPONSABILIDADE
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        <font size='2px'>De acordo com o Artigo 158, Parágrafo Único, da lei 6.514/77 e da Norma Regulamentadora NR 1, a recusa ao fiel cumprimento desta ORDEM DE<br>
                                        SERVIÇO, no todo ou em parte, constituirá ATO FALTOSO sujeitando o funcionário às penalidades previstas na lei.<br>
                                        Declaro que fui plenamente orientado quanto aos procedimentos de segurança do trabalho, estando ciente dos riscos decorrentes da atividade e dos<br>
                                        sansões disciplinares a que estou sujeito quanto ao seu descumprimento<br>

                        </font>
                    </td>
                </tr>
                 <tr style='border-style: solid;' align=left>
                    <td colspan='6' width="100%" align='left'>
                        Recebi orientação de acordo com a portaria nº 3.214 do Ministério do Trabalho, N. R. 01 sub item 1.8 “Cabe ao Empregado:<br>
                        a) cumprir as disposições legais e regulamentares sobre segurança e medicina do trabalho, inclusive as ordens de
                        serviço expedidas pelo Empregador;<br>
                        b) usar o EPI fornecido pelo empregador;<br>
                        c) Submeter-se aos exames médicos previstos nas Normas regulamentadoras NR 1.8.1.<br>
                        Constitui ato faltoso a recusa injustificada ao cumprimento dos dispositivos no item anterior”.
                        “Comprometo-me a seguir os procedimentos de segurança adotados pela empresa”.

                    </td>
                </tr>
                <tr >
                    <th style='border-style: solid;'align=left rowspan='3'  colspan='1' align='left'>
                        Data
                    </th>
                    <th style='border-style: solid;'align=left rowspan='3'  colspan='2' align='left'>
                        Ass. do Funcionário 
                    </th>
                    <th style='border-style: solid;'align=left rowspan='3'  colspan='2'   align='left'>
                        Ass. Técnico em Segurança do Trabalho
                    </th>
                    <th style=''align=left   colspan='1'   align='left'>
                       &nbsp;
                    </th>
                </tr>
                <tr  >
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr  >
                    <td>
                        &nbsp;
                    </td>
                </tr>
                 
                 
            </thead>
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% align='center'>
            <tr>
                <td width="50%" align='center' colspan='2' >
                    <font size='4px'><B> CONTRATO INDIVIDUAL DE TRABALHO POR TEMPO INDETERMINADO</B></font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='left' colspan='2' >
                    <font size='2px'>Pelo presente contrato de trabalho por tempo indeterminado, <span class='ds_empresa'></span> , pessoa jurídica de direito privado, inscrita no CNPJ/MF<br>
                        sob o nº <span class='ds_cnpj'></span> , com sede em - , na - , simplesmente denominada EMPREGADOR e de outro:<span class='ds_colaborador'></span> , inscrito no CPF/MF sob o<br>
                        nº <span class='ds_cpf'></span>, portador(a) da Carteira de Trabalho nº  Série nº , residente e domiciliado na <span class='ds_endereco'></span> , <span class='ds_numero'></span> - <span class='ds_cidade'></span> - <span class='ds_uf'></span>,<br>
                        simplesmente denominado EMPREGADO, têm justo e acertadas as seguintes condições que integram o contrato de trabalho para todos os fins:

                    </font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='left' colspan='2' >
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td width="100%" align='left' colspan='2' >
                    <font size='2px'><b>I. DO CONTRATO DE TRABALHO</b><br>
                                    1. O presente contrato de trabalho é regido pelas normas prescritas pela Consolidação das Leis do Trabalho (Decreto- Lei nº 5.452/43).<br>
                                    2. É vedados às partes alegar o desconhecimento da lei, bem como das disposições constantes deste contrato individual de trabalho.<br>
                                    3. O contrato, inicialmente, será a título de experiência, com prazo total de duração previsto de 30 (trinta) dias. Em caso de rescisão até o termo pré-fixado do
                                    contrato, caberá ao EMPREGADO apenas a indenização prevista na legislação vigente.<br>
                                    4. Se a prestação de serviço exceder aos 30 (trinta)dias iniciais, o contrato de trabalho a título de experiência poderá ser renovado, sendo que a superação de 90
                                    (noventa) dias o converterá automaticamente em por 'prazo indeterminado', sendo ao EMPREGADO garantidas todos os benefícios em lei previstos.<br>
                                    5. O EMPREGADO deverá exercer a função de <span class='ds_produto_servico'></span>, por livre determinação da empresa, o EMPREGADO poderá ser transferido
                                    para outra função diferente da que foi contratado inicialmente.<br>
                                    6. Caso o EMPREGADOR venha a constituir grupo de empresas ou formar empresas coligadas, o EMPREGADO poderá ser aproveitado por qualquer uma delas,
                                    mesmo em funções diferentes da que foi contratado.<br>
                                    7. É obrigatório durante o exercício do trabalho a utilização de crachás de identificação, dos uniformes fornecidos pela empresa e dos equipamentos de proteção
                                    individual (EPI´s).<br>
                                    8. A jornada de trabalho do EMPREGADO é de <span class='ds_carga_horaria_semanal'></span> horas semanais, facultada a adoção do sistema de compensação de jornada de trabalho ou adoção de banco de
                                    horas, conforme os preceitos da CLT e dos instrumentos de Negociação Coletiva com o sindicato da categoria.<br>
                                    9. O EMPREGADO deverá cumprir o horário de trabalho que lhe foi designado, anotando nos cartões-ponto a jornada integralmente laborada.<br>
                                    10. O registro de horário nos cartões-ponto é ato personalíssimo do EMPREGADO, sendo expressamente vedado que outra pessoa os anote.<br>
                                    11. Não serão permitidos atrasos, sendo que os minutos que estiverem em desacordo com o previsto pelo art. 58, § 1º, da CLT, serão descontados.<br>
                                    12. O EMPREGADO compromete-se a utilizar os equipamentos de proteção individual (EPI´s) fornecidos pela empresa para as atividades que necessitarem,
                                    assinando a ficha de retirada de equipamentos ou termo equivalente.<br>
                                    13. Em caso de defeito nos equipamento de proteção individual, é obrigação do EMPREGADO comunicar imediatamente a empresa e suspender a execução dos
                                    serviços até que estes sejam substituídos.<br>
                                    14. Qualquer impedimento de saúde que impossibilite o trabalho deverá ser comprovado pelo EMPREGADO no dia do retorno ao serviço, exceto quando o
                                    afastamento for superior a 5 (cinco) dias, hipótese em que o EMPREGADO deverá comunicar sua ausência, justificando-a com o correspondente atestado médico,
                                    até o 5º dia após o afastamento.<br>
                                    15. Em caso de acidente de trabalho é obrigação inescusável do EMPREGADO a de comunicar seus superiores imediatamente.
                                    16. É obrigação inescusável do EMPREGADO a de comunicar seus superiores imediatamente caso esteja grávida, inclusive até o período de 9 (nove) meses pósrescisão.
                                    17. A inobservância de quaisquer previsões contidas neste contrato individual de trabalho será punível com advertências, suspensões ou até mesmo a demissão por
                                    justo motivo.<br>
                                    <b>II. DO REGULAMENTO INTERNO DA EMPRESA</b><br>
                                    1. A empresa declara possuir regulamento interno, que aplicar-se-á a todos os funcionários.<br>
                                    2. O EMPREGADO declara, neste ato, ter recebido o regulamento, bem como que teve acesso à todas as suas disposições, comprometendo-se a cumpri-lo
                                    integralmente.<br>
                                    <b>III. DO REGIME DE COMPENSAÇÃO DE JORNADAS DE TRABALHO</b><br>
                                    1. Será facultado ao EMPREGADOR proceder à compensação de jornada de trabalho, concedendo folgas ao EMPREGADO, em contraprestação ao labor
                                    extraordinário.<br>
                                    2. O EMPREGADOR poderá instituir 'Banco de Horas', nos termos do art. 59, da CLT, desde que não haja vedação pela Convenção Coletiva de Trabalho.<br>
                                    <b>IV. DA RESPONSABILIDADE DO EMPREGADO NO EXERCÍCIO DA ATIVIDADE LABORATIVA</b><br>
                                    1. O EMPREGADOR é legítimo possuidor ou proprietário de bens que serão utilizados pelo EMPREGADO durante a atividade laborativa, cujo uso será exclusivo
                                    para fins profissionais e deverão ser utilizados conforme instruções passadas pelo EMPREGADOR ou seus prepostos.<br>
                                    2. Os bens entregues ao EMPREGADO não poderão ser cedidos à terceiros, nem utilizado para fins diversos dos solicitados verbalmente ou por escrito pelo
                                    EMPREGADOR, assumindo o EMPREGADO, qualquer dos prejuízos causados por inobservância das presentes determinações.<br>
                                    3. Se verificada a inobservância de quaisquer das cláusulas previstas neste termo, bem como a prática de atos negligente, imprudentes ou com imperícia por parte
                                    do EMPREGADO, caberá a este ressarcir ao EMPREGADOR todos os danos causados.<br>
                                    4. É obrigação do EMPREGADO, ao constar qualquer defeito nos bens utilizados que lhes são cedidos, comunicar imediatamente o EMPREGADOR, afim que as
                                    medidas cabíveis sejam tomadas.<br>
                                    5. Quaisquer multas ou infrações de trânsito cometidas pela utilização dos bens cedidos, serão reembolsadas integralmente pelo EMPREGADO, cabendo a este, em
                                    caso acúmulo de pontuação em sua Carteira Nacional de Habilitação – CNH, identificar-se no auto de infração, assumindo perante os departamentos
                                    governamentais responsáveis a responsabilidade por seus atos.<br>
                                    6. Em se constatando prejuízos ao EMPREGADOR pela infração à qualquer disposição prevista neste termo, caberá ao EMPREGADO arcar com as despesas,
                                    restituindo ao EMPREGADOR, no momento do pagamento de seus salário ou quando da rescisão contratual, o que ocorrer primeiro.<br>
                                    6.1. Os descontos nos pagamentos do obreiro não poderão ultrapassar a 30% (trinta por cento) do valor de sua remuneração, sendo vedado ao EMPREGADOR
                                    pagar ao EMPREGADO, a título de remuneração bruta (sem os descontos de alimentação, impostos, vales-transporte) menos do que 1 (um) salário mínimo vigente.<br>
                                    6.2. O valor a ser descontado poderá ser feito em mais de uma parcela, caso seja diretamente acordado com o EMPREGADO ou quando não for possível a
                                    observância do disposto no item 6.1.<br>
                                    6.3. No caso da rescisão contratual, o desconto poderá ser feito em parcela única, cabendo ao EMPREGADOR pleitear eventuais saldos remanescentes na Justiça
                                    do Trabalho ou na Justiça Comum, de acordo com sua conveniência.<br>
                                    6.4. O EMPREGADOR poderá, a seu critério, assumir os prejuízos causados pelo EMPREGADO pela prática de atos que desrespeitem este termo, sem que tal ato
                                    constitua renúncia ou revogação do presente.<br>
                                    7. A inobservância por parte do EMPREGADO de qualquer das disposições previstas neste termo será punível pelo EMPREGADOR com as medidas previstas na
                                    CLT, podendo, se for o caso, acarretar a despedida com justa causa.<br>
                                    8. O EMPREGADO declara ter tomado ciência do presente termo de responsabilidade, comprometendo-se a cumpri-lo integralmente, sob as penas previstas neste
                                    termo, na legislação trabalhista e na legislação civil.<br>
                                    <b>V. DA VIGÊNCIA CONTRATUAL</b><br>
                                    1. O presente contrato individual de trabalho terá sua vigência iniciada a partir de admissão do EMPREGADO até a demissão. E, por estarem justas e
                                    convencionadas, as partes assinam o presente instrumento em duas vias de igual teor e forma, elegendo o foro da Comarca , para
                                    dirimir dúvidas acerca das disposições do presente termo.<br>
                    </font>
                </td>
            </tr>
            <tr >
                <td colspan='2'  align=left>
                    <br><br><font size='3px'><b><span class='ds_cidade_empresa'></span></span>,___________________DE ___________________ DE ___________________</b></font>
                </td>
            </tr>
            <tr>
              <td colspan='2' width="25%">
                 &nbsp;
              </td>
          </tr>
          <tr >
              <td  colspan=1 align=left>
                  <br><br><b>______________________________________</b>
              </td>
              <td  colspan=1 align=left>
                  <br><br><b>______________________________________</b>
              </td>
          </tr>
          <tr >
              <td  colspan=1 align=left>
                  <b><span class='ds_empresa'></span><br>
                    <span class='ds_cnpj'></span>
                    </b>
              </td>
              <td  colspan=1 align=left>
                  <b><span class='ds_colaborador'></span> <br><span class='ds_cpf'></span></b>
              </td>
          </tr>
            
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% align='center'>
            <tr>
                <td width="50%" align='center' colspan='2' >
                    <font size='4px'><B> TERMO DE RESPONSABILIDADE</B></font>
                </td>
            </tr>
            <tr>
                <td width="50%" align='center' colspan='2' >
                    <font size='4px'>FORNECIMENTO DE UNIFORMES E EPI- Equipamento de Proteção Individual</font>
                </td>
            </tr>
        </table>
         <table  width=100% style='border-style: solid;'>           
            <thead>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='3' width='60%' style='border-style: solid;'align=left>
                         1- NOME DO FUNCIONÁRIO: <b><span class='ds_colaborador'></span></b>
                     </td>
                     <td  colspan='3' width='30%' style='border-style: solid;'align=left>
                          2 - EMPRESA: <b><span class='ds_empresa'></span></b>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='60%' style='border-style: solid;'align=left>
                         3 - FUNÇÃO: <b><span class='ds_produto_servico'></span></b>
                     </td>
                     <td  colspan='2' width='30%' style='border-style: solid;'align=left>
                         4 - DATADE ADMISSÃO:  <b><span class='dt_admissao'></span></b>
                     </td>
                     <td  colspan='2' width='30%' style='border-style: solid;'align=left>
                         5 - DATADE DEMISSÃO:<b></b>
                     </td>
                 </tr>
                 
            </thead>
        </table>
         <table  width=100% >           
            <thead>
                 <tr>
                    <td width="50%" align='left' colspan='6' >
                        <font size='2px'>Em atenção à portaria Ministerial nº 3.214 de 08/06/1978, NR 6 - Ministério do Trabalho, DECLARO ter recebido o (s) Equipamento(s) de proteção individual
                            (EPI's), abaixo especificado(s), nos termos dos artigos 166 e 167 da CLP, com redação da Lei Federal nº 6.514/77, e recebi treinamento para o uso correto<br>
                            do(s) mesmo(s) e fui orientado da obrigatoriedade do uso. COMPROMETO-ME a utilizá-los sempre para os fins a que se destinam, estando ciente de que a não<br>
                            utilização dos mesmo incorrerá contra a minha pessoa em ato faltoso, sujeitando-me às penalidades legais, de acordo com o disposto na CLT, capítulo V, seção
                            1, artigo 158, e NR 1, item 8, subitem 1.8.1. RESPONSABILIZO-ME por sua guarda, conservação, uso correto, e a devolução ao Dep. Segurança do Trabalho<br>
                            em qualquer estado que se encontre, indenizando a empresa no caso de perda, extravio ou danos por uso incorreto (art. 462, parágrafo 1º da CLT) e a
                            comunicação ao superior hierárquico ou Técnico de Segurança do trabalho caso ocorra alteração que o torne impróprio para uso.</font>
                    </td>
                </tr>
                 
            </thead>
        </table>
        <table  width=100% style='border-style: solid;'>           
            <thead>
                 <tr style='border-style: solid;' align=left>
                     <td   colspan='3' rowspan='2' style='border-style: solid;'align=left>
                        <b>Data Entrega</b>
                     </td>
                     <td   rowspan='2' style='border-style: solid;'align=left>
                        <b>QTDE</b>
                     </td>
                     <td   rowspan='2' style='border-style: solid;'align=left>
                        <b>DESCRIÇÃO</b>
                     </td>
                     <td   rowspan='2' style='border-style: solid;'align=left>
                        <b>CA'n</b>
                     </td>
                     <td    colspan='4' style='border-style: solid;'align=left>
                        <b>MOTIVO</b>
                     </td>
                     <td   rowspan='2' style='border-style: solid;'align=left>
                        <b>ASSINATURA DO FUNCIONÁRIO</b>
                     </td>
                     <td colspan='4' style='border-style: solid;'align=left>
                        <b>DEVOLUÇÃO</b>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td   style='border-style: solid;'align=left>
                        <b>A</b>
                     </td>
                     <td   style='border-style: solid;'align=left>
                        <b>S</b>
                     </td>
                     <td   style='border-style: solid;'align=left>
                        <b>P</b>
                     </td>
                     <td   style='border-style: solid;'align=left>
                        <b>D</b>
                     </td>
                     <td colspan='3'   style='border-style: solid;'align=left>
                        <b>DATA</b>
                     </td>
                     <td   style='border-style: solid;'align=left>
                        <b>RECEPTOR</b>
                     </td>
                 </tr>
                 <?for($i=0;$i<35;$i++){?>
                 <tr  style='border-style: solid;' align=left>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td  style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     <td   style='border-style: solid;'align=left>
                        &nbsp;
                     </td>
                     
                 </tr>
                 <?}?>
                 
                 <tr style='border-style: solid;' align=left>
                     <td colspan='4'  style='border-style: solid;'align=left>
                        <b>A = ADMISSÃO</b>
                     </td>                     
                     <td colspan='4'  style='border-style: solid;'align=left>
                        <b>S = SUBSTITUIÇÃO</b>
                     </td>                     
                     <td colspan='4'  style='border-style: solid;'align=left>
                        <b>P = PERDA</b>
                     </td>                     
                     <td colspan='3'  style='border-style: solid;'align=left>
                        <b>D = DOLO</b>
                     </td>                     
                 </tr>
                 
                 
            </thead>
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% >
            <tr>
                <td width="50%" align='center'>
                    <font size='4px'><B> DECLARAÇÃO DE VALE TRANSPORTE</B></font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='left'>
                    <font size='2px'>Eu, <span class='ds_colaborador'></span> portador(a) da cédula de identidade <span class='ds_cpf'></span>, domiciliado à R<span class='ds_endereco'></span> , <span class='ds_numero'></span> - <span class='ds_cidade'></span> - <span class='ds_uf'></span>,<br>
                                    portador do PIS <span class='ds_pis'></span>, empregado(a) da empresa <span class='ds_empresa'></span>, pessoa jurídica de direito privado, inscrita no CNPJ/MF sob o nº <span class='ds_cnpj'></span>, com sede em - , na - ,
                                    atendendo ao que determina a lei nº 7.418/85, alterada pela Lei nº 7.619/87 e Regulamentada pelo decreto nº 95.247/87, Declaro:<br><br><br>
                                    Autorizo o desconto da taxa de 6% (seis por cento) sobre o Salário base que para deslocamento Residência-Trabalho e Vice-Versa, tenho a necessidade de utilizar os seuintes meios de transporte:

                    </font>
                </td>
            </tr>
            
        </table>
        <table width=100% >
            <tr>
                <td COLSPAN='2'>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td width="50%" align='LEFT'>
                    <font size='4px'>SIM ( )</font>
                </td>
                <td width="50%" colspan='2' align='left'>
                    <font size='4px'>NÃO ( )</font>
                </td>
            </tr>
            <tr>
                <td COLSPAN='3'>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td align='LEFT'>
                    <font size='4px'>METROPOLITANO ( )</font>
                </td>
                <td align='left'>
                    <font size='4px'> URBANO  ( )</font>
                </td>
                <td align='left'>
                    <font size='4px'> METROPOLITANO / URBANO  ( )</font>
                </td>
            </tr>
            <tr>
                <td COLSPAN='3'>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td COLSPAN='3'>
                    <font size='2px'> Que tenho conhecimento de que as informações prestadas nesta declaração deverão ser utilizadas anualmente ou sempre que
                    ocorrer alteração das mesmas, sob pena de suspensão do benefício do Vale-Transporte até cumprimento dessa exigência:<br><br><br>
                    1. Que utilizarei o Vale-Transporte exclusivamente para meu efetivo deslocamento Residência-Trabalho e Vice-Versa;<br>
                    2. Que tenho conhecimento de que a declaração com informações falsas e o uso indevido do Vale Transporte constituem falta
                    grave que poderá acarretar a cessação do contrato de trabalho;<br> </font>
                </td>
            </tr>
            <tr >
                <td colspan='2'  align=left>
                    <br><br><font size='3px'><b><span class='ds_cidade_empresa'></span>___________________DE ___________________ DE ___________________</b></font>
                </td>
            </tr>
            <tr>
              <td colspan='2' width="25%">
                 &nbsp;
              </td>
          </tr>
          <tr >
              <td  colspan=1 align=left>
                  <br><br><b>______________________________________</b>
              </td>
          </tr>
          <tr >
              <td  colspan=1 align=left>
                  <b><span class='ds_colaborador'></span> <br><span class='ds_cpf'></span></b>
              </td>
          </tr>
            
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% >
            <tr>
                <td width="50%" align='center'>
                    <font size='4px'><B> TERMO DE COMPENSAÇÃO DE JORNADAS DE TRABALHO</B></font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='left'>
                    <font size='2px'>Pelo presente contrato de trabalho por tempo indeterminado, <span class='ds_empresa'></span> , pessoa jurídica de
                                    direito privado, inscrita no CNPJ/MF sob o nº <span class='ds_cnpj'></span> , com sede em - , na - , simplesmente denominada<br>
                                    EMPREGADOR e de outro:<span class='ds_colaborador'></span> , inscrito no CPF/MF sob o nº <span class='ds_cpf'></span>, portador(a) da Carteira de
                                    Trabalho nº  Série nº , residente e domiciliado na <span class='ds_endereco'></span> , <span class='ds_numero'></span> - <span class='ds_cidade'></span> - <span class='ds_uf'></span>,<br>
                                    simplesmente denominado EMPREGADO, têm justo e acertadas as seguintes condições que integram o contrato de trabalho para
                                    todos os fins:

                    </font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='left'>
                    <font size='2px'><b>I. DO TERMO DE COMPENSAÇÃO</b><br>
                                    a. O EMPREGADO cumprirá jornada semanal de ______________________________horas, onde as horas excedentes/faltantes <br>
                                    à 8ª diária trabalhadas em um dia, poderão ser compensadas dentro de um período de 6(seis) meses com base no 5° do artigo 59 
                                    da CLT.<br>
                                    b. Faculta-se ao EMPREGADOR, em virtude das exigências do serviço, instituir a jornada de trabalho 12 x 36, onde o empregado
                                    trabalhará em uma semana 3 dias e na seguinte por 4 dias.<br>
                                    c. Declaram as partes que a adoção do regime de compensação de jornada de trabalho 12 x 36 já embute nos dias de folgas a
                                    concessão do descanso semanal remunerado.<br>
                                    d. As condições aqui previstas são aplicáveis inclusive se as atividades praticadas pelo EMPREGADO forem consideradas
                                    insalubres.<br>
                                    e. O presente acordo é celebrado por prazo indeterminado.<br>
                                    E, por estarem justas e convencionadas, as partes assinam o presente instrumento em duas vias de igual teor e forma, elegendo o
                                    foro da Comarca de Londrina, Estado do Paraná, para dirimir dúvidas acerca das disposições do presente termo.


                    </font>
                </td>
            </tr>
            
        </table>
        <table width=100% >
            <tr >
                <td colspan='2'  align=left>
                    <br><br><font size='3px'><b><span class='ds_cidade_empresa'></span>,___________________DE ___________________ DE ___________________</b></font>
                </td>
            </tr>
            <tr>
              <td colspan='2' width="25%">
                 &nbsp;
              </td>
          </tr>
          <tr >
              <td  colspan=1 align=left>
                  <br><br><b>______________________________________</b>
              </td>
              <td  colspan=1 align=left>
                  <br><br><b>______________________________________</b>
              </td>
          </tr>
          <tr >
              <td  colspan=1 align=left>
                  <b><span class='ds_empresa'></span> <br> <span class='ds_cnpj'></span></b>
              </td>
              <td  colspan=1 align=left>
                  <b><span class='ds_colaborador'></span> <br><span class='ds_cpf'></span></b>
              </td>
          </tr>
            
        </table>
        <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <br>
        <table width=100% align='center'>
            <tr>
                <td width="25%" rowspan="2" align='center'>
                    <!--img src='../img/nlogo.png' width='80%'-->
                </td>
                <td width="50%" align='center'>
                    <font size='4px'><B><span class='ds_empresa'></span></B></font>
                </td>
            </tr>
            <tr>
                <td width="100%" align='center'>
                    <font size='3px'>Matriz: <span class='ds_endereco_empresa'></span><br>
                        Fone: <span class='ds_tel_empresa'></span><br>
                        <span class='ds_email_empresa'></span>
                    </font>
                </td>
            </tr>
        </table>
        <table width=100%>
            <tr>
                <td width="25%">
                   &nbsp;
                </td>
                <td colspan='2'>
                    &nbsp;
                </td>
            </tr>
        </table>
        <table width=100% >
            <tr>
                <td width="50%" align='center'>
                    <font size='4px'><B><u> LISTA DE TREINAMENTO</u></B></font>
                </td>
            </tr>
            
        </table>
        <table  width=100% style='border-style: solid;'>           
            <thead>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>TEMA:
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='6'  width='60%' style='border-style: solid;'align=left>
                         <b>TÓPICOS ABORDADOS:
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='2'   style='border-style: solid;'align=left>
                         <b>ORIENTADOR:
                         </b>
                     </th>
                     <th colspan='2'   style='border-style: solid;'align=left>
                         <b>DATA:_______ /________ /___________ 
                         </b>
                     </th>
                     <th colspan='2'   style='border-style: solid;'align=left>
                         <b>DURAÇÃO:__________________ MIN
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='3'   style='border-style: solid;'align=left>
                         <b>NOME DO COLABORADOR:
                         </b>
                     </th>
                     <th colspan='3'   style='border-style: solid;'align=left>
                         <b>ASSIANTURA
                         </b>
                     </th>
                 </tr>
                 <?for($i=0;$i<15;$i++){?>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='3'   style='border-style: solid;'align=left>
                         &nbsp;
                     </th>
                     <th colspan='3'   style='border-style: solid;'align=left>
                         &nbsp;
                     </th>
                 </tr>
                 <?}?>
                 <tr style='border-style: solid;' align=center>
                     <td colspan='6'   style='border-style: solid;'align=center>
                        <span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO
                     </td>
                 </tr>
            </thead>
        </table>
         <div style='page-break-after:always'></div>  
        
        <table width=100%>
            <tr>
                <td width="35%">
                   <font size='1px'> <span class='dt_admissao'></span></font>
                </td>
                <td colspan='2'>
                    <font size='2px'><span class='ds_colaborador'></span> - CONTRATO DE FUNCIONARIO</font>
                </td>
            </tr>
        </table>
        <br>
        <table  width=45% style='border-style: solid;'>           
            <thead>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='6' width='60%' style='border-style: solid;'align=left>
                         <b>Empregador: <span class='ds_empresa'></span><br>
                            CNPJ: <span class='ds_cnpj'></span><br>
                            Endereço:<span class='ds_endereco_empresa'></span><br>
                            Esp. do estabelecimento: <br>
                            Cargo/CBO: <span class='ds_produto_servico'></span><br>
                            Data de Admissão: <span class='dt_admissao'></span><br>
                            Remuneração Espefícica: <span class='vl_salario'></span><br>
                            _______________________________________________<br>
                            Assinatura do empregador ou a rogo com testemunha
                         </b>
                     </th>
                 </tr>
                
                 <tr style='border-style: solid;' align=left>
                     <th colspan='6'  width='60%' style='border-style: solid;'align=left>
                         <b>CONTRATO DE EXPERIÊNCIA<br>
                            Admitido em <span class='dt_admissao'></span> , mediante contrato de<br>
                            experiência de 30 dias,<br>
                            conforme Art. 433 parágrafo 2º "C" da CLT. Após esta<br>
                            data não havendo, manifestação em contrário, fica<br>
                            prorrogado, obedecendo o disposto no<br>
                            parágrafo único do Art. 445 da CLT.
                         </b>
                     </th>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <th colspan='6'  width='60%' style='border-style: solid;'align=left>
                         <b>Assinatura do empregador ou a rogo com testemunha<br>
                            <span class='ds_cnpj'></span>
                         </b>
                     </th>
                 </tr>
            </thead>
        </table>
        <br>
        <table  width=60% style='border-style: solid;'>           
            <thead>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='60%' style='border-style: solid;'align=left>
                         Nº ORDEM
                     </td>
                     <td colspan='4' width='60%' style='border-style: solid;'align=left>
                         EMPREGADOR OU RAZÃO SOCIAL<br>
                        <b><span class='ds_empresa'></span></b>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='3' width='60%' style='border-style: solid;'align=left>
                        C . N . P . J.<br>
                        <span class='ds_cnpj'></span>
                     </td>
                     <td colspan='3' width='60%' style='border-style: solid;'align=left>
                        ATIVIDADE ECONOMICA<br>
                        SERVICOS TERCEIRIZADOS
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='6' width='60%' style='border-style: solid;'align=left>
                        EMPREGADO<BR>
                        <span class='ds_colaborador'></span>
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='60%' style='border-style: solid;'align=left>
                        Nº REGISTRO<BR>
                        <span class='ds_matricula'></span>

                     </td>
                     <td colspan='2' width='60%' style='border-style: solid;'align=left>
                        Nº CTPS<BR>
                        <span class='ds_ctps'></span>
                     </td>
                     <td colspan='2' width='60%' style='border-style: solid;'align=left>
                        FUNÇÃO<BR>
                        <span class='ds_produto_servico'></span>
                     </td>
                 </tr>
                 <!--tr style='border-style: solid;' align=left>
                     <td colspan='3' width='60%' style='border-style: solid;'align=left>
                        LOCAL DE TRABALHO<BR>
                        MRV - ARAPONGAS (PARQUEAYALA)
                     </td>
                     <td colspan='3' width='60%' style='border-style: solid;'align=left>
                       1º QUINZENA
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='3' width='60%' style='border-style: solid;'align=left>
                        MES<BR>
                        16 A 31 DE MES - 01 A 15 DE MES

                     </td>
                     <td colspan='3' width='60%' style='border-style: solid;'align=left>
                        ANO<BR>
                        2021
                     </td>
                 </tr>
                 <tr style='border-style: solid;' align=left>
                     <td colspan='2' width='60%' style='border-style: solid;'align=left>
                        ENTRADA<BR>
                        07:30

                     </td>
                     <td colspan='2' width='60%' style='border-style: solid;'align=left>
                        INTERVALO<BR>
                        1 HORA
                     </td>
                     <td colspan='2' width='60%' style='border-style: solid;'align=left>
                        SAIDA<br>
                        17:30
                     </td>
                 </tr-->
            </thead>
        </table>
    </div>     
</page> 
          
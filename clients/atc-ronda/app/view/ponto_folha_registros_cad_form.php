<?
require_once "../inc/php/header.php";
?>
<script src="ponto_folha_registros_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
    body {
        margin: 0;
        padding: 0;
        font: 9pt "Tahoma";
    }

    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

    .page {
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .subpage {
        padding: 1cm;
        border: 5px red solid;
        height: 256mm;
        outline: 2cm #FFEAEA solid;
    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }
</style>
<title>Gepros - CRM</title>

<div class="container">
    <div class='row'>
        <div class='col-md-12' align='center'>
            &nbsp;
        </div>
    </div>  
</div>   
<div class="container" id="visualizar">
    <div class='row'>
        <div class='col-md-6' align='Left'>
            &nbsp;
        </div>
        <div class='col-md-6' align='Right'>
            <button type="button" class="btn btn-secondary" id="cmdVoltar" data-dismiss="modal">Voltar</button>
            &nbsp;
            <button type="button" class="btn btn-primary" id="cmdImprimirModal"  name="cmdImprimirModal">Salvar</button>
            &nbsp; &nbsp;
            <label style="font-size: 15px" for ="ic_folha_finalizada"> FOLHA FINALIZADA </label>
            <input type="checkbox" class="ic_folha_finalizada" value="0" id="ic_folha_finalizada">
        </div>
    </div>    
    <body>
        <form id="impressao" name="impressao">    
    <div id="areaImpressao" anme="area_impressao">    
        <div class='row'>
            <div class='col-md-12' align='Left'>
                    <h4>Folha de ponto</h4>
                    
                Período <div id="ds_periodo"></div>
            </div>
        </div>    
        <form id="folha_impressao" name="folha_impressao">
            <input type="hidden" id="totalLinhas" name="totalLinhas" value="">
            <div class='row'>
                <div class='col-md-12' align='Left'>
                    <table style=" width: 110%;">        
                            <tr style=" background: #1A0F6B">
                                <th colspan="2">
                                    &nbsp;<label style=" color: white ">DADOS DO COLABORADOR</label>
                                </th>
                                <th colspan="2">
                                    <label style=" color: white ">DADOS DO EMPREGADOR</label>
                                </th>
                            </tr>
                            <tr>
                                <td width='25%'>
                                    &nbsp;<b>Nome:</b>
                                </td>
                                <td width: 100%  align='Left'>
                                    <div id="ds_colaborador"></div>
                                    <input type='hidden' id='colaborador_pk' >
                                </td>
                                <td width: 100%>
                                    <b>Razão Social:</b>
                                </td>
                                <td width: 100%  align='Left'>
                                    <div id="ds_empresa"></div>
                                </td>
                            </tr>
                            <tr>
                                <td width='25%'>
                                    &nbsp;<b>CPF:</b>
                                </td>
                                <td width: 100%  align='Left'>
                                    <div id="ds_cpf"></div>
                                </td>
                                <td width: 100%>
                                    <b>Endereço:</b>
                                </td>
                                <td width: 100%  align='Left'>
                                    <div id="ds_endereco"></div>
                                </td>
                            </tr>
                            <tr>
                                <td width='25%'>
                                    &nbsp;<b>Cargo:</b>
                                </td>
                                <td width: 100%  align='Left'>
                                    <div id="ds_cargo"></div>
                                </td>
                                <td width: 100%>
                                    <b>CNPJ:</b>
                                </td>
                                <td width: 100%  align='Left'>
                                    <div id="ds_cnpj"></div>
                                </td>
                            </tr>
                            <tr>
                                <td width='25%'>
                                    &nbsp;<b>Posto de Trabalho:</b>
                                </td>
                                <td width: 100%  align='Left'>
                                    <div id="ds_posto_trabalho"></div>
                                </td>
                                <td width: 100%>
                                    <b>DT Admissão</b>
                                </td>
                                <td width: 100%  align='Left'>
                                <div id="ds_dt_admissao"></div>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    &nbsp;<b>Turno:</b>
                                </td>
                                <td colspan="3" width: 100%  align='Left'>
                                    <div id="ds_dados_turno"></div>
                                </td>                       
                            </tr>
                            <p>
                            <tr style=" background: #1A0F6B">
                                <th colspan="4">
                                    &nbsp;<label style=" color: white ">REGISTROS</label>
                                </th>        
                            </tr>                  
                    </table>
                </div>
            </div> 
            <div class='row'>
                <div class='col-md-12' align='Left'>
                    <table  style="width:100%" id="tblResultado1">
                        <thead>
                            <tr>
                                <th colspan="4">
                                    MARCAR TODOS: <input type='checkbox' class='ic_marcar_todos' id='ic_marcar_todos'>
                                </th>
                            </tr>
                            <tr> <th> &nbsp; </th> </tr>
                            <tr>
                                <th width="20" style="  text-align: center">
                                    VALIDADO
                                </th>
                                <th width="15" style=" text-align: center">
                                    DATA 
                                </th>
                                <th colspan="4" width="500" style="  text-align: center">
                                    REGISTROS
                                </th>
                                <th align='center' style=" text-align: center">
                                    H.T
                                </th>
                                <th align='center' style=" text-align: center">
                                    H.E
                                </th>
                                <th align='center' style=" text-align: center">
                                    H.F
                                </th>
                                <th align='center' style=" text-align: center">
                                    SITUAÇÃO
                                </th>
                                <th align='center' style=" text-align: center">
                                    H.IT
                                </th>  
                                <th align='center' style=" text-align: center">
                                    H.E2
                                </th> 
                                <th align='center' style=" text-align: center">
                                    A.N
                                </th>
                                <th align='center' style=" text-align: center">
                                    OBS
                                </th>
                                <th align='center' style=" text-align: center">
                                    Ação
                                </th>
                            </tr>
                        </thead>
                        <tbody id="listar_registros">

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="15">
                                    &nbsp;
                                </td>
                            </tr>      
                            <tr style=" background: #f5f5f5 ">
                                <td colspan="15">
                                    <table style=" width: 110%" > 
                                        <tr>
                                            <td width='50%'>
                                                H.T: Horas Trabalhasdas 
                                            </td>
                                            <td width='50%'>
                                                H.E: Horas Excedentes
                                            </td>             
                                        </tr>        
                                        <tr>
                                            <td width='50%'>
                                                H.F: Horas Faltantes
                                            </td>
                                            <td width='50%'>
                                                H.E1: Intrajornada 
                                            </td>             
                                        </tr> 
                                        <tr>
                                            <td width='50%'>
                                                H.E2: Horas Extra Fase 2 (100%) 
                                            </td>
                                            <td width='50%'>
                                                A.N:  Adicional Noturno 
                                            </td>             
                                        </tr> 
                                    </table>
                                </td>
                            </tr>   
                            <tr>
                                <td colspan="10">
                                    &nbsp;
                                </td>
                            </tr>  

                            <tr>
                                <td colspan="15">
                                    <table style=" width: 110%" > 
                                        <tr>
                                            <td width='50%' style=" text-align: center">
                                                __________________________________<br>
                                                    COLABORADOR
                                            </td>
                                            <td width='50%' style=" text-align: center">
                                                __________________________________<br>
                                                    EMPREGADOR
                                            </td>             
                                        </tr>        

                                    </table>
                                </td>
                            </tr>  
                        </tfoot>
                    </table> 
                </div>
            </div>   
        </form>
    </body>
        <div class="row" id="noprint">
            <div class="col-md-12" align="center" >
                &nbsp;
            </div>
        </div>


    </div>
</div>   
<?
require_once "../inc/php/footer.php";
?>

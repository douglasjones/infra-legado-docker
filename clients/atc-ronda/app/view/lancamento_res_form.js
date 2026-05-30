var tblResultado;
var primeiroDia =  "";
var ultimoDia = "";
var saldo_ini = 0;
var saldoInicial = 0;

function fcPesquisar(){	
    tblResultado.clear().destroy();
    fcCarregarGrid();    
}

function fcIncluir(){
    sendPost('lancamento_cad_form.php',{token: token, pk: ''});
}

function fcExcluir(v_pk, v_dt_vencimento){

    if (confirm("Deseja realmente excluir o registro '" + v_dt_vencimento + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("lancamento", "excluir", objParametros);   

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcEditar(v_pk){
    sendPost('lancamento_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarGrid(){
   
    var objParametros = {
        "dt_vencimento": $("#dt_vencimento").val(),
        "ic_status": $("#ic_status").val()
    };     
    
    var v_url = montarUrlController("lancamento", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
            {"targets": -2, "data": "t_metodos_pagamento_pk"},
            {"targets": -3, "data": "t_tipos_operacao_pk"},
            {"targets": -4, "data": "t_contas_bancarias_pk"},
            {"targets": -5, "data": "t_n_documento"},
            {"targets": -6, "data": "t_dt_competencia"},
            {"targets": -7, "data": "t_obs_lancamento"},
            {"targets": -8, "data": "t_ic_status_patamento"},
            {"targets": -9, "data": "t_grupo_leancamento_pk"},
            {"targets": -10, "data": "t_grupo leancamento_pk"},
            {"targets": -11, "data": "t_tipo_grupo_pk"},
            {"targets": -12, "data": "t_operacao_pk"},
            {"targets": -13, "data": "t_vl_lancamento"},
            {"targets": -14, "data": "t_ds_lancamento"},
            {"targets": -15, "data": "t_dt_vencimento"},
            {"targets": -16, "data": "t_pk"}

        ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcEditar(data['t_pk']);
        
    } );   
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_dt_vencimento']);
    } );            
    
}

function fcCarregarComboContas(){    
    var objParametros = {
        "empresas_pk": $("#empresas_pk").val()
    };          
    var arrCarregar = carregarController("conta_bancaria", "listarContasLancamento", objParametros); 
    
    carregarComboAjax($("#contas_pk"), arrCarregar, "", "pk", "ds_dados_conta");        
}
function fcCarregarSaldoContas(){  
    $("#ds_saldo_conta").text("");
    var objParametros = {
        "pk": $("#contas_pk").val()
    };          
    var arrCarregar = carregarController("conta_bancaria", "listarPk", objParametros); 
   
    //$("#ds_saldo_conta").text(float2moeda(arrCarregar.data[0]['vl_saldo_inicial']));     
    saldoInicial = arrCarregar.data[0]['vl_saldo_inicial'];
    saldo_ini = arrCarregar.data[0]['vl_inicial_conta'];
    
}

function fcDatasCaleandario(mes,ano){
   
    var today = new Date();
    if(mes==""){
        var mm = today.getMonth()+1; //January is 0!   
    }
    else{
        var mm = mes; //January is 0!   
    }
    
    if(ano==""){
        var yyyy = today.getFullYear();
    }
    else{
        var yyyy = ano;
    }
    
    $("#ds_ano").val(yyyy);       
          
    
    if(mm=='1'){
        $("#ic_mes").val(1);
        fcRemoverClassActiveButton();
        $('#ic_jan').addClass('active');
    }else if(mm=='2'){
        $("#ic_mes").val(2);
        fcRemoverClassActiveButton();
        $('#ic_fev').addClass('active');
    }else if(mm=='3'){
        $("#ic_mes").val(3);
        fcRemoverClassActiveButton();
        $('#ic_mar').addClass('active');
    }else if(mm=='4'){
        $("#ic_mes").val(4);
        fcRemoverClassActiveButton();
        $('#ic_abr').addClass('active');
    }else if(mm=='5'){
        $("#ic_mes").val(5);
        fcRemoverClassActiveButton();
        $('#ic_mai').addClass('active');
    }else if(mm=='6'){
        $("#ic_mes").val(6);
        fcRemoverClassActiveButton();
        $('#ic_jun').addClass('active');
    }else if(mm=='7'){
        $("#ic_mes").val(7);
        fcRemoverClassActiveButton();
        $('#ic_jul').addClass('active');
    }else if(mm=='8'){
        $("#ic_mes").val(8);
        fcRemoverClassActiveButton();
        $('#ic_ago').addClass('active');
    }else if(mm=='9'){
        $("#ic_mes").val(9);
        fcRemoverClassActiveButton();
        $('#ic_set').addClass('active');
    }else if(mm=='10'){
        $("#ic_mes").val(10);
        fcRemoverClassActiveButton();
        $('#ic_out').addClass('active');
    }else if(mm=='11'){
        $("#ic_mes").val(11);
        fcRemoverClassActiveButton();
        $('#ic_nov').addClass('active');
    }else if(mm=='12'){
        $("#ic_mes").val(12);
        fcRemoverClassActiveButton();
        $('#ic_dez').addClass('active');
    }  

    
    if($("#dia_ini_pk").val()!=""){    
        primeiroDia =  $("#dia_ini_pk").val()+"/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();  
    }else{
        primeiroDia =  "01/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
    }

    if($("#dia_fim_pk").val()!=""){
        ultimoDia = $("#dia_fim_pk").val()+"/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
    }else{
        ultimoDia = "31/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
    }
    
 
        fcCarregarGriLancamentosMes();
     
        fcCarregarGriLancamentosVencidoReceitaDia();
       
        fcCarregarGriLancamentosVencidoDespesaDia();
        
        fcCarregarGriLancamentosReceitaAtrasado();
        
        fcCarregarGriLancamentosDespesaAtrasado();
        
        
        fcCarregarGraficoLinha();
        fcCarregarExtrato();
        
    
    
    
    
    
    
    

}
function fcCarregarDataPrimeiroLancamentoConta(){
  
    var objParametros1 = {
        "contas_bancarias_pk":$("#contas_pk").val()
        //"operacao_pk":1
    };   
    
    var arrCarregar1 = carregarController("lancamento", "listarReceita", objParametros1);   
   
    if (arrCarregar1.result == 'success'){
        if(arrCarregar1.data.length>0){
            
            var data_primeiro_lancamento = arrCarregar1.data[0]['dt_vencimento'];
           
        }
    }
    return data_primeiro_lancamento;
}
function getMoney( str )
{
        return parseInt( str.replace(/[\D]+/g,'') );
}
function formatReal( int )
{
        var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6 )
                tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        return tmp;
}
function fcCarregarExtrato(){
   
    var objParametros = {
        "ds_dominio_modulo": "visualizar_saldo_conta",
        "ic_acao":"del"
    };    
    
    var arrCarregarPermissao = permissaoAtualizada("usuario", "verificarPermissao", objParametros); 
    
    
    $("#extrato").append(""); 
    $("#extrato").empty(); 
    var receita = 0;
    var v_receita = 0;
    var despesas = 0;
     var v_despesas = 0;
    var strRetorno = "";
    
    
    var vl_receita =  new Number(0);
    var vl_despesa = new Number(0);
    var vl_saldo = new Number(0);




     primeiroDia1 = new Date("0"+$("#ds_ano").val(), ($("#ic_mes").val()-1), 1);
  

    ultimoDia1 = new Date($("#ds_ano").val(), $("#ic_mes").val(), 0);
 

   
    var dd = primeiroDia1.getDate();        
    var mm = primeiroDia1.getMonth(); //January is 0!   
    var yyyy = primeiroDia1.getFullYear();
    var ddu = ultimoDia1.getDate();        
    var mmu = ultimoDia1.getMonth(); //January is 0!   
    var yyyyu = ultimoDia1.getFullYear();
    
    
    var data_ini = fcCarregarDataPrimeiroLancamentoConta();   
    //var data_ini = "01/"+mmu+"/"+yyyyu;
    var data_fim = "31/"+mmu+"/"+yyyyu;
    var saldo_mes_anterior = 0;
    var saldo = 0;
    var soma = 0;
    strRetorno+="<div class='overflow-auto' style='height:350px;overflow-y: scroll;' >";
    strRetorno+="<table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblResultado' >";
    strRetorno+="<thead>";
    strRetorno+="<tr>";
    strRetorno+="<td align='center'><font style='font-size: 15px'><b>Data Pagamento</b></font></td>";
    strRetorno+="<td align='center'><font style='font-size: 15px'><b>Tipo</b></font></td>";
    strRetorno+="<td align='center'><font style='font-size: 15px'><b>Tipo Grupo</b></font></td>";
    strRetorno+="<td align='center'><font style='font-size: 15px'><b>Recebido de</b></font></td>";
    strRetorno+="<td align='center'><font style='font-size: 15px'><b>Metódo Pag.</b></font></td>";
    strRetorno+="<td align='center'><font style='font-size: 15px'><b>Vl Rec</b></font></td>";
    strRetorno+="<td align='center'><font style='font-size: 15px'><b>Vl Desp</b></font></td>";
    strRetorno+="<td align='center'><font style='font-size: 15px'><b>Valor</b></font></td>";
    strRetorno+="</tr>";
    strRetorno+="</thead>";
    strRetorno+="<tbody>";
   
    if($("#contas_pk").val()!=""){
        
        var objParametros1 = {
            "dt_vencimento_ini": data_ini,
            "dt_vencimento_fim": data_fim,
            "contas_bancarias_pk":$("#contas_pk").val()
            //"operacao_pk":1
        };   

        var arrCarregar1 = carregarController("lancamento", "listarReceita", objParametros1);          
        //NewWindow(v_last_url)
        if (arrCarregar1.result == 'success'){
            if(arrCarregar1.data.length>0){

                var saldo_mes_anterior = arrCarregar1.data[0]['t_vl_saldo'];                
                if(saldo_mes_anterior!=0){                 
             
                     //var soma =  moeda2float(saldo_mes_anterior);
                     
                     //alert(moeda2float(arrCarregar1.data[0]['t_vl_total_despesa'])-moeda2float(arrCarregar1.data[0]['t_vl_total_receita']))
                     
                     
                     var soma = parseFloat(moeda2float(saldo_mes_anterior)) + parseFloat((saldo_ini));
                     //var soma = saldo_mes_anterior;
                }else{                  
                     var soma = parseFloat((saldo_ini));
                }
            }
        }
       
        var objParametros = {
            "dt_vencimento_ini": primeiroDia,
            "dt_vencimento_fim": ultimoDia,
            
            "contas_bancarias_pk":$("#contas_pk").val()
            //"operacao_pk":1
        };   

        var arrCarregar = carregarController("lancamento", "listarReceita", objParametros);   
        //NewWindow(v_last_url)
        if (arrCarregar.result == 'success'){
            if(arrCarregar.data.length>0){

                if(soma==0){
                    strRetorno+="<tr>";
                    strRetorno+="<td>";
                    strRetorno+="Valor Inicial Conta";
                    strRetorno+="</td>";
                    strRetorno+="<td>";
                     if (arrCarregarPermissao.result != 'success'){            
                        strRetorno+="**********";
                     }
                     else{
                        strRetorno+="R$: "+ float2moeda(((saldo_ini)));
                     }
                   
                    strRetorno+="</td>";
                    strRetorno+="<td colspan=6>";
                    strRetorno+="&nbsp;";
                    strRetorno+="</td>";
                    strRetorno+="</tr>";
                }

                strRetorno+="<tr>";
                strRetorno+="<td>";
                strRetorno+="Saldo mês Anterior";
                strRetorno+="</td>";
                strRetorno+="<td>";
                if (arrCarregarPermissao.result != 'success'){            
                    strRetorno+="**********";
                 }
                 else{
                    strRetorno+="R$: "+ float2moeda(((soma)));
                 }
                strRetorno+="</td>";
                strRetorno+="<td colspan=6>";
                strRetorno+="&nbsp;";
                strRetorno+="</td>";
                strRetorno+="</tr>";

                for(i=0;i< arrCarregar.data.length;i++){

                    strRetorno+="<tr>";
                    strRetorno+="<td align='center'><font style='font-size: 15px'>"+arrCarregar.data[i]['t_dt_vencimento']+"</font></td>";
 

                    strRetorno+="<td align='center'><font style='font-size: 15px'>"+arrCarregar.data[i]['t_ds_operacao']+"</font></td>";
                    strRetorno+="<td align='center'><font style='font-size: 15px'>"+arrCarregar.data[i]['t_ds_tipo_grupo']+"</font></td>";
                    strRetorno+="<td align='center'><font style='font-size: 15px'>"+arrCarregar.data[i]['t_ds_recebido_de']+"</font></td>";
                    strRetorno+="<td align='center'><font style='font-size: 15px'>"+arrCarregar.data[i]['t_ds_metodo_pagamento']+"</font></td>";
                    var vl_linha_receita = "";
                    if(arrCarregar.data[i]['t_operacao_pk']==1){
                        //v_receita += arrCarregar.data[i]['t_vl_lancamento'];                        
                        //v_vl_receita += moeda2float(arrCarregar.data[i]['t_vl_lancamento']);
                       
                        
                        if(arrCarregar.data[i]['t_vl_lancamento']!=""){
                            vl_linha_receita = float2moeda(arrCarregar.data[i]['t_vl_lancamento'])
                        }
                    
                    }                        
                    strRetorno+="<td align='center'><font style='font-size: 15px;color:blue'>"+vl_linha_receita+"</font></td>";
                    var vl_linha_despesa = "";
                    if(arrCarregar.data[i]['t_operacao_pk']!=1){
                        //vl_despesa += moeda2float(arrCarregar.data[i]['t_vl_lancamento']);
                       
                        
                        if(arrCarregar.data[i]['t_vl_lancamento']!=''){
                            vl_linha_despesa = float2moeda(arrCarregar.data[i]['t_vl_lancamento'])
                        }
                        
                    }    
                    strRetorno+="<td align='center'><font style='font-size: 15px;color:red'>"+vl_linha_despesa+"</font></td>";
                    if(arrCarregar.data[i]['t_operacao_pk']!=1){
                        vl_despesa += moeda2float(arrCarregar.data[i]['t_vl_lancamento']);
                       
                        strRetorno+="<td align='center'><font style='font-size: 15px;color:red'>"+float2moeda(arrCarregar.data[i]['t_vl_lancamento'])+"</font></td>";
                    }else{
                        receita += arrCarregar.data[i]['t_vl_lancamento'];
                        
                        vl_receita += moeda2float(arrCarregar.data[i]['t_vl_lancamento']);
                        strRetorno+="<td align='center'><font style='font-size: 15px;color:blue'>"+float2moeda(arrCarregar.data[i]['t_vl_lancamento'])+"</font></td>";
                    }
                    strRetorno+="</tr>";

                }

                strRetorno+="<tr>";
                strRetorno+="<td align='center' colspan=5>&nbsp;</td>";
                //strRetorno+="<td align='center' colspan=2><font style='font-size: 17px'><b>Saldo</b></font></td>";
                strRetorno+="<td align='center'><font style='font-size: 15px' color='Blue'><b>"+formatReal(parseFloat(vl_receita))+"</b></font></td>";
                strRetorno+="<td align='center'><font style='font-size: 15px' color='red'><b>"+formatReal(parseFloat(vl_despesa))+"</b></font></td>";
                if(saldo_mes_anterior==0){           
                    var vl_primeiro_saldo = ((vl_receita-vl_despesa)+moeda2float(saldo_ini))
                    strRetorno+="<td align='center'><font style='font-size: 15px'><b>"+formatReal(vl_primeiro_saldo)+"</b></font></td>";
                }else{                    
                   var vl = formatReal(parseFloat(parseFloat(vl_receita)-parseFloat(vl_despesa))) 
                   var vl1 =(vl).replace(".","")
                   
                   vl_saldo = float2moeda(parseFloat((vl1).replace(",",".")) + parseFloat((soma))) 
                   //vl_saldo = (vl).replace(".","")
                   strRetorno+="<td align='center'><font style='font-size: 15px'><b>"+vl_saldo+"</b></font></td>";
                }
                
                
                
                // strRetorno+="<td align='center'><font style='font-size: 15px'><b>R$: "+parseFloat((saldo_ini))+"</b></font></td>";

                /*if(saldo_mes_anterior!=0){
                    var saldo = parseFloat(moeda2float(saldo_mes_anterior)) + parseFloat(moeda2float(arrCarregar.data[0]['t_vl_saldo'])) + parseFloat((saldo_ini));
                }
                else{

                    var saldo = parseFloat(moeda2float(arrCarregar.data[0]['t_vl_saldo'])) + parseFloat((saldo_ini));

                }
                if (arrCarregarPermissao.result != 'success'){            
                    strRetorno+="<td align='center'>**********</td>";
                 }
                 else{
                    if(arrCarregar.data[0]['t_vl_saldo'] < 0){
                        strRetorno+="<td align='center'><font style='font-size: 15px;color:red'><b>R$: "+float2moeda(saldo)+"</b></font></td>";
                    }
                    else{
                        strRetorno+="<td align='center'><font style='font-size: 15px'><b>R$: "+float2moeda(saldo)+"</b></font></td>";
                    }
                 }*/
                
                strRetorno+="</tr>";

            }


        }
    }
    
    strRetorno+="</tbody>";
    strRetorno+="</table>";
    strRetorno+="</div>";
    
    
    if (arrCarregarPermissao.result != 'success'){            
       $("#ds_saldo_conta").text("********");  
    }
    else{
        if(saldoInicial!=saldo && saldo!=0){
            $("#ds_saldo_conta").text("");  
            $("#ds_saldo_conta").text(float2moeda(saldo));   
        }
        else{
            $("#ds_saldo_conta").text("");
            $("#ds_saldo_conta").text(float2moeda(saldoInicial));   
        }
    }
    
      
    
    $("#extrato").append(strRetorno); 
    
}

function fcRemoverClassActiveButton(){
    $('#ic_jan').removeClass('active');
    $('#ic_fev').removeClass('active');
    $('#ic_mar').removeClass('active');
    $('#ic_abr').removeClass('active');
    $('#ic_mai').removeClass('active');
    $('#ic_jun').removeClass('active');
    $('#ic_jul').removeClass('active');
    $('#ic_ago').removeClass('active');
    $('#ic_set').removeClass('active');
    $('#ic_out').removeClass('active');
    $('#ic_nov').removeClass('active');
    $('#ic_dez').removeClass('active');
}
function fcCarregarComboBox(){
    var today = new Date();
    var year = today.getFullYear();
    var ano = year; 
    
    var combo = "";
    combo += "<select id='ds_ano' class='btn btn-primary'>";
        combo += "   <option>2020</option>";
        combo += "   <option>2021</option>";
        combo += "   <option selected>2022</option>";
        combo += "   <option>2023</option>";
        combo += "   <option>2024</option>";
        combo += "   <option>2025</option>";
    /*for(i=0;i<6;i++){
        if(i>0){
            combo += "   <option>1</option>";
        }else{
            combo += "   <option>2</option>";
        }        
    }   */ 
    combo += " </select>";
    
    $('#ds_ano option[value='+year+']').prop('selected', true);


    
    $("#combo").append(combo);
}

function fcCarregarGraficoLinha(){
    
    var vl_receita = "";  
    var vl_despesa = "";  
    var url = "../controller/grafico_lancamento.controller.php?token="+token+"&dt_periodo_ini="+primeiroDia+"&dt_periodo_fim="+ultimoDia+"&contas_pk="+$("#contas_pk").val();

       
        //pega as informações
        $.getJSON(url, function(result) {
            for(i = 0; i < result.series.length; i++){
                vl_receita = result.series[0].data_receita;
                vl_despesa = result.series[0].data_despesa;
                
            }
            Highcharts.setOptions({
                lang: {
                    thousandsSep: ".",
                    decimalPoint: ","
                }
            });
            //monta o grafico
           Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Controle de Receita(s) X Despesa(s)'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: [''],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Valor R$',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' '
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                colors: [
                    '#7cb5ec',
                    '#f12121'
                ],
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Receita(s)',
                    data: [vl_receita]
                }, 
                {
                    name: 'Despesa(s)',
                    data: [vl_despesa]

                }]
            });
        })
        .fail(function() {
           //alert("Deu erro. Veio nada, veio JSON inválido etc");
      });
    
}

//----------------------------------------------------------------------DOCUMENTOS--------------------------------------------------------
function fcAbrirModalDocs(pk){
    
    $("#janela_docs").modal();
    $("#lancamentos_pk").val(pk);
    tblDocumentos.clear().destroy();
    fcCarregarGridDocumentos();
}
function fcCarregarGridDocumentos(){
    var objParametros = {
        "lancamentos_pk": $("#lancamentos_pk").val()
    };     
    
    var v_url = montarUrlController("documento", "listarDocumentosLancamentos", objParametros);
    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        //"bProcessing"    : true,
        "aaSorting"      : [],
        "sPaginationType": "full_numbers",
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_nome_original"},
           {"targets": -3, "data": "t_ds_obs"},
           {"targets": -4, "data": "t_ds_documento"},
           {"targets": -5, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblDocumentos tbody').on('click', '.function_edit', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcDownloadDocumento(data['t_ds_documento']);
        }
    });
    $('#tblDocumentos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirDocumento(data['t_pk'],data['t_ds_documento']);
        }
    });
}

function fcDownloadDocumento(ds_documento){
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

function fcExcluirDocumento(v_pk,v_ds_documento){
    var arrCarregar = permissao("documento", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(v_pk != ""){
        
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("documento", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcExcluirArquivo(v_ds_documento);
            tblDocumentos.clear().destroy();    
            fcCarregarGridDocumentos();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcValidarDocumentos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() == "Nenhum registro encontrado"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    } 
    else{
        fcEnviarDocumento();
    }
    
}
function fcEnviarDocumento(){ 
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    var strJSONDadosTabela =  fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();
    
    var objParametros = {
        "lancamentos_pk": $("#lancamentos_pk").val(),
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs
    };       
    
    
    var arrEnviar = carregarController("documento", "salvar", objParametros); 
    
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_documentos").modal("hide");
        alert(arrEnviar.message);
        tblDocumentos.clear().destroy();    
        fcCarregarGridDocumentos();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
           
}

function fcCarregarGridArquivos(){
    tblArquivos = $("#tblArquivos").DataTable(
        { 
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2]
            }],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        }   
    );
    return false;
}
//COMEÇO DOCUMENTOS UPLOAD

function fcAlterarNomeArquivo(v_arquivo){    
    
    var objParametros = {
        "lancamentos_pk": $("#lancamentos_pk").val(),
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivoLancamento", objParametros);           
   
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#ds_documento").text(arrEnviar.data[0]['t_ds_nome_salvo']);
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }    
}

function fcApagarArquivo(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').click(function () {
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivo(nome_arquivo);
    });
    
    tblArquivos.row($(this).parents('tr')).remove().draw();
}

function fcCancelarEnvioDocumento(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
            var colunas = $(this).children();
            nome_arquivo = $(colunas[0]).text();
            fcExcluirArquivo(nome_arquivo);
        });
}


function fcExcluirArquivo(v_nome_arquivo){
    var objParametros = {
        "nome_arquivo": v_nome_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "removerArquivo", objParametros);           
           
    if (arrEnviar.result == 'success'){
        
    }
}
function fcIncluirLinhaArquivo(nome_original){
    tblArquivos.row.add(
            [$("#ds_documento").text(),
             nome_original,
             "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcApagarArquivo);
    return false;
}


function ResetDoc(){
    $('#progressDoc .progress-bar').css('width', '0%');
}
$(function () {
    
    $('#fileuploadDoc').fileupload({
        
        dataType: 'json',
        done: function (e, data) {
           window.setTimeout('ResetDoc()', 2000);
   
            $.each(data.files, function (index, file) {
                
                $("#ds_nome_original").html(file.name);
                
                fcAlterarNomeArquivo(file.name);
                fcIncluirLinhaArquivo(file.name);
                
                               
            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },            
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressOc .progress-bar').css('width', progress + '%');
        }
    });
});

function fsCleanDoc() {
    $('#progressDoc .progress-bar').css('width', '0%');
}

function fcFormatarDadosArquivos(){

    var dsDocumento = "";
    var dsNomeOriginal = "";
    
    var arrKeys = [];
    arrKeys[0] = "ds_documento";
    arrKeys[1] = "ds_nome_original";
    
    var arrDados = [];
        var i = 0;
        $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
            dsDocumento =  $(colunas[0]).text(); 
            dsNomeOriginal = $(colunas[1]).text();
            
            
            arrDados[i] = [dsDocumento, dsNomeOriginal];
            i++;
        });
       
    return arrayToJson(arrKeys, arrDados);
    
}

function fcAbrirFormNovoDocumento(){
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    tblArquivos.clear().destroy(); 
    fcCarregarGridArquivos();
    $("#janela_documentos").modal();
    $("#ds_obs_doc").val("");
}
function carregarComboEmpresaPk(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("conta", "listarEmpresaSemCaixinha", objParametros);   
   
    carregarComboAjax($("#empresas_pk"), arrCarregar, "", "pk", "ds_razao_social");
    carregarComboAjax($("#empresa_modal_receita_pk"), arrCarregar, "", "pk", "ds_razao_social");
    carregarComboAjax($("#empresa_pk_dia"), arrCarregar, " ", "pk", "ds_razao_social");
    carregarComboAjax($("#empresa_pk_despesa_dia"), arrCarregar, " ", "pk", "ds_razao_social");
    carregarComboAjax($("#empresa_pk_atrasado"), arrCarregar, " ", "pk", "ds_razao_social");
    carregarComboAjax($("#empresa_pk_despesa_atrasado"), arrCarregar, " ", "pk", "ds_razao_social");
    carregarComboAjax($("#empresa_pk_mes"), arrCarregar, " ", "pk", "ds_razao_social");
}
function carregarComboUsuarioCadastro(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);   
   
    carregarComboAjax($("#usuario_cadastro_pk_dia"), arrCarregar, " ", "pk", "ds_usuario");
    carregarComboAjax($("#usuario_cadastro_pk_despesa_dia"), arrCarregar, " ", "pk", "ds_usuario");
    carregarComboAjax($("#usuario_cadastro_pk_atrasado"), arrCarregar, " ", "pk", "ds_usuario");
    carregarComboAjax($("#usuario_cadastro_pk_despesa_atrasado"), arrCarregar, " ", "pk", "ds_usuario");
    carregarComboAjax($("#usuario_cadastro_pk_mes"), arrCarregar, " ", "pk", "ds_usuario");
}


$(document).ready(function(){
   
    $("#dia_ini_pk").val('');
    $("#dia_fim_pk").val('');
    $(".chzn-select").chosen({allow_single_deselect: true});
    fcCarregarComboBox();
    carregarComboEmpresaPk();
 
    carregarComboUsuarioCadastro();
    
    fcCarregarComboContas();
    
    

    $('#dt_periodo_ini').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 

    $("#dt_periodo_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_periodo_fim').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 

    $("#dt_periodo_fim").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_periodo_ini_pesq').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_periodo_ini_pesq").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_periodo_fim_pesq').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_periodo_fim_pesq").keypress(function(){
       mascara(this,mdata);
    });

    
    
    
    //LANÇAMENTO
    //Carregar combo conta
    
    //$("#loader").hide();
    //$("#exibir").show();
    fcCarregarSaldoContas();
    
     
    
    
    $("#contas_pk").change(function(){ 
        $("#loader").show();
        $("#exibir").hide();
        
       fcCarregarSaldoContas();
       fcCarregarExtrato();
       
        fcCarregarGriLancamentosMes();
        fcCarregarGriLancamentosVencidoReceitaDia();
        fcCarregarGriLancamentosVencidoDespesaDia();
        fcCarregarGriLancamentosReceitaAtrasado();
        fcCarregarGriLancamentosDespesaAtrasado();
        
        
    
        fcCarregarGraficoLinha();
        $("#loader").hide();
        $("#exibir").show();
        
       
       
       
    });

    fcCarregarGridArquivos();
     
    fcCarregarGridDocumentos();
    $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);
    $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);
    //Atribui os eventos dos demais controles
    
    $("#empresas_pk").change(function(){ 
        $("#loader").show();
        $("#exibir").hide();
        $(".chzn-select").chosen('destroy');
         fcCarregarComboContas();

         fcCarregarSaldoContas();

         fcCarregarExtrato();


        fcCarregarGriLancamentosMes();
        fcCarregarGriLancamentosVencidoReceitaDia();
        fcCarregarGriLancamentosVencidoDespesaDia();
        fcCarregarGriLancamentosReceitaAtrasado();
        fcCarregarGriLancamentosDespesaAtrasado();
        

        

        fcCarregarGraficoLinha();
        setTimeout(function(){$(".chzn-select").chosen({allow_single_deselect: true}); }, 500);

        $("#loader").hide();
        $("#exibir").show();
         
         
         
     });
   

    
  //$(document).on('click', '#dia_ini_pk', fcCarregarExtrato );


   $(document).on('click', '#ic_jan', function () { 
        fcDatasCaleandario('1',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_fev', function () {
        fcDatasCaleandario('2',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_mar', function () {  
        fcDatasCaleandario('3',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_abr', function () {  
        fcDatasCaleandario('4',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_mai', function () { 
        fcDatasCaleandario('5',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_jun', function () {
        fcDatasCaleandario('6',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_jul', function () {  
        
        fcDatasCaleandario('7',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
        
    });
    $(document).on('click', '#ic_ago', function () {  
        fcDatasCaleandario('8',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_set', function () { 
        fcDatasCaleandario('9',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_out', function () {
        fcDatasCaleandario('10',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_nov', function () {    
        fcDatasCaleandario('11',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $(document).on('click', '#ic_dez', function () {  
        fcDatasCaleandario('12',$("#ds_ano").val());
        $("#loader").hide();
        $("#exibir").show();
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $("#ds_ano").change(function(){ 
       fcDatasCaleandario($("#ic_mes").val(),$("#ds_ano").val());
        
    });
    
   $("#dia_ini_pk").change(function(){
        $(".chzn-select").chosen('destroy');
        fcDatasCaleandario($("#ic_mes").val(),$("#ds_ano").val());
        $(".chzn-select").chosen({allow_single_deselect: true});        
    });

   $("#dia_fim_pk").change(function(){
        $(".chzn-select").chosen('destroy');
        fcDatasCaleandario($("#ic_mes").val(),$("#ds_ano").val());
        $(".chzn-select").chosen({allow_single_deselect: true});        
    });
    
    
    var today = new Date();
    var mm = today.getMonth()+1; //January is 0!
    setTimeout(function(){

        if(mm==1){
             $("#ic_jan").trigger("click");
         }
         else if(mm==2){
             $("#ic_fev").trigger("click");
         }
         else if(mm==3){
             $("#ic_mar").trigger("click");
         }
         else if(mm==4){
             $("#ic_abr").trigger("click");
         }
         else if(mm==5){
             $("#ic_mai").trigger("click");
         }
         else if(mm==6){
             $("#ic_jun").trigger("click");
         }
         else if(mm==7){

             $("#ic_jul").trigger("click");
         }
         else if(mm==8){
             $("#ic_ago").trigger("click");
         }
         else if(mm==9){
             $("#ic_set").trigger("click");
         }
         else if(mm==10){
             $("#ic_out").trigger("click");
         }
         else if(mm==11){
             $("#ic_nov").trigger("click");
         }
         else if(mm==12){
             $("#ic_dez").trigger("click");
         } 
     }, 500);
     
     var objParametros = {
        "ds_dominio_modulo": "exibir_extrato",
        "ic_acao":"upd"
    };    

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros); 

    if (arrCarregar.result != 'success'){ 
        $("#exibir_extrato").hide();
    }
    else{
        $("#exibir_extrato").show();
    }
     var objParametros1 = {
        "ds_dominio_modulo": "exibir_grafico_lancamento",
        "ic_acao":"upd"
    };    

    var arrCarregar1 = permissaoAtualizada("usuario", "verificarPermissao", objParametros1); 

    if (arrCarregar1.result != 'success'){ 
        $("#exibir_grafico").hide();
    }
    else{
        $("#exibir_grafico").show();
    }
   
});



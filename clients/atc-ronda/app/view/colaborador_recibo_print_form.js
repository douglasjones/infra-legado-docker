function fcCarregar(){
    $("#div_form").hide();
    $("#div_print").show();
    var v_html = "";
    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12' align='Left' >";
    v_html+=        "<table style=' width: 100%'>";        
    v_html+=            "<tr >";
    v_html+=                "<td style='font-size:12px;width:50%'>";
    v_html+=                    "<img src='../img/logo_empresa.jpeg'  width='35%'>";
    v_html+=                "</td>";
    v_html+=                "<td style='font-size:12px;;width:50%'>";
    v_html+=                    "HEMIL TERCEIRIZAÇÃO E SERVIÇOS EIRELI - CNPJ: 33.106.799/0001-54AV BRAZ OLAIA ACOSTA, 284 - JARDIM CALIFÓRNIA - RIBEIRÃO PRETO - SP(16) 3235-0811";
    v_html+=                "</td>";
    v_html+=            "</tr>";
    v_html+=        "</table>";
    v_html+=   "</div>";
    v_html+="</div>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12'>";
    v_html+=        "<table style=' width: 100%'>";        
    v_html+=            "<tr >";
    v_html+=                "<td  style='font-size:24px;text-align:center'>";
    v_html+=                    "Recibo";
    v_html+=                "</td>";
    v_html+=            "</tr>";
    v_html+=        "</table>";
    v_html+=   "</div>";
    v_html+="</div>";
    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12'>";
    v_html+=        "<table align='center'  style='width: 100%' border=1>";        
    v_html+=            "<tr >";
    v_html+=                "<td  style='font-size:12px;text-align:center;borderColor:white'>";
    v_html+=                    "Data";
    v_html+=                "</td>";
    v_html+=                "<td  style='font-size:12px;text-align:center'>";
    v_html+=                    "Sem";
    v_html+=                "</td>";
    v_html+=                "<td  style='font-size:12px;text-align:center'>";
    v_html+=                    "Posto de Trabalho";
    v_html+=                "</td>";
   v_html+=                "<td  style='font-size:12px;text-align:center'>";
    v_html+=                    "Função";
    v_html+=                "</td>";
    v_html+=                "<td  style='font-size:12px;text-align:center'>";
    v_html+=                    "HR Entrada";
    v_html+=                "</td>";
    v_html+=                "<td  style='font-size:12px;text-align:center'>";
    v_html+=                    "HR Saída";
    v_html+=                "</td>";    
    v_html+=                "<td  style='font-size:12px;text-align:center'>";
    v_html+=                    "Horas";
    v_html+=                "</td>";    
    v_html+=                "<td  style='font-size:12px;text-align:center'>";
    v_html+=                    "Valor";
    v_html+=                "</td>";    
    v_html+=            "</tr>";

     var objParametros = {
            "colaborador_recibo_pk": colaborador_recibo_pk
    };
    
    var arrCarregar = carregarController("colaborador_recibo", "listarDadosImpressao", objParametros);
    
    if (arrCarregar.result == 'success'){
        if(arrCarregar.data[0]['pk']!=0){ 
            var v_total_horas = 0;
            var v_total_dias = 0;
            for(x=0; x < arrCarregar.data[0].DadosReciboItens.length ;x++){      
                v_html+=            "<tr >";
                v_html+=                "<td  style='font-size:12px;text-align:center;borderColor:white'>"; 
                v_html+=                    arrCarregar.data[0].DadosReciboItens[x].dt_registro 
                v_html+=                "</td>";
                v_html+=                "<td  style='font-size:12px;text-align:center'>";
                v_html+=                    arrCarregar.data[0].DadosReciboItens[x].ds_dia_semana 
                v_html+=                "</td>";
                v_html+=                "<td  style='font-size:12px;text-align:center'>";
                v_html+=                    arrCarregar.data[0].DadosReciboItens[x].ds_lead 
                v_html+=                "</td>";
                v_html+=                "<td  style='font-size:12px;text-align:center'>";
                v_html+=                    arrCarregar.data[0].DadosReciboItens[x].ds_produto_servico
                v_html+=                "</td>";                
                v_html+=                "<td  style='font-size:12px;text-align:center'>";
                v_html+=                    arrCarregar.data[0].DadosReciboItens[x].hr_ini_expediente 
                v_html+=                "</td>";
                v_html+=                "<td  style='font-size:12px;text-align:center'>";
                v_html+=                    arrCarregar.data[0].DadosReciboItens[x].hr_fim_expediente 
                v_html+=                "</td>";    
                v_html+=                "<td  style='font-size:12px;text-align:center'>";
                v_html+=                    arrCarregar.data[0].DadosReciboItens[x].ds_total_hr
                v_html+=                "</td>";    
                v_html+=                "<td  style='font-size:12px;text-align:center'>";
                v_html+=                    arrCarregar.data[0].DadosReciboItens[x].vl_unitario
                v_html+=                "</td>";    
                v_html+=            "</tr>";  
                
                v_total_horas += new Number(arrCarregar.data[0].DadosReciboItens[x].ds_total_hr);
                v_total_dias ++;
                
            }
            //Total
            v_html+=            "<tr >";
            v_html+=                "<td colspan='6' style='font-size:12px;text-align:right'>";
            v_html+=                   "<b>Totais</b>&nbsp;";
            v_html+=                "</td>";  
            v_html+=                "<td  style='font-size:12px;text-align:center'><b>";
            v_html+=                   v_total_horas;
            v_html+=                "</b></td>";    
            v_html+=                "<td  style='font-size:12px;text-align:center'><b>";
            v_html+=                   float2moeda(arrCarregar.data[0]['vl_total']);
            v_html+=                "</b></td>";    
            v_html+=            "</tr>";       
            
            var v_total_valor = arrCarregar.data[0]['vl_total'];
            var v_ds_colaborador = arrCarregar.data[0]['ds_colaborador'];
            var v_ds_cpf = arrCarregar.data[0]['ds_cpf'];            
        }     
    } 
    v_html+=    "</table>";
    v_html+="</div>";
    v_html+="</div>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";

    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12'>";
    v_html+=        "<table style=' width: 100%'>";        
    v_html+=            "<tr >";
    v_html+=                "<td  style='font-size:14px;text-align:center'>";
    v_html+=                    "Declaro a quem possa interessar que recebi o valor de <b>R$ "+float2moeda(v_total_valor)+"</b>, referente aos "+ v_total_dias+" dia(s) trabalhados relacionados acima.";
    v_html+=                "</td>";
    v_html+=            "</tr>";
    v_html+=        "</table>";
    v_html+=   "</div>";
    v_html+="</div>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";  
    
    var meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"]; 
    var hoje = new Date();
    var dia = hoje.getDate();
    var mes = meses[hoje.getMonth()];
    var ano = hoje.getFullYear(); 
    
    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12'>";
    v_html+=        "<table style=' width: 100%'>";        
    v_html+=            "<tr >";
    v_html+=                "<td  style='font-size:14px;text-align:right'>";
    v_html+=                    "Ribeirão preto, "+dia+" de "+mes+" de "+ano;
    v_html+=                "</td>";
    v_html+=            "</tr>";
    v_html+=        "</table>";
    v_html+=   "</div>";
    v_html+="</div>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12'>";
    v_html+=        "<table style=' width: 100%'>";        
    v_html+=            "<tr >";
    v_html+=                "<td  style='font-size:14px;text-align:center'><b>";
    v_html+=                   "_______________________________________________<br>"+v_ds_colaborador+"<br>"+v_ds_cpf;
    v_html+=                "</b></td>";
    v_html+=            "</tr>";
    v_html+=        "</table>";
    v_html+=   "</div>";
    v_html+="</div>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";
    
    $("#areaImpressao").html(v_html)
    return false;
       
    
        var udm = (new Date($("#ano_pk").val(),parseInt($("#mes_pk").val()),0,0,0,0)).getDate();
        var v_dias =udm+1;
        var v_cont = "";
        for(i=1; i < v_dias  ;i++){              
            if($("#dia_pk_"+i).prop("checked") == true){    
                v_cont ++
            }    
        }     
        if(v_cont==''){
            alert('Marque um dos Dias!');
            return false;  
        }else{     
            var v_total_horas = new Number(0);
            var v_total_valor = new Number(0);
            for(i=1; i < v_dias  ;i++){
                if($("#dia_pk_"+i).prop("checked") == true){
                   
                    v_total_horas+= new Number($("#ds_total_hr_"+i).val());
                    v_total_valor += new Number($("#vl_unitario_"+i).val().replace(',','.'));
                    
                }
            }
 
        }

    /*for(i=1; i < li  ;i++){
        //if($("#dia_pk_"+l).prop("checked") == true){

        //}
    }*/

    v_html+="</div>";
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";

    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12'>";
    v_html+=        "<table style=' width: 100%'>";        
    v_html+=            "<tr >";
    v_html+=                "<td  style='font-size:14px;text-align:center'>";
    v_html+=                    "Declaro a quem possa interessar que recebi o valor de <b>R$ "+float2moeda(v_total_valor)+"</b>, referente aos "+v_cont+" dia(s) trabalhados relacionados acima.";
    v_html+=                "</td>";
    v_html+=            "</tr>";
    v_html+=        "</table>";
    v_html+=   "</div>";
    v_html+="</div>";
     v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";
    var meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"]; 
    var hoje = new Date();
    var dia = hoje.getDate();
    var mes = meses[hoje.getMonth()];
    var ano = hoje.getFullYear(); 
    
    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12'>";
    v_html+=        "<table style=' width: 100%'>";        
    v_html+=            "<tr >";
    v_html+=                "<td  style='font-size:14px;text-align:right'>";
    v_html+=                    "Ribeirão preto, "+dia+" de "+mes+" de "+ano;
    v_html+=                "</td>";
    v_html+=            "</tr>";
    v_html+=        "</table>";
    v_html+=   "</div>";
    v_html+="</div>";
    
    
    v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";
    var v_colaborador_cadastrado= $("#colaborador_cadastrado option:selected").val();
    var v_ds_colaborador = "";
    var v_ds_cpf = "";
    if(v_colaborador_cadastrado==1){
        v_ds_colaborador = $("#colaborador_pk option:selected").text();
        var objParametros = {
            "pk":$("#colaborador_pk option:selected").val()
        };   
        
        var arrCarregar = carregarController("colaborador", "listarColaboradoresPKCPF", objParametros); 
        //NewWindow(v_last_url)
        if (arrCarregar.result == 'success'){
            v_ds_cpf = arrCarregar.data[0]['ds_cpf'];
        }
        
        
    }else if (v_colaborador_cadastrado==2){
        v_ds_colaborador = $("#ds_nome_colaborador").val();
        v_ds_cpf = $("#ds_cpf_colaborador").val(); 
    }
    
    
    v_html+="<div class='row'>";
    v_html+=    "<div class='col-md-12'>";
    v_html+=        "<table style=' width: 100%'>";        
    v_html+=            "<tr >";
    v_html+=                "<td  style='font-size:14px;text-align:center'>";
    v_html+=                   "_______________________________<br>"+v_ds_colaborador+"<br>"+v_ds_cpf;
    v_html+=                "</td>";
    v_html+=            "</tr>";
    v_html+=        "</table>";
    v_html+=   "</div>";
    v_html+="</div>";
     v_html+="<br>";
    v_html+="<br>";
    v_html+="<br>";
    
    
    //printDiv();
}



function printDiv() {
  var divToPrint=document.getElementById('areaImpressao');
  var newWin=window.open('','Print-Window');  
  newWin.document.open();
  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();
  setTimeout(function(){newWin.close();},10);
}


function fcVoltarReciboRes(){
    sendPost("colaborador_recibo_res_form.php", {token: token});
}

$(document).ready(function(){  

   fcCarregar();
  
   $(document).on('click', '#cmdImprimirModal', printDiv);
   
   $(document).on('click', '#cmdVoltar', fcVoltarReciboRes);
   
 });
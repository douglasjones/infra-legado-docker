
function fcSair(){
    sendPost("login_holerite_form.php");
}

function fcListarAnosGrid(){ 
    var vhtml = "";
    var v_colaboradores_pk =$("#colaborador_pk").val();
    var url = '../controller/documento.controller.php?job=listarAnosHoleriteColaborador&colaboradores_pk=' + (v_colaboradores_pk);

    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){        
        if (output.result == 'success'){            
            vhtml+="<table class='table table-striped table-bordered nowrap' style='width:100%' id='tblanos'>";
            vhtml+="    <thead>";
            vhtml+="        <tr  align='center'>";
            vhtml+="            <th>Ano(s)</th>";                            
            vhtml+="        </tr>";
            vhtml+="    </thead>";            
            for(i=0;i<output.data.length;i++){ 
                vhtml+="    <tbody>";  
                vhtml+="<tr  align='center'>";
                vhtml+="<td>";
                vhtml+= "<a href=javascript:fclistarMeses("+output.data[i]['ds_ano']+")>"+output.data[i]['ds_ano']+"</a>";
                vhtml+="</td>";
                vhtml+="</tr>";
                vhtml+="    </tbody>";  
            }
            vhtml+="</table>";    
            $("#div_table_ano").html(vhtml); 
        }
    });
    request.fail(function(jqXHR, textStatus){
        
    });  
}

function fclistarMeses(ds_ano){
    $("#div_ano").hide();
        
    var vhtml = "";
    var v_colaboradores_pk =$("#colaborador_pk").val();
    var v_ds_ano = ds_ano; 
    var url = '../controller/documento.controller.php?job=listarMesessHoleriteColaborador&colaboradores_pk=' + (v_colaboradores_pk)+'&ds_ano='+(v_ds_ano) ;

    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){        
        if (output.result == 'success'){            
            vhtml+="<button type='button' class='btn btn-primary' id='cmdVoltarAno'>Voltar</button><br><br>";
            
            vhtml+="<table class='table table-striped table-bordered nowrap' style='width:100%' id='tblmeses'>";
            vhtml+="    <thead>";
            vhtml+="        <tr  align='center'>";
            vhtml+="            <th>Mese(s)</th>";                            
            vhtml+="        </tr>";
            vhtml+="    </thead>";          
            var v_mes = "";
            for(i=0;i<output.data.length;i++){ 
                v_mes = "'"+output.data[i]['ds_mes']+"'";
                vhtml+="    <tbody>";  
                vhtml+="<tr  align='center'>";
                vhtml+="<td>";
                vhtml+= "<a href=javascript:fclistarHoleritesMeses("+v_ds_ano+","+v_mes+")>"+output.data[i]['ds_mes']+"</a>";
                vhtml+="</td>";
                vhtml+="</tr>";
                vhtml+="    </tbody>";  
            }
            vhtml+="</table>";    
            $("#div_table_meses").html(vhtml); 
        }
    });
    request.fail(function(jqXHR, textStatus){
        
    });  
    $("#div_meses").show();
    
}

function fcVoltarAno(){
   $("#div_meses").hide();
   $("#div_ano").show();
}


function fclistarHoleritesMeses(ds_ano,ds_mes){
    $("#div_ano").hide();
    $("#div_meses").hide();
        
    var vhtml = "";
    var v_colaboradores_pk =$("#colaborador_pk").val();
    var v_ds_ano = ds_ano; 
    var v_ds_mes = ds_mes; 
    var url = '../controller/documento.controller.php?job=listaHoleriteMesColaborador&colaboradores_pk=' + (v_colaboradores_pk)+'&ds_ano='+(v_ds_ano)+'&ds_mes='+(v_ds_mes) ;
    //alert(url);
    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){        
        if (output.result == 'success'){            
            vhtml+="<button type='button' class='btn btn-primary' id='cmdVoltarMes'>Voltar</button><br><br>";
            
            vhtml+="<table class='table table-striped table-bordered nowrap' style='width:100%' id='tbldocs'>";
            vhtml+="    <thead>";
            vhtml+="        <tr  align='center'>";
            vhtml+="            <th>Mese(s)</th>";                            
            vhtml+="        </tr>";
            vhtml+="    </thead>";        
            var v_documento ="";
            for(i=0;i<output.data.length;i++){ 
                v_documento = "'"+output.data[i]['ds_documento']+"'";
                vhtml+="    <tbody>";  
                vhtml+="<tr  align='center'>";
                vhtml+="<td>";
                vhtml+= "<a href=javascript:fcDownloadDocumento("+v_documento+")>"+output.data[i]['ds_documento']+"</a>";
                vhtml+="</td>";
                vhtml+="</tr>";
                vhtml+="    </tbody>";  
            }
            vhtml+="</table>";    
            $("#div_table_holerite_mes").html(vhtml); 
        }
    });
    request.fail(function(jqXHR, textStatus){
        
    });  
    $("#div_holerites_mes").show();
    
}
function fcVoltarMes(){
   $("#div_meses").show();
   $("#div_ano").hide();
   $("#div_holerites_mes").hide();
}


function fcDownloadDocumento(ds_documento){
    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

$(document).ready(function(){
    
   $("#ds_colaborador_div").html($("#ds_colaborador_nome").val()) 
   $("#ds_pin_div").html($("#ds_colaborador_pin").val()) 
   $(document).on('click', '#cmdSair', fcSair); 
   $(document).on('click', '#cmdVoltarAno', fcVoltarAno); 
   $(document).on('click', '#cmdVoltarMes', fcVoltarMes); 
   
   fcListarAnosGrid();
});
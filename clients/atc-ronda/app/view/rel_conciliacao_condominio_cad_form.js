var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];
arrMes['01'] = "Janeiro";
arrMes['02'] = "Fevereiro";
arrMes['03'] = "Março";
arrMes['04'] = "Abril";
arrMes['05'] = "Maio";
arrMes['06'] = "Junho";
arrMes['07'] = "Julho";
arrMes['08'] = "Agosto";
arrMes['09'] = "Setembro";
arrMes['10'] = "Outubro";
arrMes['11'] = "Novembro";
arrMes['12'] = "Dezembro";
function fcCarregarGrid(){
    
    
    var ultimoDiaMes = pegarUltimoDiaMes(ic_mes,ds_ano);
    var data = "";
    var strRetorno = "";
    var strNenhumRegisto = "";
    
    
    
    for(i=0;i< ultimoDiaMes;i++){
        
        if(i < 9){
             data = "0"+(i+1)+"/"+ic_mes+"/"+ds_ano;
        }
        else{
             data = (i+1)+"/"+ic_mes+"/"+ds_ano;
        }
        var ds_dia_semana = pegarDsDiaSemana((i+1),(ic_mes+1),ds_ano);
        
        var n_dia_semana = pegarPosicaoDiaSemana((i+1),(ic_mes+1),ds_ano);
        
        var objParametros = {
            "leads_pk": leads_pk,
            "dt_base": data  
        };         

        var arrCarregar = carregarController("agenda_colaborador_padrao", "relatorioAgendaLead", objParametros); 
       

        if (arrCarregar.result == 'success'){
            
            if(arrCarregar.data.length >0){
                var ds_itens_contratador = "";
                var ds_profissionais_contratados = "";
                var ds_diferenca = "";
                var ds_produto_servico = "";
                var qtde_dias_semana = "";

                strRetorno+="<div class='row'>";
                strRetorno+="<div class='col-md-12'>";
                strRetorno+="   <h3><b>"+data+" ("+ds_dia_semana+")</b></h3>";
                strRetorno+=" </div>";
                strRetorno+="</div>";

                
                for(j=0; j < arrCarregar.data.length ;j++){
                    
                    if(arrCarregar.data[j]['t_n_profissionais_contratados'] > 0){
                        strRetorno+="<div class='row'><div class='col-md-12'>";
                        strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";
                    
                        strRetorno+="<tbody>";
                        strRetorno+="<tr>";
                        strRetorno+="<th width='20%'>Produtos/Serviços</th><th width='20%'>Qtde. Itens Contrat</th><th width='20%'>Qtde. Dias</th><th width='20%'>Qtde. Profissionais</th><th width='20%'>Dif</th>";
                        strRetorno+="</tr>";
                        
                        qtde_dias_semana = arrCarregar.data[j]['t_n_qtde_dias_semana'];
                        ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico'];
                        ds_itens_contratador = arrCarregar.data[j]['t_n_itens_contratados'];
                        ds_profissionais_contratados = arrCarregar.data[j]['t_n_profissionais_contratados'];
                        if(arrCarregar.data[j]['t_n_diferenca']< 0){
                            ds_diferenca = 0;
                        }
                        else{
                            ds_diferenca = arrCarregar.data[j]['t_n_diferenca'];
                        }
                        

                        strRetorno+="<tr>";
                        strRetorno+="<td width='20%'><b>"+ds_produto_servico+"</b></td>";
                        
                        strRetorno+="<td width='20%'><b>"+ds_itens_contratador+"</b></td>";
                        strRetorno+="<td width='20%'><b>"+qtde_dias_semana+"</b></td>";
                        strRetorno+="<td width='20%'><b>"+ds_profissionais_contratados+"</b></td>";
                        strRetorno+="<td width='20%'><b>"+ds_diferenca+"</b></td>";
                        strRetorno+="</tr>";
                        strRetorno+="<tr>";
                        var objParametros1 = {
                            "leads_pk": leads_pk,
                            "dt_base": data,
                            "produtos_servicos_pk":arrCarregar.data[j]['t_produtos_servicos_pk'],
                            "qtde_dias_contrato":arrCarregar.data[j]['t_n_qtde_dias_semana'],
                            "n_dia_semana":n_dia_semana
                        };   
                        var arrCarregar1 = carregarController("agenda_colaborador_padrao", "RellistarAgendaColaboradorLeadProdutosServicos", objParametros1);


                        if (arrCarregar1.result == 'success'){
                            var dt_ini = "";
                            var dt_fim = "";
                            var ds_dias_semana= "";
                            var ds_colaborador= "";

                            if(arrCarregar1.data.length > 0){
                                strRetorno+="<div class='row'><div class='col-md-12'>";
                                strRetorno+="<table class='table table-bordered'  id='tblResultadoColab'>";
                                strRetorno+="<tr>";
                                strRetorno+="<th width='20%'>Colaborador</th><th width='20%'>Data Inicio</th><th width='20%'>Data Fim</th><th width='12%'>Dia(s) Semana</th>";
                                strRetorno+="</tr>";
                                for(l=0; l < arrCarregar1.data.length ;l++){

                                        dt_ini = arrCarregar1.data[l]['t_dt_inicio_agenda'];
                                        dt_fim = arrCarregar1.data[l]['t_dt_fim_agenda'];
                                        ds_dias_semana = arrCarregar1.data[l]['t_ds_dia_semana'];
                                        ds_colaborador = arrCarregar1.data[l]['t_ds_colaborador'];

                                        strRetorno+="<tr>";
                                        strRetorno+="<td width='20%'>"+ds_colaborador+"</td>";
                                        strRetorno+="<td width='20%'>"+dt_ini+"</td>";
                                        strRetorno+="<td width='20%'>"+dt_fim+"</td>";
                                        strRetorno+="<td width='12%'>"+ds_dias_semana+"</td>";

                                        strRetorno+="</tr>";
                                }
                                strRetorno+="</tr>";
                                strRetorno+="</tbody>";
                                strRetorno+="</table>";
                                strRetorno+="</div>";
                                strRetorno+="</div>";
                                strRetorno+="<br><br><br><br>";
                            }
                            


                        }
 
                    }
                }
                strRetorno+="</tbody>";
                strRetorno+="</table>";
                strRetorno+="</div>";
                strRetorno+="</div>";
                strRetorno+="<hr><br>";
            }
            
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    } 
    if(strRetorno!=""){
        $("#grid").append(strRetorno);
    }
    else{
        
        strNenhumRegisto+="<div class='row'>";
        strNenhumRegisto+="<div class='col-md-12 text-center'>";
        strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
        strNenhumRegisto+=" </div>";
        strNenhumRegisto+="</div>";
        $("#grid").append(strNenhumRegisto);
    }
}

pegarUltimoDiaMes = function(year, month){
    var ultimoDia = (new Date(year, month, 0)).getDate();
    return ultimoDia;
};

function pegarDsDiaSemana(Dia,Mes,Ano){
    var semana = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira","Sábado"];
    var d = new Date(Ano,(Mes+1),Dia);
    return semana[d.getDay()];
}
function pegarPosicaoDiaSemana(Dia,Mes,Ano){
    var semana = [0,1,2,3,4,5,6];
    var d = new Date(Ano,(Mes+1),Dia);
    return semana[d.getDay()];
}
function fcCarregarLead(){
    
    var objParametros = {
        "pk": leads_pk
    };      
    
    var arrCarregar = carregarController("lead", "listarPk", objParametros); 
    if (arrCarregar.result == 'success'){
        $("#ds_lead").text(arrCarregar.data[0]['ds_lead']);
    }
        
}
function fcCancelar(){

    sendPost("rel_conciliacao_condominio_res_form.php", {token: token});
}

function fcExport(){

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#form").html() + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "export.xls";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}

$(document).ready(function(){    
    fcCarregarLead();
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
    var seg = today.getSeconds();
    //data
    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 
    //hora 
    if(hh<10) {
        hh = '0'+hh
    } 

    if(min<10) {
        min = '0'+min
    } 
    if(seg<10) {
        seg = '0'+seg
    } 

    today = dd + '/' + mm + '/' + yyyy + ' '+hh+':'+min+':'+seg;


    $("#dt_emissao").text(today);
    $("#ic_mes").text(arrMes[ic_mes]);
    $("#ds_ano").text(ds_ano);
    fcCarregarGrid();

});



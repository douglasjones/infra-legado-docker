function formatReal( int )
{
        var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6 )
                tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        return tmp;
}

function fcCarregarGrid(){  
    
    var objParametros = {
        "leads_pk":leads_pk,
        "colaborador_pk": colaboradores_pk,
        "dt_ini": dt_ini,
        "dt_fim": dt_fim
    };         
    var arrCarregar = carregarController("agenda_colaborador_apontamento", "relMovimentacaoFt", objParametros); 
  
    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){
            strRetorno = "";
            total_vl_ft = "";
            strRetorno+="<div class='row'><div class='col-md-12'>";
            strRetorno+="   <table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";
            strRetorno+="       <tbody>";
            strRetorno+="           <tr>";
            strRetorno+="               <th width='10%'>Usu. Cadastro</th>\n\
                                        <th width='10%'>Mês</th>\n\
                                        <th width='10%'>Data</th>\n\
                                        <th width='10%'>Cliente</th>\n\
                                        <th width='10%'>Nome</th>\n\
                                        <th width='10%'>Situação</th>\n\
                                        <th width='10%'>Vl. FT</th>\n\
                                        <th width='10%'>Observação</th>";
            strRetorno+="           </tr>";
            var total_vl_ft = "";
            for(j=0; j < arrCarregar.data.length ;j++){

                    if(arrCarregar.data[j]['t_ds_usuario']!=null){
                       ds_usuario = arrCarregar.data[j]['t_ds_usuario'];
                    }
                    else{
                        ds_usuario = "";
                    }
                    if(arrCarregar.data[j]['t_ds_mes']!=null){
                        ds_mes = arrCarregar.data[j]['t_ds_mes'];
                    }
                    else{
                        ds_mes = "";
                    }
                    if(arrCarregar.data[j]['t_vl_ft']!=null){
                        vl_ft = arrCarregar.data[j]['t_vl_ft'];
                    }
                    else{
                        vl_ft = "";
                    }
                    if(arrCarregar.data[j]['t_dt_apontamento']!=null){
                        dt_apontamento = arrCarregar.data[j]['t_dt_apontamento'];
                    }
                    else{
                        dt_apontamento = "";
                    }
                    if(arrCarregar.data[j]['t_ds_lead']!=null){
                        ds_lead = arrCarregar.data[j]['t_ds_lead'];
                    }
                    else{
                        ds_lead = "";
                    }
                    if(arrCarregar.data[j]['t_ds_colaborador_cobertura_falta']!=null){
                        ds_colaborador = arrCarregar.data[j]['t_ds_colaborador_cobertura_falta'];
                    }
                    else{
                        ds_colaborador = arrCarregar.data[j]['t_ds_colaborador'];
                    }
                    if(arrCarregar.data[j]['t_ds_motivo_cobertura_falta']!=null){
                        motivo_ft_pk = arrCarregar.data[j]['t_ds_motivo_cobertura_falta'];
                    }
                    else{
                        motivo_ft_pk = arrCarregar.data[j]['t_ds_motivo_ft'];
                    }
                    if(arrCarregar.data[j]['t_ds_mes_apontamento']!=null){
                        ds_mes_apontamento = arrCarregar.data[j]['t_ds_mes_apontamento'];
                    }
                    else{
                        ds_mes_apontamento = "";
                    }
                    if(arrCarregar.data[j]['t_total_vl_ft']!=null){
                        total_vl_ft = arrCarregar.data[j]['t_total_vl_ft'];
                    }
                    else{
                        total_vl_ft = "";
                    }
                    if(arrCarregar.data[j]['t_ds_obs_falta']!=null){
                        ds_obs = arrCarregar.data[j]['t_ds_obs_falta'];
                    }
                    else if(arrCarregar.data[j]['t_ds_obs_folga']!=null){
                        ds_obs = arrCarregar.data[j]['t_ds_obs_folga'];
                    }else{
                        ds_obs = "";
                    }

                    strRetorno+="<tr>";
                    strRetorno+="   <td width='10%'>"+ds_usuario+"</td>";
                    strRetorno+="   <td width='10%'>"+ds_mes_apontamento+"</td>";
                    strRetorno+="   <td width='10%'>"+dt_apontamento+"</td>";
                    strRetorno+="   <td width='10%'>"+ds_lead+"</td>";
                    strRetorno+="   <td width='10%'>"+ds_colaborador+"</td>";
                    strRetorno+="   <td width='10%'>"+motivo_ft_pk+"</td>";
                    strRetorno+="   <td width='10%' >"+vl_ft+"</td>";
                    strRetorno+="   <td width='10%'>"+ds_obs+"</td>";

                    strRetorno+="</tr>";
                    
            }       
            strRetorno+="     </tbody>";
            strRetorno+="     <tfoot>";
            strRetorno+="       <td></td>";
            strRetorno+="       <td></td>";
            strRetorno+="       <td></td>";
            strRetorno+="       <td></td>";
            strRetorno+="       <td></td>";
            strRetorno+="       <td><b>Total</b></td>";
            strRetorno+="       <td id='total'>"+total_vl_ft+"</td>";
            strRetorno+="     </tfoot>";
            strRetorno+="   </table>";
            strRetorno+="</div>";
            strRetorno+="</div>";
            strRetorno+="<br><br><br><br>";
        
        
        }
        else{
            var strNenhumRegisto = "";
            strNenhumRegisto+="<div class='row'>";
            strNenhumRegisto+="<div class='col-md-12 text-center'>";
            strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
            strNenhumRegisto+=" </div>";
            strNenhumRegisto+="</div>";
            $("#grid").append(strNenhumRegisto);
        }
    if(strRetorno!=""){
        $("#grid").append(strRetorno);
    }else{
        var strNenhumRegisto = "";
        strNenhumRegisto+="<div class='row'>";
        strNenhumRegisto+="<div class='col-md-12 text-center'>";
        strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
        strNenhumRegisto+=" </div>";
        strNenhumRegisto+="</div>";
        $("#grid").append(strNenhumRegisto);
    }
}

};

function fcCancelar(){

sendPost("rel_movimentação_ft_res_form.php", {token: token});
}

function fcExport(){

var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
htmlPlanilha += '<![endif]--></head><body><table>' + $("#tblResultado").html() + '</table></body></html>';

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

function fcPegarTipoOC(){    
var objParametros = {
    "pk": tipos_ocorrencias_pk
};          
var arrCarregar = carregarController("tipo_ocorrencia", "listarPk", objParametros);    
$("#ds_tipo_oc").text(arrCarregar.data[0]['ds_tipo_ocorrencia']);
}
function fcPegarUsuarioCad(){    
var objParametros = {
    "pk": usuario_cadastro_pk
};          
var arrCarregar = carregarController("usuario", "listarPk", objParametros);      
$("#ds_usuario_cadastro").text(arrCarregar.data[0]['ds_usuario']);
}
function fcPegarAgendadoPara(){    
var objParametros = {
    "pk": usuario_agendado_para
};          
var arrCarregar = carregarController("usuario", "listarPk", objParametros);      
$("#ds_usuario_agendado_para").text(arrCarregar.data[0]['ds_usuario']);
}

$(document).ready(function(){    

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
    $("#ds_lead").text(ds_lead);
    $("#ds_colaborador").text(ds_colaborador);
    $("#periodo").text(dt_ini + " - " + dt_fim);
    
    fcCarregarGrid();
});



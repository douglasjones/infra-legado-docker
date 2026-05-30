var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";
    
    var objParametros = {
        "pk": colaborador_pk,
        "ic_status": ic_status
    };         

    var arrCarregar = carregarController("colaborador", "RelatorioDadosColaborador", objParametros); 

    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   
            
                    strRetorno+="<div class='row'><div class='col-md-12'>";
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>Colaborador</th>";
                    strRetorno+="<th width='20%'>Matricula</th>";
                    strRetorno+="<th width='20%'>Pin</th>";
                    strRetorno+="<th width='20%'>Data de Nascimento</th>";
                    strRetorno+="<th width='20%'>Grau Escolaridade</th>";
                    strRetorno+="<th width='20%'>RG</th>";
                    strRetorno+="<th width='20%'>CPF</th>";
                    strRetorno+="<th width='20%'>Empresa</th>";
                    strRetorno+="<th width='20%'>Qualificação</th>";
                    strRetorno+="<th width='20%'>Regime de Contratação</th>";
                    strRetorno+="<th width='20%'>Dt Contratação</th>";
                    strRetorno+="<th width='20%'>Dt Demissão</th>";
                    strRetorno+="<th width='20%'>Carga Horaria </th>";
                    strRetorno+="<th width='20%'>Salario</th>";
                    strRetorno+="<th width='20%'>Telefones</th>";
                    strRetorno+="<th width='20%'>Endereço</th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        if(arrCarregar.data[i]['ds_colaborador']==null){
                            var ds_colaboradorGrid = "";
                        }else{
                            var ds_colaboradorGrid = arrCarregar.data[i]['ds_colaborador'];
                        }
                        
                        if(arrCarregar.data[i]['dt_nascimento']==null){
                            var dt_nascimento = "";
                        }else{
                            var dt_nascimento = arrCarregar.data[i]['dt_nascimento'];
                        }
                        
                        if(arrCarregar.data[i]['ds_qualificacao']==null){
                            var ds_qualificacao = "";
                        } else{
                            var ds_qualificacao = arrCarregar.data[i]['ds_qualificacao'];
                        }
                        if(arrCarregar.data[i]['ds_escolaridade']==null){
                            var ds_escolaridade = "";
                        }
                        else{
                            var ds_escolaridade = arrCarregar.data[i]['ds_escolaridade'];
                        }
                        if(arrCarregar.data[i]['ds_rg']==null){
                            var ds_rg = "";
                        }
                        else{
                            var ds_rg = arrCarregar.data[i]['ds_rg'];
                        }
                        if(arrCarregar.data[i]['ds_cpf']==null){
                            var ds_cpf = "";
                        }
                        else{
                            var ds_cpf = arrCarregar.data[i]['ds_cpf'];
                        }
                        if(arrCarregar.data[i]['ds_razao_social']==null){
                            var ds_razao_social = "";
                        }
                        else{
                            var ds_razao_social = arrCarregar.data[i]['ds_razao_social'];
                        }
                        if(arrCarregar.data[i]['dt_admissao']==null){
                            var dt_admissao = "";
                        }
                        else{
                            var dt_admissao = arrCarregar.data[i]['dt_admissao'];
                        }
                        if(arrCarregar.data[i]['ds_regime_contratacao']==null){
                            var ds_regime_contratacao = "";
                        }
                        else{
                            var ds_regime_contratacao = arrCarregar.data[i]['ds_regime_contratacao'];
                        }
                        if(arrCarregar.data[i]['ds_carga_horaria_semanal']==null){
                            var ds_carga_horaria_semanal = "";
                        }
                        else{
                            var ds_carga_horaria_semanal = arrCarregar.data[i]['ds_carga_horaria_semanal'];
                        }
                        if(arrCarregar.data[i]['vl_salario']==null){
                            var vl_salario = "";
                        }
                        else{
                            var vl_salario = float2moeda(arrCarregar.data[i]['vl_salario']);
                        }
                        if(arrCarregar.data[i]['ds_cel']==null){
                            var ds_cel = "";
                        }
                        else{
                            var ds_cel = (arrCarregar.data[i]['ds_cel']);
                        }
                        if(arrCarregar.data[i]['ds_endereco']==null){
                            var ds_endereco = "";
                        }
                        else{
                            var ds_endereco = (arrCarregar.data[i]['ds_endereco']);
                        }
                        
                        if(arrCarregar.data[i]['dt_demissao']==null){
                            var dt_demissao = "";
                        }
                        else{
                            var dt_demissao = (arrCarregar.data[i]['dt_demissao']);
                        }

                        if(arrCarregar.data[i]['ds_matricula']==null){
                            var ds_matricula = "";
                        }else{
                            var ds_matricula = (arrCarregar.data[i]['ds_matricula']);
                        }
                        
                        if(arrCarregar.data[i]['ds_pin']==null){
                            var ds_pin = "";
                        }else{
                            var ds_pin = (arrCarregar.data[i]['ds_pin']);
                        }
                        
                        strRetorno+="<tr>";
                        strRetorno+="<th width='20%'>"+ds_colaboradorGrid+"</th>";
                        strRetorno+="<th width='20%'>"+ds_matricula+"</th>";
                        strRetorno+="<th width='20%'>"+ds_pin+"</th>";
                        strRetorno+="<th width='20%'>"+dt_nascimento+"</th>";
                        strRetorno+="<th width='20%'>"+ds_escolaridade+"</th>";
                         strRetorno+="<th width='20%'>"+ds_rg+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cpf+"</th>";
                        strRetorno+="<th width='20%'>"+ds_razao_social+"</th>";
                        strRetorno+="<th width='20%'>"+ds_qualificacao+"</th>";
                        strRetorno+="<th width='20%'>"+ds_regime_contratacao+"</th>";
                        strRetorno+="<th width='20%'>"+dt_admissao+"</th>";
                        strRetorno+="<th width='20%'>"+dt_demissao+"</th>";
                        strRetorno+="<th width='20%'>"+ds_carga_horaria_semanal+"</th>";
                        strRetorno+="<th width='20%'>"+vl_salario+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cel+"</th>";
                        strRetorno+="<th width='20%'>"+ds_endereco+"</th>";
                        strRetorno+="</tr>";
                }
                strRetorno+="</tbody>";
                strRetorno+="</table>";
                strRetorno+="</div>";
                strRetorno+="</div>";
                strRetorno+="<br><br><br><br>";
                if(strRetorno!=""){
                    $("#grid").html(strRetorno);
                }
                else{

                    strNenhumRegisto+="<div class='row'>";
                    strNenhumRegisto+="<div class='col-md-12 text-center'>";
                    strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
                    strNenhumRegisto+=" </div>";
                    strNenhumRegisto+="</div>";
                    $("#grid").html(strNenhumRegisto);
                }

        }
        else{
            strNenhumRegisto+="<div class='row'>";
            strNenhumRegisto+="<div class='col-md-12 text-center'>";
            strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
            strNenhumRegisto+=" </div>";
            strNenhumRegisto+="</div>";
            $("#grid").html(strNenhumRegisto);
        }
        
    }
    else{
        alert('Falhar ao carregar o registro');
    }
}



function fcCancelar(){

    sendPost("rel_dados_colaborador_res_form.php", {token: token});
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
  
    $("#ds_colaborador").text(ds_colaborador);
   
    fcCarregarGrid();

});



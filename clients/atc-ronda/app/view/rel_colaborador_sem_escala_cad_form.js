var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";
      
    var objParametros = {
        "pk": colaboradores_pk
    };         

    var arrCarregar = carregarController("colaborador", "RelatorioColaboradorSemEscala", objParametros); 
  
    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   

                    
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="       <tr>";
                    strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
                    strRetorno+="            <th><input type='text' id='txtFuncao' /></th>";
                    strRetorno+="            <th><input type='text' id='txtRE' /></th>";
                    strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
                    strRetorno+="            <th><input type='text' id='txtTurno' /></th>";
                    strRetorno+="            <th><input type='text' id='txtFerias' /></th>";
                    strRetorno+="            <th><input type='text' id='txtEscala' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="       </tr>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>R.E</th>";
                    strRetorno+="<th width='20%'>Data Cadastro</th>";
                    strRetorno+="<th width='20%'>Colaborador</th>";
                    strRetorno+="<th width='20%'>Qualificação</th>";
                    strRetorno+="<th width='20%'>Status</th>";
                    strRetorno+="<th width='20%'>Funcionário</th>";
                    strRetorno+="<th width='20%'>Data Admissão</th>";
                    strRetorno+="<th width='20%'>Matricula</th>";
                    strRetorno+="<th width='20%'>Cel</th>";
                    strRetorno+="<th width='20%'>E-mail</th>";
                    strRetorno+="<th width='20%'>RG</th>";
                    strRetorno+="<th width='20%'>CPF</th>";
                    strRetorno+="<th width='20%'>Data Nascimento</th>";
                    strRetorno+="<th width='20%'>Endereço</th>";
                    strRetorno+="<th width='20%'>Nº</th>";
                    strRetorno+="<th width='20%'>Complemento</th>";
                    strRetorno+="<th width='20%'>Bairro</th>";
                    strRetorno+="<th width='20%'>CEP</th>";
                    strRetorno+="<th width='20%'>Cidade</th>";
                    strRetorno+="<th width='20%'>UF</th>";
                    strRetorno+="<th width='20%'>Cel 2</th>";
                    strRetorno+="<th width='20%'>Cel 3</th>";
                    strRetorno+="<th width='20%'>Pin</th>";
                    strRetorno+="<th width='20%'>Raça</th>";
                    strRetorno+="<th width='20%'>Deficiência Fisica</th>";
                    strRetorno+="<th width='20%'>Estado Civil</th>";
                    strRetorno+="<th width='20%'>Nome Pai</th>";
                    strRetorno+="<th width='20%'>Nome Mãe</th>";
                    strRetorno+="<th width='20%'>Nome Cônjuge</th>";
                    strRetorno+="<th width='20%'>Data Nacimento Cônjuge</th>";
                    strRetorno+="<th width='20%'>CPF Cônjuge</th>";
                    strRetorno+="<th width='20%'>Tel Cônjuge</th>";
                    strRetorno+="<th width='20%'>Regime Casamento</th>";
                    strRetorno+="<th width='20%'>CTPS</th>";
                    strRetorno+="<th width='20%'>Serie</th>";
                    strRetorno+="<th width='20%'>Data Expedição</th>";
                    strRetorno+="<th width='20%'>UF RG</th>";
                    strRetorno+="<th width='20%'>Orgão Expedidor </th>";
                    strRetorno+="<th width='20%'>Pis</th>";
                    strRetorno+="<th width='20%'>Titulo Eleitoral</th>";
                    strRetorno+="<th width='20%'>Zona Eleitoral</th>";
                    strRetorno+="<th width='20%'>Seção</th>";
                    strRetorno+="<th width='20%'>Reservista</th>";
                    strRetorno+="<th width='20%'>Nacionalidade</th>";
                    strRetorno+="</tr>";
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        if(arrCarregar.data[i]['ds_re']==null){
                            var ds_re = "";
                        }
                        else{
                            var ds_re = arrCarregar.data[i]['ds_re'];
                        }
                        
                        if(arrCarregar.data[i]['dt_cadastro']==null){
                            var dt_cadastro = "";
                        }
                        else{
                            var dt_cadastro = arrCarregar.data[i]['dt_cadastro'];
                        }
                        
                        
           
                    
                        
                        
                        
                        if(arrCarregar.data[i]['ds_colaborador']==null){
                            var ds_colaborador = "";
                        }
                        else{
                            var ds_colaborador = arrCarregar.data[i]['ds_colaborador'];
                        }
                        if(arrCarregar.data[i]['ds_produto_servico']==null){
                            var ds_produto_servico = "";
                        }
                        else{
                            var ds_produto_servico = arrCarregar.data[i]['ds_produto_servico'];
                        }
                        if(arrCarregar.data[i]['ds_status']==null){
                            var ds_status = "";
                        }
                        else{
                            var ds_status = arrCarregar.data[i]['ds_status'];
                        }
                        if(arrCarregar.data[i]['ds_funcionario']==null){
                            var ds_funcionario = "";
                        }
                        else{
                            var ds_funcionario = arrCarregar.data[i]['ds_funcionario'];
                        }
                        if(arrCarregar.data[i]['dt_admissao']==null){
                            var dt_admissao = "";
                        }
                        else{
                            var dt_admissao = arrCarregar.data[i]['dt_admissao'];
                        }
                        if(arrCarregar.data[i]['ds_matricula']==null){
                            var ds_matricula = "";
                        }
                        else{
                            var ds_matricula = arrCarregar.data[i]['ds_matricula'];
                        }
                        if(arrCarregar.data[i]['ds_cel']==null){
                            var ds_cel = "";
                        }
                        else{
                            var ds_cel = arrCarregar.data[i]['ds_cel'];
                        }
                        if(arrCarregar.data[i]['ds_email']==null){
                            var ds_email = "";
                        }
                        else{
                            var ds_email = arrCarregar.data[i]['ds_email'];
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
                        if(arrCarregar.data[i]['dt_nascimento']==null){
                            var dt_nascimento = "";
                        }
                        else{
                            var dt_nascimento = arrCarregar.data[i]['dt_nascimento'];
                        }
                        if(arrCarregar.data[i]['ds_endereco']==null){
                            var ds_endereco = "";
                        }
                        else{
                            var ds_endereco = arrCarregar.data[i]['ds_endereco'];
                        }
                        if(arrCarregar.data[i]['ds_numero']==null){
                            var ds_numero = "";
                        }
                        else{
                            var ds_numero = arrCarregar.data[i]['ds_numero'];
                        }
                        if(arrCarregar.data[i]['ds_complemento']==null){
                            var ds_complemento = "";
                        }
                        else{
                            var ds_complemento = arrCarregar.data[i]['ds_complemento'];
                        }
                        if(arrCarregar.data[i]['ds_bairro']==null){
                            var ds_bairro = "";
                        }
                        else{
                            var ds_bairro = arrCarregar.data[i]['ds_bairro'];
                        }
                        if(arrCarregar.data[i]['ds_cep']==null){
                            var ds_cep = "";
                        }
                        else{
                            var ds_cep = arrCarregar.data[i]['ds_cep'];
                        }
                        if(arrCarregar.data[i]['ds_cidade']==null){
                            var ds_cidade = "";
                        }
                        else{
                            var ds_cidade = arrCarregar.data[i]['ds_cidade'];
                        }
                        if(arrCarregar.data[i]['ds_uf']==null){
                            var ds_uf = "";
                        }
                        else{
                            var ds_uf = arrCarregar.data[i]['ds_uf'];
                        }
                        if(arrCarregar.data[i]['ds_cel1']==null){
                            var ds_cel1 = "";
                        }
                        else{
                            var ds_cel1 = arrCarregar.data[i]['ds_cel1'];
                        }
                        if(arrCarregar.data[i]['ds_cel2']==null){
                            var ds_cel2 = "";
                        }
                        else{
                            var ds_cel2 = arrCarregar.data[i]['ds_cel2'];
                        }
                        if(arrCarregar.data[i]['ds_pin']==null){
                            var ds_pin = "";
                        }
                        else{
                            var ds_pin = arrCarregar.data[i]['ds_pin'];
                        }
                        if(arrCarregar.data[i]['ds_raca']==null){
                            var ds_raca = "";
                        }
                        else{
                            var ds_raca = arrCarregar.data[i]['ds_raca'];
                        }
                        if(arrCarregar.data[i]['ds_deficiencia_fisica']==null){
                            var ds_deficiencia_fisica = "";
                        }
                        else{
                            var ds_deficiencia_fisica = arrCarregar.data[i]['ds_deficiencia_fisica'];
                        }
                        if(arrCarregar.data[i]['ds_estado_civil']==null){
                            var ds_estado_civil = "";
                        }
                        else{
                            var ds_estado_civil = arrCarregar.data[i]['ds_estado_civil'];
                        }
                        if(arrCarregar.data[i]['ds_nome_pai']==null){
                            var ds_nome_pai = "";
                        }
                        else{
                            var ds_nome_pai = arrCarregar.data[i]['ds_nome_pai'];
                        }
                        if(arrCarregar.data[i]['ds_nome_mae']==null){
                            var ds_nome_mae = "";
                        }
                        else{
                            var ds_nome_mae = arrCarregar.data[i]['ds_nome_mae'];
                        }
                        if(arrCarregar.data[i]['ds_nome_conjuge']==null){
                            var ds_nome_conjuge = "";
                        }
                        else{
                            var ds_nome_conjuge = arrCarregar.data[i]['ds_nome_conjuge'];
                        }
                        if(arrCarregar.data[i]['dt_nascimento_conjuge']==null){
                            var dt_nascimento_conjuge = "";
                        }
                        else{
                            var dt_nascimento_conjuge = arrCarregar.data[i]['dt_nascimento_conjuge'];
                        }
                        if(arrCarregar.data[i]['ds_cpf_conjuge']==null){
                            var ds_cpf_conjuge = "";
                        }
                        else{
                            var ds_cpf_conjuge = arrCarregar.data[i]['ds_cpf_conjuge'];
                        }
                        if(arrCarregar.data[i]['ds_tel_conjuge']==null){
                            var ds_tel_conjuge = "";
                        }
                        else{
                            var ds_tel_conjuge = arrCarregar.data[i]['ds_tel_conjuge'];
                        }
                        if(arrCarregar.data[i]['regime_casamento']==null){
                            var regime_casamento = "";
                        }
                        else{
                            var regime_casamento = arrCarregar.data[i]['regime_casamento'];
                        }
                        if(arrCarregar.data[i]['ds_ctps']==null){
                            var ds_ctps = "";
                        }
                        else{
                            var ds_ctps = arrCarregar.data[i]['ds_ctps'];
                        }
                        if(arrCarregar.data[i]['ds_serie']==null){
                            var ds_serie = "";
                        }
                        else{
                            var ds_serie = arrCarregar.data[i]['ds_serie'];
                        }
                        if(arrCarregar.data[i]['dt_expedicao']==null){
                            var dt_expedicao = "";
                        }
                        else{
                            var dt_expedicao = arrCarregar.data[i]['dt_expedicao'];
                        }
                        if(arrCarregar.data[i]['ds_uf_rg']==null){
                            var ds_uf_rg = "";
                        }
                        else{
                            var ds_uf_rg = arrCarregar.data[i]['ds_uf_rg'];
                        }
                        if(arrCarregar.data[i]['ds_org_exp']==null){
                            var ds_org_exp = "";
                        }
                        else{
                            var ds_org_exp = arrCarregar.data[i]['ds_org_exp'];
                        }
                        if(arrCarregar.data[i]['ds_pis']==null){
                            var ds_pis = "";
                        }
                        else{
                            var ds_pis = arrCarregar.data[i]['ds_pis'];
                        }
                        if(arrCarregar.data[i]['ds_titulo_eleitoral']==null){
                            var ds_titulo_eleitoral = "";
                        }
                        else{
                            var ds_titulo_eleitoral = arrCarregar.data[i]['ds_titulo_eleitoral'];
                        }
                        if(arrCarregar.data[i]['ds_zona_eleitoral']==null){
                            var ds_zona_eleitoral = "";
                        }
                        else{
                            var ds_zona_eleitoral = arrCarregar.data[i]['ds_zona_eleitoral'];
                        }
                        if(arrCarregar.data[i]['ds_secao']==null){
                            var ds_secao = "";
                        }
                        else{
                            var ds_secao = arrCarregar.data[i]['ds_secao'];
                        }
                        if(arrCarregar.data[i]['ds_certificado_reservista']==null){
                            var ds_certificado_reservista = "";
                        }
                        else{
                            var ds_certificado_reservista = arrCarregar.data[i]['ds_certificado_reservista'];
                        }
                        if(arrCarregar.data[i]['ds_nacionalidade']==null){
                            var ds_nacionalidade = "";
                        }
                        else{
                            var ds_nacionalidade = arrCarregar.data[i]['ds_nacionalidade'];
                        }

                        strRetorno+="<tr>";
                        strRetorno+="<th width='20%'>"+ds_re+"</th>";
                        strRetorno+="<th width='20%'>"+dt_cadastro+"</th>";
                        strRetorno+="<th width='20%'>"+ds_colaborador+"</th>";
                        strRetorno+="<th width='20%'>"+ds_produto_servico+"</th>";
                        strRetorno+="<th width='20%'>"+ds_status+"</th>";
                        strRetorno+="<th width='20%'>"+ds_funcionario+"</th>";
                        strRetorno+="<th width='20%'>"+dt_admissao+"</th>";
                        strRetorno+="<th width='20%'>"+ds_matricula+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cel+"</th>";
                        strRetorno+="<th width='20%'>"+ds_email+"</th>";
                        strRetorno+="<th width='20%'>"+ds_rg+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cpf+"</th>";
                        strRetorno+="<th width='20%'>"+dt_nascimento+"</th>";
                        strRetorno+="<th width='20%'>"+ds_endereco+"</th>";
                        strRetorno+="<th width='20%'>"+ds_numero+"</th>";
                        strRetorno+="<th width='20%'>"+ds_complemento+"</th>";
                        strRetorno+="<th width='20%'>"+ds_bairro+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cep+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cidade+"</th>";
                        strRetorno+="<th width='20%'>"+ds_uf+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cel1+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cel2+"</th>";
                        strRetorno+="<th width='20%'>"+ds_pin+"</th>";
                        strRetorno+="<th width='20%'>"+ds_raca+"</th>";
                        strRetorno+="<th width='20%'>"+ds_deficiencia_fisica+"</th>";
                        strRetorno+="<th width='20%'>"+ds_estado_civil+"</th>";
                        strRetorno+="<th width='20%'>"+ds_nome_pai+"</th>";
                        strRetorno+="<th width='20%'>"+ds_nome_mae+"</th>";
                        strRetorno+="<th width='20%'>"+ds_nome_conjuge+"</th>";
                        strRetorno+="<th width='20%'>"+dt_nascimento_conjuge+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cpf_conjuge+"</th>";
                        strRetorno+="<th width='20%'>"+ds_tel_conjuge+"</th>";
                        strRetorno+="<th width='20%'>"+regime_casamento+"</th>";
                        strRetorno+="<th width='20%'>"+ds_ctps+"</th>";
                        strRetorno+="<th width='20%'>"+ds_serie+"</th>";
                        strRetorno+="<th width='20%'>"+dt_expedicao+"</th>";
                        strRetorno+="<th width='20%'>"+ds_uf_rg+"</th>";
                        strRetorno+="<th width='20%'>"+ds_org_exp+"</th>";
                        strRetorno+="<th width='20%'>"+ds_pis+"</th>";
                        strRetorno+="<th width='20%'>"+ds_titulo_eleitoral+"</th>";
                        strRetorno+="<th width='20%'>"+ds_zona_eleitoral+"</th>";
                        strRetorno+="<th width='20%'>"+ds_secao+"</th>";
                        strRetorno+="<th width='20%'>"+ds_certificado_reservista+"</th>";
                        strRetorno+="<th width='20%'>"+ds_nacionalidade+"</th>";
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

    sendPost("rel_colaborador_sem_escala_res_form.php", {token: token});
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
  fcCarregarGrid();
    $("#ds_colaborador").text(ds_colaborador);
     $("#tabela input").keyup(function(){
            var index = $(this).parent().index();
            var nth = "#tabela td:nth-child("+(index+1).toString()+")";
            var valor = $(this).val().toUpperCase();
            $("#tabela tbody tr").show();
            $(nth).each(function(){
                    if($(this).text().toUpperCase().indexOf(valor) < 0){
                            $(this).parent().hide();
                    }
            });
    });
    $("#tabela input").blur(function(){
            $(this).val("");
    });	
    $("#loader").hide();
    $("#exibir").show();
   
    

});



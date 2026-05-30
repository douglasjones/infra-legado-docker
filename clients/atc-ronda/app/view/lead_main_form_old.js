var tblContatos;
var tblProcessos;
var tblDocumentos;
var tblArquivos;

var click_oc = 1;
var click_processo = 1;
var click_documento = 1;


function fcExibirOc(){
    if(click_oc %2 == 0) {
        $("#exibir_oc").hide();
    }
    else{
        tblOcorrencia.clear().destroy();    
        fcCarregarGridOcorrencia();
         $("#exibir_oc").show();
    }
    click_oc++;        
}
function fcExibirProcesso(){    
    if(click_processo %2 == 0) {
        $("#exibir_processo").hide();
    }else{
        tblProcessos.clear().destroy();    
        fcCarregarGridProcessos();
        $("#exibir_processo").show();
    }
    click_processo++;
}

function fcExibirDocumeto(){
    if(click_documento %2 == 0) {
        $("#exibir_documento").hide();
    }else{
        tblDocumentos.clear().destroy(); 
        fcCarregarGridDocumentos();
        $("#exibir_documento").show();
    }
    click_documento++;  
}

function fcCarregar(){
    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_lead").html(arrCarregar.data[0]['ds_lead']);
            $("#ds_endereco").html(arrCarregar.data[0]['ds_endereco']);
            $("#ds_numero").html(arrCarregar.data[0]['ds_numero']);
            $("#ds_complemento").html(arrCarregar.data[0]['ds_complemento']);
            $("#ds_cep").html(arrCarregar.data[0]['ds_cep']);
            $("#ds_bairro").html(arrCarregar.data[0]['ds_bairro']);
            $("#ds_cidade").html(arrCarregar.data[0]['ds_cidade']);
            $("#ds_uf").html(arrCarregar.data[0]['ds_uf']);
            $("#ic_cliente").html(arrCarregar.data[0]['ds_ic_cliente']);
            $("#n_qtde_torres").html(arrCarregar.data[0]['n_qtde_torres']);
            $("#ds_obs").html(arrCarregar.data[0]['ds_obs']);
            
            $("#ds_razao_social").html(arrCarregar.data[0]['ds_razao_social']);
            $("#ds_cpf_cnpj").html(arrCarregar.data[0]['ds_cpf_cnpj']);
            $("#ds_ie").html(arrCarregar.data[0]['ds_ie']);
            $("#ds_tel_lead").html(arrCarregar.data[0]['ds_tel']);
            $("#ds_fax").html(arrCarregar.data[0]['ds_fax']);
            $("#ds_site").html(arrCarregar.data[0]['ds_site']);
            $("#ds_email_lead").html(arrCarregar.data[0]['ds_email']);
            $("#ds_supervisor").html(arrCarregar.data[0]['ds_supervisor']);
            $("#ds_responsavel").html(arrCarregar.data[0]['ds_responsavel']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}


function fcCarregarGridContato(){
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("lead", "listarContatoLead", objParametros);

    //Trata a tabela
    tblContatos = $('#tblContatos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [
           {"targets": -1, "data": "t_cargos_pk","visible":false},
           {"targets": -2, "data": "t_ds_cargos_pk"},
           {"targets": -3, "data": "t_ds_tel"},
           {"targets": -4, "data": "t_ic_whatsapp","visible":false},
           {"targets": -5, "data": "t_ds_whatsapp"},
           
           {"targets": -6, "data": "t_ds_cel"},
           {"targets": -7, "data": "t_ds_email"},
           {"targets": -8, "data": "t_ds_contato"},
           {"targets": -9, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    }); 
    
    
    return false;
}
function fcCarregarGridProcessos(){
    
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("processo", "listarProcessoLead", objParametros);
    //Trata a tabela
    tblProcessos = $('#tblProcessos').DataTable({
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
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_processo"},
           {"targets": -3, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    //Atribui os eventos na coluna ação.
    $('#tblProcessos tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblProcessos.row( $(this).parents('li')).data()){
            data = tblProcessos.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblProcessos.row( $(this).parents('tr')).data()){
            data = tblProcessos.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarProcessos(data);
        
    } );   
    
    $('#tblProcessos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblProcessos.row( $(this).parents('li') ).data()){
            data = tblProcessos.row( $(this).parents('li') ).data();
        }
        else if(tblProcessos.row( $(this).parents('tr') ).data()){
            data = tblProcessos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirProcessos(data['t_pk']);
        }
    } );     
}

function fcEditarProcessos(objRegistro){
    var arrCarregar = permissao("processo", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
     sendPost('processo_cad_form.php',{pk: objRegistro['t_pk'], processos_default_pk:objRegistro['processos_default_pk'] , leads_pk:pk, token:token,colaborador_pk:""});
    
}

function fcExcluirProcessos(v_pk){
    var arrCarregar = permissao("processo", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk,
            "leads_pk": pk
        };              

        var arrExcluir = carregarController("processo", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            tblProcessos.clear().destroy();    
            fcCarregarGridProcessos();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcCarregarGridDocumentos(){
    var objParametros = {
        "leads_pk": pk
    };     
    
    var v_url = montarUrlController("documento", "listarDocumentosLead", objParametros);

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
    NewWindow(v_url, '_blank');
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
function fcEditarLead(){
    var arrCarregar = permissao("lead", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    sendPost('lead_cad_form.php',{token: token, leads_pk: pk});
}

function fcIncluirProcesso(){
    var arrCarregar = permissao("processo", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    $("#processos_pk").val("");
    $("#janela_processos").modal();
}

function fcCarregarProcessos(){
    //Carrega os grupos
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("processo_default", "listarTodos", objParametros);    
    carregarComboAjax($("#processos_pk"), arrCarregar, " ", "pk", "ds_processo_default");
    
}

function fcValidarFormProcessos(){
    $("#form_processo").validate({
        rules :{
            processos_pk:{
                required:true
            }

        },
        messages:{
            processos_pk:{
                required:"Por favor, selecione Processo"
            }

        },
        submitHandler: function(form){
            fcEnviarProcesso(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}
function fcVerificarQtdeProcesso(){
    var Qtde = 0;
    var objParametros = {
        "leads_pk": pk
    };      
    var arrCarregar = carregarController("processo", "verificarQtdeLead", objParametros); 
   
    if (arrCarregar.result == 'success'){
        Qtde = arrCarregar.data[0]['qtde'];
    }
    
    return Qtde;
}
function fcEnviarProcesso(){
    var arrCarregar = permissao("processo", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    
    if(fcVerificarQtdeProcesso() > 0){
        alert('Já existe um processo cadastro.');
        return false;
    }
    
    //Carrega os grupos
    var v_processos_pk = $("#processos_pk").val();
    
    var objParametros = {
        "pk": v_processos_pk,
        "leads_pk": pk
    };      
    var arrEnviar = carregarController("processo", "salvar", objParametros);   
   
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_processos").modal("hide");
        alert(arrEnviar.message);
        sendPost("processo_cad_form.php", {token: token, pk:arrEnviar.data[0]['pk'], processos_default_pk:arrEnviar.data[0]['processos_default_pk'], leads_pk: pk,colaborador_pk:""});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
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
        "leads_pk": pk,
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
        "leads_pk": pk,
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivo", objParametros);           
   
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


function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}
$(function () {
    
    $('#fileupload').fileupload({
        
        dataType: 'json',
        done: function (e, data) {
           window.setTimeout('Reset()', 2000);
   
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

function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
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


function fcCarregarComboEquipe(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("equipe", "listarTodos", objParametros);   
    carregarComboAjax($("#agenda_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
        
}

function fcCarregarComboUsuario(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}


function fcVoltar(){

    sendPost("lead_res_form.php", {token: token});
}

function fcVerificaProcesso(){

    var objParametros = {
        "leads_pk": pk
    };     
     var arrCarregar = carregarController("processo", "listarProcessoLead", objParametros);  
     if (arrCarregar.result == 'success'){ 
         if(arrCarregar.data[0]['t_pk']>0){
            if(arrCarregar.data[0]['t_ds_processo']=='Operacional'){
                $("#cmdIncluirProcesso").prop("disabled",true);
            }             
         }
     }
}

$(document).ready(function()
    {
    var arrCarregar = permissao("lead", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
   
        //Atribui os eventos 
        $(document).on('click', '#cmdEditarLead', fcEditarLead);
        $(document).on('click', '#cmdVoltar', fcVoltar);
        $(document).on('click', '#cmdIncluirProcesso', fcIncluirProcesso); 
        
        $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);
        $(document).on('click', '#cmdCancelarDocumento', fcCancelarEnvioDocumento);

        $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);
        
        //carrega datepicker com a data atual (Agenda)
         
        
        //Carrega os dados do lead
        fcCarregar();


        //carrega dados da grid de contatos
        fcCarregarGridContato();
        
        //carrega dados da grid de processos
        fcCarregarGridProcessos();
        fcValidarFormProcessos();
        

        //carrega dados da grid de documentos
        fcCarregarGridDocumentos();
        
        fcCarregarGridArquivos();
        
        fcCarregarProcessos();
        
        fcVerificaProcesso();
                    
    }
);
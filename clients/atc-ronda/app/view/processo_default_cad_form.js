var tblEtapas;
var tblModulo;

function fcValidarForm(){

    $("#form").validate({
        rules :{
            ds_processo_default:{
                required:true,
                minlength:3
            }

        },
        messages:{
            ds_processo_default:{
                required:"Por favor, informe Processo",
                minlength:"Processo deve ter pelo menos 3 caracteres"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviar(){

    var v_ds_processo_default = $("#ds_processo_default").val();
    var v_ic_status = $("#ic_status").val();
    var strJSONDadosTabela = fcFormatarDadosEtapa();
    var strJSONDadosTabelaModulo = fcFormatarDadosModulo();


    var objParametros = {
        "pk": pk,
        "ds_processo_default": (v_ds_processo_default),
        "ic_status": (v_ic_status),
        "arrProcessoEtapa": (strJSONDadosTabela),
        "arrProcessoModulo": (strJSONDadosTabelaModulo)
        
    };    

    var arrEnviar = carregarController("processo_default", "salvar", objParametros);   

    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("processo_default_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("processo_default_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("processo_default", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#ds_processo_default").val(arrCarregar.data[0]['ds_processo_default']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
        
        fcAtualizarDadosGrid();
        fcAtualizarDadosGridModulo();
    }
}

function fcFormatarGrid(){
        
    tblEtapas = $("#tblEtapas").DataTable({
        "scrollX": true,
        "responsive": true,
        "searching": false,
        "paging": false,
        "columnDefs" : [{
            orderable: false,
            targets: [1,2]
        }],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    
    return false;
    
}

function fcIncluirEtapa(){
    
    tblEtapas.row.add([
            "<input type='text' onkeypress='mascara(this,soNumeros )' id='n_ordem_etapa' />",
            "<input type='text' id='ds_processo_default_etapa' />",
            "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"

    ]).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcExcluirLinha);
    
    return false;
}
function fcAtualizarDadosGrid(){
    
    var v_url = "../controller/processo_default_etapa.controller.php?job=listarProcessoDefaultPk&token="+token+"&processo_default_pk="+pk;
    var request = $.ajax({
        url:          v_url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    
    request.done(function(output){
        if (output.result == 'success'){
            for(i = 0; i < output.data.length; i++){

                //Adiciona a linha.
                fcIncluirEtapa();

                //Pega as variaveis 
                var cboDsProcessoDefaultEtapa = $("input[id='ds_processo_default_etapa']");
                var intOrdem = $("input[id='n_ordem_etapa']");
                
                cboDsProcessoDefaultEtapa.get(i).value = output.data[i]['t_ds_processo_default_etapa'];
                intOrdem.get(i).value = output.data[i]['t_n_ordem_etapa'];
                
            }
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });    
    
}
function fcExcluirLinha(){
    
    tblEtapas.row($(this).parents('tr')).remove().draw();
    
    return false;
}

function fcFormatarDadosEtapa(){

    var StringDsProcessoDefaultEtapa = $("input[id='ds_processo_default_etapa']");
    var IntOrdemEtapa = $("input[id='n_ordem_etapa']");
    
    var arrKeys = [];
    arrKeys[0] = "ds_processo_default_etapa";
    arrKeys[1] = "n_ordem_etapa";
    
    var arrDados = [];  
    
    for(i = 0; i < StringDsProcessoDefaultEtapa.length; i++){
        
        if(StringDsProcessoDefaultEtapa.get(i).value == ""){
            StringDsProcessoDefaultEtapa.get(i).focus();
            return false;
        }
        
        arrDados[i] = [StringDsProcessoDefaultEtapa.get(i).value, IntOrdemEtapa.get(i).value];
        
    }
    
    return arrayToJson(arrKeys, arrDados);
    
}

function fcFormatarGridtblModulo(){
        
    tblModulo = $("#tblModulo").DataTable({
        "scrollX": true,
        "responsive": true,
        "searching": false,
        "paging": false,
        "columnDefs" : [{
            orderable: false,
            targets: [1,2]
        }],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    
    return false;
    
}

function fcIncluirModulo(){
    var arrCarregar = carregarController("modulo", "listarTodos", '');

    var html = "";
        html += "<option></option>";

    for(var i=0; i<arrCarregar.data.length; i++){
        html += "<option value="+arrCarregar.data[i]['pk']+">"+arrCarregar.data[i]['ds_modulo']+"</option>";
    }

    tblModulo.row.add([
            "<input type='text' onkeypress='mascara(this,soNumeros )' id='n_ordem_modulo' />",
            "<select id='modulo_pk'>"+html+"</select>",
            "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
    ]).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcExcluirLinhaModulo);
    
    return false;
}

function fcAtualizarDadosGridModulo(){
    
    var v_url = "../controller/processo_default_configuracao.controller.php?job=listarModulosProcessoDefaultPk&token="+token+"&processo_default_pk="+pk;

    var request = $.ajax({
        url:          v_url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    
    request.done(function(output){
        if (output.result == 'success'){
            for(i = 0; i < output.data.length; i++){

                //Adiciona a linha.
                fcIncluirModulo();

                //Pega as variaveis 
                var cboDsProcessoDefaultModulo = $("select[id='modulo_pk']");
                var intOrdemodulo = $("input[id='n_ordem_modulo']");
                
                cboDsProcessoDefaultModulo.get(i).value = output.data[i]['modulos_pk'];
                intOrdemodulo.get(i).value = output.data[i]['n_ordem'];
                
            }
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });    
    
}

function fcExcluirLinhaModulo(){
    
    tblModulo.row($(this).parents('tr')).remove().draw();
    
    return false;
}

function fcFormatarDadosModulo(){

    //var StringDsProcessoDefaultModulo = $("#modulo_pk option:selected");
    var StringDsProcessoDefaultModulo = $("select[id='modulo_pk']");

    var IntOrdemModulo = $("input[id='n_ordem_modulo']");
    
    var arrKeys = [];
    arrKeys[0] = "modulo_pk";
    arrKeys[1] = "n_ordem_modulo";
    
    var arrDados = [];  
    
    for(i = 0; i < StringDsProcessoDefaultModulo.length; i++){
        if(StringDsProcessoDefaultModulo.get(i).value == ""){
            StringDsProcessoDefaultModulo.get(i).focus();
            return false;
        }
        
        arrDados[i] = [StringDsProcessoDefaultModulo.get(i).value, IntOrdemModulo.get(i).value];
        
    }
    
    return arrayToJson(arrKeys, arrDados);
    
}

$(document).ready(function()
    {
        var arrCarregar = permissao("processo_default", "ins");        

        if (arrCarregar.result != 'success'){            
            alert('Falhar ao carregar o registro');
            return false;
        }
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
        $(document).on('click', '#cmdIncluir', fcIncluirEtapa);
        $(document).on('click', '#cmdIncluirModulo', fcIncluirModulo);

        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        
        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
        
        //Carrega os dados no combo.
        fcFormatarGrid();
        fcFormatarGridtblModulo();

    }
);

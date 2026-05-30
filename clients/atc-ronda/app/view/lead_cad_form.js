var tblContatos;
var rLinhaSelecionada = null;

function fcValidarForm(){

    if($('#ic_tipo_lead').val()==""){
        $("#alert_tipo_lead").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_lead").slideUp(500);
        });
        $('#ic_tipo_lead').focus();
        return false;
    }
    if($('#ds_lead').val()==""){
        $("#alert_ds_lead").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_lead").slideUp(500);
        });
        $('#ds_lead').focus();
        return false;
    }
    if($("#ic_tipo_lead").val()==1){
        if($('#ds_cpf_cnpj').val()==""){
            $("#alert_cnpj").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_cnpj").slideUp(500);
            });
            $('#ds_cpf_cnpj').focus();
            return false;
        }
        else  if($('#ds_cpf_cnpj').val()!=""){
            var ds_cpf_cnpj = $('#ds_cpf_cnpj').val();
            if(ds_cpf_cnpj.length < 14 ){
                $("#alert_cnpj").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_cnpj").slideUp(500);
                });
                $('#ds_cpf_cnpj').focus();
                return false;
            }
            else if(ds_cpf_cnpj.length > 14 && ds_cpf_cnpj.length < 18 ){
                $("#alert_cnpj").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_cnpj").slideUp(500);
                });
                $('#ds_cpf_cnpj').focus();
                return false;
            }
        }
    }

    if($("#ic_tipo_lead").val()==2 && $("#leads_pai_pk").val()==""){
    
        if($('#ds_cpf_cnpj').val()==""){
            $("#alert_cnpj").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_cnpj").slideUp(500);
            });
            $('#ds_cpf_cnpj').focus();
            return false;
        }
        else  if($('#ds_cpf_cnpj').val()!=""){

            var ds_cpf_cnpj = $('#ds_cpf_cnpj').val();
            if(ds_cpf_cnpj.length < 14 ){
                
                $("#alert_cnpj").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_cnpj").slideUp(500);
                });
                $('#ds_cpf_cnpj').focus();
                return false;
            } else if(ds_cpf_cnpj.length > 14 && ds_cpf_cnpj.length < 18 ){
     
                /*$("#alert_cnpj").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_cnpj").slideUp(500);
                });
                $('#ds_cpf_cnpj').focus();
                return false;*/
            }
        }
    }
  
    if($('#ds_cep').val()==""){
        $("#alert_ds_cep").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_cep").slideUp(500);
        });
        $('#ds_cep').focus();
        return false;
    }
    if($('#ds_endereco').val()==""){
        $("#alert_ds_endereco").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_endereco").slideUp(500);
        });
        $('#ds_endereco').focus();
        return false;
    }
    if($('#ds_numero').val()==""){
        $("#alert_ds_numero").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_numero").slideUp(500);
        });
        $('#ds_numero').focus();
        return false;
    }
    if($('#ds_bairro').val()==""){
        $("#alert_cidade_bairro").show();
        $("#alert_ds_bairro").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_bairro").slideUp(500);
        });
        $('#ds_bairro').focus();
        return false;
    }
    if($('#ds_cidade').val()==""){
        $("#alert_cidade_bairro").show();
        $("#alert_ds_cidade").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_cidade").slideUp(500);
        });
        $('#ds_cidade').focus();
        return false;
    }
    if($('#ds_uf').val()==""){
        $("#alert_ds_uf").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_uf").slideUp(500);
        });
        $('#ds_uf').focus();
        return false;
    }
    if($('#ic_cliente').val()==""){
        $("#alert_ic_cliente").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ic_cliente").slideUp(500);
        });
        $('#ic_cliente').focus();
        return false;
    }   

    fcEnviar(); 
}


    function fcEnviar(){ 
        try {
            //Contatos
        var strJSONDadosTabela = fcFormatarDadosContato();

        //Materiais
        //var strJSONDadosMateriais = fcFormatarDadosMateriais();

        //Imposto
        var strJSONDadosImposto = fcFormatarDadosImposto();
        //Imposto
        var strJSONDadosDesconto = fcFormatarDadosDesconto();
            
        var v_ds_lead = $("#ds_lead").val();
        var v_ds_endereco = $("#ds_endereco").val();
        var v_ds_numero = $("#ds_numero").val();
        var v_ds_complemento = $("#ds_complemento").val();
        var v_ds_cep = $("#ds_cep").val();
        var v_ds_bairro = $("#ds_bairro").val();
        var v_ds_cidade = $("#ds_cidade").val();
        var v_ds_uf = $("#ds_uf").val();
        var v_ic_cliente = $("#ic_cliente").val();
        var v_n_qtde_torres = $("#n_qtde_torres").val();
        var v_ds_obs = $("#ds_obs").val();
        var v_ds_razao_social = $("#ds_razao_social").val();
        var v_ds_cpf_cnpj = $("#ds_cpf_cnpj").val();
        var v_ds_ie = $("#ds_ie").val();
        var v_ds_tel_lead = $("#ds_tel_fixo").val();
        var v_ds_fax = $("#ds_tel_fixo1").val();
        var v_ds_site = $("#ds_site").val();
        var v_ds_email_lead = $("#ds_email_contato_receita").val();
        var v_supervisores_pk = $("#supervisores_pk").val();
        var v_supervisor1_pk = $("#supervisor1_pk").val();
        var v_supervisor2_pk = $("#supervisor2_pk").val();
        var v_responsavel_pk = $("#responsavel_pk").val();
        var v_segmentos_pk = $("#segmentos_pk").val();
        var v_dt_vencimento = $("#dt_vencimento").val();
        var v_leads_pai_pk = $("#leads_pai_pk").val();
        var v_ic_tipo_lead = $("#ic_tipo_lead").val();
        var v_ds_tipo_lead = $("#ds_tipo_lead").val();
        var v_ds_porte = $("#ds_porte").val();
        var t_dt_abertura = $("#dt_abertura").val();
        var v_ds_atividade_principal_receita = $("#ds_atividade_principal_receita").val();
        var v_ds_atividade_secundaria_receita = $("#ds_atividade_secundaria_receita").val();
        var v_ds_socio1 = $("#ds_socio1").val();
        var v_ds_socio2 = $("#ds_socio2").val();
        var v_ds_socio3 = $("#ds_socio3").val();

        var objParametros = {
            "pk": leads_pk,
            "ds_lead": (v_ds_lead),
            "ds_endereco": (v_ds_endereco),
            "ds_numero": (v_ds_numero),
            "ds_complemento": (v_ds_complemento),
            "ds_cep": (v_ds_cep),
            "ds_bairro": (v_ds_bairro),
            "ds_cidade": (v_ds_cidade),
            "ds_uf": (v_ds_uf),
            "ic_cliente": (v_ic_cliente),      
            "n_qtde_torres": (v_n_qtde_torres),      
            "ds_obs": (v_ds_obs),
            "ds_razao_social": (v_ds_razao_social),
            "ds_cpf_cnpj": (v_ds_cpf_cnpj),
            "ds_ie": (v_ds_ie),
            "ds_tel": (v_ds_tel_lead),
            "ds_fax": (v_ds_fax),
            "ds_site": (v_ds_site),
            "leads_pai_pk": (v_leads_pai_pk),
            "ic_tipo_lead": (v_ic_tipo_lead),
            "supervisores_pk": (v_supervisores_pk),
            "supervisor1_pk": (v_supervisor1_pk),
            "supervisor2_pk": (v_supervisor2_pk),
            "responsavel_pk": (v_responsavel_pk),
            "ds_email": (v_ds_email_lead),
            "segmentos_pk": (v_segmentos_pk),
            "dt_vencimento": (v_dt_vencimento),
            "contatos_lead": (strJSONDadosTabela),  
            "imposto_pk": (strJSONDadosImposto),  
            "descontos_pk": (strJSONDadosDesconto),  
            "ds_tipo": (v_ds_tipo_lead),
            "ds_porte": (v_ds_porte),
            "dt_abertura": (t_dt_abertura),
            "ds_atividade_principal": (v_ds_atividade_principal_receita),
            "ds_atividade_secundaria": (v_ds_atividade_secundaria_receita),
            "ds_socio1": (v_ds_socio1),
            "ds_socio2": (v_ds_socio2),
            "ds_socio3": (v_ds_socio3), 
             
            "processo_default_configuracao_pk": (processo_default_configuracao_pk)
            //"materiais_lead": (strJSONDadosMateriais)  
        };  

        var arrEnviar = carregarController("lead", "salvar", objParametros); 
        //NewWindow(v_last_url)
        if (arrEnviar.result == 'success'){
            // Reload datable
            alert(arrEnviar.message);
            if(ic_processo_comercial != 1){
                sendPost("lead_res_form.php", {token: token, ic_abertura: 1});
            }else{
                sendPost("comercial_painel_res_form.php", {token: token, ic_abertura: 2});
            }
        }
        else{
            alert('Falhou a requisição para salvar o registro');
        }
        } catch (error) {
            alert(error)
        }
        
        
    }

function fcCancelar(){
    if(ic_processo_comercial != 1){
        sendPost("lead_res_form.php", {token: token, ic_abertura: 1});
    }else{
        sendPost("comercial_painel_res_form.php", {token: token, ic_abertura: 2});
    }
   // sendPost("lead_res_form.php", {token: token});
}

function fcCarregar(){
 
    try {
        if(leads_pk > 0){
            var objParametros = {
                "pk": leads_pk
            }; 
            
            colaborador_pk = "";
            var arrCarregar = carregarController("lead", "listarPk", objParametros);
    
            if (arrCarregar.result == 'success'){        
                $("#ds_lead").val(arrCarregar.data[0]['ds_lead']);
                $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
                $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
                $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
                $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
                $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
                $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
                $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
                $("#ic_cliente").val(arrCarregar.data[0]['ic_cliente']);
                $("#n_qtde_torres").val(arrCarregar.data[0]['n_qtde_torres']);
                $("#ds_obs").val(arrCarregar.data[0]['ds_obs']);            
                $("#ds_razao_social").val(arrCarregar.data[0]['ds_razao_social']);
                $("#ds_cpf_cnpj").val(arrCarregar.data[0]['ds_cpf_cnpj']);
                $("#ds_ie").val(arrCarregar.data[0]['ds_ie']);
                $("#ds_tel_fixo").val(arrCarregar.data[0]['ds_tel']);
                $("#ds_tel_fixo1").val(arrCarregar.data[0]['ds_fax']);
                $("#ds_site").val(arrCarregar.data[0]['ds_site']);
                $("#ds_email_contato_receita").val(arrCarregar.data[0]['ds_email']);
                $("#supervisores_pk").val(arrCarregar.data[0]['supervisores_pk']);
                $("#supervisor1_pk").val(arrCarregar.data[0]['supervisor1_pk']);
                $("#supervisor2_pk").val(arrCarregar.data[0]['supervisor2_pk']);
                $("#responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
                $("#segmentos_pk").val(arrCarregar.data[0]['segmentos_pk']);            
                $("#dt_vencimento").val(arrCarregar.data[0]['dt_vencimento']);            
                $("#leads_pai_pk").val(arrCarregar.data[0]['leads_pai_pk']);            
                $("#ic_tipo_lead").val(arrCarregar.data[0]['ic_tipo_lead']);     
                $("#ds_tipo_lead").val(arrCarregar.data[0]['ds_tipo']);
                $("#ds_porte").val(arrCarregar.data[0]['ds_porte']);
                $("#dt_abertura").val(arrCarregar.data[0]['dt_abertura']);
                $("#ds_atividade_principal_receita").val(arrCarregar.data[0]['ds_atividade_principal']);
                $("#ds_atividade_secundaria_receita").val(arrCarregar.data[0]['ds_atividade_secundaria']);            
                $("#ds_socio1").val(arrCarregar.data[0]['ds_socio1']);            
                $("#ds_socio2").val(arrCarregar.data[0]['ds_socio2']);            
                $("#ds_socio3").val(arrCarregar.data[0]['ds_socio3']);     
                    if($("#ic_tipo_lead").val()==1){
                        $("#lead_pai").hide();
                    }
                    else if($("#ic_tipo_lead").val()==2){
                        $(".chzn-select").chosen('destroy');
                        $("#lead_pai").show();
                        $(".chzn-select").chosen({allow_single_deselect: true});
                    }
            }
            else{
                alert('Falhar ao carregar o registro');
            }
        } 
    } catch (error) {
        alert(error)
    }
    
}

// ---------------------------------------------------------
//Inicio das funcoes da tela de contato (Modal).

function fcCarregarGridContato(){
    
    var objParametros = {
        "leads_pk": leads_pk
    };     
    
    var v_url = montarUrlController("lead", "listarContatoLead", objParametros);
    //Trata a tabela
    tblContatos = $('#tblContatos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_cargos_pk","visible":false},
           {"targets": -3, "data": "t_ds_cargos_pk"},
           {"targets": -4, "data": "t_ds_tel"},
           {"targets": -5, "data": "t_ic_whatsapp","visible":false},
           {"targets": -6, "data": "t_ds_whatsapp"},
           
           {"targets": -7, "data": "t_ds_cel"},
           {"targets": -8, "data": "t_ds_email"},
           {"targets": -9, "data": "t_ds_contato"},
           {"targets": -10, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblContatos tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblContatos.row( $(this).parents('li')).data()){
            data = tblContatos.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblContatos.row( $(this).parents('tr')).data()){
            data = tblContatos.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarContato(data);
        
    } );   
    
    $('#tblContatos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblContatos.row( $(this).parents('li') ).data()){
            data = tblContatos.row( $(this).parents('li') ).data();
        }
        else if(tblContatos.row( $(this).parents('tr') ).data()){
            data = tblContatos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirContato(data['t_pk']);
        }
        tblContatos.row($(this).parents('tr')).remove().draw();
    } ); 
    
    return false;
}


function fcEditarContato(objRegistro){
    fcLimparFormContato();
    $("#janela_contatos").modal();
    $("#contatos_pk").val("");
    $("#acao").val("upd");
    
    //Carrega as informações da linha selecionada.
    $("#contatos_pk").val(objRegistro['t_pk']);
    $("#ds_contato").val(objRegistro['t_ds_contato']);
    $("#ds_email").val(objRegistro['t_ds_email']);
    $("#ds_cel").val(objRegistro['t_ds_cel']);
    $("#ic_whatsapp").val(objRegistro['t_ic_whatsapp']);
    $("#ds_tel_contato").val(objRegistro['t_ds_tel']);
    $("#cargos_pk").val(objRegistro['t_cargos_pk']);  
    
}

function fcExcluirContato(v_pk){
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("contato", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcBotoesGridContatos(){
    return "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>";
}

function fcEnviarContato(){
        if(leads_pk == ""){
            if($("#acao").val() == "ins"){
                fcIncluirContatoSemPk();
            }
            else if($("#acao").val() == "upd"){
                fcEditarContatoSemPk();
            }
        }
        else{
            fcSalvarContato();
        }   
        $("#janela_contatos").modal("hide");
}

function fcRecarregarGridContatos(){
    tblContatos.clear().destroy();    
    fcCarregarGridContato();
}

function fcSalvarContato(){
    
    
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": $("#contatos_pk").val(),
        "leads_pk": leads_pk,
        "ds_contato": $("#ds_contato").val(),
        "ds_email": $("#ds_email").val(),
        "ds_cel": $("#ds_cel").val(),
        "ds_tel": $("#ds_tel_contato").val(),
        "ic_whatsapp": $("#ic_whatsapp").val(),
        "cargos_pk": $("#cargos_pk").val() 
    }; 
    var arrEnviar = carregarController("contato", "salvar", objParametros);
    
    if (arrEnviar.result == 'success'){
        fcRecarregarGridContatos();
    }else{
        alert(arrEnviar.result);
    }
    
}

function fcIncluirContatoSemPk(){      
    tblContatos.row.add(
        {
            "t_pk":"",
            "t_ds_contato":$("#ds_contato").val(),
            "t_ds_email":$("#ds_email").val(),
            "t_ds_cel":$("#ds_cel").val(),
            "t_ic_whatsapp":$("#ic_whatsapp").val(),
            "t_ds_whatsapp":$("#ic_whatsapp option:selected").text(),
            "t_ds_tel":$("#ds_tel_contato").val(),
            "t_cargos_pk":$("#cargos_pk").val(),
            "t_ds_cargos_pk":$("#cargos_pk option:selected").text(),
            "t_functions":""
        }
    ).draw();
    
    return false;
}

function fcExcluirContatoSemPk(){
   tblContatos.row($(this).parents('tr')).remove().draw();
   return false;
}

function fcEditarContatoSemPk(){
    
    fcIncluirContatoSemPk();
    tblContatos.row(rLinhaSelecionada).remove().draw();
    return false;
}


function fcCarregarCargo(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("cargo", "listarTodos", objParametros);    
    carregarComboAjax($("#cargos_pk"), arrCarregar, " ", "pk", "ds_cargo");
        
}

function fcCarregarSupervisor(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarSupervisor", objParametros);  
    carregarComboAjax($("#supervisores_pk"), arrCarregar, " ", "pk", "ds_usuario");
    carregarComboAjax($("#supervisor1_pk"), arrCarregar, " ", "pk", "ds_usuario");
    carregarComboAjax($("#supervisor2_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}
function fcCarregarResponsavel(){    
    var objParametros = {
        "pk": ""
    };     
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");        
}

function fcFormatarDadosContato(){    
        var contatosPk = "";
        var dsContato = "";
        var dsEmail =  "";
        var dsCel = "";
        var icWhatsapp = "";
        var dsTelContato = "";
        var cboCargosPk = "";
        
        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "contatos_pk";
        arrKeys[1] = "ds_contato";
        arrKeys[2] = "ds_email";
        arrKeys[3] = "ds_cel";
        arrKeys[4] = "ic_whatsapp";
        arrKeys[5] = "ds_tel_contato";
        arrKeys[6] = "cargos_pk";
        
        var  data = tblContatos.rows().data();
        
        for(i = 0; i< data.length; i++){
            contatosPk = data[i]['t_pk'];
            dsContato = data[i]['t_ds_contato'];
            dsEmail =  data[i]['t_ds_email'];
            dsCel = data[i]['t_ds_cel'];
            icWhatsapp = data[i]['t_ic_whatsapp'];
            dsTelContato = data[i]['t_ds_tel'];
            cboCargosPk = data[i]['t_cargos_pk'];                        
            arrDados[i] = [contatosPk, dsContato, dsEmail, dsCel, icWhatsapp, dsTelContato, cboCargosPk];                        
        }
        return arrayToJson(arrKeys, arrDados);
}

/*function fcFormatarDadosMateriais(){    
    try{
        var movimentacao_estoquePk = "";
        var categorias_produto_pk = "";
        var produtos_pk =  "";
        var produtos_itens_pk = "";
        var dt_entrega= "";
        var dt_devolucao = "";
        var obs_material = "";
        var ic_mateiral_carga = "";
        
        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "movimentacao_estoque_pk";
        arrKeys[1] = "categorias_produto_pk";
        arrKeys[2] = "produtos_pk";
        arrKeys[3] = "produtos_itens_pk";
        arrKeys[4] = "dt_entrega";
        arrKeys[5] = "dt_devolucao";
        arrKeys[6] = "obs_material";
        arrKeys[7] = "ic_mateiral_carga";
        
        var  data = tblMaterial.rows().data();
        
        for(i = 0; i< data.length; i++){
            if(data[i]['pk']==""){
                movimentacao_estoquePk = data[i]['pk'];
                categorias_produto_pk = data[i]['categorias_produto_pk'];
                produtos_pk =  data[i]['produtos_pk'];
                produtos_itens_pk = data[i]['produtos_itens_pk'];
                dt_entrega = data[i]['dt_entrega'];
                dt_devolucao = data[i]['dt_devolucao'];
                obs_material = data[i]['obs_material'];                        
                ic_mateiral_carga = data[i]['ic_mateiral_carga'];                        
                arrDados[i] = [movimentacao_estoquePk, categorias_produto_pk, produtos_pk, produtos_itens_pk, dt_entrega, dt_devolucao, obs_material,ic_mateiral_carga]; 
            }
                                   
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    } 
}*/

function fcLimparFormContato(){
    $("#acao").val("");
    $("#contatos_pk").val("");
    $("#ds_contato").val("");
    $("#ds_email").val("");
    $("#ds_cel").val("");
    $("#ic_whatsapp").val("");
    $("#ds_tel_contato").val("");
    $("#cargos_pk").val("");        
}

//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoContato(){
    
    //limpa os dados de qualquer registro existe
    fcLimparFormContato();
    
    $("#janela_contatos").modal();
    $("#acao").val("ins");
    $("#contatos_pk").val("");
}

function fcValidarFormContato(){
    
    $("#form_contato").validate({
        rules :{
            ds_contato:{
                required:true,
                minlength:3
            },
            ic_whatsapp:{
                required:true
            },
            ds_cel:{
                required:true,
                minlength:13
            },
            ds_tel_contato:{
                minlength:13
            },
            ds_email:{
                email: true
            }

        },
        messages:{
            ds_contato:{
                required:"Por favor, informe Contato",
                minlength:"Contato deve ter pelo menos 3 caracteres"
            },
            ds_cel:{
                required:"Por favor, informe Celular",
                minlength:"Por favor, informe Celular válido"
            },
            ds_tel_contato:{
                minlength:"Por favor, informe Telefone válido"
            },
            ic_whatsapp:{
                required:"Por favor, informe WhatsApp"
            },
            ds_email:{
                email:"Por favor, informe E-mail válido"
            }

        },
        submitHandler: function(form){
            fcEnviarContato(); //Se a validação deu certo, faz o envio do formulario.
            
            return false;
        }
    });

}        
function fcVerificarCNPJ(){
    var ds_cpf_cnpj = $("#ds_cpf_cnpj").val();
    if(ds_cpf_cnpj.length == 14 || ds_cpf_cnpj.length == 18){
        var objParametros = {
            "ds_cpf_cnpj": $("#ds_cpf_cnpj").val()
        };        
        
        var arrCarregar = carregarController("lead", "verificarCNPJ", objParametros);
    
        if (arrCarregar.result == 'success'){

            if(arrCarregar.data.length > 0){
                alert("Já existe um Lead com esse CNPJ");
                $("#ds_lead").val("");
                $("#ds_cpf_cnpj").val("");
                $("#ds_cidade").val("");
                $("#ds_endereco").val("");
                $("#ds_bairro").val("");
                $("#ds_uf").val("");
                
            }
            

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
       
       
}        


function fcCarregarLeadPai(){    
    var objParametros = {
        "pk": ""
    };     
    
    var arrCarregar = carregarController("lead", "listarLeadPai", objParametros);  
    
    carregarComboAjax($("#leads_pai_pk"), arrCarregar, " ", "pk", "ds_lead");        
}

$(document).ready(function(){

    colaborador_pk ="";
    $("#exibir_material").hide();
    
    if(leads_pk!=""){
        $("#exibir_material").show();
    }
    var arrCarregar = permissao("lead", "ins");        
    
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    
    //Atribui os eventos - Leads
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdEnviarTudo', fcValidarForm);
    $(document).on('click', '#btn_modal', fcAbrirFormNovoContato);
    //atribui mascara aos campos - Lead

    $('#dt_vencimento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_vencimento").keypress(function(){
        mascara(this,mdata);
    });

    $('#dt_abertura').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_abertura").keypress(function(){
        mascara(this,mdata);
    });
    
    $("#ds_cep").keypress(function(){
        mascara(this,cep);
    });
    $("#n_qtde_torres").keypress(function(){
        mascara(this,soNumeros);
    });      
    $("#ds_cpf_cnpj").keypress(function(){
        chama_mascara(this);
    });       

    $("#ds_tel_fixo").keypress(function(){
        mascara(this,mascaraTelefone);
    });        
    $("#ds_tel_fixo1").keypress(function(){
        mascara(this,mascaraTelefone);
    });        
    $("#ds_ie").keypress(function(){
        mascara(this,soNumeros);
    });        
    //Atribui os eventos dos controles do formulario de contatos.
    
    fcValidarFormContato();
    //Carrega os dados cadastrais do lead
    fcCarregarSupervisor();

    fcCarregarResponsavel();
    
    $("#lead_pai").hide();
    fcCarregarLeadPai();
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    fcCarregar();
    
    
    if($("#ic_cliente").val()==""){
        $("#ic_cliente").val(2);
    }
    
    //---------------------------------------------
    //atribui mascara aos campos - Contato

    $("#ds_tel_contato").on('keypress', function () {
        mascara(this, mascaraTelefone);
    });
    $("#ds_cel").on('keypress', function () {
        mascara(this, mascaraTelefone);
    });
    $("#ds_cep").change(function(){
        fcCarregarCep($("#ds_cep").val());
    });
    $("#ds_cpf_cnpj").change(function(){
        fcVerificarCNPJ();
    });
    
    $("#ic_tipo_lead").change(function(){
        if($("#ic_tipo_lead").val()==1){
            $("#lead_pai").hide();
            $("#lead_pai_pk").val("");
        }
        else if($("#ic_tipo_lead").val()==2){
            $(".chzn-select").chosen('destroy');
            $("#lead_pai").show();
            $(".chzn-select").chosen({allow_single_deselect: true});
        }
    });
    $(".chzn-select").chosen({width: "200%"});

    //Carrega os dados do campo de Cargo na tela modal dos contatos
    fcCarregarCargo();

    //Formata a grid de contatoss
    fcCarregarGridContato();
    
});
	
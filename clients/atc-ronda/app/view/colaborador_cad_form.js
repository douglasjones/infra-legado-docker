

function fcValidarFormColaborador(){

    if($('#ds_colaborador').val()==""){
        alert("Por favor, informe Colaborador");
        $('#ds_colaborador').focus();
        return false;
    }else if($('#ds_colaborador').val().length < 3){
        alert("Colaborador deve ter pelo menos 3 caracteres");
        $('#ds_colaborador').focus();
        return false;
    }

    if($('#dt_nascimento').val()==""){
        alert("Por favor, informe Data Nascimento");
        $('#dt_nascimento').focus();
        return false;
    }else if($('#dt_nascimento').val().length < 10){
        alert("Por favor, informe Data Nascimento válida");
        $('#dt_nascimento').focus();
        return false;
    }

    if($('#generos_pk').val()==""){
        alert("Por favor, informe Gênero");
        $('#generos_pk').focus();
        return false;
    }

    if($('#ic_status').val()==""){
        alert("Por favor, informe Status");
        $('#ic_status').focus();
        return false;
    }

    if($('#ic_status').val()!=5){
        
        if($('#ds_cpf').val()==""){
            alert("Por favor, informe CPF");
            $('#ds_cpf').focus();
            return false;
        }else if($('#ds_cpf').val().length < 14){
            alert("Por favor, informe CPF válido");
            $('#ds_cpf').focus();
            return false;
        }

        if($('#ds_rg').val()==""){
            alert("Por favor, informe RG/RNE");
            $('#ds_rg').focus();
            return false;
        }else if($('#ds_rg').val().length < 9){
            alert("Por favor, informe RG/RNE válido");
            $('#ds_rg').focus();
            return false;
        }
    }

    if($('#ds_cel').val()==""){
        alert("Por favor, informe Cel");
        $('#ds_cel').focus();
        return false;
    }else if($('#ds_cel').val().length < 13){
        alert("Por favor, informe um Cel Válido");
        $('#ds_cel').focus();
        return false;
    }

    if($('#ds_cel2').val()!=""){
        if($('#ds_cel2').val().length < 13){
            alert("Por favor, informe um Cel2 Válido");
            $('#ds_cel2').focus();
            return false;
        }
    }

    if($('#ds_cel3').val()!=""){
        if($('#ds_cel3').val().length < 13){
            alert("Por favor, informe um Cel3 Válido");
            $('#ds_cel3').focus();
            return false;
        }
    }

    if($("#ic_status").val() == 2){

        fcValidarDemissao();
    }else{
       fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
    }
    return false;
}

function fcEnviar(){

    var strJSONDadosTabela = fcFormatarDadosQualificacao();
    if(strJSONDadosTabela=="[]"){
        alert("Por favor, informe ao menos uma Qualificação");
        return false;
    }

    var strJSONDadosTabelaNomeFilho = fcFormatarDadosNomeFilho();
    if(strJSONDadosTabelaNomeFilho==0){
        alert("Por favor, preencha todos os campos de Filho!");
        return false;
    }
    var strJSONDadosTabelaAfastamento = fcFormatarDadosAfastamento();
    if(strJSONDadosTabelaAfastamento==1){
        alert("Por favor, preencha Tipo Apontamento e Data Inicio!");
        return false;
    }

    //var strJSONDadosTabelaEscala = fcFormatarDadosEscala();
    
    var strJSONDadosTabelaEscala; 
    
    var strJsonBeneficios = fcFormatarDadosBeneficio();
    var strJsonCurso = fcFormatarDadosCurso();

    var v_ds_colaborador = $("#ds_colaborador").val();
    var v_ds_cel = $("#ds_cel").val();
    var v_ic_whatsapp = $("#ic_whatsapp").val();

    var v_ds_cel2 = $("#ds_cel2").val();
    var v_ic_whatsapp2 = $("#ic_whatsapp2").val();

    var v_ds_cel3 = $("#ds_cel3").val();
    var v_ic_whatsapp3 = $("#ic_whatsapp3").val();

    var v_ds_email = $("#ds_email").val();
    var v_ds_rg = $("#ds_rg").val();
    var v_ds_cpf = $("#ds_cpf").val();
    var v_dt_nascimento = $("#dt_nascimento").val();
    var v_ds_endereco = $("#ds_endereco").val();
    var v_ds_numero = $("#ds_numero").val();
    var v_ds_complemento = $("#ds_complemento").val();
    var v_ds_bairro = $("#ds_bairro").val();
    var v_ds_cep = $("#ds_cep").val();
    var v_ds_cidade = $("#ds_cidade").val();
    var v_ds_uf = $("#ds_uf").val();
    var v_ic_status = $("#ic_status").val();
    var v_generos_pk = $("#generos_pk").val();
    var v_ic_funcionario = $("#ic_funcionario").val();
    var ds_re = $("#ds_re").val();
    var v_produtos_servicos_colaboradores = strJSONDadosTabela;
    
    var ds_nacionalidade = $("#ds_nacionalidade").val();
    var ds_matricula = $("#ds_matricula").val();
    var grau_escolaridade_pk = $("#grau_escolaridade_pk").val();
    
    var ds_n_sapato = $("#ds_n_sapato").val();
    var ds_n_camisa = $("#ds_n_camisa").val();
    var ds_n_calca = $("#ds_n_calca").val();
    
    if($("#vl_salario").val()!=""){
        var vl_salario = moeda2float($("#vl_salario").val());
    }
    else {
        var vl_salario = 0;
    }

    var ic_dom = 2;
    var ic_seg = 2;
    var ic_ter = 2;
    var ic_qua = 2;
    var ic_qui = 2;
    var ic_sex = 2;
    var ic_sab = 2;
    var ic_registrar_ponto = 2;
    //verifica quais dias foram selecionados

    if($('#ic_registrar_ponto').is(":checked")){
        ic_registrar_ponto = 1;
    }
    else{
        ic_registrar_ponto = 2;
    }

    var ic_filho_menor_14 = "";
    if($('#ic_filho_menor_14').is(":checked")){
            ic_filho_menor_14 = 1;
    }
    var ic_reserva = "";
    if($('#ic_reserva').is(":checked")){
            ic_reserva = 1;
    }

    var v_ds_n_luva = $("#ds_n_luva").val();

    //Novos Campos Douglas - Alt 08-05-23
    var v_ic_tipo_sanguineo = $("#ic_tipo_sanguineo").val();
    var v_ds_cartao_sus = $("#ds_cartao_sus").val();
    var v_ic_tipo_sanguineo_conjuge = $("#ic_tipo_sanguineo_conjuge").val();
    var v_ds_cartao_sus_conjuge = $("#ds_cartao_sus_conjuge").val();

    var objParametros = {
        "pk": colaborador_pk,
        "ds_colaborador": (v_ds_colaborador),
        "ds_cel": (v_ds_cel),
        "ic_whatsapp": (v_ic_whatsapp),
        "ds_cel2": (v_ds_cel2),
        "ic_whatsapp2": (v_ic_whatsapp2),
        "ds_cel3": (v_ds_cel3),
        "ic_whatsapp3": (v_ic_whatsapp3),
        "ds_email": (v_ds_email),
        "ds_rg": (v_ds_rg),
        "ds_cpf": (v_ds_cpf),
        "dt_nascimento": (v_dt_nascimento),
        "ds_endereco": (v_ds_endereco),
        "ds_numero": (v_ds_numero),
        "ds_complemento": (v_ds_complemento),
        "ds_bairro": (v_ds_bairro),
        "ds_cep": (v_ds_cep),
        "ds_cidade": (v_ds_cidade),
        "ds_uf": (v_ds_uf),
        "ic_status": (v_ic_status),
        "generos_pk": (v_generos_pk),
        "ic_reserva": (ic_reserva),
        "ic_funcionario": (v_ic_funcionario),
        "produtos_servicos_colaboradores": (v_produtos_servicos_colaboradores),
        "vl_salario": (vl_salario),
        "ds_n_sapato": (ds_n_sapato),
        "ds_n_camisa": (ds_n_camisa),
        "ds_n_calca": (ds_n_calca),
        "ds_n_luva": (v_ds_n_luva),
        

        "ds_raca": $('#ds_raca').val(),
        "ds_deficiencia_fisica": $('#ds_deficiencia_fisica').val(),
        "estado_civil": $('#estado_civil').val(),
        "ds_nome_mae": $('#ds_nome_mae').val(),
        "ds_nome_conjuge": $('#ds_nome_conjuge').val(),
        "ds_nome_pai": $('#ds_nome_pai').val(),
        "dt_nascimento_conjuge": $('#dt_nascimento_conjuge').val(),
        "ds_cpf_conjuge": $('#ds_cpf_conjuge').val(),
        "ds_tel_conjuge": $('#ds_tel_conjuge').val(),
        "regime_casamento": $('#regime_casamento').val(),
        "ds_ctps": $('#ds_ctps').val(),
        "qtde_filho": $('#qtde_filho').val(),
        "ds_serie": $('#ds_serie').val(),
        "dt_expedicao": $('#dt_expedicao').val(),
        "ds_uf_rg": $('#ds_uf_rg').val(),
        "ds_org_exp": $('#ds_org_exp').val(),
        "ds_pis": $('#ds_pis').val(),
        "ds_titulo_eleitoral": $('#ds_titulo_eleitoral').val(),
        "ds_zona_eleitoral": $('#ds_zona_eleitoral').val(),
        "ds_secao": $('#ds_secao').val(),
        "ds_certificado_reservista": $('#ds_certificado_reservista').val(),
        "dt_demissao": $('#dt_demissao').val(),
        "dt_admissao": $('#dt_admissao').val(),
 
        "empresas_pk":$("#empresas_pk").val(),
        "regime_contratacao_pk":$("#regime_contratacao_pk").val(),
        "ds_carga_horaria_semanal":$("#ds_carga_horaria_semanal").val(),

        "tipo_conta_bancaria":$("#tipo_conta_bancaria").val(),
        "ds_agencia":$("#ds_agencia").val(),
        "ds_conta":$("#ds_conta").val(),
        "ds_digito":$("#ds_digito").val(),
        "bancos_pk":$("#bancos_pk").val(),
        "ds_pix":$("#ds_pix").val(),
        "ds_conta_favorecido":$("#ds_conta_favorecido").val(),


        "ic_filho_menor_14": ic_filho_menor_14,
        "ic_registrar_ponto":ic_registrar_ponto,
        "ds_re":ds_re,
        "ds_nacionalidade":ds_nacionalidade,
        "ds_matricula":ds_matricula,
        "grau_escolaridade_pk":grau_escolaridade_pk,
        "colaborador_beneficios":strJsonBeneficios,
        "colaborador_nome_filho":strJSONDadosTabelaNomeFilho,
        "colaborador_afastamento":strJSONDadosTabelaAfastamento,
        "colaboradores_curso":strJsonCurso,
        "colaborador_escala": strJSONDadosTabelaEscala,

        //Novos Campos - Alt Douglas 08/05/23
        "ic_tipo_sanguineo":$("#ic_tipo_sanguineo").val(),
        "ds_cartao_sus":$("#ds_cartao_sus").val(),
        "ic_tipo_sanguineo_conjuge":$("#ic_tipo_sanguineo_conjuge").val(),
        "ic_ds_cartao_sus_conjuge":$("#ds_cartao_sus_conjuge").val(),

        //Novo Campo - Alt João 20/06/23
        "ic_experiencia":$("#ic_experiencia").val(),
        
    };
    
    var arrEnviar = carregarController("colaborador", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        // Reload datable
        if(colaborador_pk==""){
            fcEnviarDocumento(arrEnviar.data['0']['pk']);
            
            colaborador_pk = arrEnviar.data['0']['pk'];
        }
        
        alert(arrEnviar.message);
        sendPost("colaborador_res_form.php", {token: token});
        /*var resultado = confirm("Deseja cadastrar uma escala para esse Colaborador ?");
        
        if (resultado == true){
           
            sendPost("colaborador_res_form.php", {token: token,leads_pk:"",colaborador_pk:colaborador_pk,pk:""});
        }else{            
            sendPost("colaborador_res_form.php", {token: token});
        }*/
        
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcFormatarDadosMateriais(){
    try{
        var movimentacao_estoquePk = "";
        var categorias_produto_pk = "";
        var produtos_pk =  "";
        var produtos_itens_pk = "";
        var dt_entrega= "";
        var dt_devolucao = "";
        var obs_material = "";

        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "movimentacao_estoque_pk";
        arrKeys[1] = "categorias_produto_pk";
        arrKeys[2] = "produtos_pk";
        arrKeys[3] = "produtos_itens_pk";
        arrKeys[4] = "dt_entrega";
        arrKeys[5] = "dt_devolucao";
        arrKeys[6] = "obs_material";

        var  data = tblMaterial.rows().data();

        for(i = 0; i< data.length; i++){
            movimentacao_estoquePk = data[i]['pk'];
            categorias_produto_pk = data[i]['categorias_produto_pk'];
            produtos_pk =  data[i]['produtos_pk'];
            produtos_itens_pk = data[i]['produtos_itens_pk'];
            dt_entrega = data[i]['dt_entrega'];
            dt_devolucao = data[i]['dt_devolucao'];
            obs_material = data[i]['obs_material'];
            arrDados[i] = [movimentacao_estoquePk, categorias_produto_pk, produtos_pk, produtos_itens_pk, dt_entrega, dt_devolucao, obs_material];
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch(err) {
        alert(err);
    }
}

function fcFormatarDadosBeneficio(){

    var beneficios_pk = $("select[id='beneficios_pk']");
    var vl_beneficio = $("input[id='vl_beneficio']");
    var obs = $("input[id='obs']");

    var arrKeys = [];
    arrKeys[0] = "beneficios_pk";
    arrKeys[1] = "vl_beneficio";
    arrKeys[2] = "obs";

    var arrDados = [];


    for(i = 0; i < beneficios_pk.length; i++){
        if(beneficios_pk.get(i).value == ""){
            beneficios_pk.get(i).focus();
            return false;

        }

        arrDados[i] = [beneficios_pk.get(i).value, moeda2float(vl_beneficio.get(i).value), obs.get(i).value];

    }

    return arrayToJson(arrKeys, arrDados);

}

function fcCancelar(){
    sendPost("colaborador_res_form.php", {token: token});
}

function fcCarregar(){
    
    if(colaborador_pk > 0){
        
        var objParametros = {
            "pk": colaborador_pk
        };
        var arrCarregar = carregarController("colaborador", "listarPk", objParametros);
        //NewWindow(v_last_url)
        if (arrCarregar.result == 'success'){
            if(arrCarregar.data[0]['ds_pin']!=null){
                $("#ds_pin").html("<h6>Pin: " + arrCarregar.data[0]['ds_pin']+"</h6>");
            }
            else{
                $("#ds_pin").html("");
            }

            $("#ds_colaborador").val(arrCarregar.data[0]['ds_colaborador']);
            $("#ds_cel").val(arrCarregar.data[0]['ds_cel']);
            $("#ic_whatsapp").val(arrCarregar.data[0]['ic_whatsapp']);
            $("#ds_cel2").val(arrCarregar.data[0]['ds_cel2']);
            $("#ic_whatsapp2").val(arrCarregar.data[0]['ic_whatsapp2']);
            $("#ds_cel3").val(arrCarregar.data[0]['ds_cel3']);
            $("#ic_whatsapp3").val(arrCarregar.data[0]['ic_whatsapp3']);
            $("#ds_email").val(arrCarregar.data[0]['ds_email']);
            $("#ds_rg").val(arrCarregar.data[0]['ds_rg']);
            $("#ds_cpf").val(arrCarregar.data[0]['ds_cpf']);
            $("#dt_nascimento").val(arrCarregar.data[0]['dt_nascimento']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
            $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#generos_pk").val(arrCarregar.data[0]['generos_pk']);
            $("#ic_funcionario").val(arrCarregar.data[0]['ic_funcionario']);
            $("#ds_re").val(arrCarregar.data[0]['ds_re']);
            $("#ds_raca").val(arrCarregar.data[0]['ds_raca']);
            $("#ds_deficiencia_fisica").val(arrCarregar.data[0]['ds_deficiencia_fisica']);
            $("#estado_civil").val(arrCarregar.data[0]['estado_civil']);
            $("#ds_nome_pai").val(arrCarregar.data[0]['ds_nome_pai']);
            $("#ds_nome_mae").val(arrCarregar.data[0]['ds_nome_mae']);
            $("#ds_nome_conjuge").val(arrCarregar.data[0]['ds_nome_conjuge']);
            $("#dt_nascimento_conjuge").val(arrCarregar.data[0]['dt_nascimento_conjuge']);
            $("#ds_cpf_conjuge").val(arrCarregar.data[0]['ds_cpf_conjuge']);
            $("#ds_tel_conjuge").val(arrCarregar.data[0]['ds_tel_conjuge']);
            $("#regime_casamento").val(arrCarregar.data[0]['regime_casamento']);
            $("#ds_ctps").val(arrCarregar.data[0]['ds_ctps']);
            $("#ds_serie").val(arrCarregar.data[0]['ds_serie']);
            $("#dt_expedicao").val(arrCarregar.data[0]['dt_expedicao']);
            $("#ds_uf_rg").val(arrCarregar.data[0]['ds_uf_rg']);
            $("#ds_org_exp").val(arrCarregar.data[0]['ds_org_exp']);
            $("#ds_pis").val(arrCarregar.data[0]['ds_pis']);
            $("#ds_titulo_eleitoral").val(arrCarregar.data[0]['ds_titulo_eleitoral']);
            $("#ds_zona_eleitoral").val(arrCarregar.data[0]['ds_zona_eleitoral']);
            $("#ds_secao").val(arrCarregar.data[0]['ds_secao']);
            $("#ds_certificado_reservista").val(arrCarregar.data[0]['ds_certificado_reservista']);
            $("#ds_nacionalidade").val(arrCarregar.data[0]['ds_nacionalidade']);
            $("#ds_matricula").val(arrCarregar.data[0]['ds_matricula']);
            $("#grau_escolaridade_pk").val(arrCarregar.data[0]['grau_escolaridade_pk']);
            $("#dt_demissao").val(arrCarregar.data[0]['dt_demissao']);
            $("#dt_admissao").val(arrCarregar.data[0]['dt_admissao']);

            $("#empresas_pk").val(arrCarregar.data[0]['empresas_pk']);
            $("#regime_contratacao_pk").val(arrCarregar.data[0]['regime_contratacao_pk']);
            $("#ds_carga_horaria_semanal").val(arrCarregar.data[0]['ds_carga_horaria_semanal']);
            
            $("#ds_n_sapato").val(arrCarregar.data[0]['ds_n_sapato']);
            $("#ds_n_camisa").val(arrCarregar.data[0]['ds_n_camisa']);
            $("#ds_n_calca").val(arrCarregar.data[0]['ds_n_calca']);
            $("#ds_n_luva").val(arrCarregar.data[0]['ds_n_luva']);
            
            $("#tipo_conta_bancaria").val(arrCarregar.data[0]['tipo_conta_bancaria']);
            $("#ds_agencia").val(arrCarregar.data[0]['ds_agencia']);
            $("#ds_conta").val(arrCarregar.data[0]['ds_conta']);
            $("#ds_digito").val(arrCarregar.data[0]['ds_digito']);
            $("#bancos_pk").val(arrCarregar.data[0]['bancos_pk']);
            $("#vl_salario").val(float2moeda(arrCarregar.data[0]['vl_salario']));
            $("#ds_pix").val(arrCarregar.data[0]['ds_pix'])
            $("#ds_conta_favorecido").val(arrCarregar.data[0]['ds_conta_favorecido'])

            $("#ic_tipo_sanguineo").val(arrCarregar.data[0]['ic_tipo_sanguineo'])
            $("#ds_cartao_sus").val(arrCarregar.data[0]['ds_cartao_sus'])
            $("#ic_tipo_sanguineo_conjuge").val(arrCarregar.data[0]['ic_tipo_sanguineo_conjuge'])
            $("#ds_cartao_sus_conjuge").val(arrCarregar.data[0]['ic_ds_cartao_sus_conjuge'])
            $("#ic_experiencia").val(arrCarregar.data[0]['ic_experiencia'])
                     

            if(arrCarregar.data[0]['ds_imagem']!=null){
                
                var link = arrCarregar.data[0]['ds_imagem'];
                var linkDesescapado = link.replaceAll('\\/', '/');
                
                $("#ds_imagem").html("<img width=100 height=120 src='" + linkDesescapado + "'>");
            }else{
               $("#ds_imagem").html("<img width=100 height=120 src='http://democondominio.gepros6.com.br/img/usuario_sem_imagem.png'>");
            }

            $("#dt_liberado").html(arrCarregar.data[0]['dt_liberado']);

            if(arrCarregar.data[0]['ds_status_app']!= null){
                $("#ds_status_app").html("Status liberação acesso App Ponto :<b>"+arrCarregar.data[0]['ds_status_app']+"</b>");
            }else{

                $("#ds_status_app").html("Status liberação acesso App Ponto: <b>Não solicitado</b>");
            }

            if(arrCarregar.data[0]['ds_status_app']=='Liberado'){
                $("#dt_liberacao").html("Data da Liberação acesso App Ponto <b>"+arrCarregar.data[0]['dt_liberacao']+"</b>");
            }


            if(arrCarregar.data[0]['ic_filho_menor_14']==1){
                              
			                    $("#exibir_qtde_filho").show();
			                    $("input[id=ic_filho_menor_14]").prop("checked", "true");
			                    $("#qtde_filho").val(arrCarregar.data[0]['qtde_filho']);
			                    $("#exibir_nome_filho").show();
			                    setTimeout(function(){
			                        //tblNomeFilho.clear().destroy();
			                        //fcFormatarGridNomeFilho();
			                        fcAtualizarDadosGridNomeFilho();
			                    }, 500);
            }
            if(arrCarregar.data[0]['ic_reserva']==1){
                    $("input[id=ic_reserva]").prop("checked", "true");
            }



            
        }
        else{
            alert('Falhar ao carregar o registro');
        }

    }
}

function fcCarregarTurno(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("turno", "listarTodos", objParametros);

    carregarComboAjax($("#dom_turnos_pk"), arrCarregar, " ", "pk", "ds_turno");
    carregarComboAjax($("#seg_turnos_pk"), arrCarregar, " ", "pk", "ds_turno");
    carregarComboAjax($("#ter_turnos_pk"), arrCarregar, " ", "pk", "ds_turno");
    carregarComboAjax($("#qua_turnos_pk"), arrCarregar, " ", "pk", "ds_turno");
    carregarComboAjax($("#qui_turnos_pk"), arrCarregar, " ", "pk", "ds_turno");
    carregarComboAjax($("#sex_turnos_pk"), arrCarregar, " ", "pk", "ds_turno");
    carregarComboAjax($("#sab_turnos_pk"), arrCarregar, " ", "pk", "ds_turno");

}

function fcLimparPonto(){

    $("#ic_registrar_ponto").prop("checked", false);
    $("#ic_dom").prop("checked", false);
    $("#ic_seg").prop("checked", false);
    $("#ic_ter").prop("checked", false);
    $("#ic_qua").prop("checked", false);
    $("#ic_qui").prop("checked", false);
    $("#ic_sex").prop("checked", false);
    $("#ic_sab").prop("checked", false);

    $("#colaborador_ponto_pk").val("");
    $("#dom_turnos_pk").val("");
    $("#seg_turnos_pk").val("");
    $("#ter_turnos_pk").val("");
    $("#qua_turnos_pk").val("");
    $("#qui_turnos_pk").val("");
    $("#sex_turnos_pk").val("");
    $("#sab_turnos_pk").val("");
    $("#hr_entrada_dom").val("");
    $("#hr_saida_dom").val("");
    $("#hr_entrada_seg").val("");
    $("#hr_saida_seg").val("");
    $("#hr_entrada_ter").val("");
    $("#hr_saida_ter").val("");
    $("#hr_entrada_qua").val("");
    $("#hr_saida_qua").val("");
    $("#hr_entrada_qui").val("");
    $("#hr_saida_qui").val("");
    $("#hr_entrada_sex").val("");
    $("#hr_saida_sex").val("");
    $("#hr_entrada_sab").val("");
    $("#hr_saida_sab").val("");

}

function fcCarregarGenero(){
    //Carrega os grupos

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("genero", "listarTodos", objParametros);
    
    carregarComboAjax($("#generos_pk"), arrCarregar, " ", "pk", "ds_genero");

}


//COMEÇO DOCUMENTOS UPLOAD

function fcAlterarNomeArquivo(v_arquivo){
        var objParametros = {
            "colaboradores_pk": colaborador_pk,
            "ds_arquivo": v_arquivo
        };


        var arrEnviar = carregarController("documento", "renomearArquivoColaborador", objParametros);

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

                $("#ds_nome_original").text(file.name);

                fcAlterarNomeArquivo(file.name);
                fcIncluirLinhaArquivo(file.name);



            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width', progress + '%');
        }
    });
});

function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}

function fcFormatarDadosArquivos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() != "Nenhum registro encontrado"){
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


}

function fcLimparDadosDocumento(){
    $("#ds_obs_doc").val("");
    $("#acao").val("");
}
function fcAbrirFormNovoDocumento(){
    tblArquivos.clear().destroy();
    fcCarregarGridArquivos();
    fcLimparDadosDocumento();
    $("#acao").val("ins");
    $("#janela_documentos").modal();

}



function fcVerificarCNPJ(){
    var ds_cpf_cnpj = $("#ds_cpf").val();
    if(ds_cpf_cnpj.length == 14){
         var objParametros = {
            "ds_cpf": $("#ds_cpf").val()
        };

        var arrCarregar = carregarController("colaborador", "verificarCPF", objParametros);

        if (arrCarregar.result == 'success'){

            if(arrCarregar.data.length > 0){
                alert("Já existe um Colaborador com esse CPF");
                $("#ds_colaborador").val("");
                $("#generos_pk").val("");
                $("#ds_cel").val("");
                $("#ds_cel2").val("");
                $("#dt_nascimento").val("");
                $("#ds_cel3").val("");
                $("#ds_rg").val("");
                $("#ds_cpf").val("");
                $("#ic_whatsapp").val("");
                $("#ds_email").val("");

            }


        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }


}


//--------------------------------------------------------------NOME FILHO-----------------------------------------------------
function fcFormatarGridNomeFilho(){
    tblNomeFilho = $("#tblNomeFilho").DataTable(
        {
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2,3,4]
            }],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        }
    );
    return false;

}

function fcAtualizarDadosGridNomeFilho(){
    
    var objParametros = {
        "colaborador_pk":colaborador_pk,
        "token": token
    };
    
    var arrCarregar = carregarController("colaborador_nome_filho", "listarNomeFilhoColaboradorPk", objParametros);
   
    if (arrCarregar.result == 'success'){
        if(arrCarregar.data.length>0){
            for(i = 0; i < arrCarregar.data.length; i++){

            //Adiciona a linha.
                fcIncluirNomeFilho();

                //Pega as variaveis
                var ds_nome_filho = $("input[id='ds_nome_filho']");
                var ds_cpf_filho = $("input[id='ds_cpf_filho']");
                var dt_nascimento_filho = $("input[id='dt_nascimento_filho']");
                var ds_tipo_sanguineo_dependente = $("input[id='ds_tipo_sanguineo_dependente']");
                var ds_num_cartao_sus_dependente = $("input[id='ds_num_cartao_sus_dependente']");


                ds_nome_filho.get(i).value = arrCarregar.data[i]['ds_nome_filho'];
                ds_cpf_filho.get(i).value = arrCarregar.data[i]['ds_cpf_filho'];
                dt_nascimento_filho.get(i).value = arrCarregar.data[i]['dt_nascimento_filho'];
                ds_tipo_sanguineo_dependente.get(i).value = arrCarregar.data[i]['ds_tipo_sanguineo_dependente'];
                ds_num_cartao_sus_dependente.get(i).value = arrCarregar.data[i]['ds_num_cartao_sus_dependente'];

            }
        }
        
    }
    else{

        alert('Falhar ao carregar o registro');
    }

}


function fcIncluirNomeFilho(){

    tblNomeFilho.row.add(
            ["<input type='text' class='form-control form-control-sm' onchange='' id='ds_nome_filho' />",
             "<input type='text' class='form-control form-control-sm' onkeypress='chama_mascara(this);' maxlength='14' id='ds_cpf_filho' />",
             "<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,mdata);' maxlength='10' id='dt_nascimento_filho' />",
             "<input type='text' class='form-control form-control-sm' maxlength='10' id='ds_tipo_sanguineo_dependente' />",
             "<input type='text' class='form-control form-control-sm' maxlength='25' id='ds_num_cartao_sus_dependente' />"
            ]
    ).draw( false );



    return false;
}

function fcFormatarDadosNomeFilho(){

    var ds_nome_filho = $("input[id='ds_nome_filho']");
    var ds_cpf_filho = $("input[id='ds_cpf_filho']");
    var dt_nascimento_filho = $("input[id='dt_nascimento_filho']");
    var ds_tipo_sanguineo_dependente = $("input[id='ds_tipo_sanguineo_dependente']");
    var ds_num_cartao_sus_dependente = $("input[id='ds_num_cartao_sus_dependente']");

    var arrKeys = [];
    arrKeys[0] = "ds_nome_filho";
    arrKeys[1] = "ds_cpf_filho";
    arrKeys[2] = "dt_nascimento_filho";
    arrKeys[3] = "ds_tipo_sanguineo_dependente";
    arrKeys[4] = "ds_num_cartao_sus_dependente";

    var arrDados = [];

    var alert = 0;
    var  data = tblNomeFilho.rows().data();
    if(data.length >0){
        for(i = 0; i < data.length; i++){
            if(ds_nome_filho.get(i).value==""){
                alert = 1;
            }
            else if(ds_cpf_filho.get(i).value==""){
                alert = 1;
            }
            else if(dt_nascimento_filho.get(i).value==""){
                alert = 1;
            }

            arrDados[i] = [ds_nome_filho.get(i).value, ds_cpf_filho.get(i).value, dt_nascimento_filho.get(i).value, ds_tipo_sanguineo_dependente.get(i).value, ds_num_cartao_sus_dependente.get(i).value];

        }
    }
    if(alert >= 1){
        return 0;
    }
    else{
        return arrayToJson(arrKeys, arrDados);
    }


}

function fcCarregarEmpresa(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("conta", "listarPk", objParametros);
    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_conta");

}
function fcCarregarBancos(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("banco", "listarTodos", objParametros);
    carregarComboAjax($("#bancos_pk"), arrCarregar, " ", "pk", "ds_banco");

}

function fcValidarDemissao(){ 
  
    var ic_status = $("#ic_status").val();
    var dt_demissao = $("#dt_demissao").val();
    if(ic_status == 2){

        if(dt_demissao == ""){

            $("#alert_dt_demissao").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_dt_demissao").slideUp(500);
            });
            $('#dt_demissao').focus();
            return false;
        }

        if(ic_status != "" && dt_demissao != ""){

            objParametros = {
                "colaborador_pk": colaborador_pk,
                "dt_demissao": dt_demissao
            }
        
            carregarController("agenda_colaborador_padrao", "cancelarEscalasDemissao", objParametros);
            
            //NewWindow(v_last_url);
        }

    }

        fcEnviar();


}


$(document).ready(function()
    {
        leads_pk = "";
       
        var arrCarregar = permissao("colaborador", "ins");

        if (arrCarregar.result != 'success'){
            alert('Falhar ao carregar o registro');
            return false;
        }
      
        //fcLimparPonto();
       // fcCarregarTurno();
       
        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
       
        
        $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);
        $(document).on('click', '#cmdCancelarDocumento', fcCancelarEnvioDocumento);
        
        
        $(document).on('click', '#cmdEnviarColaborador', fcValidarFormColaborador);
        //$(document).on('click', '#cmdEnviarColaborador', fcValidarFormColaborador);
        
        
        $('#dt_nascimento').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        });
        $('#dt_nascimento_conjuge').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        });
        $('#dt_expedicao').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        });
        $('#dt_admissao').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        });
        $('#dt_demissao').datepicker({defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        });

        $("#ds_agencia").keypress(function(){
           mascara(this,soNumeros);
        });
        $("#ds_conta").keypress(function(){
           mascara(this,soNumeros);
        });
        $("#ds_agencia").keypress(function(){
           mascara(this,soNumeros);
        });

        $("#vl_salario").keypress(function(){
            mascara(this,moeda);
        });

        $("#dt_admissao").keypress(function(){
           mascara(this,mdata);
        });
        $("#dt_demissao").keypress(function(){
           mascara(this,mdata);
        });
        $("#dt_nascimento").keypress(function(){
           mascara(this,mdata);
        });
        $("#dt_nascimento_conjuge").keypress(function(){
           mascara(this,mdata);
        });
        $("#dt_expedicao").keypress(function(){
           mascara(this,mdata);
        });
        $("#ds_cep").keypress(function(){
           mascara(this,cep);
        });
        $("#ds_cpf").keypress(function(){
           chama_mascara(this);
        });
        $("#ds_cpf_conjuge").keypress(function(){
           chama_mascara(this);
        });
        $("#ds_cel").keypress(function(){
           mascara(this,mascaraTelefone);
        });
        $("#ds_tel_conjuge").keypress(function(){
           mascara(this,mascaraTelefone);
        });
        $("#ds_cel2").keypress(function(){
           mascara(this,mascaraTelefone);
        });
        $("#ds_cel3").keypress(function(){
           mascara(this,mascaraTelefone);
        });

        $("#ds_cep").change(function(){
            fcCarregarCep($("#ds_cep").val());
        });

       

        
        $("#exibir_qtde_filho").hide();
        $("#exibir_nome_filho").hide();
        fcFormatarGridNomeFilho();
        
        //fcAtualizarDadosGridNomeFilho();
        
        $("#ic_filho_menor_14").change(function(){
            if($('#ic_filho_menor_14').is(":checked")){
                $("#exibir_qtde_filho").show();
            }
            else{
                $("#exibir_qtde_filho").hide();
                $("#qtde_filho").val("");
                $("#exibir_nome_filho").hide();
            }
        });

        $("#qtde_filho").change(function(){
            if($('#qtde_filho').val()!=""){
                tblNomeFilho.clear().destroy();
                fcFormatarGridNomeFilho();
                //fcAtualizarDadosGridNomeFilho();
                $("#exibir_nome_filho").show();

                for(i=0;i<$('#qtde_filho').val();i++){
                    fcIncluirNomeFilho();
                }

            }
            else{
                tblNomeFilho.clear().destroy();
                fcFormatarGridNomeFilho();
                //fcAtualizarDadosGridNomeFilho();
                $("#exibir_nome_filho").hide();
            }
        });

        ///------------------GRID----------------------------


        /*$("#ds_carga_horaria_semanal").keypress(function(){
            mascara(this,horamasksemanal);
        });*/
       
         //----------------------FINAL GRID------------------




        $("#hr_entrada_dom").keypress(function(){
            mascara(this,horamask);
         });
        $("#hr_saida_dom").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_entrada_seg").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_saida_seg").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_entrada_ter").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_saida_ter").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_entrada_qua").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_saida_qua").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_entrada_qui").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_saida_qui").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_entrada_sex").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_saida_sex").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_entrada_sab").keypress(function(){
            mascara(this,horamask);
         });
         $("#hr_saida_sab").keypress(function(){
            mascara(this,horamask);
         });
        
        if(colaborador_pk!=""){
            $("#exibir_materiais").show();
            $("#exibir_afastamento").show(); 
            
        };
        
        //Atribui a validação do formulário dos campos obrigatórios
        //fcValidarFormColaborador();
        
        fcCarregarGenero();
        
        fcCarregarEmpresa();
        
        fcCarregarBancos();
       

        
        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
        

    }
);

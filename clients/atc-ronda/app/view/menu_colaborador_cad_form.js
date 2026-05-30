var tblQualificacao;
var strComboProdutoServico = "";
var tblDocumentos;
function fcValidarForm(){

    $("#form").validate({
        ignore: "",
        rules :{
            ds_colaborador:{
                required:true,
                minlength:3
            },
            generos_pk:{
                required:true
            },
            ds_cel:{
                required:true,
                minlength:13
            },
            ds_cel2:{
                minlength:13
            },
            dt_nascimento:{
                required:true,
                minlength:10
            },
            ds_cel3:{
                minlength:13
            },
            ds_rg:{
                required:true,
                minlength:9
            },
            ds_cpf:{
                required:true,
                minlength:14
            },
            ic_whatsapp:{
                required:true
            },
            ic_status:{
                required:true
            },
            ds_email:{
                email: true
            }
        },
        messages:{
            ds_colaborador:{
                required:"Por favor, informe Colaborador",
                minlength:"Colaborador deve ter pelo menos 3 caracteres"
            },
            generos_pk:{
                required:"Por favor, informe Gênero"
            },
            ds_cel:{
                required:"Por favor, informe Celular",
                minlength:"Por favor, informe Celular válido"
            },
            dt_nascimento:{
                required:"Por favor, informe Data Nascimento",
                minlength:"Por favor, informe Data Nascimento válido"
            },
            ds_cpf:{
                required:"Por favor, informe CPF",
                minlength:"Por favor, informe CPF válido"
            },
            ds_rg:{
                required:"Por favor, informe RG/RE",
                minlength:"Por favor, informe Rg válido"
            },
            ds_cel2:{
                minlength:"Por favor, informe Celular válido"
            },
            ds_cel3:{
                minlength:"Por favor, informe Celular válido"
            },
            ic_whatsapp:{
                required:"Por favor, informe WhatsApp"
            },
            ic_status:{
                required:"Por favor, informe Status"
            },
            ds_email:{
                email:"Por favor, informe um Email válido"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}

function validarGridControlePonto(){
    if($('#ic_dom').is(":checked") && $('#dom_turnos_pk').val()==""){
        return false;
    }
    else if($('#ic_seg').is(":checked") && $('#seg_turnos_pk').val()==""){
        return false;
    }
    else if($('#ic_ter').is(":checked") && $('#ter_turnos_pk').val()==""){
        return false;
    }
    else if($('#ic_qua').is(":checked") && $('#qua_turnos_pk').val()==""){
        return false;
    }
    else if($('#ic_qui').is(":checked") && $('#qui_turnos_pk').val()==""){
        return false;
    }
    else if($('#ic_sex').is(":checked") && $('#sex_turnos_pk').val()==""){
        return false;
    }
    else if($('#ic_sab').is(":checked") && $('#sab_turnos_pk').val()==""){

        return false;
    }
    return true;
}
function fcEnviar(){
    if(!validarGridControlePonto()){
        $("#alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert").slideUp(500);
        });
        return false;
    }
    var strJSONDadosTabela = fcFormatarDadosQualificacao();
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

    //Materiais
    //var strJSONDadosMateriais = fcFormatarDadosMateriais();

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
    var vl_salario = $("#vl_salario").val();

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

    //DOM
    if($('#ic_dom').is(":checked")){
        ic_dom = 1;
    }
    else{
        ic_dom = 2;
    }
    //SEG
    if($('#ic_seg').is(":checked")){
        ic_seg = 1;
    }
    else{
        ic_seg = 2;
    }
    //TER
    if($('#ic_ter').is(":checked")){
        ic_ter = 1;
    }
    else{
        ic_ter = 2;
    }
    //QUA
    if($('#ic_qua').is(":checked")){
        ic_qua = 1;
    }
    else{
        ic_qua = 2;
    }
    //QUI
    if($('#ic_qui').is(":checked")){
        ic_qui = 1;
    }
    else{
        ic_qui = 2;
    }
    //SEX
    if($('#ic_sex').is(":checked")){
        ic_sex = 1;

    }
    else{
        ic_sex = 2;
    }
    //SAB
    if($('#ic_sab').is(":checked")){
        ic_sab = 1;
    }
    else{
        ic_sab = 2;
    }
    var ic_filho_menor_14 = "";
    if($('#ic_filho_menor_14').is(":checked")){
            ic_filho_menor_14 = 1;
    }
    var ic_reserva = "";
    if($('#ic_reserva').is(":checked")){
            ic_reserva = 1;
    }


    var objParametros = {
        "pk": pk,
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
        "vl_salario": moeda2float(vl_salario),
        //"materiais_lead": (strJSONDadosMateriais),
        "ic_dom": ic_dom,
        "ic_seg": ic_seg,
        "ic_ter": ic_ter,
        "ic_qua": ic_qua,
        "ic_qui": ic_qui,
        "ic_sex": ic_sex,
        "ic_sab": ic_sab,
        "hr_entrada_dom":$("#hr_entrada_dom").val(),
        "colaborador_ponto_pk":$("#colaborador_ponto_pk").val(),
        "hr_saida_dom":$("#hr_saida_dom").val(),
        "hr_entrada_seg":$("#hr_entrada_seg").val(),
        "hr_saida_seg":$("#hr_saida_seg").val(),
        "hr_entrada_ter":$("#hr_entrada_ter").val(),
        "hr_saida_ter":$("#hr_saida_ter").val(),
        "hr_entrada_qua":$("#hr_entrada_qua").val(),
        "hr_saida_qua":$("#hr_saida_qua").val(),
        "hr_entrada_qui":$("#hr_entrada_qui").val(),
        "hr_saida_qui":$("#hr_saida_qui").val(),
        "hr_entrada_sex":$("#hr_entrada_sex").val(),
        "hr_saida_sex":$("#hr_saida_sex").val(),
        "hr_entrada_sab":$("#hr_entrada_sab").val(),
        "hr_saida_sab":$("#hr_saida_sab").val(),
        "turnos_pk_dom": $('#dom_turnos_pk').val(),
        "turnos_pk_seg": $('#seg_turnos_pk').val(),
        "turnos_pk_ter": $('#ter_turnos_pk').val(),
        "turnos_pk_qua": $('#qua_turnos_pk').val(),
        "turnos_pk_qui": $('#qui_turnos_pk').val(),
        "turnos_pk_sex": $('#sex_turnos_pk').val(),
        "turnos_pk_sab": $('#sab_turnos_pk').val(),
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

        "ds_entrada_dom":$("#ds_entrada_dom").val(),
        "ds_ida_intervalo_dom":$("#ds_ida_intervalo_dom").val(),
        "ds_volta_intervalo_dom":$("#ds_volta_intervalo_dom").val(),
        "ds_saida_dom":$("#ds_saida_dom").val(),

        "ds_entrada_seg":$("#ds_entrada_seg").val(),
        "ds_ida_intervalo_seg":$("#ds_ida_intervalo_seg").val(),
        "ds_volta_intervalo_seg":$("#ds_volta_intervalo_seg").val(),
        "ds_saida_seg":$("#ds_saida_seg").val(),

        "ds_entrada_ter":$("#ds_entrada_ter").val(),
        "ds_ida_intervalo_ter":$("#ds_ida_intervalo_ter").val(),
        "ds_volta_intervalo_ter":$("#ds_volta_intervalo_ter").val(),
        "ds_saida_ter":$("#ds_saida_ter").val(),

        "ds_entrada_qua":$("#ds_entrada_qua").val(),
        "ds_ida_intervalo_qua":$("#ds_ida_intervalo_qua").val(),
        "ds_volta_intervalo_qua":$("#ds_volta_intervalo_qua").val(),
        "ds_saida_qua":$("#ds_saida_qua").val(),

        "ds_entrada_qui":$("#ds_entrada_qui").val(),
        "ds_ida_intervalo_qui":$("#ds_ida_intervalo_qui").val(),
        "ds_volta_intervalo_qui":$("#ds_volta_intervalo_qui").val(),
        "ds_saida_qui":$("#ds_saida_qui").val(),

        "ds_entrada_sex":$("#ds_entrada_sex").val(),
        "ds_ida_intervalo_sex":$("#ds_ida_intervalo_sex").val(),
        "ds_volta_intervalo_sex":$("#ds_volta_intervalo_sex").val(),
        "ds_saida_sex":$("#ds_saida_sex").val(),

        "ds_entrada_sab":$("#ds_entrada_sab").val(),
        "ds_ida_intervalo_sab":$("#ds_ida_intervalo_sab").val(),
        "ds_volta_intervalo_sab":$("#ds_volta_intervalo_sab").val(),
        "ds_saida_sab":$("#ds_saida_sab").val(),
        "tipo_conta_bancaria":$("#tipo_conta_bancaria").val(),
        "ds_agencia":$("#ds_agencia").val(),
        "ds_conta":$("#ds_conta").val(),
        "ds_digito":$("#ds_digito").val(),
        "bancos_pk":$("#bancos_pk").val(),



        "ic_filho_menor_14": ic_filho_menor_14,
        "ic_registrar_ponto":ic_registrar_ponto,
        "ds_re":ds_re,
        "ds_nacionalidade":ds_nacionalidade,
        "ds_matricula":ds_matricula,
        "grau_escolaridade_pk":grau_escolaridade_pk,
        "colaborador_beneficios":strJsonBeneficios,
        "colaborador_nome_filho":strJSONDadosTabelaNomeFilho,
        "colaborador_afastamento":strJSONDadosTabelaAfastamento,
        "colaboradores_curso":strJsonCurso

    };

    var arrEnviar = carregarController("colaborador", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        // Reload datable
        if(pk==""){
            fcEnviarDocumento(arrEnviar.data['0']['pk']);
        }
        alert(arrEnviar.message);
        sendPost("colaborador_res_form.php", {token: token});
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



function fcCancelar(){
    sendPost("colaborador_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };

        var arrCarregar = carregarController("colaborador", "listarPk", objParametros);

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

            $("#ds_entrada_dom").val(arrCarregar.data[0]['ds_entrada_dom']);
            $("#ds_ida_intervalo_dom").val(arrCarregar.data[0]['ds_ida_intervalo_dom']);
            $("#ds_volta_intervalo_dom").val(arrCarregar.data[0]['ds_volta_intervalo_dom']);
            $("#ds_saida_dom").val(arrCarregar.data[0]['ds_saida_dom']);

            $("#ds_entrada_seg").val(arrCarregar.data[0]['ds_entrada_seg']);
            $("#ds_ida_intervalo_seg").val(arrCarregar.data[0]['ds_ida_intervalo_seg']);
            $("#ds_volta_intervalo_seg").val(arrCarregar.data[0]['ds_volta_intervalo_seg']);
            $("#ds_saida_seg").val(arrCarregar.data[0]['ds_saida_seg']);

            $("#ds_entrada_ter").val(arrCarregar.data[0]['ds_entrada_ter']);
            $("#ds_ida_intervalo_ter").val(arrCarregar.data[0]['ds_ida_intervalo_ter']);
            $("#ds_volta_intervalo_ter").val(arrCarregar.data[0]['ds_volta_intervalo_ter']);
            $("#ds_saida_ter").val(arrCarregar.data[0]['ds_saida_ter']);

            $("#ds_entrada_qua").val(arrCarregar.data[0]['ds_entrada_qua']);
            $("#ds_ida_intervalo_qua").val(arrCarregar.data[0]['ds_ida_intervalo_qua']);
            $("#ds_volta_intervalo_qua").val(arrCarregar.data[0]['ds_volta_intervalo_qua']);
            $("#ds_saida_qua").val(arrCarregar.data[0]['ds_saida_qua']);

            $("#ds_entrada_qui").val(arrCarregar.data[0]['ds_entrada_qui']);
            $("#ds_ida_intervalo_qui").val(arrCarregar.data[0]['ds_ida_intervalo_qui']);
            $("#ds_volta_intervalo_qui").val(arrCarregar.data[0]['ds_volta_intervalo_qui']);
            $("#ds_saida_qui").val(arrCarregar.data[0]['ds_saida_qui']);

            $("#ds_entrada_sex").val(arrCarregar.data[0]['ds_entrada_sex']);
            $("#ds_ida_intervalo_sex").val(arrCarregar.data[0]['ds_ida_intervalo_sex']);
            $("#ds_volta_intervalo_sex").val(arrCarregar.data[0]['ds_volta_intervalo_sex']);
            $("#ds_saida_sex").val(arrCarregar.data[0]['ds_saida_sex']);

            $("#ds_entrada_sab").val(arrCarregar.data[0]['ds_entrada_sab']);
            $("#ds_ida_intervalo_sab").val(arrCarregar.data[0]['ds_ida_intervalo_sab']);
            $("#ds_volta_intervalo_sab").val(arrCarregar.data[0]['ds_volta_intervalo_sab']);
            $("#ds_saida_sab").val(arrCarregar.data[0]['ds_saida_sab']);
            $("#tipo_conta_bancaria").val(arrCarregar.data[0]['tipo_conta_bancaria']);
            $("#ds_agencia").val(arrCarregar.data[0]['ds_agencia']);
            $("#ds_conta").val(arrCarregar.data[0]['ds_conta']);
            $("#ds_digito").val(arrCarregar.data[0]['ds_digito']);
            $("#bancos_pk").val(arrCarregar.data[0]['bancos_pk']);
            $("#vl_salario").val(float2moeda(arrCarregar.data[0]['vl_salario']));


            if(arrCarregar.data[0]['ds_imagem']!=null){
                $("#ds_imagem").html("<img width=100 height=120 src='"+arrCarregar.data[0]['ds_imagem']+"'>");
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
			                        tblNomeFilho.clear().destroy();
			                        fcFormatarGridNomeFilho();
			                        fcAtualizarDadosGridNomeFilho();
			                    }, 500);
            }
            if(arrCarregar.data[0]['ic_reserva']==1){
                    $("input[id=ic_reserva]").prop("checked", "true");
            }

            if(arrCarregar.data[0]['ic_dom']==1){
                $("input[id=ic_dom]").prop("checked", "true");
           }
           //SEG
           if(arrCarregar.data[0]['ic_seg']==1){
                $("input[id=ic_seg]").prop("checked", "true");
           }
           if(arrCarregar.data[0]['ic_registrar_ponto']==1){
                $("input[id=ic_registrar_ponto]").prop("checked", "true");
           }
           //TER
           if(arrCarregar.data[0]['ic_ter']==1){
                $("input[id=ic_ter]").prop("checked", "true");
           }
           //QUA
           if(arrCarregar.data[0]['ic_qua']==1){
                $("input[id=ic_qua]").prop("checked", "true");
           }
           //QUI
           if(arrCarregar.data[0]['ic_qui']==1){
                $("input[id=ic_qui]").prop("checked", "true");
           }
           //SEX
           if(arrCarregar.data[0]['ic_sex']==1){
                $("input[id=ic_sex]").prop("checked", "true");
           }
           //SAB
           if(arrCarregar.data[0]['ic_sab']==1){
                $("input[id=ic_sab]").prop("checked", "true");
           }

           $("#colaborador_ponto_pk").val(arrCarregar.data[0]['colaborador_ponto_pk']);
           $("#dom_turnos_pk").val(arrCarregar.data[0]['turnos_pk_dom']);
           $("#seg_turnos_pk").val(arrCarregar.data[0]['turnos_pk_seg']);
           $("#ter_turnos_pk").val(arrCarregar.data[0]['turnos_pk_ter']);
           $("#qua_turnos_pk").val(arrCarregar.data[0]['turnos_pk_qua']);
           $("#qui_turnos_pk").val(arrCarregar.data[0]['turnos_pk_qui']);
           $("#sex_turnos_pk").val(arrCarregar.data[0]['turnos_pk_sex']);
           $("#sab_turnos_pk").val(arrCarregar.data[0]['turnos_pk_sab']);

            $("#hr_entrada_dom").val(arrCarregar.data[0]['hr_entrada_dom']);
            $("#hr_entrada_seg").val(arrCarregar.data[0]['hr_entrada_seg']);
            $("#hr_entrada_ter").val(arrCarregar.data[0]['hr_entrada_ter']);
            $("#hr_entrada_qua").val(arrCarregar.data[0]['hr_entrada_qua']);
            $("#hr_entrada_qui").val(arrCarregar.data[0]['hr_entrada_qui']);
            $("#hr_entrada_sex").val(arrCarregar.data[0]['hr_entrada_sex']);
            $("#hr_entrada_sab").val(arrCarregar.data[0]['hr_entrada_sab']);

            $("#hr_saida_dom").val(arrCarregar.data[0]['hr_saida_dom']);
            $("#hr_saida_seg").val(arrCarregar.data[0]['hr_saida_seg']);
            $("#hr_saida_ter").val(arrCarregar.data[0]['hr_saida_ter']);
            $("#hr_saida_qua").val(arrCarregar.data[0]['hr_saida_qua']);
            $("#hr_saida_qui").val(arrCarregar.data[0]['hr_saida_qui']);
            $("#hr_saida_sex").val(arrCarregar.data[0]['hr_saida_sex']);
            $("#hr_saida_sab").val(arrCarregar.data[0]['hr_saida_sab']);

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
        "pk": pk
    };

    var arrCarregar = carregarController("genero", "listarTodos", objParametros);
    carregarComboAjax($("#generos_pk"), arrCarregar, " ", "pk", "ds_genero");

}


function fcFormatarGrid(){
    tblQualificacao = $("#tblQualificacao").DataTable(
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

function carregarListaCombo(){



    var objParametros = {

    };

    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);

    if (arrCarregar.result == 'success'){
        strComboProdutoServico = "<select id='produtos_servicos_pk' disabled name='produtos_servicos_pk'><option></option>";
        for(i = 0; i < arrCarregar.data.length; i++){
            strComboProdutoServico = strComboProdutoServico + "<option value='"+arrCarregar.data[i]['pk']+"'>"+arrCarregar.data[i]['ds_produto_servico']+"</option>";
        }
        strComboProdutoServico += "</select>";
        //Carrega os dados no combo.
        fcFormatarGrid();
        fcAtualizarDadosGrid();
    }
    else{

        alert('Falhar ao carregar o registro');

    }
}


function fcAtualizarDadosGrid(){

    var objParametros = {
        "colaboradores_pk":pk,
        "token": token
    };

    var arrCarregar = carregarController("produto_servico", "listarQualificacaoColaboradores", objParametros);

        if (arrCarregar.result == 'success'){
            for(i = 0; i < arrCarregar.data.length; i++){

                //Adiciona a linha.
                fcIncluirQualificacao();

                //Pega as variaveis
                var cboProdutosServicosPk = $("select[id='produtos_servicos_pk']");
                var chkTreinamento = $("input[id='ic_possui_treinamento']");
                var chkCertificado = $("input[id='ic_possui_certificado']");

                cboProdutosServicosPk.get(i).value = arrCarregar.data[i]['t_produtos_servicos_pk'];

                if(arrCarregar.data[i]['t_ic_possui_treinamento'] == 1)
                    chkTreinamento.get(i).checked = true;
                if(arrCarregar.data[i]['t_ic_possui_certificado'] == 1)
                    chkCertificado.get(i).checked = true;
            }
        }
        else{

            alert('Falhar ao carregar o registro');
        }

}

function fcIncluirQualificacao(){

    tblQualificacao.row.add(
            [strComboProdutoServico,
             "<input type='checkbox' disabled id='ic_possui_treinamento' />",
             "<input type='checkbox' disabled id='ic_possui_certificado' />"
            ]
    ).draw( false );


    return false;
}

function fcFormatarDadosQualificacao(){

    var cboProdutosServicosPk = $("select[id='produtos_servicos_pk']");
    var chkTreinamento = $("input[id='ic_possui_treinamento']");
    var chkCertificado = $("input[id='ic_possui_certificado']");

    var arrKeys = [];
    arrKeys[0] = "produtos_servicos_pk";
    arrKeys[1] = "ic_possui_treinamento";
    arrKeys[2] = "ic_possui_certificado";

    var arrDados = [];

    var v_ic_possui_treinamento = 2;
    var v_ic_possui_certificado = 2;

    for(i = 0; i < cboProdutosServicosPk.length; i++){
        if(cboProdutosServicosPk.get(i).value == ""){
            cboProdutosServicosPk.get(i).focus();
            return false;

        }


        v_ic_possui_treinamento = 2;
        v_ic_possui_certificado = 2;

        if(chkTreinamento.get(i).checked)
            v_ic_possui_treinamento = 1;
        if(chkCertificado.get(i).checked)
            v_ic_possui_certificado = 1;

        arrDados[i] = [cboProdutosServicosPk.get(i).value, v_ic_possui_treinamento, v_ic_possui_certificado];

    }

    return arrayToJson(arrKeys, arrDados);

}



///BENEFICIOS

function fcFormatarGridBeneficio(){
    tblBeneficio = $("#tblBeneficio").DataTable(
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

function carregarListaComboBeneficio(){



    var objParametros = {
        pk:""
    };

    var arrCarregar = carregarController("beneficio", "listarTodos", objParametros);

    if (arrCarregar.result == 'success'){
        strComboBeneficio = "<select id='beneficios_pk' disabled class='form-control form-control-sm' name='beneficios_pk'><option></option>";
        for(i = 0; i < arrCarregar.data.length; i++){
            strComboBeneficio = strComboBeneficio + "<option value='"+arrCarregar.data[i]['pk']+"'>"+arrCarregar.data[i]['ds_beneficio']+"</option>";
        }
        strComboBeneficio += "</select>";
        //Carrega os dados no combo.
        fcFormatarGridBeneficio();
        fcAtualizarDadosGridBeneficio();
    }
    else{

        alert('Falhar ao carregar o registro');

    }
}


function fcAtualizarDadosGridBeneficio(){

    var objParametros = {
        "colaboradores_pk":pk,
        "token": token
    };

    var arrCarregar = carregarController("beneficio", "listarBeneficioColaboradores", objParametros);

        if (arrCarregar.result == 'success'){
            for(i = 0; i < arrCarregar.data.length; i++){

                //Adiciona a linha.
                fcIncluirBeneficio();

                //Pega as variaveis
                var cboBeneficiosPk = $("select[id='beneficios_pk']");
                var VlBeneficio = $("input[id='vl_beneficio']");
                var Obs = $("input[id='obs']");

                cboBeneficiosPk.get(i).value = arrCarregar.data[i]['beneficios_pk'];
                VlBeneficio.get(i).value = arrCarregar.data[i]['vl_beneficio'];
                Obs.get(i).value = arrCarregar.data[i]['obs'];
            }
        }
        else{

            alert('Falhar ao carregar o registro');
        }

}

function fcIncluirBeneficio(){

    tblBeneficio.row.add(
            [strComboBeneficio,
             "<input type='text' id='vl_beneficio' class='form-control form-control-sm' onkeypress='mascara(this,moeda)'/>",
             "<input type='text' class='form-control form-control-sm' id='obs' />"
            ]
    ).draw( false );


    return false;
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
///AFASTAMENTO

function fcFormatarGridAfastamento(){
    tblAfastamento = $("#tblAfastamento").DataTable(
        {
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2,3]
            }],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        }
    );
    return false;

}

function carregarListaComboAfastamento(){

        strComboAfastamento = "<select id='tipo_apontamento' disabled class='form-control form-control-sm' name='tipo_apontamento'><option></option>";
        strComboAfastamento +="<option value='1'>Afastamento Médio</option>";
        strComboAfastamento +="<option value='2'>Férias</option>";
        strComboAfastamento += "</select>";
        //Carrega os dados no combo.

        fcFormatarGridAfastamento();
        fcAtualizarDadosGridAfastamento();
}


function fcAtualizarDadosGridAfastamento(){

    var objParametros = {
        "colaborador_pk":pk,
        "token": token
    };

    var arrCarregar = carregarController("afastamento_ferias_colaborador", "listarAfastamentoColaboradores", objParametros);

        if (arrCarregar.result == 'success'){
            for(i = 0; i < arrCarregar.data.length; i++){

                //Adiciona a linha.
                fcIncluirAfastamento();

                //Pega as variaveis
                var tipo_apontamento = $("select[id='tipo_apontamento']");
                var dt_inicio = $("input[id='dt_inicio_afastamento']");
                var dt_fim = $("input[id='dt_fim_afastamento']");
                var obs = $("input[id='obs']");

                tipo_apontamento.get(i).value = arrCarregar.data[i]['tipo_apontamento'];
                dt_inicio.get(i).value = arrCarregar.data[i]['dt_inicio'];
                dt_fim.get(i).value = arrCarregar.data[i]['dt_fim'];
                obs.get(i).value = arrCarregar.data[i]['ds_obs'];
            }
        }
        else{

            alert('Falhar ao carregar o registro');
        }

}

function fcIncluirAfastamento(){

    tblAfastamento.row.add(
            [strComboAfastamento,
             "<input type='text' disabled id='dt_inicio_afastamento' maxlength='10' class='form-control form-control-sm' onkeypress='mascara(this,mdata)'/>",
             "<input type='text' disabled id='dt_fim_afastamento' maxlength='10'  class='form-control form-control-sm' onkeypress='mascara(this,mdata)'/>",
             "<input type='text' disabled class='form-control form-control-sm' id='obs' />"
            ]
    ).draw( false );

    return false;
}


function fcFormatarDadosAfastamento(){

    var tipo_apontamento = $("select[id='tipo_apontamento']");
    var dt_inicio = $("input[id='dt_inicio_afastamento']");
    var dt_fim = $("input[id='dt_fim_afastamento']");
    var obs = $("input[id='obs']");

    var alert = 0;


    var arrKeys = [];
    arrKeys[0] = "tipo_apontamento";
    arrKeys[1] = "dt_inicio";
    arrKeys[2] = "dt_fim";
    arrKeys[3] = "obs";

    var arrDados = [];

    var  data = tblAfastamento.rows().data();

    if(data.length >0){
        for(i = 0; i < data.length; i++){

            if(tipo_apontamento.get(i).value == ""){
                alert = 1;
            }
            if(dt_inicio.get(i).value == ""){
                alert = 1;
            }

            arrDados[i] = [tipo_apontamento.get(i).value, dt_inicio.get(i).value, dt_fim.get(i).value, obs.get(i).value];

        }
    }


    if(alert>0){
        return 1;
    }
    else{
        return arrayToJson(arrKeys, arrDados);
    }


}

///Curso
function fcFormatarGridCurso(){
    tblCurso = $("#tblCurso").DataTable(
        {
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2],
            }],

            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        }
    );
    return false;

}

function carregarListaComboCurso(){



    var objParametros = {

    };

    var arrCarregar = carregarController("curso", "listarTodosAtivo", objParametros);


    if (arrCarregar.result == 'success'){
        strComboCurso = "<select id='cursos_pk' disabled class='form-control form-control-sm' name='cursos_pk'><option></option>";
        for(i = 0; i < arrCarregar.data.length; i++){
            strComboCurso = strComboCurso + "<option value='"+arrCarregar.data[i]['pk']+"'>"+arrCarregar.data[i]['ds_curso']+"</option>";
        }
        strComboCurso += "</select>";
        //Carrega os dados no combo.
        fcFormatarGridCurso();
        fcAtualizarDadosGridCurso();
    }
    else{

        alert('Falhar ao carregar o registro');

    }
}


function fcAtualizarDadosGridCurso(){
    if(pk!=""){
        var objParametros = {
            "colaboradores_pk":pk,
            "token": token
        };

        var arrCarregar = carregarController("colaborador_curso", "listarCursoColaboradores", objParametros);
            if (arrCarregar.result == 'success'){
                for(i = 0; i < arrCarregar.data.length; i++){

                    //Adiciona a linha.
                    fcIncluirCurso();

                    //Pega as variaveis
                    var cboCursoPk = $("select[id='cursos_pk']");
                    var dt_execucao = $("input[id='dt_execucao']");
                    var dt_validacao = $("input[id='dt_validacao']");

                    cboCursoPk.get(i).value = arrCarregar.data[i]['cursos_pk'];
                    dt_execucao.get(i).value = arrCarregar.data[i]['dt_execucao'];
                    dt_validacao.get(i).value = arrCarregar.data[i]['dt_validacao'];
                }
            }
            else{

                alert('Falhar ao carregar o registro');
            }
    }


}

function fcIncluirCurso(){
    tblCurso.row.add(
            [strComboCurso,
             "<input type='text' disabled id='dt_execucao' class='form-control form-control-sm dt_execucao' maxlength=10 onkeypress='mascara(this,mdata)' style=' width:132px' />",
             "<input type='text' disabled class='form-control form-control-sm dt_validacao' id='dt_validacao' maxlength=10 onkeypress='mascara(this,mdata)' style='width:132px'/>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $('.dt_validacao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $('.dt_execucao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    return false;
}

function fcFormatarDadosCurso(){

    var cursos_pk = $("select[id='cursos_pk']");
    var dt_execucao = $("input[id='dt_execucao']");
    var dt_validacao = $("input[id='dt_validacao']");

    var arrKeys = [];
    arrKeys[0] = "cursos_pk";
    arrKeys[1] = "dt_execucao";
    arrKeys[2] = "dt_validacao";

    var arrDados = [];


    for(i = 0; i < cursos_pk.length; i++){
        if(cursos_pk.get(i).value == ""){
            cursos_pk.get(i).focus();
            return false;

        }

        arrDados[i] = [cursos_pk.get(i).value, (dt_execucao.get(i).value), dt_validacao.get(i).value];

    }

    return arrayToJson(arrKeys, arrDados);

}


function fcCarregarGridDocumentos(){
    var objParametros = {
        "colaboradores_pk": pk
    };

    var v_url = montarUrlController("documento", "listarDocumentosColaborador", objParametros);

    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>"
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
        fcDownloadDocumento(data['t_ds_documento']);
    });
    
}

function fcDownloadDocumento(ds_documento){
    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}


function fcValidarDocumentos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() == "Nenhum registro encontrado"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    }
    else{
        if(pk == ""){
            if($("#acao").val() == "ins"){
                var dsDocumento = "";
                var dsNomeOriginal = "";
                $('#tblArquivos tbody tr').each(function () {
                var colunas = $(this).children();
                    var colunas = $(this).children();
                    dsDocumento = $(colunas[0]).text();
                    dsNomeOriginal = $(colunas[1]).text();
                    fcIncluirDocumentoSemPk(dsDocumento,dsNomeOriginal);
                });
                $("#janela_documentos").modal("hide");
            }
        }
        else{
            fcEnviarDocumento(pk);
        }

    }

}

function fcIncluirDocumentoSemPk(v_documento,v_nome_original){
    tblDocumentos.row.add(
        {
            "t_pk":"",
            "t_ds_documento":v_documento,
            "t_ds_obs":$("#ds_obs_doc").val(),
            "t_ds_nome_original":v_nome_original,
            "t_functions":""
        }
    ).draw();

    return false;
}
function fcEnviarDocumento(v_pk){

    var strJSONDadosTabela =  fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();

    var objParametros = {
        "colaboradores_pk": v_pk,
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs
    };


    var arrEnviar = carregarController("documento", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_documentos").modal("hide");
        //alert(arrEnviar.message);
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
            "colaboradores_pk": pk,
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

function fcCarregarCep(){
    var cpf = $("#ds_cep").val();

    if(cpf.length == 9){

        var objParametros = {
            "ds_cep": $("#ds_cep").val()
        };

        var arrCarregar = carregarController("cep", "buscarCep", objParametros);

        if (arrCarregar.result == 'success'){

            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);


        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
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

function fcAtualizarDadosGridNomeFilho(){

    var objParametros = {
        "colaborador_pk":pk,
        "token": token
    };

    var arrCarregar = carregarController("colaborador_nome_filho", "listarNomeFilhoColaboradorPk", objParametros);

    if (arrCarregar.result == 'success'){
        for(i = 0; i < arrCarregar.data.length; i++){

            //Adiciona a linha.
            fcIncluirNomeFilho();

            //Pega as variaveis
            var ds_nome_filho = $("input[id='ds_nome_filho']");
            var ds_cpf_filho = $("input[id='ds_cpf_filho']");
            var dt_nascimento_filho = $("input[id='dt_nascimento_filho']");

            ds_nome_filho.get(i).value = arrCarregar.data[i]['ds_nome_filho'];
            ds_cpf_filho.get(i).value = arrCarregar.data[i]['ds_cpf_filho'];
            dt_nascimento_filho.get(i).value = arrCarregar.data[i]['dt_nascimento_filho'];

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
             "<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,mdata);' maxlength='10' id='dt_nascimento_filho' />"
            ]
    ).draw( false );



    return false;
}

function fcFormatarDadosNomeFilho(){

   var ds_nome_filho = $("input[id='ds_nome_filho']");
    var ds_cpf_filho = $("input[id='ds_cpf_filho']");
    var dt_nascimento_filho = $("input[id='dt_nascimento_filho']");

    var arrKeys = [];
    arrKeys[0] = "ds_nome_filho";
    arrKeys[1] = "ds_cpf_filho";
    arrKeys[2] = "dt_nascimento_filho";

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

            arrDados[i] = [ds_nome_filho.get(i).value, ds_cpf_filho.get(i).value, dt_nascimento_filho.get(i).value];

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


$(document).ready(function()
    {
        leads_pk = "";
        colaborador_pk ="";
        var arrCarregar = permissao("colaborador", "ins");

        if (arrCarregar.result != 'success'){
            alert('Falhar ao carregar o registro');
            return false;
        }

        fcLimparPonto();
        fcCarregarTurno();


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
            fcCarregarCep();
        });




        $("#exibir_qtde_filho").hide();
        $("#exibir_nome_filho").hide();
        fcFormatarGridNomeFilho();
        fcAtualizarDadosGridNomeFilho();
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


        $("#ds_carga_horaria_semanal").keypress(function(){
            mascara(this,horamasksemanal);
        });
        $("#ds_entrada_dom").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_ida_intervalo_dom").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_volta_intervalo_dom").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_saida_dom").keypress(function(){
            mascara(this,horamask);
        });

        $("#ds_entrada_seg").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_ida_intervalo_seg").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_volta_intervalo_seg").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_saida_seg").keypress(function(){
            mascara(this,horamask);
        });

        $("#ds_entrada_ter").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_ida_intervalo_ter").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_volta_intervalo_ter").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_saida_ter").keypress(function(){
            mascara(this,horamask);
        });

        $("#ds_entrada_qua").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_ida_intervalo_qua").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_volta_intervalo_qua").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_saida_qua").keypress(function(){
            mascara(this,horamask);
        });

        $("#ds_entrada_qui").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_ida_intervalo_qui").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_volta_intervalo_qui").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_saida_qui").keypress(function(){
            mascara(this,horamask);
        });

        $("#ds_entrada_sex").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_ida_intervalo_sex").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_volta_intervalo_sex").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_saida_sex").keypress(function(){
            mascara(this,horamask);
        });

        $("#ds_entrada_sab").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_ida_intervalo_sab").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_volta_intervalo_sab").keypress(function(){
            mascara(this,horamask);
        });
        $("#ds_saida_sab").keypress(function(){
            mascara(this,horamask);
        });

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
        $("#ds_cpf").change(function(){
            fcVerificarCNPJ();
        });

        if(pk!=""){
            $("#exibir_materiais").show();
            $("#exibir_afastamento").show();
        }
        //Atribui a validação do formulário dos campos obrigatórios
        fcValidarForm();

        fcCarregarGenero();

        fcCarregarEmpresa();

        fcCarregarBancos();



        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();

        $(".chzn-select").chosen({allow_single_deselect: true});

        carregarListaCombo();

        carregarListaComboAfastamento();

        carregarListaComboCurso();

        carregarListaComboBeneficio();

        fcCarregarGridDocumentos();

        fcCarregarGridArquivos();

        fcValidarFormExames();


    }
);

var tblContatos;
var rLinhaSelecionada = null;
function fcCarregar(){

    if($("#colaborador_pk").val() > 0){

        var objParametros = {
            "pk": $("#colaborador_pk").val()
        };
        var arrCarregar = carregarController("colaborador", "listarPk", objParametros);

        if (arrCarregar.status == true){

            $("#ds_colaborador").val(arrCarregar.data[0]['ds_colaborador']);
            $("#ds_nacionalidade").val(arrCarregar.data[0]['ds_nacionalidade']);
            $("#generos_pk").val(arrCarregar.data[0]['ic_genero']);
            $("#dt_nascimento").val(arrCarregar.data[0]['dt_nascimento']);
            $("#ds_nome_pai").val(arrCarregar.data[0]['ds_nome_pai']);
            $("#ds_nome_mae").val(arrCarregar.data[0]['ds_nome_mae']);
            $("#regime_contratacao_pk").val(arrCarregar.data[0]['ic_regime_contratacao']);
            $("#ds_carga_horaria_semanal").val(arrCarregar.data[0]['ds_carga_horaria_mensal']);
            $("#vl_salario").val(float2moeda(arrCarregar.data[0]['vl_salario']));
            $("#ds_matricula").val(arrCarregar.data[0]['ds_matricula']);
            $("#ds_re").val(arrCarregar.data[0]['ds_e_social']);
            $("#ic_funcionario").val(arrCarregar.data[0]['ic_funcionario']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#ds_cpf").val(arrCarregar.data[0]['ds_cpf']);
            $("#ds_rg").val(arrCarregar.data[0]['ds_rg']);
            $("#ds_org_exp").val(arrCarregar.data[0]['ds_orgao_expedicao_rg']);
            $("#dt_expedicao").val(arrCarregar.data[0]['dt_expedicao_rg']);
            $("#ds_uf_rg").val(arrCarregar.data[0]['uf_expedicao_rg']);
            $("#ds_titulo_eleitoral").val(arrCarregar.data[0]['ds_titulo_eleitor']);
            $("#ds_zona_eleitoral").val(arrCarregar.data[0]['ds_zona_eleitorial']);
            $("#ds_secao").val(arrCarregar.data[0]['ds_secao']);
            $("#ds_ctps").val(arrCarregar.data[0]['ds_ctps']);
            $("#ds_serie").val(arrCarregar.data[0]['ds_serie_ctps']);
            $("#ds_certificado_reservista").val(arrCarregar.data[0]['ds_num_reservista']);
            $("#ds_cartao_sus").val(arrCarregar.data[0]['ds_num_cartao_sus']);
            $("#tipo_conta_bancaria").val(arrCarregar.data[0]['ic_tipo_conta_bancaria']);
            $("#ds_agencia").val(arrCarregar.data[0]['ds_agencia']);
            $("#ds_conta").val(arrCarregar.data[0]['ds_conta']);
            $("#ds_digito").val(arrCarregar.data[0]['ds_digito']);
            $("#bancos_pk").val(arrCarregar.data[0]['banco_pk']);
            $("#ds_pix").val(arrCarregar.data[0]['ds_pix']);
            $("#ds_conta_favorecido").val(arrCarregar.data[0]['ds_favorecido']);
            $("#ds_cep").val(arrCarregar.data[0]['ds_cep']);
            $("#ds_endereco").val(arrCarregar.data[0]['ds_endereco']);
            $("#ds_numero").val(arrCarregar.data[0]['ds_numero']);
            $("#ds_complemento").val(arrCarregar.data[0]['ds_complemento']);
            $("#ds_bairro").val(arrCarregar.data[0]['ds_bairro']);
            $("#ds_cidade").val(arrCarregar.data[0]['ds_cidade']);
            $("#ds_uf").val(arrCarregar.data[0]['ds_uf']);
            $("#ds_n_sapato").val(arrCarregar.data[0]['ds_num_sapato']);
            $("#ds_n_camisa").val(arrCarregar.data[0]['ds_num_camisa']);
            $("#ds_n_calca").val(arrCarregar.data[0]['ds_num_calca']);
            $("#grupos_pk").val(arrCarregar.data[0]['grupos_pk']);
            $("#ds_cel").val(arrCarregar.data[0]['ds_cel']);
            if(arrCarregar.data[0]['ds_imagem']!=null){
                $("#ds_imagem").html(arrCarregar.data[0]['ds_imagem']);
            }else{
                $("#ds_imagem").html(' <img src="/assets/img/profile/avatar.jpg" width="100" height="100">');
            }

        }
        else{
            utilsJS.toastNotify(false, 'Falhar ao carregar o registro');
        }
    }
}
function fcValidarForm(){


    fcEnviar();
}

function fcCarregarBancos(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("banco", "listarTodos", objParametros);
    carregarComboAjax($("#bancos_pk"), arrCarregar, " ", "pk", "ds_banco");

}
function fcEnviar(){
    try {
        var strFuncao = [];
        if($("#colaborador_pk").val()==""){
            strFuncao = fcFormatarDadosFuncao();
        }
        var strEscala = fcFormatarDadosEscala();
        var strDocs = fcFormatarDadosDocumentos();
        if($('#ds_colaborador').val()==""){
            sweetMensagem('warning',"Por favor, informe Colaborador");
            $('#ds_colaborador').focus();
            return false;
        }

        /*if($('#ds_rg').val()==""){
            utilsJS.toastNotify(false,"Por favor, informe RG");
            $('#ds_rg').focus();
            return false;
        }

        if($('#dt_nascimento').val()==""){
            utilsJS.toastNotify(false,"Por favor, informe Data Nascimento");
            $('#dt_nascimento').focus();
            return false;
        }*/

        if($('#ds_cpf').val()==""){
            sweetMensagem('warning',"Por favor, informe CPF");
            $('#ds_cpf').focus();
            return false;
        }

        /*if($('#ds_cel').val()==""){
            utilsJS.toastNotify(false,"Por favor, informe Cel");
            $('#ds_cel').focus();
            return false;
        }else if($('#ds_cel').val().length < 10){
            utilsJS.toastNotify(false,"Por favor, informe um Cel Válido");
            $('#ds_cel').focus();
            return false;
        }*/

        utilsJS.loading("Salvando informações...");

        setTimeout(() => {
            var ds_colaborador = $("#ds_colaborador").val();
            var ds_nacionalidade = $("#ds_nacionalidade").val();
            var generos_pk = $("#generos_pk").val();
            var dt_nascimento = $("#dt_nascimento").val();
            var ds_nome_pai = $("#ds_nome_pai").val();
            var ds_nome_mae = $("#ds_nome_mae").val();
            var regime_contratacao_pk = $("#regime_contratacao_pk").val();
            var ds_carga_horaria_semanal = $("#ds_carga_horaria_semanal").val();
            var vl_salario = $("#vl_salario").val();
            var ds_matricula = $("#ds_matricula").val();
            var ds_re = $("#ds_re").val();
            var ic_funcionario = $("#ic_funcionario").val();
            var ic_status = $("#ic_status").val();
            var ds_cpf = $("#ds_cpf").val();
            var ds_rg = $("#ds_rg").val();
            var ds_org_exp = $("#ds_org_exp").val();
            var dt_expedicao = $("#dt_expedicao").val();
            var ds_uf_rg = $("#ds_uf_rg").val();
            var ds_titulo_eleitoral = $("#ds_titulo_eleitoral").val();
            var ds_zona_eleitoral = $("#ds_zona_eleitoral").val();
            var ds_secao = $("#ds_secao").val();
            var ds_ctps = $("#ds_ctps").val();
            var ds_serie = $("#ds_serie").val();
            var ds_certificado_reservista = $("#ds_certificado_reservista").val();
            var ds_cartao_sus = $("#ds_cartao_sus").val();
            var tipo_conta_bancaria = $("#tipo_conta_bancaria").val();
            var bancos_pk = $("#bancos_pk").val();
            var ds_agencia = $("#ds_agencia").val();
            var ds_conta = $("#ds_conta").val();
            var ds_digito = $("#ds_digito").val();
            var ds_pix = $("#ds_pix").val();
            var ds_conta_favorecido = $("#ds_conta_favorecido").val();
            var ds_cep = $("#ds_cep").val();
            var ds_endereco = $("#ds_endereco").val();
            var ds_numero = $("#ds_numero").val();
            var ds_complemento = $("#ds_complemento").val();
            var ds_bairro = $("#ds_bairro").val();
            var ds_cidade = $("#ds_cidade").val();
            var ds_uf = $("#ds_uf").val();
            var ds_n_sapato = $("#ds_n_sapato").val();
            var ds_n_camisa = $("#ds_n_camisa").val();
            var ds_n_calca = $("#ds_n_calca").val();
            var grupos_pk = $("#grupos_pk").val();
            var ds_cel = $("#ds_cel").val();    
            var objParametros = {
                "pk": $("#colaborador_pk").val(),
                "ds_colaborador": (ds_colaborador),
                "ds_nacionalidade": (ds_nacionalidade),
                "ic_genero": (generos_pk),
                "dt_nascimento": (dt_nascimento),
                "ds_nome_pai": (ds_nome_pai),
                "ds_nome_mae": (ds_nome_mae),
                "ic_regime_contratacao": (regime_contratacao_pk),
                "ds_carga_horaria_mensal": (ds_carga_horaria_semanal),
                "vl_salario": moeda2float(vl_salario),
                "ds_matricula": (ds_matricula),
                "ds_e_social": (ds_re),
                "ic_funcionario": (ic_funcionario),
                "ic_status": (ic_status),
                "ds_cpf": (ds_cpf),
                "ds_rg": (ds_rg),
                "ds_orgao_expedicao_rg": (ds_org_exp),
                "dt_expedicao_rg": (dt_expedicao),
                "uf_expedicao_rg": (ds_uf_rg),
                "ds_titulo_eleitor": (ds_titulo_eleitoral),
                "ds_zona_eleitorial": (ds_zona_eleitoral),
                "ds_secao": (ds_secao),
                "ds_ctps": (ds_ctps),
                "ds_serie_ctps": (ds_serie),
                "ds_num_reservista": (ds_certificado_reservista),
                "ds_num_cartao_sus": (ds_cartao_sus),
                "ic_tipo_conta_bancaria": (tipo_conta_bancaria),
                "banco_pk": (bancos_pk),
                "ds_agencia": (ds_agencia),
                "ds_conta": (ds_conta),
                "ds_digito": (ds_digito),
                "ds_pix": (ds_pix),
                "ds_favorecido": (ds_conta_favorecido),
                "ds_cep": (ds_cep),
                "ds_endereco": (ds_endereco),
                "ds_numero": (ds_numero),
                "ds_complemento": (ds_complemento),
                "ds_bairro": (ds_bairro),
                "ds_cidade": (ds_cidade),
                "ds_uf": (ds_uf),
                "ds_num_sapato": (ds_n_sapato),
                "ds_num_camisa": (ds_n_camisa),
                "ds_num_calca": (ds_n_calca),
                "grupos_pk": (grupos_pk),
                "ds_cel":(ds_cel),
                "funcao_colaborador": (strFuncao),
                "escala_colaborador": (strEscala),
                "documento_colaborador": (strDocs),
            };
            var arrEnviar = carregarController("colaborador", "salvar", objParametros);
            //NewWindow(v_last_url)
            if (arrEnviar.status == true){
                // Reload datable
                utilsJS.loaded();
                utilsJS.toastNotify(true, arrEnviar.message);
                var objParametros = {
                    "local":$("#local").val()
                };
                sendPost('colaborador','receptivo' ,objParametros);

            }
            else{
                utilsJS.loaded();
                utilsJS.toastNotify(false, 'Falhou a requisição para salvar o registro');
            }
        }, 2000);
        
    } catch (error) {
        utilsJS.loaded();
        utilsJS.toastNotify(false, error);
    }

}

function fcCarregarGrupoColaborador() {
    //Carrega os grupos

    var objParametros = {
    };

    var arrCarregar = carregarController("conta", "listarTodos", objParametros);

    carregarComboAjax($("#grupos_pk"), arrCarregar, " ", "pk", "ds_conta");
}

function fcCancelar(){
    var objParametros = {
        "local":$("#local").val()
    };
    sendPost('lead','receptivo' ,objParametros);
}

function fcCarregarGrupoLeads() {
    //Carrega os grupos

    var objParametros = {
    };

    var arrCarregar = carregarController("conta", "listarTodos", objParametros);

    carregarComboAjax($("#escala_grupos_leads_pk"), arrCarregar, " ", "pk", "ds_conta");

}

// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
//Inicio das funcoes da tela de FUNÇÃO (Modal).
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------

function fcCarregarGridFuncao(){

    if($("#colaborador_pk").val()!=""){
        var objParametros = {
            "colaborador_pk": $("#colaborador_pk").val()
        };

        var v_url = routes_api("colaborador", "listarGridFuncao", objParametros);

        //Trata a tabela
        tblFuncao = $('#tblFuncao').DataTable({
            searching: true,
            paging: true,
            scrollX: true,
            pageLength: 10,
            aLengthMenu: [10, 25, 50, 100],
            iDisplayLength: 10,
            processing: false,
            serverSide: true,
            ajax: v_url,
            responsive: true,
            language: {
                emptyTable: "Não existem Dados cadastrados"
            },
            order: [
                [0, "asc"]
            ],
            columns: [
                {
                    mRender: function (data, type, full) {
                        return full['pk'];
                    },
                    'orderable': true,
                    'searchable': false

                },
                {
                    mRender: function (data, type, full) {
                        return full['ds_produto_servico'];
                    },
                    'orderable': true,
                    'searchable': false,

                },
                {
                    mRender: function (data, type, full) {
                        var buttonPainel = '<a class="function_edit"><span><i class="fa fa-edit" style="font-size=18px;color:blue" title="editar"></i></span></a> ';
                        var buttonDelete = '<a class="function_delete1"><span><i class="fa fa-trash-alt" style="font-size=18px;color:blue" title="excluir"></i></span></a> ';


                        return buttonPainel + buttonDelete;
                    },
                    'orderable': false,
                    'searchable': false,
                }
            ]
        });

        //Atribui os eventos na coluna ação.
        $('#tblFuncao tbody').on('click', '.function_edit', function (e) {
            var data;
            if(tblFuncao.row( $(this).parents('li')).data()){
                data = tblFuncao.row( $(this).parents('li')).data();
            }
            else if(tblFuncao.row( $(this).parents('tr')).data()){
                data = tblFuncao.row( $(this).parents('tr')).data();
            }
            fcEditarFuncao(data);

        } );

        $('#tblFuncao tbody').on('click', '.function_delete1', function () {
            var data;
            if(tblFuncao.row( $(this).parents('li')).data()){
                data = tblFuncao.row( $(this).parents('li')).data();
            }
            else if(tblFuncao.row( $(this).parents('tr')).data()){
                data = tblFuncao.row( $(this).parents('tr')).data();
            }
            fcExcluirFuncaoColab(data['pk']);
        });

        return false;
    }
    else{
        tblFuncao = $('#tblFuncao').DataTable( {
            responsive: true,
            scrollX: true,
        });
        //Atribui os eventos na coluna ação.
        $('#tblFuncao tbody').on('click', '.function_edit', function (e) {
            e.preventDefault();
            let element = $(this);
            $("#cargos_pk").val(element.parents('tr').find("td:nth-child(2) input").val());
            $("#janela_funcao").modal("show");

            tblFuncao.row($(this).parents('tr')).remove().draw();
        } );

        $('#tblFuncao tbody').on('click', '.function_delete', function () {
            tblFuncao.row($(this).parents('tr')).remove().draw();
        } );

        return false;
    }

}

function fcEditarFuncao(objRegistro){
    $("#funcao_pk").val(objRegistro['pk']);
    $("#cargos_pk").val(objRegistro['produtos_servicos_pk']);
    $("#janela_funcao").modal("show");
}

function fcExcluirFuncaoColab(v_pk){
    if(v_pk != ""){

        var objParametros = {
            "pk": v_pk
        };

        var arrExcluir = carregarController("colaborador", "excluirFuncao", objParametros);

        if (arrExcluir.status == true){
            utilsJS.toastNotify(true,arrExcluir.message)

            // Reload datable
            tblFuncao.ajax.reload();

        }else{

            utilsJS.toastNotify(false, 'Falhou a requisição de exclusão ');
        }
    }
    else{
        utilsJS.toastNotify(false, 'Código não encontrado');
    }

}

function fcSalvarFuncao(){
    var objParametros = {
        "pk": $("#funcao_pk").val(),
        "produtos_servicos_pk": $("#cargos_pk").val(),
        "colaborador_pk": $("#colaborador_pk").val()
    };

    var arrEnviar = carregarController("colaborador", "salvarFuncao", objParametros);

    if (arrEnviar.status == true){
        // Reload datable
        utilsJS.toastNotify(true,arrEnviar.message)

        // Reload datable
        tblFuncao.ajax.reload();
    }
    else{
        utilsJS.toastNotify(false,'Falhou a requisição para salvar o registro');
    }
}

function fcEnviarFuncao(){
    if($("#colaborador_pk").val()==""){
        if($("#acao").val() == "ins"){
            fcIncluirFuncaoSemPk();
        }
        else if($("#acao").val() == "upd"){
            fcEditarFuncaoSemPk();
        }
    }
    else{
        fcSalvarFuncao();
    }


    $("#janela_funcao").modal("hide");
}
function fecharModalFuncao(){
    $("#janela_funcao").modal("hide");
}
function fcRecarregarGridFuncao(){
    tblFuncao.clear().destroy();
    fcCarregarGridFuncao();
}
function fcIncluirFuncaoSemPk(){

    var counter = 1;

    tblFuncao.row.add( [
        counter,
        "<td><input type='hidden' id='cargos_pk[]' value ='"+$("#cargos_pk").val()+"'>"+ $("#cargos_pk option:selected").text()+"</td>",
        "<td><a class='function_edit' style='margin-right: 12px;'><i class='fa fa-pencil-alt'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'style='margin-right: 12px;'><i class='fa fa-trash-alt'></i></a></td>"
    ] ).draw().node();
    counter++;
    return false;
}

function fcEditarFuncaoSemPk(){

    fcIncluirFuncaoSemPk();
    tblFuncao.row(rLinhaSelecionada).remove().draw();
    return false;
}

function fcFormatarDadosFuncao(){
    try{
        var funcaoPk = "";

        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "cargos_pk";
        if($("#colaborador_pk").val()==""){
            var i = 0;
            $("#tblFuncao").find('tbody tr').each(function () {
                //if ($(this).find('td:nth-child(1) input').val() == "") {
                cboCargosPk = $(this).find('td:nth-child(2) input').val();

                arrDados[i] = [cboCargosPk];
                i++;
                //}
            });
        }
        else{
            var  data = tblFuncao.rows().data();
            for(i = 0; i< data.length; i++) {
                cboCargosPk = data[i]['pk'];

                arrDados[i] = [cboCargosPk];
            }
        }

        return arrayToJson(arrKeys, arrDados);
    }
    catch (err) {

        utilsJS.toastNotify(false, err);
    }
}

function fcLimparFormFuncao(){
    $("#acao").val("");
    $("#cargos_pk").val("");
    $("#funcao_pk").val("");
}


//abre o formulario para a inclusao de um novo contato.
function fcAbrirFormNovoFuncao(){
    //limpa os dados de qualquer registro existe
    fcLimparFormFuncao();
    $("#janela_funcao").modal('show');
    $("#acao").val("ins");
}
function fcCarregarFuncao(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("servico", "listarTodos", objParametros);
    carregarComboAjax($("#cargos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}
function fcCarregarFuncaoEscala(){

    var objParametros = {
        "leads_pk": $("#escala_leads_pk").val()
    };

    var arrCarregar = carregarController("servico", "listarByLeads", objParametros);
    carregarComboAjax($("#escala_cargos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
//Inicio das funcoes da tela de ESCALA (Modal).
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------

function fcCarregarGridEscala(){

    var objParametros = {
        "colaborador_pk":$("#colaborador_pk").val()
    };

    var v_url = routes_api("agenda_colaborador_padrao", "listarEscalaColaborador", objParametros);

    //Trata a tabela
    tblEscala = $('#tblEscala').DataTable({
        searching: true,
        paging: true,
        scrollX: true,
        pageLength: 10,
        aLengthMenu: [10, 25, 50, 100],
        iDisplayLength: 10,
        processing: false,
        serverSide: true,
        ajax: v_url,
        responsive: true,
        language: {
            emptyTable: "Não existem Dados cadastrados"
        },
        order: [
            [0, "asc"]
        ],
        columns: [
            {
                mRender: function (data, type, full) {
                    return full['pk'];
                },
                'orderable': true,
                'searchable': false

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_colaborador'];
                },
                'orderable': true,
                'searchable': false,

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_lead'];
                },
                'orderable': true,
                'searchable': false,

            },{
                mRender: function (data, type, full) {
                    return full['ds_funcao'];
                },
                'orderable': true,
                'searchable': false,

            },{
                mRender: function (data, type, full) {
                    return full['ds_escala'];
                },
                'orderable': true,
                'searchable': false,

            },
            {
                mRender: function (data, type, full) {
                    var buttonPainel = '<a class="function_edit"><span><i class="fa fa-edit" style="font-size=18px;color:blue" title="editar"></i></span></a> ';
                    var buttonDelete = '<a class="function_delete"><span><i class="fa fa-trash-alt" style="font-size=18px;color:blue" title="excluir"></i></span></a> ';


                    return buttonPainel + buttonDelete;
                },
                'orderable': false,
                'searchable': false,
            }
        ]
    });
    //Atribui os eventos na coluna ação.
    $('#tblEscala tbody').on('click', '.function_edit', function () {
        var data;
        rLinhaSelecionada = null;
        if (tblEscala.row($(this).parents('li')).data()) {
            data = tblEscala.row($(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if (tblEscala.row($(this).parents('tr')).data()) {
            data = tblEscala.row($(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarEscala(data);
    });

    $('#tblEscala tbody').on('click', '.function_delete', function () {
        var data;
        if (tblEscala.row($(this).parents('li')).data()) {
            data = tblEscala.row($(this).parents('li')).data();
        }
        else if (tblEscala.row($(this).parents('tr')).data()) {
            data = tblEscala.row($(this).parents('tr')).data();
        }

        if (data['pk'] != "") {
            fcExcluirEscala(data['pk']);
        }
        tblEscala.row($(this).parents('tr')).remove().draw();
    });

    return false;
}

function  fcExcluirEscala(v_pk){
    utilsJS.jqueryConfirm('Excluir?', 'Deseja excluir o registro '+v_pk+'?', function () {
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("agenda_colaborador_padrao", "excluir", objParametros);

            if (arrExcluir.status == true){
                utilsJS.toastNotify(true,arrExcluir.message)

                // Reload datable
                tblEscala.ajax.reload();

            }else{

                utilsJS.toastNotify(false, 'Falhou a requisição de exclusão ');
            }
        }
        else{
            utilsJS.toastNotify(false, 'Código não encontrado');
        }
    });
}
function fcEditarEscala(objRegistro){
    fcLimparFormEscala();
    fcCarregarLead();
    $("#escala_agenda_pk").val(objRegistro['pk']);
    $("#exibir_data_cancelamento").show();
    $("#dt_inicio_agenda").val(objRegistro['dt_inicio_agenda']);
    $("#dt_fim_agenda").val(objRegistro['dt_fim_agenda']);

    $("#escala_leads_pk").val(objRegistro['leads_pk']);
    fcCarregarFuncaoEscala();
    $("#escala_cargos_pk").val(objRegistro['produtos_servicos_pk']);
    $("#dt_cancelamento_agenda_escala").val(objRegistro['dt_cancelamento']);
    $("#ds_motivo_cancelamento").val(objRegistro['ds_motivo_cancelamento']);
    $("#tipo_escala_pk").val(objRegistro['tipos_escalas_pk']);
    if(objRegistro['ds_escala']=="12X36"){
        $("#exibir_variacao_escala").show()
    }
    else{
        $("#exibir_variacao_escala").hide();
    }
    $("#ic_variacao_dias_escala").val(objRegistro['ic_variacao_dias_escala']);
    if(objRegistro['ic_escala_dom']==1){
        $("#ic_dom").prop("checked", true);
    }
    if(objRegistro['ic_escala_seg']==1){
        $("#ic_seg").prop("checked", true);
    }
    if(objRegistro['ic_escala_ter']==1){
        $("#ic_ter").prop("checked", true);
    }
    if(objRegistro['ic_escala_qua']==1){
        $("#ic_qua").prop("checked", true);
    }
    if(objRegistro['ic_escala_qui']==1){
        $("#ic_qui").prop("checked", true);
    }
    if(objRegistro['ic_escala_sex']==1){
        $("#ic_sex").prop("checked", true);
    }
    if(objRegistro['ic_escala_sab']==1){
        $("#ic_sab").prop("checked", true);
    }
    if(objRegistro['ic_folga_dom']==1){
        $("#ic_dom_folga").prop("checked", true);
    }
    if(objRegistro['ic_folga_seg']==1){
        $("#ic_seg_folga").prop("checked", true);
    }
    if(objRegistro['ic_folga_ter']==1){
        $("#ic_ter_folga").prop("checked", true);
    }
    if(objRegistro['ic_folga_qua']==1){
        $("#ic_qua_folga").prop("checked", true);
    }
    if(objRegistro['ic_folga_qui']==1){
        $("#ic_qui_folga").prop("checked", true);
    }
    if(objRegistro['ic_folga_sex']==1){
        $("#ic_sex_folga").prop("checked", true);
    }
    if(objRegistro['ic_folga_sab']==1){
        $("#ic_sab_folga").prop("checked", true);
    }
    $("#dom_turnos_pk").val(objRegistro['turnos_pk']);
    $("#seg_turnos_pk").val(objRegistro['turnos_pk']);
    $("#ter_turnos_pk").val(objRegistro['turnos_pk']);
    $("#qua_turnos_pk").val(objRegistro['turnos_pk']);
    $("#qui_turnos_pk").val(objRegistro['turnos_pk']);
    $("#sex_turnos_pk").val(objRegistro['turnos_pk']);
    $("#sab_turnos_pk").val(objRegistro['turnos_pk']);
    $("#hr_turno_dom").val(objRegistro['hr_inicio_exp_dom']);
    $("#hr_turno_seg").val(objRegistro['hr_inicio_exp_seg']);
    $("#hr_turno_ter").val(objRegistro['hr_inicio_exp_ter']);
    $("#hr_turno_qua").val(objRegistro['hr_inicio_exp_qua']);
    $("#hr_turno_qui").val(objRegistro['hr_inicio_exp_qui']);
    $("#hr_turno_sex").val(objRegistro['hr_inicio_exp_sex']);
    $("#hr_turno_sab").val(objRegistro['hr_inicio_exp_sab']);
    $("#hr_turno_dom_saida").val(objRegistro['hr_termino_expediente_dom']);
    $("#hr_turno_seg_saida").val(objRegistro['hr_termino_expediente_seg']);
    $("#hr_turno_ter_saida").val(objRegistro['hr_termino_expediente_ter']);
    $("#hr_turno_qua_saida").val(objRegistro['hr_termino_expediente_qua']);
    $("#hr_turno_qui_saida").val(objRegistro['hr_termino_expediente_qui']);
    $("#hr_turno_sex_saida").val(objRegistro['hr_termino_expediente_sex']);
    $("#hr_turno_sab_saida").val(objRegistro['hr_termino_expediente_sab']);
    $("#hr_intervalo_dom").val(objRegistro['hr_inicio_intervalo_dom']);
    $("#hr_intervalo_seg").val(objRegistro['hr_inicio_intervalo_seg']);
    $("#hr_intervalo_ter").val(objRegistro['hr_inicio_intervalo_ter']);
    $("#hr_intervalo_qua").val(objRegistro['hr_inicio_intervalo_qua']);
    $("#hr_intervalo_qui").val(objRegistro['hr_inicio_intervalo_qui']);
    $("#hr_intervalo_sex").val(objRegistro['hr_inicio_intervalo_sex']);
    $("#hr_intervalo_sab").val(objRegistro['hr_inicio_intervalo_sab']);
    $("#hr_intervalo_saida_dom").val(objRegistro['hr_termino_intervalo_dom']);
    $("#hr_intervalo_saida_seg").val(objRegistro['hr_termino_intervalo_ter']);
    $("#hr_intervalo_saida_ter").val(objRegistro['hr_termino_intervalo_ter']);
    $("#hr_intervalo_saida_qua").val(objRegistro['hr_termino_intervalo_ter']);
    $("#hr_intervalo_saida_qui").val(objRegistro['hr_termino_intervalo_ter']);
    $("#hr_intervalo_saida_sex").val(objRegistro['hr_termino_intervalo_ter']);
    $("#hr_intervalo_saida_sab").val(objRegistro['hr_termino_intervalo_ter']);
    $("#turnos_pk").val(objRegistro['turnos_pk']);
    $("#hr_inicio_expediente").val(objRegistro['hr_inicio_expediente']);
    $("#hr_termino_expediente").val(objRegistro['hr_termino_expediente']);
    $("#hr_inicio_intervalo").val(objRegistro['hr_inicio_intervalo']);
    $("#hr_termino_intervalo").val(objRegistro['hr_termino_intervalo']);
    $("#obs").val(objRegistro['obs']);
    if(objRegistro['ic_intrajornada']==1){
        $("#ic_intrajornada").prop("checked", true);
    }
    $("#janela_escala").modal("show");
}

function fcEnviarEscala(){
    //variaveis
    var ic_dom = 2;
    var ic_seg = 2;
    var ic_ter = 2;
    var ic_qua = 2;
    var ic_qui = 2;
    var ic_sex = 2;
    var ic_sab = 2;
    var ic_dom_folga = 2;
    var ic_seg_folga = 2;
    var ic_ter_folga = 2;
    var ic_qua_folga = 2;
    var ic_qui_folga = 2;
    var ic_sex_folga = 2;
    var ic_sab_folga = 2;

    //validações do grid de escala
    if($("#tipo_escala_pk").val()==""){
        sweetMensagem('warning',"Por favor, informe o Tipo Escala");
        return false;
    }
    if ($('#ic_dom').is(":checked") && $('#dom_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#dom_turnos_pk').focus();
        return false;
    }
    if ($('#ic_dom').is(":checked") && $('#dom_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#dom_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_seg').is(":checked") && $('#seg_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#seg_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_ter').is(":checked") && $('#ter_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#ter_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_qua').is(":checked") && $('#qua_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#qua_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_qui').is(":checked") && $('#qui_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#qui_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_sex').is(":checked") && $('#sex_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#sex_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_sab').is(":checked") && $('#sab_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#sab_turnos_pk').focus();
        return false;
    }
    //HORARIO
    else if ($('#ic_dom').is(":checked") && $('#hr_turno_dom').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_dom').focus();
        return false;
    }
    else if ($('#ic_seg').is(":checked") && $('#hr_turno_seg').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_seg').focus();
        return false;
    }
    else if ($('#ic_ter').is(":checked") && $('#hr_turno_ter').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_ter').focus();
        return false;
    }
    else if ($('#ic_qua').is(":checked") && $('#hr_turno_qua').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_qua').focus();
        return false;
    }
    else if ($('#ic_qui').is(":checked") && $('#hr_turno_qui').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_qui').focus();
        return false;
    }
    else if ($('#ic_sex').is(":checked") && $('#hr_turno_sex').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_sex').focus();
        return false;
    }
    else if ($('#ic_sab').is(":checked") && $('#hr_turno_sab').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_sab').focus();
        return false;
    }

    if ($('#ic_dom').is(":checked")) {
        ic_dom = 1;
    }
    if ($('#ic_seg').is(":checked")) {
        ic_seg = 1;
    }
    if ($('#ic_ter').is(":checked")) {
        ic_ter = 1;
    }
    if ($('#ic_qua').is(":checked")) {
        ic_qua = 1;
    }
    if ($('#ic_qui').is(":checked")) {
        ic_qui = 1;
    }
    if ($('#ic_sex').is(":checked")) {
        ic_sex = 1;
    }
    if ($('#ic_sab').is(":checked")) {
        ic_sab = 1;
    }

    if ($('#ic_dom_folga').is(":checked")) {
        ic_dom_folga = 1;
    }
    if ($('#ic_seg_folga').is(":checked")) {
        ic_seg_folga = 1;
    }
    if ($('#ic_ter_folga').is(":checked")) {
        ic_ter_folga = 1;
    }
    if ($('#ic_qua_folga').is(":checked")) {
        ic_qua_folga = 1;
    }
    if ($('#ic_qui_folga').is(":checked")) {
        ic_qui_folga = 1;
    }
    if ($('#ic_sex_folga').is(":checked")) {
        ic_sex_folga = 1;
    }
    if ($('#ic_sab_folga').is(":checked")) {
        ic_sab_folga = 1;
    }
    var  ic_intrajornada = ""
    if ($('#ic_intrajornada').is(":checked")) {
        ic_intrajornada = 1;
    }


    formdataEscala.append("pk",$("#escala_agenda_pk").val());
    formdataEscala.append("leads_pk",$("#escala_leads_pk").val());
    formdataEscala.append("produtos_servicos_pk",$("#escala_cargos_pk").val());
    formdataEscala.append("dt_inicio_agenda",$("#dt_inicio_agenda").val());
    formdataEscala.append("dt_fim_agenda",$("#dt_fim_agenda").val());
    formdataEscala.append("turnos_pk",$("#turnos_pk").val());
    formdataEscala.append("hr_inicio_expediente",$("#hr_inicio_expediente").val());
    formdataEscala.append("hr_termino_expediente",$("#hr_termino_expediente").val());
    formdataEscala.append("hr_inicio_intervalo",$("#hr_inicio_intervalo").val());
    formdataEscala.append("hr_termino_intervalo",$("#hr_termino_intervalo").val());
    formdataEscala.append("ic_intrajornada",ic_intrajornada);
    formdataEscala.append("ic_variacao_dias_escala",$("#ic_variacao_dias_escala").val());
    formdataEscala.append("tipos_escalas_pk",$("#tipo_escala_pk").val());
    formdataEscala.append("ic_folga_dom",ic_dom_folga);
    formdataEscala.append("ic_folga_seg",ic_seg_folga);
    formdataEscala.append("ic_folga_ter",ic_ter_folga);
    formdataEscala.append("ic_folga_qua",ic_qua_folga);
    formdataEscala.append("ic_folga_qui",ic_qui_folga);
    formdataEscala.append("ic_folga_sex",ic_sex_folga);
    formdataEscala.append("ic_folga_sab",ic_sab_folga);
    formdataEscala.append("ic_escala_dom",ic_dom);
    formdataEscala.append("ic_escala_seg",ic_seg);
    formdataEscala.append("ic_escala_ter",ic_ter);
    formdataEscala.append("ic_escala_qua",ic_qua);
    formdataEscala.append("ic_escala_qui",ic_qui);
    formdataEscala.append("ic_escala_sex",ic_sex);
    formdataEscala.append("ic_escala_sab",ic_sab);
    formdataEscala.append("hr_inicio_exp_dom",$("#hr_turno_dom").val());
    formdataEscala.append("hr_inicio_exp_seg",$("#hr_turno_seg").val());
    formdataEscala.append("hr_inicio_exp_ter",$("#hr_turno_ter").val());
    formdataEscala.append("hr_inicio_exp_qua",$("#hr_turno_qua").val());
    formdataEscala.append("hr_inicio_exp_qui",$("#hr_turno_qui").val());
    formdataEscala.append("hr_inicio_exp_sex",$("#hr_turno_sex").val());
    formdataEscala.append("hr_inicio_exp_sab",$("#hr_turno_sab").val());
    formdataEscala.append("hr_inicio_intervalo_dom",$("#hr_intervalo_dom").val());
    formdataEscala.append("hr_inicio_intervalo_seg",$("#hr_intervalo_seg").val());
    formdataEscala.append("hr_inicio_intervalo_ter",$("#hr_intervalo_ter").val());
    formdataEscala.append("hr_inicio_intervalo_qua",$("#hr_intervalo_qua").val());
    formdataEscala.append("hr_inicio_intervalo_qui",$("#hr_intervalo_qui").val());
    formdataEscala.append("hr_inicio_intervalo_sex",$("#hr_intervalo_sex").val());
    formdataEscala.append("hr_inicio_intervalo_sab",$("#hr_intervalo_sab").val());
    formdataEscala.append("hr_termino_intervalo_dom",$("#hr_intervalo_saida_dom").val());
    formdataEscala.append("hr_termino_intervalo_seg",$("#hr_intervalo_saida_seg").val());
    formdataEscala.append("hr_termino_intervalo_ter",$("#hr_intervalo_saida_ter").val());
    formdataEscala.append("hr_termino_intervalo_qua",$("#hr_intervalo_saida_qua").val());
    formdataEscala.append("hr_termino_intervalo_qui",$("#hr_intervalo_saida_qui").val());
    formdataEscala.append("hr_termino_intervalo_sex",$("#hr_intervalo_saida_sex").val());
    formdataEscala.append("hr_termino_intervalo_sab",$("#hr_intervalo_saida_sab").val());
    formdataEscala.append("hr_termino_expediente_dom",$("#hr_turno_dom_saida").val());
    formdataEscala.append("hr_termino_expediente_seg",$("#hr_turno_seg_saida").val());
    formdataEscala.append("hr_termino_expediente_ter",$("#hr_turno_ter_saida").val());
    formdataEscala.append("hr_termino_expediente_qua",$("#hr_turno_qua_saida").val());
    formdataEscala.append("hr_termino_expediente_qui",$("#hr_turno_qui_saida").val());
    formdataEscala.append("hr_termino_expediente_sex",$("#hr_turno_sex_saida").val());
    formdataEscala.append("hr_termino_expediente_sab",$("#hr_turno_sab_saida").val());
    formdataEscala.append("dt_cancelamento",$("#dt_cancelamento_agenda_escala").val());
    formdataEscala.append("ds_motivo_cancelamento",$("#ds_motivo_cancelamento").val());
    formdataEscala.append("obs",$("#obs").val());
    formdataEscala.append("colaboradores_pk",$("#colaborador_pk").val());

    $.ajax({
        type: 'POST',
        url: '/api/agenda_colaborador_padrao/salvar',
        data: formdataEscala,
        processData: false,
        contentType: false,
        complete: function (response) {
            try {
                var log = JSON.parse(response.responseText);
                if(log.status==true){
                    utilsJS.toastNotify(true,log.message);
                    $("#escala_agenda_pk").val(log.data);
                    $("#janela_escala").modal("hide");
                    fcCadastrarEscala();
                    fcRecarregarGridEscala();
                }
                else{
                    utilsJS.toastNotify(false,'Falhou a requisição para salvar o registro');
                }

            } catch (e) {
                utilsJS.toastNotify(false,'Falhou a requisição para salvar o registro');
            }
        }
    });
}

function fcCadastrarEscala() {
    var objParametros = {
        "agenda_colaborador_padrao_pk": $("#escala_agenda_pk").val(),
        "leads_pk": $("#escala_leads_pk").val(),
        "colaboradores_pk": $("#colaborador_pk").val(),
        "dt_periodo_ini": $("#dt_inicio_agenda").val(),
        "dt_periodo_fim": $("#dt_fim_agenda").val(),
        "tipo_escala_pk": $("#tipo_escala_pk").val(),
        "ds_escala": $('#tipo_escala_pk option:selected').text(),
    }

    var arrEnviar = carregarController("agenda_colaborador_padrao", "escalaDadosColaborador", objParametros);
    //NewWindow(v_last_url)
    if (arrEnviar.status == true) {
        $("#escala_agenda_pk").val("");
    } else {
        utilsJS.toastNotify(false,arrEnviar.result);
    }
}

function fcRecarregarGridEscala(){
    tblEscala.clear().destroy();
    fcCarregarGridEscala();
}

function fcLimparFormEscala(){
    $("#escala_agenda_pk").val("");

    $("#dt_inicio_agenda").val("");
    $("#dt_fim_agenda").val("");
    $("#escala_cargos_pk").val("");
    $("#escala_leads_pk").val("");
    $("#dt_cancelamento_agenda_escala").val("");
    $("#ds_motivo_cancelamento").val("");
    $("#tipo_escala_pk").val("");
    $("#exibir_variacao_escala").hide();
    $("#ic_variacao_dias_escala").val("");
    $("#ic_dom").prop("checked", false);
    $("#ic_seg").prop("checked", false);
    $("#ic_ter").prop("checked", false);
    $("#ic_qua").prop("checked", false);
    $("#ic_qui").prop("checked", false);
    $("#ic_sex").prop("checked", false);
    $("#ic_sab").prop("checked", false);
    $("#ic_dom_folga").prop("checked", false);
    $("#ic_seg_folga").prop("checked", false);
    $("#ic_ter_folga").prop("checked", false);
    $("#ic_qua_folga").prop("checked", false);
    $("#ic_qui_folga").prop("checked", false);
    $("#ic_sex_folga").prop("checked", false);
    $("#ic_sab_folga").prop("checked", false);
    $("#ic_dom").prop("disabled", false);
    $("#ic_seg").prop("disabled", false);
    $("#ic_ter").prop("disabled", false);
    $("#ic_qua").prop("disabled", false);
    $("#ic_qui").prop("disabled", false);
    $("#ic_sex").prop("disabled", false);
    $("#ic_sab").prop("disabled", false);
    $("#ic_dom_folga").prop("disabled", false);
    $("#ic_seg_folga").prop("disabled", false);
    $("#ic_ter_folga").prop("disabled", false);
    $("#ic_qua_folga").prop("disabled", false);
    $("#ic_qui_folga").prop("disabled", false);
    $("#ic_sex_folga").prop("disabled", false);
    $("#ic_sab_folga").prop("disabled", false);
    $("#dom_turnos_pk").val("");
    $("#seg_turnos_pk").val("");
    $("#ter_turnos_pk").val("");
    $("#qua_turnos_pk").val("");
    $("#qui_turnos_pk").val("");
    $("#sex_turnos_pk").val("");
    $("#sab_turnos_pk").val("");
    $("#hr_turno_dom").val("");
    $("#hr_turno_seg").val("");
    $("#hr_turno_ter").val("");
    $("#hr_turno_qua").val("");
    $("#hr_turno_qui").val("");
    $("#hr_turno_sex").val("");
    $("#hr_turno_sab").val("");
    $("#hr_turno_dom_saida").val("");
    $("#hr_turno_seg_saida").val("");
    $("#hr_turno_ter_saida").val("");
    $("#hr_turno_qua_saida").val("");
    $("#hr_turno_qui_saida").val("");
    $("#hr_turno_sex_saida").val("");
    $("#hr_turno_sab_saida").val("");
    $("#hr_intervalo_dom").val("");
    $("#hr_intervalo_seg").val("");
    $("#hr_intervalo_ter").val("");
    $("#hr_intervalo_qua").val("");
    $("#hr_intervalo_qui").val("");
    $("#hr_intervalo_sex").val("");
    $("#hr_intervalo_sab").val("");
    $("#hr_intervalo_saida_dom").val("");
    $("#hr_intervalo_saida_seg").val("");
    $("#hr_intervalo_saida_ter").val("");
    $("#hr_intervalo_saida_qua").val("");
    $("#hr_intervalo_saida_qui").val("");
    $("#hr_intervalo_saida_sex").val("");
    $("#hr_intervalo_saida_sab").val("");
    $("#turnos_pk").val("");
    $("#hr_inicio_expediente").val("");
    $("#hr_termino_expediente").val("");
    $("#hr_inicio_intervalo").val("");
    $("#hr_termino_intervalo").val("");
    $("#ic_intrajornada").prop("checked", false);
}

function fcAbrirFormNovoEscala(){

    //limpa os dados de qualquer registro existe
    fcLimparFormEscala();
    $("#janela_escala").modal('show');

}


function fcCarregarLead() {
    //Carrega os grupos

    var objParametros = {

    };

    var arrCarregar = carregarController("lead", "listarTodos", objParametros);
    carregarComboAjax($("#escala_leads_pk"), arrCarregar, " ", "pk", "ds_lead");

}
function fcCarregarTipoEscala() {
    //Carrega os grupos
    var objParametros = {
    };

    var arrCarregar = carregarController("tipo_escala", "listarTodos", objParametros);
    carregarComboAjax($("#tipo_escala_pk"), arrCarregar, " ", "pk", "ds_tipo_escala");
}
function fcIntrajornada(){
    if ($('#ic_intrajornada').is(":checked")) {
        $('#hr_inicio_intervalo').val(" ")
        $('#hr_termino_intervalo').val(" ")
        $("#hr_termino_intervalo").attr('disabled','disabled');
        $("#hr_inicio_intervalo").attr('disabled','disabled');

        $('#hr_intervalo_dom').val(" ")
        $('#hr_intervalo_seg').val(" ")
        $('#hr_intervalo_ter').val(" ")
        $('#hr_intervalo_qua').val(" ")
        $('#hr_intervalo_qui').val(" ")
        $('#hr_intervalo_sex').val(" ")
        $('#hr_intervalo_sab').val(" ")
        $("#hr_intervalo_dom").attr('disabled','disabled');
        $("#hr_intervalo_seg").attr('disabled','disabled');
        $("#hr_intervalo_ter").attr('disabled','disabled');
        $("#hr_intervalo_qua").attr('disabled','disabled');
        $("#hr_intervalo_qui").attr('disabled','disabled');
        $("#hr_intervalo_sex").attr('disabled','disabled');
        $("#hr_intervalo_sab").attr('disabled','disabled');

        $('#hr_intervalo_saida_dom').val(" ")
        $('#hr_intervalo_saida_seg').val(" ")
        $('#hr_intervalo_saida_ter').val(" ")
        $('#hr_intervalo_saida_qua').val(" ")
        $('#hr_intervalo_saida_qui').val(" ")
        $('#hr_intervalo_saida_sex').val(" ")
        $('#hr_intervalo_saida_sab').val(" ")
        $("#hr_intervalo_saida_dom").attr('disabled','disabled');
        $("#hr_intervalo_saida_seg").attr('disabled','disabled');
        $("#hr_intervalo_saida_ter").attr('disabled','disabled');
        $("#hr_intervalo_saida_qua").attr('disabled','disabled');
        $("#hr_intervalo_saida_qui").attr('disabled','disabled');
        $("#hr_intervalo_saida_sex").attr('disabled','disabled');
        $("#hr_intervalo_saida_sab").attr('disabled','disabled');
    }else{
        $("#hr_termino_intervalo").removeAttr('disabled');
        $("#hr_inicio_intervalo").removeAttr('disabled');

        $("#hr_intervalo_dom").removeAttr('disabled');
        $("#hr_intervalo_seg").removeAttr('disabled');
        $("#hr_intervalo_ter").removeAttr('disabled');
        $("#hr_intervalo_qua").removeAttr('disabled');
        $("#hr_intervalo_qui").removeAttr('disabled');
        $("#hr_intervalo_sex").removeAttr('disabled');
        $("#hr_intervalo_sab").removeAttr('disabled');

        $("#hr_intervalo_saida_dom").removeAttr('disabled');
        $("#hr_intervalo_saida_seg").removeAttr('disabled');
        $("#hr_intervalo_saida_ter").removeAttr('disabled');
        $("#hr_intervalo_saida_qua").removeAttr('disabled');
        $("#hr_intervalo_saida_qui").removeAttr('disabled');
        $("#hr_intervalo_saida_sex").removeAttr('disabled');
        $("#hr_intervalo_saida_sab").removeAttr('disabled');
    }
}

function fcPreenchimentoAutomatico() {
    //VERIFICA SE AS INFORMAÇÕES NECESSÁRIAS ESTÃO MARCADAS
    if ($("#turnos_pk").val() == "") {
        sweetMensagem('warning',"Por favor, selecione o turno para o preenchimento automático!");
        $("#ic_preenchimento_automatico").prop("checked", false);
        $("#turnos_pk").focus();
        return false;
    }
    if ($("#hr_inicio_expediente").val() == "") {
        sweetMensagem('warning',"Por favor, informe horário de início do expediente!");
        $("#ic_preenchimento_automatico").prop("checked", false);
        $("#hr_inicio_expediente").focus();
        return false;
    }
    if ($("#hr_termino_expediente").val() == "") {
        sweetMensagem('warning',"Por favor, informe horário de termino do expediente!");
        $("#ic_preenchimento_automatico").prop("checked", false);
        $("#hr_termino_expediente").focus();
        return false;
    }
    //PRENCHIMENTO DE TURNO
    if ($("#dias_escala_servico").val() == '12x36') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", true);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", true);
        $("#ic_sex_folga").prop("checked", false);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", false);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", false);
        $("#ic_sex").prop("checked", true);
        $("#ic_sab").prop("checked", false);

    } else if ($("#dias_escala_servico").val() == '6x1') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", false);
        $("#ic_sex_folga").prop("checked", false);
        $("#ic_sab_folga").prop("checked", false);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", true);
        $("#ic_sex").prop("checked", true);
        $("#ic_sab").prop("checked", true);
    } else if ($("#dias_escala_servico").val() == '5D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", false);
        $("#ic_sex_folga").prop("checked", false);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", true);
        $("#ic_sex").prop("checked", true);
        $("#ic_sab").prop("checked", false);
    } else if ($("#dias_escala_servico").val() == '4D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", false);
        $("#ic_sex_folga").prop("checked", false);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", true);
        $("#ic_sex").prop("checked", true);
        $("#ic_sab").prop("checked", false);
    } else if ($("#dias_escala_servico").val() == '3D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", true);
        $("#ic_sex_folga").prop("checked", true);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", false);
        $("#ic_sex").prop("checked", false);
        $("#ic_sab").prop("checked", false);
    } else if ($("#dias_escala_servico").val() == '2D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", true);
        $("#ic_qui_folga").prop("checked", true);
        $("#ic_sex_folga").prop("checked", true);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", false);
        $("#ic_qui").prop("checked", false);
        $("#ic_sex").prop("checked", false);
        $("#ic_sab").prop("checked", false);
    } else if ($("#dias_escala_servico").val() == '1D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", true);
        $("#ic_qua_folga").prop("checked", true);
        $("#ic_qui_folga").prop("checked", true);
        $("#ic_sex_folga").prop("checked", true);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", false);
        $("#ic_qua").prop("checked", false);
        $("#ic_qui").prop("checked", false);
        $("#ic_sex").prop("checked", false);
        $("#ic_sab").prop("checked", false);
    }


    //TURNOS
    $("#dom_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#seg_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#ter_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#qua_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#qui_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#sex_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#sab_turnos_pk").val($("#turnos_pk option:selected").val());
    //HORARIO ENTRATDA EXPEDIENTE
    $("#hr_turno_dom").val($("#hr_inicio_expediente").val());
    $("#hr_turno_seg").val($("#hr_inicio_expediente").val());
    $("#hr_turno_ter").val($("#hr_inicio_expediente").val());
    $("#hr_turno_qua").val($("#hr_inicio_expediente").val());
    $("#hr_turno_qui").val($("#hr_inicio_expediente").val());
    $("#hr_turno_sex").val($("#hr_inicio_expediente").val());
    $("#hr_turno_sab").val($("#hr_inicio_expediente").val());
    //HORARIO SAIDA INTERVALO
    $("#hr_intervalo_dom").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_seg").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_ter").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_qua").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_qui").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_sex").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_sab").val($("#hr_inicio_intervalo").val());
    //HORARIO RETORNO INTERVALO
    $("#hr_intervalo_saida_dom").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_seg").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_ter").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_qua").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_qui").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_sex").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_sab").val($("#hr_termino_intervalo").val());
    //HORARIO SAIDA EXPEDIENTE
    $("#hr_turno_dom_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_seg_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_ter_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_qua_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_qui_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_sex_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_sab_saida").val($("#hr_termino_expediente").val());
}

function fecharModalEscala(){
    $("#janela_escala").modal("hide");
}

function fcFormatarDadosEscala(){

    try{
        var escalaPk = "";

        var arrKeys = [];
        var arrDados = [];
        arrKeys[0] = "escala_pk";

        var  data = tblEscala.rows().data();
        for(i = 0; i< data.length; i++) {
            escalaPk = data[i]['pk'];

            arrDados[i] = [escalaPk];
        }
        return arrayToJson(arrKeys, arrDados);
    }
    catch (err) {
        utilsJS.toastNotify(false, err);
    }
}

// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
//Inicio das funcoes da tela de DOCUMETOS (Modal).
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------

function fcCarregarGridDocumentos(){
    var objParametros = {
        "colaborador_pk": $("#colaborador_pk").val()
    };

    var v_url = routes_api("documento", "listarDocumentosColaborador", objParametros);
    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        searching: false,
        paging: false,
        pageLength: 10,
        aLengthMenu: [10, 25, 50, 100],
        iDisplayLength: 10,
        processing: false,
        serverSide: false,
        ajax: v_url,
        responsive: true,
        scrollX: true,
        language: {
            emptyTable: "Não existem Dados cadastrados"
        },
        order: [
            [0, "asc"]
        ],
        columns: [
            {
                mRender: function (data, type, full) {
                    return full['pk'];
                },
                'orderable': true,
                'searchable': false,
                width: '80px'

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_documento'];
                },
                'orderable': true,
                'searchable': false,
                width: '80px'

            },
            {
                mRender: function (data, type, full) {
                    var buttonDelete = "<i class='fa fa-download function_download' style='font-size:12px; color:blue' title='DOWNLOAD DOCUMENTO'></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-trash function_delete' style='font-size:12px; color:black' title='EXCLUIR O DOCUMENTO'></i>";
                    return  buttonDelete;
                },
                'orderable': false,
                'searchable': false,
                width: '80px'
            }
        ]
    });
    $('#tblDocumentos tbody').on('click', '.function_download', function () {
        var data;

        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        fcDownloadDocumento(data['pk'],data['ds_documento']);
    });
    $('#tblDocumentos tbody').on('click', '.function_delete', function () {
        var data;

        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }

        if(data['pk'] != ""){
            fcExcluirDocumento(data['pk']);
        }
    });
}

function fcDownloadDocumento(pk,ds_documento){
    var arrCarregar = permissao("documento", "ins");

    if (arrCarregar.status != true){
        utilsJS.toastNotify(false,'Você não tem permissão');
        return false;
    }

    //var url_documento = (window.location.protocol+"//"+window.location.host+"/app/src/docs/"+ds_documento)

    //DOWNLOAD
    var v_url = "/documento/download?pk="+pk+"&ds_documento="+ds_documento;

    window.open(v_url, '_blank');
}

function fcExcluirDocumento(v_pk){
    var arrCarregar = permissao("documento", "del");

    if (arrCarregar.status != true){
        utilsJS.toastNotify(false,'Você não tem permissão');
        return false;
    }
    if(v_pk != ""){

        var objParametros = {
            "pk": v_pk
        };

        var arrExcluir = carregarController("documento", "excluir", objParametros);

        if (arrExcluir.status == true){

            //Exibe a mensagem
            utilsJS.toastNotify(true,arrExcluir.message);
            tblDocumentos.clear().destroy();
            fcCarregarGridDocumentos();
        }
        else{
            utilsJS.toastNotify(false,'Falhou a requisição de exclusão.');
        }
    }
    else{
        utilsJS.toastNotify(false,'Código não encontrado');
    }
}

function fcAbrirFormNovoDocumento(){
    var arrCarregar = permissao("documento", "ins");

    if (arrCarregar.status != true){
        utilsJS.toastNotify(false,'Você não tem permissão');
        return false;
    }
    tblArquivos.clear().destroy();
    fcCarregarGridArquivos();
    $("#janela_documentos").modal("show");
}

function fcValidarDocumentos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() == "Não existem Dados cadastrados"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    }
    else{
        $("#janela_documentos").modal("hide");
        utilsJS.toastNotify(true,"Documentos salvos com sucesso!");
        tblDocumentos.clear().destroy();
        fcCarregarGridDocumentos();
    }

}

function fcCarregarGridArquivos(){
    try {

        tblArquivos = $("#tblArquivos").DataTable(
            {
                "searching": false,
                "paging": false,
                "scrollX": true,
                "columnDefs" : [{
                    orderable: false,
                    targets: [0,1]
                }]
            }
        );
        return false;
    } catch (error) {
        utilsJS.toastNotify(false,error);
    }
}
//COMEÇO DOCUMENTOS UPLOAD

function fcAlterarNomeArquivo(v_arquivo){

    var objParametros = {
        "colaborador_pk": $("#colaborador_pk").val(),
        "ds_arquivo": v_arquivo
    };

    var arrEnviar = carregarController("documento", "renomearArquivo", objParametros);

    if (arrEnviar.status == true){
        // Reload datable

    }
    else{
        utilsJS.toastNotify(false,'Falhou a requisição para salvar o registro');
    }
}

function fcApagarArquivo(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').click(function () {
        var colunas = $(this).children();
    });

    tblArquivos.row($(this).parents('tr')).remove().draw();
}

function fcCancelarEnvioDocumento(){
    $("#janela_documentos").modal("hide");
}


function fcIncluirLinhaArquivo(nome_original){
    tblArquivos.row.add(
        [   "",
            nome_original
        ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcApagarArquivo);
    return false;
}


function fcFormatarDadosArquivos(){

    var dsDocumento = "";

    var arrKeys = [];
    arrKeys[0] = "ds_documento";

    var arrDados = [];
    var i = 0;
    $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
        dsDocumento =  $(colunas[1]).text();
        arrDados[i] = [dsDocumento];
        i++;
    });

    return arrayToJson(arrKeys, arrDados);

}
function fcSalvarDocumentos(formdata){

    var url = "";


    url = "/documento/salvarDocumento";


    var request = $.ajax({
        url:          url,
        data:         formdata,
        processData:  false,
        cache:        false,
        async:        false,
        dataType:     'json',
        contentType:  false,
        type:         'post'
    });
    request.done(function(output){
        if (output.status == true){
        }else{
            utilsJS.toastNotify(false, 'Falhou a requisição: '+output.message);
        }
    });
    request.fail(function(jqXHR, textStatus){
        utilsJS.toastNotify(false, 'Falhou a requisição: '+textStatus);
    });

}
function fcFormatarDadosDocumentos(){

    var pk = "";

    var arrKeys = [];
    arrKeys[0] = "pk";

    var arrDados = [];
    var i = 0;
    $('#tblDocumentos tbody tr').each(function () {
        var colunas = $(this).children();
        pk =  $(colunas[0]).text();
        arrDados[i] = [pk];
        i++;
    });

    return arrayToJson(arrKeys, arrDados);

}
let c = 0;
$(document).ready(function(){
    /*var arrCarregar = permissao("lead", "ins");

    if (arrCarregar.status != true){
        utilsJS.toastNotify(false, 'Você não tem permissão para acessar essa pagina!');
        setTimeout(function() {
            sendPost('menu','principal',{})
        }, 2000);
        return false;
    }*/

    fcCarregarGrupoColaborador();



    $(".mask_hour").mask('99:99');



    $("#dados-tab").click(function(){
        $("#dados-tab").removeClass();
        $("#dados-tab").addClass('nav-link active');

        $("#funcao-tab").removeClass();
        $("#funcao-tab").addClass('nav-link');

        $("#escala-tab").removeClass();
        $("#escala-tab").addClass('nav-link');

        $("#ocorrencia-tab").removeClass();
        $("#ocorrencia-tab").addClass('nav-link');

        $("#documento-tab").removeClass();
        $("#documento-tab").addClass('nav-link');

        $("#dados").removeClass();
        $("#dados").addClass('tab-pane fade show active');

        $("#funcao").removeClass();
        $("#funcao").addClass('tab-pane fade');

        $("#escala").removeClass();
        $("#escala").addClass('tab-pane fade');

        $("#ocorrencia").removeClass();
        $("#ocorrencia").addClass('tab-pane fade');

        $("#documento").removeClass();
        $("#documento").addClass('tab-pane fade');
    });

    $("#funcao-tab").click(function(){

        $("#dados-tab").removeClass();
        $("#dados-tab").addClass('nav-link ');

        $("#funcao-tab").removeClass();
        $("#funcao-tab").addClass('nav-link active');

        $("#escala-tab").removeClass();
        $("#escala-tab").addClass('nav-link');

        $("#ocorrencia-tab").removeClass();
        $("#ocorrencia-tab").addClass('nav-link');

        $("#documento-tab").removeClass();
        $("#documento-tab").addClass('nav-link');

        $("#dados").removeClass();
        $("#dados").addClass('tab-pane fade ');

        $("#funcao").removeClass();
        $("#funcao").addClass('tab-pane fade show active');

        $("#escala").removeClass();
        $("#escala").addClass('tab-pane fade');

        $("#ocorrencia").removeClass();
        $("#ocorrencia").addClass('tab-pane fade');

        $("#documento").removeClass();
        $("#documento").addClass('tab-pane fade');
        if(c==0){
            fcRecarregarGridFuncao();
            c++;
        }
    });

    $("#escala-tab").click(function(){
        $("#dados-tab").removeClass();
        $("#dados-tab").addClass('nav-link ');

        $("#funcao-tab").removeClass();
        $("#funcao-tab").addClass('nav-link ');

        $("#escala-tab").removeClass();
        $("#escala-tab").addClass('nav-link active');

        $("#ocorrencia-tab").removeClass();
        $("#ocorrencia-tab").addClass('nav-link');

        $("#documento-tab").removeClass();
        $("#documento-tab").addClass('nav-link');

        $("#dados").removeClass();
        $("#dados").addClass('tab-pane fade ');

        $("#funcao").removeClass();
        $("#funcao").addClass('tab-pane fade ');

        $("#escala").removeClass();
        $("#escala").addClass('tab-pane fade show active');

        $("#ocorrencia").removeClass();
        $("#ocorrencia").addClass('tab-pane fade');

        $("#documento").removeClass();
        $("#documento").addClass('tab-pane fade');

        fcRecarregarGridEscala();
    });

    $("#ocorrencia-tab").click(function(){
        $("#dados-tab").removeClass();
        $("#dados-tab").addClass('nav-link ');

        $("#funcao-tab").removeClass();
        $("#funcao-tab").addClass('nav-link ');

        $("#escala-tab").removeClass();
        $("#escala-tab").addClass('nav-link ');

        $("#ocorrencia-tab").removeClass();
        $("#ocorrencia-tab").addClass('nav-link active');

        $("#documento-tab").removeClass();
        $("#documento-tab").addClass('nav-link');

        $("#dados").removeClass();
        $("#dados").addClass('tab-pane fade ');

        $("#funcao").removeClass();
        $("#funcao").addClass('tab-pane fade ');

        $("#escala").removeClass();
        $("#escala").addClass('tab-pane fade');

        $("#ocorrencia").removeClass();
        $("#ocorrencia").addClass('tab-pane fade  show active');

        $("#documento").removeClass();
        $("#documento").addClass('tab-pane fade');
    });

    $("#documento-tab").click(function(){
        $("#dados-tab").removeClass();
        $("#dados-tab").addClass('nav-link ');

        $("#funcao-tab").removeClass();
        $("#funcao-tab").addClass('nav-link ');

        $("#escala-tab").removeClass();
        $("#escala-tab").addClass('nav-link ');

        $("#ocorrencia-tab").removeClass();
        $("#ocorrencia-tab").addClass('nav-link ');

        $("#documento-tab").removeClass();
        $("#documento-tab").addClass('nav-link active');

        $("#dados").removeClass();
        $("#dados").addClass('tab-pane fade ');

        $("#funcao").removeClass();
        $("#funcao").addClass('tab-pane fade ');

        $("#escala").removeClass();
        $("#escala").addClass('tab-pane fade');

        $("#ocorrencia").removeClass();
        $("#ocorrencia").addClass('tab-pane fade');

        $("#documento").removeClass();
        $("#documento").addClass('tab-pane fade show active');

        tblDocumentos.clear().destroy();
        fcCarregarGridDocumentos();
    });

    //Atribui os eventos - Leads
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdEnviarTudo', fcValidarForm);
    $(document).on('click', '#cmdCancelar2', fcCancelar);
    $(document).on('click', '#cmdEnviarTudo2', fcValidarForm);


    //atribui mascara aos campos - Lead
    fcCarregarBancos();
    $('#dt_nascimento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#ds_cel").keypress(function(){
        mascara(this,mascaraTelefone);
    });
    $("#dt_nascimento").keypress(function(){
        mascara(this,mdata);
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


    $("#ds_cep").keypress(function(){
        mascara(this,cep);
    });

    $("#ds_cpf").keypress(function(){
        chama_mascara(this);
    });






    if($("#ic_status").val()==""){
        $("#ic_status").val(2);
    }

    //---------------------------------------------
    //atribui mascara aos campos

    $("#ds_tel").on('keypress', function () {
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
    fcCarregar();
    $(".chzn-select").chosen({allow_single_deselect: true});

    //FUNÇÃO
    fcCarregarGridFuncao();
    fcCarregarFuncao();
    $(document).on('click', '#btn_modal_funcao', fcAbrirFormNovoFuncao);
    $(document).on('click', '#cmdEnviarFuncao', fcEnviarFuncao);

    //ESCALA
    fcCarregarGrupoLeads();
    fcCarregarGridEscala();
    fcCarregarLead();


    $('#dt_inicio_agenda').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

    $("#dt_inicio_agenda").keypress(function(){
        mascara(this,mdata);
    });

    $('#dt_fim_agenda').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

    $("#dt_fim_agenda").keypress(function(){
        mascara(this,mdata);
    });
    $('#dt_cancelamento_agenda_escala').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

    $("#dt_cancelamento_agenda_escala").keypress(function(){
        mascara(this,mdata);
    });

    $("#hr_inicio_expediente").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_termino_expediente").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_inicio_intervalo").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_termino_intervalo").keypress(function () {
        mascara(this, horamask);
    });

    $('#ic_preenchimento_automatico').click(function () {
        fcPreenchimentoAutomatico();//FUNÇÃO DE PREENCHIMENTO AUTOMATICO
    });
    $('#tipo_escala_pk').change(function () {
        if($('#tipo_escala_pk option:selected').text()=="12X36"){
            $("#exibir_variacao_escala").show()
        }
        else{
            $("#exibir_variacao_escala").hide();
        }
    });
    $('#escala_leads_pk').change(function () {
        fcCarregarFuncaoEscala();
    });

    fcCarregarTipoEscala();

    $(document).on('click', '#ic_intrajornada', fcIntrajornada);
    $(document).on('click', '#btn_modal_escala', fcAbrirFormNovoEscala);
    $(document).on('click', '#cmdEnviarEscala', fcEnviarEscala);



    //DOCUMENTOS
    $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);

    //carrega dados da grid de documentos
    fcCarregarGridDocumentos();

    formdataDocs = new FormData();
    $('#fileupload').change(function(){
        //on change event
        if($(this).prop('files').length > 0){
            $.each($(this).prop('files'), function (index, file) {
                formdataDocs.append(index, file);
                formdataDocs.append("ds_nome_documento", file.name);
                formdataDocs.append("colaborador_pk", $("#colaborador_pk").val());
                formdataDocs.append("leads_pk", 0);
                fcSalvarDocumentos(formdataDocs);

                fcAlterarNomeArquivo(file.name);
                fcIncluirLinhaArquivo(file.name);
            });

        }
    });
    $(document).on('click', '#cmdCancelarDocumento', fcCancelarEnvioDocumento);
    $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);

    fcCarregarGridArquivos();

    formdataEscala = new FormData();
    formdataDocs = new FormData();

});
var formdataEscala = null;
var formdataDocs = null;
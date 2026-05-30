var tblResultado;
function fcPesquisar(){

    tblResultado.clear().destroy();
    fcCarregarGrid();

}

function fcIncluir(){

    sendPost('colaborador_cad_form.php',{token: token, pk: ''});

}

function fcExcluir(v_pk, v_ds_colaborador){
    if (confirm("Deseja realmente excluir o registro '" + v_ds_colaborador + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("colaborador", "excluir", objParametros);
           
            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcEditar(v_pk){
    sendPost('menu_colaborador_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarQualificacao(){

    var objParametros = {
        "pk": ""

    };

    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);
    carregarComboAjax($("#produtos_servicos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}
function fcCarregarGrid(){

        var ic_reserva = "";
        if($('#ic_reserva').is(":checked")){
                ic_reserva = 1;
        }
    var objParametros = {
        "pk": $("#colaborador_pk").val(),
        "ic_status": $("#ic_status").val(),
        "leads_pk": $("#leads_pk").val(),
        "leads_usuarios_pk": $("#leads_usuarios_pk").val(),
        "ic_origem": $("#ic_origem").val(),
        "ds_pin": $("#ds_pin").val(),
        "generos_pk": $("#generos_pk").val(),
        "ds_re": $("#ds_re").val(),
        "ic_status_app": $("#ic_status_app").val(),
        "ic_reserva": ic_reserva,
        "produtos_servicos_pk": $("#produtos_servicos_pk").val()
    };

    var v_url = montarUrlController("colaborador", "listarGridColaboradorMenuCliente", objParametros);
   //NewWindow(v_last_url)
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 src='../img/whatsapp.png'></span></a>"
            },
            {"targets": -2, "data": "t_ds_funcao"},            
            {"targets": -3, "data": "t_ds_cel2"},            
            {"targets": -4, "data": "t_ic_status"}, 
            {"targets": -5, "data": "t_ic_origem"},
            {"targets": -6, "data": "ds_status_app"}, 
            {"targets": -7, "data": "t_ds_cel"},
            {"targets": -8, "data": "t_ds_re"},
            {"targets": -9, "data": "t_ds_pin"},
            {"targets": -10, "data": "t_ds_colaborador"},
            {"targets": -11, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });


    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcEditar(data['t_pk']);

    } );


    $('#tblResultado tbody').on('click', '.function_painel', function () {
	        var data;

	        if(tblResultado.row( $(this).parents('li') ).data()){
	            data = tblResultado.row( $(this).parents('li') ).data();
	        }
	        else if(tblResultado.row( $(this).parents('tr') ).data()){
	            data = tblResultado.row( $(this).parents('tr') ).data();
	        }
	        if(data['t_ic_whatsapp']=="Sim"){
	            fcAbrirMensagemWhatsAppTel(data);
	        }


    } );

}
function fcAbrirMensagemWhatsAppTel(objRegistro){
    var str =  objRegistro['t_ds_cel'];
    var telefone = str.replace(/[^\d]+/g,'');
    var url = "https://api.whatsapp.com/send?phone=55"+telefone+"&text=Olá"

    window.open(url, '_blank');
}

function fcCarregarGenero(){
    //Carrega os grupos
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("genero", "listarTodos", objParametros); 
    
    carregarComboAjax($("#generos_pk"), arrCarregar, " ", "pk", "ds_genero");
    
}
function fcCarregarLeads(){
    //Carrega os grupos
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
    
}
function fcCarregarColaborador(){
    //Carrega os grupos
    
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "leads_usuarios_pk": $("#leads_usuarios_pk").val()
    };      
    
    var arrCarregar = carregarController("colaborador", "listarColaboradorLeadMenuCliente", objParametros); 

    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");
    
}
function fcListarLeadsPkUsuarioLogado(){
    var objParametros = {
            "pk": ""
        };        
        
        var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros);
        
        if (arrCarregar.result == 'success'){
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $(".ds_usuario").text(arrCarregar.data[0]['ds_usuario']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
}

function fcCarregarLeads(){
    //Carrega os grupos
     
    var objParametros = {
        "leads_pk_pai": $("#leads_pk").val()
    };      
    
    var arrCarregar = carregarController("lead", "listaLeadsClientesPK", objParametros); 
    carregarComboAjax($("#leads_usuarios_pk"), arrCarregar, " ", "pk", "ds_lead");    
}
$(document).ready(function(){

    //faz a carga inicial do grid.
    fcListarLeadsPkUsuarioLogado();
    fcCarregarLeads();
    fcCarregarGenero();
    
    fcCarregarQualificacao();
    
    fcCarregarColaborador();
    
   $("#leads_usuarios_pk").change(function(){
        $(".chzn-select").chosen('destroy');   
        //tblResultado.clear();    
       fcCarregarColaborador();      
    });
    
    
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    fcCarregarGrid();
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);

});



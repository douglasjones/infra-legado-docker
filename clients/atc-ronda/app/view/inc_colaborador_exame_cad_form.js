var tblExames;
function fcCarregarGridExames(){

    var objParametros = {
        "polos_pk": pk
    };     
    
    var v_url = montarUrlController("colaboradores_exames", "listarTodos", objParametros);

    //Trata a tabela
    tblExames = $('#tblExames').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": true, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },              
           {"targets": -2, "data": "ic_status_exames"},
           {"targets": -3, "data": "dt_exame"},           
           {"targets": -4, "data": "dt_prevista"},
           {"targets": -5, "data": "exames_pk"},
           {"targets": -6, "data": "pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });   
    
    //Atribui os eventos na coluna ação.
    $('#tblExames tbody').on('click', '.function_edit', function () {
        var data;    
     
    } );   
    
    $('#tblExames tbody').on('click', '.function_delete', function () {
        var data;
        
    } ); 
    
    return false;
}

function fcValidarForm(){  
    $("#form_exames").validate({
        rules :{
            exames_pk:{
                required:true         
            },
            dt_prevista:{
                required:true
            }
        },
        messages:{
            exames_pk:{
                required:"Por favor, selecione o exame "                
            },
            dt_prevista:{
                required:"Por favor, informe a data prevista"                
            }
        },
        submitHandler: function(form){
            fcEnviarExame(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}
function fcEnviarExame(){

    if(pk == ""){

       if($("#acao").val() == "ins"){   
           fcIncluirExamesSemPk();
       }else if($("#acao").val() == "upd"){
           fcEditarExamesSemPk();
       }
   }else{
       fcSalvarExames();
   }   
   $("#janela_exames").modal("hide");
}

function fcIncluirExamesSemPk(){
    tblExames.row.add(        
        {            
            "pk":"",
            "exames_pk":$("#exames_pk option:selected").text(),
            "dt_prevista":$("#dt_prevista").val(),
            "dt_exame":$("#dt_exame").val(),
            "ic_status_exames":$("#ic_status_exames option:selected").text(),
            "t_functions":""
        }
    ).draw();    
    return false;
}


function fcSalvarExames(){

    var v_exames_pk = $("#exames_pk").val();
    var v_dt_prevista = $("#dt_prevista").val();
    var v_dt_exame = $("#dt_exame").val();
    var v_ic_status = $("#ic_status").val();
    var v_obs = $("#obs").val();
    var v_colaborador_pk = $("#colaborador_pk").val();

    var objParametros = {
        "pk": pk,
        "exames_pk": encodeURIComponent(v_exames_pk),
        "dt_prevista": encodeURIComponent(v_dt_prevista),
        "dt_exame": encodeURIComponent(v_dt_exame),
        "ic_status": encodeURIComponent(v_ic_status),
        "obs": encodeURIComponent(v_obs),
        "colaborador_pk": encodeURIComponent(v_colaborador_pk)        
    };    

    var arrEnviar = carregarController("colaboradores_exames", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("colaboradores_exames_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}


function fcCarregar(){

    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("colaboradores_exames", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#exames_pk").val(arrCarregar.data[0]['exames_pk']);
            $("#dt_prevista").val(arrCarregar.data[0]['dt_prevista']);
            $("#dt_exame").val(arrCarregar.data[0]['dt_exame']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#obs").val(arrCarregar.data[0]['obs']);
            $("#colaborador_pk").val(arrCarregar.data[0]['colaborador_pk']);

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcAbrirFormNovoExame(){

    //limpa os dados de qualquer registro existe
    fcLimparFormExame();
    
    $("#janela_exames").modal();
    $("#acao").val("ins");
    $("#exames_pk").val("");
}

function  fcLimparFormExame(){
    $("#acao").val("");
    $("#exames_pk").val("");
    $("#dt_prevista").val("");
    $("#dt_exame").val("");
    $("#ic_status").val("");
    $("#obs").val("");
    //$("#ic_status_operador").val("");      
}

$(document).ready(function(){
    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdIncluirExames', fcAbrirFormNovoExame); 

    $('#dt_prevista').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#dt_prevista").keypress(function(){
       mascara(this,mdata);
    });
    $("#dt_prevista").keypress(function(){
       mascara(this,horamask);
    });

    $('#dt_exame').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#dt_exame").keypress(function(){
       mascara(this,mdata);
    });
    $("#dt_exame").keypress(function(){
       mascara(this,horamask);
    });
    fcCarregarGridExames();

    //Atribui a validação do formulário dos campos obrigatórios
    fcValidarForm();

    //Verifica se o registro é para alteracao e puxa os dados.
    //cCarregar();        
        
});


var tblAgenda;
function fcIncluiragenda(){
    sendPost('agenda_cad_form.php',{token: token, pk: ''});
}

function fcExcluirAgenda(v_pk){
    /*var arrCarregar = permissao("agenda", "del");  
    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }*/

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){
            alert(v_pk)

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("agenda", "excluir", objParametros);

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblAgenda.ajax.reload();

            }else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcCarregarGridAgenda(){   
    
    try {
        var objParametros = {
            "leads_pk": leads_pk
        };     
        var v_url = montarUrlController("agenda", "listarDataTable", objParametros);
        //NewWindow(v_last_url)
        //Trata a tabela
        tblAgenda = $('#tblAgenda').DataTable({
            "scrollX": true,
            "ajax": { "url": v_url, "type": "POST" },
            "ordering": false,
            "responsive": false,
            "searching": true,
            "paging": true,
            "bFilter": true,
            "bInfo": true,
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<a class='function_edit'><span><i class='bi bi-pencil-square' style='font-size:18px; color:black' title='EDITAR O LEAD'></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR O LEAD'></i></span></a>"
                },
                
                {"targets": -2, "data": "t_ds_obs"}, 
                {"targets": -3, "data": "t_ds_status"}, 
                {"targets": -4, "data": "t_dt_cadastro"},
                {"targets": -5, "data": "t_ds_usuario"},
                {"targets": -6, "data": "t_dt_ini_agenda_ini"},
                {"targets": -7, "data": "t_ds_tipo_agendas"},
                {"targets": -8, "data": "t_pk"} 
    
            ],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
            }
        });
        $('#tblAgenda tbody').on('click', '.function_delete', function () {
            var data;
            
            if(tblAgenda.row( $(this).parents('li') ).data()){
                data = tblAgenda.row( $(this).parents('li') ).data();
            }
            else if(tblAgenda.row( $(this).parents('tr') ).data()){
                data = tblAgenda.row( $(this).parents('tr') ).data();
            }
            
            if(data['t_pk'] != ""){
                fcExcluirAgenda(data['t_pk']);
            }
        } );
        
        $('#tblAgenda tbody').on('click', '.function_edit', function () {
            var data;
            
            rLinhaSelecionada = null;
            
            if(tblAgenda.row( $(this).parents('li')).data()){
                data = tblAgenda.row( $(this).parents('li')).data();
                rLinhaSelecionada = $(this).parents('li');
            }
            else if(tblAgenda.row( $(this).parents('tr')).data()){
                data = tblAgenda.row( $(this).parents('tr')).data();
                rLinhaSelecionada = $(this).parents('tr');
            } 
            fcAbrirFormAgenda(data['t_pk'], "", "inserir", leads_pk);  
        } ); 
    } catch (error) {
        alert(error)
    }
  
}



function fcCarregarInfoAgenda(){
    if(leads_pk > 0){
        var objParametros = {
            "pk": leads_pk
        }; 
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        
        $("#ds_lead_titulo_agenda").html("<b>"+arrCarregar.data[0]['ds_lead']+"</b>");
        $("#id_lead_agenda").html("Cód Lead: "+arrCarregar.data[0]['pk']);
        $("#dt_cadastro_lead_agenda").html("Dt de Cad: "+arrCarregar.data[0]['dt_cadastro']);
        $("#dt_ult_atualizacao_lead_agenda").html("Dt Utl atualização: "+arrCarregar.data[0]['dt_ult_atualizacao']);
        $("#ds_usuario_cadastro_agenda").html("Usuário de Cad: "+arrCarregar.data[0]['ds_usuario_cadastro']);
    }
}

$(document).ready(function(){
    /*var arrCarregar = permissao("agenda", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }*/
    
    //faz a carga inicial do grid.
    fcCarregarGridAgenda();
    fcCarregarInfoAgenda();

    //Atribui os eventos dos demais controles
    $("#cmdIncluirAgenda").click(function(){
        fcAbrirFormAgenda("", "", "inserir", leads_pk);
    });
    
});



function fcCancelarProcesso(){

    sendPost("lead_main_form.php", {token: token,pk:leads_pk});
}

function fcCarregar(){

    if(pk > 0){
        var objParametros = {
            "pk": pk,
        };       
        
        var arrCarregar = carregarController("processo", "listarPk", objParametros);
 
        if (arrCarregar.result == 'success'){
            
            $("#ds_processo").text(arrCarregar.data[0]['ds_processo']);  
            $(".leads_pk_cad").text(leads_pk);
            $(".ds_lead_cad").text(arrCarregar.data[0]['ds_lead']);
            $(".status_lead").text(arrCarregar.data[0]['ds_classificacao_processo']);
        }else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcCarregarEtapasProcesso(){

    var objParametros = {
        "pk": pk
    };        

    var arrCarregar = carregarController("processo", "listarEtapas", objParametros);

    if (arrCarregar.result == 'success'){

        for(i = 0; i < arrCarregar.data.length; i++){         
            //if(/Orçamento/.test(arrCarregar.data[i]['etapas'])){          
            if(/Or&ccedil;amento/.test(arrCarregar.data[i]['etapas']) || /Orçamento/.test(arrCarregar.data[i]['etapas'])){      
           
                $('#etapas_1').html(arrCarregar.data[i]['etapas']);    
                //include da pagina            
                $("#inc_etapas_1").load('inc_proposta_res_form.php');
                $('#processos_etapas_pk_1').val(arrCarregar.data[i]['pk']);
            }   
            if(/Contrato/.test(arrCarregar.data[i]['etapas'])){                  
                $('#etapas_2').html('2. Contrato(s) / Aditivos / Serviços Extras'); 
                //include da pagina
               // $("#inc_etapas_2").load('contrato_operacional_res_form.php');           
                $('#processos_etapas_pk_2').val(arrCarregar.data[i]['pk']);
            }
            if(/Agenda/.test(arrCarregar.data[i]['etapas'])){
                $('#etapas_3').html(arrCarregar.data[i]['etapas']);    
                //include da pagina
                //$("#inc_etapas_3").load('inc_agenda_escala_res_form.php');
                $('#processos_etapas_pk_2').val(arrCarregar.data[i]['pk']);
            }
        }
    }      
    else{
        alert('Falhar ao carregar o registro');
    }
}

$(document).ready(function() {
    
        //Atribui os eventos
    $(document).on('click', '#cmdCancelarProcesso', fcCancelarProcesso);       
    $(document).on('click', '#cmdCancelarProcesso1', fcCancelarProcesso);       
    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();

    fcCarregarEtapasProcesso();
    
    setTimeout(function(){
        $("#loader").hide();
        $("#exibir").show();
    },200);
    
} );

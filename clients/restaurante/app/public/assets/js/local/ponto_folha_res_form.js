var tblResultado;
function fcPesquisar(){
    $("#tbl").remove();
    fcCarregarGrid();
}
function fcVoltar(){
    var objParametros = {};
    sendPost('menu','rh' ,objParametros);
}
function fcIncluir(){
    var objParametros = {
        "pk":""  
    };
    sendPost('ponto_folha','cadForm',objParametros)
}

function fcEditar(v_pk){
    var objParametros = {
        "pk":v_pk  
    };
    sendPost('ponto_folha','colaboradoresCad',objParametros)
}


function fcExcluir(v_pk){
    var arrCarregar = permissao("ponto_folha", "del");

    if (arrCarregar.status != true){
        utilsJS.toastNotify(false, 'Você não tem permissão para acessar essa pagina!');
        setTimeout(function() {
            sendPost('menu','principal',{})
        }, 2000);
        return false;
    }

    utilsJS.jqueryConfirm('Excluir ?', 'Deseja excluir o registro '+v_pk+'?',function(){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("ponto_folha", "excluir", objParametros);   
            if (arrExcluir.status == true){

                //Exibe a mensagem
                utilsJS.toastNotify(true,arrExcluir.message);

                location.reload(true);

            }
            else{
                utilsJS.toastNotify(false,'Falhou a requisição de exclusão.');
            }
        }
        else{
            utilsJS.toastNotify(false,"Código não encontrado");
        }
    });
}

function fcCarregarGrid(){
    var objParametros = {
        "empresas_pk": $("#empresas_pk").val(),
        "leads_pk": $("#leads_pk").val(),
        "dt_periodo_ini": $("#dt_periodo_ini").val(),
        "dt_periodo_fim": $("#dt_periodo_fim").val(),
        "ic_status": $("#ic_status").val()
    };  

    var arrCarregar = carregarController("ponto_folha", "listarGrid", objParametros);

    if (arrCarregar.status == true && arrCarregar.data[0]['pk'] != "") {
        if (arrCarregar.data[0]['pk'] != 0) {
            var vhtml = "<tbody id='tblResultado'></tbody>";


            for(var i=0; i < arrCarregar.data.length; i++){
                vhtml += "        <tr>";
                vhtml += "          <td>";
                vhtml += "              <ul>";
                vhtml += "                  <span class='caret'>";
                vhtml +=                        arrCarregar.data[i]['ds_lead'];
                vhtml += "                  </span>";
                vhtml += "                  <ul class='nested' style='text-align: left;><br>";

                for(var l=0; l < arrCarregar.data[i]['mesesNoAno'].length; l++){
                    vhtml += "                  &nbsp;&nbsp;&nbsp;&nbsp;<span class='caret1'><i style='font-size: 18px;color: blue'></i>&nbsp;<b>";
                    vhtml +=                       arrCarregar.data[i]['mesesNoAno'][l]['ds_ano'];
                    vhtml += "                  </b></span>";
                    vhtml += "                  <ul>";
                    for(var a=0; a < arrCarregar.data[i]['mesesNoAno'][l]['folhaPorMes'].length; a++){
                        vhtml += "                  <ul>";
                        vhtml += "                      <span class='caret2'><i style='font-size: 18px;color: blue'></i>&nbsp;<b>";
                        vhtml +=                            arrCarregar.data[i]['mesesNoAno'][l]['folhaPorMes'][a]['ds_mes'] + " </b>";
                        vhtml += "                        <br>";
                        vhtml += "                     </span><hr>";
                        for(var b=0; b<arrCarregar.data[i]['mesesNoAno'][l]['folhaPorMes'][a]['folhas_mes'].length; b++){
                            vhtml += "                  <ul>";
                            vhtml += "                      <span><i class='bi bi-arrow-return-right style='font-size: 18px;color: blue'></i>&nbsp;<b>";
                            vhtml +=                            arrCarregar.data[i]['mesesNoAno'][l]['folhaPorMes'][a]['folhas_mes'][b]['dt_cadastro']+" - "+ arrCarregar.data[i]['mesesNoAno'][l]['folhaPorMes'][a]['folhas_mes'][b]['ponto_folha_pk']  + " &nbsp;&nbsp; </b>";
                            vhtml += "                          <a class='function_edit'><span><i class='bi bi-pencil-square listaFolha' style='font-size:18px; color:blue' onclick='fcEditar("+arrCarregar.data[i]['mesesNoAno'][l]['folhaPorMes'][a]['folhas_mes'][b]['ponto_folha_pk']+")'></i></span></a>&nbsp;&nbsp;";
                            vhtml += "                          <a class='function_delete'><span><i class='bi bi-x-circle listaFolha' style='font-size:18px; color:blue' onclick='fcExcluir("+arrCarregar.data[i]['mesesNoAno'][l]['folhaPorMes'][a]['folhas_mes'][b]['ponto_folha_pk']+")'></i></span></a>";
                            vhtml += "                        <br>";
                            vhtml += "                        <br>";
                            vhtml += "                     </span>";
                            vhtml += "                  </ul>";
                        }
                        vhtml += "                  </ul>";
                    }
                    vhtml += "                  </ul>";
                }
                vhtml += "                  </ul>";
                vhtml += "              </ul>";
                vhtml += "          </td>";
                vhtml += "        </tr>";
            }
            $('#tbl').append(vhtml);

        }
    }

    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }

    var toggler1 = document.getElementsByClassName("caret1");
    var l;

    for (l = 0; l < toggler1.length; l++) {
        toggler1[l].addEventListener("click", function() {
            this.parentElement.querySelector(".nested1").classList.toggle("active1");
            this.classList.toggle("caret1-down");
        });
    }

    var toggler2 = document.getElementsByClassName("caret2");
    var a;

    for (a = 0; a < toggler2.length; a++) {
        toggler2[a].addEventListener("click", function() {
            this.parentElement.querySelector(".nested2").classList.toggle("active2");
            this.classList.toggle("caret2-down");
        });
    }
}

//combos
function fcComboEmpresas(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("conta", "listarTodos", objParametros);    
    
    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_conta");         
}

function fcCarregarLeads(){
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 

    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");    
}

$(document).ready(function(){

    //Combo e mascaras
    fcComboEmpresas();

    fcCarregarLeads();

    $(".chzn-select").chosen({allow_single_deselect: true});
    
    $("#leads_pk").change(function(){
        $(".chzn-select").chosen('destroy');
        fcCarregarColaborador();
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    
    $('#dt_periodo_ini').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();

    $("#dt_periodo_ini").keypress(function(){
        mascara(this,mdata);
    });
    
    $('#dt_periodo_fim').datepicker({defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 

    $("#dt_periodo_fim").keypress(function(){
        mascara(this,mdata);
    });

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);    
    $(document).on('click', '#cmdVoltar', fcVoltar); 

    //faz a carga inicial do grid.
    fcCarregarGrid();
});




var ultimoDia ="";
var ultimoDia_anterior = "";

var DAtual = new Date();


function fcCarregar(){  
  
    $("#grid").html("");
    if($("#ic_dia").val()<10){
        var dt_ini = "0"+$("#ic_dia").val()+"/"+$("#ic_mes").val()+"/"+$("#ds_ano").val()
    }
    else{
        var dt_ini = $("#ic_dia").val()+"/"+$("#ic_mes").val()+"/"+$("#ds_ano").val()
    }
    
     var ArrData = dt_ini.split("/");
    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
    //0 dia; 1 mes; 2 ano

    var data = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    var dia_semana = data.getDay(); // 0-6 (zero=domingo)
    
    var dt_agenda_ini = "01/"+$("#ic_mes").val()+"/"+$("#ds_ano").val();
    var v_dt_ini = dt_ini;

    var strRetorno = "";

    var strNenhumRegisto = "";
        var objParametros = {
            "dt_ini": v_dt_ini,
            "dia_semana":dia_semana
        };    
 
    var arrCarregar = carregarController("agenda_colaborador_padrao", "relatorioEscalaServicoDiaGridParaTarefa", objParametros); 
    
    if (arrCarregar.result == 'success'){

        if(arrCarregar.data.length > 0){                
            
            for(j=0; j < arrCarregar.data.length ;j++){
                var strBackGround = "";
                var strDiaFolga = "";
                var strFontColor = "";
                strDiaFolga = "Folga";
                strFontColor = "red";
                
                
                
                var objParametrosCores = {
                    "colaborador_pk": arrCarregar.data[j]['t_colaboradores_pk'],
                    "dt_agenda": dt_agenda_ini,
                    "dt_agenda_fim": v_dt_ini,
                    "leads_pk": arrCarregar.data[j]['t_leads_pk']
                        //"dia_semana": i
                };         

                var arrCarregarCores = carregarController("agenda_colaborador_pausa", "listarCores", objParametrosCores);
                
                var intInverter = 1;
                var dt_agenda = "01/"+(ArrData[1])+"/"+ArrData[2];
                if(arrCarregar.data[j]['t_ds_lead']!= null){
                    var ds_lead = arrCarregar.data[j]['t_ds_lead'];
                }else{
                    var ds_lead = "";
                }          
                
                if(arrCarregar.data[j]['t_ds_re']!= null){
                    var ds_re = arrCarregar.data[j]['t_ds_re'];
                }else{
                    var ds_re = "";
                }
                
                
                if(arrCarregar.data[j]['t_ds_colaborador']!= null){
                    var ds_colaborador = arrCarregar.data[j]['t_ds_colaborador'];
                }else{
                    var ds_colaborador = "";
                }
                
                if(arrCarregar.data[j]['t_ds_produto_servico']!= null){
                    var ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico'];
                }else{
                    var ds_produto_servico = "";
                }
                if(arrCarregar.data[j]['t_ds_turnos']!= null){
                    var ds_turno = arrCarregar.data[j]['t_ds_turnos'];
                }else{
                    var ds_turno = "";
                }
                if(arrCarregar.data[j]['t_ds_endereco']!= null){
                    var ds_endereco = arrCarregar.data[j]['t_ds_endereco'];
                }else{
                    var ds_endereco = "";
                }
                
                
                var hr_turno = "";
                var hr_turno_saida = "";
                
                
                for(i = 0 ;i< $("#ic_dia").val();i++){
                    if (arrCarregarCores.result == 'success'){
                        if(arrCarregarCores.data.length > 0){
                            for(c=0; c < arrCarregarCores.data.length ;c++){
                                //PONTO
                                
                                if(arrCarregarCores.data[c]['dt_hr_ponto']==dt_agenda){
                                     strBackGround = "green";

                                }
                                //FALTA
                                if(arrCarregarCores.data[c]['dt_escala']==dt_agenda){
                                    strBackGround = "orange";

                                }
                                //TROCA COLABORADOR
                                if(arrCarregarCores.data[c]['dt_inicio_pausa']==dt_agenda && arrCarregarCores.data[c]['motivos_pausas_pk']!=null){
                                    strBackGround = "yellow";

                                }
                                //EXCLUSAO
                                if(arrCarregarCores.data[c]['dt_inicio_pausa']==dt_agenda && arrCarregarCores.data[c]['motivo_exclusao_pk']!=null){
                                    strBackGround = "salmon";

                                }
                                //REMOVER FOLGA
                                if(arrCarregarCores.data[c]['dt_inicio_pausa']==dt_agenda && arrCarregarCores.data[c]['motivo_exclusao_pk']==null && arrCarregarCores.data[c]['motivos_pausas_pk']==null){

                                   strDiaFolga = arrCarregarCores.data[c]['ds_agenda_colaborador_pausa'];
                                   strBackGround = "#f2f2f2";

                                }

                                 //ATRIBUIR FOLGA
                                if(arrCarregarCores.data[c]['dt_inicio_pausa']==dt_agenda && arrCarregarCores.data[c]['motivo_folga_pk']!=null){

                                    strDiaFolga = "Folga";
                                    strBackGround = "#aacaff";
                                }


                            }
                        }
                    }
                    var ArrDatas = dt_agenda.split("/");
                    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
                    //0 dia; 1 mes; 2 ano

                    var dt_semana = new Date(ArrDatas[2], ArrDatas[1] - 1, ArrDatas[0]);
                    //DOMINGO
                    if(dt_semana.getDay()==0){
                                       
                        //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_dom']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                intInverter = 0 + intInverter;
                                if (intInverter % 2 == 0) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                       }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_dom_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //TRAB
                                        hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                        hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                     }
                     //SEGUNDA
                    if(dt_semana.getDay()==1){
                                       
                        //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_seg']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 1) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                        //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                        }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_seg_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                    }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                     //TERÇA
                    if(dt_semana.getDay()==2){
                                       
                        //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_ter']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 0) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                        }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_ter_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                    }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{

                                    //TRAB
                                     hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                     hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                       
                                }
                            }
                            else{
                                if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                    }
                                   else if(strBackGround==""){
                                       //TRAB
                                        hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                        hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                   }
                                   else{
                                        //TRAB
                                        hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                                        hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                                   }
                                
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                    //QUARTA
                    if(dt_semana.getDay()==3){
                                       
                         //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_qua']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 1) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                        }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_qua_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                                       }
                                }
                            }
                            else{
                               //FOLGA
                                hr_turno = strDiaFolga;
                                hr_turno_saida = strDiaFolga;
                            }
                        }
                        else{
                           
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                         
                        }
                    }
                    //QUINTA
                    if(dt_semana.getDay()==4){
                                       
                        //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_qui']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 0) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                    }
                                }
                            }
                            else{
                               if(strBackGround=="#f2f2f2"){
                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                                }
                                else if(strBackGround=="#aacaff"){

                                    //FOLGA
                                    hr_turno = strDiaFolga;
                                    hr_turno_saida = strDiaFolga;
                               }
                               else{

                                   //TRAB
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                               }
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_qui_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                    //SEXTA
                    if(dt_semana.getDay()==5){
                                       
                       //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_sex']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                
                                if (intInverter % 2 == 1) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                    }
                                }
                            }
                            else{
                                    hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_sex_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                   
                    //SABADO
                    if(dt_semana.getDay()==6){
                         //Escala de trabalho
                        //TRABALHANDO
                        if(arrCarregar.data[j]['t_ic_sab']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 0) {
                                    
                                    
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround==""){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else{
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                    
                                    
                                }
                                else{
                                    
                                    if(strBackGround=="#f2f2f2"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround=="#aacaff"){
                                                       
                                        //FOLGA
                                         hr_turno = strDiaFolga;
                                         hr_turno_saida = strDiaFolga;
                                    }
                                    else if(strBackGround==""){
                                         //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                    }
                                    else{
                                        //TRAB
                                         hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                         hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                    }
                                }
                            }
                            else{

                                //TRAB
                                 hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                 hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                            }
                        }
                        else if(arrCarregar.data[j]['t_ic_sab_folga']==1){
                            if(arrCarregar.data[j]['t_ic_folga_inverter']==1){
                                if (intInverter % 2 == 1) {
                                    if(strBackGround=="#f2f2f2"){
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround=="#aacaff"){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else if(strBackGround==""){
                                       //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                   else{
                                        //FOLGA
                                        hr_turno = strDiaFolga;
                                        hr_turno_saida = strDiaFolga;
                                   }
                                }
                                else{
                                    if(strBackGround=="#f2f2f2"){
                                            //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                       }
                                       else if(strBackGround=="#aacaff"){
                                           //FOLGA
                                            hr_turno = strDiaFolga;
                                            hr_turno_saida = strDiaFolga;
                                           
                                       }
                                       else if(strBackGround==""){
                                           //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                       }
                                       else{
                                            //TRAB
                                            hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                            hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                                       }
                                }
                            }
                            else{
                                //TRAB
                                hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                                hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                            }
                        }
                        else{
                            //FOLGA
                            hr_turno = strDiaFolga;
                            hr_turno_saida = strDiaFolga;
                        }
                    }
                    
                     var p_nova_dt_agenda = dt_agenda.split("/");


                    //pega a data que ja passou pelo for 
                    var nova_dt_agenda_dia_anterior = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                    var nova_dt_agenda_dia_proximo = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                    //a cada looping acrescenta mais um dia 
                    nova_dt_agenda_dia_proximo.setDate(nova_dt_agenda_dia_anterior.getDate() + 1);

                    var dt_agenda = 0;
                    var dia = 0;
                    var mes = 0;
                    var ano = 0;
                    if(nova_dt_agenda_dia_proximo.getDate()<10){
                        dia = "0"+nova_dt_agenda_dia_proximo.getDate();
                        mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                        ano = nova_dt_agenda_dia_proximo.getFullYear();
                    }
                    else{
                        dia = nova_dt_agenda_dia_proximo.getDate();
                        mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                        ano = nova_dt_agenda_dia_proximo.getFullYear();
                    }

                    if((nova_dt_agenda_dia_proximo.getMonth()+1)<10){
                        mes = "0"+(nova_dt_agenda_dia_proximo.getMonth()+1);
                        ano = nova_dt_agenda_dia_proximo.getFullYear();

                    }
                    else{
                        mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                        ano = nova_dt_agenda_dia_proximo.getFullYear();

                    }                
                    dt_agenda = dia+"/"+mes+"/"+ano;
            
                    
                     
                    
                    intInverter ++ ;
                }
                
                if(hr_turno!="Folga"){
                    
                    
                    var objParametrosTarefa = {
                        "dt_execucao": v_dt_ini
                    };         

                    var arrCarregarTarefa = carregarController("agenda_colaborador_tarefa", "listarTarefasColaboradoresPorData", objParametrosTarefa);
                    if (arrCarregarTarefa.result == 'success'){
                        if(arrCarregarTarefa.data.length > 0){ 
                            strRetorno+="       <div class='row'>";
                            strRetorno+="           <div class='col-md-4'>";
                            strRetorno+="               &nbsp;";
                            strRetorno+="           </div >";
                            strRetorno+="           <div class='col-md-8'>";
                            strRetorno+="               <table>";
                            strRetorno+="                   <tr>";
                            strRetorno+="                       <td>Lead: <b>"+ds_lead+"</b> </td>";
                            strRetorno+="                   </tr>";
                            strRetorno+="                   <tr>";
                            strRetorno+="                       <td>Escala: <b>"+hr_turno+"</b></td>";
                            strRetorno+="                   </tr>";
                            strRetorno+="                   <tr>";
                            strRetorno+="                       <td>Posto de Trabalho: <b>"+ds_produto_servico+" </b></td>";
                            strRetorno+="                   </tr>";
                            strRetorno+="                   <tr>";
                            strRetorno+="                       <td>Endereço: <b>"+ds_endereco+" </b></td>";
                            strRetorno+="                   </tr>";
                            
                            strRetorno+="               </table>";
                            strRetorno+="           </div>";
                            strRetorno+="       </div>";
                            strRetorno+="       <br>";
                            
                            strRetorno+="       <div class='row'>";
                            strRetorno+="        <div class='col-md-4'>";
                            strRetorno+="        &nbsp;";
                            strRetorno+="        </div >";
                            strRetorno+="        <div class='col-md-8'>";
                            strRetorno+="          <table class='table table-striped table-bordered' aling=center style='width:50%' id='tblResultado'>";
                            strRetorno+="              <tbody>";
                            strRetorno+="                  <tr>";
                            strRetorno+="                       <th>Hora</th>";
                            strRetorno+="                       <th>Tarefa</th>";
                            strRetorno+="                       <th>Observação</th>";
                            strRetorno+="                       <th>Tarefa Concluida</th>";
                            strRetorno+="                       <th>Docs</th>";
                            strRetorno+="                  </tr>";
                            
                            for(t=0;t<arrCarregarTarefa.data.length;t++){
                                //MONTANDO DATA PARA COMPARAR COM A DATA E HORA ATUAL
                                var dt_compare = arrCarregarTarefa.data[t]['dt_execucao']+" "+ arrCarregarTarefa.data[t]['hr_inicio']+":00";
                                var date_comparacao = new Date(dt_compare);

                                if(DAtual > date_comparacao){
                                    if(arrCarregarTarefa.data[t]['dt_termino']!=null){
                                        strRetorno+="       <tr>";
                                        strRetorno+="           <td>"+arrCarregarTarefa.data[t]['hr_inicio']+"</td>";
                                        strRetorno+="           <td>"+arrCarregarTarefa.data[t]['ds_tarefa']+"</td>";
                                        strRetorno+="           <td>"+arrCarregarTarefa.data[t]['obs_tarefa']+"</td>";
                                        strRetorno+="           <td><input type='checkbox' checked disabled></td>";
                                        strRetorno+="           <td><button type='button' class='btn btn-link' onclick='fcAbrirModalDocs("+arrCarregarTarefa.data[t]['pk']+")'><img src='../img/download.png' width=30 height=30></button></td>";
                                        strRetorno+="       </tr>";
                                    }
                                    else{
                                        strRetorno+="       <tr>";
                                        strRetorno+="          <td><font color='red'>"+arrCarregarTarefa.data[t]['hr_inicio']+"</font></td>";
                                        strRetorno+="           <td><font color='red'>"+arrCarregarTarefa.data[t]['ds_tarefa']+"</font></td>";
                                        strRetorno+="           <td><font color='red'>"+arrCarregarTarefa.data[t]['obs_tarefa']+"</font></td>";
                                        strRetorno+="           <td><input type='checkbox' onclick='fcSalvarTarefa("+arrCarregarTarefa.data[t]['pk']+")'></td>";
                                        strRetorno+="           <td><button type='button' class='btn btn-link' onclick='fcAbrirModalDocs("+arrCarregarTarefa.data[t]['pk']+")'><img src='../img/download.png' width=30 height=30></button></td>";
                                        strRetorno+="       </tr>";
                                    }
                                    
                                }
                                else if(arrCarregarTarefa.data[t]['dt_termino']!=null){
                                    strRetorno+="       <tr>";
                                    strRetorno+="           <td>"+arrCarregarTarefa.data[t]['hr_inicio']+"</td>";
                                    strRetorno+="           <td>"+arrCarregarTarefa.data[t]['ds_tarefa']+"</td>";
                                    strRetorno+="           <td>"+arrCarregarTarefa.data[t]['obs_tarefa']+"</td>";
                                    strRetorno+="           <td><input type='checkbox' checked disabled></td>";
                                    strRetorno+="           <td><button type='button' class='btn btn-link' onclick='fcAbrirModalDocs("+arrCarregarTarefa.data[t]['pk']+")'><img src='../img/download.png' width=30 height=30></button></td>";
                                    strRetorno+="       </tr>";
                                    
                                }
                                else{
                                    strRetorno+="       <tr>";
                                    strRetorno+="           <td>"+arrCarregarTarefa.data[t]['hr_inicio']+"</td>";
                                    strRetorno+="           <td>"+arrCarregarTarefa.data[t]['ds_tarefa']+"</td>";
                                    strRetorno+="           <td><"+arrCarregarTarefa.data[t]['obs_tarefa']+"</td>";
                                    strRetorno+="           <td><input type='checkbox' onclick='fcSalvarTarefa("+arrCarregarTarefa.data[t]['pk']+")'></td>";
                                    strRetorno+="           <td><button type='button' class='btn btn-link' onclick='fcAbrirModalDocs("+arrCarregarTarefa.data[t]['pk']+")'><img src='../img/download.png' width=30 height=30></button></td>";
                                    strRetorno+="       </tr>";
                                }
                                
                               
                            }
                            
                            strRetorno+="</tbody>";
                            
                            strRetorno+="</table>";
                            
                            strRetorno+="</div>";
                            strRetorno+="<hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>   ";
                            
                        }
                        
                    }
                   
                
                
                }

                

            }
        }
    }
    else{
        alert('Falhar ao carregar o registro');
    }
    
    if(strRetorno!=""){        
        $("#grid").html(strRetorno);
    }else{ 
        var strNenhumRegisto = "";
        strNenhumRegisto+="   <table>";
        strNenhumRegisto+="       <tr>";
        strNenhumRegisto+="           <td><h4><b>Nenhuma Tarefa</b></h4></td>";
        strNenhumRegisto+="       </tr>";
        strNenhumRegisto+="   </table>";
        $("#grid").html(strNenhumRegisto);
    }
   
}

function fcSalvarTarefa(pk){
    var objParametros = {
        "pk":pk,
        "dt_termino":1

    }; 
    //alert($('#agenda_contratos_itens_pk').val())
    var arrEnviar = carregarController("agenda_colaborador_tarefa", "salvar", objParametros);
    
    if (arrEnviar.result == 'success'){
        fcCarregar();
    }    
    else{
        alert(arrEnviar.result);
    }
}

function fcPegarUltimoDiaMes(){
    ultimoDia = new Date($("#ds_ano").val(), $("#ic_mes").val(), 0);
    ultimoDia_anterior = new Date($("#ds_ano").val(),($("#ic_mes").val()-1), 0)
}

function fcDatasCaleandario(label,acao){
    
    
    var today = new Date();
    var dd = today.getDate();        
    var mm = today.getMonth()+1; //January is 0!   
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
    
    if($("#ic_mes").val()==""){
        $("#ic_mes").val(mm);
    }
    
   fcPegarUltimoDiaMes();
      
    if(label=='mes'){
        if(acao=='anterior'){     
            if($("#ic_mes").val()==1){
                dd  = $("#ic_dia").val();
                mm = 12;
                yyyy = ($("#ds_ano").val()-1);
            }else{
                dd  = $("#ic_dia").val();
                mm = ($("#ic_mes").val()-1);
                yyyy = (new Number($("#ds_ano").val()));
            }                        
        }else if(acao=='proximo'){             
            if($("#ic_mes").val()==12){
                dd  = $("#ic_dia").val();
                mm = 1;
                yyyy = (new Number($("#ds_ano").val())+1) 
            }
            else{
                dd  = $("#ic_dia").val();
                mm = (new Number($("#ic_mes").val())+1);
                yyyy = (new Number($("#ds_ano").val()));
            }             
        }
    }     
      

    if(label=='ano'){
        if(acao=='anterior'){  
            mm = $("#ic_mes").val();
            yyyy = ($("#ds_ano").val()-1);
        }else if(acao=='proximo'){    
            mm = $("#ic_mes").val();
            yyyy = (new Number($("#ds_ano").val())+1)      
        }
    }
    if(label=='dia'){
        if(acao=='anterior'){    
            
            if($("#ic_dia").val()==1){
                if($("#ic_mes").val()==1){
                    dd  = ultimoDia_anterior.getDate();
                    mm = 12;
                    yyyy = ($("#ds_ano").val()-1);
                }else{
                    dd  = ultimoDia_anterior.getDate();
                    mm = ($("#ic_mes").val()-1);
                    yyyy = (new Number($("#ds_ano").val()));
                }
            }
            else {
                dd  = (parseInt($("#ic_dia").val())-1);
                mm = ($("#ic_mes").val());
                yyyy = (new Number($("#ds_ano").val()));
            }                        
        }else if(acao=='proximo'){   
            
            if($("#ic_dia").val()==ultimoDia.getDate()){
                if($("#ic_mes").val()==12){
                    dd  = 1;
                    mm = 1;
                    yyyy = (new Number($("#ds_ano").val())+1) 
                }
                else{
                    dd  = 1;
                    mm = (parseInt($("#ic_mes").val())+1);
                    yyyy = (new Number($("#ds_ano").val())) 
                }
                
            }
            else{
                
                dd  = (parseInt($("#ic_dia").val())+1);
                mm = (parseInt($("#ic_mes").val()));
             
                yyyy = (new Number($("#ds_ano").val()));
            }             
        }
    }  
    
    
    if(mm=='1'){
        $("#ds_mes").text('Janeiro');
        $("#ic_mes").val(1);
    }else if(mm=='2'){
        $("#ds_mes").text('Fevereiro');
        $("#ic_mes").val(2);
    }else if(mm=='3'){
        $("#ds_mes").text('Março');
        $("#ic_mes").val(3);
    }else if(mm=='4'){
        $("#ds_mes").text('Abril');
        $("#ic_mes").val(4);
    }else if(mm=='5'){
        $("#ds_mes").text('Maio');
        $("#ic_mes").val(5);
    }else if(mm=='6'){
        $("#ds_mes").text('Junho');
        $("#ic_mes").val(6);
    }else if(mm=='7'){
        $("#ds_mes").text('Julho');
        $("#ic_mes").val(7);
    }else if(mm=='8'){
        $("#ds_mes").text('Agosto');
        $("#ic_mes").val(8);
    }else if(mm=='9'){
        $("#ds_mes").text('Setembro');
        $("#ic_mes").val(9);
    }else if(mm=='10'){
        $("#ds_mes").text('Outubro');
        $("#ic_mes").val(10);
    }else if(mm=='11'){
        $("#ds_mes").text('Novembro');
        $("#ic_mes").val(11);
    }else if(mm=='12'){
        $("#ds_mes").text('Dezembro');
        $("#ic_mes").val(12);
    }
    
    $("#ano_pk").text(yyyy);    
        
    $("#ds_ano").val(yyyy);  
    

   
    
    $("#ic_dia").val(parseInt(dd));
    $("#ds_dia").text(dd); 
    
    
    
    
     
    fcCarregar();
}





function fcAbrirModalDocs(pk){
    $("#janela_docs").modal();
    $("#tarefas_pk").val(pk)
    tblDocumentos.clear().destroy();
    fcCarregarGridDocumentos();
}
function fcCarregarGridDocumentos(){
    var objParametros = {
        "agenda_colaborador_tarefa_pk": $("#tarefas_pk").val()
    };     
    
    var v_url = montarUrlController("documento", "listarDocumentosTarefa", objParametros);

    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        //"bProcessing"    : true,
        "aaSorting"      : [],
        "sPaginationType": "full_numbers",
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
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
        
        if(data['t_pk'] != ""){
            fcDownloadDocumento(data['t_ds_documento']);
        }
    });
    $('#tblDocumentos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirDocumento(data['t_pk'],data['t_ds_documento']);
        }
    });
}

function fcDownloadDocumento(ds_documento){

    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

function fcExcluirDocumento(v_pk,v_ds_documento){

    if(v_pk != ""){
        
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("documento", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcExcluirArquivo(v_ds_documento);
            tblDocumentos.clear().destroy();    
            fcCarregarGridDocumentos();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcValidarDocumentos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() == "Nenhum registro encontrado"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    } 
    else{
        fcEnviarDocumento();
    }
    
}
function fcFormatarDadosArquivos(){

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
function fcEnviarDocumento(){ 

    var strJSONDadosTabela =  fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();
    
    var objParametros = {
        "agenda_colaborador_tarefa_pk": $("#tarefas_pk").val(),
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs
    };       
    
    
    var arrEnviar = carregarController("documento", "salvar", objParametros);           
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_documentos").modal("hide");
        alert(arrEnviar.message);
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
        //"leads_pk": $("#leads_pk_opcoes").val(),
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivoTarefa", objParametros);           
   
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


function ResetDoc(){
    $('#progressDoc .progress-bar').css('width', '0%');
}
$(function () {
    
    $('#fileuploadDoc').fileupload({
        
        dataType: 'json',
        done: function (e, data) {
           window.setTimeout('ResetDoc()', 2000);
   
            $.each(data.files, function (index, file) {
                
                $("#ds_nome_original").html(file.name);
                
                fcAlterarNomeArquivo(file.name);
                fcIncluirLinhaArquivo(file.name);
                
                               
            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },            
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressOc .progress-bar').css('width', progress + '%');
        }
    });
});

function fsCleanDoc() {
    $('#progressDoc .progress-bar').css('width', '0%');
}


function fcAbrirFormNovoDocumento(){

    tblArquivos.clear().destroy(); 
    fcCarregarGridArquivos();
    $("#janela_documentos").modal();
    $("#ds_obs_doc").val("");
}

function fcCarregarUsuarios(){
    var objParametros = {
        "pk": ""
    };         

    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros);  

    if (arrCarregar.result == 'success'){

        $(".ds_usuario").html(arrCarregar.data[0]['ds_usuario']);
    }
    else{
        alert('Falhar ao carregar o registro');
    }
}



$(document).ready(function(){
   
    fcDatasCaleandario('','');

    $(document).on('click', '#cmdPreviDia', function () {            
        fcDatasCaleandario('dia','anterior');
    } );
        
    $(document).on('click', '#cmdNextDia', function () {  
        fcDatasCaleandario('dia','proximo');
    } ); 
    
    $(document).on('click', '#cmdPreviMes', function () {            
        fcDatasCaleandario('mes','anterior');
    } );
        
    $(document).on('click', '#cmdNextMes', function () {  
        fcDatasCaleandario('mes','proximo');
    } );    
    
    $(document).on('click', '#cmdPreviAno', function () {  
        fcDatasCaleandario('ano','anterior');
    } );    

    $(document).on('click', '#cmdNextAno', function () {  
        fcDatasCaleandario('ano','proximo');
    } ); 
    
    // Mostra o resultado
    fcCarregarUsuarios();
    $("#loader").hide();
    $("#exibir").show();
    
   fcCarregarGridDocumentos();
   fcCarregarGridArquivos();
   
   $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);
   $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);
});



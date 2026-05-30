function fcVoltar(){
    sendPost('formulario_contrato_colaborador_res_form.php',{token: token, colaborador_pk: colaborador_pk});
}
function fcImprimir(){
    window.print();
    
}
function fcCarregar(){
    var v_html = ""    
    var meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"];    
    var hoje = new Date();
    var dia = hoje.getDate();
    var mes = hoje.getMonth()+1;
    var ano = hoje.getFullYear();   

    var data = "São Paulo, "+dia+" de "+ meses[parseInt(mes)-1]+" de "+ano;
    
   var objParametros = {
        "pk": colaborador_pk
    };          
    var arrCarregar = carregarController("colaborador", "listarPk", objParametros); 

        
    var arrCarregar0 = carregarController("colaborador", "RelatorioDadosColaborador", objParametros); 

    var v_dt_adminissao = "";
    var v_de_cargo = "";
    if(arrCarregar.data[0]['dt_admissao']!=null){
        var v_dt_admissao= arrCarregar.data[0]['dt_admissao'];
    }
    if(arrCarregar0.data[0]['ds_qualificacao']!=null){
        var v_ds_cargo= arrCarregar0.data[0]['ds_qualificacao'];
    }   
    
    
    
    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 22' colspan=4>";
    v_html +=          " <img src='https://segformula.gepros6.com.br/img/logo_cliente.png'  width='60%'><br>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 30' colspan=4>";
    v_html +=           "<b>0. S. - ORDEM DE SERVIÇO</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html +=   "<tr>";
    v_html +=       "<td  style=' text-align: left; font-size: 22px  '>";
    v_html +=           "<b>CBO</b>";
    v_html +=       "</td>";
    v_html +=       "<td  style=' text-align: left; font-size: 22px  '>";
    v_html +=           "<b></b>";
    v_html +=       "</td>";
    v_html +=       "<td  style=' text-align: right; font-size: 22px  '>";
    v_html +=           "<b>Nome:</b>";
    v_html +=       "</td>";
    v_html +=       "<td  style=' text-align: left; font-size: 22px  '>";
    v_html +=           arrCarregar.data[0]['ds_colaborador'];
    v_html +=       "</td>";       
    v_html +=   "</tr>";
    v_html +=   "<tr>";
    v_html +=       "<td  style=' text-align: left; font-size: 22px  '>";
    v_html +=           "<b>Admissão</b>";
    v_html +=       "</td>";
    v_html +=       "<td  style=' text-align: left; font-size: 22px  '>";
    v_html +=           v_dt_admissao;
    v_html +=       "</td>";
    v_html +=       "<td  style=' text-align: right; font-size: 22px  '>";
    v_html +=           "<b>Cargo:</b>";
    v_html +=       "</td>";
    v_html +=       "<td  style=' text-align: left; font-size: 22px  '>";
    v_html +=           v_ds_cargo;
    v_html +=       "</td>";       
    v_html +=   "</tr>";
    v_html += "</table>";
    v_html +="<br>";

    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 22' >";
    v_html +=           "<b>ATIVIDADES DESENVOLVIDAS</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 15'>";
    v_html +=           "- Atendimento a clientes;<br>- Controle de entrada e saída de pessoas e veículos;<br>- Identificação dos visitantes e funcionários;<br>- Executar outras atribuições semelhantes, conforme necessidade;<br>-Zelam pela guarda do patrimônio e exercem a vigilância de fabricas, armazéns, residências, estacionamentos, edifícios públicos, privados e outros estabelecimentos, percorrendo-os sistematicamente e inspecionando suas dependências";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html +="<br>";

    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 22'>";
    v_html +=           "<b>RISCO DA OPERAÇÃO</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 15'>";
    v_html +=           "- Físico: ruídos<br>- Químico: particulados<br>- Acidentes: queda de objeto";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html +="<br>";

    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 22' >";
    v_html +=           "<b>EPI’S - USO OBRIGATÓRIO</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 15' >";
    v_html +=           "N/A";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
       
    v_html +="<br>";

    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 22' >";
    v_html +=           "<b>MEDIDAS PREVENTIVAS</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 15' >";
    v_html +=           "- Manter a limpeza e organização do local, sendo proibido manter, ainda que por pequeno período, alimentos de qualquer espécie;<br>- Escada com corrimão e piso antiderrapante. Aconselha-se não correr ao descer ou subir escadas;<br>- Participar dos exames periódicos quando convocado;<br>- Pausa para descanso a cada hora trabalhada em pé;<br>- Posicionar-se corretamente ao executar a atividade, mantendo a coluna sempre ereta;<br>- São realizadas limpezas periódicas das luminárias e substituir lâmpadas queimadas;<br>- Uso permanente de lixeira com tampa de pedal e sabão líquido e papel toalha.";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html +="<br>";

    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 22' >";
    v_html +=           "<b>NORMAS INTERNAS</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 15' >";
    v_html +=           "- Cumprir e respeitar o horário de expediente e intervalos;<br>- Evitar o uso de adereços como bonés, colares, piercing e outros, se assim for solicitado pelo Supervisor Operacional;<br>- Manter seu posto de trabalho limpo e organizado;<br>- Não consumir bebida alcoólica ou qualquer tipo de entorpecente, no local de trabalho e durante a jornada de trabalho;<br>- Não fazer uso do copo coletivo;<br>- Não fumar no interior da empresa;<br>- Não realizar nenhum tipo de reparo ou manutenção em equipamentos/máquinas energizadas;<br>- Não se alimentar (ainda que lanches leves) dentro da empresa, a não ser no local reservado e apropriado para tal;<br>- Paralisar seu serviço sempre que constatar qualquer irregularidade quanto a sua segurança, comunicando imediatamente a sua supervisão;<br>- Usar calçado adequado preso ao pé para desenvolver a atividade profissional e vestir roupas adequadas e/ou uniformes, quando exigido, para transitar no interior da empresa;<br>- Utilizar os equipamentos de informática ou outros quaisquer oferecidos pela empresa apenas e tão somente na execução do trabalho determinado;<br>- Cumprir as disposições legais e regulamentadoras sobre Segurança e Medicina do Trabalho;<br>- Submeter-se aos exames médicos previstos nas Normas Regulamentadoras;<br>- No relacionamento e comunicação com os demais colaboradores, clientes, fornecedores, diretoria, etc., seja pessoalmente, ao telefone, por e-mail, ou ainda por qualquer outro meio, devem ser observadas regras mínimas de sadia convivência social, gentileza mútua e respeito à pessoa humana, sendo terminantemente vedado o uso de palavras, gestos e expressões chulas e de baixo calão, além de brincadeiras que venham a constranger ou denegrir a imagem dos companheiros de trabalho.";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";

    v_html +="<br>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 15' >";
    v_html +=           "- Noções Básicas de Combate à Incêndio;<br>- Noções de Primeiros Socorros.";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html +="<hr>"; 
        
    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td  style=' text-align: center; font-size: 18px; color: #008000'>";
    v_html +=           " Av. Eliseu de Almeida, 2771, sala 2| Instituto Previdência| Butantã| São Paulo | CEP 05533-000<br>(11)  3589-4710 | (11) 9 4778-4959 |<br>http://www.segformula.com e-mail: segformula@segformula.com";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html +="<label id='break'></label>"; 
    
    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 22' >";
    v_html +=          " <img src='https://segformula.gepros6.com.br/img/logo_cliente.png'  width='60%'><br>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html +="<br>";

    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 22' >";
    v_html +=           "<b>PROCEDIMENTO EM CASO DE ACIDENTE DE TRABALHO</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 15' >";
    v_html +=           "- Acionar brigadista quando constatada necessidade;<br>- Comunicar imediatamente a supervisão quando da ocorrência de acidente do trabalho, de trajeto ou surgir qualquer tipo de doença profissional;<br>- Solicitar ao RH abertura da  CAT – Comunicação de Acidente do Trabalho, após a caracterização do acidente;<br>- Prestar informações verdadeiras para o preenchimento da ficha de acidente.";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html +="<br>";

    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 22' >";
    v_html +=           "<b>CARACTERIZAÇÃO DA EXPOSIÇÃO</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: left; font-size: 15' >";
    v_html +=           "<b>Adicional de Insalubridade:</b><br> Não caracteriza como atividade ou operação insalubre de acordo com o disposto na Norma Regulamentadora NR 15.<br><b>Adicional de Periculosidade:</b><br>  Não caracteriza como atividade ou operação pediculosa de acordo com o disposto na Norma Regulamentadora NR 16.";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";    
    v_html +="<br>";

    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 22' >";
    v_html +=           "<b>TERMO DE RESPONSABILIDADE</b>";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    v_html += "<table width='100%' border='1' >";
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 15' colspan=3'>";
    v_html +=           "De acordo com o Artigo 158, Parágrafo Único, da lei 6.514/77 e da Norma Regulamentadora NR 1, <b>a recusa ao fiel cumprimento desta ORDEM DE SERVIÇO</b>, no todo ou em parte, <b>constituirá ATO FALTOSO</b> sujeitando o funcionário às penalidades previstas na lei.<br>Declaro que fui plenamente orientado quanto aos procedimentos de segurança do trabalho, estando ciente dos riscos decorrentes da atividade e dos sansões disciplinares a que estou sujeito quanto ao seu descumprimento.";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: center; font-size: 15; width: 25% ' >";
    v_html +=           "Data da emissão<br>/                 /";
    v_html +=       "</td>";
    v_html +=       "<td style=' text-align: center; font-size: 15; width: 33%' >";
    v_html +=           "<br><br>Ass. Funcionário";
    v_html +=       "</td>";
    v_html +=       "<td style=' text-align: center; font-size: 15; width: 33%' >";
    v_html +=           "<br><br>Ass. Técnico em Segurança do Trabalho";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    
    v_html +=   "<tr>";
    v_html +=       "<td style=' text-align: justify; font-size: 15' colspan=3'>";
    v_html +=           "De acordo com a portaria nº 3.214 do Ministério do Trabalho, N. R. 01 sub item 1.8 “Cabe ao Empregado: a) cumprir as disposições legais e regulamentares sobre segurança e medicina do trabalho, inclusive as ordens de serviço expedidas pelo Empregador; b) usar o E.P.I. fornecido pelo empregador; c) submeter-se aos exames médicos previstos nas Normas regulamentadoras N. R. 1.8.1 constitui ato faltoso a recusa injustificada ao cumprimento dos dispositivos no item anterior”.";
    v_html +=       "</td>";    
    v_html +=   "</tr>";
    
    v_html += "</table>"; 
    
    v_html +="<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>"; 
    v_html +="<hr>"; 
        
    v_html += "<table width='100%' border='0' >";
    v_html +=   "<tr>";
    v_html +=       "<td  style=' text-align: center; font-size: 18px; color: #008000'>";
    v_html +=           " Av. Eliseu de Almeida, 2771, sala 2| Instituto Previdência| Butantã| São Paulo | CEP 05533-000<br>(11)  3589-4710 | (11) 9 4778-4959 |<br>http://www.segformula.com e-mail: segformula@segformula.com";
    v_html +=       "</td>";
    v_html +=   "</tr>";
    v_html += "</table>";
    
    
    $("#v_html").html(v_html);
    
}

$(document).ready(function() {      
    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImprimir', fcImprimir);      
});
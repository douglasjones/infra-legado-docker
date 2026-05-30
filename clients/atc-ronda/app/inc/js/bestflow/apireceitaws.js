function limparDadosCnpj()
{
    document.getElementById('cnpj').value = "";
    document.getElementById('tipo').value = "";
    document.getElementById('porte').value = "";
    document.getElementById('nome').value = "";
    document.getElementById('fantasia').value = "";
    document.getElementById('abertura').value = "";
    document.getElementById('cep').value = "";
    document.getElementById('logradouro').value = "";
    document.getElementById('numero').value = "";
    document.getElementById('complemento').value = "";
    document.getElementById('bairro').value = "";
    document.getElementById('localidade').value = "";
    document.getElementById('uf').value = "";
    document.getElementById('ibge').value = "";
    document.getElementById('ddd').value = "";
    document.getElementById('telefone').value = "";
    document.getElementById('celular').value = "";
    document.getElementById('email').value = "";
    document.getElementById('contato').value = "";
}

function retornoReceitaWS(conteudo)
{
    // verifica se o callback apresentou algum erro
    if (!('message' in conteudo))
    {
        if (conteudo['situacao'] == 'ATIVA')
        {
            for (const campo in conteudo)
            {
                let campoAux = document.querySelector(`#${campo}`)
                if (campoAux && campoAux != "telefone")
                {
                    campoAux.value = conteudo[campo].toUpperCase();
                }
            }
            // ajustar telefones
            separarTelefones(conteudo['telefone']);
            // campo com nome diferente devido a api do cep
            document.querySelector(`#localidade`).value = conteudo['municipio'];
            // obtem o socio principal do array dos sócios
            document.querySelector(`#contato`).value = obterSocio(conteudo['qsa']);
            // email em minúsculas
            document.querySelector(`#email`).value = conteudo['email'].toLowerCase();
            validarCep(conteudo['cep']);
        } else
        {
            alert('CNPJ inativo, não pode ser cadastrado!');
            limparDadosCnpj();
        }
    } else
    {
        alert(conteudo['message']);
        limparDadosCnpj();
    }
}

function validarCnpj(valor)
{

    // obtém somente os números
    let cnpj = valor.replace(/\D/gm,'');
    // expressão regular para validar o cnpj
    let regEx = /^[0-9]{14}$/;
    // verifica se o cep está no formato válido
    if (regEx.test(cnpj))
    {
        consultarCnpj(cnpj);
    } else {
        alert('Cnpj em formato inválido!');
        limparDadosCnpj();
    }
}

function consultarCnpj(valor)
{

    $.ajax({
        url:'https://www.receitaws.com.br/v1/cnpj/' + valor,
        method:'GET',
        dataType: 'jsonp', // Em requisições AJAX para outro domínio é necessário usar o formato "jsonp" que é o único aceito pelos navegadores por questão de segurança
        complete: function(xhr){

          // Aqui recuperamos o json retornado
          response = xhr.responseJSON;
          
          // Na documentação desta API tem esse campo status que retorna "OK" caso a consulta tenha sido efetuada com sucesso
          if(response.status == 'OK') {
            $('#ds_tel_fixo').val("");
            $('#ds_tel_fixo1').val("");
            // Agora preenchemos os campos com os valores retornados
            $('#ds_tipo_lead').val(response.tipo);
            $('#ds_porte').val(response.porte);
            $('#dt_abertura').val(response.abertura);
            $('#ds_atividade_principal_receita').val(response.atividade_principal[0].text);
            $('#ds_atividade_secundaria_receita').val(response.atividades_secundarias[0].text);
            
            $('#ds_razao_social').val(response.nome);
            $('#ds_lead').val(response.fantasia);
            $('#ds_socio1').val(response.qsa[0].nome);
            $('#ds_socio2').val(response.qsa[1].nome);
            $('#ds_socio3').val(response.qsa[2].nome);
            $('#ds_email_contato_receita').val(response.email);

            if(response.telefone.includes('/')){
                var telefone = response.telefone.split("/");
                $('#ds_tel_fixo').val(telefone[0]);
                $('#ds_tel_fixo1').val(telefone[1]);
            }else{
                $('#ds_tel_fixo').val(response.telefone);
            }
            
            $('#ds_cep').val(response.cep);
            $('#ds_endereco').val(response.logradouro);
            $('#ds_numero').val(response.numero);
            $('#ds_complemento').val(response.complemento);
            $('#ds_bairro').val(response.bairro);
            $('#ds_cidade').val(response.municipio);
            $('#ds_uf').val(response.uf);
            $('#ds_complemento').val(response.complemento);
          
          // Aqui exibimos uma mensagem caso tenha ocorrido algum erro
          } else {
            alert(response.message); // Neste caso estamos imprimindo a mensagem que a própria API retorna
          }
        }
      });
   
}

function validarTelefone(valor)
{
    let regexTelefone = /^[0-9]{4,5}[0-9]{4}$/;
    if (valor !== '')
    {
        if (!(regexTelefone.test(valor)))
        {
            alert('Formato de telefone inválido!');
        }  
    }
}

function obterSocio(arrayQSA)
{
    let contato = arrayQSA[0].nome
    return contato.split(" ",1);
}

function separarTelefones(valor)
{
    let arrTelefones = valor.split("/",2);
    let numero = null;

    for (let i = 0; i < arrTelefones.length; i++) {
        numero = arrTelefones[i].replace(/\D/gm,'');
        numero.length > 9 ? numero = numero.substring(2,numero.length) : numero = numero;
        document.querySelector(`#telefone${i}`).value = numero;       
    }
}
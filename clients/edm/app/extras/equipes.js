function UserIns(equipe){
	NewWindow('equipes_usr.php?codequipe=' + equipe, 300, 100)
}

function UserDel(vlr){
	if(vlr == null){
		alert("Por favor, selecione um Usuário.")
		return
	}
	if(confirm("Deseja excluir o registro selecionado?"))
		NewWindow('equipes_cad.php?acao=del_usr&codusr=' + vlr, 100, 100)
}
function getSel(){
	var rd = document.getElementsByName('rd')
	var retorno = null
	if(rd)
		if(rd.length)
			for(i=0;i<rd.length;i++)
				if(rd[i].checked)
					retorno = rd[i].value
		else
			if(rd.checked)
				retorno = rd.value
	return retorno
}
function showDetVendas(usr,dti,dtf,dti2,dtf2){
	var div = $('detalhes');
	div.innerHTML = "Carregando..."
	div.style.display = "block";
	var pars = 'usr=' + usr + '&dti=' + dti + '&dtf=' + dtf + '&dti2=' + dti2 + '&dtf2=' + dtf2;
	new Ajax.Updater('detalhes', 'RelEquipesAjax.php', { method: 'post', parameters: pars } );
}
function closeDetVendas(){
	var div = $('detalhes');
	div.style.display = "none";
}
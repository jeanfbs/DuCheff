/**************************************************************************
*
*	Validation faz uma validação de todos os seletores equivalentes ao seletor 
* 	passado no parametro.

* @param seletor O seletor a ser percorrido para fazer a validação
* @return true se existe pelo menos um campo vazio
*		  false se todos os campos estão preenchidos
*
***************************************************************************/
$.fn.extend({
 validation: function()
{	
	var erro = false;
	// variavel de codição do erro
	 $(this).each(function(){

			if($(this).val() == "")
			{
				if($(this).parents("div .form-group").hasClass("has-success"))
				{
					
					$(this).parents("div .form-group").removeClass("has-success");
					$(this).parents("div .form-group").addClass("has-error");
				}
				else 
					$(this).parents("div .form-group").addClass("has-error");
				erro = true;
			}
			else
			{
				if($(this).parents("div .form-group").hasClass("has-error"))
				{
					
					$(this).parents("div .form-group").removeClass("has-error");
					$(this).parents("div .form-group").addClass("has-success");
				}
				else
					$(this).parents("div .form-group").addClass("has-success");
			}

			});

	 if(erro) return true;
	 else return false;
}

});

/**************************************************************************
*
*	 Busca os clientes para preencher o seletor com os dados
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
getClientesSelect: function()
{
	var seletor = $(this);

	$.getJSON(pt_br.absolute_url+"/panel-control/clientes/listar",function(json)
	{
		$.each(json,function(i,item){

			var op = "<option value="+json[i].cod+">"+json[i].nome.toUpperCase()+"</option>";
			seletor.append(op);
			

		});
	});
	return false;
}
});

/**************************************************************************
*
*	 Busca as bebidas para preencher o seletor com os dados
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
getBebidasSelect: function()
{
	var seletor = $(this);

	$.getJSON(pt_br.absolute_url+"/panel-control/bebidas/listar",function(json)
	{
		$.each(json,function(i,item){

			var op = "<option value="+json[i].cod+">"+json[i].nome.toUpperCase()+"</option>";
			seletor.append(op);
			

		});
	});
	return false;
}
});

/**************************************************************************
*
*	 Busca os produtos para preencher o seletor com os dados
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
getProdutosSelect: function()
{
	var seletor = $(this);

	$.getJSON(pt_br.absolute_url+"/panel-control/produtos/listar",function(json)
	{
		$.each(json,function(i,item){

			var op = "<option value="+json[i].cod+">"+json[i].nome.toUpperCase()+"</option>";
			seletor.append(op);
			

		});
	});
	return false;
}
});

/**************************************************************************
*
*	 Busca os tipos de pratos para preencher o seletor com os dados
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
getTiposPratosSelect: function()
{
	var seletor = $(this);

	$.getJSON(pt_br.absolute_url+"/panel-control/tipos/listar",function(json)
	{
		$.each(json,function(i,item){

			var op = "<option value="+json[i].cod+">"+json[i].nome.toUpperCase()+"</option>";
			seletor.append(op);
			

		});
	});
	return false;
}
});

/**************************************************************************
*
*	 Busca as variedades para preencher o seletor com os dados
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
getVariedadeSelect: function()
{
	var seletor = $(this);

	$.getJSON(pt_br.absolute_url+"/panel-control/variedades/listar",function(json)
	{
		$.each(json,function(i,item){

			var op = "<option value="+json[i].cod+">"+json[i].nome.toUpperCase()+"</option>";
			seletor.append(op);
			

		});
	});
	return false;
}
});

/**************************************************************************
*
*	 Busca as categorias para preencher o seletor com os dados
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
getCategoriasSelect: function()
{
	var seletor = $(this);

	$.getJSON(pt_br.absolute_url+"/panel-control/categorias/listar",function(json)
	{
		$.each(json,function(i,item){

			var op = "<option value="+json[i].cod+">"+json[i].nome.toUpperCase()+"</option>";
			seletor.append(op);
			

		});
	});
	return false;
}
});

/**************************************************************************
*
*	 Busca os produtos para preencher o seletor com os dados
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
getPratosSelect: function(tipo)
{
	var seletor = $(this);
	seletor.append("<option value=''></option>");
	$.getJSON(pt_br.absolute_url+"/panel-control/pratos/listar",{tipo:tipo},function(json)
	{
		$.each(json,function(i,item){
			var op = "<option value="+json[i].cod+">"+json[i].nome.toUpperCase()+"</option>";
			seletor.append(op);
			

		});
	});
	return false;
}
});

/**************************************************************************
*
* Autocomplete Produtos constroi o autocomplete com os dados apenas dos produtos
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
	getProdutos: function()
	{
		var seletor = $(this);
		$.getJSON(pt_br.absolute_url+"/panel-control/produtos/listar",function(data)
		{
			var item = [];
			$(data).each(function(key,value){

				item.push(value.nome);
			    
			});

			seletor.autocomplete(
			{
				source: item						
			}).autocomplete("widget").addClass("fixed-height");
		});
		return false;
	}
});

/**************************************************************************
*
* Autocomplete Clientes constroi o autocomplete com os dados apenas dos clientes
* @param Seletor
* @return false
*
***************************************************************************/
$.fn.extend({
	getClientes: function()
	{
		var seletor = $(this);
		$.getJSON(pt_br.absolute_url+"/panel-control/clientes/listar",function(data)
		{
			var item = [];
			$(data).each(function(key,value){

				item.push(value.nome);
			    
			});
			seletor.autocomplete(
			{
				source: item						
			}).autocomplete("widget").addClass("fixed-height");
		});
		return false;
	}
});

function today()
{
	var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    var today = dd+'/'+mm+'/'+yyyy;
    return today;
}

function getHorario()
{
	d = new Date();
	datetext = d.toTimeString();
	time = datetext.split(' ')[0];
	

	return time;
}
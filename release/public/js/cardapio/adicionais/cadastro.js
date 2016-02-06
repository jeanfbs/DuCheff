$(document).ready(function() {


/* ------------------------------------------------------------------ 
|	Preenche o select com os produtos cadastradas
------------------------------------------------------------------*/
$("#produtos").getProdutosSelect();
var s2p = $("#produtos").select2();
/* ------------------------------------------------------------------ 
|	Preenche o select com as categorias cadastradas
------------------------------------------------------------------*/
$("#categorias").getCategoriasSelect();
var s2c = $("#categorias").select2();
/* ------------------------------------------------------------------ 
|	Evento de Cadastrar dados via Ajax
------------------------------------------------------------------*/
$("#salvar").on('click', function(event) {
	
	/* valida o formulario para: Campos vazios ou senhas diferentes*/
	var validation = s2p.val() == "" || s2c.val() == "";
	if(validation)
	{
		alertErro(pt_br.campos_vazios);
		return false;
	}
	var dados = new FormData(document.querySelector("#cadastro"));
	
	$.ajax({
		type: "POST",
        contentType: false,
        url : pt_br.absolute_url+"/panel-control/adicionais/cadastro",
        enctype: 'multipart/form-data',
        data : dados,
        processData:false
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
	    	alertSucesso(pt_br.msg_cadastro_sucesso);
	    	clearFormulario();
    	}
    	else if(parseInt(res,10) == 0)
    	{
    		alertErro(pt_br.msg_erro);
    	}
    	else if(parseInt(res,10) == 2)
    	{
    		alertErro(pt_br.msg_erro_existe);
    	}

    });
});


/* ------------------------------------------------------------------ 
|	Limpar os campos do formulario
------------------------------------------------------------------*/
$("#cancelar").on("click",function(){
	clearFormulario();
});

function clearFormulario()
{
	s2p.val("").change();
	s2c.val("").change();
	$("#cadastro textarea").val("");
}

});


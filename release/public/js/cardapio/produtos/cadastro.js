$(document).ready(function() {

/* ------------------------------------------------------------------ 
|	BootstrapValidator para o formulario de cadastro
------------------------------------------------------------------*/
$('#cadastro').bootstrapValidator({
	message: '',
	fields: {
		nome: {
			validators: {
				notEmpty: {
					message: pt_br.msg_erro_produto
				}
			}
		}
		
		
	}
});

/* ------------------------------------------------------------------ 
|	Evento de Cadastrar dados via Ajax
------------------------------------------------------------------*/
$("#salvar").on('click', function(event) {
	
	/* valida o formulario para: Campos vazios ou senhas diferentes*/
	if($("#cadastro .required").validation())
	{
		alertErro(pt_br.campos_vazios);
		return false;
	}


	var dados = new FormData(document.querySelector("#cadastro"));
	
	$.ajax({
		type: "POST",
        contentType: false,
        url : pt_br.absolute_url+"/panel-control/produtos/cadastro",
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
	$("#cadastro input").each(function(){
		$(this).val("");
	});
}

});


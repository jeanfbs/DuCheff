$(document).ready(function() {

$('#cadastro').bootstrapValidator({
	message: '',
	fields: {
		nome: {
			validators: {
				notEmpty: {
					message: pt_br.msg_erro_nome
				},
				stringLength: {
					min: 6,
					message: pt_br.msg_erro_nome_minimo_caractere
				}
			}
		},
		endereco: {
			validators: {
				notEmpty: {
					message: pt_br.msg_erro_endereco
				}
			}
		},
		telefone: {
			validators: {
				notEmpty: {
					message: pt_br.msg_erro_telefone
				}
			}
		},
		
		
	}
});


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
        url : pt_br.absolute_url+"/panel-control/clientes/cadastro",
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

    });
});

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


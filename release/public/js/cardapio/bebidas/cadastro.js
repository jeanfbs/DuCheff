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
					message: pt_br.msg_erro_marca
				}
			}
		},
		valor: {
			validators: {
				notEmpty: {
					message: pt_br.msg_erro_preco
				},
				regexp: {
					regexp: /^[0-9\.]+$/,
					message: pt_br.msg_erro_apenas_numeros
				}
			}
		},
		
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
        url : pt_br.absolute_url+"/panel-control/bebidas/cadastro",
        enctype: 'multipart/form-data',
        data : dados,
        processData:false,
        beforeSend: function() {
         $('#ajaxLoading').fadeIn(350);
     	},
        complete: function() {
         $('#ajaxLoading').fadeOut(350);
     }
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
/* ------------------------------------------------------------------ 
|	Função para carregar a Imagem
------------------------------------------------------------------*/
function readURL(input,img) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            img.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(".imagem").on("change",function(){
	img = $(this).parents("div").find("img");
	array = $(this).val().split("\\");
	alt = array[array.length-1];
	img.attr("alt",alt);
    readURL(this,img);
});

/* ------------------------------------------------------------------ 
|	Limpar os campos do formulario
------------------------------------------------------------------*/
$("#cancelar").on("click",function(){
	clearFormulario();
});
/* ------------------------------------------------------------------ 
|	Formata o input para aceitar apenas valores float
------------------------------------------------------------------*/
$(document).on("keyup",".float",function(){
	 var expre = /[^0-9.]/g;

    // REMOVE OS CARACTERES DA EXPRESSAO ACIMA
    if ($(this).val().match(expre))
        $(this).val($(this).val().replace(expre,''));
		
});

function clearFormulario()
{
	$("#cadastro input").each(function(){
		$(this).val("");
	});
	$("#fbebida").attr("src","").attr("alt","");
}

});


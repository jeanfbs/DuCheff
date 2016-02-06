$(document).ready(function() {

/* ------------------------------------------------------------------ 
|	BootstrapValidator para o formulario de cadastro
------------------------------------------------------------------*/
$('#cadastro_estoque').bootstrapValidator({
	message: '',
	fields: {
		qtd_entrada: {
			validators: {
				notEmpty: {
					message: pt_br.msg_erro_qtd_entrada
				}
			}
		},
		data_entrada: {
			validators: {
				notEmpty: {
					message: pt_br.msg_erro_dt_entrada
				}
			}
		},
		data_vencimento: {
			validators: {
				notEmpty: {
					message: pt_br.msg_erro_dt_vencimento
				}
			}
		}
		
		
	}
});

/* ------------------------------------------------------------------ 
|	Preenche o select com os produtos cadastradas
------------------------------------------------------------------*/
$("#produtos").getProdutosSelect();
var s2p = $("#produtos").select2();


$(".datepicker").datepicker({
	dateFormat: 'dd/mm/yy'
});
$(".datepicker").val(today());
/* ------------------------------------------------------------------ 
|	Evento de Cadastrar dados via Ajax
------------------------------------------------------------------*/
$("#salvar").on('click', function(event) {
	
	/* valida o formulario para: Campos vazios ou senhas diferentes*/
	if($("#cadastro_estoque .required").validation())
	{
		alertErro(pt_br.campos_vazios);
		return false;
	}
	if($("select[name=unidade_medida]").val() == "")
	{
		alertErro(pt_br.msg_erro_unid);
		return false;
	}


	var dados = $("#cadastro_estoque").serializeArray();
	
	$.ajax({
		type: "POST",
        url : pt_br.absolute_url+"/panel-control/estoque-produtos/cadastro",
        data : dados
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
	    	alertSucesso(pt_br.msg_cadastro_sucesso);
	    	clearFormulario();
    	}
    	else if(parseInt(res,10) == 0)
    	{
    		alertErro(pt_br.msg_cadastro_erro);
    	}

    });
});
/* ------------------------------------------------------------------ 
|   Formata o input para aceitar apenas valores float
------------------------------------------------------------------*/
$(document).on("keyup",".float",function(){
     var expre = /[^0-9.]/g;

    // REMOVE OS CARACTERES DA EXPRESSAO ACIMA
    if ($(this).val().match(expre))
        $(this).val($(this).val().replace(expre,''));
        
});
/* ------------------------------------------------------------------ 
|	Limpar os campos do formulario
------------------------------------------------------------------*/
$("#cancelar").on("click",function(){
	clearFormulario();
});

function clearFormulario()
{
	$("#cadastro_estoque input").each(function(){
		$(this).val("");
	});
	$("#cadastro_estoque textarea").val("");
}

});


$(document).ready(function() {

	
/* ------------------------------------------------------------------ 
|	Cria os Botões de Ver,Editar e Excluir
------------------------------------------------------------------*/
var actions_buttons ='<a class="view"><i class="fa fa-eye" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_ver+'"></i></a> ';
    actions_buttons += '<a data-toggle="modal" data-target="#edit" class="editar"><i class="fa fa-edit" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_editar+'"></i></a> ';
	actions_buttons += '<a href="#deletar" class="del"><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_deletar+'"></i></a>';
				    					 
/* ------------------------------------------------------------------ 
|	DataTables Plugin
------------------------------------------------------------------*/
var dataTable = $('#tabela_dados_estoque').DataTable( {
		"lengthMenu": [[10,25,50, -1], [10,25,50, "Todos"]],// modifica qtd de resultados por pagina
		"aaSorting": [[ 0, "asc" ]],// indice da coluna para a ordenação no init da DataTable
		"scrollX": true,
		"oLanguage": {
			"sSearch": pt_br.sSearch,
			"sLengthMenu": '_MENU_',
			"sZeroRecords": pt_br.sZeroRecords,
			"sInfo": pt_br.sInfo,
			"sInfoEmpty":pt_br.sInfoEmpty,
			"sInfoFiltered":pt_br.sInfoFiltered,
			"sProcessing":pt_br.sProcessing

		},
		"bProcessing": true,// mostra o icone de processando...
		"bServerSide": true,// faz com que o processamento seja do lado do servidor
		// Ajax propriedades
		"ajax":{
			"url":pt_br.absolute_url+"/panel-control/estoque-produtos/pesquisa",
			"type":"POST",
			"data":function(d){
				d.min = $("#min").val();
				d.max = $("#max").val();
			},
		},
		// Colunas propriedades
		"columns": [
			{
				'width':'12.5%',  
				"name": "cod" 
			},
			{ "name": "produtos.nome" },
			{ "name": "estoque_produtos.qtd_atual" },
			{ "name": "estoque_produtos.data_entrada" },
			{ "name": "estoque_produtos.data_vencimento" },
		    {
		    	"data":null,
		    	"orderable":      false,
		    	"defaultContent":actions_buttons
		    }
		  ]
});

// Event listener to the two range filtering inputs to redraw on input
$('#min, #max').on("keyup",function() {
    dataTable.draw();
});
 // Array de ids das linhas que irão mostrar os detalhes
    var detailRows = [];
 /* ------------------------------------------------------------------ 
|	Manipulador para quando o usuario clicar no view da tabela
------------------------------------------------------------------*/
    $('#tabela_dados_estoque tbody').off("click",".view").on( 'click', '.view', function () {

        var tr = $(this).closest('tr');
        var row = dataTable.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 		var fonticon = $(this).children('i');
 		
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            fonticon.removeClass('fa fa-eye-slash');
           	fonticon.addClass('fa fa-eye');
            row.child.hide(200);
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            fonticon.removeClass('fa fa-eye');
            fonticon.addClass('fa fa-eye-slash');
            
           var codigo = parseInt(tr.children("td:eq(0)").text(),10);

            $.ajax({

		    type: "GET",
		    url : pt_br.absolute_url+"/panel-control/estoque-produtos/editar",
		    data : {codigo:codigo},
		    dataType: 'json'
		    }).done(function(res){
		    	row.child(format(res[0])).show(200);
 
	            // Add to the 'open' array
	            if ( idx === -1 ) {
	                detailRows.push( tr.attr('id') );
	            }

		    });
            
        }
    });
 
    // On each draw, loop over the `detailRows` array and show any child rows
    dataTable.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );


 
/*------------------------------------------------------------------------
|	Validador do formulario de edição
|------------------------------------------------------------------------*/
$('#edicao_estoque').bootstrapValidator({
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

$(".datepicker").datepicker({
	dateFormat: 'dd/mm/yy'
});
$(".datepicker").val(today());
/*------------------------------------------------------------------------
|	Carrega informações via ajax para edição
|------------------------------------------------------------------------*/
$(document).off("click",".editar").on("click",".editar",function(){

	$("#editar").modal("show");
	var codigo = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);
	var nome = $(this).parents("tr").children("td:eq(1)").text();
	$.ajax({

    type: "GET",
    url : pt_br.absolute_url+"/panel-control/estoque-produtos/editar",
    data : {codigo:codigo},
    dataType: 'json'
    }).done(function(res){
    	$("#titulo_modal").html("<b style='color:#d15e5e;'>"+nome.toUpperCase()+"</b>");
    	$("#edit_cod").val(codigo);
    	$("input[name=qtd_atual]").val(res[0].qtd_atual);
    	$("select[name=unidade_medida]").val(res[0].unidade_medida);
    	$("input[name=data_entrada]").val(res[0].data_entrada);
    	$("input[name=data_vencimento]").val(res[0].data_vencimento);
    	$("textarea[name=observacoes]").val(res[0].observacoes);
    	
    });

});

/*------------------------------------------------------------------------
|	Função de salvar edição
|------------------------------------------------------------------------*/
$("#salvar_edicao").off("click").on("click",function(){

	/* valida o formulario para: Campos vazios ou senhas diferentes*/
	if($("#edicao_estoque .required").validation())
	{
		alertErro(pt_br.campos_vazios);
		return false;
	}
	if($("select[name=unidade_medida]").val() == "")
	{
		alertErro(pt_br.msg_erro_unid);
		return false;
	}


	var dados = $("#edicao_estoque").serializeArray();
	
	$.ajax({
		type: "POST",
        url : pt_br.absolute_url+"/panel-control/estoque-produtos/editar",
        data : dados
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
    		$("#editar").modal("hide");
    		clearFormulario();
    		dataTable.draw();
    		alertSucesso(pt_br.msg_edicao_sucesso);

    	}
    	else
    	{
    		alertErro(pt_br.msg_erro);
    	}

    });
});

$("input[name=qtd_atual]").focusout(function(event) {
	var number = parseInt($(this).val(),10);
	if(number < 0)
	{
		$(this).val(0);
		alertWarning(pt_br.msg_erro_qtd_atual);
	}
});
/*------------------------------------------------------------------------
|	FUNÇÃO DE CONFIRMAÇÃO DE EXCLUSÃO
|------------------------------------------------------------------------*/

$(document).off("click",".del").on("click",".del",function(){

	if(!confirm(pt_br.cofirmacao_deletar))
		return false;

	var id = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);
	$.ajax({
		type: "GET",
	    url: pt_br.absolute_url+"/panel-control/estoque-produtos/deletar",
	    data: {id:id}
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
    		dataTable.draw();
    		alertSucesso(pt_br.msg_exclusao_sucesso);
    	}
    	else if(parseInt(res,10) == 0)
    	{
    		alertErro(pt_br.msg_cadastro_erro);
    	}

    });

});

});
// Função que formata os dados para mostrar no detalhes da tabela
function format(f){

	string = '';
	string += "<b>"+pt_br.format_field_qtd_entrada+"</b>"+' '+f.qtd_entrada+'<br>';
	string += "<b>"+pt_br.format_field_unid+"</b>"+' '+f.unidade_medida+'<br>';
    string += "<b>"+pt_br.format_field_obs+"</b>"+' '+f.observacoes+'<br>';
    return string;

}

function clearFormulario()
{
	$("#edicao_estoque input").each(function(){
		$(this).val("");
	});
	$("#edicao_estoque select").val("");
	$("#edicao_estoque textarea").val("");
}

$(document).ready(function() {

	var actions_buttons ='<a class="view"><i class="fa fa-eye" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_ver+'"></i></a> ';
		actions_buttons += '<a data-toggle="modal" data-target="#edit" class="editar"><i class="fa fa-edit" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_editar+'"></i></a> ';
		actions_buttons += '<a href="#deletar" class="del"><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_deletar+'"></i></a>';
					    					 

	var dataTable = $('#tabela_dados_clientes').DataTable( {
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
				"url":pt_br.absolute_url+"/panel-control/clientes/pesquisa",
				"type":"POST"
			},
			// Colunas propriedades
			"columns": [
				{ "name": "cod"},
			    { "name": "nome","data":3},
			    { "name": "endereco","data":4 },
			    { "name": "telefone","data":5 },
			    {
			    	"data":null,
			    	"orderable":      false,
			    	"defaultContent":actions_buttons
			    }
			  ],

	});


 // Array de ids das linhas que irão mostrar os detalhes
    var detailRows = [];
 
    $('#tabela_dados_clientes tbody').off("click",".view").on( 'click', '.view', function () {

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
		    url : pt_br.absolute_url+"/panel-control/clientes/editar",
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
$('#edicao').bootstrapValidator({
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
		}
	}
});



/*------------------------------------------------------------------------
|	Carrega informações via ajax para edição
|------------------------------------------------------------------------*/
$(document).off("click",".editar").on("click",".editar",function(){

	$("#editar").modal("show");
	var codigo = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);

	$.ajax({

    type: "GET",
    url : pt_br.absolute_url+"/panel-control/clientes/editar",
    data : {codigo:codigo},
    dataType: 'json'
    }).done(function(res){
    	$("#titulo_modal").html("<b style='color:#d15e5e;'>"+res[0].nome.toUpperCase()+"</b>");
    	$("#edit_cod").val(res[0].cod);
    	$("input[name=nome]").val(res[0].nome);
    	$("input[name=login]").val(res[0].login);
    	$("input[name=endereco]").val(res[0].endereco);
    	$("input[name=telefone]").val(res[0].telefone);
    	$("input[name=email]").val(res[0].email);
    });

});

/*------------------------------------------------------------------------
|	Função de salvar edição
|------------------------------------------------------------------------*/
$("#salvar_edicao").off("click").on("click",function(){

	/* valida o formulario para: Campos vazios ou senhas diferentes*/
	if($("#edicao .required").validation())
	{
		alertErro(pt_br.campos_vazios);
		return false;
	}
	
	if($("input[name=senha]").val() == "")
	{
		$("input[type=password]").removeAttr('name');
	}
	else
	{
		$("input[type=password]").attr('name','senha');
	}
	
	dados = $("#edicao").serializeArray();
	$.ajax({

    type: "POST",
    url : pt_br.absolute_url+"/panel-control/clientes/editar",
    data : dados
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
    		$("#editar").modal("hide");
    		dataTable.ajax.reload();
    		alertSucesso(pt_br.msg_edicao_sucesso);

    	}
    	else
    	{
    		alertErro(pt_br.msg_erro);
    	}

    });
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
	    url: pt_br.absolute_url+"/panel-control/clientes/deletar",
	    data: {id:id}
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
    		dataTable.ajax.reload();
    		alertSucesso(pt_br.msg_exclusao_sucesso);
    	}
    	else if(parseInt(res,10) == 0)
    	{
    		alertErro(pt_br.msg_erro);
    	}
    	else if(parseInt(res,10) == 2)
    	{
    		alertErro(pt_br.msg_erro_exclusao);
    	}

    });

});

});
// Função que formata os dados para mostrar no detalhes da tabela
function format(f){

	string = '';
	string += "<b>"+pt_br.format_field_login+"</b>"+' '+f.login+'<br>';
    string += "<b>"+pt_br.format_field_senha+"</b>"+' '+f.senha+'<br>';

    return string;

}


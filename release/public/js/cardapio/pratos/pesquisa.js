$(document).ready(function() {
/* ------------------------------------------------------------------ 
|	Cria os Botões de Ver,Editar e Excluir
------------------------------------------------------------------*/
var actions_buttons ='<a class="view"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="'+pt_br.tooltip_ver+'"></i></a> ';
	actions_buttons += '<a data-toggle="modal" data-target="#edit" class="editar"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="'+pt_br.tooltip_editar+'"></i></a> ';
	actions_buttons += '<a href="#deletar" class="del"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'+pt_br.tooltip_deletar+'"></i></a>';
				    					 
/* ------------------------------------------------------------------ 
|	DataTables Plugin
------------------------------------------------------------------*/
var dataTable = $('#tabela_dados').DataTable( {
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
			"url":pt_br.absolute_url+"/panel-control/pratos/pesquisa",
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
				"name": "pratos.cod" 
			},
			{ "name": "tipo_prato.nome" },
			{ "name": "pratos.nome" },
			{ "name": "pratos.valor" },
		    {
		    	'width':'15%',
		    	"name": "pratos.foto_url",
		    	"orderable":      false,
		    },
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
    $('#tabela_dados tbody').off("click",".view").on( 'click', '.view', function () {

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
		    url : pt_br.absolute_url+"/panel-control/pratos/ver",
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
/* ------------------------------------------------------------------ 
|	Preenche o select com os tipos de produtos cadastrados
------------------------------------------------------------------*/
$("#tipo").getTiposPratosSelect();
/*------------------------------------------------------------------------
|	Carrega informações via ajax para edição
|------------------------------------------------------------------------*/
$(document).off("click",".editar").on("click",".editar",function(){

	$("#editar").modal("show");
	var codigo = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);

	$.ajax({

    type: "GET",
    url : pt_br.absolute_url+"/panel-control/pratos/editar",
    data : {codigo:codigo},
    dataType: 'json'
    }).done(function(res){
    	
    	$("#edit_cod_prato").val(res[0].cod);
    	$("#tipo").val(res[0].cod_tipo_prato);
    	$("#titulo_modal").html("<b style='color:#d15e5e;'>"+res[0].prato.toUpperCase()+"</b>");
    	$("input[name=nome]").val(res[0].prato);
    	$("input[name=valor]").val(res[0].valor);
    	$("textarea[name=descricao]").text(res[0].descricao);
    	$("#foto_edicao").attr("src",res[0].foto_url);
    	$("#foto_edicao").attr("alt",res[0].foto_url);
    	$("#antiga_foto").val(res[0].foto_url);

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
	
	var dados = new FormData(document.querySelector("#edicao"));
	
	$.ajax({
		type: "POST",
        contentType: false,
        url : pt_br.absolute_url+"/panel-control/pratos/editar",
        enctype: 'multipart/form-data',
        data : dados,
        processData:false
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
    		$("#editar").modal("hide");
    		clearFormulario();
    		dataTable.ajax.reload();
    		alertSucesso(pt_br.msg_edicao_sucesso);

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
/*------------------------------------------------------------------------
|	FUNÇÃO DE CONFIRMAÇÃO DE EXCLUSÃO
|------------------------------------------------------------------------*/

$(document).off("click",".del").on("click",".del",function(){

	if(!confirm(pt_br.cofirmacao_deletar))
		return false;

	var id = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);
	$.ajax({
		type: "GET",
	    url: pt_br.absolute_url+"/panel-control/pratos/deletar",
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

    });

});

$(".imagem").on("change",function(){
	img = $("#foto_edicao");
	array = $(this).val().split("\\");
	alt = array[array.length-1];
	img.attr("alt",alt);
    readURL(this,img);
});



});
// Função que formata os dados para mostrar no detalhes da tabela
function format(f){

	string = '';
	string += "<b>"+pt_br.format_field_descricao+"</b>"+' '+f.descricao+'<br>';
	return string;

}
/* FUNÇÃO PARA CARREGAR A IMAGEM 	*/
function readURL(input,img) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            img.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function clearFormulario()
{
	$("#edicao input").each(function(){
		$(this).val("");
	});
	$("#foto_edicao").attr("src","").attr("alt","");
}

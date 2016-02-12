$(document).ready(function() {

	
/* ------------------------------------------------------------------ 
|	Cria os Botões de Ver,Editar e Excluir
------------------------------------------------------------------*/
var actions_buttons ='<a chref="#ver" class="abrir"><i class=" fa fa-eye fa-fw" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_ver+'"></i></a> ';
    actions_buttons +='<a chref="#concluir" class="concluir"><i class="text-success fa fa-check fa-fw" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_concluir+'"></i></a> ';
    actions_buttons +='<a chref="#pago" class="pago"><i class="text-primary fa fa-usd fa-fw" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_pago+'"></i></a> ';
    actions_buttons += '<a href="#rejeitar" class="rejeitar"><i class="text-danger fa fa-times fa-fw" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_rejeitar+'"></i></a>';
				    					 
/* ------------------------------------------------------------------ 
|	DataTables Plugin
------------------------------------------------------------------*/
var dataTable = $('#tabela_abertos').DataTable( {
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
			"url":pt_br.absolute_url+"/panel-control/pedidos/pedidosenviados",
			"type":"POST"
		},
		// Colunas propriedades
		"columns": [
			{ "name": "pedidos.cod" },
			{ 
                "width":"11.5%",
                "name": "pedidos.nro_mesa" 
            },
            { 
                "width":"20%",
                "name": "clientes.nome" 
            },
            { 
                "width":"12%",
                "name": "pedidos.data" 
            },
            { "name": "pedidos.horario" },
            { "name": "pedidos.status","data":5 },
            { "name": "pedidos.origem" },
            { "name": "pedidos.valor_total","width":"10%", },
		    {
                "width":"12.5%",
		    	"data":null,
		    	"orderable":      false,
		    	"defaultContent":actions_buttons
		    }
		  ]
});

$(document).off("click",".concluir").on("click",".concluir",function(){

    var codigo = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);
    status = $(this).parents("tr").children("td:eq(5)").children("span").attr("cod_status");

    
    if(status  != 2)
    {
        alertErro(pt_br.msg_erro_conclusao);
        return false;
    }
    
    $.ajax({

        type: "POST",
        url : pt_br.absolute_url+"/panel-control/pedidos/status",
        data : {codigo:codigo,status:4}
        }).done(function(res){
          
            if(parseInt(res,10) == 1)
            {
                dataTable.draw();
                alertSucesso(pt_br.msg_pedido_concluido);
            }
            else
            {
                alertErro(pt_br.msg_erro);
            }

        });

});

$(document).off("click",".pago").on("click",".pago",function(){

    codigo = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);
    status = $(this).parents("tr").children("td:eq(5)").children("span").attr("cod_status");

    
    if(status != 4)
    {
        alertWarning(pt_br.msg_erro_pagamento);
        return false;
    }
    
    $.ajax({

        type: "POST",
        url : pt_br.absolute_url+"/panel-control/pedidos/status",
        data : {codigo:codigo,status:5}
        }).done(function(res){
          
            if(parseInt(res,10) == 1)
            {
                dataTable.draw();
                alertSucesso(pt_br.msg_pedido_concluido);
            }
            else
            {
                alertErro(pt_br.msg_erro);
            }

        });

});
$("#aceitar").off("click").on("click",function(){

    var codigo = parseInt($("#pedido_cod").val(),10);
    
    $.ajax({

        type: "POST",
        url : pt_br.absolute_url+"/panel-control/pedidos/status",
        data : {codigo:codigo,status:2}
        }).done(function(res){
          
            if(parseInt(res,10) == 1)
            {
                $("#pe_modal").modal("hide");
                dataTable.draw();
                alertSucesso(pt_br.msg_pedido_aceito);
            }
            else
            {
                alertErro(pt_br.msg_erro);
            }

        });

});
$(document).off("click",".rejeitar").on("click",".rejeitar",function(){
    
    status = $(this).parents("tr").children("td:eq(5)").children("span").attr("cod_status");

    if(status != 1)
    {
        alertErro(pt_br.msg_erro_rejeicao);
        return false;
    }

    $("#pe_rejeitar").modal("show");
    var codigo = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);
    $("#cod_pedido_rejeitado").val(codigo);

});

$("#rejeitar").on('click', function(event) {


    if($("#observacoes").val() == "")
    {
        alertErro(pt_br.msg_erro_motivo);
        return false;
    }
    if(!confirm(pt_br.confirma_rejeicao))
        return false;
    dados = {};
    dados.codigo = parseInt($("#cod_pedido_rejeitado").val(),10);
    dados.observacoes = $("#motivo").val();
    dados.status = 3;
    $.ajax({

        type: "POST",
        url : pt_br.absolute_url+"/panel-control/pedidos/status",
        data : dados
        }).done(function(res){
          
            if(parseInt(res,10) == 1)
            {
                $("#pe_rejeitar").modal("hide");
                dataTable.draw();
                alertSucesso(pt_br.msg_pedido_rejetado);
                $("#cod_pedido_rejeitado").val("");
                $("#motivo").val("");
            }
            else
            {
                alertErro(pt_br.msg_erro);
            }

        });
});

/*------------------------------------------------------------------------
|	Carrega informações via ajax para visualizar os detalhes do pedido
|------------------------------------------------------------------------*/
$(document).off("click",".abrir").on("click",".abrir",function(){

	$("#pe_modal").modal("show");
	var codigo = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);

	$.ajax({

    type: "GET",
    url : pt_br.absolute_url+"/panel-control/pedidos/pedido",
    data : {codigo:codigo},
    dataType: 'json'
    }).done(function(res){

        if(res.cliente == null)
            $("#div_cliente").hide();
        else
            $("#div_cliente").show();

        if(res.status != 1)
        {
            $("#aceitar").hide();
        }
        else $("#aceitar").show();

        //dados do cliente
        $("#pedido_cod").val(res.cod_pedido);
        $("#spcliente").text(((res.cliente != null) ? res.cliente:''));
        $("#spendereco").text(((res.endereco != null) ? res.endereco:''));
        $("#sptelefone").text(((res.telefone != null) ? res.telefone:''));
        // dados do pedido
        $("#spdata_pedido").text(res.data);
        $("#sphorario").text(res.horario);
        $("#spnro_mesa").text(((res.nro_mesa != 0) ? res.nro_mesa:''));
        $("#spobs").text(res.observacoes);
        $("#valor_total").text(parseFloat(res.valor_total).toFixed(2));
    	
        $("#itens_bebidas_modal").empty();
        $("#itens_pedido_modal").empty();

        $.each(res.bebidas,function(ib, b) {
            l = "<tr>";
            l += "<td><b>"+b+"</b></td>";
            l += "</tr>";
            $("#itens_bebidas_modal").append(l);
        });

    	$.each(res.itens,function(index, it) {
            
            linha = "<tr class='active'>";
            linha += "<td>"+it.prato+"</td>";
            linha += "<td>"+it.quantidade+"</td>";
            linha += "</tr>";

            // variedades
            linha += "<tr><td colspan='2'>";
            linha += "<span><i class='fa fa-leaf'></i> <b>"+pt_br.format_field_variedade+"</b> ";
            $.each(it.variedades,function(index_v, v) {
               linha += v+"  ";
            });
            linha +="</span><br>";
            $.each(it.adicionais,function(cat, ad) {
                
                linha += "<span><i class='fa fa-check-square-o'></i> <b>"+cat+": </b> ";
                linha += "<ul class='list-inline'>";
                $.each(ad,function(j, d) {
                    
                    linha += '<li>';
                    linha += d+", ";
                    linha += '</li>';
                });
                linha += "</ul>";
                linha +="</span><br>";
            });
            linha += "</td></tr>";

            $("#itens_pedido_modal").append(linha);
        });

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
        url : pt_br.absolute_url+"/panel-control/bebidas/editar",
        enctype: 'multipart/form-data',
        data : dados,
        processData:false
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
    		$("#pe_modal").modal("hide");
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
/*------------------------------------------------------------------------
|	FUNÇÃO DE CONFIRMAÇÃO DE EXCLUSÃO
|------------------------------------------------------------------------*/

$(document).off("click",".del").on("click",".del",function(){

	if(!confirm(pt_br.cofirmacao_deletar))
		return false;

	var id = parseInt($(this).parents("tr").children("td:eq(0)").text(),10);
	$.ajax({
		type: "GET",
	    url: pt_br.absolute_url+"/panel-control/bebidas/deletar",
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

/* ------------------------------------------------------------------ 
|	Formata o input para aceitar apenas valores float
------------------------------------------------------------------*/
$(document).on("keyup",".float",function(){
	 var expre = /[^0-9.]/g;

    // REMOVE OS CARACTERES DA EXPRESSAO ACIMA
    if ($(this).val().match(expre))
        $(this).val($(this).val().replace(expre,''));
		
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
	string += "<b>"+pt_br.format_field_nome+"</b>"+' '+f.nome+'<br>';
    string += "<b>"+pt_br.format_field_preco+"</b>"+' '+f.valor+'<br>';
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


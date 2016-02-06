$(document).ready(function() {

/* ------------------------------------------------------------------ 
|	Preenche o select com as variedades cadastradas
------------------------------------------------------------------*/
$("#variedade").getVariedadeSelect();
var s2v = $("#variedade").select2();
/* ------------------------------------------------------------------ 
|   Preenche o select com os pratos cadastrados
------------------------------------------------------------------*/
$("#prato_2").getPratosSelect(0);
var s2p = $("#prato_2").select2();
/* ------------------------------------------------------------------ 
|	Evento de Cadastrar dados via Ajax
------------------------------------------------------------------*/
$("#salvar_variedade").on('click', function(event) {
	
	var validation = s2v.val() == "" || s2p.val() == "";
	if(validation)
	{
		alertErro(pt_br.campos_vazios);
		return false;
	}

	var dados = new FormData(document.querySelector("#cadastro_prato_variedade"));
	
	$.ajax({
		type: "POST",
        contentType: false,
        url : pt_br.absolute_url+"/panel-control/pratos-variedades/cadastrar",
        enctype: 'multipart/form-data',
        data : dados,
        processData:false
    }).done(function(res){
    	
    	if(parseInt(res,10) == 1)
    	{
	    	alertSucesso(pt_br.msg_cadastro_sucesso);
            searchTable();
	    	clearFormulario();
    	}
    	else if(parseInt(res,10) == 2)
        {
            alertErro(pt_br.msg_erro_existe);
        }

    });
});

searchTable();
/* ------------------------------------------------------------------ 
|	Limpar os campos do formulario
------------------------------------------------------------------*/
$("#cancelar").on("click",function(){
	clearFormulario();
});


$("#btn_pesquisar").off("click").on("click",function(){
    searchTable();
});

$("input[name=valor_buscado]").on("keyup",function(e){
     searchTable();
});

/*------------------------------------------------------------------------
|   FUNÇÃO DE CONFIRMAÇÃO DE EXCLUSÃO
|------------------------------------------------------------------------*/

$(document).off("click",".del").on("click",".del",function(){

    if(!confirm(pt_br.cofirmacao_deletar))
        return false;

    var codigo = $(this).parents("tr").children("td:eq(0)").attr("id");
    $.ajax({
        type: "GET",
        url: pt_br.absolute_url+"/panel-control/pratos-variedades/deletar",
        data: {codigo:codigo}
    }).done(function(res){
        
        if(parseInt(res,10) == 1)
        {
            searchTable();
            alertSucesso(pt_br.msg_exclusao_sucesso);
        }

    });

});


function clearFormulario()
{
    s2v.val("").change();
    s2p.val("").change();
}

});// fim document


function searchTable(){
    
    var dados = $("#form_pesquisa").serializeArray();

    $.ajax({
        type: "GET",
        dataType: 'json',
        url : pt_br.absolute_url+"/panel-control/pratos-variedades/pesquisar",
        data : dados,
    }).done(function(json){
            
        $("#dados_ajax").empty();

        $.each(json,function(i, item) {
            
            var linha = "<tr>";
                linha += "<td id="+item.cod_prato+"#"+item.cod_variedade+">"+item.prato+"</td>";
                linha += "<td>"+item.variedade+"</td>";
                linha += '<td>';
                linha += '<a href="#deletar" class="del"><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_deletar+'"></i></a></td>';
                linha += "</tr>";
            $("#dados_ajax").append(linha);
        });
    });
}



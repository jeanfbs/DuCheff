$(document).ready(function() {

spin = $("#ui-spinner").spinner({
    min:1,
    max:50,

});
spin.spinner("value",1);
$("#nomaximo").on('click', function(event) {

    if($(this).is(":checked"))
    {
        spin.val(-1);
        spin.hide();
    }
    else
    {
        spin.spinner( "value",1);
        spin.show();
    }
});
/* ------------------------------------------------------------------ 
|   Preenche o select com as categorias cadastradas
------------------------------------------------------------------*/
$("#categoria").getCategoriasSelect();
var s2c = $("#categoria").select2();
/* ------------------------------------------------------------------ 
|   Preenche o select com os pratos cadastrados
------------------------------------------------------------------*/
$("#prato_1").getPratosSelect(0);
var s2p = $("#prato_1").select2();
/* ------------------------------------------------------------------ 
|   Evento de Cadastrar dados via Ajax
------------------------------------------------------------------*/
$("#salvar_categoria").on('click', function(event) {
    
    var validation = s2c.val() == "" || s2p.val() == "";
    if(validation)
    {
        alertErro(pt_br.campos_vazios);
        return false;
    }

    var dados = new FormData(document.querySelector("#cadastro_prato_categoria"));
    
    $.ajax({
        type: "POST",
        contentType: false,
        url : pt_br.absolute_url+"/panel-control/pratos-categorias/cadastrar",
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
|   Limpar os campos do formulario
------------------------------------------------------------------*/
$("#cancelar_categoria").on("click",function(){
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

$(document).off("click",".del_cat").on("click",".del_cat",function(){

    if(!confirm(pt_br.cofirmacao_deletar))
        return false;

    var codigo = $(this).parents("tr").children("td:eq(0)").attr("id");
    $.ajax({
        type: "GET",
        url: pt_br.absolute_url+"/panel-control/pratos-categorias/deletar",
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
    s2c.val("").change();
    s2p.val("").change();
    spin.spinner( "value",0);
    spin.show();
    $("#nomaximo").prop('checked', '');
}

});// fim document


function searchTable(){
    
    var dados = $("#form_pesquisa_cat").serializeArray();

    $.ajax({
        type: "GET",
        dataType: 'json',
        url : pt_br.absolute_url+"/panel-control/pratos-categorias/pesquisar",
        data : dados,
    }).done(function(json){
            
        $("#dados_cat_ajax").empty();

        $.each(json,function(i, item) {
            
            var linha = "<tr>";
                linha += "<td id="+item.cod_prato+"#"+item.cod_categoria+">"+item.prato+"</td>";
                linha += "<td>"+item.categoria+"</td>";
                linha += '<td>';
                linha += '<a href="#deletar" class="del_cat"><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="'+pt_br.tooltip_deletar+'"></i></a></td>';
                linha += "</tr>";
            $("#dados_cat_ajax").append(linha);
        });
    });
}



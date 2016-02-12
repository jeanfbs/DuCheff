<style type="text/css" media="screen">
	.scrollable{overflow-y:scroll; max-height: 25em;}
</style>
<div class="box-content">
{{Form::open(array('class' => 'form-horizontal ','id' => 'cadastro_pedido','files' => true))}}
	<div class="row form-group">
		<label class="col-sm-2 control-label">{{trans('geral.tipo_pedido')}}</label>
		<div class="col-sm-6">
			<div class="radio-inline">
				<label>
					<input type="radio" name="tipo_pedido" checked class="pedido_tipo" value="0"> {{trans('geral.delivery')}}
					<i class="fa fa-circle-o"></i>
				</label>
			</div>
			<div class="radio-inline">
				<label>
					<input type="radio" name="tipo_pedido" class="pedido_tipo" value="1"> {{trans('geral.mesa')}}
					<i class="fa fa-circle-o"></i>
				</label>
			</div>
		</div>
	</div>
	<br>
	<div id="dados_cliente">
		<h4 class="page-header">{{trans('geral.header_cliente')}}</h4>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.cliente')}}</label>
			<div class="col-sm-8">
				<input type="hidden" name="cod_cliente" id="cod_cliente">
				<input type="text" class="form-control required" name="nome" maxlength="40" id="cliente_auto" maxlength="40" placeholder="{{trans('geral.cliente')}}" title="{{trans('geral.cliente')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.endereco')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="endereco" maxlength="70" placeholder="{{trans('geral.endereco')}}" title="{{trans('geral.endereco')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.telefone')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="telefone" maxlength="20" placeholder="{{trans('geral.telefone')}}" title="{{trans('geral.telefone')}}">
			</div>
		</div>
	</div>
	<h4 class="page-header">{{trans('geral.header_pedido')}}</h4>
	<div id="div_mesa">
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.nro_mesa')}}</label>
			<div class="col-sm-2">
				<input type="text" class="form-control integer" name="nro_mesa" value="0" maxlength="4">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="data" class="col-sm-2 control-label">{{trans('geral.data')}}</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="data" readonly name="data">
		</div>
		<label for="horario" class="col-sm-2 control-label">{{trans('geral.horario')}}</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="horario" readonly name="horario">
		</div>
	</div>
	<hr>
	<div class="panel panel-default">
	  <div class="panel-heading">
	  	<label class="pull-left">{{trans('geral.header_pedido_item')}}</label>
	  	<label class="pull-right">
	  		<a href="#info" title="{{trans('geral.title_info')}}" data-placement="left" data-toggle="popover" data-trigger="focus" data-content="{{trans('geral.ajuda_pedido_item')}}">
				<i class="fa fa-info-circle "></i>
			</a>
	  	</label>
	  	<label class="clearfix"></label>
	  </div>
	  <div class="panel-body">
	   		<div class="form-group">
				<label class="col-sm-2 control-label">*{{trans('geral.tipo')}}</label>
				<div class="col-sm-4">
					<select  name="cod_tipo_prato" id="tipo">
					  <option value=""></option>
					</select>
				</div>
				<label class="col-sm-1 control-label">*{{trans('geral.prato')}}</label>
				<div class="col-sm-5">
					<input type="hidden" id="valor_prato_escolhido">
					<select class="form-control" name="cod_prato" id="prato">
					  <option value=""></option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">*{{trans('geral.titulo_variedades')}}</label>
				<div class="col-sm-10" id="checks_variedades">
					<!-- Aqui ficará os checkboxs das variedades do prato selecionado -->
				</div>
			</div>
			<div class="form-group">
				<label for="qtd_spinner" class="col-sm-2 control-label">{{trans('geral.quantidade')}}</label>
				<div class="col-sm-2">
					<input type="text" id="qtd_spinner" value="1" name="quantidade" class="form-control">
				</div>
			</div>
			<br>
			<div class="form-group">
				<div class="col-sm-offset-5	col-sm-2">
					<button type="button" id="add_item" class="btn btn-primary btn-label-left">
					<span><i class="fa fa-plus"></i></span>
						{{trans('geral.button_adicionar')}}
					</button>
				</div>
			</div>
	  </div>
	</div>
	<!-- Tabela de Itens do Pedidos -->
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="box-content scrollable" id="box_table">
				<table class="table table-hover table-bordered table-striped">
					<thead>
						<tr class="active">
							<th>{{trans('geral.prato')}}</th>
							<th>{{trans('geral.quantidade')}}</th>
							<th>{{trans('geral.valor_unit')}}</th>
							<th>{{trans('geral.valor')}}</th>
							<th>{{trans('geral.variedade')}}</th>
							<th><a href="#limpar" id="limpar_itens" data-toggle="tooltip" data-placement="left" title="{{trans('geral.limpar')}}"><i class="fa fa-trash"></i></a></th>
						</tr>
					</thead>
					<tbody id="itens_pedido">

					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<h4 class="pull-right text-primary">{{trans('geral.rs')}}</h4>
							</td>
							<td colspan="1">
								<h4 class="pull-left text-primary" id="total_itens">0.00</h4>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<hr>
	<!-- Adicionar Bebidas ao pedido -->
	<div class="panel panel-default">
	  <div class="panel-heading">
	  	<label class="pull-left">{{trans('geral.header_pedido_bebidas')}}</label>
	  	<label class="pull-right">
	  		<a href="#info" title="{{trans('geral.title_info')}}" data-placement="left" data-toggle="popover" data-trigger="focus" data-content="{{trans('geral.ajuda_pedido_bebida')}}">
				<i class="fa fa-info-circle "></i>
			</a>
	  	</label>
	  	<label class="clearfix"></label>
	  </div>
	  <div class="panel-body">
	   		<div class="form-group">
	   			<label class="col-sm-2 control-label">*{{trans('geral.marca')}}</label>
				<div class="col-sm-4">
					<select  name="cod_bebida" id="bebidas">
					  <option value=""></option>
					</select>
				</div>
				<label for="qtd_spinner_bebida" class="col-sm-2 control-label">{{trans('geral.quantidade')}}</label>
				<div class="col-sm-2">
					<input type="text" id="qtd_spinner_bebida" value="1" name="qtd_bebida" class="form-control">
				</div>
				<div class="col-sm-2">
					<button type="button" id="add_bebida" class="btn btn-primary">
					<span><i class="fa fa-plus"></i></span>
					</button>
				</div>
			</div>
	  </div>
	</div>
	<!-- Tabela de Itens do Pedidos -->
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="box-content scrollable" id="tabela_bebidas">
				<table class="table table-hover table-bordered table-striped">
					<thead>
						<tr class="active">
							<th>{{trans('geral.titulo_bebidas')}}</th>
							<th style="width:12.5%;">{{trans('geral.valor_bebida_item')}}</th>
							<th style="width:12.5%;">{{trans('geral.quantidade')}}</th>
							<th style="width:12.5%;"><a href="#limpar" id="limpar_bebidas" data-toggle="tooltip" data-placement="left" title="{{trans('geral.limpar')}}"><i class="fa fa-trash"></i></a></th>
						</tr>
					</thead>
					<tbody id="itens_bebida">

					</tbody>
					<tfoot>
						<tr>
							<td colspan="3">
								<h4 class="pull-right text-primary">{{trans('geral.rs')}}</h4>
							</td>
							<td colspan="1">
								<h4 class="pull-left text-primary" id="valor_bebidas">0.00</h4>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<div class="col-md-offset-4">
			<h2>{{trans('geral.total')}} <span id="total"></span></h2>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.obs')}}</label>
			<div class="col-md-9">
				<textarea class="form-control" rows="3" name="observacoes"></textarea>
			</div>
		</div>
	</div>
	<hr>
	<br>
	<div class="clearfix"></div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-2">
			<button type="button" id="cancelar" class="btn btn-default btn-label-left">
			<span><i class="fa fa-times"></i></span>
				{{trans('geral.button_cancelar')}}
			</button>
		</div>
		<div class="col-sm-2">
			<button type="button" id="salvar_pedido" class="btn btn-primary btn-label-left">
			<span><i class="fa fa-check"></i></span>
				{{trans('geral.button_salvar')}}
			</button>
		</div>
	</div>


<!-- Modal -->
<div class="modal fade" id="detalhes" tabindex="-1" role="dialog" aria-labelledby="detalhes">
  <div class="modal-dialog modal-lg devoops-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans('geral.titulo_modal_detalhes')}} <span id="titulo_modal"><span></h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-12 col-sm-12">
      			<h4 class="page-header">{{trans('geral.header_detalhes')}}</h4>
      		</div>
      	</div>
      	<input type="hidden" id="cit"> <!-- Codigo do Item selecionado -->
		<!-- Tabela de Itens do Pedidos -->
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="box-content scrollable" id="box_table">
					<table class="table table-bordered">
						<thead>
							<tr class="active">
								<th>{{trans('geral.categoria')}}</th>
								<th style='width:65px;'>{{trans('geral.max')}}</th>
							</tr>
						</thead>
						<tbody id="itens_adicionais">

						</tbody>
					</table>
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('geral.button_cancelar')}}</button>
        <button type="button" class="btn btn-primary" id="salvar_adicionais">{{trans('geral.button_salvar')}}</button>
      </div>
    </div>
  </div>
</div>
{{Form::close()}}
</div>



<script src="{{url('js/pedidos/cadastro.js')}}" type="text/javascript" charset="utf-8"></script>




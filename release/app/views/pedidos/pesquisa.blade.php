<link rel="stylesheet" type="text/css" href="{{url('plugins/datatables/css/dataTables.bootstrap.min.css')}}">
<style type="text/css" media="screen">
	table{width: 100%!important;}
	.dataTables_scrollHeadInner{width: 100%!important;}
</style>
<div class="row">
	<div class="col-xs-12">
		<div class="box-content no-padding">
			<table class="table table-bordered table-striped table-hover" id="tabela_abertos">
				<thead>
					<tr class="active">
						<th>{{trans('geral.codigo')}}</th>
						<th>{{trans('geral.nro_mesa')}}</th>
						<th>{{trans('geral.cliente')}}</th>
						<th>{{trans('geral.coluna_data')}}</th>
						<th>{{trans('geral.horario')}}</th>
						<th>{{trans('geral.status')}}</th>
						<th>{{trans('geral.origem')}}</th>
						<th>{{trans('geral.coluna_total')}}</th>
						<th>{{trans('geral.acao')}}</th>
					</tr>
				</thead>
				<tbody id="abertos">
					
				</tbody>
				
			</table>
		</div>
	</div>	
</div>

<!-- Modal Pedido Enviado Modal-->
<div class="modal fade" id="pe_modal" tabindex="-1" role="dialog" aria-labelledby="pe_modal">
  <div class="modal-dialog modal-lg devoops-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans('geral.titulo_modal_pedido')}}</h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('class' => 'form-horizontal ','id' => 'form_detalhes'))}}
		<h4 class="page-header">{{trans('geral.title_info')}}</h4>
		<div id="div_cliente">
			<div class="form-group">
				<input type="hidden" id="pedido_cod">
				<label class="col-sm-2 control-label">{{trans('geral.cliente')}}</label>
				<span class="col-sm-5" id="spcliente"></span>
				<label class="col-sm-2 control-label">{{trans('geral.telefone')}}</label>
				<span class="col-sm-3" id="sptelefone"></span>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">{{trans('geral.endereco')}}</label>
				<span class="col-sm-5" id="spendereco"></span>
			</div>
			<hr>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.data')}}</label>
			<span class="col-sm-2" id="spdata_pedido"></span>
			<label class="col-sm-2 control-label">{{trans('geral.nro_mesa')}}</label>
			<span class="col-sm-2" id="spnro_mesa"></span>
			<label class="col-sm-2 control-label">{{trans('geral.horario')}}</label>
			<span class="col-sm-2" id="sphorario"></span>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.obs')}}</label>
			<p class="col-sm-8" id="spobs"></p>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="box-content" id="tabela_bebidas">
					<table class="table">
						<thead>
							<tr>
								<th>{{trans('geral.titulo_bebidas')}}</th>
							</tr>
						</thead>
						<tbody id="itens_bebidas_modal">
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-offset-4">
				<h3 class="text-danger">{{trans('geral.total')}} <span id="valor_total"></span></h3>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="box-content" id="tabela_itens">
					<table class="table table-bordered">
						<thead>
							<tr class="danger">
								<th>{{trans('geral.prato')}}</th>
								<th style='width:120px;'>{{trans('geral.quantidade')}}</th>
							</tr>
						</thead>
						<tbody id="itens_pedido_modal">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	{{Form::close()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('geral.button_cancelar')}}</button>
        <button type="button" class="btn btn-primary" id="aceitar">{{trans('geral.button_aceitar')}}</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Rejeição de Pedidos -->
<div class="modal fade" id="pe_rejeitar" tabindex="-1" role="dialog" aria-labelledby="pe_rejeitar">
  <div class="modal-dialog  devoops-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans('geral.titulo_modal_rejeitar')}}</h4>
      </div>
      <div class="modal-body">
	    {{Form::open(array('class' => 'form-horizontal ','id' => 'form_rejeitar_pedido'))}}
			<input type="hidden" id="cod_pedido_rejeitado" />
			<div class="form-group">
				<label class="col-sm-2 control-label">{{trans('geral.motivo')}}</label>
				<div class="col-md-9">
					<textarea class="form-control" rows="3" id="motivo"></textarea>
				</div>
			</div>
		{{Form::close()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('geral.button_cancelar')}}</button>
        <button type="button" class="btn btn-danger" id="rejeitar">{{trans('geral.button_rejeitar')}}</button>
      </div>
    </div>
  </div>
</div>
<script src="{{url('plugins/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{url('plugins/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{url('js/pedidos/pesquisa.js')}}"></script>


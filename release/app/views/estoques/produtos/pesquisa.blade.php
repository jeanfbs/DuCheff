<link rel="stylesheet" type="text/css" href="{{url('plugins/datatables/css/dataTables.bootstrap.min.css')}}">
<style type="text/css" media="screen">
	table{width:100%!important;}
	.dataTables_scrollHeadInner{width: 100%!important;}
</style>
<h4 class="page-header">{{trans('geral.header_pesquisa')}}</h4>
<div class="row">
<form>
	<div class="form-group">
		<div class="col-xs-2">
	    	<label>{{trans('geral.min')}}</label>
	    	<input type="text" class="form-control" id="min" >
	    </div>
	    <div class="col-xs-2">
	    	<label>{{trans('geral.max')}}</label>
	    	<input type="text" class="form-control" id="max">
	    </div>
	</div>
</form>
</div>
<hr>
<div class="row">
	<div class="col-xs-12">
		<div class="box-content no-padding">
			<table class="table table-bordered table-striped table-hover" id="tabela_dados_estoque">
				<thead>
					<tr class="active">
						<th>{{trans('geral.codigo')}}</th>
						<th>{{trans('geral.produto')}}</th>
						<th>{{trans('geral.qtd_atual')}}</th>
						<th>{{trans('geral.dt_entrada')}}</th>
						<th>{{trans('geral.dt_vencimento')}}</th>
						<th>{{trans('geral.acao')}}</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				
			</table>
		</div>
	</div>	
</div>

<!-- Modal -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="editar">
  <div class="modal-dialog devoops-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{trans('geral.titulo_modal')}} <span id="titulo_modal"><span></h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('class' => 'form-horizontal ','id' => 'edicao_estoque'))}}
		<div class="form-group">
			<input type="hidden" id="edit_cod" name="cod">
			<label class="col-sm-3 control-label">*{{trans('geral.qtd_atual')}}</label>
			<div class="col-sm-3">
				<input type="text" class="form-control required float" name="qtd_atual" placeholder="{{trans('geral.qtd_atual')}}" title="{{trans('geral.qtd_atual')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">*{{trans('geral.uni_medida')}}</label>
			<div class="col-md-3">
				<select class="form-control" name="unidade_medida">
					<option value=""></option>
					<option value="UN">UN</option>
					<option value="KG">KG</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">*{{trans('geral.dt_entrada')}}</label>
			<div class="col-xs-4">
				<input type="text" class="form-control required datepicker"  name="data_entrada">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">*{{trans('geral.dt_vencimento')}}</label>
			<div class="col-xs-4">
				<input type="text" class="form-control required datepicker"  name="data_vencimento">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">{{trans('geral.obs')}}</label>
			<div class="col-md-8">
				<textarea class="form-control" rows="3" name="observacoes"></textarea>
			</div>
		</div>
	{{Form::close()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('geral.button_cancelar')}}</button>
        <button type="button" class="btn btn-primary" id="salvar_edicao">{{trans('geral.button_salvar')}}</button>
      </div>
    </div>
  </div>
</div>
<script src="{{url('plugins/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{url('plugins/datatables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{url('js/estoques/produtos/pesquisa.js')}}"></script>


<link rel="stylesheet" type="text/css" href="{{url('plugins/datatables/css/dataTables.bootstrap.min.css')}}">
<style type="text/css" media="screen">
	table{width:100%!important;}
	.dataTables_scrollHeadInner{width: 100%!important;}
</style>
<div class="row">
	<div class="col-xs-12">
		<div class="box-content no-padding">
			<table class="table table-bordered table-striped table-hover" id="tabela_dados_clientes">
				<thead>
					<tr class="active">
						<th>{{trans('geral.codigo')}}</th>
						<th>{{trans('geral.nome')}}</th>
						<th>{{trans('geral.endereco')}}</th>
						<th>{{trans('geral.telefone')}}</th>
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
        {{Form::open(array('class' => 'form-horizontal ','id' => 'edicao'))}}
		<div class="form-group">
			<input type="hidden" id="edit_cod" name="cod">
			<label class="col-sm-2 control-label">{{trans('geral.login')}}</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="login" maxlength="15" placeholder="{{trans('geral.login')}}" title="{{trans('geral.login')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.senha')}}</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" name="senha" placeholder="{{trans('geral.senha')}}" title="{{trans('geral.senha')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.nome')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="nome" maxlength="40" placeholder="{{trans('geral.nome')}}" title="{{trans('geral.nome')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.endereco')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="endereco" maxlength="40" placeholder="{{trans('geral.endereco')}}" title="{{trans('geral.endereco')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.cidade')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="cidade" maxlength="40" placeholder="{{trans('geral.cidade')}}" title="{{trans('geral.cidade')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.telefone')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="telefone" maxlength="40" placeholder="{{trans('geral.telefone')}}" title="{{trans('geral.telefone')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.email')}}</label>
			<div class="col-sm-8">
				<input type="email" class="form-control" name="email" maxlength="40" placeholder="{{trans('geral.email')}}" title="{{trans('geral.email')}}">
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
<script src="{{url('js/clientes/pesquisa.js')}}"></script>


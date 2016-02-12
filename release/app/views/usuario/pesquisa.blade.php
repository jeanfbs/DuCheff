<link rel="stylesheet" type="text/css" href="{{url('plugins/datatables/css/dataTables.bootstrap.min.css')}}">
<style type="text/css" media="screen">
	table{width:100%!important;}
	.dataTables_scrollHeadInner{width: 100%!important;}
</style>
<div class="row">
	<input type="hidden" id="nivel_user" value="{{Session::get('nivel_user')}}">
	<div class="col-xs-12">
		<div class="box-content no-padding">
			<table class="table table-bordered table-striped table-hover" id="tabela_dados">
				<thead>
					<tr class="active">
						<th>{{trans('geral.codigo')}}</th>
						<th>{{trans('geral.nome')}}</th>
						<th>{{trans('geral.nivel')}}</th>
						<th>{{trans('geral.login')}}</th>
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
			<label class="col-sm-2 control-label">*{{trans('geral.nome')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="nome" maxlength="40" placeholder="{{trans('geral.nome')}}" title="Nome">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.login')}}</label>
			<div class="col-sm-4">
				<input type="text" class="form-control required" name="login" maxlength="15" placeholder="{{trans('geral.login')}}" title="Login">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.senha')}}</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" name="senha" placeholder="{{trans('geral.senha')}}" title="Senha">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.nivel')}}</label>
			<div class="col-sm-4">
				<select class="form-control" name="nivel" title="Nivel de Acesso">
				  <option value="1">{{trans('geral.nivel_admin')}}</option>
				  <option value="2">{{trans('geral.nivel_atendente')}}</option>
				</select>
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
<script src="{{url('js/usuario/pesquisa.js')}}"></script>


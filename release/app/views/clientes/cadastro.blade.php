<div class="box-content">
	<h4 class="page-header">{{trans('geral.header_cliente')}}</h4>
{{Form::open(array('class' => 'form-horizontal ','id' => 'cadastro','files' => true))}}
		<div class="form-group">
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
			<div class="col-sm-4">
				<input type="text" class="form-control required" name="cidade" maxlength="40" placeholder="{{trans('geral.cidade')}}" title="{{trans('geral.cidade')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.telefone')}}</label>
			<div class="col-sm-4">
				<input type="text" class="form-control required" name="telefone" maxlength="25" placeholder="{{trans('geral.telefone')}}" title="{{trans('geral.telefone')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.email')}}</label>
			<div class="col-sm-8">
				<input type="email" class="form-control" name="email" maxlength="40" placeholder="{{trans('geral.email')}}" title="{{trans('geral.email')}}">
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-2">
				<button type="button" id="cancelar" class="btn btn-default btn-label-left">
				<span><i class="fa fa-times"></i></span>
					{{trans('geral.button_cancelar')}}
				</button>
			</div>
			<div class="col-sm-2">
				<button type="button" id="salvar" class="btn btn-primary btn-label-left">
				<span><i class="fa fa-check"></i></span>
					{{trans('geral.button_salvar')}}
				</button>
			</div>
		</div>
	{{Form::close()}}
</div>

<script src="{{url('js/clientes/cadastro.js')}}" type="text/javascript" charset="utf-8"></script>




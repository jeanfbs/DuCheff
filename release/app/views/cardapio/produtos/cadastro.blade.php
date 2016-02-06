<div class="box-content">
	<h4 class="page-header">{{trans('geral.header_produtos')}}</h4>
{{Form::open(array('class' => 'form-horizontal ','id' => 'cadastro','files' => true))}}
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.produto')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="nome" maxlength="30" placeholder="{{trans('geral.produto')}}" title="{{trans('geral.produto')}}">
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

<script src="{{url('js/cardapio/produtos/cadastro.js')}}" type="text/javascript" charset="utf-8"></script>




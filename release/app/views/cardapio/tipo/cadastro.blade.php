<div class="box-content">
	<h4 class="page-header">{{trans('geral.header_tipo')}}</h4>
{{Form::open(array('class' => 'form-horizontal ','id' => 'cadastro','files' => true))}}
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.tipo')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="nome" maxlength="30" placeholder="{{trans('geral.tipo')}}" title="{{trans('geral.tipo')}}">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<img style='max-width: 100px; max-height: 100px;' id="photo"/><br><br>
				<div class='btn btn-primary btn-xs btn-file'> <i class='fa fa-camera'></i> {{trans('geral.add_foto')}}<input  type='file' name='foto' class='file imagem'></div>
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

<script src="{{url('js/cardapio/tipo/cadastro.js')}}" type="text/javascript" charset="utf-8"></script>




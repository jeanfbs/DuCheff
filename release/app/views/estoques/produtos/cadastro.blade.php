<div class="box-content">
	<h4 class="page-header">{{trans('geral.header_estoque')}}</h4>
{{Form::open(array('class' => 'form-horizontal ','id' => 'cadastro_estoque'))}}
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.produto')}}</label>
			<div class="col-sm-4">
				<select  name="cod_produto" id="produtos">
				  <option value=""></option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.qtd_entrada')}}</label>
			<div class="col-sm-3">
				<input type="text" class="form-control required float" name="qtd_entrada" placeholder="{{trans('geral.qtd_entrada')}}" title="{{trans('geral.qtd_entrada')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.uni_medida')}}</label>
			<div class="col-md-2">
				<select class="form-control" name="unidade_medida">
					<option value=""></option>
					<option value="UN">UN</option>
					<option value="KG">KG</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.dt_entrada')}}</label>
			<div class="col-xs-3">
				<input type="text" class="form-control required datepicker"  name="data_entrada">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.dt_vencimento')}}</label>
			<div class="col-xs-3">
				<input type="text" class="form-control required datepicker"  name="data_vencimento">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.obs')}}</label>
			<div class="col-md-9">
				<textarea class="form-control" rows="3" name="observacoes"></textarea>
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

<script src="{{url('js/estoques/produtos/cadastro.js')}}" type="text/javascript" charset="utf-8"></script>




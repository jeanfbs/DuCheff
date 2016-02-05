<style type="text/css" media="screen">
	#box_table{ max-height:20em; overflow-y:scroll;}
</style>
<div class="box-content">
	<h4 class="page-header">{{trans('geral.header_prato_categoria_cadastro')}}</h4>
{{Form::open(array('class' => 'form-horizontal ','id' => 'cadastro_prato_categoria','files' => true))}}
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.prato')}}</label>
			<div class="col-sm-4">
				<select  name="cod_prato" id="prato_1">
				  
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.categoria')}}</label>
			<div class="col-sm-4">
				<select  name="cod_categoria" id="categoria">
				  <option value=""></option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="ui-spinner" class="col-sm-2 control-label">{{trans('geral.maximo')}}</label>
			<div class="col-sm-4">
				<input type="text" id="ui-spinner" name="limite" class="form-control">
			</div>
			<div class="col-sm-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="nomaximo"> {{trans('geral.nomaximo')}}
						<i class="fa fa-square-o small"></i>
					</label>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-2">
				<button type="button" id="cancelar_categoria" class="btn btn-default btn-label-left">
				<span><i class="fa fa-times"></i></span>
					{{trans('geral.button_cancelar')}}
				</button>
			</div>
			<div class="col-sm-2">
				<button type="button" id="salvar_categoria" class="btn btn-primary btn-label-left">
				<span><i class="fa fa-check"></i></span>
					{{trans('geral.button_salvar')}}
				</button>
			</div>
		</div>
	{{Form::close()}}
</div>
<hr>
<br>
<h4 class="page-header">{{trans('geral.header_prato_categoria_pesquisa')}}</h4>
<form id="form_pesquisa_cat">
	<div class="form-group">
		<div class="col-md-3">
			<select class="form-control" name="filtro">
			  <option value="pratos.nome">{{trans('geral.prato')}}</option>
			  <option value="categorias.nome">{{trans('geral.categoria')}}</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group pull-right col-md-6">
	      <input type="text" class="form-control required" name="valor_buscado" placeholder="{{trans('geral.pesquisar')}}">
	      <span class="input-group-btn">
	        <button class="btn btn-primary" type="button" id="btn_pesquisar"><i class="fa fa-search"></i></button>
	      </span>

	    </div><!-- /input-group -->
	</div>
</form>
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-table"></i>
					<span>{{trans('geral.header_prato_categoria_table')}}</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content" id="box_table">
				<table class="table table-hover table-bordered table-striped">
					<thead>
						<tr>
							<th>{{trans('geral.prato')}}</th>
							<th>{{trans('geral.categoria')}}</th>
							<th>{{trans('geral.acao')}}</th>
						</tr>
					</thead>
					<tbody id="dados_cat_ajax">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="{{url('js/cardapio/pratos/adicionais.js')}}" type="text/javascript" charset="utf-8"></script>




<link rel="stylesheet" type="text/css" href="{{url('plugins/datatables/css/dataTables.bootstrap.min.css')}}">
<style type="text/css" media="screen">
	table{width:100%!important;}
	.dataTables_scrollHeadInner{width: 100%!important;}
</style>
<h4 class="page-header">{{trans('geral.header_busca_preco')}}</h4>
<div class="row">
<form>
	<div class="form-group">
		<div class="col-xs-2">
	    	<label for="exampleInputName2">{{trans('geral.min')}}</label>
	    	<input type="text" class="form-control" id="min" >
	    </div>
	    <div class="col-xs-2">
	    	<label for="exampleInputName2">{{trans('geral.max')}}</label>
	    	<input type="text" class="form-control" id="max">
	    </div>
	</div>
</form>
</div>
<hr>
<div class="row">
	<div class="col-xs-12">
		<div class="box-content no-padding">
			<table class="table table-bordered table-striped table-hover" id="tabela_dados">
				<thead>
					<tr class="active">
						<th>{{trans('geral.codigo')}}</th>
						<th>{{trans('geral.tipo')}}</th>
						<th>{{trans('geral.prato')}}</th>
						<th>{{trans('geral.preco')}}</th>
						<th>{{trans('geral.foto')}}</th>
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
        {{Form::open(array('class' => 'form-horizontal ','id' => 'edicao','files' => true))}}
        <input type="hidden" id="edit_cod_prato" name="cod">
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.tipo')}}</label>
			<div class="col-sm-4">
				<select  class="form-control" name="cod_tipo_prato" id="tipo">
				  <option value=""></option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.prato')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="nome" maxlength="30" placeholder="{{trans('geral.prato')}}" title="{{trans('geral.prato')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.preco')}}</label>
			<div class="col-sm-4">
				<input type="text" class="form-control required float" name="valor" placeholder="Ex: 2.50" title="{{trans('geral.preco')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">{{trans('geral.descricao')}}</label>
			<div class="col-sm-8">
				<textarea class="form-control" rows="3" name="descricao" title="{{trans('geral.descricao')}}"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<img style='max-width: 100px; max-height: 100px;' id="foto_edicao"/><br><br>
				<input type="hidden" name="antiga_foto" id="antiga_foto">
				<div class='btn btn-primary btn-xs btn-file'> <i class='fa fa-camera'></i> {{trans('geral.add_foto')}}<input  type='file' name='foto' class='file imagem'></div>
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
<script src="{{url('js/cardapio/pratos/pesquisa.js')}}"></script>


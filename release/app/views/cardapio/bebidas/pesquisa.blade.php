<link rel="stylesheet" type="text/css" href="{{url('plugins/datatables/css/dataTables.bootstrap.min.css')}}">
<style type="text/css" media="screen">
	table{width:100%!important;}
	.dataTables_scrollHeadInner{width: 100%!important;}
</style>
<div class="row">
	
	<div class="col-xs-12">
		<div class="box-content no-padding">
			<table class="table table-bordered table-striped table-hover" id="tabela_dados">
				<thead>
					<tr class="active">
						<th>{{trans('geral.codigo')}}</th>
						<th>{{trans('geral.marca')}}</th>
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
        {{Form::open(array('method'=>'GET', 'url'=>'panel-control/bebidas', 'class' => 'form-horizontal ','id' => 'edicao','files' => true))}}
		<div class="form-group">
			<input type="hidden" id="edit_cod" name="cod">
			<label class="col-sm-2 control-label">*{{trans('geral.marca')}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" name="nome" maxlength="40" placeholder="{{trans('geral.marca')}}" title="{{trans('geral.marca')}}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">*{{trans('geral.preco')}}</label>
			<div class="col-sm-4">
				<input type="text" class="form-control required float" name="valor" placeholder="{{trans('geral.preco')}}" title="{{trans('geral.preco')}}">
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
<script src="{{url('js/cardapio/bebidas/pesquisa.js')}}"></script>


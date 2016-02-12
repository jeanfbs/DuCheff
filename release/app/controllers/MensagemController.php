<?php 

class MensagemController extends BaseController{


	public function getIndex()
	{
		$dados = array();
		$dados["status"] = 2;
		$result = DB::table('comentarios')
		->where("status",1)
        ->update($dados);

        $comentarios = DB::table("comentarios")
        ->join("clientes","comentarios.cod_cliente","=","clientes.cod")
        ->select("comentarios.cod","comentarios.data","comentarios.tipo",
                "comentarios.horario","comentarios.mensagem","comentarios.status",
                "clientes.nome","clientes.email")
        ->orderBy("comentarios.cod","desc")
        ->take(10)
        ->get();
        
        foreach ($comentarios as $key => $value) {
        	
        	$tmp = $value->data;
        	$explode = explode("-", $tmp);
        	$ndata = $explode[2]."/".$explode[1]."/".$explode[0];
        	$value->data = $ndata;
        }

        $extra = [
        	"comentarios" => $comentarios 
        ];
		return View::make('mensagens.mensagens')->with($extra);
	}


	public function getNovoscomentarios(){

		$comentarios = ComentarioModel::
		where("status",1)
		->get();

		return count($comentarios);
	}
}
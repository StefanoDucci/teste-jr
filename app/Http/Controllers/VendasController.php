<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;

class VendasController extends ApiController
{
    /**
     * [Metodo de retorno de todas os registros do banco de dados]
     * @method index
     * @return [array]
     */
    public function index()
    {

        $vendas = Venda::all();

        return response()->json([
            'data' => $this->transformCollection($vendas)
        ], 200);

    }

    /**
     * [Metodo de retorno de apenas um único registro do banco de dados]
     * @method show
     * @param  [inteiro] $id [Identificador do registro no banco de dados]
     * @return [array]
     */
    public function show($id)
    {

      $venda = Venda::find($id);

      if ( ! $venda)
      {
          return $this->respondNotFound('Esta venda não existe.');
      }

      return response()->json([
          'data' => $this->transform($venda)
      ], 200);
    }

    /**
     * [Metodo para armazenar um novo registro no bando de dados]
     * @method store
     * @return [array] [Dados: nome, email e comissão(8.5% do valor de entrada do valor da venda)]
     */
    public function store()
    {
      $this->validate(request(),[
        'nome' => 'required',
        'email' => 'required',
        'valor_venda' => 'required'
      ]);

        Venda::create(request()->all());

        return [
          'nome' => request()->get('nome'),
          'email' => request()->get('email'),
          'comissao' => request()->get('valor_venda') * 0.085
        ];
    }

    /**
     * [Metodo que varre um array de registros do banco de dados e submete cada um ao metodo transform]
     * @method transformCollection
     * @param  [array]              $vendas [Um array contendo um registro vindo do banco de dados]
     * @return [array]                      [Um array onde cada indice do array de entrada passa pelo metodo transform]
     */
    private function transformCollection($vendas)
    {
        return array_map([$this, 'transform'], $vendas->toArray());
    }

    /**
     * [Metodo que altera o tipo de dado que será enviado para a requisição]
     * @method transform
     * @param  [type]    $venda [description]
     * @return [type]           [description]
     */
    private function transform($venda)
    {
        return [
            'nome' => $venda['nome'],
            'email' => $venda['email'],
            'comissao' => (float) $venda['valor_venda']
        ];
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;
use Validator;

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
     * @return array
     */
    public function show($id)
    {

        $venda = Venda::find($id);

        if (! $venda) {
            return $this->respondNotFound('Esta venda não existe.');
        }

        return response()->json([
          'data' => $this->transform($venda)
        ], 200);
    }

    /**
     * [store description]
     * @method store
     * @param  Request $request [Dados da requisão]
     * @return array  [Array de erro ou array dos dados da inserção
     *                  com a comissão sendo 8.5% do valor da venda cadastrada]
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
        'nome' => 'required:string',
        'email' => 'required:email',
        'valor_venda' => 'required:numeric'
        ]);

        if ($validator->fails()) {
            return $this->respondAuthFailed('Ocorreu um erro durante a validação dos dados.');
        }

        Venda::create(request()->all());

        return [
          'nome' => $request->get('nome'),
          'email' => $request->get('email'),
          'comissao' => $request->get('valor_venda') * 0.085
        ];
    }

    /**
     * [Metodo que varre um array de registros do banco de dados e submete cada um ao metodo transform]
     * @method transformCollection
     * @param  array            $vendas [Um array contendo um registro vindo do banco de dados]
     * @return array                      [Um array onde cada indice do array de entrada passa pelo metodo transform]
     */
    private function transformCollection($vendas)
    {
        return array_map([$this, 'transform'], $vendas->toArray());
    }

    /**
     * [Metodo que altera o tipo de dado que será enviado para a requisição]
     * @method transform
     * @param  array    $venda [Array dos registros de uma busca no banco de dados]
     * @return array           [Formatação dos tipos dos dados enviados para a requisição]
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

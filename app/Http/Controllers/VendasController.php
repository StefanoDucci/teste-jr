<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;

class VendasController extends ApiController
{

    public function index()
    {

        $vendas = Venda::all();

        return response()->json([
            'data' => $this->transformCollection($vendas)
        ], 200);

    }


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


    public function store()
    {
        if ( ! request()->get('name') or ! request()->get('email') or ! request()->get('comissao'))
        {
          return $this->setStatusCode(422)->respondWithError('Falha na validação dos parâmetros da venda.');
        }

        $param = [
          'name' => request()->get('name'),
          'email' => request()->get('email'),
          'comissao' => request()->get('comissao') * 0.085
        ];

        Venda::create($param);

        return $this->setStatusCode(201)->respond([
            'message' => 'Venda registrada com sucesso.'
        ]);

    }


    private function transformCollection($vendas)
    {
        return array_map([$this, 'transform'], $vendas->toArray());
    }

    private function transform($venda)
    {
        return [
            'name' => $venda['name'],
            'email' => $venda['email'],
            'comissao' => (float) $venda['comissao']
        ];
    }


}

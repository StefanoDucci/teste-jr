<?php
namespace App\Http\Controllers;

class ApiController extends Controller
{

    protected $statusCode = 200;

    /**
     * [getStatusCode]
     * @method getStatusCode
     * @return mix
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * [setStatusCode]
     * @method setStatusCode
     * @param  mix        $statusCode [Variavel para retorno default]
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * [Metodo para informar uma falha na requisição]
     * @method respondNotFound
     * @param  string          $message [Mensagem default para este metodo]
     * @return array                   [Um array contendo a mensagem e o código do erro]
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * [Metodo para informar uma falha na autenticação nos dados enviados pelo POST]
     * @method respondAuthFailed
     * @param  string            $message [Mensagem default para este metodo]
     * @return array                     [Um array contendo a mensagem e o código do erro]
     */
    public function respondAuthFailed($message = 'Invalid Data')
    {
        return $this->setStatusCode(422)->respondWithError($message);
    }

    /**
     * [Metodo construtor da resposta de erro]
     * @method respond
     * @param  array  $data    [Um array com as informações do erro]
     * @param  array   $headers
     * @return mix
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * [Metodo para definir o array de retorno do erro]
     * @method respondWithError
     * @param  string           $message [Mensagem de descrição do erro]
     * @return array                    [Um array contendo a mensagem e o código do erro]
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }
}

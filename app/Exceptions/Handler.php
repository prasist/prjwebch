<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\CustomException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        //Tratamento de erros para PDOException

          if($e->getCode())
          {
                return view('errors.msgerro')
                ->with('erro',
                    [
                        'titulo' => 'Integridade Referencial',
                        'codigo'=> $e->getCode(),
                        'mensagem'=> 'Não foi possível excluir o registro, pois ele possui referência(s) em outra(s) tabela(s).',
                        'mensagem_original'=> $e->getMessage()
                    ]);
          }

          //Tratamento para página não encontrada
          if ($e instanceof NotFoundHttpException)
          {
             return redirect()->to('errors.404');
          }

          //outro tipo de erro não tratado
            return parent::render($request, $e);
    }
}

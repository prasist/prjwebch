<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //Verificação : Se for usuário recém cadastrado, verifica se já cadastrou os dados da empresa
        $gate->define('verifica_permissao', function ($user, $pagina, $acao)
        {

                //--------Verificar se o usuario ja cadastrou os dados da empresa
                $cadastrou = \App\Models\usuario::findOrfail($user->id);

                if ($cadastrou) //Verifica se cadastrou os dados da empresa
                {

                    //Verifica se a empresa logada é sede, para das as devidas permissoes ao master
                    $verifica_sede = \App\Models\empresas::select('igreja_sede')->findOrfail($cadastrou->empresas_id);

                    \Session::put('master_sede', $verifica_sede);
                    \Session::put('dados_login', $cadastrou);
                    \Session::put('tour_rapido', $cadastrou->tutorial);
                    \Session::put('tour_visaogeral', $cadastrou->tutorial_visaogeral);

                    //Ler todas permissoes do usuarios
                    $permissoes = \DB::select('select incluir, alterar, excluir, visualizar, exportar, acessar, imprimir from view_permissoes_grupo where view_permissoes_grupo.usuario = ? and id_pagina = ? ', [$user->id, $pagina]);

                    if ($permissoes)
                    {

                            switch ($acao) {
                                case 'incluir':
                                    if ($permissoes[0]->incluir == 1) return true;
                                    break;

                                case 'alterar':

                                    if ($permissoes[0]->alterar == 1) return true;
                                    break;

                                case 'excluir':
                                    if ($permissoes[0]->excluir == 1)  return true;
                                    break;

                                case 'visualizar':
                                    if ($permissoes[0]->visualizar == "1")  return true;
                                    break;

                                case 'exportar':
                                    if ($permissoes[0]->exportar == 1)  return true;
                                    break;

                                case 'imprimir':
                                    if ($permissoes[0]->imprimir == 1)  return true;
                                    break;

                                case 'acessar':
                                    if ($permissoes[0]->acessar == "1")  return true;
                                    break;

                                default:
                                    return true; //retorna true mesmo nao encontrando a ação, pois pode ser validacao somente se o usuario cadastrou os dados da empresa
                                    break;
                            }

                    }
                    else //Não encontrou permissao para a pagina
                    {
                          return false;
                    }

                }
                else // Verifica se cadastrou os dados da empresa
                {
                    return false;
                }

        });

    }
}
<?php

namespace App;

use App\Init\Bootstrap;

/**
 * Class Init
 * @package App
 */
class Init extends Bootstrap
{

    /**
     * Método para setar rotas, baseadas em controlers e actions
     */
    protected function initRoutes()
    {
        $ar['home'] = ['route' => '/', 'controller' => 'index', 'action' => 'index'];
        $ar['cadastro'] = ['route' => '/usuario/cadastro', 'controller' => 'usuario', 'action' => 'cadastro'];
        $ar['cadastro-confirmacao'] = ['route' => '/usuario/confirmacao', 'controller' => 'usuario', 'action' => 'confirmacao'];
        $ar['ativacao'] = ['route' => '/assinante/ativacao', 'controller' => 'usuario', 'action' => 'ativacao'];
        $ar['dashboard'] = ['route' => '/dashboard', 'controller' => 'index', 'action' => 'dashboard'];
        $ar['dashboard-admin'] = ['route' => '/dashboard-Admin', 'controller' => 'admin', 'action' => 'dashboard'];
        
        $ar['esqueceu-senha'] = ['route' => '/usuario/esqueceu', 'controller' => 'usuario', 'action' => 'esqueceu'];

        $ar['senha-enviada'] = ['route' => '/usuario/senha-enviada', 'controller' => 'usuario', 'action' => 'enviosenha'];
        
        $ar['pdf'] = ['route' => '/pdf', 'controller' => 'index', 'action' => 'pdf'];
        
        $ar['listaEvento'] = ['route' => '/listaEvento', 'controller' => 'index', 'action' => 'listaEvento'];
        
        $ar['eventos'] = ['route' => '/eventos', 'controller' => 'eventos', 'action' => 'index'];
        
        $ar['evento-novo'] = ['route' => '/evento/novo', 'controller' => 'eventos', 'action' => 'novo'];
        
       $ar['descricao-novo'] = ['route' => '/descricao/novo', 'controller' => 'descricao', 'action' => 'novo'];
        
        $ar['alunoEvento'] = ['route' => '/alunoEvento/novo', 'controller' => 'AlunoEvento', 'action' => 'novo'];
        
        $ar['participantes'] = ['route' => '/participantes', 'controller' => 'eventos', 'action' => 'listaParticipantes'];
        
         $ar['logout'] = ['route' => '/logout', 'controller' => 'index', 'action' => 'logout'];
        
        $ar['listaParticipantes'] = ['route' => '/Evento/lista-paticipantes', 'controller' => 'eventos', 'action' => 'listaParticipantesPdf'];
                   $this->setRoutes($ar);
    }



}

<?php
namespace App\Session;

class Login{

    //Método responsável por iniciar a sessão
    private static function init(){
        //VERIFICA OS STATUS DA SESSÃO
        if(session_status() !== PHP_SESSION_ACTIVE){
            //INICIA A SESSÃO
            session_start();
        }
    }

    //Método responsável por retornar os dados do usuário logado
    public static function getUsuarioLogado(){
        //INICIA A SESSÃO
        self::init();

        //RETORNA DADOS DO USUÁRIO
        return self::isLogged() ? $_SESSION['usuario'] : null;
    }

    //Método responsável por logar usuário
    public static function login($obUsuario){
        //INICIA A SESSÃO
        self::init();

        //SESSÃO DO USUÁRIO
        $_SESSION['usuario'] = [
            'id' => $obUsuario->id,
            'nome' => $obUsuario->nome,
            'email' => $obUsuario->email

        ];

        //REDIRECIONA USUÁRIO PARA INDEX
        header('location: adminpanel.php');
        exit;
    }

    //Método responsável por deslogar o usuário
    public static function logout(){
        //INICIA A SESSÃO
        self::init();

        //REMOVE A SESÃO DO USUÁRIO
        unset($_SESSION['usuario']);

         //REDIRECIONA USUÁRIO PARA LOGIN
         header('location: login.php');

    }

    //Método responsável por verificar se o usuário está logado
    public static function isLogged(){
        //INICIA A SESSÃO
        self::init();

        //VALIDAÇÃO DA SESSÃO
        return isset($_SESSION['usuario']['id']);
    }

    //Método responsável por obrigar o usuário a estar logado para acessar
    public static function requireLogin(){
        if(!self::isLogged()){
            header('location:login.php');
            exit;
        }
    }

    //Método responsável por obrigar o usuário a estar deslogado para acessar
    public static function requireLogout(){
        if(self::isLogged()){
            header('location:index.php');
            exit;
        }
    }


}
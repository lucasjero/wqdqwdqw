<?php
namespace App\Entity;
use \App\Db\Database;
use \PDO;

class Usuario{
    public $id;

    public $nome;

    public $email;

    public $senha; //HASH DA SENHA

    //Método responsável por cadastrar um novo usuário no banco
    public function cadastrar(){
        //DATABASE
        $obDatabase = new Database('usuarios');

        //INSERE UM NOVO USUÁRIO
        $this->id = $obDatabase->insert([
            'nome' => $this->nome,
            'email' =>$this->email,
            'senha'=>$this->senha
        ]);

        //SUCESSO
        return true;
    }

    //Método responsável retornar uma instância de usuário com base em seu email
    public static function getUsuarioPorEmail($email){
        return (new Database('usuarios'))->select ('email = "'.$email.'"')->fetchObject(self::class);
    }

    // Método responsável por excluir a projeto do banco
    public function excluir(){
        return (new Database('usuarios'))->delete('id = '.$this->id);
    }

    // Método responsável por atualizar o projeto no banco
    public function atualizar(){
        return (new Database('usuarios'))->update('id = '.$this->id,[
                                            'nome'    => $this->nome,
                                            'email'   => $this->email,
                                            'senha'   => $this->senha,
                                                                ]);
    }

    // Método responsável por obter os projetos do banco de dados
    public static function getUsuarios($where = null, $order = null, $limit = null){
    return (new Database('usuarios'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

    // Método responsável por buscar um projeto com base em seu ID
    public static function getUsuario($id){
        return (new Database('usuarios'))->select('id = '.$id)
                                    ->fetchObject(self::class);
    }
}
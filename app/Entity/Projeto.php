<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Projeto{

  // Identificador único do projeto
  public $id;

  // Título do projeto
  public $titulo;

  // Define o tipo do projeto
  public $tipo;

  //O arquivo do projeto
  public $arquivo;

  // Data de publicação do projeto
  public $data;

  //Método responsável por cadastrar um novo projeto no banco
  public function cadastrar(){
    //DEFINIR A DATA
    $this->data = date('Y-m-d H:i:s');

    //INSERIR A VAGA NO BANCO
    $obDatabase = new Database('portfolio');
    $this->id = $obDatabase->insert([
                                      'titulo'    => $this->titulo,
                                      'tipo'     => $this->tipo,
                                      'arquivo'  => $this->arquivo,
                                      'data'      => $this->data
                                    ]);

    //RETORNAR SUCESSO
    return true;
  }

  // Método responsável por atualizar o projeto no banco
  public function atualizar(){
    return (new Database('portfolio'))->update('id = '.$this->id,[
                                        'titulo'    => $this->titulo,
                                        'tipo'     => $this->tipo,
                                        'arquivo'  => $this->arquivo,
                                        'data'      => $this->data
                                                              ]);
  }

  // Método responsável por excluir a projeto do banco
  public function excluir(){
    return (new Database('portfolio'))->delete('id = '.$this->id);
  }

  // Método responsável por obter os projetos do banco de dados
  public static function getProjetos($where = null, $order = null, $limit = null){
    return (new Database('portfolio'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  //Método responsável por buscar um projeto com base em seu ID
  public static function getProjeto($id){
    return (new Database('portfolio'))->select('id = '.$id)
                                  ->fetchObject(self::class);
  }

}
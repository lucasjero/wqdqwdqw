<?php

namespace App\Entity;

class Upload{
    //Nome do arquivo
    private $name;

    //Extensão do arquivo
    private $extension;

    //Type do arquivo
    private $type;

    //Nome temporário/Caminho temporário do arquivo
    private $tmpName;

    //Código de erro
    private $error;

    //Size
    private $size;

    //Contador de duplicação de arquivo
    private $duplicates = 0;

    public function __construct($file){
        $this->type = $file['type'];
        $this->tmpName = $file['tmp_name'];
        $this->error = $file['error'];
        $this->size = $file['size'];

        $info = pathinfo($file['name']);
        $this->name = $info['filename'];
        $this->extension = $info['extension'];

    }

    //Método responsável por retornar o nome do arquivo com sua extensão
    public function getBasename(){
        //Valida extensão
        $extension = strlen($this->extension) ? '.'.$this->extension : '';

        //VALIDA DUPLICAÇÃO
        $duplicates = $this->duplicates > 0 ? '-' .$this->duplicates : '';

        //Retorna o nome completo
        return $this->name.$duplicates.$extension;
    }

    //Método responsável por obter um nome possível para o arquivo
    private function getPossibleBasename($dir,$overwrite){
        //SOBRESCREVER ARQUIVO
        if($overwrite) return $this->getBasename();

        //NÃO PODE SOBRESCREVER ARQUIVO
        $basename = $this->getBaseName();

        //VERIFICAR DUPLICAÇÃO
        if(!file_exists($dir.'/'.$basename)){
            return $basename;
        }

        //INCREMENTAR DUPLICAÇÕES
        $this->duplicates++;

        //RETORNA O PRÓPRIO MÉTODO
        return $this->getPossibleBasename($dir, $overwrite);
    }

    //Método responsável por mover o arquivo de upload
    public function upload($dir, $overwrite = true){
        //Verificar erro
        if($this-> error != 0) return false;

        //Caminho completo de destino
        $path = $dir.'/'.$this->getPossibleBasename($dir, $overwrite);
        
        //Move o arquivo para pasta de destino
        return move_uploaded_file($this->tmpName,$path);
    }

    public function mudarnome($novonome){
        rename($this->getBasename(), $novonome.$this->extension);
        
    }
}
<?php
namespace App\Communication;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class Email{

    //Credenciais de acesso ao SMTP
    const HOST = 'smtp.gmail.com';
    const USER = 'backupproducoes@gmail.com';
    const PASS = 'vitoriaeumadeusa';
    const SECURE = 'ssl';
    const PORT = 465;
    const CHARSET = 'UTF-8';
    
    //Dados do destinatário
    const TO_EMAIL = 'backupproducoes@gmail.com';
    const TO_NAME = 'Backup Produções';

    //Mensagem de erro do envio
    private $error;

    //Método responsável por retornar a mensagem de envio
    public function getError(){
        return $this->error;
    }

    //Método responsável por enviar um e-mail
    public function sendEmail($fromaddress, $fromname, $subject, $body){
        //Limpar a mensagem de erro
        $this->error = '';

        //Instancia de PHPMailer
        $obMail = new PHPMailer(true);
        try{
            //Credenciais de acesso ao SMTP
            //$obMail->SMTPDebug = 2;
            $obMail->isSMTP(true);
            $obMail->Host = self::HOST;
            $obMail->SMTPAuth = true;
            $obMail->Username = self::USER;
            $obMail->Password = self::PASS;
            $obMail->SMTPSecure = self::SECURE;
            $obMail->Port = self::PORT;
            $obMail->CharSet = self::CHARSET;

            //Remetente
            $obMail->setFrom($fromaddress, $fromname);

            //DESTINATÁRIOS
            $obMail->addAddress(self::TO_EMAIL, self::TO_NAME);

             //Conteúdo do E-mail
             $obMail->isHTML(true);
             $obMail->Subject = $subject;
             $obMail->Body = $body;

             //Envia o e-mail
             return $obMail->send();

        }catch(PHPMailerException $e){
            //Apresenta o erro da mensagem
            $this->error = $e->getMessage();
            return false;
        }
    }
}
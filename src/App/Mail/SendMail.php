<?php

namespace App\Mail;

require_once 'swift_required.php';

/**
 * Class SendMail - SwiftMailer
 * @package App\Mail
 */
class SendMail
{
    /**
     * @return array
     */
    public function configuraSwift()
    {
        $transport = \Swift_SmtpTransport::newInstance();

        $mailer = \Swift_Mailer::newInstance($transport);

       $transport->setHost('smtp.live.com')
            ->setPort(587)//Configurar Porta
            ->setEncryption('tls')
            ->setUsername('agnaldobernardojunior@hotmail.com')
            ->setPassword('ZXCVBNMMNBVCXZ');
           
          /* $transport = \Swift_SmtpTransport::newInstance('smtp.live.com', 587, tls)
            ->setUsername('agnaldobernardojunior@hotmail.com')
            ->setPassword('ZXCVBNMMNBVCXZ')
            ;*/

        $message = \Swift_Message::newInstance($transport);

        return array(
            'mailerInstance' => $mailer,
            'messageInstance' => $message
        );
    }

    /**
     * @param $message
     * @param $mailer
     * @param $assunto
     * @param $destinatario
     * @param $mensagemHtml
     * @param array $dados
     * @return mixed
     */
    public function enviaHtml($message, $mailer, $assunto, $destinatario, $mensagemHtml, array $dados)
    {
        $message->setSubject($assunto)
            ->setFrom(
                array(
                    $dados['email'] => $dados['nome']
                )
            )
            ->setTo(
                array(
                    $destinatario
                )
            )
            ->setBody($mensagemHtml,"text/html");

        return $mailer->send($message);

    }

}
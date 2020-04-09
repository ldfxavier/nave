<?php
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '123456');
define('DB_DATABASE', 'umprogramador');
date_default_timezone_set('America/Sao_Paulo');

class Model
{
    public function __construct()
    {
        $this->pdo = new PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PWD);
    }

    public function select()
    {
        $consulta = $this->pdo->query("SELECT * FROM `mensagem_contato`");
        $retorno = $consulta->fetch(PDO::FETCH_ASSOC);

        return $retorno;
    }

    public function hash($hash)
    {
        $consulta = $this->pdo->query("SELECT * FROM `mensagem_contato` WHERE `hash` = '{$hash}'");
        $retorno = $consulta->fetch(PDO::FETCH_ASSOC);

        return (object) $retorno;
    }

    public function solicitacao($hash)
    {
        $consulta = $this->pdo->query("SELECT * FROM `mensagem_solicitacao` WHERE `hash` = '{$hash}'");
        $retorno = $consulta->fetch(PDO::FETCH_ASSOC);

        return (object) $retorno;
    }

    public function insert($tabela, $dados)
    {
        $campos = '';
        $valores = '';
        foreach ($dados as $ind => $val):
            $campos .= "`" . $ind . "`, ";
            $valores .= '"' . $val . '", ';
        endforeach;

        $campos = substr($campos, 0, -2);
        $valores = substr($valores, 0, -2);

        $inserir = $this->pdo->prepare("INSERT INTO {$tabela}({$campos}) VALUES({$valores})");
        $inserir->execute();

        if ($inserir):
            $retorno = true;
        else:
            $retorno = false;
        endif;

        return $retorno;
    }
}

final class Email
{

    public function enviar($titulo, $nome, $email, $mensagem, $login = '', $senha = '')
    {
        require 'mail/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = 'a2plcpnl0075.prod.iad2.secureserver.net';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "atendimento@umprogramador.com.br";
        $mail->Password = "up134679";
        $mail->setFrom('comercial@nave.art.br', 'Atendimento');
        $mail->addReplyTo('comercial@nave.art.br', 'Atendimento');
        $mail->addAddress($email, $titulo);
        $mail->Subject = $titulo;
        $mail->msgHTML(file_get_contents($mensagem), dirname(__FILE__));

        if (!$mail->send()):
            echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        else:
            return true;
        endif;
    }
}

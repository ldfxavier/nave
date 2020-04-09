<?php
require_once "config.php";

if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(500);
    exit();
}

$dados['nome'] = strip_tags(htmlspecialchars($_POST['name']));
$dados['email'] = strip_tags(htmlspecialchars($_POST['email']));
$dados['telefone'] = strip_tags(htmlspecialchars($_POST['phone']));
$dados['mensagem'] = strip_tags(htmlspecialchars($_POST['message']));
$dados['data_criacao'] = date('Y-m-d h:i:s');
$dados['hash'] = uniqid(date(time()));
$dados['status'] = 1;

$Model = new Model;
$insert = $Model->insert('mensagem_contato', $dados);

if ($insert):
    $Email = new Email;
    $Email->enviar('CONTATO SITE', 'NAVE', 'ldfxavier@gmail.com', "https://nave.art.br/email/mensagem.php?h=" . $dados['hash']);

    $retorno = json_encode(array(
        'erro' => false,
        'titulo' => 'Mensagem enviada com sucesso!',
        'texto' => 'Em breve entraremos em contato com você.',
    ));
else:
    $retorno = json_encode(array(
        'erro' => true,
        'titulo' => 'Erro ao enviar',
        'texto' => 'Por favor, tente novamente',
    ));
endif;

echo $retorno;

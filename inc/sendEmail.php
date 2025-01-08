<?php

$siteOwnersEmail = 'felipemp2014@gmail.com';

if ($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   $error = [];

   if (strlen($name) < 2) {
      $error['name'] = "Por favor, insira seu nome.";
   }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error['email'] = "Por favor, insira um endereço de e-mail válido.";
   }

   if (strlen($contact_message) < 15) {
      $error['message'] = "Por favor, insira sua mensagem. Ela deve ter pelo menos 15 caracteres.";
   }

   // Define Assunto padrão, se vazio
   if ($subject == '') { 
      $subject = "Contato do Formulário"; 
   }

   // Cria a mensagem do e-mail
   $message = "<strong>Email de:</strong> " . $name . "<br />";
   $message .= "<strong>Endereço de email:</strong> " . $email . "<br />";
   $message .= "<strong>Mensagem:</strong><br />";
   $message .= $contact_message;
   $message .= "<br />-----<br /> Este e-mail foi enviado pelo formulário de contato do site.";

   // Cabeçalhos do e-mail
   $headers = "From: " . $name . " <" . $email . ">\r\n";
   $headers .= "Reply-To: ". $email . "\r\n";
   $headers .= "MIME-Version: 1.0\r\n";
   $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

   // Se não houver erros, envia o e-mail
   if (!$error) {
      ini_set("sendmail_from", $siteOwnersEmail); // Apenas para servidores Windows
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

      if ($mail) {
         echo "OK";
      } else {
         echo "Servidor desabilitado no momento. Por favor, tente novamente mais tarde.";
      }
   } else {
      // Retorna os erros de validação
      $response = "";
      if (isset($error['name'])) $response .= $error['name'] . "<br />";
      if (isset($error['email'])) $response .= $error['email'] . "<br />";
      if (isset($error['message'])) $response .= $error['message'] . "<br />";
      echo $response;
   }
}

?>

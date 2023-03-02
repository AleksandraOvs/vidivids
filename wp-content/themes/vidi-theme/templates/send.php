<?php 
require_once( dirname(__FILE__) . '/../../../../wp-load.php');

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    if (empty( $_POST['name']) || empty( $_POST['message'])){
       echo "Заполните все поля";
      };
    
    else{
        //$to = get_option('admin_email'); 
        $to = '<aleksandra.ovsia@gmail.com>';
        $subject = "Письмо с обратной связи"; 
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: <test@mail.ru>\r\n";
        $mail_message .= "Name: ".$name."\n";
        $mail_message .= "Email: ".$email."\n";
        $mail_message .= "Phone number: ".$phone."\n";
        $mail_message .= "Message: ".$message."\n";

        $send = mail($to, $subject, $mail_message, $headers);

        if ($send == "true")
        {
            echo "Ваше сообщение отправлено. Мы ответим вам в ближайшее время.\r\n";
        }

        else
        {
            echo "Не удалось отправить, попробуйте снова!";
        }
    }

?>
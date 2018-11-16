<?php


require_once 'tools/PHPMailer-master/PHPMailerAutoload.php';

class MailUtil
{
    public static function addBCCs($mail)
    {
        $mail->addBCC('admin@oursitterlistnashville.com', 'Administrator');
//        $mail->addBCC('sethcriedel@gmail.com', 'Webmaster');
        $mail->addBCC('cjohnson@furiae-interactive.com', 'Chris Johnson');
        $mail->addBCC('oursitterlistnashville@gmail.com', 'Webmaster');
        $mail->addBCC('karlyhart0@gmail.com', 'Karly Hart');
        $mail->addBCC('whitneyschickling@gmail.com', 'Whitney Schickling');
    }

    public static function getMailer()
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();

//        $mail->SMTPDebug  = 1;
        $mail->Host = "in-v3.mailjet.com";
        $mail->Port = 587;
        $mail->Username = '56b7456917499583f5cedd8d17e14821';
        $mail->Password = 'f8be29bd2ca493039ad8dc0ed5abd227';

        MailUtil::addBCCs($mail);

        return $mail;
    }

    public static function getMailerWhitney()
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();

//        $mail->SMTPDebug  = 1;
        $mail->Host = "in-v3.mailjet.com";
        $mail->Port = 587;
        $mail->Username = '56b7456917499583f5cedd8d17e14821';
        $mail->Password = 'f8be29bd2ca493039ad8dc0ed5abd227';

        $mail->setFrom('karlyandwhitney@oursitterlistnashville.com', 'Our Sitter List - Nashville');

        MailUtil::addBCCs($mail);

        return $mail;
    }

    public static function getMailerInquiry()
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();

        $mail->Host = "in-v3.mailjet.com";
        $mail->Port = 587;
        $mail->Username = '56b7456917499583f5cedd8d17e14821';
        $mail->Password = 'f8be29bd2ca493039ad8dc0ed5abd227';

        $mail->setFrom('inquiry@oursitterlistnashville.com', 'Our Sitter List - Nashville');

        MailUtil::addBCCs($mail);

        return $mail;
    }
}

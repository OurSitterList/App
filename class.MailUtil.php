<?php


require_once 'tools/PHPMailer-master/PHPMailerAutoload.php';

class MailUtil
{
    public static function addBCCs($mail)
    {
        // $mail->addBCC('admin@oursitterlistnashville.com', 'Administrator');
//        $mail->addBCC('sethcriedel@gmail.com', 'Webmaster');
        // $mail->addBCC('cjohnson@furiae-interactive.com', 'Chris Johnson');
        // $mail->addBCC('oursitterlist@gmail.com', 'Webmaster');
        // $mail->addBCC('karlyhart0@gmail.com', 'Karly Hart');
        // $mail->addBCC('whitneyschickling@gmail.com', 'Whitney Schickling');
    }

    public static function getMailer()
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();

//        $mail->SMTPDebug  = 1;
        $mail->Host = "";
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';

        MailUtil::addBCCs($mail);

        return $mail;
    }

    public static function getMailerWhitney()
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();

//        $mail->SMTPDebug  = 1;
        $mail->Host = "";
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';

        $mail->setFrom('karlyandwhitney@oursitterlistnashville.com', 'Our Sitter List - Nashville');

        MailUtil::addBCCs($mail);

        return $mail;
    }

    public static function getMailerInquiry()
    {
        $mail = new PHPMailer;
        $mail->IsSMTP();

        $mail->Host = "";
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';

        $mail->setFrom('inquiry@oursitterlistnashville.com', 'Our Sitter List - Nashville');

        MailUtil::addBCCs($mail);

        return $mail;
    }
}


<?php

namespace xrobau;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class SMTPHack
{
    private $phpmailer;
    private $smtp;

    private $from;
    private $to;

    /**
     * @param string $from
     * @param string $to
     * @param string $smtphost
     * @return void
     */
    public function __construct(string $from, string $to, string $smtphost = 'mailrx')
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPAutoTLS = false;
        $mail->Host = $smtphost;
        $this->phpmailer = $mail;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param string $helo
     * @return SMTP
     */
    public function getSmtp(string $helo = ''): SMTP
    {
        if (!$this->smtp) {
            if ($helo) {
                $this->phpmailer->Helo = $helo;
            }
            $this->phpmailer->smtpConnect();
            $this->smtp = $this->phpmailer->getSMTPInstance();
            $this->smtp->mail($this->from);
            $this->smtp->recipient($this->to);
        }
        return $this->smtp;
    }

    /**
     * @param string $data
     * @param string $helo
     * @param boolean $quiet
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function data(string $data, string $helo = '', bool $quiet = true)
    {
        $smtp = $this->getSmtp($helo);
        $prev = $smtp->do_debug;
        if ($quiet) {
            $smtp->do_debug = 0;
        }
        $smtp->data($data);
        $smtp->do_debug = $prev;
    }
}

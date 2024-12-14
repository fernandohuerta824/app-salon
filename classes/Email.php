<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    private string $email;
    private string $nombre;
    private string $token;

    public function __construct(string $email, string $nombre, string $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    private function setDatosEmail(string $asunto, string $contenido) {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASSWORD'];

        $phpmailer->setFrom('appsalonbelleza@gmail.com');
        $phpmailer->addAddress($this->email, $this->nombre);

        $phpmailer->Subject = $asunto;
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';
        $contenido = $contenido;

        $phpmailer->Body = $contenido;
        $phpmailer->send();
    }

    public function enviarConfirmacion() {
        $this->setDatosEmail('Confirmar Cuenta', "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 20px auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border: 1px solid #dddddd;
                        border-radius: 5px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    }
                    .email-header {
                        font-size: 20px;
                        color: #333333;
                        margin-bottom: 20px;
                    }
                    .email-body {
                        font-size: 16px;
                        color: #555555;
                        line-height: 1.5;
                    }
                    .email-link {
                        display: inline-block;
                        margin-top: 20px;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 16px;
                    }
                    .email-link:hover {
                        background-color: #0056b3;
                    }
                    .email-footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #999999;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        Hola - $this->nombre
                    </div>
                    <div class='email-body'>
                        Has creado tu cuenta en AppSalon. Solo debes confirmarla presionando el siguiente enlace:
                        <br>
                        <a href='http://192.168.100.188:3000/confirmar-cuenta?token=$this->token' class='email-link'>Confirmar Cuenta</a>
                        <p>Si tú no solicitaste esto, puedes ignorar este mensaje.</p>
                    </div>
                    <div class='email-footer'>
                        &copy; " . date("Y") . " AppSalon. Todos los derechos reservados.
                    </div>
                </div>
            </body>
            </html>
        ");
    }

    public function enviarRecuperarPass() {
        $this->setDatosEmail('Restablece tus password', "
        <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 20px auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border: 1px solid #dddddd;
                        border-radius: 5px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    }
                    .email-header {
                        font-size: 20px;
                        color: #333333;
                        margin-bottom: 20px;
                    }
                    .email-body {
                        font-size: 16px;
                        color: #555555;
                        line-height: 1.5;
                    }
                    .email-link {
                        display: inline-block;
                        margin-top: 20px;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 16px;
                    }
                    .email-link:hover {
                        background-color: #0056b3;
                    }
                    .email-footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #999999;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        Hola - $this->nombre
                    </div>
                    <div class='email-body'>
                        Has solicitado recuperar tu contraseña en AppSalon. Para hacerlo, por favor presiona el siguiente enlace:
                        <br>
                        <a href='". $_ENV['APP_URL'] ."/recuperar?token=$this->token' class='email-link'>Recuperar Contraseña</a>
                        <p>Si tú no solicitaste esto, puedes ignorar este mensaje.</p>
                    </div>
                    <div class='email-footer'>
                        &copy; " . date("Y") . " AppSalon. Todos los derechos reservados.
                    </div>
                </div>
            </body>
            </html>
        ");
    }

}
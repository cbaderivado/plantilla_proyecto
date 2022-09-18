<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Support\Facades\Redis;
use Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class ControladorContacto extends Controller
{
    public function index()
    {
            return view ("web.contacto");
    }
    public function enviar(Request $request)
    {
            // $mail=new PHPMailer(true);
            // $mail->SMTPDebug=0;
            // $mail->isSMTP();
            // $mail->Host=env('MAIL_HOST');
            // $mail->SMTPAuth=true;
            // $mail->Username=env('MAIL_USERNAME');
            // $mail->Password=env('MAIL_PASSWORD');
            // $mail->SMTPSecure=env('MAIL_ENCRYPTION');
            // $mail->Port=env('MAIL_PORT');
            // $mail->setFrom(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
            // $mail->addAddress(env('MAIL_FROM_ADDRESS'));
            // $mail->isHTML(true);
            // $mail->Subject="Nuevo mensajes de Contacto";
            // $mail->Body=
            // "Nombre: " .$request->input('txtNombre') ."\n" .
            // "Telefono: " .$request->input('txtTelefono') ."\n" .
            // "Correo: " .$request->input('txtCorreo') ."\n" .
            // "Mensaje: " .$request->input('txtMensaje');
            // $mail->send();

        
        return view ("web.mensajeEnviado");
    }
}

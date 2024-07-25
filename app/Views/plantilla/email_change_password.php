<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Cambio de Contraseña</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }
        .title {
            color: #A7250D;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .text {
            color: #808080;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .list-group {
            list-style: none;
            padding: 0;
        }
        .list-group-item {
            background-color: #CC9933;
            color: #FFFFFF;
            border: none;
            padding: 10px;
            margin-bottom: 5px;
        }
        .btn {
            background-color: #A7250D;
            border: none;
            color: #FFFFFF;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #CC9933;
        }
        .footer {
            margin-top: 30px;
            background-color: #CCCCCC;
            padding: 10px;
            text-align: center;
            border-radius: 0 0 10px 10px;
            color: #808080;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="title">🔑 Notificación de Cambio de Contraseña</h2>
        <p class="text">Estimado/a <?= esc($nombre_usuario) ?>,</p>
        <p class="text">Te informamos que la contraseña de tu cuenta en nuestro sistema de gestión de pruebas psicológicas UPTX TestManager ha sido cambiada con éxito.</p>
        <p class="text">Si tú has realizado este cambio, no es necesario que hagas nada más. Si no has solicitado este cambio o crees que tu cuenta podría estar en riesgo, te recomendamos que contactes con nuestro equipo de soporte de inmediato.</p>
        <ul class="list-group">
            <li class="list-group-item">📧 Correo Electrónico: <?= esc($email_usuario) ?></li>
            <li class="list-group-item">📅 Fecha del Cambio: <?= esc($fecha_cambio) ?></li>
        </ul>
        <p class="text">Para mantener la seguridad de tu cuenta, te recomendamos utilizar una contraseña segura y actualizarla periódicamente.</p>
        <p class="text">Si necesitas asistencia adicional o tienes alguna pregunta, no dudes en contactarnos a través de este correo electrónico.</p>
        <a href="https://uptlax.edu.mx/index.php/psicologica/" class="btn">🔐 Gestionar tu Cuenta</a>
    </div>

    <div class="footer">
        <p>Atentamente,</p>
        <p>Equipo de Apoyo Psicológico</p>
        <p>TIAMLab</p>
        <p>Todos los derechos reservados TIAMLab.</p>
    </div>
</body>
</html>

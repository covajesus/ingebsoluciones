<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto</title>
</head>
<body>
    <h2>Nuevo mensaje de contacto</h2>

    <p>Se ha recibido un nuevo mensaje de contacto con la siguiente información:</p>

    <ul>
        <li><strong>Nombre:</strong> {{ $formData['first_name'] }} {{ $formData['last_name'] }}</li>
        <li><strong>Correo electrónico:</strong> {{ $formData['email'] }}</li>
        @if(isset($formData['phone']))
            <li><strong>Teléfono:</strong> {{ $formData['phone'] }}</li>
        @endif
    </ul>

    <p><strong>Mensaje:</strong></p>
    <p>{{ $formData['message'] }}</p>

    <p>Este mensaje ha sido enviado desde el formulario de contacto en el sitio web.</p>
</body>
</html>
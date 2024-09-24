<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validar los campos (puedes agregar más validaciones según tus necesidades)
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die('Todos los campos son obligatorios.');
    }

    // Guardar los datos en la base de datos
    // $conn = new mysqli('sql110.infinityfree.com', 'if0_37159214', 'qJ79CAPgRLmrH', 'if0_37159214_contact');
    $conn = new mysqli('sql110.iceiy.com', 'icei_37159371', 'tmkhEQMo0Ybu', 'icei_37159371_contact');
    // $conn = new mysqli('localhost', 'root', '', 'emails');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt = $conn->prepare("INSERT INTO users (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {
        echo "Mensaje guardado con éxito.";
    } else {
        echo "Error al guardar el mensaje: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Enviar correo electrónico
    $to = "tu_correo@dominio.com";
    $headers = "From: " . $email . "\r\n";
    $body = "Nombre: $name\nCorreo: $email\nAsunto: $subject\nMensaje:\n$message";

    if (mail($to, $subject, $body, $headers)) {
        echo "Correo enviado con éxito.";
    } else {
        echo "Error al enviar el correo.";
    }
}
?>

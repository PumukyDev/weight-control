<?php
// Traer los archivos necesarios
require_once './config.php';
require_once './UserController.php';
require_once './PesoController.php';

// Inicializar controladores
$userController = new UserController();
$pesoController = new PesoController();

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        //Validación básica
        if (empty($_POST['name']) || empty($_POST['surnames']) || empty($_POST['weight']) || empty($_POST['height'])) {
            throw new Exception("No puede haber campos vacíos");
        }

        // Registrar al usuario
        $userController->createUser($_POST['name'], $_POST['surnames']);

        // Obtener el ID del usuario
        $userID = $userController->getLastInsertedId();

        // Registrar el peso
        $pesoController->createWeight($_POST['weight'], $_POST['height'], date('Y-m-d H:i:s'), $userID);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peso Fernando</title>
</head>

<body>
    <h1>Peso Fernando</h1>
    <form method="post">
        <label for="weight">Peso (kg):</label>
        <input type="number" id="weight" name="weight" step="0.01">

        <label for="height">Altura (m):</label>
        <input type="number" id="height" name="height" step="0.01">

        <!-- Campo para el nombre -->
        <label for="name">Nombre: </label>
        <input type="text" name="name" id="name" />

        <!-- Campo para los apellidos -->
        <label for="surnames">Apellidos: </label>
        <input type="text" name="surnames" id="surnames" />

        <button type="submit">Añadir</button>
    </form>

    <?php
    # Te lo dejo a ti, Alonso
    // Qué amable por tu parte
    

    // Historial de pesos
    
    ?>
</body>

</html>
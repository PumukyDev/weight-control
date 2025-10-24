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
        if (empty($_POST['name']) || empty($_POST['surnames']) || empty($_POST['weight']) || empty($_POST['height']) || empty($_POST['birth'])) {
            throw new Exception("No puede haber campos vacíos");
        }

        // Registrar al usuario
        $userController->createUser($_POST['name'], $_POST['surnames'], $_POST['birth']);

        // Obtener el ID del usuario
        $userID = $userController->getLastInsertedId();

        // Registrar el peso
        $pesoController->createWeight($_POST['weight'], $_POST['height'], date('Y-m-d H:i:s'), $userID);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Obtener el historial de pesos
$pesos = $pesoController->index();

// Obtener el peso máximo
$max = $pesoController->getMax();

// Obtener el peso mínimo
$min = $pesoController->getMin();
?>

<?php
# Te lo dejo a ti, Alonso
// Qué amable por tu parte
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peso Fernando</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
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

        <!-- Campo para la fecha de nacimiento -->
        <label for="birth">Fecha de nacimiento: </label>
        <input type="date" name="birth" id="birth" />

        <button type="submit">Añadir</button>
    </form>

    <br />

    <h2>Historial de pesos</h2>

    <main>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Fecha de nacimiento</th>
                        <th>Fecha en que se añadió</th>
                        <th>Peso</th>
                        <th>Altura</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pesos as $peso): ?>
                        <tr class="tr">
                            <th>
                                <?php echo htmlspecialchars($peso['name'] . ' ' . $peso['surnames']); ?>
                            </th>

                            <td>
                                <?php echo htmlspecialchars($peso['birth']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($peso['fecha']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($peso['peso']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($peso['altura']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <section>
            <h5>Peso máximo histórico</h5>
            <?php
            echo htmlspecialchars($max['max_peso']) . ' kg - ';
            echo htmlspecialchars($max['name'] . ' ' . $max['surnames']);
            ?>
        </section>

        <section>
            <h5>Peso mínimo histórico</h5>
            <?php
            echo htmlspecialchars($min['min_peso']) . ' kg - ';
            echo htmlspecialchars($min['name'] . ' ' . $min['surnames']);
            ?>
        </section>
    </footer>
</body>

</html>
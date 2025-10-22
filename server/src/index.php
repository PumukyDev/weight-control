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
        <label for="weight">Peso:</label>
        <input type="number" id="weight" name="weight" step="0.01">
        <label for="height">Altura:</label>
        <input type="number" id="height" name="height" step="0.01">
        <button type="submit">Añadir</button>
    </form>

    <?php
    # Te lo dejo a ti, Alonso
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $weight = $_POST['weight'] ?? '';
        $height = $_POST['height'] ?? '';

        if ($weight !== '' && $height !== '') {
            echo "<p>Has introducido: Peso = " . htmlspecialchars($weight) . ", Altura = " . htmlspecialchars($height) . "</p>";
        }
    }
    ?>
</body>
</html>

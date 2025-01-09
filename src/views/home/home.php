<?php
use App\Atlas\config\App;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | ATLAS</title>
    <?php require_once App::URL_INC . "total_css.php"; ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper conten-main">
        <?php require_once App::URL_INC . "/menu.php"; ?>
        <main class="app-main m-3">

        </main>
        <?php require_once App::URL_INC . "/footer.php"; ?>
    </div>
    <?php require_once App::URL_INC . "/scrips.php"; ?>
</body>
</html>
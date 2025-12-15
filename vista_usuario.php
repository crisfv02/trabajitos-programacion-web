<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: acceso.php");
    exit;
}

require_once 'conexion.php';


$consulta = $pdo->query("SELECT * FROM productos");
$productos = $consulta->fetchAll();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['carrito'][] = [
        'id'     => $_POST['id_producto'],
        'nombre' => $_POST['nombre_producto'],
        'precio' => $_POST['precio_producto'],
        'talla'  => $_POST['talla']
    ];
}


$total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color:#f5efe6;">
<div class="container-fluid mt-4">
    <div class="row">

       
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">🛒 Mi carrito</h5>
                    <hr>

                    <p>
                        Productos agregados:
                        <b><?= isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0 ?></b>
                    </p>

                    <p class="fs-5">
                        Total:
                        <b>$<?= number_format($total, 2); ?></b>
                    </p>

                    <a href="carrito.php" class="btn btn-danger w-100">
                        Ver carrito
                    </a>
                </div>
            </div>
        </div>

        
        <div class="col-md-9">
            <h3 class="mb-4">PAC MENSWEAR</h3>

            <div class="row">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center">
                                <h5><?= htmlspecialchars($producto['nombre']); ?></h5>

                                <p>
                                    $<?= number_format($producto['precio'], 2); ?>
                                </p>

                                <form method="POST">

                                   
                                    <div class="mb-2">
                                        <label class="form-label">Talla</label><br>
                                        <input type="radio" name="talla" value="S" required> S
                                        <input type="radio" name="talla" value="M"> M
                                        <input type="radio" name="talla" value="G"> G
                                    </div>

                    
                                    <input type="hidden" name="id_producto"
                                           value="<?= $producto['id_producto']; ?>">
                                    <input type="hidden" name="nombre_producto"
                                           value="<?= htmlspecialchars($producto['nombre']); ?>">
                                    <input type="hidden" name="precio_producto"
                                           value="<?= $producto['precio']; ?>">

                                    <button type="submit" class="btn btn-success">
                                        Agregar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>
</body>
</html>
<?php

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: acceso.php");
    exit;
}

require_once 'conexion.php';

function obtenerProductos($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}


if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];

    try {
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id_producto = ?");
        $stmt->execute([$id]);
        $_SESSION['mensaje'] = "Producto eliminado correctamente";
        header("Location: productos.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error al eliminar el producto: " . $e->getMessage();
        header("Location: productos.php");
        exit;
    }
}

$productos = obtenerProductos($pdo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #d4c6a8; 
        }

        .btn-cafe {
            background-color: #8b5a2b;
            color: white;
            border: none;
        }

        .btn-cafe:hover {
            background-color: #6f451f;
            color: white;
        }

        .btn-rojo {
            background-color: #b22222;
            color: white;
            border: none;
        }

        .btn-rojo:hover {
            background-color: #8b1a1a;
            color: white;
        }

        .contenedor {
            background-color: #e7dcc4; 
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="container mt-4 contenedor">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Catálogo de Productos</h3>
        <a href="salir.php" class="btn btn-rojo">Salir</a>
    </div>

  
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensaje'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <a href="agregar_producto.php" class="btn btn-cafe mb-3">Agregar producto</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Talla</th>
                <th>Existencias</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($productos)): ?>
                <tr><td colspan="6" class="text-center">No hay productos registrados</td></tr>
            <?php else: ?>
                <?php foreach ($productos as $index => $p): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($p["nombre"]) ?></td>
                        <td>$<?= number_format($p["precio"], 2) ?></td>
                        <td><?= htmlspecialchars($p["talla"]) ?></td>
                        <td><?= htmlspecialchars($p["existencias"]) ?></td>

                        <td>
                            <a href="editar_producto.php?id=<?= $p['id_producto'] ?>" class="btn btn-warning btn-sm">Editar</a>

                            <a href="?eliminar=<?= $p['id_producto'] ?>"
                               class="btn btn-rojo btn-sm"
                               onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
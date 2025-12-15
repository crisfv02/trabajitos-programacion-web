<?php

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: acceso.php");
    exit;
}

require_once 'conexion.php';

if (!isset($_GET['id'])) {
    header("Location: productos.php");
    exit;
}

$id = $_GET['id'];
$producto = null;
$error = '';


try {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch();

    if (!$producto) {
        $_SESSION['error'] = "Producto no encontrado";
        header("Location: productos.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al cargar el producto: " . $e->getMessage();
    header("Location: productos.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $talla = $_POST['talla'] ?? '';
    $existencias = $_POST['existencias'] ?? 0;

    if (empty($nombre) || empty($precio) || empty($talla)) {
        $error = "Todos los campos obligatorios deben ser llenados";
    } elseif (!is_numeric($precio) || $precio <= 0) {
        $error = "El precio debe ser un número positivo";
    } elseif (!is_numeric($existencias) || $existencias < 0) {
        $error = "Las existencias deben ser un número no negativo";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE productos 
                                   SET nombre=?, precio=?, talla=?, existencias=? 
                                   WHERE id_producto=?");
            $stmt->execute([$nombre, $precio, $talla, $existencias, $id]);

            $_SESSION['mensaje'] = "Producto actualizado correctamente";
            header("Location: productos.php");
            exit;
        } catch (PDOException $e) {
            $error = "Error al actualizar el producto: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #d4c6a8; 
        }

        .contenedor {
            background-color: #e7dcc4; 
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            margin-top: 30px;
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

    </style>
</head>

<body>

<div class="container contenedor">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Editar Producto</h3>
        <a href="productos.php" class="btn btn-rojo">Volver</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Nombre *</label>
            <input type="text" class="form-control" name="nombre"
                   value="<?= htmlspecialchars($producto['nombre']) ?>" required maxlength="50">
        </div>

        <div class="mb-3">
            <label class="form-label">Precio *</label>
            <input type="number" class="form-control" name="precio"
                   value="<?= htmlspecialchars($producto['precio']) ?>" step="0.01" min="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Talla *</label>
            <select class="form-select" name="talla" required>
                <option value="S" <?= $producto['talla']=='S' ? 'selected':'' ?>>S</option>
                <option value="M" <?= $producto['talla']=='M' ? 'selected':'' ?>>M</option>
                <option value="G" <?= $producto['talla']=='G' ? 'selected':'' ?>>G</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Existencias</label>
            <input type="number" class="form-control" name="existencias"
                   value="<?= htmlspecialchars($producto['existencias']) ?>" min="0">
        </div>

        <button type="submit" class="btn btn-cafe">Actualizar Producto</button>
        <a href="productos.php" class="btn btn-rojo">Cancelar</a>

    </form>
</div>

</body>
</html>
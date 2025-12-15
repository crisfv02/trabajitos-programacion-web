<?php
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION['rol'] != 'cliente') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['indice_eliminar'])) {
    unset($_SESSION['carrito'][$_POST['indice_eliminar']]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

$gran_total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $prod) { 
        $gran_total += $prod['precio']; 
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Carrito</title>

<style>
    body {
        margin: 0;
        background-color: #cbbfa0;
        font-family: Georgia, serif;
        text-align: center;
    }

    h1 {
        margin-top: 40px;
        font-size: 40px;
    }

    .carrito-icon {
        font-size: 100px;
        margin: 10px 0 25px 0;
    }

    table {
        width: 80%;
        margin: auto;
        border-collapse: collapse;
        background-color: #b3a15a;
        border-radius: 5px;
        overflow: hidden;
        font-size: 18px;
    }

    th {
        padding: 15px;
    }

    td {
        padding: 20px;
    }

    .btn-eliminar {
        background-color: #f39d63;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-pagar {
        margin-top: 40px;
        background-color: #f39d63;
        border: none;
        padding: 15px 40px;
        font-size: 22px;
        border-radius: 5px;
        cursor: pointer;
        float: right;
        margin-right: 10%;
    }
</style>

</head>
<body>

    <h1>DETALLES DE TU COMPRA</h1>
    <div class="carrito-icon">🛒</div>

    <?php if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0): ?>

        <p><b>Tu carrito está vacío.</b></p>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Talla</th>
                    <th>Pedido</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($_SESSION['carrito'] as $indice => $producto): ?>
                    <tr>
                        <td><b><?php echo $producto['nombre']; ?></b></td>
                        <td><?php echo $producto['talla']; ?></td>
                        <td>1</td>
                        <td><?php echo $producto['precio']; ?></td>

                        <td>
                            <form method="POST">
                                <input type="hidden" name="indice_eliminar" value="<?php echo $indice; ?>">
                                <button type="submit" class="btn-eliminar">ELIMINAR</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form action="pago.php">
            <button class="btn-pagar">PAGAR</button>
        </form>

    <?php endif; ?>

</body>
</html>
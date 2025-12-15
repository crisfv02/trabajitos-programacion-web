<?php
session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION['rol'] != 'cliente') {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) == 0) {
    header("Location: vista_usuario.php");
    exit();
}

$gran_total = 0;
foreach ($_SESSION['carrito'] as $prod) {
    $gran_total += $prod['precio'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $_SESSION['ultima_compra'] = $_SESSION['carrito'];

    unset($_SESSION['carrito']);

    header("Location: finalizado.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pago</title>

<style>

    body {
        background: #d3c7a4; 
        font-family: Arial;
        padding: 20px;
    }

    h1, h2 {
        text-align: center;
        font-weight: bold;
    }

    .box {
        width: 80%;
        margin: auto;
        background: #e4d8b9;
        padding: 25px;
        border-radius: 10px;
    }

    .metodo-box {
        width: 40%;
        margin: auto;
        background: #dcdcdc;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }

    input, select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: none;
        background: #c5c5c5;
        margin-top: 5px;
    }

    .fila {
        display: flex;
        gap: 25px;
        margin-bottom: 20px;
    }

    .col {
        flex: 1;
    }

    .divisor {
        width: 100%;
        height: 2px;
        background: #4a4a4a;
        margin: 25px 0;
    }

   button {
    background: #8B4513; 
    color: white;
    padding: 12px 30px;
    border: none;
    font-size: 20px;
    font-weight: bold;
    border-radius: 12px;
    cursor: pointer;
    margin-top: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    transition: 0.2s;
}

button:hover {
    background: #5c2f0c; 
}


</style>
</head>

<body>

<div class="box">

    <h1>Método de pago</h1>

    <div class="metodo-box">

        <select name="metodo_pago">
            <option value="credito">Crédito</option>
            <option value="debito">Débito</option>
        </select>

        <br><br>

        <input type="text" name="tarjeta" placeholder="Número de tarjeta">
        <br><br>

        <input type="text" name="fecha" placeholder="Fecha MM/AA">
        <br><br>

        <input type="text" name="cvv" placeholder="CVV">
    </div>

    <div class="divisor"></div>

    <h2>Datos de envío</h2>

    <form method="POST">


        <div class="fila">
            <div class="col">
                <label>País/Región</label>
                <input type="text" name="pais" required>
            </div>

            <div class="col">
                <label>Código postal</label>
                <input type="text" name="cp" required>
            </div>

            <div class="col">
                <label>Referencia (Opcional)</label>
                <input type="text" name="ref">
            </div>
        </div>

    
        <div class="fila">
            <div class="col">
                <label>Nombre del destinatario</label>
                <input type="text" name="nombre" required>
            </div>

            <div class="col">
                <label>Colonia/Alcaldía</label>
                <input type="text" name="colonia" required>
            </div>
        </div>


        <div class="fila">
            <div class="col">
                <label>Teléfono</label>
                <input type="text" name="telefono" required>
            </div>

            <div class="col">
                <label>Calle/número exterior e interior</label>
                <input type="text" name="direccion" required>
            </div>
        </div>

        <br>
        <div style="text-align: center;">
            <button type="submit">Realizar compra</button>
        </div>

    </form>

</div>

</body>
</html>

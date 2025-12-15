<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Finalizada - PAC MENSWEAR</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2e9dc; 
        }

        .container {
            max-width: 850px;
            margin: 60px auto;
            background: #fff;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            text-align: center;
        }

        h1 {
            font-size: 38px;
            margin-bottom: 10px;
            color: #4a2e19; 
        }

        p {
            font-size: 18px;
            color: #4a2e19;
            margin-bottom: 25px;
        }

        .check {
            font-size: 70px;
            color: #8B4513; 
            margin-bottom: 20px;
        }

        .info-box {
            background: #f7f2ec;
            border-left: 6px solid #8B4513;
            padding: 15px 25px;
            margin: 25px 0;
            border-radius: 12px;
            text-align: left;
        }

        .btn {
            display: inline-block;
            padding: 15px 35px;
            font-size: 20px;
            font-weight: bold;
            color: white;
            background: #8B4513; 
            border-radius: 12px;
            text-decoration: none;
            transition: .25s;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            margin-top: 15px;
        }

        .btn:hover {
            background: #5c2f0c;
            transform: scale(1.03);
        }

        .bottom-links {
            margin-top: 30px;
        }

        .bottom-links a {
            color: #4a2e19;
            text-decoration: underline;
            font-size: 16px;
            margin: 0 15px;
        }

    </style>
</head>
<body>

    <div class="container">
        
        <div class="check">✔</div>

        <h1>¡Compra finalizada!</h1>
        <p>Gracias por confiar en <strong>PAC Menswear</strong>. Tu pedido ha sido procesado con éxito.</p>

        <div class="info-box">
            <p><strong>Resumen rápido:</strong></p>
            <p>✓ Tu pago fue aprobado.</p>
            <p>✓ Tu pedido está siendo preparado.</p>
            <p>✓ Podrás ver los detalles completos en el ticket.</p>
        </div>

        <a class="btn" href="ticket.php" target="_blank">VER DETALLES DE COMPRA</a>

        <div class="bottom-links">
            <a href="vista_usuario.php">Seguir comprando</a>
            <a href="Logintienda.php">Salir</a>
        </div>
    </div>

</body>
</html>

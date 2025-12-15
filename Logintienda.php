<?php
session_start();

@require_once 'conexion.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    if (empty($usuario) || empty($password)) {
        $mensaje_error = "Usuario y contraseña son requeridos.";
    } else {
        try {
      
            if (!isset($pdo)) {
                throw new Exception("Error en la conexión a la base de datos.");
            }
            
    
            $sql = "SELECT id, usuario, password, rol FROM usuarios WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();
            

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($password === $user['password']) {
                
                
                    
                    $_SESSION['usuario'] = $user['usuario'];
                    $_SESSION['rol'] = $user['rol'];
                    $_SESSION['user_id'] = $user['id'];
                    
                    
                    if ($user['rol'] == 'admin') {
                        header("Location: productos.php");
                        exit();
                    } elseif ($user['rol'] == 'cliente') {
                        header("Location: vista_usuario.php");
                        exit();
                    } else {
                        $mensaje_error = "Rol no válido.";
                    }
                } else {
                    $mensaje_error = "Usuario o contraseña incorrectos.";
                }
            } else {
                $mensaje_error = "Usuario o contraseña incorrectos.";
            }
            
        } catch(PDOException $e) {
            $mensaje_error = "Error en la base de datos: " . $e->getMessage();
            
            
        } catch(Exception $e) {
            $mensaje_error = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAC Menswear - Login</title>
    <style>
        body {
            background-color: #ecbd76ff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            width: 300px;
        }

        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 18px;
            color: #333;
            letter-spacing: 2px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            color: #000;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }

        .btn-continuar {
            background-color: #333;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .btn-continuar:hover {
            background-color: #555;
        }

        .error-msg {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid red;
            padding: 5px;
            background-color: #ffe6e6;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="imagenes/PAC.png" alt="Logo" class="logo">
        
        <h2>Inicio de Sesion</h2>

        <?php if(isset($mensaje_error)) { ?>
            <p class="error-msg">⛔ <?php echo htmlspecialchars($mensaje_error); ?></p>
        <?php } ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="usuario">USUARIO</label>
                <input type="text" name="usuario" id="usuario" required>
            </div>

            <div class="form-group">
                <label for="password">CONTRASEÑA</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit" class="btn-continuar">Continuar</button>
        </form>
    </div>

</body>
</html>
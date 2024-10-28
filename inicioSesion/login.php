<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="/CentroSalud/inicioSesion/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="div-form">
        <form class="forms-login" action="/CentroSalud/inicioSesion/validacion.php" method="post">
            <h1>Iniciar sesión</h1>
            <label class="div-email">
                <i class='bx bx-envelope'></i>
                <input type="text" placeholder="Nombre Usuario" name="Nombre" required>
            </label>
            <div class="div-img">
                <img class="img-usuario"
                    src="https://cdn.icon-icons.com/icons2/827/PNG/512/user_icon-icons.com_66546.png" alt="">
            </div>
            <label class="div-password">
                <i class='bx bxs-lock'></i>
                <input type="password" name="Contra" id="contraseña" placeholder="Ingrese su contraseña" required>
            </label>
            <label for="">Seleccionar Perfil: </label>
            <select name="perfil" required>
                <option value="">--Seleccione su Tipo de Perfil--</option>
                <option value="medico">Médico</option>
                <option value="secretaria">Secretaria</option>
                <option value="transportista">Transportista</option>
            </select>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>

</html>
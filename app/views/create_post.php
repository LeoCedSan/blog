<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Post</title>
    <!-- Asegúrate de incluir tu archivo CSS para estilos aquí si es necesario -->
    <link rel="stylesheet" href="./app/public/css/form.css">
</head>
<body>
    <div class="container">
        <h1>Crear Nuevo Post</h1>
        <p>Por favor, completa el formulario a continuación y haz clic en "Guardar Post" para crear un nuevo post.</p>
        <div  id="Fmr">
        <form action="/blog/post" method="post">
            <!-- No se necesita campo para el ID en la creación -->
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Contenido:</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <button type="submit">Guardar Post</button>
            <a href="/blog">Cancelar</a>
        </form>
        </div>
    </div>
</body>
</html>

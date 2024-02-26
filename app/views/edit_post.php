<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Post</title>
    <!-- Asegúrate de incluir tu archivo CSS para estilos aquí si es necesario -->
    <link rel="stylesheet" href="./app/public/css/form.css">
</head>
<body>
    <div class="container">
        <h1>Editar Post</h1>
        <p>Por favor, edita el post a continuación y haz clic en "Actualizar Post" para guardar los cambios.</p>
        <div  id="Fmr">
        <form action="/blog/post" method="post">
            <input type="hidden" name="id" value="<?= $postItem['id']; ?>">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($postItem['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Contenido:</label>
                <textarea id="content" name="content" required><?= htmlspecialchars($postItem['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            <button type="submit">Actualizar Post</button>
            <a href="/blog">Cancelar</a>
        </form>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Home</title>
    <link rel="stylesheet" href="./app/public/css/styles.css"> <!-- Asegúrate de tener este archivo CSS para estilos -->
</head>
<body>
    <div class="container">
        <h1>Posts Recientes</h1>
        <!-- Enlace para crear un nuevo post -->
        <a href="/blog/create" class="btn">Crear Nuevo Post</a>
        <!-- Comprobar si hay posts para mostrar -->
        <?php if (!empty($postArr)): ?>
            <div class="posts">
                <?php foreach ($postArr as $post): ?>
                    <div class="post">
                        <h2><a href="/blog/post?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?></a></h2>
                        <p><?= nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')) ?></p>
                        <span>Publicado el: <?= date('j M Y', strtotime($post['created_at'])) ?></span>
                        <!-- Enlaces para editar y eliminar -->
                        <a href="/blog/edit?id=<?= $post['id'] ?>" class="btn">Editar</a>
                        <a href="/blog/delete?id=<?= $post['id'] ?>" class="btn" onclick="return confirm('¿Estás seguro de querer eliminar este post?');">Eliminar</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No se encontraron posts.</p>
        <?php endif; ?>
    </div>
</body>
</html>

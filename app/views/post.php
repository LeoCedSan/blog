<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($postItem['title'], ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="./app/public/css/styles.css"> <!-- Asegúrate de tener este archivo CSS para estilos -->
</head>
<body>
    <div class="container">
        <!-- Detalles del Post -->
        <article class="post-detail">
            <h1><?= htmlspecialchars($postItem['title'], ENT_QUOTES, 'UTF-8') ?></h1>
            <p><?= nl2br(htmlspecialchars($postItem['content'], ENT_QUOTES, 'UTF-8')) ?></p>
            <div class="post-meta">
                <span>Publicado el: <?= date('j M Y', strtotime($postItem['publish_date'])) ?></span>
            </div>
        </article>

        <a href="/blog">Volver a la página principal</a>
    </div>
</body>
</html>

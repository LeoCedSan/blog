<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($postItem['title'], ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="./app/public/css/post.css"> <!-- Asegúrate de tener este archivo CSS para estilos -->
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

        <div class="comment-form">
        <form action="/blog/post/addComment/1" method="post">
        <label for="comment">Hacer un comentario:</label>
        <textarea id="comment" name="comment" required></textarea>
        <button type="submit">Agregar Comentario</button>
    </form>
</div>

<!-- Mostrar los comentarios existentes -->
<div class="comments-section">
    <h2>Comentarios:</h2>

    <?php if (isset($postItem['comments']) && is_array($postItem['comments']) && !empty($postItem['comments'])): ?>
        <?php foreach ($postItem['comments'] as $comment): ?>
            <div class="comment">
                <?php if (isset($comment['content'])): ?>
                    <p><?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <div class="comment-meta">
                    <?php if (isset($comment['user_id'])): ?>
                        <span>Publicado por Usuario ID <?= $comment['user_id'] ?></span>
                    <?php endif; ?>

                    <?php if (isset($comment['created_at'])): ?>
                        <span>Fecha: <?= date('j M Y H:i:s', strtotime($comment['created_at'])) ?></span>
                    <?php endif; ?>

                    <!-- Botón para eliminar el comentario -->
                    <?php if (isset($comment['id'])): ?>
                        <form action="/blog/post/deleteComment/<?= $comment['id'] ?>" method="post">
                            <button type="submit">Eliminar comentario</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay comentarios disponibles.</p>
    <?php endif; ?>
</div>

        <a href="/blog">Volver a la página principal</a>
    </div>
</body>

</html>

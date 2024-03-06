<?php
// app/controllers/PostController.php

require_once './app/models/Post.php';

class PostController
{
    // Método para mostrar la página principal con todos los posts
    public function index()
    {
        // Instanciar el modelo Post
        $post = new Post();

        // Establecer la cantidad de posts por página
        $postsPerPage = 9;

        // Obtener la página actual
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

        // Llamar al método readWithPagination() del modelo para obtener los posts paginados
        $postArr = $post->readWithPagination($currentPage, $postsPerPage);

        // Obtener el total de posts para calcular el número total de páginas
        $totalPosts = $this->getTotalPosts();
        $totalPages = ceil($totalPosts / $postsPerPage);

        // Verificar si hay posts
        if ($postArr->rowCount() > 0) {
            // Cargar la vista correspondiente y pasarle los posts, total de páginas y página actual
            require_once './app/views/home.php';
        } else {
            // No hay posts, cargar una vista diferente o mostrar un mensaje
            echo "No se encontraron posts.";
        }
    }

    // Método para mostrar un post específico por su ID
    public function show($id)
    {
        // Instanciar el modelo Post
        $post = new Post();
        // Llamar al método readOne() del modelo para obtener el post específico
        $post->readOne($id);
        // Verificar si el post fue encontrado
        if ($post->id != null) {
            // Preparar el post para ser mostrado
            $postItem = array(
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'publish_date' => $post->publish_date
            );

            // Obtener los comentarios del post
            $postItem['comments'] = $post->getCommentsForPost($postItem['id']);

            // Cargar la vista correspondiente y pasarle el post y los comentarios
            require_once './app/views/post.php';
        } else {
            // El post no existe, cargar una vista de error o mostrar un mensaje
            echo "Post no encontrado.";
        }
    }

    // Método para obtener el total de posts
    public function getTotalPosts()
    {
        $post = new Post();
        $stmt = $post->read(); // Assuming read() fetches all posts without pagination
        return $stmt->rowCount();
    }

    
    // Método para mostrar un post específico por su I

    /**
     * Método para guardar un post
     * Este método maneja tanto la creación de un nuevo post como la actualización de un post existente.
     * Si el ID del post se proporciona, se asume que el post ya existe y se actualiza.
     * Si no se proporciona un ID, se asume que es un nuevo post y se crea.
     * Finalmente, redirige al usuario a la página de inicio o a la lista de posts.
     */
    public function save()
    {
        $post = new Post();
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $title = $_POST['title'];
        $content = $_POST['content'];
        $user_id = 1; // El ID del usuario actualmente autenticado
        if ($id) {
            // Actualizar el post existente
            $post->update($id, $title, $content);
        } else {
            // Crear un nuevo post
            $post->create($title, $content, $user_id);
        }

        // Redireccionar al inicio o a la lista de posts
        header('Location: /blog');
    }

    /**
     * Método para eliminar un post
     * Este método maneja la eliminación de un post por su ID.
     * Finalmente, redirige al usuario a la página de inicio o a la lista de posts.
     * @param int $id - El ID del post a eliminar
     * @return void
     */
    public function delete($id)
    {

        $post = new Post();
        $post->delete($id);

        // Redireccionar a la lista de posts
        header('Location: /blog');
    }

    /**
     * Método para mostrar el formulario de edición de un post
     * @param int $id - El ID del post a editar
     * @return void
     */
    public function edit($id)
    {
        $post = new Post();
        $post->readOne($id);

        if ($post->id != null) {
            // Preparar el post para ser editado
            $postItem = array(
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'publish_date' => $post->publish_date
            );

            // Cargar la vista de edición y pasarle el post
            require_once './app/views/edit_post.php'; // Asegúrate de tener esta vista
        } else {
            echo "Post no encontrado para editar.";
        }
    }

    /**
     * Método para mostrar el formulario de creación de un nuevo post
     * @return void
     */
    public function create()
    {
        require_once './app/views/create_post.php';
    }

    // Dentro de PostController.php
public function addComment($postId, $userId, $content)
{
    $post = new Post();
    $success = $post->addComment($postId, $userId, $content);

    if ($success) {
        // Redirigir de vuelta al post después de agregar el comentario
        header("Location: /blog/post/show/{$postId}");
    } else {
        // Manejar el error de alguna manera (puede ser útil mostrar un mensaje de error en la vista)
        echo "Error al agregar el comentario.";
    }
}

public function deleteComment($commentId, $postId)
{
    $post = new Post();
    $success = $post->deleteComment($commentId);

    if ($success) {
        // Redirigir de vuelta al post después de eliminar el comentario
        header("Location: /blog/post/show/{$postId}");
    } else {
        // Manejar el error de alguna manera (puede ser útil mostrar un mensaje de error en la vista)
        echo "Error al eliminar el comentario.";
    }
}

}

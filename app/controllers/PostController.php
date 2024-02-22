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

        // Llamar al método read() del modelo para obtener todos los posts
        $stmt = $post->read();
        $postCount = $stmt->rowCount();

        // Verificar si hay posts
        if ($postCount > 0) {
            // Array para almacenar los posts
            $postArr = array();

            // Recorrer todos los registros
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $postItem = array(
                    'id' => $id,
                    'title' => $title,
                    'content' => html_entity_decode($content),
                    'created_at' => $created_at
                );

                array_push($postArr, $postItem);
            }

            // Cargar la vista correspondiente y pasarle los posts
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
            $comments = $post->getComments();

            // Cargar la vista correspondiente y pasarle el post y los comentarios
            require_once './app/views/post.php';
        } else {
            // El post no existe, cargar una vista de error o mostrar un mensaje
            echo "Post no encontrado.";
        }
    }

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

        if ($id) {
            // Actualizar el post existente
            $post->update($id, $title, $content);
        } else {
            // Crear un nuevo post
            $post->create($title, $content);
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

        
        // Cargar la vista de creación
        require_once './app/views/create_post.php'; 
    }
}

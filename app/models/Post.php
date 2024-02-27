<?php
// app/models/Post.php

require_once './app/config/Database.php';

class Post
{
    // Conexión a la base de datos y nombre de la tabla
    private $conn;
    private $table_name = "posts";

    // Propiedades del objeto Post
    public $id;
    public $title;
    public $content;
    public $publish_date;
    private $user_id;

    // Constructor con $db como conexión a la base de datos
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Método para leer todos los posts
   // Método para leer todos los posts con paginación
public function readWithPagination($page = 1, $perPage = 9)
{
    // Calcular el offset
    $offset = ($page - 1) * $perPage;

    // Consulta para seleccionar registros con paginación
    $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at ASC LIMIT :offset, :perPage";

    // Preparar declaración de consulta
    $stmt = $this->conn->prepare($query);

    // Vincular valores de paginación
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->bindParam(":perPage", $perPage, PDO::PARAM_INT);

    // Ejecutar consulta
    $stmt->execute();

    return $stmt;
}
public function read()
{
    // Consulta para seleccionar todos los registros
    $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at ASC";

    // Preparar declaración de consulta
    $stmt = $this->conn->prepare($query);

    // Ejecutar consulta
    $stmt->execute();

    return $stmt;
}


    // Método para leer un solo post por ID
    public function readOne($id)
    {
        // Consulta para leer un solo registro
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        // Preparar declaración de consulta
        $stmt = $this->conn->prepare($query);

        // Vincular ID del post a ser actualizado
        $stmt->bindParam(1, $id, PDO::PARAM_INT); // Especificar el tipo de dato ayuda a PDO a manejar correctamente la variable

        // Ejecutar consulta
        $stmt->execute();

        // Obtener fila recuperada
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Establecer valores a propiedades del objeto
        if ($row) {
            $this->id = $row['id']; // Asegúrate de asignar el valor de 'id' aquí
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->publish_date = $row['created_at'];
        }

    }

    /**
     * Método para crear un nuevo post
     * Este método maneja tanto la creación de un nuevo post como la actualización de un post existente.
     * @param string $title
     * @param string $content
     * @param int $user_id
     * @return bool
     */
    public function create($title, $content, $user_id)
    {
        // Query to insert a record
        $query = "INSERT INTO " . $this->table_name . " (title, content, user_id) VALUES (:title, :content, :user_id)";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $title = htmlspecialchars(strip_tags($title));
        $content = htmlspecialchars(strip_tags($content));

        // Bind values
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":user_id", $user_id);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Method to update a post
     * Handles both the creation of a new post and the update of an existing post.
     * @param int $id
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function update($id, $title, $content)
    {
        // Query to update a record
        $query = "UPDATE " . $this->table_name . " SET title = :title, content = :content WHERE id = :id";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $id = htmlspecialchars(strip_tags($id));
        $title = htmlspecialchars(strip_tags($title));
        $content = htmlspecialchars(strip_tags($content));

        // Bind values
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    /**
     * Método para eliminar un post
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        // Consulta para eliminar un registro
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Preparar declaración
        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->id = htmlspecialchars(strip_tags($id));

        // Vincular id
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        // Ejecutar
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    /**
     * Método para obtener los comentarios de un post
     * @return array
     */
    public function getComments()
    {
        // Consulta para obtener los comentarios de un post
        $query = "SELECT * FROM comments WHERE post_id = :post_id";

        // Preparar declaración
        $stmt = $this->conn->prepare($query);

        // Vincular valor
        $stmt->bindParam(":post_id", $this->id, PDO::PARAM_INT);

        // Ejecutar
        $stmt->execute();

        // Obtener resultados
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $comments;
    }
}



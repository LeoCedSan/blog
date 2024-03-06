<?php

class AuthController
{
    public function login()
    {
        require_once './app/views/login.php';
    }

    public function authenticate()
    {
        // Check if username and password are set in the POST request
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            if ($this->isValidUser($username, $password)) {
                // Iniciar sesión
                session_start();
                $_SESSION['username'] = $username;
    
                // Redirigir a la página de inicio
                header('Location: /blog/');
                exit();
            } else {
                // Mostrar mensaje de error
                $error = "Usuario o contraseña incorrectos";
            }
        } else {
            // Handle the case where username or password is not set
            $error = "Por favor, ingrese tanto el nombre de usuario como la contraseña";
        }
    
        // Include the login view with or without an error message
        require_once './app/views/login.php';
    }
    

    private function isValidUser($username, $password)
    {
        // Validar usuario y contraseña
        return $username === 'Admin' && $password === 'password';
        
    }

}

<?php
// app/controllers/AuthController.php

class AuthController
{
    public function login()
    {
        require_once './app/views/login.php';
    }

    public function authenticate()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($this->isValidUser($username, $password)) {
            // Iniciar sesión
            session_start();
            $_SESSION['username'] = $username;

            // Redirigir a la página de inicio
            header('Location: /blog/');
        } else {
            // Mostrar mensaje de error
            $error = "Usuario o contraseña incorrectos";
            require_once './app/views/login.php';
        }
    }

    private function isValidUser($username, $password)
    {
        // Validar usuario y contraseña
        return $username === 'Admin' && $password === 'password';
        
    }

}

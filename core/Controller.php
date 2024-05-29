<?php
class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        if (str_contains($view, 'admin')) {
            ob_start();
            require 'views/' . $view . '.php';
            $content = ob_get_clean();
            require 'views/layouts/admin.php';
        } else if (str_contains($view, 'app') && !str_contains($view, 'payment')) {
            ob_start();
            require 'views/' . $view . '.php';
            $content = ob_get_clean();
            require 'views/layouts/app.php';
        } else {
            require 'views/' . $view . '.php';
        }
    }


    protected function redirect($url)
    {
        header('Location: ' . $url);
    }

    protected function back()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    protected function redirectWithMessage($url, $type, $message)
    {
        $_SESSION[$type] = $message;
        header('Location: ' . $url);
    }

    //API
    protected function response($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

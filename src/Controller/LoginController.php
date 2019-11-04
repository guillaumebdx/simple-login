<?php
namespace App\Controller;

use App\Model\LoginManager;

class LoginController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Login/index.html.twig', [
            'target' => 'create',
        ]);
    }

    public function create()
    {
        echo $_SESSION['username'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loginManager = new LoginManager();
            $userData = [
                'name'     => $_POST['name'],
                'password' => password_hash($_POST['password'], PASSWORD_ARGON2I) ,
            ];
            $loginManager->insert($userData);
            header('Location:/login/index');
        }
    }
    
    public function log()
    {
        return $this->twig->render('Login/index.html.twig', [
            'target' => 'check',
        ]);
    }
    
    public function check()
    {
        $loginManager = new LoginManager();
        $userData = $loginManager->selectOneByName($_POST['name']);
        if ($userData && !empty($userData) && password_verify($_POST['password'], $userData['password'])) {
            $_SESSION["username"] = $userData['name'];
            header("location:/login/create");
        } else {
            //TODO header to error
            echo "pas ok";
        }
    }
}

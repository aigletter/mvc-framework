<?php


namespace app\Controllers;


use Learning\MVC\Controller\ControllerInterface;

class UserController implements ControllerInterface
{
    public function view(int $id, string $name, bool $bla): string
    {
        return 'User controller with id ' . $id . '<br>';
    }

    public function show($name)
    {

    }
}
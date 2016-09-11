<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Twig_Environment;
use Twig_Loader_Filesystem;

class HelloController
{

    protected $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(config('twig')['view']);
        $this->twig = new Twig_Environment($loader, array(
            'cache' => false
        ));
    }

    public function sayHello(Request $request)
    {
        $template = $this->twig->loadTemplate('hello.html');

        return new Response($template->render(['name' => $request->get('name')]));
    }
}
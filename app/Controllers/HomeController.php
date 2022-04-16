<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function create(): string
    {
        $param = ['title' => 'Create a hotel'];

        return $this->render('create', $param);
    }
}
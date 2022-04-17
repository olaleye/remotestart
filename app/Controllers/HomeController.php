<?php

namespace App\Controllers;

use Core\Request;
use Core\Validator;

class HomeController extends Controller
{
    public function create(): string
    {
        $param = ['title' => 'Create a hotel'];

        return $this->render('create', $param);
    }

    public function store(Request $request): string
    {
        $payload = $request->getBody();

        $rules = [
            'hotel_name' => 'required|string',
            'floor' => 'required|int',
            'room_number' => 'required|int',
            'room_price' => 'required'
        ];

        $validator = new Validator();
        $errors = $validator->validate($rules, $payload);
        if(count($errors) > 0){
            $param = ['errors' => $errors, 'title' => 'Create a hotel', 'payload' => $payload];
            return $this->render('create', $param);
        }
        // TODO
    }
}
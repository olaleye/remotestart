<?php

namespace App\Controllers;

use Core\Request;
use Core\Validator;
use MercuryHolidays\Search\Searcher;

class HomeController extends Controller
{
    private Searcher $searcher;

    public function __construct()
    {
        $this->searcher = new Searcher();
    }
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

        $this->searcher->add($payload);

        $param = ['title' => 'Hotel added successfully'];
        return $this->render('create', $param);
    }

    public function search(): string
    {
        $param = ['title' => 'Search hotels with Adjacent rooms'];

        return $this->render('search', $param);
    }

    public function show(Request $request): string
    {
        $payload = $request->getBody();

        $rules = [
            'number_of_rooms' => 'required',
            'minimum_budget' => 'required',
            'maximum_budget' => 'required'
        ];

        $validator = new Validator();
        $errors = $validator->validate($rules, $payload);

        if(count($errors) > 0){
            $param = ['errors' => $errors, 'title' => 'Search hotels with Adjacent rooms', 'payload' => $payload];
            return $this->render('search', $param);
        }

        $hotels = $this->searcher->search($payload['number_of_rooms'], $payload['minimum_budget'], $payload['maximum_budget']);
        $param = ['title' => 'Search hotels with Adjacent rooms', 'hotels' => $hotels];
        return $this->render('search', $param);
    }
}
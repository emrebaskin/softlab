<?php

namespace App\Http\Controllers;

use App\Foursquare\Foursquare;
use Illuminate\Http\Request;

class FoursquareController extends Controller
{

    public function index()
    {

        return view('index');

    }

    public function categories()
    {

        $foursquareClient = new Foursquare();

        return $foursquareClient->categories();

    }

    public function explore(Request $request)
    {

        $params = [
            'categoryId' => $request->input('categoryId', ''),
            'radius'     => $request->input('radius', 10),
            'near'       => $request->input('near', ''),
        ];

        $foursquareClient = new Foursquare();

        return $foursquareClient->explore($params);

    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use App\Http\Resources\CurrencyResource;

class CurrencyController extends Controller
{
    public function index()
    {
       return CurrencyResource::collection(Currency::all());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class FuncoesController extends Controller
{

    public function index()
    {
            return "Ok";
    }

}
<?php

namespace App\Controllers;

class PedidosController extends Controller
{
    public function index()
    {
        response()->render('pedido');
    }

   
}

<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Muestra la lista de todos los productos
    public function index()
    {
        $productos = Producto::all();// obtiene todos los productos de la base de datos
        //podemos regularlarlo

        return view('productos.index', compact('productos'));// te lleva a la vista de listado de productos
    }

    // Muestra el detalle de un producto específico
    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto')); // te lleva a la vista de detalle del producto
    }
}

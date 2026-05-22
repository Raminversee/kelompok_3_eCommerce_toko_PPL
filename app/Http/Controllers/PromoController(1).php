<?php
namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::aktif()->paginate(9);
        return view('promo.index', compact('promos'));
    }
}
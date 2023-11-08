<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowBerita extends Controller
{
    public function show(Berita $berita)
    {
        return view('berita.show',[
            'berita'=> $berita
        ]);
    }
}

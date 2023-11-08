<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;

    protected $table = "kategori";
    protected $fillable = ['kategori'];

    protected $primaryKey = "kategori_id";


    public function berita(){
        return $this->hasMany(Berita::class,'kategori_id','kategori_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lane extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',
        'description',
        'index',
        'board_id',
        'author_id',
    ] ;

    public function board()
    {
        return $this->belongsTo(Board::class) ;
    }

    public function author()
    {
        return $this->belongsTo(User::class) ;
    }

    public function cards()
    {
        return $this->hasMany(Card::class) ;
    }
}

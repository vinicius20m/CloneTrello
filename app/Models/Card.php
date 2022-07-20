<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',
        'content',
        'index',
        'lane_id',
        'author_id',
    ] ;

    public function lane()
    {
        return $this->belongsTo(Lane::class) ;
    }

    public function author()
    {
        return $this->belongsTo(User::class) ;
    }


    public function comments()
    {
        return $this->hasMany(CardComment::class) ;
    }

    public function checklists()
    {
        return $this->hasMany(CardChecklist::class) ;
    }
}

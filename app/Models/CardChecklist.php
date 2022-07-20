<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardChecklist extends Model
{
    use HasFactory;

    protected $fillable = [

        'card_id',
        'title',
    ] ;

    public function card()
    {
        return $this->belongsTo(Card::class) ;
    }

    public function items()
    {
        return $this->hasMany(ChecklistItem::class, 'checklist_id') ;
    }
}

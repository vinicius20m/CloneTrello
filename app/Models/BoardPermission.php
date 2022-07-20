<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardPermission extends Model
{
    use HasFactory;

    protected $fillable = [

        'board_id',
        'user_id',
        'is_owner',
        'accepted',
        'can_create',
        'can_edit',
        'can_delete',
        'can_move',
        'can_add_member',
        'can_remove_member',
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class) ;
    }

    public function board()
    {
        return $this->belongsTo(Board::class) ;
    }

    public function setUserIdAttribute($user)
    {
        $board = Board::find($this->attributes['board_id']) ;
        if($board) if($user == $board->user_id){
            $this->attributes['is_owner'] = true ;
            $this->attributes['accepted'] = true ;
            $this->attributes['can_create'] = true ;
            $this->attributes['can_edit'] = true ;
            $this->attributes['can_delete'] = true ;
            $this->attributes['can_move'] = true ;
            $this->attributes['can_add_member'] = true ;
            $this->attributes['can_remove_member'] = true ;
        }

        $this->attributes['user_id'] = $user ;
    }
}

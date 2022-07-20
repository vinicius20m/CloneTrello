<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Card;
use App\Models\Lane;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function moveCard(Lane $lane, Request $r)
    {

        // foreach (Card::where('lane_id', 1)->get() as $key => $value)
        //     $value->update(['index' => $key]);

        $card = Card::find($r->card_id) ;
        if($card->lane_id == $lane->id){

            $toUpper = $r->oldIndex < $r->newIndex ? true : false ;
            $modifiedIndexes = Card::where('lane_id', $lane->id)
            ->whereBetween(
                'index',
                [
                    $toUpper? $r->oldIndex +1 : $r->newIndex,
                    $toUpper? $r->newIndex : $r->oldIndex -1
                ]
            )->get() ;

            $card->update(['index' => $r->newIndex]) ;
            foreach($modifiedIndexes as $modifiedIndex)
                $modifiedIndex->update(['index' => $modifiedIndex->index + ($toUpper? -1 : 1)])
            ;
        }else {

            // sort the cards on the old lane
            $modifiedIndexes = Card::where('lane_id', $card->lane_id)->where('index', '>', $r->oldIndex)->get() ;
            foreach($modifiedIndexes as $modifiedIndex)
                $modifiedIndex->update(['index' => $modifiedIndex->index -1])
            ;

            // sort the cards on the new lane
            $modifiedIndexes = Card::where('lane_id', $lane->id)->where('index', '>=', $r->newIndex)->get() ;
            foreach($modifiedIndexes as $modifiedIndex)
                $modifiedIndex->update(['index' => $modifiedIndex->index +1])
            ;

            // update the card
            $card->update(['lane_id' => $lane->id, 'index' => $r->newIndex]) ;
        }

        return response($modifiedIndexes) ;
    }

    public function moveLane(Board $board, Request $r)
    {
        // foreach (lane::where('board_id', $board->id)->get() as $key => $value)
        //     $value->update(['index' => $key])
        // ;

        // return response($r) ;

        $lane = Lane::find($r->lane_id) ;

        $toUpper = $r->oldIndex < $r->newIndex ? true : false ;
        $modifiedIndexes = Lane::where('board_id', $board->id)
        ->whereBetween(
            'index',
            [
                $toUpper? $r->oldIndex +1 : $r->newIndex,
                $toUpper? $r->newIndex : $r->oldIndex -1
            ]
        )->get() ;

        $lane->update(['index' => $r->newIndex]) ;
        foreach($modifiedIndexes as $modifiedIndex)
            $modifiedIndex->update(['index' => $modifiedIndex->index + ($toUpper? -1 : 1)])
        ;

        return response($modifiedIndexes) ;
    }
}

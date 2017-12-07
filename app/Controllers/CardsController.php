<?php
namespace App\Controllers;

use App\Models\Deck;
use App\Models\Cards;
use Sirius\Validation\Validator;

class CardsController extends BaseController{

    public function getIndex($name){
        $webInfo = [
            'title' => 'Card Info - HearthstoneDb'
        ];

        // Si hay dos copias de la carta, elimina el x2 del nombre para buscar en la db.
        if (strpos($name, "x2") !== false){
            $cardName = trim(iconv_substr($name, 0, -2));
        }else{
            $cardName = trim($name);
        }

        $card = Cards::where('name', $cardName)->first();

        if( !$card ){
            return $this->render('404.twig', ['webInfo' => $webInfo]);
        }

        //dameDato($distro);
        return $this->render('card.twig', [
            'card' => $card,
            'webInfo'=> $webInfo]);
    }
}
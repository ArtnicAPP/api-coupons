<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Coupons extends Controller
{
    //
  public function generateDefault(){
    $randomPrefix = chr( rand(65, 90) ) . chr( rand(65,90) )  . chr( rand(65,90) );
    $defaultQuantity = 50000;

    return response()->json($this->generate($randomPrefix, $defaultQuantity));
  }

  public function generateWithPrefix($prefix){
    $defaultQuantity = 50000;

    return response()->json($this->generate($prefix, $defaultQuantity));
  }

  public function generateWithQuantity($quantity){
    $randomPrefix = chr( rand(65, 90) ) . chr( rand(65,90) )  . chr( rand(65,90) );

    return response()->json($this->generate($randomPrefix, $quantity));
  }

  public function generateWithBoth($prefix, $quantity){
    // return response()->json($this->generate($prefix, $quantity));
    return response()->json($this->generate($prefix, $quantity));
  }

  public function generate($prefix, $quantity){
    $result = new \App\Coupon();
    $i = 0;

    if($quantity > 100000):
      $result->addError("Quantidade de cupons solicitados maior que o máximo permitido");
    elseif (strlen($prefix) > 3):
      $result->addError("Prefixo maior que 3 caracteres");
    elseif (preg_match("/[^A-Z]/", $prefix)):
      $result->addError("Prefixo deve conter apenas caracteres maiúsculos");
    else:
      $code = 0;
      while($i < $quantity):
        $seed = rand(2,10);
        $pow = rand(7,9);
        $code = ($code + pow($seed, $pow)) % pow(10, 7);
        $newOne = sprintf("%s%07d", $prefix, $code);
        if( !$result->inList($newOne) ):
          $result->addToList($newOne);
          $i++;
        endif;
      endwhile;
      $result->sort();
    endif;

    return $result->toArray();
  }
}

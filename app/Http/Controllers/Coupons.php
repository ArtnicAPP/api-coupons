<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Controller for routes manipulation
class Coupons extends Controller
{
  public function generateDefault($size){
    $randomPrefix = chr(rand(65, 90) ) . chr( rand(65,90) )  . chr( rand(65,90));
    $defaultQuantity = pow(10, $size - strlen($randomPrefix));
    return response()->json($this->generate($randomPrefix, $defaultQuantity, $size));
  }

  public function generateWithPrefix($prefix, $size){
    $defaultQuantity = pow(10, $size - strlen($prefix));
    return response()->json($this->generate($prefix, $defaultQuantity, $size));
  }

  public function generateWithQuantity($quantity, $size){
    $randomPrefix = chr( rand(65, 90) ) . chr( rand(65,90) )  . chr( rand(65,90) );
    return response()->json($this->generate($randomPrefix, $quantity, $size));
  }

  public function generateWithBoth($prefix, $quantity, $size){
    return response()->json($this->generate($prefix, $quantity, $size));
  }

  public function generate($prefix, $quantity, $size){
    $result = new \App\Coupon();
    $i = 0;
    $maxCombs = pow(10, $size - strlen($prefix));

    if($quantity > 100000):
      $result->addError("Quantidade de cupons solicitados maior que o máximo permitido");

    elseif (strlen($prefix) < 3):
      $result->addError("Prefixo menor que 3 caracteres");

    elseif (preg_match("/[^A-Z]/", $prefix)):
      $result->addError("Prefixo deve conter apenas caracteres maiúsculos");

    elseif ($size > 32):
      $result->addError("Os cupons não podem ter mais que 32 caracteres");

    elseif ($size < 5):
      $result->addError("Os cupons não podem ter menos que 5 caracteres");

    elseif ($quantity > $maxCombs):
      $result->addError(sprintf("Esse prefixo permite a geração de até %d códigos de tamanho %d. %d foram solicitados", $maxCombs, $size, $quantity));

    else:
      $code = 0;
      $fixed = strlen($prefix);
      while($i < $quantity):

        $seed = rand(2,10);
        $pow = rand(7,9);
        $code = ($code + pow($seed, $pow)) % pow(10, $size - $fixed);

        $newOne = sprintf("%s%0". ($size - $fixed) . "d", $prefix, $code);
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

<?php
namespace App;

class Coupon {

  private $list;
  private $error;

  public function __construct(){
    $this->list = array();
    $this->error = array();
  }

  public function addToList($elem){
    $this->list[] = $elem;
    return true;
  }

  public function addError($err){
    $this->error[] = $err;
    return true;
  }

  public function getList(){
    return $this->list;
  }

  public function getErrors(){
    return $this->error;
  }

  public function sort(){
    sort($this->list);
  }

  public function inList($elem){
    return in_array($elem, $this->list);
  }

  public function toArray(){
    return array( "cupons" =>
      array(
        "list" => $this->list,
        "error" => $this->error
      )
    );
  }

}

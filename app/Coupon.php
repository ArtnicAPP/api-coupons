<?php
namespace App;

class Coupon {

  private $list; // array to store all generated coupon codes
  private $error; // array to store all error messages when validating the generation request

  // Initialize object attributes, i. e., create both arrays, list and errors
  public function __construct(){
    $this->list = array();
    $this->error = array();
  }

  // Insert $elem (coupon code) in object list array;
  public function addToList($elem){
    $this->list[] = $elem;
    return true;
  }

  // Insert $err (error message) in object error array
  public function addError($err){
    $this->error[] = $err;
    return true;
  }

  // Return object generated coupons code array (AKA list)
  public function getList(){
    return $this->list;
  }

  // Return object error array
  public function getErrors(){
    return $this->error;
  }

  // Sort current object list
  public function sort(){
    sort($this->list);
  }

  // Verify if given $elem is in the list
  public function inList($elem){
    return in_array($elem, $this->list);
  }

  // Convert a Coupon object to an array that will be converted in JSON in the response
  public function toArray(){
    return array( "cupons" =>
      array(
        "list" => $this->list,
        "error" => $this->error
      )
    );
  }

}

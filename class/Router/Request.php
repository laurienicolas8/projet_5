<?php 
namespace App\Router;

use App\Router\ReqParameter;

class Request {
    private $get;

    public function __construct() {
        $this->get = new ReqParameter($_GET);
    }

    public function reqGet() {
        return $this->get;
    }   
}
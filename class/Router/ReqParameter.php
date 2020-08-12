<?php 
namespace App\Router;

class ReqParameter {
    private $parameter;

    public function __construct($parameter) {
        $this->parameter = $parameter;
    }
    
    /**
     * getParam
     * control that the parameter[$name] exists
     * return the parameter
     * @param string $name
     * @return string
     */
    public function getParam($name) {
        if (isset($this->parameter[$name])) {
            return $this->parameter[$name];
        }
    }
    
    /**
     * setParam
     * create a parameter with name and value
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value) {
        $this->parameter[$name] = $value;
    }
}
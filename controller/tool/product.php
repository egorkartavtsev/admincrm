<?php

class ControllerToolProduct extends Controller{
    private $vin = 'privet';
    
    public function index($nnn) {
        $this->vin = $nnn;
        return $this;
    }
    
    public function showVin() {
        return $this->vin;
    }
}


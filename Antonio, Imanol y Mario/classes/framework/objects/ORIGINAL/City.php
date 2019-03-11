<?php

namespace framework\objects\dbobjects;

use \framework\classes\Common;

class City {

    private $id, $name, $countrycode, $district, $population;
    
    function __construct($id = null, $name = null, $countrycode = null, $district = null, $population = null) {
        $this->id = $id;
        $this->name = $name;
        $this->countrycode = $countrycode;
        $this->district = $district;
        $this->population = $population;
    }
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getCountrycode() {
        return $this->countrycode;
    }

    function getDistrict() {
        return $this->district;
    }

    function getPopulation() {
        return $this->population;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setCountrycode($countrycode) {
        $this->countrycode = $countrycode;
    }

    function setDistrict($district) {
        $this->district = $district;
    }

    function setPopulation($population) {
        $this->population = $population;
    }

}
<?php

namespace framework\objects;

class Pagination {

    private $page, $rpp, $total;
    
    function __construct($total, $page = 1, $rpp = 10) {
        $this->total = $total;
        $this->page = $page;
        $this->rpp = $rpp;
    }
    
    function first() {
        return 1;
    }
    
    function last() {
        return ceil($this->total / $this->rpp);
    }
    
    function next() {
        return min($this->page() + 1, $this->last());
    }

    function offset() {
        return ($this->page() - 1) * $this->rpp;
    }

    function page() {
        if($this->page < $this->first()) {
            return $this->first();
        }
        if($this->page > $this->last()) {
            return $this->last();
        }
        return $this->page;
    }
    
    function pages() {
        return $this->last();
    }

    function previous() {
        return max($this->page() - 1, $this->first());
    }
    
    function range($range = 3) {
        return $this->asymetricRange($range, $range);
    }
    
    function asymetricRange($left = 2, $right = 5) {
        $array = array();
        for($i = $this->page() - $left; $i <= $this->page() + $right; $i++) {
            if($i >= $this->first() && $i <= $this->last()) {
                $array[] = $i;
            }
        }
        return $array;
    }

    function rpp() {
        return $this->rpp;
    }
    
    function values() {
        return array(
            'primero'   => $this->first(),
            'anterior'  => $this->previous(),
            'rango'  => $this->range(),
            'siguiente' => $this->next(),
            'ultimo'    => $this->last(),
            'pagina' => $this->page()
        );
    }
}
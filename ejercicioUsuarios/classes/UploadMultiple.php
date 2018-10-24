<?php

/*
Cuántos archivos venían y cuántos ha podido subir
Si le pido el nombre me tiene que da los nombres con los que guarda los archivos
El keep se queda con el prime archivo
el overwrite con el ultimo
Y con el rename con todos, por lo que al cambiar el nombre se lo cambio a todos
El maxSize es solo para uno
*/

class UploadMultiple{
    
    const POLICY_KEEP = 1,
            POLICY_OVERWRITE = 2,
            POLICY_RENAME = 3;
            
    private $error = false,
            $files,
            $maxSize = 0,
            $name = '',
            $policy = self::POLICY_OVERWRITE,
            $savedNames = array(),
            $target = './archivosSubidos/',
            $type = '';
            
    function __construct ($input){
        if (isset($_FILES[$input])){
            $this->files = $_FILES[$input];
        } else {
            $this->error = true;
        }
    }
    
    private function __doUpload($file, $index) {
        $result = false;
        switch($this->policy) {
            case self::POLICY_KEEP:
                $result = $this->__doUploadKeep($file, $index);
                break;
            case self::POLICY_OVERWRITE:
                $result = $this->__doUploadOverwrite($file, $index);
                break;
            case self::POLICY_RENAME:
                $result = $this->__doUploadRename($file, $index);
                break;
        }
        return $result;
    }
    
    private function __doUploadKeep($file, $index){
        $result = false;
        $name = $this->__getFileName($file);
        if (!file_exists($this->target . $name)){
            $result = $this->__move($file, $this->target . $name, $index);
        } else{
            $this->savedNames[$index] = 'Policy error: keep.';
        }
        return $result;
    }
    
    private function __doUploadOverwrite($file, $index){
        $name = $this->__getFileName($file);
        $result = $this->__move($file, $this->target . $name, $index);
        return $result;
    }
    
    private function __doUploadRename($file, $index){
        $name = $this->__getFileName($file);
        $newName = $this->target . $name;
        if (file_exists($newName)){
            $newName = self::__getValidName($newName);
        }
        $result = $this->__move($file, $newName, $index);
        return $result;
    }
    
    private function __getFileName($file){
        $name = $file['name'];
        if ($this->name !== ''){
            $name = $this->name;//
        }
        return $name;
    }
    
    private function __getOrderedFiles(){
        $files = array();
        //Saber si hay más de un archivo
        $names = $this->files['name'];
        if(is_array($names)){
            //llamar método que ordene files
            $files = $this->__reOrder($this->files);
        } else {
            $files[] = $this->files;
        }
        return $files;
    }
    
    private static function __getValidName($file) {
        $parts = pathinfo($file);
        $extension = '';
        if(isset($parts['extension'])) {
            $extension = '.' . $parts['extension'];
        }
        $cont = 0;
        while(file_exists($parts['dirname'] . '/' . $parts['filename'] . $cont . $extension)) {
            $cont++;
        }
        return $parts['dirname'] . '/' . $parts['filename'] . $cont . $extension;
    }
    
    private function __move($file, $name, $index){
        $result = move_uploaded_file($file['tmp_name'], $name);
        if ($result){
            $nameParts = pathinfo($name);
            $this->savedNames[$index] = $nameParts['basename'];
        }else{
            $this->savedNames[$index] = 'Move error';
        }
        return $result;
    }
    
    private function __reOrder(array $array){
        $filesOrdered = array();
        foreach($array as $i => $all){
            foreach ($all as $k => $value){
                $filesOrdered[$k][$i] = $value;
            }
        }
        return $filesOrdered;
    }
    
    private function __uploadFiles($files){
        $result = 0;
        foreach($files as $index => $file){
            if ($file['error'] === 0 && $this->isValidSize($file)//No habria que poner ['size']¿
            && $this->isValidType($file)){
                    if($this->__doUpload($file, $index)){
                        $result++;
                    }
            } else{
                $this->savedNames[$index] = 'Error de subida, tamaño o tipo.';
            }
        }
        return $result;
    }
    
    function getError() {
        return $this->error;
    }

    function getMaxSize() {
        return $this->maxSize;
    }

    function getNames() {
        return $this->savedNames;
    }

    function isValidSize($size) {
        return ($this->maxSize === 0 || $this->maxSize >= $size);
    }

    function isValidType($file) {
        $valid = true;
        if($this->type !== '') {
            $type = shell_exec('file --mime ' . $file);
            $posicion = strpos($type, $this->type);
            if($posicion === false) {
                $valid = false;
            }
        }
        return $valid;
    }

    function setMaxSize($size) {
        if(is_int($size) && $size > 0) {
            $this->maxSize = $size;
        }
        return $this;
    }

    function setName($name) {
        if(is_string($name) && trim($name) !== '') {
            $this->name = trim($name);
        }
        return $this;
    }

    function setPolicy($policy) {
        if(is_int($policy) && $policy >= self::POLICY_KEEP && $policy <= self::POLICY_RENAME) {
            $this->policy = $policy;
        }
        return $this;
    }

    function setTarget($target) {
        if(is_string($target) && trim($target) !== '') {
            $this->target = trim($target);
        }
        return $this;
    }

    function setType($type) {
        if(is_string($type) && trim($type) !== '') {
            $this->type = trim($type);
        }
        return $this;
    }
    
    function upload(){
        $result = 0;
        if(!$this->error){
            $files = $this->__getOrderedFiles();
            $result = $this->__uploadFiles($files);
        }
        return $result;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
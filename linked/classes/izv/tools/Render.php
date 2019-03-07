<?php

namespace izv\tools;

class Render {
    
    static function renderCheckBox($name, $check=false, $value=1, $id=null) {
        if($id === null) {
            $id = $name;
        }
        $data = [
            'type' => 'checkbox',
            'name' => $name,
            'id' => $id,
            'value' => $value
        ];
        if($check) {
            $data['checked'] = 'checked';
        }
        return self::renderAutoClose('input', $data);
    }
    
    static function renderAutoClose($tag, array $attributes) {
        $result='';
        if(trim($tag) !== '') {
            $result .= '<' . trim($tag);
            foreach($attributes as $name=>$value) {
                $result .= ' ' . $name . '="' . $value .'"';
            }
            $result .= ' />';
        }
        return $result;
    }
    
}
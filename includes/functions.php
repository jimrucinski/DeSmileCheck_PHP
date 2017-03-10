<?php

function createDropdown($rows, $id, $name, $keepvalue, $blank, $class){
    $str = "<select name='" . $name . "' id='" . $id . "' class='" . $class . "'>";
    
    if($blank==1 || $blank=='1'){
        $str.= "<option/>";
    }
    
    foreach ($rows as $row){
        $str .= "<option  value='{$row['id']}' ";        
        if($keepvalue != ''){
            if($row['id'] == $keepvalue ){
            
            $str .= " selected ";
        }
        //if(($selectedAgentId!=null && $row[0]==$selectedAgentId) || $row[0] == $a['keepvalue'] ){
            
         //   $str .= " selected ";
        }
        $str .= ">{$row['val']}</option>";
    }
    $str .= "</select>";
    return $str;
}

?>
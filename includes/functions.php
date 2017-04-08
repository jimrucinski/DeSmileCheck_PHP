<?php
include('includes/arrays.php');
function createDropdown($rows, $id, $name, $keepvalue, $blank, $class,$submitForm){
    $str = "<select name='" . $name . "' id='" . $id . "' class='" . $class . "' ";
    if($submitForm)
        $str .= " onchange='this.form.submit()'";
    $str .=  ">";
    
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

function clense_input($data,$name,$action) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function getPercent($top, $bottom)
{
    if($top != "" && $bottom !=""){
        $result = ($top/$bottom)*100;
        $result = number_format($result, 2, '.', ',' );
        return $result . '%';
    }
    else
        return "";

}
?>
<?php

class customException extends Exception{
    public function errorMessage(){
        $errorMsg = 'Error on line ' . $this->getLine() . '<br/>in file: ' . $this->getFile()
        . ': <i>' . $this->getMessage() . '</i><br/>code: ' . $this->getCode();
        return $errorMsg;
    }

}

?>
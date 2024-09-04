<?php
function my_is_multiple(int $divider, int $multiple) : bool{
    if ($multiple % $divider === 0) {
        return true;
    } else {
        return false;
    }
}

var_dump(my_is_multiple(2, 4)); 
var_dump(my_is_multiple(2, 5)); 
?>
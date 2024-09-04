<?php
function my_str_reverse(string $string): string {
$reversed = '';

for ($i = strlen($string) -1; $i >= 0; $i--){
    $reversed .= $string[$i];
}

return $reversed;

}
$string_to_reverse = 'Hello';
$result = my_str_reverse($string_to_reverse);

echo "La chaîne inversée de '$string_to_reverse' est '$result'.";
?>
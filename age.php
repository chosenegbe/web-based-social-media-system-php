<?php
/**
 * Simple PHP age Calculator
 * 
 * Calculate and returns age based on the date provided by the user.
 * @param   date of birth('Format:yyyy-mm-dd').
 * @return  age based on date of birth
 */
function ageCalculator($dob){
    if(!empty($dob)){
        $birthdate = new DateTime($dob);
        $today   = new DateTime('today');
        $age = $birthdate->diff($today)->y;
        return $age;
    }else{
        return 0;
    }
}
$dob = '1992-03-18';
echo ageCalculator($dob);
?>
<?php

function get_age($birth_date){
 return floor((time() - strtotime($birth_date))/31556926);
 }

echo " I am ".get_age("2000-05-10") ." years old";

?>
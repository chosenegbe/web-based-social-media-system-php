function checkAge()
{ 

var today = new Date(); 
var d = document.getElementById("dob").value;
if (!/\d{4}\-\d{2}\-\d{2}/.test(d)) 
{ // check valid format
showMessage();
return false;
}

d = d.split("-");
var byr = parseInt(d[0]); 
var nowyear = today.getFullYear();
if (byr >= nowyear || byr < 1900) 
{ // check valid year
showMessage();
return false;
}
var bmth = parseInt(d[1],10)-1; // radix 10!
if (bmth <0 || bmth >11) 
{ // check valid month 0-11
showMessage(); 
return false;
}
var bdy = parseInt(d[2],10); // radix 10!
var dim = daysInMonth(bmth+1,byr);
if (bdy <1 || bdy > dim) 
{ // check valid date according to month
showMessage();
return false;
}

var age = nowyear - byr;
var nowmonth = today.getMonth();
var nowday = today.getDate();
var age_month = nowmonth - bmth;
var	age_day = nowday - bdy;
if (age < 18 )
{
alert ("We're sorry but thesite.com won't allow children under 18 years old to login.");
}
else if (age == 18 && age_month <= 0 && age_day <0)
{
alert ("We're sorry but thesite.com won't allow children under 18 years old to login.");
}


}

function showMessage() 
{
if (document.getElementById("dob").value != "") 
{
alert ("Invalid date format or impossible year/month/day of birth - please re-enter as YYYY-MM-DD");
document.getElementById("dob").value = "";
document.getElementById("dob").focus();
}
}

function daysInMonth(month,year) { // months are 1-12
var dd = new Date(year, month, 0);
return dd.getDate();
}

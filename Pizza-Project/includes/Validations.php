<?php
/*
*
*ANM 293 -- Advanced PHP: Group project
*Pizza order/delivery form
*
*@author Elizabeth Fredenburg
*@category Pizza Project Validations
*
*/

function FormValidate2($billingname,$billingaddress,$billingcity,$billingstate,$billingzip,$billingemail,
       $shippingname,$shippingaddress,$shippingcity,$shippingstate,$shippingzip,$shippingemail,$cctype,$cardnumber)
{
   $rslt = FALSE;
   if(($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])) )
   {
     $rslt = TRUE;
   } else {
     echo "Security code entered incorrectly. Please try again.";
   }
  if (!empty($billingname) && !empty($billingaddress) && !empty($billingcity) && !empty($billingstate) && 
   	  !empty($billingzip) && !empty($billingemail) && !empty($shippingname) && !empty($shippingaddress) && 
        !empty($shippingcity) && !empty($shippingstate) && !empty($shippingzip) && !empty($shippingemail) && 
        !empty($cctype) && !empty($cardnumber))
  {
	 $rslt = TRUE;
  } else {
	echo "Please fill in ALL required fields.";
  }
  return $rslt;
}

// function ValidateContact($name,$zip,$email,$phone)
// {
  // NameValidate($name);
  // ZipCodeValidate($zip);
  // EmailValidate($email);
  // USTelephoneValidate($phone);
// }

// function CheckPizzaSession()
// {
  // SessVarCheck('shippingname',"shipping name");
  // SessVarCheck('shippingaddress',"shipping address");
  // SessVarCheck('shippingcity',"shipping city");
  // SessVarCheck('shippingstate',"shipping state");
  // SessVarCheck('shippingzip',"shipping zip code");
  // SessVarCheck('shippingemail',"shipping email");
  // SessVarCheck('billingname',"billing name");
  // SessVarCheck('billingaddress',"billing address");
  // SessVarCheck('billingcity',"billing city");
  // SessVarCheck('billingstate',"billing state");
  // SessVarCheck('billingzip',"billing zip code");
  // SessVarCheck('billingemail',"billing email");
  // SessVarCheck('size',"pizza size");
  // SessVarCheck('crust',"crust type");
// }

function SessVarCheck($inputVar,$attName)
{
  if (!isset($_SESSION[$inputVar])){
	$_SESSION[$inputVar] = $_POST[$inputVar];
	echo "Please enter $attName /n";
  }
}

function MajorCreditCardValidate($card)
{
  $regexp = "/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/";
  if (preg_match($regexp, $card))
  {
    return;
  } else {
    echo "Credit card number is invalid.";
  }
}

function VisaCardValidate($card)
{
  $regexp = "/^4[0-9]{12}(?:[0-9]{3})?$/";
  if (preg_match($regexp, $card))
  {
    return;
  } else {
    echo "Visa card number is invalid.";
  }
}

function MastCardValidate($card)
{
  $regexp = "/^5[1-5][0-9]{14}$/";
  if (preg_match($regexp, $card))
  {
    return;
  } else {
    echo "Master card number is invalid.";
  }
}

function DiscCardValidate($card)
{
  $regexp = "/^6011[0-9]{12}$/";
  if (preg_match($regexp, $card))
  {
    return;
  } else {
    echo "Discover card number is invalid.";
  }
}

function DinersCardValidate($card)
{
  $regexp = "/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/";
  if (preg_match($regexp, $card))
  {
    return;
  } else {
    echo "Diners Club card number is invalid.";
  }
}

function AmerExprCardValidate($card)
{
  $regexp = "/^3[47][0-9]{13}$/";
  if (preg_match($regexp, $card))
  {
    return;
  } else {
    echo "American Express card number is invalid.";
  }
}

function USTelephoneValidate($phone)
{
  $regexp = "/^\D*([2-9]{1})([0-9]{2})\D*([0-9]{3})\D*([0-9]{4})$/";
  if (preg_match($regexp, $phone))
  {
    return;
  } else {
    echo "Telephone number is invalid.";
  }
}

function ZipCodeValidate($zip)
{
  $regexp = "/^([0-9]{5})(-[0-9]{4})?$/";
  if (preg_match($regexp, $zip))
  {
    return;
  } else {
    echo "Zip code is invalid.";
  }
}

function EmailValidate($email)
{
  $regexp = "/^[^0-9][A-Za-z0-9_]+([.][A-Za-z0-9_]+)*[@][A-Za-z0-9_]+([.][A-Za-z0-9_]+)*[.][A-Za-z]{2,4}$/";
  if (preg_match($regexp, $email))
  {
    return;
  } else {
    echo "Email address is invalid.";
  }
}

function NameValidate($name)
{
  $regexp = "/^[A-Za-z]+[-][A-Za-z]+$/";
  if (preg_match($regexp, $name))
  {
    return;
  } else {
    echo "Name contains invalid characters.";
  }
}
<?php 
   //session_start();
   $_SESSION['billingname'] = $_POST['billingname'];
  $_SESSION['billingaddress'] = $_POST['billingaddress'];
  $_SESSION['billingcity'] = $_POST['billingcity'];
  $_SESSION['billingstate'] = $_POST['billingstate'];
  $_SESSION['billingzip'] = $_POST['billingzip'];
  $_SESSION['billingemail'] = $_POST['billingemail'];
  $_SESSION['shippingname'] = $_POST['shippingname'];
  $_SESSION['shippingaddress'] = $_POST['shippingaddress'];
  $_SESSION['shippingcity'] = $_POST['shippingcity'];
  $_SESSION['shippingstate'] = $_POST['shippingstate'];
  $_SESSION['shippingzip'] = $_POST['shippingzip'];
  $_SESSION['shippingemail'] = $_POST['shippingemail'];
  $_SESSION['size'] = $_POST['size'];
  $_SESSION['crust'] = $_POST['crust'];
  $_SESSION['cctype'] = $_POST['cctype'];
  $_SESSION['cardNumber'] = $_POST['cardNumber'];
  
  $billingname = $_POST['billingname'];
  $billingaddress = $_POST['billingaddress'];
  $billingcity = $_POST['billingcity'];
  $billingstate = $_POST['billingstate'];
  $billingzip = $_POST['billingzip'];
  $billingemail = $_POST['billingemail'];
  $shippingname = $_POST['shippingname'];
  $shippingaddress = $_POST['shippingaddress'];
  $shippingcity = $_POST['shippingcity'];
  $shippingstate = $_POST['shippingstate'];
  $shippingzip = $_POST['shippingzip'];
  $shippingemail = $_POST['shippingemail'];
  $totalPrice = $_POST['totalPrice'];
  $cctype = $_POST['cctype'];
  $cardnumber = $_POST['cardNumber'];
  
   if(($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])) ) {
      // Insert you code for processing the form here, e.g emailing the submission, entering it into a database.
      include 'includes/ini.php';
	  $size = $_SESSION['size'];
      switch($size)
      {
        case "10.00":
          $size="Small";
          break;

        case "12.00":
          $size="Medium";
          break;

        case "14.00":
          $size="Large";
          break;

        default: // By default the 4th selection is selected
          $size="Small";
          break;
      }
	  $crust = $_SESSION['crust'];
	  $toppings = $_POST["topping"];
	  if(empty($toppings))
	    {
		  $alltops = "None";
		}
		else
		  {
			$alltops = implode(", ",$toppings);
		  }
      $totalPrice = $_POST['totalPrice'];
	  if (!$totalPrice)
	  {
	  	$numToppings = $_POST['topping'];
	    $toppingPrice = count($numToppings) * 0.75;
	    $totalPrice = ($toppingPrice + $_SESSION['size']) * 1.06;
	  }

	  echo("Thank you, " . $billingname . ", for your order.<br />");
	  echo("You have ordered a " . $size . " " . $crust . " pizza, with the following toppings:<br />");
	  echo $alltops . "<br /><br />";
	  echo("Your total is: $" . $totalPrice . " (Includes tax and deliver)<br /><br />");
	  
	  $emailString = "Thank you, " . $billingname . ", for your order.<br />Your " . $size . " " . $crust . " pizza with " . $alltops . " will be delivered as soon as possible.<br />Your total: $" . $totalPrice . " (Including Tax)";
	  
	  try {
     // forces the include of the swift_required.php file
     @(include_once('library/lib/swift_required.php'));
  
     // builds a new instance of transport from the swift mailer library
     $transport = Swift_SmtpTransport::newInstance()
       ->setHost('smtp.gmail.com')
       ->setPort(465)
       ->setEncryption('ssl')
       ->setUsername('kevinsieling@gmail.com')
       ->setPassword('gmail454');
  
     // builds a new instance of mailer from the library using the transport
     $mailer = Swift_Mailer::newInstance($transport);
  
     // builds a new instance of a message
     $message = Swift_Message::newInstance()
       ->setSubject('Your Pizza Order')
       ->setFrom(array('kevinsieling@gmail.com' => 'Kevin Sieling'))
       ->setTo($billingemail)
       ->setBody($emailString, 'text/html')
       ->setReplyTo('kevinsieling@gmail.com')
       ;
    
     //  $header->addTextHeader('ANM293', 'CNM-270');
  
     // sends the message
     $numSent = $mailer->send($message);
  
     } catch(Exception $e) {

     trigger_error('Send message error',E_USER_NOTICE);
  
     }
	 
	 // displays Sent if the message was sent, Failed if it was not sent
     if (!$numSent) {
       echo "We tried to send an email, but it failed.";
     }
     else {
       echo "An email was sent to " . $billingemail . " to confirm your order.<br /><br />";
     }

     try {
       $dbh = new PDO('sqlite:database/pizzadatabase.db');
	   
	   $dbh->exec('CREATE TABLE pizzaOrders (Id INTEGER PRIMARY KEY, billingname CHAR(30), billingaddress CHAR(30), billingcity CHAR(30), billingstate CHAR(30), billingzip CHAR(30), billingemail CHAR(30), price CHAR(30), cardtype CHAR(30))');
	   
	   $dbh->exec("INSERT INTO pizzaOrders (billingname, billingaddress, billingcity, billingstate, billingzip, billingemail, price, cardtype) VALUES ('$billingname', '$billingaddress', '$billingcity', '$billingstate', '$billingzip', '$billingemail', '$totalPrice', '$cctype')");
	   
	   //now output the data to a simple html table...
       print "<table border=1>";
       print "<tr><td>Id</td><td>Name</td><td>Address</td><td>City</td><td>State</td><td>Zip</td><td>Email</td><td>Price</td><td>Card</td></tr>";
      $result = $dbh->query('SELECT * FROM pizzaOrders');
      foreach($result as $row)
      {
        print "<tr><td>".$row['Id']."</td>";
        print "<td>".$row['billingname']."</td>";
        print "<td>".$row['billingaddress']."</td>";
        print "<td>".$row['billingcity']."</td>";
        print "<td>".$row['billingstate']."</td>";
        print "<td>".$row['billingzip']."</td>";
        print "<td>".$row['billingemail']."</td>";
        print "<td>".$row['price']."</td>";
        print "<td>".$row['cardtype']."</td></tr>";
      }
      print "</table>";
	   
	   $dbh = NULL;
	 }
	 catch(PDOException $e) {
		 echo($e->getMessage());
	 }
      unset($_SESSION['security_code']);
   } else {
      // Insert your code for showing an error message here
	  echo("Your captcha answer was incorrect, please try again.<br />");
	  echo("<a href='index.php'>Return</a> to the form.");
   }
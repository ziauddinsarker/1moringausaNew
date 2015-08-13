<?php 
$your_email ='moringapills@gmail.com';// <<=== update to your email address

session_start();
$errors = '';
$fullname = '';
$streetaddress = '';
$streetaddress2 = '';

$city = '';
$state = '';
$zipcode = '';
$visitor_email = '';


if(isset($_POST['submit']))
{
	
	$fullname = $_POST['fullname'];
	$streetaddress = $_POST['streetaddress'];
	$streetaddress2 = $_POST['streetaddress2'];
	
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zipcode = $_POST['zipcode'];

	$visitor_email = $_POST['email'];


	///------------Do Validations-------------
	if(empty($fullname)||empty($visitor_email))
	{
		$errors .= " Name and Email are required fields.\n ";	
	}
	if(IsInjected($visitor_email))
	{
		$errors .= "\n Bad email value!";
	}
	if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$errors .= "The captcha code does not match!";
	}
	
	if(empty($errors))
	{
		//send the email
		$to = $your_email;
		$subject="New form submission";
		$from = $your_email;
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		
		$body = 
		
		"$fullname\n".
		"$streetaddress\n".
		"$streetaddress2\n".
		"$city $state $zipcode\n".
		"$visitor_email \n";	
		
		$headers = "From: $from \r\n";
		$headers .= "Reply-To: $visitor_email \r\n";
		
		mail($to, $subject, $body,$headers);
		
		header('Location: thank-you.html');
	}
}

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>

					<div id="contact">
							<?php
							if(!empty($errors)){
							echo "<div class='err'>".nl2br($errors)."</div>";
							}
							?>
							<div id='contact_form_errorloc'></div>

							<form method="POST" name="contact_form" id="contactform"
							action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"> 
		
							
							<div class="clear"></div>
							<p><label for="fullname"><span class="required">*</span>Contact Name</label>
							<input type="text" name="fullname" value='<?php echo htmlentities($fulname) ?>'></p>

							<p><label for="streetaddress"><span class="required"></span>Street Address</label>
							<input type="text" name="streetaddress" value='<?php echo htmlentities($streetaddress) ?>'></p>

							<p><label for="streetaddress2"><span class="required"></span>Street Address 2</label>
							<input type="text" name="streetaddress2" value='<?php echo htmlentities($streetaddress2) ?>'></p>

							

							<p><label for="city"><span class="required"></span> Town/City</label>
							<input type="text" name="city" value='<?php echo htmlentities($city) ?>'></p>

							<p><label for="state"><span class="required"></span>State</label>
							  <select name="state"><option></option>
          <option value="AL">AL</option>
          <option value="AK">AK</option>
          <option value="AZ">AZ</option>
          <option value="AR">AR</option>
          <option value="CA">CA</option>
          <option value="CO">CO</option>
          <option value="CT">CT</option>
          <option value="DE">DE</option>
          <option value="FL">FL</option>
          <option value="GA">GA</option>
          <option value="HI">HI</option>
          <option value="ID">ID</option>
          <option value="IL">IL</option>
          <option value="IN">IN</option>
          <option value="IA">IA</option>
          <option value="KS">KS</option>
          <option value="KY">KY</option>
          <option value="LA">LA</option>
          <option value="ME">ME</option>
          <option value="MD">MD</option>
          <option value="MA">MA</option>
          <option value="MI">MI</option>
          <option value="MN">MN</option>
          <option value="MS">MS</option>
          <option value="MO">MO</option>
          <option value="MT">MT</option>
          <option value="NE">NE</option>
          <option value="NV">NV</option>
          <option value="NH">NH</option>
          <option value="NJ">NJ</option>
          <option value="NM">NM</option>
          <option value="NY">NY</option>
          <option value="NC">NC</option>
          <option value="ND">ND</option>
          <option value="OH">OH</option>
          <option value="OK">OK</option>
          <option value="OR">OR</option>
          <option value="PA">PA</option>
          <option value="RI">RI</option>
          <option value="SC">SC</option>
          <option value="SD">SD</option>
          <option value="TN">TN</option>
          <option value="TX">TX</option>
          <option value="UT">UT</option>
          <option value="VT">VT</option>
          <option value="VA">VA</option>
          <option value="WA">WA</option>
          <option value="WV">WV</option>
          <option value="WI">WI</option>
          <option value="WY">WY</option>
         </select></p>

							<p><label for="zipcode"><span class="required"></span>Zipcode</label>
							<input type="text" name="zipcode" value='<?php echo htmlentities($zipcode) ?>'></p>

						

							<p><label for="email"><span class="required">*</span> Email</label>
							<input type="text" name="email" value='<?php echo htmlentities($visitor_email) ?>'></p>

					

							<div class="clear"></div>
							<p>
							<img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><br>
							<label for='message'><span class="required">*</span>Enter the code above here :</label>
							<input id="6_letters_code" name="6_letters_code" type="text"><br>
							<small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small>
							</p>

							<div class="clear"></div>
							<p>Send me my Free Samples please! <input type="button" class="submit" value="Button" name='Button' />
							</p>
						</form>
					</div>
	


<script language="JavaScript">
var frmvalidator  = new Validator("contact_form");
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();


frmvalidator.addValidation("fullname","req","Please provide your first name"); 
frmvalidator.addValidation("streetaddress","req","Please provide your Street Address"); 
frmvalidator.addValidation("streetaddress2","req","Please provide your Street Address 2"); 

frmvalidator.addValidation("city","req","Please provide your City"); 
frmvalidator.addValidation("state","req","Please provide your State"); 
frmvalidator.addValidation("zipcode","req","Please provide your zipcode"); 

frmvalidator.addValidation("tel","req","Please provide your Telephone Number"); 
frmvalidator.addValidation("email","req","Please provide your email"); 
frmvalidator.addValidation("email","email","Please enter a valid email address"); 
</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</body>
</html>
  

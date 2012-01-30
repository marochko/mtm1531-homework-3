<?php

	$choices_lang = array (
		'english' => 'English',
		'french' => 'Francais',
		'spanish' => 'Espagnol'
	);

	$errors = array();
	$display_thanks = false;

	$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$preferredlang = filter_input(INPUT_POST, 'preferredlang', FILTER_SANITIZE_STRING);
	$notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
	$acceptterms = filter_input(INPUT_POST, 'acceptterms', FILTER_SANITIZE_STRING);
	

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (empty($name)) {
			$errors['name'] = true;
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = true;	
		}

		if (mb_strlen($username) > 25) {
			$errors['username'] = true;		
		}

		if (empty($password)) {
			$errors['password'] = true ;	
		}

		if (!array_key_exists($preferredlang, $choices_lang)) {
			$errors['preferredlang'] = true;	
		}

		if ($acceptterms == 'unchecked') {
			$errors['acceptterms'] = true;	
		}
		
		if (empty($acceptterms)) {
			$errors['acceptterms'] = true;
		}
		
		if (empty($errors)) {
			$display_thanks = true;
		$email_message = 'Name: ' . $name . "\r\n"; 
		$email_message .= 'Username: ' . $username . "\r\n";
		$email_message .= 'Message: ' . $notes . "\r\n";
		
		$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
		// $headers = 'Fron: Amanda <amanda.marochko@gmail.com>' "\r\n";
		
			
			mail('amanda.marochko@gmail.com', $subject, $message);
			//mail($email, 'Thanks for registering')
		}
	}
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Registration Form Validation</title>
	<link href="css/general.css" rel="stylesheet">
</head>

<body>
	


	<?php if ($display_thanks): ?>
    	<strong>Thanks!</strong>
    <?php else: ?>
    
	<form method="post" action="index.php">
		<div>
			<label for="name">Name</label>
			<input type="name" id="name" name="name" value="<?php echo $name; ?>" required><?php if (isset($errors['name'])) : ?> <strong>Please enter a name</strong><?php endif; ?>
		</div>
		<div>
			<label for="email">Email</label>
			<input type="email" id="email" name="email" value="<?php echo $email; ?>" required><?php if (isset($errors['email'])) : ?> <strong>Please enter an e-mail address</strong><?php endif; ?>
		</div>
		<div>
			<label for="username">Username</label>
			<input type="text" id="username" name="username" value="<?php echo $username; ?>" required><?php if (isset($errors['username'])) : ?> <strong>Please enter a username that is less than 25 characters</strong><?php endif; ?>
		</div>
		<div>
			<label for="password">Password</label>
			<input type="password" id="password" name="password" value="<?php echo $password; ?>" required><?php if (isset($errors['password'])) : ?> <strong>Please enter a password</strong><?php endif; ?>
		</div>
		<div>
			<fieldset>
				<legend>Preferred Language</legend><?php if (isset($errors['lang'])) : ?> <strong> Please choose a language</strong><?php endif; ?>
			<?php foreach($choices_lang as $key => $value) : ?>
				<input type="radio" id="<?php echo $key; ?>" name="preferredlang" value="<?php echo $key; ?>"<?php if ($key == $preferredlang) { echo ' checked'; } ?> required>
				<label for="<?php echo $key; ?>"><?php echo $value; ?></label>
			<?php endforeach; ?>
			</fieldset>
		</div>
		<div>
			<label for="notes">Notes</label>
			<textarea id="notes" name="notes"><?php echo $notes; ?></textarea>
		</div>
		<div>
			<fieldset>
				<input type="checkbox" id="acceptterms" name="acceptterms" required>
				<label for="acceptterms">Accept the Terms of Agreement</label><?php if (isset($errors['acceptterms'])): ?> <strong>Please accept the Terms of Agreement to continue</strong><?php endif; ?>
			</fieldset>
		</div>
		<div>
			<button type="submit" name="submit">Submit Form</button>
		</div>
	</form>
 <?php endif; ?>
 

</body>
</html>
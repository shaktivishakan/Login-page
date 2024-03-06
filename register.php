<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ad7171;
    }
    .container {
      max-width: 400px;
      margin: 100px auto; /* Adjusted margin to center the container vertically */
      padding: 30px;
      background-color: #39bbb4;
      border-radius: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 50px;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 3px solid #a575dd;
      border-radius: 10px;
      box-sizing: border-box; /* Changed to border-box for consistent sizing */
    }
    input[type="submit"] {
      width: 45%; /* Adjusted width to fill the container */
      padding: 10px; /* Increased padding for better appearance */
      background-color: #548fe7;
      color: #fff;
      font-size: 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      display: block; /* Change the display property to block */
      margin: 20px auto 0; /* Center the button horizontally and add some top margin */
    }
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
    .error {
      color: #ff0808;
      font-size: 1em;
    }
    #registrationImage {
      display: block;
      margin: 0 auto;
      margin-bottom: 20px;
      border-radius: 50%; /* Apply border-radius to make the image circular */
      overflow: hidden; /* Hide overflow to ensure the circular shape */
    }
    #registrationImage img {
      width: 100%; /* Ensure the image fills the circular container */
      height: auto; /* Maintain aspect ratio */
    }
    .password-toggle {
      position: relative;
    }
    .password-toggle i {
      position: absolute;
      right: -22px; /* Adjusted position to move the icon a little to the right */
      top: 40%;
      transform: translateY(-50%);
      cursor: pointer;
    }
    .password-toggle i:hover {
      color: #548fe7;
    }
  </style>
</head>
<body>
<?php

$host = 'localhost';
$dbname = 'register';
$username = 'root';
$password = '';

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // If connection fails, display an error message
    echo "Connection failed: " . $e->getMessage();
}

if(isset($_POST["submit"])) {
    $fullName = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];
    
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();

    if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }
    if ($password !== $passwordRepeat) {
        array_push($errors, "Password does not match");
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(array(':email' => $email));
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
        array_push($errors, "Email already exists!");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (:full_name, :email, :password)");
        $stmt->execute(array(':full_name' => $fullName, ':email' => $email, ':password' => $passwordHash));
        echo "<div class='alert alert-success'>You are registered successfully.</div>";
    }
}

?>

  <div class="container">
    <h2>Registration</h2>
    <img src="./images/Untitled.png" alt="" id="registrationImage">
    <form id="registrationForm" action="register.php" method="post" onsubmit="return validateForm()">
      <input type="text" name="fullname" id="name" placeholder="Name">

      <div id="nameError"  class="error"></div>

      <input type="email" name="email" id="email" placeholder="Email">

      <div id="emailError" class="error"></div>

      <input type="password" name="password" id="password" placeholder="Password">

      <div id="passwordError" class="error"></div>

      <div class="password-toggle">

        <input type="password" name="repeat_password" id="confirmPassword" placeholder="Confirm Password">

        <i class="far fa-eye-slash" onclick="toggleConfirmPasswordVisibility()"></i> <!-- Font Awesome eye icon -->
      </div> 

      <div id="confirmPasswordError" class="error"></div>
      <input type="submit" value="Register" name="submit">
    </form>
  </div>

  <script>
    function validateForm() {
      var name = document.getElementById("name").value.trim();
      var email = document.getElementById("email").value.trim();
      var password = document.getElementById("password").value.trim();
      var confirmPassword = document.getElementById("confirmPassword").value.trim();

      var nameError = document.getElementById("nameError");
      var emailError = document.getElementById("emailError");
      var passwordError = document.getElementById("passwordError");
      var confirmPasswordError = document.getElementById("confirmPasswordError");

      nameError.textContent = "";
      emailError.textContent = "";
      passwordError.textContent = "";
      confirmPasswordError.textContent = "";

      if (name === "") {
        nameError.textContent = "Name is required";
        return false;
      }

      if (email === "") {
        emailError.textContent = "Email is required";
        return false;
      }

      if (!validateEmail(email)) {
        emailError.textContent = "Invalid email address";
        return false;
      }

      if (password === "") {
        passwordError.textContent = "Password is required";
        return false;
      }

      if (password.length < 6) {
        passwordError.textContent = "Password should be at least 6 characters long";
        return false;
      }

      if (confirmPassword === "") {
        confirmPasswordError.textContent = "Please confirm your password";
        return false;
      }

      if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match";
        return false;
      }

      return true;
    }

    function validateEmail(email) {
      var re = /\S+@\S+\.\S+/;
      return re.test(email);
    }

    function toggleConfirmPasswordVisibility() {
      var confirmPasswordInput = document.getElementById("confirmPassword");
      var eyeIcon = document.querySelector(".password-toggle i");

      if (confirmPasswordInput.type === "password") {
        confirmPasswordInput.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
      } else {
        confirmPasswordInput.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
      }
    }
  </script>
</body>
</html>

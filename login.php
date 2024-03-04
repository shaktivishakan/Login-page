
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: italic, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ad7171;
    }
    .container {
      max-width: 400px;
      margin: 100px auto; /* Adjusted margin to center the container */
      padding: 30px;
      background-color: #39bbb4;
      border-radius: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      text-align: center; /* Center the content */
    }
    h2 {
      margin-bottom: 50px;
    }
    input[type="email"],
    input[type="password"] {
      width: calc(100% - 30px); /* Adjusted width */
      padding: 10px;
      margin-bottom: 15px;
      border: 3px solid #a575dd;
      border-radius: 10px;
      box-sizing: border-box; /* Use border-box to include padding and border in the width calculation */
    }
    .password-toggle {
      position: relative;
    }
    .password-toggle i {
      position: absolute;
      right: -5px; /* Adjusted position */
      top: 69%;
      transform: translateY(-50%);
      cursor: pointer;
    }
    .password-toggle i:hover {
      color: #e42f2f;
    }
    .register-link {
      margin-top: 20px; /* Adjusted margin */
    }
    .register-link a {
      color: #ffef08;
      text-decoration: none;
    }
    .register-link a:hover {
      text-decoration: underline;
      color: rgb(219, 14, 158);
    }
    #loginImage {
      margin-top: 20px; /* Adjusted margin */
      width: 100px; /* Adjusted width */
      height: 100px; /* Adjusted height */
      border-radius: 50%; /* Make the image circular */
      display: block; /* Ensure the image is block-level */
      margin: 0 auto 20px; /* Center the image horizontally and add bottom margin */
    }
    input[type="submit"] {
      width: 45%; /* Make the button full-width */
      padding: 10px; /* Increase padding for a bigger button */
      background-color: #548fe7;
      color: #fff;
      font-size: 22px; /* Increase font size */
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .error-message {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    

  <?php
session_start();
if (isset($_SESSION["users"])) {
   header("Location: index.php");
   exit(); // Terminate script execution after redirect
}

if (isset($_POST["login"])) {
   $email = $_POST["email"];
   $password = $_POST["password"];
   require_once "database.php";
   $sql = "SELECT * FROM users WHERE email = '$email'";
   $result = mysqli_query($conn, $sql);

   if (!$result) {
       die("Query failed: " . mysqli_error($conn)); // Check if the query fails
   }

   $user = mysqli_fetch_assoc($result); // Use mysqli_fetch_assoc instead of mysqli_fetch_array with MYSQLI_ASSOC
   if ($user) {
       if (password_verify($password, $user["password"])) {
           $_SESSION["user"] = $user; // Store the user data in session instead of just a string
           header("Location: user.php");
           exit(); // Terminate script execution after redirect
       } else {
           echo "<div class='alert alert-danger'>Password does not match</div>";
       }
   } else {
       echo "<div class='alert alert-danger'>Email does not match</div>";
   }
}
?>



    <h2>Login</h2>
    <img src="./images/Untitled.png" alt="Login Image" id="loginImage">
    <form id="loginForm" action="login.php" method="post" onsubmit="return validateForm()"> <!-- Changed action to user.html -->
      <div class="password-toggle">
        <input type="email" id="email" name = "email" placeholder="Email">
        <input type="password" id="password" name = "password" placeholder="Password" style="width: calc(100% - 40px); margin-bottom: 15px;"> <!-- Adjusted width -->
        <i class="far fa-eye-slash" onclick="togglePasswordVisibility()"></i>
      </div>
      <input type="submit" name = "login" value="Login">
      <div class="error-message" id="errorMessage"></div>
    </form>
    <div class="register-link">
      Don't have an account? <a href="register.html">Register here</a>.
    </div>
  </div>

  <script>
    function validateForm() {
      var email = document.getElementById("email").value.trim();
      var password = document.getElementById("password").value.trim();
      var errorMessage = document.getElementById("errorMessage");

      errorMessage.textContent = ""; // Clear previous error message

      if (email === "" || password === "") {
        errorMessage.textContent = "Email and password are required";
        return false;
      }

      // You can add your login validation logic here
      // For example, if login fails, display an error message
      if (email !== $email || password !== $password) {
        errorMessage.textContent = "Email or password doesn't match";
        return false;
      }

      return true;
    }

    function togglePasswordVisibility() {
      var passwordInput = document.getElementById("password");
      var eyeIcon = document.querySelector(".password-toggle i");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
      }
      passwordInput.focus(); // Ensure focus remains on the password input field after toggling visibility
    }
  </script>
</body>
</html>

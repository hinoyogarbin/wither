
<?php
session_start();
include '../config/config.php'; // adjust path to your config.php

// If user is already logged in, send to dashboard
if(isset($_SESSION['user_id'])){
    header("Location: ../dashboard/dashboard.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['email'], $_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                header("Location: ../dashboard/dashboard.php"); // go to dashboard after login
                exit;
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "Email not found";
        }
        } else {
    header("Location: ../auth/login.php"); // redirect if accessed directly
    exit;
}
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Wither - Authentication</title>

<style>
 
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #f5f7fa;
}

 
.auth-container {
  width: 400px;
  background: #ffffff;
  padding: 30px 25px;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
}

 
.logo {
  font-size: 35px;
  font-weight: 600;
  text-align: center;
  margin-bottom: 25px;
  color: #333;
}

.logo span {
  color: #4CAF50;
}
 
.form {
  display: none;
  animation: fadeIn 0.3s ease;
}

.form.active {
  display: block;
}

input {
  width: 100%;
  padding: 12px 15px;
  margin: 10px 0;
  border: 1px solid #dcdcdc;
  border-radius: 8px;
  font-size: 14px;
  transition: border 0.3s;
}

input:focus {
  outline: none;
  border-color: #4CAF50;
  box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
}

button.submit {
  width: 100%;
  padding: 12px;
  background: #4CAF50;
  border: none;
  color: white;
  font-size: 16px;
  font-weight: 600;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}

button.submit:hover {
  background: #43a047;
}

 
.switch-link {
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
  color: #4CAF50;
  cursor: pointer;
  text-decoration: underline;
}

 
.footer {
  text-align: center;
  font-size: 12px;
  margin-top: 20px;
  color: #999;
}

 
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
</head>

<body>

<div class="auth-container">

  <div class="logo">
    Wit<span>her</span>
  </div>

  <!-- LOGIN FORM -->
  <form id="login" class="form active" action="../auth/login.php" method="POST">
    <input type="email" placeholder="Email" name="email" required>
    <input type="password" placeholder="Password" name="password" required>
    <button class="submit" type="submit">Login</button>
    <div class="switch-link" onclick="showForm('register')">Create Account</div>
  </form>

  <!-- REGISTER FORM -->
  <form id="register" class="form" action="../auth/register.php" method="POST">
    <input type="text" placeholder="Full Name" name="fullname" required>
    <input type="email" placeholder="Email" name="email" required>
    <input type="text" placeholder="Username" name="username" required>
    <input type="password" placeholder="Password" name="password" required>
    <button class="submit" type="submit">Create Account</button>
    <div class="switch-link" onclick="showForm('login')">Back to Login</div>
  </form>

  <div class="footer">
    NBSC Micro Climate
  </div>

</div>

<script>
function showForm(type) {
  document.getElementById("login").classList.remove("active");
  document.getElementById("register").classList.remove("active");

  document.getElementById(type).classList.add("active");
}
</script>

</body>
</html>
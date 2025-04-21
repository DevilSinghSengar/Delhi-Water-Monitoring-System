<?php
$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './db/config.php';
    $username = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = $user['is_admin']; 
        header("location: index.php");
        exit();
    } else {
        $showError = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="index.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class'
    };
  </script>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      background: linear-gradient(to right, #667eea, #764ba2);
      animation: gradient 10s ease infinite;
      background-size: 400% 400%;
    }

    @keyframes gradient {
      0% { background-position: 0% 50% }
      50% { background-position: 100% 50% }
      100% { background-position: 0% 50% }
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center">

  <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl transition transform hover:scale-[1.01] duration-300">
    <div class="flex justify-center mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.656 0 3-1.344 3-3S13.656 5 12 5s-3 1.344-3 3 1.344 3 3 3zm0 2c-2.67 0-8 1.336-8 4v2h16v-2c0-2.664-5.33-4-8-4z" />
      </svg>
    </div>

    <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">Login to Your Account</h2>

    <?php if ($login): ?>
      <div class="mb-4 text-green-700 bg-green-100 border border-green-400 p-3 rounded text-sm">
        ✅ You are logged in!
      </div>
    <?php elseif ($showError): ?>
      <div class="mb-4 text-red-700 bg-red-100 border border-red-400 p-3 rounded text-sm">
        ❌ Error: <?= $showError ?>
      </div>
    <?php endif; ?>

    <form action="/Programs/Project/login.php" method="post" class="space-y-5" onsubmit="return showLoader()">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Username</label>
        <input type="text" id="email" name="email" required
          class="mt-1 block w-full px-4 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-yellow-400" />
      </div>

      <div class="relative">
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
        <input type="password" id="password" name="password" required
          class="mt-1 block w-full px-4 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-yellow-400" />
        <button type="button" onclick="togglePassword()" class="absolute right-3 bottom-2.5 text-gray-500 dark:text-gray-300 hover:text-gray-800">
        <i class="fa-solid fa-eye"></i>
        </button>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
          <input type="checkbox" class="mr-2" name="remember" />
          Remember Me
        </label>
        <a href="#" class="text-sm text-indigo-600 dark:text-yellow-400 hover:underline">Forgot Password?</a>
      </div>

      <div>
        <button id="loginBtn" type="submit"
          class="w-full bg-indigo-600 dark:bg-yellow-500 text-white py-2 rounded-md hover:bg-indigo-700 dark:hover:bg-yellow-600 shadow-lg hover:shadow-xl transform hover:scale-105 transition flex justify-center items-center">
          <svg id="spinner" class="hidden animate-spin h-5 w-5 mr-2 text-white" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8z"></path>
          </svg>
          Log In
        </button>
      </div>

      <div class="flex items-center justify-center my-4">
        <div class="border-t border-gray-300 dark:border-gray-600 w-1/3"></div>
        <span class="mx-2 text-gray-500 dark:text-gray-300 text-sm">or</span>
        <div class="border-t border-gray-300 dark:border-gray-600 w-1/3"></div>
      </div>

      <div>
        <button type="button" onclick="alert('Google Login not implemented 😅')"
          class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-700 dark:text-white dark:bg-gray-700 dark:border-gray-600 rounded-md py-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
          <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="h-5 w-5" alt="Google" />
          Login with Google
        </button>
      </div>

      <div class="text-center">
        <p class="text-sm text-gray-700 dark:text-gray-300 mt-4">
          Don’t have an account?
          <a href="/Programs/Project/signup.php" class="text-indigo-600 dark:text-yellow-400 font-medium hover:underline">
            Sign Up
          </a>
        </p>
      </div>
    </form>
  </div>

  <script>
   function togglePassword() {
    const input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
  }

  
  </script>

</body>
</html>

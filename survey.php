<?php 
  session_start();
  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: login.php");
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Water Body Survey</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
</head>
<body class="bg-blue-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-500 bg-cover bg-center" style="background-image: url('https://cdn.pixabay.com/photo/2020/01/28/04/28/sunrise-4798911_640.jpg'); filter: brightness(1.2);">

  <!-- Mobile Navbar -->
  <div id="mobileSidebar" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden sm:hidden">
  <div class="absolute left-0 top-0 w-64 h-full bg-gray-800 p-6 space-y-4 shadow-lg transform transition-transform duration-300 translate-x-0">
    <button onclick="toggleSidebar()" class="text-white text-xl absolute top-4 right-4">
      <i class="fas fa-times"></i>
    </button>
    <a href="index.php" class="block text-white text-lg hover:text-blue-400">Home</a>
    <a href="index.php #monitoring" class="block text-white text-lg hover:text-blue-400">Monitoring</a>
    <a href="survey.php" class="block text-white text-lg hover:text-blue-400">Survey</a>
    <a href="contact.php" class="block text-white text-lg hover:text-blue-400">Contact</a>
    <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
      <a href="admin.php" class="block text-white text-lg hover:text-blue-400">Admin</a>
    <?php endif; ?>
    
    <div class="mt-4 space-y-2 border-t border-gray-700 pt-4">
      <div class="text-gray-300 font-semibold flex items-center gap-2">
        <i class="fa-solid fa-user text-lg"></i>
        <span><?= htmlspecialchars($_SESSION['username']); ?></span>
      </div>
      <a href="logout.php" class="block text-red-400 hover:text-red-500 transition">Logout</a>
    </div>
  </div>
</div>
<!-- Navbar -->
<header class="bg-gray-800 shadow-md">
  <div class="max-w-6xl mx-auto p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-300">💧 Delhi Water Watch</h1>
    
    <!-- Hamburger for Mobile -->
    <button id="menuToggle" class="sm:hidden text-2xl text-blue-300 focus:outline-none" onclick="toggleSidebar()">☰</button>

    <!-- Desktop Navbar -->
    <nav id="navbar" class="hidden sm:flex flex-col sm:flex-row sm:space-x-4 sm:items-center w-full sm:w-auto mt-4 sm:mt-0">
      <a href="index.php" class="hover:text-blue-400 font-medium transition block sm:inline">Home</a>
      <a href="index.php #monitoring" class="hover:text-blue-400 font-medium transition block sm:inline">Monitoring</a>
      <a href="survey.php" class="hover:text-blue-400 text-blue-300 transition block sm:inline">Survey</a>
      <a href="contact.php" class="text-white font-medium transition block sm:inline">Contact</a>
      <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <a href="admin.php" class="hover:text-blue-400 font-medium transition block sm:inline">Admin</a>
      <?php endif; ?>

      <!-- User Menu -->
      <div class="relative inline-block text-left block sm:inline ml-2" onclick="document.getElementById('userMenu').classList.toggle('hidden')">
        <button class="inline-flex justify-center items-center w-full rounded-full px-4 py-2 bg-gray-700 text-md font-medium text-gray-200 hover:bg-gray-600 transition">
          <i class="fa-solid fa-user mr-2"></i> <?= htmlspecialchars($_SESSION['username']); ?>
        </button>
        <div id="userMenu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-700 ring-1 ring-black ring-opacity-5 hidden z-50">
          <div class="py-1">
            <a href="logout.php" class="block px-4 py-2 text-sm text-red-400 hover:bg-red-800 transition">Logout</a>
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>

  <!-- Survey Form -->
  <main class="max-w-4xl mx-auto mt-10 mb-16 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl p-6 sm:p-10 border border-blue-100 dark:border-gray-700">
      <h2 class="text-3xl sm:text-4xl font-bold text-blue-900 dark:text-blue-300 mb-8 text-center"><i class="fa-solid fa-file"></i> Water Body Survey Form</h2>
      <form action="submit_survey.php" method="POST" class="space-y-8 sm:space-y-10">

        <!-- Location -->
        <div class="bg-blue-50 dark:bg-gray-700 rounded-xl p-4 sm:p-6 shadow-md border border-blue-200 dark:border-gray-600">
          <h3 class="text-base sm:text-lg font-semibold text-blue-700 dark:text-blue-300 mb-3"><i class="fa-solid fa-location-dot"></i> Choose the Water Body Location</h3>
          <select name="location" required class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-200">
            <option value="">-- Select a location --</option>
            <option value="Yamuna River">Yamuna River</option>
            <option value="Sanjay Lake">Sanjay Lake</option>
            <option value="Najafgarh Drain">Najafgarh Drain</option>
          </select>
        </div>

        <!-- Water Color -->
        <div class="bg-blue-50 dark:bg-gray-700 rounded-xl p-4 sm:p-6 shadow-md border border-blue-200 dark:border-gray-600">
          <h3 class="text-base sm:text-lg font-semibold text-blue-700 dark:text-blue-300 mb-3"><i class="fa-solid fa-droplet"></i> What is the Water Color?</h3>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <label class="flex items-center space-x-2">
              <input type="radio" name="color" value="Clear" required class="accent-blue-600">
              <span>Clear</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="color" value="Greenish" class="accent-blue-600">
              <span>Greenish</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="color" value="Brownish" class="accent-blue-600">
              <span>Brownish</span>
            </label>
          </div>
        </div>

        <!-- Odor -->
        <div class="bg-blue-50 dark:bg-gray-700 rounded-xl p-4 sm:p-6 shadow-md border border-blue-200 dark:border-gray-600">
          <h3 class="text-base sm:text-lg font-semibold text-blue-700 dark:text-blue-300 mb-3"><i class="fa-solid fa-holly-berry"></i> Is there any Odor?</h3>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <label class="flex items-center space-x-2">
              <input type="radio" name="odor" value="No Odor" required class="accent-blue-600">
              <span>No Odor</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="odor" value="Mild Odor" class="accent-blue-600">
              <span>Mild Odor</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="radio" name="odor" value="Strong Odor" class="accent-blue-600">
              <span>Strong Odor</span>
            </label>
          </div>
        </div>

        <!-- Waste -->
        <div class="bg-blue-50 dark:bg-gray-700 rounded-xl p-4 sm:p-6 shadow-md border border-blue-200 dark:border-gray-600">
          <h3 class="text-base sm:text-lg font-semibold text-blue-700 dark:text-blue-300 mb-3"><i class="fa-solid fa-recycle"></i> Visible Waste</h3>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="waste[]" value="Plastic" class="accent-blue-600">
              <span>Plastic</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="waste[]" value="Foam" class="accent-blue-600">
              <span>Foam</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="waste[]" value="Dead Fish" class="accent-blue-600">
              <span>Dead Fish</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="waste[]" value="None" class="accent-blue-600">
              <span>None</span>
            </label>
          </div>
        </div>

        <!-- Comments -->
        <div class="bg-blue-50 dark:bg-gray-700 rounded-xl p-4 sm:p-6 shadow-md border border-blue-200 dark:border-gray-600">
          <h3 class="text-base sm:text-lg font-semibold text-blue-700 dark:text-blue-300 mb-3"><i class="fa-solid fa-file-lines"></i> Any Additional Comments?</h3>
          <textarea name="comments" rows="4" placeholder="Write your thoughts..." class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2 dark:bg-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" class="bg-gradient-to-r from-blue-600 to-green-500 hover:from-green-600 hover:to-blue-500 text-white font-bold px-8 sm:px-10 py-3 rounded-full shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
          <i class="fa-solid fa-circle-check"></i> Submit Survey
          </button>
        </div>
      </form>
    </div>
  </main>

<!-- Footer Section -->
<footer class="bg-gray-900 text-gray-300 py-10 px-4">
  <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-8 text-center md:text-left">
    
    <!-- Logo & Description -->
    <div class="space-y-4">
      <h4 class="text-xl font-semibold text-purple-400">Delhi Water Watch</h4>
      <p class="text-sm">A real-time water monitoring platform empowering citizens with environmental data transparency.</p>
    </div>

    <!-- Quick Links -->
    <div class="space-y-3">
      <h4 class="text-lg font-semibold text-purple-400">Quick Links</h4>
      <ul class="space-y-1 text-sm">
        <li><a href="index.php" class="hover:text-white">Home</a></li>
        <li><a href="#monitoring" class="hover:text-white">Monitoring</a></li>
        <li><a href="survey.php" class="hover:text-white">Survey</a></li>
        <li><a href="contact.php" class="hover:text-white">Contact</a></li>
      </ul>
    </div>

    <!-- Contact Info -->
    <div class="space-y-3">
      <h4 class="text-lg font-semibold text-purple-400">Contact</h4>
      <p><i class="fas fa-envelope mr-2"></i> ayushman.rick007@gmail.com</p>
      <p><i class="fas fa-phone mr-2"></i> +91 8167394620</p>
      <p><i class="fas fa-map-marker-alt mr-2"></i> Delhi, India</p>
    </div>
  </div>

  <div class="border-t border-gray-700 mt-10 pt-6 text-sm text-center text-gray-500">
    © 2025 Delhi Water Watch. All rights reserved.
  </div>
</footer>

  <script>
  function checkAdminAccess() {
    const isAdmin = <?php echo (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) ? 'true' : 'false'; ?>;
    if (!isAdmin) {
      alert("⚠️ Only admins can access this page.");
      return false;
    }
    return true;
  }
  function toggleSidebar() {
    const sidebar = document.getElementById("mobileSidebar");
    sidebar.classList.toggle("hidden");
  }
</script>
</body>
</html>

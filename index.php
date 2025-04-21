<?php 
  session_start();
  if(isset($row['email'])) {
    $_SESSION['username'] = $row['email']; 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Water Monitoring - Delhi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          colors: {
            primary: '#4f46e5',
            secondary: '#9333ea',
            accent: '#06b6d4',
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-200 font-sans">
<!-- Mobile Sidebar -->
<div id="mobileSidebar" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden sm:hidden">
  <div class="absolute left-0 top-0 w-64 h-full bg-gray-800 p-6 space-y-4 shadow-lg transform transition-transform duration-300 ">
    <button onclick="toggleSidebar()" class="text-white text-xl absolute top-4 right-4">
      <i class="fas fa-times"></i>
    </button>
    <a href="index.php" class="block text-white text-lg hover:text-blue-400">Home</a>
    
    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
      <a href="#monitoring" class="block text-white text-lg hover:text-blue-400">Monitoring</a>
      <a href="survey.php" class="block text-white text-lg hover:text-blue-400">Survey</a>
      <a href="contact.php" class="block text-white text-lg hover:text-blue-400">Contact</a>
      <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <a href="admin.php" class="block text-white text-lg hover:text-blue-400">Admin</a>
      <?php endif; ?>
      
      <div class="mt-4 space-y-2 border-t border-gray-700 pt-4">
        <div class="text-gray-300 font-semibold flex items-center gap-2">
          <i class="fa-solid fa-user text-lg"></i>
          <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <a href="logout.php" class="block text-red-400 hover:text-red-500 transition">Logout</a>
      </div>
    <?php else: ?>
      <div class="mt-4 space-y-2 border-t border-gray-700 pt-4">
        <a href="login.php" class="block text-blue-400 hover:text-blue-500 transition">Login</a>
        <a href="signup.php" class="block text-purple-400 hover:text-purple-500 transition">Signup</a>
      </div>
    <?php endif; ?>
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
      
      <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <a href="#monitoring" class="hover:text-blue-400 font-medium transition block sm:inline">Monitoring</a>
        <a href="survey.php" class="hover:text-blue-400 font-medium transition block sm:inline">Survey</a>
        <a href="contact.php" class="text-white font-medium transition block sm:inline">Contact</a>
        <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
          <a href="admin.php" class="hover:text-blue-400 font-medium transition block sm:inline">Admin</a>
        <?php endif; ?>

        <!-- User Menu -->
        <div class="relative inline-block text-left block sm:inline ml-2" onclick="document.getElementById('userMenu').classList.toggle('hidden')">
          <button class="inline-flex justify-center items-center w-full rounded-full px-4 py-2 bg-gray-700 text-md font-medium text-gray-200 hover:bg-gray-600 transition">
            <i class="fa-solid fa-user mr-2"></i> <?= htmlspecialchars($_SESSION['username']); ?>
          </button>
          <div id="userMenu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-700 hidden z-50">
            <div class="py-1">
              <a href="logout.php" class="block px-4 py-2 text-sm text-red-400 hover:bg-red-800 transition">Logout</a>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="flex space-x-2 ml-auto">
          <a href="login.php" class="px-4 py-2 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">Login</a>
          <a href="signup.php" class="px-4 py-2 rounded-full bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold transition">Signup</a>
        </div>
      <?php endif; ?>
    </nav>
  </div>
</header>

<!-- Hero Section -->
<section class="relative text-center py-32 bg-cover bg-center bg-no-repeat" style="background-image: url('https://www.crossroadadventure.com/wp-content/uploads/2024/01/Yamuna-Ghat_7-scaled.jpg')">
  <div class="absolute inset-0 bg-gray-900 opacity-80"></div>
  <div class="relative z-10 max-w-5xl mx-auto px-4 text-gray-100">
    <h2 class="text-4xl font-extrabold mb-4">Real-Time Water Monitoring & Survey</h2>
    <p class="text-lg max-w-2xl mx-auto">Empowering Delhi to track and improve the quality of water bodies through real-time data and community input.</p>
    <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
      <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <a href="#monitoring" class="bg-primary text-white px-6 py-2 rounded-full shadow hover:bg-indigo-700 transition">View Monitoring</a>
        <a href="survey.php" class="bg-secondary text-white px-6 py-2 rounded-full shadow hover:bg-purple-700 transition">Submit a Survey</a>
      <?php else: ?>
        <a href="login.php" class="bg-primary text-white px-6 py-2 rounded-full shadow hover:bg-indigo-700 transition">Login to Access</a>
        <a href="signup.php" class="bg-secondary text-white px-6 py-2 rounded-full shadow hover:bg-purple-700 transition">Create Account</a>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Monitoring Section -->
<section id="monitoring" class="py-16 px-4 bg-gray-900">
  <div class="max-w-6xl mx-auto">
    <h3 class="text-3xl font-bold text-white mb-10 text-center"><i class="fa-solid fa-table-columns"></i> Water Quality Dashboard</h3>
    
    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
      <?php
        $csvFile = fopen(__DIR__ . "/WBC_DL_0.csv", "r");
        if ($csvFile !== FALSE) {
          $headers = fgetcsv($csvFile);
          $excludeColumns = ["ward_name", "town_municipality_name"];
          $includeIndexes = [];

          foreach ($headers as $index => $header) {
            if (!in_array(trim(strtolower($header)), $excludeColumns)) {
              $includeIndexes[] = $index;
            }
          }

          $includeIndexes = array_slice($includeIndexes, 0, 10);
          $maxRows = 5;
          $rowCount = 0;

          while (($row = fgetcsv($csvFile)) !== FALSE && $rowCount < $maxRows) {
            echo '<div class="mb-8 p-4 rounded-xl border border-gray-600 bg-gray-800 shadow">';
            echo '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">';
            foreach ($includeIndexes as $index) {
              $label = isset($headers[$index]) ? htmlspecialchars($headers[$index]) : "Column $index";
              $value = isset($row[$index]) ? htmlspecialchars($row[$index]) : "N/A";
              echo "
                <div class='p-3 bg-gray-700 rounded-2xl shadow-md hover:bg-gray-600 transition-all duration-300 transform hover:scale-105'>
                  <h4 class='text-xs text-gray-400 font-medium truncate'>{$label}</h4>
                  <p class='text-base font-bold text-blue-400 break-words'>{$value}</p>
                </div>
              ";
            }
            echo '</div></div>';
            $rowCount++;
          }

          fclose($csvFile);
        } else {
          echo "<p class='text-red-400'>Error: Unable to read the CSV file.</p>";
        }
      ?>
    <?php else: ?>
      <div class="bg-gray-800 p-8 rounded-xl text-center">
        <div class="text-lg mb-4">
          <i class="fas fa-lock text-2xl text-amber-500 mb-4 block"></i>
          <p class="font-medium">Please login to access the water quality monitoring data.</p>
        </div>
        <div class="mt-6 flex justify-center gap-4">
          <a href="login.php" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">Login</a>
          <a href="signup.php" class="px-4 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition">Signup</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- About Section -->
<section class="max-w-6xl mx-auto py-16 px-4 bg-slate-600 shadow-inner shadow-gray-800 rounded-xl">
  <h3 class="text-3xl md:text-4xl font-bold text-white mb-10 text-center"><i class="fa-solid fa-circle-info"></i> About the Project</h3>
  <div class="grid md:grid-cols-2 gap-10 items-center">
    
    <!-- Image with Shadow -->
    <img src="https://static.wixstatic.com/media/6ade0b_d6b74eb90c21457fa89682d573ad8a2f~mv2.jpg" alt="River in Delhi"
         class="rounded-xl shadow-lg shadow-black/40 w-full h-full max-h-[400px]">

    <!-- Text Content -->
    <div class="text-gray-300 space-y-5 text-justify">
      <p><strong class="text-purple-400">Delhi Water Watch</strong> is a citizen-focused initiative that combines technology, environmental awareness, and data transparency to monitor the health of Delhi's water bodies in real time.</p>
      <p>By integrating government CSV (e.g., <span class="text-blue-300">data.gov.in</span>), we provide visual dashboards of key water quality parameters like <strong>pH, TDS, DO, BOD</strong>. The platform also collects crowd-sourced insights from the public through a user-friendly survey system.</p>
      <p>This project empowers residents to engage with water safety data, encouraging collaborative efforts toward environmental conservation and better policy implementation.</p>

      <ul class="list-disc pl-5 text-sm">
        <li><strong class="text-green-400">Tech Stack:</strong> HTML, Tailwind CSS, PHP, JavaScript, MySQL</li>
        <li><strong class="text-green-400">Live Monitoring:</strong> Based on real-time CSV/API feeds</li>
        <li><strong class="text-green-400">Open Data:</strong> Supports public + government datasets</li>
      </ul>
    </div>
  </div>
</section>


 <!-- Break Line -->
 <hr class="border-t border-gray-700 mx-auto w-3/4 my-12">

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
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
          <li><a href="#monitoring" class="hover:text-white">Monitoring</a></li>
          <li><a href="survey.php" class="hover:text-white">Survey</a></li>
          <li><a href="contact.php" class="hover:text-white">Contact</a></li>
        <?php else: ?>
          <li><a href="login.php" class="hover:text-white">Login</a></li>
          <li><a href="signup.php" class="hover:text-white">Signup</a></li>
        <?php endif; ?>
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

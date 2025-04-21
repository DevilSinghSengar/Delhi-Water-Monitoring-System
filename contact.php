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
  <title>Contact Us - Delhi Water Watch</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <script>
    tailwind.config = {
      darkMode: 'class',
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

<!-- Navbar -->
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

<!-- Contact Section -->
<section class="max-w-6xl mx-auto py-16 px-4">
  <h2 class="text-3xl font-bold text-center mb-12 text-white"><i class="fa-solid fa-address-card"></i> Meet the Team</h2>
  
  <!-- Contact Form Section -->
  <div class="bg-gray-800 rounded-xl shadow-lg p-8 mb-16">
    <h3 class="text-2xl font-bold text-center mb-8 text-white"><i class="fa-solid fa-envelope"></i> Get in Touch</h3>
    <form id="contactForm" class="max-w-2xl mx-auto space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
          <input type="text" id="name" name="name" required
                 class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-primary transition">
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
          <input type="email" id="email" name="email" required
                 class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-primary transition">
        </div>
      </div>
      <div>
        <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
        <input type="text" id="subject" name="subject" required
               class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-primary transition">
      </div>
      <div>
        <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Message</label>
        <textarea id="message" name="message" rows="4" required
                  class="w-full px-4 py-2 rounded-lg bg-gray-700 border border-gray-600 text-white focus:outline-none focus:border-primary transition"></textarea>
      </div>
      <div class="text-center">
        <button type="submit" 
                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-105">
          <i class="fa-solid fa-paper-plane mr-2"></i>Send Message
        </button>
      </div>
    </form>
  </div>

  <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-2">
    
    <!-- Member 1 -->
    <div class="bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
      <img src="https://media.licdn.com/dms/image/v2/D5603AQFqFBfgi-xN0g/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1707564979338?e=1749686400&v=beta&t=mr2kcE6JqHkgj8h91DAkLu6mmzIa61_s_6LWicuD3P0" alt="Team Member" class="w-28 h-28 rounded-full mx-auto mb-4 border-4 border-primary">
      <h3 class="text-xl font-semibold text-center text-blue-400">Ayushman Bhattacharya</h3>
      <p class="text-center text-gray-400 mb-2">Lead Developer</p>
      <p class="text-center text-sm"><i class="fa-solid fa-envelope mr-2"></i>ayushman.rick007@gmail.com</p>
      <p class="text-center text-sm"><i class="fa-solid fa-phone mr-2"></i>+91 8167394620</p>
    </div>

    <!-- Member 2 -->
    <div class="bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
      <img src="https://media.licdn.com/dms/image/v2/D5603AQGGKzYgMIkFRQ/profile-displayphoto-shrink_400_400/B56ZYjbFq3HQAg-/0/1744351026516?e=1750291200&v=beta&t=wqnVUllOPmVD8iuyB0iV4NNXaji5s9lXsi9OQlCQ6Zk" alt="Team Member" class="w-28 h-28 rounded-full mx-auto mb-4 border-4 border-secondary">
      <h3 class="text-xl font-semibold text-center text-purple-400">Hritik Parihar</h3>
      <p class="text-center text-gray-400 mb-2">UI/UX Designer</p>
      <p class="text-center text-sm"><i class="fa-solid fa-envelope mr-2"></i>hparihar2005@gmail.com</p>
      <p class="text-center text-sm"><i class="fa-solid fa-phone mr-2"></i>+91 9906232302</p>
    </div>

    <!-- Member 3 -->
    <div class="bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
      <img src="https://media.licdn.com/dms/image/v2/D4D03AQHtmSVuPC5TAQ/profile-displayphoto-shrink_400_400/profile-displayphoto-shrink_400_400/0/1699776886454?e=1749686400&v=beta&t=BMl0VTM5AKQOe_hnawxentyKCWgT0drnkJLOvNX2Bbk" alt="Team Member" class="w-28 h-28 rounded-full mx-auto mb-4 border-4 border-accent">
      <h3 class="text-xl font-semibold text-center text-cyan-400">Priyanshu Jaiswal</h3>
      <p class="text-center text-gray-400 mb-2">Front-End Developer</p>
      <p class="text-center text-sm"><i class="fa-solid fa-envelope mr-2"></i>aryanpriyanshu6204@gmail.com</p>
      <p class="text-center text-sm"><i class="fa-solid fa-phone mr-2"></i>+91 6204894023</p>
    </div>

    <!-- Member 4 -->
    <div class="bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition duration-300">
      <img src="https://media.licdn.com/dms/image/v2/D5635AQGpe1PtKRXRuA/profile-framedphoto-shrink_400_400/B56ZZEKkA7HoAc-/0/1744900342245?e=1745560800&v=beta&t=OCgKvgAPRV8RcQGbEKwKHMSXkEhqgeRpS9g6gKxUdFo" alt="Team Member" class="w-28 h-28 rounded-full mx-auto mb-4 border-4 border-gray-500">
      <h3 class="text-xl font-semibold text-center text-gray-300">Piyush Singh</h3>
      <p class="text-center text-gray-400 mb-2">Data Analyst</p>
      <p class="text-center text-sm"><i class="fa-solid fa-envelope mr-2"></i>piyushsenger205@gmail.com</p>
      <p class="text-center text-sm"><i class="fa-solid fa-phone mr-2"></i>+91 9936693329</p>
    </div>

  </div>
</section>

<!-- Footer -->
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

  // Contact Form Submission
  document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);

    try {
      const response = await fetch('submit_contact.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.text();
      
      if (response.ok) {
        alert(result);
        document.getElementById('contactForm').reset();
      } else {
        throw new Error(result);
      }
    } catch (error) {
      alert(error.message || 'Error sending message. Please try again later.');
      console.error('Error:', error);
    }
  });
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'URL Shortener' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode.min.js"></script>

    <!-- Font Awesome CDN -->
    <link href="<?php echo base_url('public/css/style.css'); ?>" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Qr Code  CDN -->
    <script type="text/javascript" src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    
</head>


<body class="bg-gray-100 flex flex-col min-h-screen">

    <header class="bg-white p-4 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Logo Section -->
            <div class="flex items-center space-x-4">
                <h1 class="text-3xl font-semibold text-indigo-600 tracking-tight">short-url</h1>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-6">

                <!-- Logged-in User Options -->
                <?php if (session()->get('isLoggedIn')): ?>

                    <a href="<?= base_url('url_shortener') ?>" class="text-white bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-full transition-all text-lg getstartbtn">
                        +Create new
                    </a>
                    <a href="<?= base_url('url_shortener/analytics') ?>" class="text-gray-700 hover:text-indigo-400 hover:underline transition-colors px-4 py-2 rounded-md text-lg Header_header-link">
                        <i class="fas fa-chart-line mr-2"></i>    
                        Analytics
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative inline-block group">
                        <button class="text-gray-700 hover:text-indigo-400 hover:underline transition-colors px-4 py-2 rounded-md text-lg">
                        <i class="fas fa-user mr-2"></i>
                            Profile
                        </button>
                        <div class="absolute right-0 hidden group-hover:block mt-0 w-48 bg-white shadow-lg rounded-md z-10">
                            <a href="<?= base_url('auth/settings') ?>" class="flex items-center px-4 py-2 transition-colors duration-200 hover:bg-indigo-600 hover:text-white rounded">
                                <i class="fas fa-cog mr-2"></i>
                                Settings
                            </a>
                            <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-4 py-2 transition-colors duration-200 hover:bg-indigo-600 hover:text-white rounded">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Log Out
                            </a>
                        </div>
                    </div>

                    <span class="text-indigo-800 text-lg font-semibold px-4 py-2">Hello, <?= esc(session()->get('username')) ?></span>

                <?php else: ?>
                    <a href="<?= base_url('/') ?>" class="text-indigo-700 hover:text-blue-400 hover:underline transition-colors px-4 py-2 rounded-md text-lg">Home</a>
                    <a href="#about" class="text-indigo-700 hover:text-blue-400 hover:underline transition-colors px-4 py-2 rounded-md text-lg">About</a>
                    <a href="#features" class="text-indigo-700 hover:text-blue-400 hover:underline transition-colors px-4 py-2 rounded-md text-lg">Features</a>

                    <a href="<?= base_url('auth/login') ?>" class="text-indigo-700 hover:text-blue-400 hover:underline transition-colors px-4 py-2 rounded-md text-lg">Log In</a>
                    <a href="<?= base_url('auth/register') ?>" class="text-indigo-700 hover:text-blue-400 hover:underline transition-colors px-4 py-2 rounded-md text-lg">Sign Up</a>
                <?php endif; ?>
            </nav>

            <!-- Mobile Navbar (Hamburger Menu) -->
            <div class="md:hidden flex items-center">
                <button id="hamburger" class="text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown (Initially Hidden) -->
        <div id="mobileMenu" class="xl:hidden fixed inset-0 bg-gray-900 bg-opacity-80 z-40 hidden">
            <div class="flex justify-end p-4">
                <button id="closeMenu" class="text-white hover:text-indigo-300 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex flex-col items-center space-y-4 p-6">
                <?php if (session()->get('isLoggedIn')): ?>
                    <span class="text-white text-lg font-semibold">Hello, <?= esc(session()->get('username')) ?></span>
                    <div class="space-y-2 w-full">
                        <a href="<?= base_url('url_shortener/analytics') ?>" class="flex items-center justify-center w-full px-4 py-2 bg-indigo-700 text-white rounded-lg shadow hover:bg-indigo-600 transition duration-200">
                            <i class="fas fa-chart-line mr-2"></i>
                            Analytics
                        </a>
                        <a href="<?= base_url('auth/settings') ?>" class="flex items-center justify-center w-full px-4 py-2 bg-indigo-700 text-white rounded-lg shadow hover:bg-indigo-600 transition duration-200">
                            <i class="fas fa-cog mr-2"></i>
                            Settings
                        </a>
                        <a href="<?= base_url('auth/logout') ?>" class="flex items-center justify-center w-full px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-500 transition duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Log Out
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-2 w-full">
                        <a href="<?= base_url('auth/login') ?>" class="flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-500 transition duration-200">Log In</a>
                        <a href="<?= base_url('auth/register') ?>" class="flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-500 transition duration-200">Sign Up</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; <?= date('Y') ?> Futuristic Innovative System Pvt. Ltd. All rights reserved.</p>
            <!-- Optional footer links -->
            <div class="mt-2 flex justify-center space-x-4">
                <a href="#" class="text-blue-400 hover:text-blue-300">Privacy Policy</a>
                <a href="#" class="text-blue-400 hover:text-blue-300">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script>
        // Toggle mobile menu visibility
        const hamburgerButton = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMenuButton = document.getElementById('closeMenu');

        hamburgerButton.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
        });

        closeMenuButton.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    </script>

</body>

</html>
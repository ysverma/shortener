<div class="w-full sm:w-64 bg-gray-800 text-white p-6 sm:block hidden transition-transform duration-300 ease-in-out transform hover:scale-105">
    <h2 class="text-2xl font-semibold text-center mb-8">User  Dashboard</h2>
    <ul class="space-y-4">
        <li>
            <a href="<?= base_url('url_shortener') ?>" class="flex items-center px-4 py-2 transition-colors duration-200 <?= ($current_page == 'dashboard') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-600 hover:text-white' ?> rounded">
                <i class="fas fa-tachometer-alt mr-2"></i>
                Dashboard
            </a>
        </li>
        <li class="relative">
            <a href="#" class="flex items-center text-lg transition-colors duration-200 hover:text-indigo-400">
                <i class="fas fa-user mr-2"></i>
                Profile
            </a>
            <ul class="mt-2 space-y-2">
                <li>
                    <a href="<?= base_url('auth/settings') ?>" class="flex items-center px-4 py-2 transition-colors duration-200 <?= ($current_page == 'settings') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-600 hover:text-white' ?> rounded">
                        <i class="fas fa-cog mr-2"></i>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('url_shortener/analytics') ?>" class="flex items-center px-4 py-2 transition-colors duration-200 <?= ($current_page == 'analytics') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-600 hover:text-white' ?> rounded">
                        <i class="fas fa-chart-line mr-2"></i>
                        Analytics
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-4 py-2 transition-colors duration-200 hover:bg-indigo-600 hover:text-white rounded">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Log Out
            </a>
        </li>
    </ul>
</div>
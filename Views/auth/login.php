<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
    <!-- Main Content -->
    <main class="min-h-screen bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 flex justify-center items-center">
        <div class="w-full max-w-sm bg-white p-8 rounded-xl shadow-lg overflow-hidden">
            <!-- Logo Section -->
            <div class="text-center mb-6">
                <h1 class="text-4xl font-bold text-gray-800">Welcome Back!</h1>
                <p class="text-gray-600 mt-2">Sign in to your account</p>
            </div>

            <!-- Flash messages for errors -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="text-red-500 bg-red-100 border border-red-500 p-3 rounded mb-6">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="text-red-500 bg-red-100 border border-red-500 p-3 rounded mb-6">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->get('success')) : ?>
                <div class="mb-4">
                    <p class="text-green-600"><?= esc(session()->get('success')) ?></p>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= base_url('auth/loginSubmit') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= old('email') ?>" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 ease-in-out" required>
                </div>

                <!-- Password input -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 ease-in-out" required>
                </div>

                <!-- Submit button -->
                <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-200 ease-in-out">Login</button>
            </form>

            <!-- Divider -->
            <div class="my-6 flex items-center">
                <hr class="flex-grow border-gray-300">
                <span class="px-4 text-sm text-gray-600">or</span>
                <hr class="flex-grow border-gray-300">
            </div>

            <!-- Gmail Login Button -->
            <div class="mb-4">
                <a href="<?= base_url('auth/gmailLogin') ?>" class="w-full bg-gray-800 text-white py-3 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 flex items-center justify-center space-x-2 transition duration-200 ease-in-out">
                    <!-- Gmail Logo -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20px" height="20px" class="mr-2">
                        <g>
                            <path d="M23.7136364,10.1333333 C27.025,10.1333333 30.0159091,11.3066667 32.3659091,13.2266667 L39.2022727,6.4 C35.0363636,2.77333333 29.6954545,0.533333333 23.7136364,0.533333333 C14.4268636,0.533333333 6.44540909,5.84426667 2.62345455,13.6042667 L10.5322727,19.6437333 C12.3545909,14.112 17.5491591,10.1333333 23.7136364,10.1333333" fill="#EB4335"></path>
                            <path d="M9.82727273,24 C9.82727273,22.4757333 10.0804318,21.0144 10.5322727,19.6437333 L2.62345455,13.6042667 C1.08206818,16.7338667 0.213636364,20.2602667 0.213636364,24 C0.213636364,27.7365333 1.081,31.2608 2.62025,34.3882667 L10.5247955,28.3370667 C10.0772273,26.9728 9.82727273,25.5168 9.82727273,24" fill="#FBBC05"></path>
                            <path d="M23.7136364,37.8666667 C17.5491591,37.8666667 12.3545909,33.888 10.5322727,28.3562667 L2.62345455,34.3946667 C6.44540909,42.1557333 14.4268636,47.4666667 23.7136364,47.4666667 C29.4455,47.4666667 34.9177955,45.4314667 39.0249545,41.6181333 L31.5177727,35.8144 C29.3995682,37.1488 26.7323182,37.8666667 23.7136364,37.8666667" fill="#34A853"></path>
                            <path d="M46.1454545,24 C46.1454545,22.6133333 45.9318182,21.12 45.6113636,19.7333333 L23.7136364,19.7333333 L23.7136364,28.8 L36.3181818,28.8 C35.6879545,31.8912 33.9724545,34.2677333 31.5177727,35.8144 L39.0249545,41.6181333 C43.3393409,37.6138667 46.1454545,31.6490667 46.1454545,24" fill="#4285F4"></path>
                        </g>
                    </svg>
                    <!-- Text -->
                    <span>Login with Google</span>
                </a>
            </div>
        </div> 
    </main>

<?= $this->endSection() ?>

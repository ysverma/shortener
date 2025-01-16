<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>
<main class="flex-grow flex justify-center items-center py-8 bg-gray-50">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-xl">
        <h2 class="text-3xl font-semibold text-center text-indigo-600 mb-6">Create an Account</h2>

        <!-- Flash message for errors -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="text-red-500 bg-red-100 border border-red-500 p-4 rounded-lg mb-6">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li class="text-sm"><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (session()->get('success')) : ?>
            <div class="mb-4">
                <p class="text-green-600"><?= esc(session()->get('success')) ?></p>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form action="<?= base_url('auth/registerSubmit') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Username input -->
            <div class="mb-6">
                <label for="username" class="block text-lg font-medium text-gray-700">Username</label>
                <input type="text" name="username" value="<?= old('username') ?>" 
                    class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Enter your username" required>
            </div>

            <!-- Email input -->
            <div class="mb-6">
                <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="<?= old('email') ?>" 
                    class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Enter your email" required>
            </div>

            <!-- Password input -->
            <div class="mb-6">
                <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                <input type="password" name="password" 
                    class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Create a password" required>
            </div>

            <!-- Confirm Password input -->
            <div class="mb-8">
                <label for="confirm_password" class="block text-lg font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" 
                    class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Confirm your password" required>
            </div>

            <!-- Submit button -->
            <button type="submit" 
                class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition-all ease-in-out duration-300">
                Register
            </button>

            <!-- Alternative Login -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Already have an account? 
                    <a href="<?= base_url('auth/login') ?>" class="text-indigo-600 hover:text-indigo-700">Login</a>
                </p>
            </div>
        </form>
    </div>
</main>

<?= $this->endSection() ?>

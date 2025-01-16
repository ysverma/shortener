<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="flex min-h-screen">
    <!-- Include Sidebar Partial -->
    <?= $this->include('partials/sidebar') ?>

    <!-- Main Content Area -->
    <div class="flex-1 p-6 bg-white shadow-lg rounded-lg w-auto">

        <h1 class="text-2xl font-semibold mb-4">Account Settings</h1>

        <!-- Display success message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-500 text-white p-4 mb-4 rounded-md">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Display errors -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
                <?= implode('<br>', session()->getFlashdata('errors')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/updateSettings') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label for="username" class="block text-lg font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="mt-2 p-3 border border-gray-300 rounded-md w-full" value="<?= esc($user['username']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-2 p-3 border border-gray-300 rounded-md w-full" value="<?= esc($user['email']) ?>" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-lg font-medium text-gray-700">New Password (Optional)</label>
                <input type="password" id="password" name="password" class="mt-2 p-3 border border-gray-300 rounded-md w-full" placeholder="Leave blank if not changing">
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="block text-lg font-medium text-gray-700">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="mt-2 p-3 border border-gray-300 rounded-md w-full" placeholder="Leave blank if not changing">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md">Save Changes</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
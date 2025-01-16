<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>

  <!-- Hero Section -->
<section class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 text-white py-32">
    <div class="absolute inset-0 bg-cover bg-center opacity-30"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">Shorten URLs with Ease</h1>
        <p class="text-xl md:text-2xl mb-10">Share short, branded, and trackable links with just a few clicks!</p>
        <div class="flex justify-center gap-4 items-center">
            <input type="url" id="long-url" placeholder="Enter your long URL..." class="w-full sm:w-96 px-6 py-3 rounded-l-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-800 placeholder-gray-500" />
            <button id="shorten-url-btn" class="bg-indigo-700 text-white px-8 py-3 rounded-r-lg shadow-md hover:bg-indigo-800 transition-all">Shorten</button>
        </div>
        <p class="text-sm mt-6">Just shorten and share instantly!</p>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-20 bg-indigo-50 text-center">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-semibold mb-6 text-gray-800">How It Works</h2>
        <p class="text-xl mb-12 text-gray-600">Follow these simple steps to shorten your URLs quickly and easily.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-all">
                <div class="text-indigo-600 mb-4">
                    <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3M4 12h16"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-4">Enter Your URL</h3>
                <p>Simply paste your long URL in the input box, and we’ll take care of the rest.</p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-all">
                <div class="text-indigo-600 mb-4">
                    <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-4">Preview Your Link</h3>
                <p>Review the metadata of your URL like title, description, and image before shortening it.</p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-all">
                <div class="text-indigo-600 mb-4">
                    <svg class="w-12 h-12 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold mb-4">Shorten Your Link</h3>
                <p>Click the button to generate your shortened link. You can also customize it with an alias!</p>
            </div>
        </div>
    </div>
</section>


<!-- Preview Section -->
<section id="preview-section" class="py-20 bg-white text-center hidden">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-semibold mb-6 text-gray-800">URL Preview</h2>
        <div class="bg-white p-8 rounded-lg shadow-lg mb-6">
            <img id="preview-image" src="" alt="Preview Image" class="hidden mb-4 max-w-full h-auto rounded-md shadow-md" />
            <p id="preview-title" class="text-2xl font-semibold text-gray-800"></p>
            <p id="preview-description" class="text-xl text-gray-600"></p>
        </div>

        <!-- Custom Alias Section -->
        <div class="mb-6">
            <label for="custom-alias" class="block text-lg font-medium text-gray-800">Custom Alias (Optional)</label>
            <input type="text" id="custom-alias" placeholder="Enter custom alias" class="w-full sm:w-96 px-6 py-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-800" />
        </div>

        <!-- Shorten Button -->
        <button id="submit-url" class="bg-indigo-700 text-white px-8 py-3 rounded-lg shadow-md hover:bg-indigo-800 transition-all">Shorten URL</button>
    </div>
</section>


  <!-- About Section -->
  <section id="about" class="py-20 bg-white text-center">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-4xl font-semibold mb-10 text-gray-800">Why Choose Short_url?</h2>
      <p class="text-xl mb-12 text-gray-600">Our tool offers a simple, fast, and secure way to shorten URLs, enhance tracking, and boost your online performance.</p>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-gray-50 p-8 rounded-lg shadow-lg transition-all transform hover:scale-105 hover:shadow-xl">
          <h3 class="text-2xl font-semibold mb-4">Fast & Easy</h3>
          <p>Shorten your URLs in seconds without any complex steps or requirements.</p>
        </div>
        <div class="bg-gray-50 p-8 rounded-lg shadow-lg transition-all transform hover:scale-105 hover:shadow-xl">
          <h3 class="text-2xl font-semibold mb-4">Customizable Links</h3>
          <p>Create branded or personalized short URLs that match your identity.</p>
        </div>
        <div class="bg-gray-50 p-8 rounded-lg shadow-lg transition-all transform hover:scale-105 hover:shadow-xl">
          <h3 class="text-2xl font-semibold mb-4">Link Analytics</h3>
          <p>Track your links' performance with real-time click and location data.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-20 bg-indigo-50 text-center">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-4xl font-semibold mb-6 text-gray-800">Features that Matter</h2>
      <p class="text-xl mb-12 text-gray-600">More than just URL shortening – it's a powerful suite of tools to help you get the most out of your links.</p>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-all">
          <h3 class="text-2xl font-semibold mb-4">Link Expiration</h3>
          <p>Set expiry dates for your short URLs to ensure they are automatically disabled after a specific time.</p>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-all">
          <h3 class="text-2xl font-semibold mb-4">QR Codes</h3>
          <p>Generate QR codes for your shortened URLs and share them in physical or digital formats.</p>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-all">
          <h3 class="text-2xl font-semibold mb-4">Link Customization</h3>
          <p>Create custom alias links that match your campaign or branding strategy.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section id="get-started" class="py-20 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white text-center">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-4xl font-semibold mb-6">Get Started with Short-url</h2>
      <p class="text-xl mb-8">Take control of your links and boost your online presence today.</p>
      <a href="<?= base_url('auth/login') ?>"  class="bg-indigo-500 text-white px-8 py-3 rounded-full text-lg hover:bg-indigo-800 transition-all">Start Now</a>
    </div>
  </section>
  <script>
    document.getElementById('shorten-url-btn').addEventListener('click', async () => {
        const url = document.getElementById('long-url').value;

        if (!url) {
            alert('Please enter a valid URL!');
            return;
        }

        // Store the URL in sessionStorage
        sessionStorage.setItem('pendingUrl', url);

        // Redirect to login
        window.location.href = '<?= base_url("auth/login") ?>';
    });
</script>
  <?= $this->endSection() ?>
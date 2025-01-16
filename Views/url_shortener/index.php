<?= $this->extend("layouts/base"); ?>

<?= $this->section("content"); ?>

<style>
    .getstartbtn {
        display: none;
    }
</style>

<div class="flex flex-col lg:flex-row items-start justify-center min-h-screen">
    <!-- Shortened URL Display Section -->
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-lg mb-6 lg:mb-0 lg:w-1/2">
        <h1 class="text-3xl font-semibold text-center text-blue-600 mb-6">URL Shortener</h1>

        <!-- Display errors or success messages -->
        <?php if (session()->get('errors')) : ?>
            <div class="mb-4">
                <ul class="list-disc pl-6 text-red-600">
                    <?php foreach (session()->get('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (session()->get('success')) : ?>
            <div class="mb-4">
                <p class="text-green-600"><?= esc(session()->get('success')) ?></p>
            </div>
        <?php endif; ?>

        <div id="error-messages" class="mb-4">
            <ul class="list-disc pl-6 text-red-600"></ul>
        </div>

        <!-- URL Shortener Form -->
        <form id="url-form" action="<?= base_url('url_shortener/shorten') ?>" method="post">
            <?= csrf_field() ?>

            <!-- URL Input Field -->
            <div class="mb-4 text-center">
                <label for="url" class="block text-lg font-medium text-gray-700">Enter URL:</label>
                <input type="text" name="url" id="url" value="<?= old('url') ?>"
                    class="w-full sm:w-96 px-6 py-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-800"
                    placeholder="Enter the URL to shorten" required>
            </div>

            <!-- Custom Title Input Field (Editable) -->
            <div class="mb-4 text-center">
                <label for="title" class="block text-lg font-medium text-gray-700">Custom Title (Optional):</label>
                <input type="text" name="title" id="title" value="<?= old('title') ?>"
                    class="w-full sm:w-96 px-6 py-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-800"
                    placeholder="Enter a custom title" />
            </div>

            <!-- Custom Description Input Field (Editable) -->
            <div class="mb-4 text-center">
                <label for="description" class="block text-lg font-medium text-gray-700">Custom Description (Optional):</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full sm:w-96 px-6 py-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-800"
                    placeholder="Enter a custom description"></textarea>
            </div>

            <!-- Optional Alias Input Field -->
            <div class="mb-4 text-center">
                <label for="alias" class="block text-lg font-medium text-gray-700">Create custom alias links that match your campaign or branding strategy (Optional):</label>
                <input type="text" name="alias" id="alias" value="<?= old('alias') ?>"
                    class="w-full sm:w-96 px-6 py-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-800"
                    placeholder="Enter a custom alias (optional)">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="w-full sm:w-96 py-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Shorten URL
                </button>
            </div>
        </form>

        <!-- Shortened URL Display -->
        <div id="shortened-url" class="mb-6 hidden">
            <p class="text-lg font-medium text-gray-700 mb-2">Short URL:</p>

            <div class="flex items-center space-x-2">
                <input id="shortened-input" type="url" class="w-full sm:w-96 px-6 py-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 text-gray-800" readonly />
                <button onclick="copyToClipboard()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Copy
                </button>
            </div>
            <div id="copy-message" class="copy-message">
                Link copied to clipboard
            </div>

            <!-- Centered QR Code Section -->
            <div id="qr-code" class="mt-8 text-center">
                <h3 class="text-lg font-semibold text-blue-600 mb-4">QR code for the shortened URL:</h3>
                <!-- QR code -->
                <div id="qrcode" class="mx-auto mb-4"></div>
                <button id="download-qr" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Download QR Code
                </button>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="<?= base_url('url_shortener') ?>"
                class="inline-block px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Shorten another URL
            </a>
        </div>
    </div>


    <!-- Social Media Previews Section -->
    <div class="w-full lg:w-1/2 p-6 bg-white shadow-xl rounded-lg">
        <div id="loader" style="display: none;">
            <div class="spinner"></div>
        </div>
        <h2 class="text-xl font-semibold text-blue-600 mb-4">Social Media Previews</h2>

        <div class="Channels_preview__types ">
            <button class="ChannelIcon_type ChannelIcon_active ChannelIcon_facebook" id="facebook-btn">
                <i class="fab fa-facebook-f" aria-hidden="true"></i>
            </button>
            <button class="ChannelIcon_type ChannelIcon_active ChannelIcon_telegram" id="telegram-btn">
                <i class="fab fa-telegram-plane" aria-hidden="true"></i>
            </button>
            <button class="ChannelIcon_type ChannelIcon_active ChannelIcon_twitter" id="twitter-btn">
                <i class="fab fa-twitter" aria-hidden="true"></i>
            </button>
            <button class="ChannelIcon_type ChannelIcon_active ChannelIcon_linkedin" id="linkedin-btn">
                <i class="fab fa-linkedin-in" aria-hidden="true"></i>
            </button>
            <button class="ChannelIcon_type ChannelIcon_active ChannelIcon_whatsapp" id="whatsapp-btn">
                <i class="fab fa-whatsapp" aria-hidden="true"></i>
            </button>
        </div>

        <div id="url-preview-facebook" class="text-gray-700 mb-6 p-4 border-2 border-gray-300 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-600">Facebook Preview</h3>
            <div class="facebook-pre">
                <img id="fb-image" src="" alt="FB Preview Image" class="hidden max-w-full h-auto shadow-md" />
                <div class="description-text">
                    <p id="fb-title" class="font-semibold text-blue-600 FacebookPreview_card__title"></p>
                    <p id="fb-description" class="text-gray-500 FacebookPreview_card__description"></p>
                    <p id="fb-domain" class="text-gray-500 FacebookPreview_card__description"></p>
                </div>
            </div>
        </div>

        <!-- Telegram Preview -->
        <div id="url-preview-telegram" class="text-gray-700 mb-6 p-4 border-2 border-blue-500 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-600">Telegram Preview</h3>
            <div class="TelegramPreview_im_message_webpage">
                <p id="tg-domain" class="text-gray-500 TelegramPreview_im_message_webpage_host "></p>
                <p id="tg-title" class="font-semibold text-blue-600 TelegramPreview_im_message_webpage_title"></p>
                <p id="tg-description" class="text-gray-500 TelegramPreview_im_message_webpage_description"></p>
                <img id="tg-image" src="" alt="Telegram Preview Image" class="hidden mb-4 max-w-full h-auto rounded-md shadow-md" />
            </div>
        </div>

        <!-- Twitter Preview -->
        <div id="url-preview-twitter" class="text-gray-700 mb-6 p-4 border-2 border-blue-600 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-600">Twitter Preview</h3>
            <div class="TwitterPreview_im_message_webpage TwitterPreview_card_seo_twitter__text">
                <img id="tw-image" src="" alt="Twitter Preview Image" class="hidden mb-4 max-w-full h-auto rounded-md shadow-md TwitterPreview_card_seo_twitter__image" />
                <p id="tw-title" class="font-semibold text-blue-600 TwitterPreview_card_seo_twitter__title"></p>
                <p id="tw-description" class="text-gray-500 TwitterPreview_card_seo_twitter__description"></p>
                <p id="tw-link" class="text-gray-500 TwitterPreview_card_seo_twitter__link"></p>
                <p id="tw-domian" class="text-gray-500 TwitterPreview_card_seo_twitter__link"></p>
            </div>
        </div>

        <!-- WhatsApp Preview -->
        <div id="url-preview-whatsapp" class="text-gray-700 mb-6 p-4 border-2 border-green-600 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-600">WhatsApp Preview</h3>
            <div class="whatsapp-preview-container WhatsappPreview_card-seo-whatsapp ">
                <img id="wa-image" src="" alt="WhatsApp Preview Image" class="hidden mb-4 max-w-full h-auto rounded-md shadow-md" />
                <p id="wa-title" class="font-semibold text-blue-600 WhatsappPreview_card-seo-whatsapp__title"></p>
                <p id="wa-description" class="text-gray-500 WhatsappPreview_card-seo-whatsapp__body"></p>
                <p id="wa-domain" class="text-gray-500 WhatsappPreview_card-seo-whatsapp__link"></p>
            </div>
        </div>

        <!-- LinkedIn Preview -->
        <div id="url-preview-linkedin" class="text-gray-700 p-4 border-2 border-blue-700 rounded-lg LinkedinPreview_card-seo-linkedin">
            <h3 class="text-lg font-semibold text-blue-600">LinkedIn Preview</h3>
            <div class="LinkedinPreview_card-seo-linkedin__text">
                <img id="li-image" src="" alt="LinkedIn Preview Image" class="hidden mb-4 max-w-full h-auto rounded-md shadow-md" />
                <p id="li-title" class="font-semibold text-blue-600 LinkedinPreview_card-seo-linkedin__title"></p>
                <p id="li-domain" class="text-gray-500 LinkedinPreview_card-seo-linkedin__description"></p>
                <p id="li-description" class="text-gray-500 LinkedinPreview_card-seo-linkedin__description"></p>
            </div>
        </div>

    </div>
</div>


<script>
    // CSRF token for secure requests
const csrfToken = '<?= csrf_token() ?>';
const platforms = ['fb', 'tg', 'tw', 'wa', 'li']; // List of social media platforms

// Function to smoothly scroll to the preview section of a specific platform
function scrollToPreview(platform) {
    const previewElement = document.getElementById(`url-preview-${platform}`);
    previewElement.scrollIntoView({
        behavior: 'smooth'
    });
}

// Add click event listeners to buttons for each platform to scroll to their previews
['facebook', 'telegram', 'twitter', 'whatsapp', 'linkedin'].forEach(platform => {
    document.getElementById(`${platform}-btn`).addEventListener('click', () => scrollToPreview(platform));
});

// Function to fetch metadata from a given URL
async function fetchMetadata(url) {
    const loader = document.getElementById('loader');
    loader.style.display = 'flex';

    try {
        const response = await fetch('<?= base_url('url_metadata') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
            body: JSON.stringify({
                url
            })
        });

        if (!response.ok) throw new Error('Failed to fetch metadata');

        const data = await response.json();
        console.log(data); 
        updateFields(data);
        updateAllPreviews(data); 
    } catch (error) {
        console.error(error); 
        alert('Failed to fetch metadata: ' + error.message); 
    } finally {
        loader.style.display = 'none'; 
    }
}

// Function to update input fields with fetched metadata
function updateFields(data) {
    document.getElementById('title').value = data.title || 'No title found';
    document.getElementById('description').value = data.description || 'No description found';
    updatePreviews(); 
}

// Function to update previews for all platforms
function updateAllPreviews(data) {
    platforms.forEach(platform => {
        const prefix = `${platform}-`;
        updatePreviewElements(prefix, data); 
    });
}

// Function to update individual preview elements for a platform
function updatePreviewElements(prefix, data) {
    const titleElement = document.getElementById(`${prefix}title`);
    const descElement = document.getElementById(`${prefix}description`);
    const imgElement = document.getElementById(`${prefix}image`);
    const linkElement = document.getElementById(`${prefix}link`);
    const domainElement = document.getElementById(`${prefix}domain`);

    // Update the content of each preview element
    if (titleElement) titleElement.textContent = data.title || 'No title found';
    if (descElement) descElement.textContent = data.description || 'No description found';
    if (linkElement) linkElement.textContent = data.link || 'No link found';
    if (domainElement) domainElement.textContent = data.domain || 'No domain found';

    // Update image element and toggle visibility
    if (imgElement) {
        imgElement.src = data.image || '';
        imgElement.classList.toggle('hidden', !data.image);
    }
}

// Function to update previews based on custom title and description
function updatePreviews() {
    const customTitle = document.getElementById('title').value;
    const customDescription = document.getElementById('description').value;

    platforms.forEach(platform => {
        const prefix = `${platform}-`;
        document.getElementById(`${prefix}title`).textContent = customTitle || 'No title found';
        document.getElementById(`${prefix}description`).textContent = customDescription || 'No description found';
    });
}

// Add event listeners for title and description input fields to update previews
document.getElementById('title').addEventListener('input', updatePreviews);
document.getElementById('description').addEventListener('input', updatePreviews);

// Event listener for URL input field to fetch metadata when a URL is entered
document.getElementById('url').addEventListener('input', function() {
    const url = this.value;
    if (url) {
        fetchMetadata(url); 
    } else {
        resetPreviews(); 
    }
});

// Function to reset all previews to empty state
function resetPreviews() {
    platforms.forEach(platform => {
        const prefix = `${platform}-`;
        document.getElementById(`${prefix}title`).textContent = '';
        document.getElementById(`${prefix}description`).textContent = '';
        document.getElementById(`${prefix}link`).textContent = '';
        document.getElementById(`${prefix}domain`).textContent = '';
        document.getElementById(`${prefix}image`).classList.add('hidden');
    });
}

// Function to generate a QR code for a shortened URL
function generateQRCode(shortenedUrl) {
    const qrCodeContainer = document.getElementById('qrcode');
    qrCodeContainer.innerHTML = ''; 

    new QRCode(qrCodeContainer, {
        text: shortenedUrl,
        width: 128,
        height: 128,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.L 
    });
}

// jQuery document ready function to handle form submission
$(document).ready(function() {
    $('#url-form').on('submit', function(e) {
        e.preventDefault(); 

        const url = $('#url').val();
        const alias = $('#alias').val();
        const csrfToken = $('input[name="<?= csrf_token() ?>"]').val(); 

        // AJAX request to shorten the URL
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: {
                url: url,
                alias: alias,
                <?= csrf_token() ?>: csrfToken
            },
            success: function(response) {
                console.log(response); 
                if (response.success) {
                    $('#shortened-url').removeClass('hidden'); 
                    $('#shortened-input').val(response.shortened_url); 
                    generateQRCode(response.shortened_url); 
                } else {
                    displayErrorMessages(response.errors); 
                }
            },
            error: function() {
                alert('An error occurred while shortening the URL');
            }
        });
    });
});

// Function to display error messages
function displayErrorMessages(errors) {
    let errorMessages = '';
    if (errors) {
        errors.forEach(function(error) {
            errorMessages += `<li>${error}</li>`; 
        });
    }
    $('#error-messages').html(errorMessages); 
}

// Event listener for downloading the QR code as an image
document.getElementById('download-qr').addEventListener('click', function() {
    const qrCodeCanvas = document.querySelector('#qrcode canvas');
    const imageUrl = qrCodeCanvas.toDataURL("image/png"); 

    const link = document.createElement('a');
    link.href = imageUrl; 
    link.download = 'qrcode.png'; 
    link.click(); 
});

// Function to copy the shortened URL to clipboard
function copyToClipboard() {
    const copyText = document.getElementById('shortened-input');
    copyText.select(); 
    document.execCommand('copy'); 

    const messageElement = document.getElementById('copy-message');
    messageElement.style.display = 'block'; 

    setTimeout(() => {
        messageElement.style.opacity = '1'; 
    }, 10);

    setTimeout(() => {
        messageElement.style.opacity = '0'; 
        setTimeout(() => {
            messageElement.style.display = 'none';
        }, 500);
    }, 2000);
}

// Document ready function to check for a pending URL in session storage
document.addEventListener('DOMContentLoaded', async function() {
    const pendingUrl = sessionStorage.getItem('pendingUrl'); 
    console.log("pendingurl: ", pendingUrl);
    if (pendingUrl) {
        document.getElementById('url').value = pendingUrl; 
        await fetchMetadata(pendingUrl); 
        sessionStorage.removeItem('pendingUrl'); 
    }
});
</script>

<?= $this->endSection() ?>
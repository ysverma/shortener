<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="flex min-h-screen bg-gray-100">

    <!-- Include Sidebar -->
    <?= $this->include('partials/sidebar') ?>

    <!-- Main Content Area -->
    <div class="flex-1 p-4 sm:p-8 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Page Title -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Analytics Dashboard</h1>
            <p class="text-lg text-gray-600 mt-2">Analyze the performance of your shortened URLs across different periods.</p>
        </div>

        <!-- Key Metrics Section -->
        <section class="mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                <?php
                $metrics = [
                    ['title' => 'Total Clicks', 'value' => $totalClicks, 'description' => 'All-time total clicks for your URLs.', 'bg' => 'from-blue-500 to-indigo-600'],
                    ['title' => 'Clicks in Last 24h', 'value' => $clickData24h, 'description' => 'Performance of your URLs in the last 24 hours.', 'bg' => 'from-green-500 to-teal-500'],
                    ['title' => 'Clicks in Last Week', 'value' => $clickDataWeek, 'description' => 'How your URLs performed over the past week.', 'bg' => 'from-yellow-500 to-orange-600'],
                    ['title' => 'Clicks in Last Month', 'value' => $clickDataMonth, 'description' => 'Performance of your URLs in the last month.', 'bg' => 'from-red-500 to-pink-600'],
                ];
                foreach ($metrics as $metric): ?>
                    <div class="bg-gradient-to-r <?= $metric['bg'] ?> p-6 rounded-lg shadow-lg text-white">
                        <h3 class="text-xl font-semibold"><?= esc($metric['title']) ?></h3>
                        <p class="text-4xl font-bold"><?= esc($metric['value']) ?></p>
                        <p class="text-sm mt-2"><?= esc($metric['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Analytics Chart Section -->
        <section class="mb-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Clicks Over Time</h3>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <canvas id="clicksChart" class="w-full h-72 sm:h-96"></canvas>
            </div>
        </section>

        <!-- URL Table Section -->
        <section class="bg-white p-6 rounded-lg shadow-lg overflow-hidden">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Your Shortened URLs</h3>
    <div class="overflow-x-auto max-h-72 overflow-y-auto">
        <table id="urlsTable" class="min-w-full bg-white rounded-lg shadow-sm">
            <thead class="bg-indigo-700 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Shortened URL</th>
                    <th class="px-6 py-3 text-left">Original URL</th>
                    <th class="px-6 py-3 text-left">Clicks</th>
                    <th class="px-6 py-3 text-left">Growth</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($urls)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-center text-gray-500">No shortened URLs found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($urls as $url): ?>
                        <tr class="border -t hover:bg-indigo-50">
                            <td class="px-6 py-3 text-blue-500">
                                <a href="<?= base_url($url['short_url']) ?>" target="_blank" class="hover:text-indigo-700" aria-label="Visit <?= esc($url['original_url']) ?>"><?= base_url($url['short_url']) ?></a>
                            </td>
                            <td class="px-6 py-3"><?= esc($url['original_url']) ?></td>
                            <td class="px-6 py-3"><?= esc($url['clicks']) ?></td>
                            <td class="px-6 py-3">
                                <div class="w-full bg-gray-200 rounded-full">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: <?= esc($url['clicks']) ?>%"></div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js configuration for Clicks Graph
    var ctx = document.getElementById('clicksChart').getContext('2d');
    var clicksChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Last 24h', 'Last Week', 'Last Month'],
            datasets: [{
                label: 'Number of Clicks',
                data: [<?= $clickData24h ?>, <?= $clickDataWeek ?>, <?= $clickDataMonth ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(75, 192, 192, 2)',
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'Clicks: ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#urlsTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            pageLength: 10, // Set the default number of rows per page
        });
    });
</script>
<?= $this->endSection() ?>
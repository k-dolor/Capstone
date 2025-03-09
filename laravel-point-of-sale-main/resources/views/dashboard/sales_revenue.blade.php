<!-- Sales & Revenue Chart Section -->
<div class="col-lg-6 mb-4">
    <div class="card card-block card-stretch card-height">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Sales & Revenue</h4>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton002" data-toggle="dropdown">
                    <span id="selectedFilter">Monthly</span> <i class="ri-arrow-down-s-line ml-1"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton002">
                    <button class="dropdown-item" onclick="fetchSalesRevenueData('monthly')">Monthly</button>
                    <button class="dropdown-item" onclick="fetchSalesRevenueData('weekly')">Weekly</button>
                    <button class="dropdown-item" onclick="fetchSalesRevenueData('yearly')">Yearly</button>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <canvas id="salesRevenueChart" style="min-height: 400px;"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetchSalesRevenueData("monthly");
});

function fetchSalesRevenueData(filter) {
    document.getElementById("selectedFilter").innerText = filter.charAt(0).toUpperCase() + filter.slice(1);

    fetch(`/dashboard/sales-revenue?filter=${filter}`)
        .then(response => response.json())
        .then(data => {
            updateSalesRevenueChart(data.labels, data.salesData, data.revenueData);
        })
        .catch(error => console.error("Error fetching sales data:", error));
}

function updateSalesRevenueChart(labels, salesData, revenueData) {
    console.log("Updating Chart with Data:", labels, salesData, revenueData);

    var ctx = document.getElementById("salesRevenueChart").getContext("2d");

    if (window.salesRevenueChart !== undefined) {
        window.salesRevenueChart.destroy();
    }

    window.salesRevenueChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Sales",
                    data: salesData,
                    backgroundColor: "rgba(54, 162, 235, 0.6)",
                },
                {
                    label: "Revenue",
                    data: revenueData,
                    backgroundColor: "rgba(255, 99, 132, 0.6)",
                }
            ]
        }
    });
}
</script>

var ctx = document.getElementById("myChart").getContext("2d");
var myChart = new Chart(ctx, {
	type: "bar",
	data: {
		labels: [], // Labels akan diisi oleh data dari API
		datasets: [
			{
				label: "Statistik",
				data: [], // Data akan diisi oleh API
				backgroundColor: ["rgba(0, 123, 255, 1)"],
				borderColor: ["rgba(0, 123, 255, 0)"],
				borderWidth: 1,
			},
		],
	},
	options: {
		scales: {
			y: {
				beginAtZero: true,
				// Added this line to remove the grid lines
				gridLines: {
					display: false,
				},
			},
		},
	},
});

document.addEventListener("DOMContentLoaded", function () {
	var timeFrameSelect = document.getElementById("timeFrameSelect");
	updateChartData(timeFrameSelect.value); // Update chart on page load with the default selected value

	timeFrameSelect.addEventListener("change", function () {
		updateChartData(this.value); // Update chart on selection change
	});
});

function updateChartData(timeFrame) {
	fetch(`http://localhost/sim_keuangan_toko/api/revenue?timeFrame=${timeFrame}`)
		.then((response) => response.json())
		.then((data) => {
			console.log(data); // Log data untuk debugging
			if (data.error) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: data.error,
				});
			} else {
				let labels = [];
				let datasetData = [];

				// Pastikan keys sesuai dengan yang dikirim dari API
				if (timeFrame === "daily") {
					labels = Object.keys(data.sales_per_day);
					datasetData = Object.values(data.sales_per_day);
				} else if (timeFrame === "monthly") {
					labels = Object.keys(data.sales_per_month);
					datasetData = Object.values(data.sales_per_month);
				} else if (timeFrame === "yearly") {
					labels = Object.keys(data.sales_per_year);
					datasetData = Object.values(data.sales_per_year);
				}

				myChart.data.labels = labels;
				myChart.data.datasets[0].data = datasetData; // Pastikan ini mengacu pada dataset yang benar
				myChart.update();
			}
		})
		.catch((error) => {
			console.error("Error fetching data: ", error);
			Swal.fire({
				icon: "error",
				title: "Failed!",
				text: "Failed to fetch data from API.",
			});
		});
}

function updateStatsLabels(label) {
	const salesLabel = document.querySelector(".sales-label");
	const revenueLabel = document.querySelector(".revenue-label");
	if (salesLabel && revenueLabel) {
		salesLabel.textContent = label;
		revenueLabel.textContent = label;
	}
}

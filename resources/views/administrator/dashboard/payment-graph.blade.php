<div>
    <canvas id="investmentChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('investmentChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: JSON.parse(`@json($paymentGraph['labels'])`).slice(-30).map(function(label) {
                return label.substring(2, 10);
            }),
            datasets: [{
                    label: 'Investment',
                    data: JSON.parse(`@json($paymentGraph['series'])`).slice(-30),
                    borderWidth: 1
                },
                {
                    label: 'Quantity',
                    data: JSON.parse(`@json($paymentGraph['count'])`).slice(-30),
                    borderWidth: 1,
                    hidden: true
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return formatNumberBangladeshi(value);
                        }
                    }
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';

                            if (label !== "Investment") {
                                return;
                            }

                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += formatNumberBangladeshi(context.parsed.y);
                            }

                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
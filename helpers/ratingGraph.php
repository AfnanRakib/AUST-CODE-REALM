    <div class="container-graph">
        <canvas id="ratingActivityGraph" width="400" height="300"></canvas>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('ratingActivityGraph').getContext('2d');

        const customBackgroundPlugin = {
            id: 'customBackground',
            beforeDraw: (chart) => {
                const { ctx, chartArea: { left, top, right, bottom, height, width }, scales: { y } } = chart;

                ctx.save();

                // Novice (Grey)
                ctx.fillStyle = '#80808033';
                ctx.fillRect(left, y.getPixelForValue(0), width, y.getPixelForValue(400) - y.getPixelForValue(0));

                // Specialist (Green)
                ctx.fillStyle = '#00800033';
                ctx.fillRect(left, y.getPixelForValue(400), width, y.getPixelForValue(800) - y.getPixelForValue(400));

                // Expert (Dull Cyan)
                ctx.fillStyle = '#88FFFF33';
                ctx.fillRect(left, y.getPixelForValue(800), width, y.getPixelForValue(1200) - y.getPixelForValue(800));

                // Master (Blue)
                ctx.fillStyle = '#0000FF33';
                ctx.fillRect(left, y.getPixelForValue(1200), width, y.getPixelForValue(1600) - y.getPixelForValue(1200));

                // Grandmaster (Purple)
                ctx.fillStyle = '#80008033';
                ctx.fillRect(left, y.getPixelForValue(1600), width, y.getPixelForValue(2400) - y.getPixelForValue(1600));

                ctx.restore();
            }
        };

        Chart.register(customBackgroundPlugin);

        // Data points with dates, ratings, and contest IDs
        const contestData = [
            { id: 'C001', date: '2022-10-01', rating: 0 },
            { id: 'C002', date: '2022-11-15', rating: 300 },
            { id: 'C003', date: '2022-12-10', rating: 450 },
            { id: 'C004', date: '2023-01-20', rating: 560 },
            { id: 'C005', date: '2023-02-25', rating: 600 },
            { id: 'C008', date: '2023-05-22', rating: 809 },
            { id: 'C009', date: '2023-06-27', rating: 911 },
            { id: 'C015', date: '2023-11-28', rating: 1189 },
            { id: 'C016', date: '2024-03-10', rating: 1145 },
            { id: 'C017', date: '2024-03-15', rating: 1200 },
            { id: 'C018', date: '2024-03-20', rating: 1255 },
            { id: 'C019', date: '2024-03-25', rating: 1306 },
            { id: 'C020', date: '2024-05-10', rating: 1289 },
            { id: 'C021', date: '2024-06-20', rating: 1255 },
            { id: 'C022', date: '2024-07-25', rating: 1306 },
            { id: 'C023', date: '2024-08-10', rating: 1289 },
            { id: 'C018', date: '2024-09-20', rating: 1255 },
            { id: 'C019', date: '2024-10-25', rating: 1306 },
            { id: 'C020', date: '2025-12-10', rating: 1289 }
        ];

        const labels = contestData.map(data => data.date);
        const ratings = contestData.map(data => data.rating);

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'AfnanRakib',
                    data: ratings,
                    borderColor: '#FFD700', // Yellow
                    backgroundColor: 'rgba(255, 215, 0, 0.2)', // Yellow fill
                    borderWidth: 2,
                    fill: true,
                    pointBackgroundColor: 'black' // Yellow points
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 0,
                        max: 2400,
                        ticks: {
                            stepSize: 200,
                        },
                    },
                    x: {
                        type: 'time',
                        time: {
                            unit: 'month',
                            displayFormats: {
                                month: 'MMM yyyy'
                            }
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 8
                        }
                    }
                },
                plugins: {
                    customBackground: true,
                    tooltip: {
                        callbacks: {
                            title: (tooltipItems) => {
                                const item = tooltipItems[0];
                                const data = contestData[item.dataIndex];
                                return `Contest ID: ${data.id}`;
                            },
                            label: (tooltipItem) => {
                                const data = contestData[tooltipItem.dataIndex];
                                return `Rating: ${data.rating}, Date: ${new Date(data.date).toLocaleDateString('default', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                            }
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            generateLabels: function(chart) {
                                return [
                                    {
                                        text: 'Novice',
                                        fillStyle: '#808080',
                                        strokeStyle: '#808080'
                                    },
                                    {
                                        text: 'Specialist',
                                        fillStyle: '#008000',
                                        strokeStyle: '#008000'
                                    },
                                    {
                                        text: 'Expert',
                                        fillStyle: '#88FFFF',
                                        strokeStyle: '#88FFFF'
                                    },
                                    {
                                        text: 'Master',
                                        fillStyle: '#0000FF',
                                        strokeStyle: '#0000FF'
                                    },
                                    {
                                        text: 'Grandmaster',
                                        fillStyle: '#800080',
                                        strokeStyle: '#800080'
                                    }
                                ];
                            }
                        }
                    }
                }
            }
        });
    });
    </script>

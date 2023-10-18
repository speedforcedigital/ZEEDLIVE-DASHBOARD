// Import Chart.js
import {
  Chart, PieController, ArcElement, TimeScale, Tooltip,
} from 'chart.js';
import 'chartjs-adapter-moment';

// Import utilities
import { tailwindConfig } from '../utils';

Chart.register(PieController, ArcElement, TimeScale, Tooltip);

// A chart built with Chart.js 3
// https://www.chartjs.org/
const fintechCard09 = () => {
  const ctx = document.getElementById('fintech-card-09');
  if (!ctx) return;

  fetch('')
    .then(a => {
      return a.json();
    })
    .then(result => {

        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Buy Now', 'Auctions', 'Live Streams'],
                datasets: [
                    {
                        label: 'Sale Amount',
                        data: result.data,
                        backgroundColor: [
                            '#34d399',
                            '#fbbf24',
                            '#6366f1',
                        ],
                        hoverBackgroundColor: [
                            '#10b981',
                            '#f59e0b',
                            '#4f46e5',
                        ],
                        borderWidth: 0,
                    },
                ],
            },
            options: {
                layout: {
                    padding: {
                        top: 4,
                        bottom: 4,
                        left: 24,
                        right: 24,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                    },
                    htmlLegend: {
                        // ID of the container to put the legend in
                        containerID: 'fintech-card-09-legend',
                    },
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest',
                },
                animation: {
                    duration: 200,
                },
                maintainAspectRatio: false,
            },
            plugins: [{
                id: 'htmlLegend',
                // ... (unchanged)
            }],
        });
    });
};

export default fintechCard09;

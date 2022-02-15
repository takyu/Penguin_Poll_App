import Chart from 'chart.js/auto';
import { nodeOps } from './nodeOps.js';

export function pollChart() {
  const $chart = nodeOps.qs('#chart');

  if (!$chart) {
    return;
  }

  const ctx = $chart.getContext('2d');

  const count_likes = $chart.dataset.likes;
  const count_dislikes = $chart.dataset.dislikes;
  // const count_nei = $chart.dataset.neither;

  let data;

  if (count_likes == 0 && count_dislikes == 0 /* && count_nei == 0 */) {
    data = {
      labels: ['No votes yet.'],
      datasets: [
        {
          data: [1],
          backgroundColor: ['#696969'],
        },
      ],
    };
  } else {
    data = {
      labels: ['賛成', '反対'],
      datasets: [
        {
          data: [count_likes, count_dislikes],
          // backgroundColor: ['#34d399', '#f87171', '#dcdcdc'],
          backgroundColor: ['#34d399', '#f87171'],
        },
      ],
    };
  }

  new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
      plugins: {
        title: {
          display: true,
          text: '賛成？反対？',
        },
        legend: {
          position: 'bottom',
        },
      },
    },
  });
}

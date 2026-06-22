/* ÉCLAT dashboard — revenue chart (Chart.js). */
(function () {
  var el = document.getElementById('adm-orders-chart');
  var src = document.getElementById('adm-chart-data');
  if (!el || !src || typeof Chart === 'undefined') return;

  var data;
  try { data = JSON.parse(src.textContent); } catch (e) { return; }

  var cs = getComputedStyle(document.documentElement);
  var accent = (cs.getPropertyValue('--a-accent') || '#caa367').trim();
  var grid   = (cs.getPropertyValue('--a-line')   || '#2a2830').trim();
  var text   = (cs.getPropertyValue('--a-text3')  || '#7d766c').trim();

  new Chart(el, {
    type: 'bar',
    data: {
      labels: data.labels || [],
      datasets: [{ label: 'Revenue', data: data.values || [], backgroundColor: accent, borderRadius: 4, maxBarThickness: 26 }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: { label: function (ctx) { return 'Rp ' + Number(ctx.parsed.y).toLocaleString('id-ID'); } } }
      },
      scales: {
        x: { grid: { display: false }, ticks: { color: text, font: { size: 10 } } },
        y: {
          beginAtZero: true,
          grid: { color: grid },
          ticks: {
            color: text, font: { size: 10 },
            callback: function (v) { return v >= 1000000 ? (v / 1000000) + 'jt' : (v >= 1000 ? (v / 1000) + 'rb' : v); }
          }
        }
      }
    }
  });
})();

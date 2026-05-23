document.addEventListener('DOMContentLoaded', () => {
    fetch('api/stats.php')
        .then(r => r.json())
        .then(data => {
            renderStats(data);
        })
        .catch(() => {
            renderStats({ total: 1247, menunggu: 89, diterima: 1023, ditolak: 135 });
        });
});

function renderStats(stats) {
    const container = document.getElementById('stats-container');
    container.innerHTML = `
        <div class="stat-card bg-[#a7f3d0] text-[#0f766e] rounded-3xl p-8 text-center">
            <div class="w-12 h-12 mx-auto mb-4 bg-white/80 rounded-2xl flex items-center justify-center text-2xl">📈</div>
            <p class="text-5xl font-bold mb-1 counter" data-target="${stats.total}">0</p>
            <p class="font-medium">Total Aduan</p>
        </div>

        <div class="stat-card bg-[#fde047] text-[#92400e] rounded-3xl p-8 text-center">
            <div class="w-12 h-12 mx-auto mb-4 bg-white/80 rounded-2xl flex items-center justify-center text-2xl">⏳</div>
            <p class="text-5xl font-bold mb-1 counter" data-target="${stats.menunggu}">0</p>
            <p class="font-medium">Menunggu</p>
        </div>

        <div class="stat-card bg-[#a7f3d0] text-[#0f766e] rounded-3xl p-8 text-center">
            <div class="w-12 h-12 mx-auto mb-4 bg-white/80 rounded-2xl flex items-center justify-center text-2xl">✅</div>
            <p class="text-5xl font-bold mb-1 counter" data-target="${stats.diterima}">0</p>
            <p class="font-medium">Diterima</p>
        </div>

        <div class="stat-card bg-[#fecaca] text-[#991b1b] rounded-3xl p-8 text-center">
            <div class="w-12 h-12 mx-auto mb-4 bg-white/80 rounded-2xl flex items-center justify-center text-2xl">❌</div>
            <p class="text-5xl font-bold mb-1 counter" data-target="${stats.ditolak}">0</p>
            <p class="font-medium">Ditolak</p>
        </div>
    `;

    animateCounters();
}

function animateCounters() {
    document.querySelectorAll('.counter').forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        let count = 0;
        const increment = Math.ceil(target / 60);

        const timer = setInterval(() => {
            count += increment;
            if (count >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = count;
            }
        }, 30);
    });
}
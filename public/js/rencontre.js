
function filterJeu(jeu, event) {
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    const sections = document.querySelectorAll('.jeu-section');
    if (jeu === 'all') {
        sections.forEach(s => s.style.display = 'block');
    } else {
        sections.forEach(s => {
            s.style.display = (s.dataset.jeu === jeu) ? 'block' : 'none';
        });
    }
}

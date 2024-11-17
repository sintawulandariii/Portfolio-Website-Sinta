// scripts.js
document.querySelectorAll('nav a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
// efek bayangan kartu education
const cardedu = document.querySelector('.cardedu');
card.addEventListener('click', () => {
    card.classList.toggle('active');
    setTimeout(() => {
        cardedu.classList.remove('active');
    }, 500);
});
//bayangan kartu skills
const card = document.querySelector('.card2');
//menambahkan bayangan saat kartu dihover
card.addEventListener('mouseover', function() {
    // Menambahkan bayangan yang mengarah ke kanan dan lebih besar
    card.style.boxShadow = '10px 10px 30px rgba(0, 0, 0, 0.3)';
});
//menghapus bayangan saat mouse keluar dari kartu
card.addEventListener('mouseout', function() {
// Menghapus bayangan dan kembali ke keadaan semula
    card.style.boxShadow = 'none';
});
//experience
window.addEventListener('scroll', function () {
    const cards = document.querySelectorAll('.card');
    const scrollPosition = window.scrollY + window.innerHeight;

    cards.forEach(function (card) {
        const cardPosition = card.getBoundingClientRect().top + window.scrollY;
        const cardHeight = card.offsetHeight;

        if (scrollPosition >= cardPosition + cardHeight * 0.2) {
            card.style.transition = 'transform 0.6s ease-out';
            card.style.transform = 'translateY(0)';
        } else {
            card.style.transition = 'none';
            card.style.transform = 'translateY(50px)';
        }
    });
});
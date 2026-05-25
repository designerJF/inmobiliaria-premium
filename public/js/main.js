document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            // Opcional: Bloquear el scroll del cuerpo cuando el menú está abierto
            document.body.classList.toggle('overflow-hidden');
        });
    }
});
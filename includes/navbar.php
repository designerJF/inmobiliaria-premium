<nav class="w-full bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-premium-border transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        
        <a href="index.php" class="text-xl font-medium tracking-[0.25em] uppercase text-premium-dark hover:opacity-80 transition">
            WowVision
        </a>

        <div class="hidden md:flex items-center space-x-10 text-[11px] tracking-[0.2em] uppercase font-medium text-premium-gray">
            <a href="index.php" class="text-premium-dark hover:text-premium-dark transition">Inicio</a>
            <a href="propiedades.php" class="hover:text-premium-dark transition">Propiedades</a>
            <a href="nosotros.php" class="hover:text-premium-dark transition">Nosotros</a>
            <a href="contacto.php" class="hover:text-premium-dark transition">Contacto</a>
        </div>

        <div class="md:hidden">
            <button id="menu-btn" class="text-premium-dark focus:outline-none p-2" aria-label="Abrir menú">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden fixed inset-x-0 top-20 bg-white border-b border-premium-border shadow-sm transition-all duration-300 z-40">
        <div class="flex flex-col px-6 py-8 space-y-6 text-xs tracking-[0.2em] uppercase font-medium text-premium-gray">
            <a href="index.php" class="text-premium-dark py-2 border-b border-premium-light">Inicio</a>
            <a href="propiedades.php" class="hover:text-premium-dark py-2 border-b border-premium-light">Propiedades</a>
            <a href="nosotros.php" class="hover:text-premium-dark py-2 border-b border-premium-light">Nosotros</a>
            <a href="contacto.php" class="hover:text-premium-dark py-2">Contacto</a>
        </div>
    </div>
</nav>
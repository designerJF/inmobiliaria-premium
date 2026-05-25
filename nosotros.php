<?php
$page_title = "Nuestra Firma";
$page_description = "Conozca la filosofía, visión y el estándar arquitectónico que define a WowVision Real Estate.";

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<main class="bg-white min-h-screen pb-24">
    
    <section class="max-w-4xl mx-auto px-6 pt-20 pb-16 text-center">
        <span class="text-[10px] uppercase tracking-[0.3em] font-semibold text-premium-gray mb-3 block">Desde 2025</span>
        <h1 class="font-editorial text-4xl md:text-6xl font-normal tracking-tight text-premium-dark leading-tight">
            Creando conexiones entre la arquitectura vanguardista y su estilo de vida.
        </h1>
    </section>

    <section class="max-w-7xl mx-auto px-6 mb-24">
        <div class="w-full h-[450px] overflow-hidden bg-premium-light">
            <img src="https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1600&q=80" 
                 alt="Detalle Arquitectónico WowVision" class="w-full h-full object-cover">
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
        <div class="space-y-6">
            <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-premium-gray block">Nuestra Filosofía</span>
            <h2 class="font-editorial text-2xl md:text-4xl font-normal text-premium-dark leading-snug">
                No buscamos metros cuadrados; seleccionamos intenciones espaciales.
            </h2>
        </div>
        <div class="text-premium-gray font-light text-sm leading-relaxed space-y-6">
            <p>
                En **WowVision**, entendemos que el mercado inmobiliario de alta gama exige más que transacciones comerciales estándar. Exige una profunda sensibilidad hacia el diseño contemporáneo, el uso honesto de la materialidad y la optimización de la luz natural.
            </p>
            <p>
                Cada propiedad integrada en nuestro catálogo pasa por una rigurosa curaduría. Nos aseguramos de que cada espacio ofrezca una experiencia habitacional distinguida y un valor de inversión atemporal en las zonas más exclusivas.
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 pt-24 mt-24 border-t border-premium-border/60">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="border border-premium-border p-8 bg-premium-light/30">
                <h3 class="font-sans text-xs uppercase tracking-[0.15em] font-semibold text-premium-dark mb-4">Misión</h3>
                <p class="text-xs text-premium-gray font-light leading-relaxed">
                    Proveer un servicio de asesoría inmobiliaria boutique, conectando a inversores y compradores exigentes con piezas arquitectónicas residenciales y comerciales que redefinen el lujo a través del minimalismo y la funcionalidad estricta.
                </p>
            </div>
            
            <div class="border border-premium-border p-8 bg-premium-light/30">
                <h3 class="font-sans text-xs uppercase tracking-[0.15em] font-semibold text-premium-dark mb-4">Visión</h3>
                <p class="text-xs text-premium-gray font-light leading-relaxed">
                    Consolidarnos como la firma referente de real estate premium en la región, reconocida por la digitalización impecable de nuestros servicios, la honestidad en cada consulta y la exclusividad absoluta de nuestras propiedades listadas.
                </p>
            </div>
        </div>
    </section>

</main>

<?php require_once 'includes/footer.php'; ?>
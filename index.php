<?php
$page_title = "Propiedades Exclusivas";
$page_description = "Encuentra residencias de lujo, villas minimalistas y apartamentos premium de diseño contemporáneo.";

require_once 'config/database.php';
require_once 'includes/helpers.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';

try {
    $stmt = $pdo->query("SELECT * FROM propiedades WHERE destacado = 1 ORDER BY id DESC LIMIT 3");
    $propiedades_destacadas = $stmt->fetchAll();
} catch (Exception $e) {
    $propiedades_destacadas = [];
}
?>

<section class="relative min-h-[85vh] flex items-center justify-center bg-premium-light overflow-hidden">
    
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1920&q=80" 
             alt="Residencia Contemporánea" 
             class="w-full h-full object-cover object-center transform scale-105 motion-safe:animate-[pulse_8s_ease-in-out_infinite]"
             style="animation-duration: 20s;">
        <div class="absolute inset-0 bg-gradient-to-r from-premium-dark/40 via-premium-dark/30 to-premium-dark/50 backdrop-blur-[1px]"></div>
    </div>

    <div class="relative z-10 max-w-5xl w-full mx-auto px-6 py-20 text-center text-white flex flex-col items-center">
        
        <span class="text-[11px] uppercase tracking-[0.3em] font-semibold text-white/90 mb-4 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/10">
            Colección Arquitectónica <?php echo date('Y'); ?>
        </span>
        
        <h1 class="font-editorial text-4xl md:text-6xl font-normal tracking-tight leading-[1.15] max-w-4xl mb-6">
            El arte de vivir en espacios <span class="italic font-light">atemporales</span>.
        </h1>
        
        <p class="text-sm md:text-base text-white/80 max-w-lg font-light tracking-wide mb-12 hidden sm:block">
            Residencias seleccionadas bajo los más altos estándares de diseño minimalista, ubicación y privacidad.
        </p>

        <div class="w-full max-w-4xl bg-white text-premium-dark p-4 md:p-6 shadow-2xl border border-premium-border/40 rounded-none md:rounded-xl">
            <form action="propiedades.php" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end text-left">
                
                <div class="flex flex-col space-y-2 border-b sm:border-b-0 sm:border-r border-premium-border pb-3 sm:pb-0 sm:pr-4">
                    <label class="text-[10px] uppercase tracking-[0.15em] font-semibold text-premium-gray">Ubicación</label>
                    <select name="ubicacion" class="w-full bg-transparent text-sm font-light focus:outline-none appearance-none cursor-pointer text-premium-dark py-1">
                        <option value="">Cualquier ubicación</option>
                        <option value="santo-domingo">Santo Domingo</option>
                        <option value="casa-de-campo">Casa de Campo</option>
                        <option value="las-terrenas">Las Terrenas</option>
                        <option value="punta-cana">Punta Cana</option>
                    </select>
                </div>

                <div class="flex flex-col space-y-2 border-b lg:border-b-0 lg:border-r border-premium-border pb-3 lg:pb-0 lg:pr-4">
                    <label class="text-[10px] uppercase tracking-[0.15em] font-semibold text-premium-gray">Tipo</label>
                    <select name="tipo" class="w-full bg-transparent text-sm font-light focus:outline-none appearance-none cursor-pointer text-premium-dark py-1">
                        <option value="">Todos los tipos</option>
                        <option value="villa">Villa de Lujo</option>
                        <option value="apartamento">Apartamento Penthouse</option>
                        <option value="estudio">Estudio Minimalista</option>
                    </select>
                </div>

                <div class="flex flex-col space-y-2 border-b sm:border-b-0 sm:border-r border-premium-border pb-3 sm:pb-0 sm:pr-4">
                    <label class="text-[10px] uppercase tracking-[0.15em] font-semibold text-premium-gray">Estado</label>
                    <select name="estado" class="w-full bg-transparent text-sm font-light focus:outline-none appearance-none cursor-pointer text-premium-dark py-1">
                        <option value="">Venta o Renta</option>
                        <option value="venta">En Venta</option>
                        <option value="alquiler">En Alquiler</option>
                    </select>
                </div>

                <div class="flex flex-col space-y-2 pb-3 sm:pb-0 sm:pr-2">
                    <label class="text-[10px] uppercase tracking-[0.15em] font-semibold text-premium-gray">Precio Máximo</label>
                    <select name="precio_max" class="w-full bg-transparent text-sm font-light focus:outline-none appearance-none cursor-pointer text-premium-dark py-1">
                        <option value="">Sin límite</option>
                        <option value="300000">$300,000 USD</option>
                        <option value="750000">$750,000 USD</option>
                        <option value="1500000">$1,500,000 USD</option>
                        <option value="3000000">$3,000,000 USD+</option>
                    </select>
                </div>

                <div class="pt-2 sm:pt-0">
                    <button type="submit" class="w-full btn-premium flex items-center justify-center gap-2 py-3.5 tracking-widest text-xs font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        BUSCAR
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-24 bg-white grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
    <div>
        <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-premium-gray mb-3 block">Curaduría de Excelencia</span>
        <h2 class="font-editorial text-3xl md:text-4xl font-normal tracking-tight text-premium-dark leading-tight mb-6">
            Redefiniendo los estándares de la búsqueda inmobiliaria digital.
        </h2>
    </div>
    <div class="text-premium-gray font-light text-sm leading-relaxed space-y-4">
        <p>
            No somos un catálogo masivo. Cada residencia listada en nuestra plataforma pasa por un estricto filtro de arquitectura, materialidad e integración con su entorno natural o urbano.
        </p>
        <p>
            Nuestra interfaz elimina las distracciones visuales comunes para permitirle enfocarse puramente en las proporciones, la luz y los detalles de su próxima inversión.
        </p>
    </div>
</section>

<section class="bg-white py-24 border-t border-premium-border/40">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-4">
            <div>
                <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-premium-gray mb-2 block">Curaduría Exclusiva</span>
                <h2 class="font-editorial text-3xl md:text-5xl font-normal tracking-tight">Obras Arquitectónicas</h2>
            </div>
            <a href="propiedades.php" class="text-xs uppercase tracking-widest font-medium border-b border-premium-dark pb-1 hover:text-premium-gray hover:border-premium-gray transition inline-block self-start md:self-auto">
                Ver toda la colección &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php if (!empty($propiedades_destacadas)): ?>
                <?php foreach ($propiedades_destacadas as $propiedad): ?>
                    <article class="group cursor-pointer flex flex-col h-full">
                        <a href="detalle.php?id=<?php echo $propiedad['id']; ?>" class="block overflow-hidden relative mb-4">
                            <span class="absolute top-4 left-4 z-10 bg-white/90 backdrop-blur-md text-premium-dark text-[9px] uppercase tracking-[0.15em] font-medium px-3 py-1 border border-premium-border/30">
                                En <?php echo ucfirst($propiedad['estado']); ?>
                            </span>
                            <img src="<?php echo $propiedad['imagen_principal']; ?>" 
                                 alt="<?php echo htmlspecialchars($propiedad['titulo']); ?>" 
                                 class="w-full h-[380px] object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                        </a>
                        
                        <div class="flex flex-col flex-grow">
                            <div class="flex justify-between items-start gap-4 mb-2">
                                <h3 class="font-sans text-base font-normal tracking-wide text-premium-dark group-hover:opacity-70 transition">
                                    <a href="detalle.php?id=<?php echo $propiedad['id']; ?>">
                                        <?php echo htmlspecialchars($propiedad['titulo']); ?>
                                    </a>
                                </h3>
                                <span class="font-serif text-base font-normal whitespace-nowrap">
                                    <?php echo formatearPrecio($propiedad['precio'], $propiedad['estado']); ?>
                                </span>
                            </div>
                            
                            <p class="text-xs text-premium-gray font-light tracking-wide mb-4">
                                <?php echo htmlspecialchars($propiedad['ubicacion_humana']); ?>
                            </p>
                            
                            <div class="mt-auto pt-4 border-t border-premium-border/60 flex items-center gap-6 text-[11px] text-premium-gray font-light uppercase tracking-wider">
                                <span class="flex items-center gap-1.5">
                                    <strong><?php echo $propiedad['habitaciones']; ?></strong> Hab
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <strong><?php echo $propiedad['banos']; ?></strong> Baños
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <strong><?php echo $propiedad['area_m2']; ?></strong> m²
                                </span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-premium-gray text-sm font-light col-span-full">No se han encontrado propiedades destacadas en este momento.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php 
require_once 'includes/footer.php'; 
?>
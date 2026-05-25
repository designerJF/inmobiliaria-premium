<?php
require_once 'config/database.php';
require_once 'includes/helpers.php';

// Validar que exista un ID válido en la URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: propiedades.php');
    exit;
}

// Consultar la propiedad específica de manera segura
try {
    $stmt = $pdo->prepare("SELECT * FROM propiedades WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $propiedad = $stmt->fetch();
    
    if (!$propiedad) {
        header('Location: propiedades.php');
        exit;
    }
    
    // Buscar propiedades relacionadas para el módulo inferior (Misma ubicación o tipo)
    $stmt_rel = $pdo->prepare("SELECT * FROM propiedades WHERE id != :id AND (ubicacion = :ubicacion OR tipo = :tipo) LIMIT 3");
    $stmt_rel->execute([
        'id' => $id,
        'ubicacion' => $propiedad['ubicacion'],
        'tipo' => $propiedad['tipo']
    ]);
    $relacionadas = $stmt_rel->fetchAll();

} catch (Exception $e) {
    die("Error al procesar la solicitud: " . $e->getMessage());
}

$page_title = $propiedad['titulo'];
$page_description = substr(strip_tags($propiedad['descripcion']), 0, 150) . '...';

require_once 'includes/header.php';
require_once 'includes/navbar.php';

// Definir mensaje personalizado automatizado para WhatsApp
$texto_whatsapp = rawurlencode("Hola, estoy interesado en la propiedad '" . $propiedad['titulo'] . "' listada en su web. Solicito más información. Ref ID: #" . $propiedad['id']);
$telefono_broker = "18095550199"; // Reemplazar por el número real del cliente de la firma
?>

<main class="bg-white min-h-screen pb-24">
    
    <section class="max-w-7xl mx-auto px-6 pt-12 pb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-premium-gray mb-2 block">
                Exclusividad en En <?php echo ucfirst($propiedad['estado']); ?>
            </span>
            <h1 class="font-editorial text-3xl md:text-5xl font-normal tracking-tight text-premium-dark mb-2">
                <?php echo htmlspecialchars($propiedad['titulo']); ?>
            </h1>
            <p class="text-xs md:text-sm text-premium-gray font-light tracking-wide">
                <?php echo htmlspecialchars($propiedad['ubicacion_humana']); ?>
            </p>
        </div>
        <div class="text-left md:text-right">
            <span class="text-[10px] uppercase tracking-[0.15em] text-premium-gray block mb-1">Valor de la Inversión</span>
            <span class="font-serif text-2xl md:text-4xl font-normal text-premium-dark">
                <?php echo formatearPrecio($propiedad['precio'], $propiedad['estado']); ?>
            </span>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-2 overflow-hidden bg-premium-light h-[400px] md:h-[600px]">
                <img src="<?php echo $propiedad['imagen_principal']; ?>" 
                     alt="Portada <?php echo htmlspecialchars($propiedad['titulo']); ?>" 
                     class="w-full h-full object-cover transition-transform duration-700 hover:scale-102">
            </div>
            
            <div class="hidden md:flex flex-col gap-4 h-[600px]">
                <div class="h-1/2 overflow-hidden bg-premium-light">
                    <img src="https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?auto=format&fit=crop&w=600&q=80" alt="Interior" class="w-full h-full object-cover">
                </div>
                <div class="h-1/2 overflow-hidden bg-premium-light relative">
                    <img src="https://images.unsplash.com/photo-1600566752355-35792bedcfea?auto=format&fit=crop&w=600&q=80" alt="Detalle" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-premium-dark/20 flex items-center justify-center">
                        <span class="text-white text-xs uppercase tracking-widest font-medium">Luz & Espacio</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
        
        <div class="lg:col-span-2 space-y-12">
            
            <div class="grid grid-cols-3 border-y border-premium-border py-6 text-center lg:text-left gap-4">
                <div>
                    <span class="block text-[10px] uppercase tracking-widest text-premium-gray mb-1">Dormitorios</span>
                    <span class="font-serif text-lg md:text-2xl text-premium-dark"><?php echo $propiedad['habitaciones']; ?></span>
                </div>
                <div class="border-x border-premium-border">
                    <span class="block text-[10px] uppercase tracking-widest text-premium-gray mb-1">Baños Completos</span>
                    <span class="font-serif text-lg md:text-2xl text-premium-dark"><?php echo $propiedad['banos']; ?></span>
                </div>
                <div>
                    <span class="block text-[10px] uppercase tracking-widest text-premium-gray mb-1">Área Total</span>
                    <span class="font-serif text-lg md:text-2xl text-premium-dark"><?php echo $propiedad['area_m2']; ?> <small class="text-xs font-sans">m²</small></span>
                </div>
            </div>

            <div>
                <h3 class="font-editorial text-xl font-normal text-premium-dark mb-4">Sobre esta Residencia</h3>
                <div class="text-premium-gray font-light text-sm leading-relaxed space-y-4">
                    <?php echo nl2br(htmlspecialchars($propiedad['descripcion'])); ?>
                </div>
            </div>

            <div class="pt-6">
                <h4 class="text-[11px] uppercase tracking-[0.15em] font-semibold text-premium-dark mb-6">Amenidades & Terminaciones</h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-8 text-xs font-light text-premium-gray">
                    <span class="flex items-center gap-2">&bull; Cocina de Diseño Abierto</span>
                    <span class="flex items-center gap-2">&bull; Seguridad 24/7 Controlada</span>
                    <span class="flex items-center gap-2">&bull; Climatización Central</span>
                    <span class="flex items-center gap-2">&bull; Pisos de Mármol / Cemento Pulido</span>
                    <span class="flex items-center gap-2">&bull; Terrazas Orientadas al Sol</span>
                    <span class="flex items-center gap-2">&bull; Estacionamiento Privado</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 bg-premium-light border border-premium-border p-8 sticky top-28 rounded-none md:rounded-lg">
            <h3 class="font-sans text-xs uppercase tracking-[0.15em] font-semibold text-premium-dark mb-2">¿Le interesa esta propiedad?</h3>
            <p class="text-xs font-light text-premium-gray leading-relaxed mb-6">
                Agende una visita privada presencial o una sesión de consultoría digital de manera inmediata directamente con nuestros asesores asignados.
            </p>
            
            <a href="https://wa.me/<?php echo $telefono_broker; ?>?text=<?php echo $texto_whatsapp; ?>" 
               target="_blank" 
               class="w-full btn-premium flex items-center justify-center gap-3 py-4 text-xs font-semibold tracking-widest rounded-none shadow-sm bg-[#111111] hover:bg-emerald-800 hover:border-emerald-800">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.713-1.455L0 24zm6.59-4.846c1.66.986 3.294 1.484 5.352 1.486 5.482 0 9.937-4.406 9.94-9.82.002-2.624-1.021-5.093-2.883-6.958C17.2 2.002 14.73 .979 12.012.979c-5.487 0-9.941 4.407-9.944 9.822-.002 2.017.514 3.702 1.517 5.358l-.993 3.626 3.754-.979z"/>
                </svg>
                CONTACTAR POR WHATSAPP
            </a>
            
            <div class="mt-4 text-center">
                <span class="text-[10px] text-premium-gray font-light uppercase tracking-wider">Respuesta estimada: < 15 minutos</span>
            </div>
        </div>
    </section>

    <?php if(!empty($relacionadas)): ?>
    <section class="max-w-7xl mx-auto px-6 pt-24 mt-24 border-t border-premium-border/60">
        <div class="mb-12">
            <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-premium-gray mb-2 block">Sugerencias del Sistema</span>
            <h3 class="font-editorial text-2xl md:text-3xl font-normal text-premium-dark">Propiedades de Perfil Similar</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php foreach($relacionadas as $rel): ?>
                <article class="group cursor-pointer flex flex-col h-full">
                    <a href="detalle.php?id=<?php echo $rel['id']; ?>" class="block overflow-hidden relative mb-4">
                        <img src="<?php echo $rel['imagen_principal']; ?>" alt="<?php echo htmlspecialchars($rel['titulo']); ?>" class="w-full h-[260px] object-cover transition-transform duration-700 group-hover:scale-105">
                    </a>
                    <div class="flex flex-col flex-grow">
                        <div class="flex justify-between items-start gap-4 mb-1">
                            <h4 class="font-sans text-sm font-normal tracking-wide text-premium-dark group-hover:opacity-70">
                                <a href="detalle.php?id=<?php echo $rel['id']; ?>"><?php echo htmlspecialchars($rel['titulo']); ?></a>
                            </h4>
                            <span class="font-serif text-sm whitespace-nowrap"><?php echo formatearPrecio($rel['precio'], $rel['estado']); ?></span>
                        </div>
                        <p class="text-[11px] text-premium-gray font-light"><?php echo htmlspecialchars($rel['ubicacion_humana']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</main>

<?php require_once 'includes/footer.php'; ?>
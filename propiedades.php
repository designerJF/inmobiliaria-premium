<?php
require_once 'config/database.php';
require_once 'includes/helpers.php';

$page_title = "Colección de Propiedades";
$page_description = "Filtre y explore nuestro catálogo selecto de bienes raíces exclusivos.";

// Captura de filtros desde la URL (GET)
$ubicacion = $_GET['ubicacion'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$estado = $_GET['estado'] ?? '';
$habitaciones = $_GET['habitaciones'] ?? '';
$orden = $_GET['orden'] ?? 'recientes';

// Construcción dinámica y segura de la consulta SQL
$sql = "SELECT * FROM propiedades WHERE 1=1";
$params = [];

if (!empty($ubicacion)) {
    $sql .= " AND ubicacion = :ubicacion";
    $params['ubicacion'] = $ubicacion;
}
if (!empty($tipo)) {
    $sql .= " AND tipo = :tipo";
    $params['tipo'] = $tipo;
}
if (!empty($estado)) {
    $sql .= " AND estado = :estado";
    $params['estado'] = $estado;
}
if (!empty($habitaciones)) {
    $sql .= " AND habitaciones = :habitaciones";
    $params['habitaciones'] = $habitaciones;
}

// Ordenamiento de registros
switch ($orden) {
    case 'precio_bajo':
        $sql .= " ORDER BY precio ASC";
        break;
    case 'precio_alto':
        $sql .= " ORDER BY precio DESC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
        break;
}

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $propiedades = $stmt->fetchAll();
} catch (Exception $e) {
    $propiedades = [];
}

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<main class="bg-white min-h-screen pt-12 pb-24">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="mb-12">
            <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-premium-gray mb-2 block">Catálogo Dinámico</span>
            <h1 class="font-editorial text-3xl md:text-5xl font-normal tracking-tight text-premium-dark">Explorar la Colección</h1>
        </div>

        <div class="bg-premium-light/50 border border-premium-border p-6 mb-12 rounded-lg">
            <form action="propiedades.php" method="GET" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end text-xs font-medium tracking-wide">
                
                <div>
                    <label class="block uppercase tracking-wider text-premium-gray mb-2">Ubicación</label>
                    <select name="ubicacion" class="w-full bg-white border border-premium-border p-2.5 rounded focus:outline-none focus:border-premium-dark text-premium-dark">
                        <option value="">Todas</option>
                        <option value="santo-domingo" <?php echo $ubicacion === 'santo-domingo' ? 'selected' : ''; ?>>Santo Domingo</option>
                        <option value="casa-de-campo" <?php echo $ubicacion === 'casa-de-campo' ? 'selected' : ''; ?>>Casa de Campo</option>
                        <option value="las-terrenas" <?php echo $ubicacion === 'las-terrenas' ? 'selected' : ''; ?>>Las Terrenas</option>
                        <option value="punta-cana" <?php echo $ubicacion === 'punta-cana' ? 'selected' : ''; ?>>Punta Cana</option>
                    </select>
                </div>

                <div>
                    <label class="block uppercase tracking-wider text-premium-gray mb-2">Tipo</label>
                    <select name="tipo" class="w-full bg-white border border-premium-border p-2.5 rounded focus:outline-none focus:border-premium-dark text-premium-dark">
                        <option value="">Todos</option>
                        <option value="villa" <?php echo $tipo === 'villa' ? 'selected' : ''; ?>>Villa de Lujo</option>
                        <option value="apartamento" <?php echo $tipo === 'apartamento' ? 'selected' : ''; ?>>Apartamento</option>
                    </select>
                </div>

                <div>
                    <label class="block uppercase tracking-wider text-premium-gray mb-2">Contrato</label>
                    <select name="estado" class="w-full bg-white border border-premium-border p-2.5 rounded focus:outline-none focus:border-premium-dark text-premium-dark">
                        <option value="">Cualquiera</option>
                        <option value="venta" <?php echo $estado === 'venta' ? 'selected' : ''; ?>>En Venta</option>
                        <option value="alquiler" <?php echo $estado === 'alquiler' ? 'selected' : ''; ?>>En Alquiler</option>
                    </select>
                </div>

                <div>
                    <label class="block uppercase tracking-wider text-premium-gray mb-2">Habitaciones</label>
                    <select name="habitaciones" class="w-full bg-white border border-premium-border p-2.5 rounded focus:outline-none focus:border-premium-dark text-premium-dark">
                        <option value="">Cualquiera</option>
                        <option value="2" <?php echo $habitaciones === '2' ? 'selected' : ''; ?>>2 Dormitorios</option>
                        <option value="3" <?php echo $habitaciones === '3' ? 'selected' : ''; ?>>3 Dormitorios</option>
                        <option value="4" <?php echo $habitaciones === '4' ? 'selected' : ''; ?>>4+ Dormitorios</option>
                    </select>
                </div>

                <div>
                    <label class="block uppercase tracking-wider text-premium-gray mb-2">Ordenar Por</label>
                    <select name="orden" class="w-full bg-white border border-premium-border p-2.5 rounded focus:outline-none focus:border-premium-dark text-premium-dark">
                        <option value="recientes" <?php echo $orden === 'recientes' ? 'selected' : ''; ?>>Más Recientes</option>
                        <option value="precio_bajo" <?php echo $orden === 'precio_bajo' ? 'selected' : ''; ?>>Precio: Menor a Mayor</option>
                        <option value="precio_alto" <?php echo $orden === 'precio_alto' ? 'selected' : ''; ?>>Precio: Mayor a Menor</option>
                    </select>
                </div>

                <div class="col-span-full flex justify-end gap-2 pt-2">
                    <a href="propiedades.php" class="btn-premium-outline text-center py-2.5 px-4 text-xs">Limpiar</a>
                    <button type="submit" class="btn-premium py-2.5 px-6 text-xs font-semibold">Aplicar Filtros</button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php if (!empty($propiedades)): ?>
                <?php foreach ($propiedades as $propiedad): ?>
                    <article class="group cursor-pointer flex flex-col h-full">
                        <a href="detalle.php?id=<?php echo $propiedad['id']; ?>" class="block overflow-hidden relative mb-4">
                            <span class="absolute top-4 left-4 z-10 bg-white/90 backdrop-blur-md text-premium-dark text-[9px] uppercase tracking-[0.15em] font-medium px-3 py-1 border border-premium-border/30">
                                En <?php echo ucfirst($propiedad['estado']); ?>
                            </span>
                            <img src="<?php echo $propiedad['imagen_principal']; ?>" alt="<?php echo htmlspecialchars($propiedad['titulo']); ?>" class="w-full h-[340px] object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                        </a>
                        
                        <div class="flex flex-col flex-grow">
                            <div class="flex justify-between items-start gap-4 mb-2">
                                <h3 class="font-sans text-base font-normal tracking-wide text-premium-dark group-hover:opacity-70 transition">
                                    <a href="detalle.php?id=<?php echo $propiedad['id']; ?>"><?php echo htmlspecialchars($propiedad['titulo']); ?></a>
                                </h3>
                                <span class="font-serif text-base font-normal whitespace-nowrap">
                                    <?php echo formatearPrecio($propiedad['precio'], $propiedad['estado']); ?>
                                </span>
                            </div>
                            <p class="text-xs text-premium-gray font-light tracking-wide mb-4"><?php echo htmlspecialchars($propiedad['ubicacion_humana']); ?></p>
                            
                            <div class="mt-auto pt-4 border-t border-premium-border/60 flex items-center gap-6 text-[11px] text-premium-gray font-light uppercase tracking-wider">
                                <span><strong><?php echo $propiedad['habitaciones']; ?></strong> Hab</span>
                                <span><strong><?php echo $propiedad['banos']; ?></strong> Baños</span>
                                <span><strong><?php echo $propiedad['area_m2']; ?></strong> m²</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-20 border border-dashed border-premium-border rounded">
                    <p class="text-premium-gray text-sm font-light">Ninguna propiedad coincide con los criterios de búsqueda seleccionados.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
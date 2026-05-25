<?php
session_start();
if (!isset($_SESSION['admin_autenticado']) || $_SESSION['admin_autenticado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$error = '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// 1. OBTENER LOS DATOS ACTUALES DE LA PROPIEDAD
try {
    $stmt = $pdo->prepare("SELECT * FROM propiedades WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $propiedad = $stmt->fetch();
    
    if (!$propiedad) {
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    die("Error al consultar la propiedad: " . $e->getMessage());
}

// 2. PROCESAR LA ACTUALIZACIÓN CUANDO SE ENVÍA EL FORMULARIO (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = (float)($_POST['precio'] ?? 0);
    $ubicacion = $_POST['ubicacion'] ?? '';
    $ubicacion_humana = $_POST['ubicacion_humana'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $habitaciones = (int)($_POST['habitaciones'] ?? 0);
    $banos = (int)($_POST['banos'] ?? 0);
    $area_m2 = (int)($_POST['area_m2'] ?? 0);
    $destacado = isset($_POST['destacado']) ? 1 : 0;
    
    // Mantener la ruta de la imagen actual por defecto
    $imagen_url = $propiedad['imagen_principal']; 
    
    // Si el usuario subió una nueva imagen, procesarla y reemplazar la anterior
    if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagen_principal']['tmp_name'];
        $fileName = $_FILES['imagen_principal']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../public/uploads/';
        $dest_path = $uploadFileDir . $newFileName;
        
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $imagen_url = 'public/uploads/' . $newFileName;
        } else {
            $error = 'Error al subir la nueva imagen.';
        }
    }

    if (empty($error)) {
        try {
            $sql = "UPDATE propiedades SET 
                        titulo = :titulo, 
                        descripcion = :descripcion, 
                        precio = :precio, 
                        ubicacion = :ubicacion, 
                        ubicacion_humana = :ubicacion_humana, 
                        tipo = :tipo, 
                        estado = :estado, 
                        habitaciones = :habitaciones, 
                        banos = :banos, 
                        area_m2 = :area_m2, 
                        imagen_principal = :imagen_principal, 
                        destacado = :destacado 
                    WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'ubicacion' => $ubicacion,
                'ubicacion_humana' => $ubicacion_humana,
                'tipo' => $tipo,
                'estado' => $estado,
                'habitaciones' => $habitaciones,
                'banos' => $banos,
                'area_m2' => $area_m2,
                'imagen_principal' => $imagen_url,
                'destacado' => $destacado,
                'id' => $id
            ]);
            
            header('Location: index.php?mensaje=actualizado');
            exit;
        } catch (Exception $e) {
            $error = 'Error al actualizar los datos: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Propiedad | WowVision Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F5F5F7] min-h-screen text-gray-950 font-sans py-12">

    <div class="max-w-3xl mx-auto bg-white p-8 border border-gray-200 shadow-sm">
        <div class="mb-8 border-b border-gray-100 pb-4">
            <a href="index.php" class="text-xs text-gray-400 hover:text-black transition">&larr; Cancelar y Volver</a>
            <h1 class="text-xl font-normal tracking-tight text-gray-900 mt-2">Editar Propiedad <span class="font-mono text-gray-400 text-sm">#<?php echo $propiedad['id']; ?></span></h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-600 p-4 text-xs mb-6 border border-red-100 font-medium">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="editar.php?id=<?php echo $propiedad['id']; ?>" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Título de la Propiedad</label>
                    <input type="text" name="titulo" required value="<?php echo htmlspecialchars($propiedad['titulo']); ?>" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Precio (USD)</label>
                    <input type="number" step="0.01" name="precio" required value="<?php echo $propiedad['precio']; ?>" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
            </div>

            <div>
                <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Descripción Corta / Atributos</label>
                <textarea name="descripcion" rows="5" required class="w-full border p-3 text-sm focus:outline-none focus:border-black"><?php echo htmlspecialchars($propiedad['descripcion']); ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Filtro Ubicación (Slug)</label>
                    <select name="ubicacion" required class="w-full border p-3 bg-white text-sm focus:outline-none focus:border-black">
                        <option value="punta-cana" <?php echo $propiedad['ubicacion'] === 'punta-cana' ? 'selected' : ''; ?>>Punta Cana</option>
                        <option value="santo-domingo" <?php echo $propiedad['ubicacion'] === 'santo-domingo' ? 'selected' : ''; ?>>Santo Domingo</option>
                        <option value="las-terrenas" <?php echo $propiedad['ubicacion'] === 'las-terrenas' ? 'selected' : ''; ?>>Las Terrenas</option>
                        <option value="casa-de-campo" <?php echo $propiedad['ubicacion'] === 'casa-de-campo' ? 'selected' : ''; ?>>Casa de Campo</option>
                    </select>
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Dirección Descriptiva (Texto Humano)</label>
                    <input type="text" name="ubicacion_humana" required value="<?php echo htmlspecialchars($propiedad['ubicacion_humana']); ?>" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Tipo de Propiedad</label>
                    <select name="tipo" required class="w-full border p-3 bg-white text-sm focus:outline-none focus:border-black">
                        <option value="villa" <?php echo $propiedad['tipo'] === 'villa' ? 'selected' : ''; ?>>Villa de Lujo</option>
                        <option value="apartamento" <?php echo $propiedad['tipo'] === 'apartamento' ? 'selected' : ''; ?>>Apartamento Penthouse</option>
                    </select>
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Estado del Contrato</label>
                    <select name="estado" required class="w-full border p-3 bg-white text-sm focus:outline-none focus:border-black">
                        <option value="venta" <?php echo $propiedad['estado'] === 'venta' ? 'selected' : ''; ?>>En Venta</option>
                        <option value="alquiler" <?php echo $propiedad['estado'] === 'alquiler' ? 'selected' : ''; ?>>En Alquiler</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Habitaciones</label>
                    <input type="number" name="habitaciones" value="<?php echo $propiedad['habitaciones']; ?>" min="0" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Baños</label>
                    <input type="number" name="banos" value="<?php echo $propiedad['banos']; ?>" min="0" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Área (m²)</label>
                    <input type="number" name="area_m2" value="<?php echo $propiedad['area_m2']; ?>" min="0" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
            </div>

            <div class="border border-gray-200 p-6 bg-gray-50 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <div>
                    <label class="block uppercase tracking-wider text-gray-600 mb-2 font-medium">Imagen Actual</label>
                    <img src="<?php echo (strpos($propiedad['imagen_principal'], 'http') === 0) ? $propiedad['imagen_principal'] : '../' . $propiedad['imagen_principal']; ?>" 
                         class="w-full h-24 object-cover border border-gray-200" alt="Portada actual">
                </div>
                <div class="md:col-span-2">
                    <label class="block uppercase tracking-wider text-gray-600 mb-2 font-medium">Reemplazar Imagen Portada</label>
                    <input type="file" name="imagen_principal" accept="image/*" class="text-sm text-gray-500">
                    <p class="text-[10px] text-gray-400 mt-1">Dejar vacío si desea conservar la foto actual.</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="destacado" id="destacado" class="w-4 h-4 accent-black" <?php echo $propiedad['destacado'] == 1 ? 'checked' : ''; ?>>
                <label for="destacado" class="uppercase tracking-wider text-gray-700 font-medium cursor-pointer">Destacar propiedad en la Página de Inicio</label>
            </div>

            <button type="submit" class="w-full bg-black text-white p-4 text-xs tracking-widest font-semibold uppercase hover:bg-gray-800 transition">
                GUARDAR CAMBIOS
            </button>
        </form>
    </div>

</body>
</html>
<?php
session_start();
if (!isset($_SESSION['admin_autenticado']) || $_SESSION['admin_autenticado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

$error = '';

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
    
    // LOGICA DE SUBIDA DE IMAGEN
    $imagen_url = 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c'; // Fallback por defecto
    
    if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagen_principal']['tmp_name'];
        $fileName = $_FILES['imagen_principal']['name'];
        
        // Generar un nombre único para evitar sobreescritura de archivos
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
        $uploadFileDir = '../public/uploads/';
        $dest_path = $uploadFileDir . $newFileName;
        
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            // Guardamos la ruta relativa que leerá el frontend público
            $imagen_url = 'public/uploads/' . $newFileName;
        } else {
            $error = 'Error al mover el archivo subido al directorio de destino.';
        }
    }

    if (empty($error)) {
        try {
            $sql = "INSERT INTO propiedades (titulo, descripcion, precio, ubicacion, ubicacion_humana, tipo, estado, habitaciones, banos, area_m2, imagen_principal, destacado) 
                    VALUES (:titulo, :descripcion, :precio, :ubicacion, :ubicacion_humana, :tipo, :estado, :habitaciones, :banos, :area_m2, :imagen_principal, :destacado)";
            
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
                'destacado' => $destacado
            ]);
            
            header('Location: index.php?mensaje=creado');
            exit;
        } catch (Exception $e) {
            $error = 'Error en la inserción de la base de datos: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Propiedad | WowVision</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F5F5F7] min-h-screen text-gray-950 font-sans py-12">

    <div class="max-w-3xl mx-auto bg-white p-8 border border-gray-200 shadow-sm">
        <div class="mb-8 border-b border-gray-100 pb-4">
            <a href="index.php" class="text-xs text-gray-400 hover:text-black transition">&larr; Volver al Listado</a>
            <h1 class="text-xl font-normal tracking-tight text-gray-900 mt-2">Registrar Nueva Propiedad</h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-600 p-4 text-xs mb-6 border border-red-100 font-medium">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="crear.php" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Título de la Propiedad</label>
                    <input type="text" name="titulo" required placeholder="Ej: Villa Wave" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Precio (USD)</label>
                    <input type="number" step="0.01" name="precio" required placeholder="Ej: 450000" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
            </div>

            <div>
                <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Descripción Corta / Atributos del Inmueble</label>
                <textarea name="descripcion" rows="5" required placeholder="Escriba los detalles arquitectónicos..." class="w-full border p-3 text-sm focus:outline-none focus:border-black"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Filtro Ubicación (Slug)</label>
                    <select name="ubicacion" required class="w-full border p-3 bg-white text-sm focus:outline-none focus:border-black">
                        <option value="punta-cana">Punta Cana</option>
                        <option value="santo-domingo">Santo Domingo</option>
                        <option value="las-terrenas">Las Terrenas</option>
                        <option value="casa-de-campo">Casa de Campo</option>
                    </select>
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Dirección Descriptiva (Texto Humano)</label>
                    <input type="text" name="ubicacion_humana" required placeholder="Ej: Piantini, Santo Domingo" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Tipo de Propiedad</label>
                    <select name="tipo" required class="w-full border p-3 bg-white text-sm focus:outline-none focus:border-black">
                        <option value="villa">Villa de Lujo</option>
                        <option value="apartamento">Apartamento Penthouse</option>
                    </select>
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Estado del Contrato</label>
                    <select name="estado" required class="w-full border p-3 bg-white text-sm focus:outline-none focus:border-black">
                        <option value="venta">En Venta</option>
                        <option value="alquiler">En Alquiler</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Habitaciones</label>
                    <input type="number" name="habitaciones" min="0" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Baños</label>
                    <input type="number" name="banos" min="0" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="block uppercase tracking-wider text-gray-500 mb-2 font-medium">Área (m²)</label>
                    <input type="number" name="area_m2" min="0" class="w-full border p-3 text-sm focus:outline-none focus:border-black">
                </div>
            </div>

            <div class="border border-dashed border-gray-300 p-6 bg-gray-50">
                <label class="block uppercase tracking-wider text-gray-600 mb-2 font-medium">Imagen Principal Portada</label>
                <input type="file" name="imagen_principal" accept="image/*" class="text-sm text-gray-500">
                <p class="text-[10px] text-gray-400 mt-2">Formatos admitidos: JPG, PNG, WEBP. Tamaño máximo sugerido: 2MB.</p>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="destacado" id="destacado" class="w-4 h-4 accent-black">
                <label Safe for inner HTML class for labeling checked input items for "destacado" field target items layout block for admin dashboard view forms logic structure for backend. for="destacado" class="uppercase tracking-wider text-gray-700 font-medium cursor-pointer">Destacar propiedad en la Página de Inicio</label>
            </div>

            <button type="submit" class="w-full bg-black text-white p-4 text-xs tracking-widest font-semibold uppercase hover:bg-gray-800 transition">
                PUBLICAR PROPIEDAD
            </button>
        </form>
    </div>

</body>
</html>
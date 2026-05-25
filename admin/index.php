<?php
session_start();
if (!isset($_SESSION['admin_autenticado']) || $_SESSION['admin_autenticado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';
require_once '../includes/helpers.php';

// Lógica para Eliminar Propiedad de forma segura si se solicita por URL
if (isset($_GET['eliminar'])) {
    $id_eliminar = (int)$_GET['eliminar'];
    if ($id_eliminar > 0) {
        $stmt = $pdo->prepare("DELETE FROM propiedades WHERE id = :id");
        $stmt->execute(['id' => $id_eliminar]);
        header('Location: index.php?mensaje=eliminado');
        exit;
    }
}

// Consultar el catálogo completo para listarlo en la tabla
$stmt = $pdo->query("SELECT id, titulo, precio, ubicacion_humana, tipo, estado, destacado FROM propiedades ORDER BY id DESC");
$propiedades = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control | WowVision</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F5F5F7] min-h-screen text-gray-950 font-sans">

    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="text-sm font-semibold tracking-[0.2em] uppercase">WowVision Admin</span>
                <span class="text-[10px] bg-gray-100 px-2 py-0.5 text-gray-500 rounded">v1.0 Nativo</span>
            </div>
            <a href="logout.php" class="text-xs text-red-600 hover:underline font-medium">Cerrar Sesión Panel</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-12">
        
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-10">
            <div>
                <h1 class="text-2xl font-normal tracking-tight">Gestión de Catálogo</h1>
                <p class="text-xs text-gray-500 font-light mt-1">Añada, modifique o elimine las propiedades de la plataforma.</p>
            </div>
            <a href="crear.php" class="inline-flex justify-center bg-black text-white px-5 py-2.5 text-xs tracking-widest font-semibold uppercase hover:bg-gray-800 transition">
                + NUEVA PROPIEDAD
            </a>
        </div>

        <?php if (isset($_GET['mensaje'])): ?>
            <div class="bg-emerald-50 text-emerald-700 p-4 text-xs mb-6 border border-emerald-100 font-medium">
                Operación realizada con éxito en la base de datos.
            </div>
        <?php endif; ?>

        <div class="bg-white border border-gray-200 overflow-x-auto shadow-sm">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-wider font-semibold border-b border-gray-200">
                        <th class="p-4">Ref ID</th>
                        <th class="p-4">Título</th>
                        <th class="p-4">Ubicación</th>
                        <th class="p-4">Tipo / Contrato</th>
                        <th class="p-4 text-right">Precio</th>
                        <th class="p-4 text-center">Destacado</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($propiedades)): ?>
                        <?php foreach ($propiedades as $prop): ?>
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="p-4 text-gray-400 font-mono">#<?php echo $prop['id']; ?></td>
                                <td class="p-4 font-medium text-gray-900"><?php echo htmlspecialchars($prop['titulo']); ?></td>
                                <td class="p-4 text-gray-500 font-light"><?php echo htmlspecialchars($prop['ubicacion_humana']); ?></td>
                                <td class="p-4 text-gray-500 font-light capitalize">
                                    <?php echo $prop['tipo']; ?> <span class="text-[10px] text-gray-400">/ <?php echo $prop['estado']; ?></span>
                                </td>
                                <td class="p-4 text-right font-medium text-gray-900">
                                    <?php echo formatearPrecio($prop['precio'], $prop['estado']); ?>
                                </td>
                                <td class="p-4 text-center">
                                    <?php echo $prop['destacado'] == 1 ? '<span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold border border-emerald-100">Sí</span>' : '<span class="text-gray-400 text-[10px]">No</span>'; ?>
                                </td>
                                <td class="p-4 text-center flex justify-center gap-4">
                                    <a href="editar.php?id=<?php echo $prop['id']; ?>" class="text-blue-600 hover:underline font-medium">Editar</a>
                                    <a href="index.php?eliminar=<?php echo $prop['id']; ?>" 
                                       onclick="return confirm('¿Está completamente seguro de eliminar esta propiedad? Esta acción no se puede deshacer.');" 
                                       class="text-red-600 hover:underline font-medium">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400 font-light">No hay registros en la base de datos actualmente.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="../index.php" target="_blank" class="text-xs text-gray-500 hover:text-black transition font-medium">&larr; Ver Sitio Web Público</a>
        </div>
    </main>

</body>
</html>
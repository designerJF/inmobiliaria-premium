<?php
session_start();

// Definimos la contraseña única de acceso administrativo
define('ADMIN_PASSWORD', 'WowVision2026'); 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    if ($password === ADMIN_PASSWORD) {
        $_SESSION['admin_autenticado'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Contraseña incorrecta. Inténtelo de nuevo.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Privado | Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F5F5F7] min-h-screen flex items-center justify-center font-sans antialiased">

    <div class="max-w-md w-full bg-white p-8 shadow-sm border border-gray-200">
        <div class="text-center mb-8">
            <span class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-semibold block mb-2">Internal System</span>
            <h1 class="text-xl font-medium tracking-[0.15em] uppercase text-gray-950">WowVision Admin</h1>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 text-red-600 p-3 text-xs mb-6 border border-red-100 font-medium">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-6">
            <div>
                <label class="block text-[10px] uppercase tracking-wider text-gray-500 font-medium mb-2">Contraseña de Entorno</label>
                <input type="password" name="password" required autofocus
                       class="w-full bg-transparent border border-gray-200 p-3 text-sm focus:outline-none focus:border-black transition text-gray-900">
            </div>

            <button type="submit" 
                    class="w-full bg-black text-white p-3 text-xs tracking-widest font-semibold uppercase transition hover:bg-gray-800">
                ENTRAR AL PANEL
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="../index.php" class="text-xs text-gray-400 hover:text-black transition">&larr; Volver a la web pública</a>
        </div>
    </div>

</body>
</html>
<?php
$page_title = "Contacto Privado";
$page_description = "Póngase en contacto con nuestros asesores para coordinar una reunión presencial o videollamada.";

require_once 'includes/header.php';
require_once 'includes/navbar.php';

$mensaje_exito = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí puedes enlazar un envío de correo nativo vía mail() o guardar en una tabla de leads.
    // Simulamos éxito para el frontend premium.
    $mensaje_exito = 'Agradecemos su comunicación. Un consultor se comunicará con usted en las próximas horas.';
}
?>

<main class="bg-white min-h-screen pb-24">
    
    <section class="max-w-7xl mx-auto px-6 pt-16 mb-12">
        <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-premium-gray mb-2 block">Agende una Sesión</span>
        <h1 class="font-editorial text-3xl md:text-5xl font-normal tracking-tight text-premium-dark">Canales de Comunicación</h1>
    </section>

    <section class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-16 items-start">
        
        <div class="lg:col-span-1 space-y-10 text-xs">
            <div>
                <h3 class="uppercase tracking-widest text-premium-gray font-semibold mb-3">Oficina Central</h3>
                <p class="text-premium-dark font-light leading-relaxed">
                    Av. Winston Churchill, Torre Blue Mall, Piso 14<br>
                    Santo Domingo, República Dominicana
                </p>
            </div>

            <div>
                <h3 class="uppercase tracking-widest text-premium-gray font-semibold mb-3">Atención Telefónica</h3>
                <p class="text-premium-dark font-light leading-relaxed">
                    Directo: +1 (809) 555-0199<br>
                    Broker Interno: +1 (809) 555-0155
                </p>
            </div>

            <div>
                <h3 class="uppercase tracking-widest text-premium-gray font-semibold mb-3">Consultas Digitales</h3>
                <p class="text-premium-dark font-light leading-relaxed">
                    General: info@wowvisionre.com<br>
                    Privado: legal@wowvisionre.com
                </p>
            </div>
        </div>

        <div class="lg:col-span-2 bg-premium-light/40 border border-premium-border p-8 rounded-none md:rounded-lg">
            
            <?php if (!empty($mensaje_exito)): ?>
                <div class="bg-emerald-50 text-emerald-700 p-4 text-xs mb-6 border border-emerald-100 font-medium">
                    <?php echo $mensaje_exito; ?>
                </div>
            <?php endif; ?>

            <form action="contacto.php" method="POST" class="space-y-6 text-xs">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block uppercase tracking-wider text-premium-gray font-medium mb-2">Nombre Completo</label>
                        <input type="text" name="nombre" required class="w-full bg-white border border-premium-border p-3 text-sm focus:outline-none focus:border-premium-dark transition">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wider text-premium-gray font-medium mb-2">Correo Electrónico</label>
                        <input type="email" name="email" required class="w-full bg-white border border-premium-border p-3 text-sm focus:outline-none focus:border-premium-dark transition">
                    </div>
                </div>

                <div>
                    <label class="block uppercase tracking-wider text-premium-gray font-medium mb-2">Asunto de la Solicitud</label>
                    <input type="text" name="asunto" required placeholder="Ej: Adquisición de Propiedad / Consulta Legal" class="w-full bg-white border border-premium-border p-3 text-sm focus:outline-none focus:border-premium-dark transition">
                </div>

                <div>
                    <label class="block uppercase tracking-wider text-premium-gray font-medium mb-2">Mensaje / Requerimientos Específicos</label>
                    <textarea name="mensaje" rows="6" required placeholder="Detalle las características de la propiedad de su interés..." class="w-full bg-white border border-premium-border p-3 text-sm focus:outline-none focus:border-premium-dark transition"></textarea>
                </div>

                <button type="submit" class="w-full btn-premium py-4 font-semibold tracking-widest text-center uppercase">
                    ENVIAR FORMULARIO PRIVADO
                </button>
            </form>
        </div>
    </section>

</main>

<?php require_once 'includes/footer.php'; ?>
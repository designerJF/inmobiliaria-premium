<?php
/**
 * Formatea un precio numérico al estándar premium de la plataforma.
 */
function formatearPrecio($precio, $estado) {
    $formato = '$' . number_format($precio, 0, '.', ',') . ' USD';
    return ($estado === 'alquiler') ? $formato . ' / mes' : $formato;
}

/**
 * Retorna el nombre legible de una ubicación basada en su slug.
 */
function limpiarSlug($slug) {
    return ucwords(str_replace('-', ' ', $slug));
}
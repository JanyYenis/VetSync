"use strict";

// Variables para el canvas de firma
let canvas, ctx;
let dibujando = false;
let ultimoX = 0;
let ultimoY = 0;

$(function () {
    iniciarComponentes();
});

const iniciarComponentes = (form = "") => {
    window.inicializarCanvasFirma();

    // Firma
    $('#btnLimpiarFirma').on('click', function() {
        window.limpiarCanvas();
        $('#firmaGuardada').addClass('d-none');
        $('#canvasFirma').removeClass('d-none');
    });

    $('#btnGuardarFirma').on('click', guardarFirma);
}

// =====================
// CANVAS DE FIRMA
// =====================

/**
 * Inicializa el canvas para la firma electrónica
 */
window.inicializarCanvasFirma = () => {
    canvas = document.getElementById('canvasFirma');
    ctx = canvas.getContext('2d');

    // Configurar el contexto
    ctx.strokeStyle = '#1e3a8a';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    // Limpiar canvas
    window.limpiarCanvas();

    // Eventos de mouse
    canvas.addEventListener('mousedown', iniciarDibujo);
    canvas.addEventListener('mousemove', dibujar);
    canvas.addEventListener('mouseup', detenerDibujo);
    canvas.addEventListener('mouseout', detenerDibujo);

    // Eventos táctiles para dispositivos móviles
    canvas.addEventListener('touchstart', iniciarDibujoTouch);
    canvas.addEventListener('touchmove', dibujarTouch);
    canvas.addEventListener('touchend', detenerDibujo);
}

/**
 * Limpia el canvas de firma
 */
window.limpiarCanvas = () => {
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Línea base para firma
    ctx.strokeStyle = '#e2e8f0';
    ctx.lineWidth = 1;
    ctx.beginPath();
    ctx.moveTo(20, canvas.height - 30);
    ctx.lineTo(canvas.width - 20, canvas.height - 30);
    ctx.stroke();

    // Restaurar configuración
    ctx.strokeStyle = '#1e3a8a';
    ctx.lineWidth = 2;
}

/**
 * Obtiene las coordenadas del mouse relativas al canvas
 */
window.obtenerCoordenadas = (e) => {
    const rect = canvas.getBoundingClientRect();
    return {
        x: e.clientX - rect.left,
        y: e.clientY - rect.top
    };
}

/**
 * Inicia el dibujo en el canvas
 */
window.iniciarDibujo = (e) => {
    dibujando = true;
    const coords = window.obtenerCoordenadas(e);
    ultimoX = coords.x;
    ultimoY = coords.y;
}

/**
 * Dibuja en el canvas mientras se mueve el mouse
 */
window.dibujar = (e) => {
    if (!dibujando) return;

    const coords = window.obtenerCoordenadas(e);

    ctx.beginPath();
    ctx.moveTo(ultimoX, ultimoY);
    ctx.lineTo(coords.x, coords.y);
    ctx.stroke();

    ultimoX = coords.x;
    ultimoY = coords.y;
}

/**
 * Detiene el dibujo
 */
window.detenerDibujo = () => {
    dibujando = false;
}

/**
 * Inicia el dibujo táctil
 */
window.iniciarDibujoTouch = (e) => {
    e.preventDefault();
    const touch = e.touches[0];
    const rect = canvas.getBoundingClientRect();

    dibujando = true;
    ultimoX = touch.clientX - rect.left;
    ultimoY = touch.clientY - rect.top;
}

/**
 * Dibuja con touch
 */
window.dibujarTouch = (e) => {
    e.preventDefault();
    if (!dibujando) return;

    const touch = e.touches[0];
    const rect = canvas.getBoundingClientRect();
    const x = touch.clientX - rect.left;
    const y = touch.clientY - rect.top;

    ctx.beginPath();
    ctx.moveTo(ultimoX, ultimoY);
    ctx.lineTo(x, y);
    ctx.stroke();

    ultimoX = x;
    ultimoY = y;
}

// =====================
// FIRMA ELECTRÓNICA
// =====================

/**
 * Guarda la firma del canvas como imagen
 */
function guardarFirma() {
    const dataURL = canvas.toDataURL('image/png');
    historiaActual.firma = dataURL;

    $('#firmaGuardada').attr('src', dataURL).removeClass('d-none');
    $('#canvasFirma').addClass('d-none');

    generalidades.toastrGenerico('success', 'Firma guardada correctamente.');
}

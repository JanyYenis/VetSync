/**
 * ========================================
 * HISTORIA CLÍNICA VETERINARIA - JavaScript
 * Sistema CRUD completo con firma electrónica
 * ========================================
 */

// =====================
// DATOS SIMULADOS
// =====================

const mascotas = [
    {
        id: 1,
        nombre: "Max",
        especie: "Perro",
        raza: "Labrador Retriever",
        edad: "5 años",
        sexo: "Macho",
        color: "Dorado",
        peso: 32.5,
        propietario: {
            nombre: "Juan Carlos Pérez",
            telefono: "3001234567",
            email: "juanperez@email.com",
            direccion: "Calle 123 #45-67, Bogotá"
        },
        antecedentes: {
            vacunaRabia: "2024-01-15",
            vacunaParvovirus: "2024-01-15",
            vacunaMoquillo: "2024-01-15",
            desparasitacionInterna: "2024-03-10",
            desparasitacionExterna: "2024-03-10",
            alergias: "Ninguna conocida",
            enfermedadesCronicas: "Ninguna"
        }
    },
    {
        id: 2,
        nombre: "Luna",
        especie: "Gato",
        raza: "Siamés",
        edad: "3 años",
        sexo: "Hembra",
        color: "Crema con puntos oscuros",
        peso: 4.2,
        propietario: {
            nombre: "María García López",
            telefono: "3109876543",
            email: "mariagarcia@email.com",
            direccion: "Carrera 50 #20-30, Medellín"
        },
        antecedentes: {
            vacunaRabia: "2024-02-20",
            vacunaParvovirus: "",
            vacunaMoquillo: "",
            desparasitacionInterna: "2024-04-05",
            desparasitacionExterna: "2024-04-05",
            alergias: "Alergia al pollo",
            enfermedadesCronicas: "Ninguna"
        }
    },
    {
        id: 3,
        nombre: "Rocky",
        especie: "Perro",
        raza: "Bulldog Francés",
        edad: "2 años",
        sexo: "Macho",
        color: "Atigrado",
        peso: 12.8,
        propietario: {
            nombre: "Carlos Andrés Rodríguez",
            telefono: "3205551234",
            email: "carlos.rodriguez@email.com",
            direccion: "Avenida 30 #15-45, Cali"
        },
        antecedentes: {
            vacunaRabia: "2023-12-01",
            vacunaParvovirus: "2023-12-01",
            vacunaMoquillo: "2023-12-01",
            desparasitacionInterna: "2024-02-15",
            desparasitacionExterna: "2024-02-15",
            alergias: "Sensibilidad en piel",
            enfermedadesCronicas: "Problemas respiratorios leves"
        }
    },
    {
        id: 4,
        nombre: "Mía",
        especie: "Gato",
        raza: "Persa",
        edad: "4 años",
        sexo: "Hembra",
        color: "Blanco",
        peso: 5.1,
        propietario: {
            nombre: "Ana Sofía Martínez",
            telefono: "3156667788",
            email: "anasofia.m@email.com",
            direccion: "Calle 80 #10-20, Barranquilla"
        },
        antecedentes: {
            vacunaRabia: "2024-03-01",
            vacunaParvovirus: "",
            vacunaMoquillo: "",
            desparasitacionInterna: "2024-03-01",
            desparasitacionExterna: "2024-03-01",
            alergias: "Ninguna conocida",
            enfermedadesCronicas: "Ninguna"
        }
    },
    {
        id: 5,
        nombre: "Thor",
        especie: "Perro",
        raza: "Pastor Alemán",
        edad: "6 años",
        sexo: "Macho",
        color: "Negro y marrón",
        peso: 38.0,
        propietario: {
            nombre: "Roberto Hernández",
            telefono: "3187779900",
            email: "roberto.h@email.com",
            direccion: "Transversal 25 #45-60, Bucaramanga"
        },
        antecedentes: {
            vacunaRabia: "2024-01-20",
            vacunaParvovirus: "2024-01-20",
            vacunaMoquillo: "2024-01-20",
            desparasitacionInterna: "2024-04-10",
            desparasitacionExterna: "2024-04-10",
            alergias: "Ninguna conocida",
            enfermedadesCronicas: "Displasia de cadera leve"
        }
    }
];

// =====================
// VARIABLES GLOBALES
// =====================

let historiaActual = {
    numeroHistoria: '',
    fechaCreacion: '',
    mascotaId: null,
    datosMascota: {},
    datosPropietario: {},
    antecedentes: {},
    historialClinico: [],
    firma: null,
    nombreVeterinario: '',
    matriculaVeterinario: '',
    observacionesGenerales: ''
};

let historiasGuardadas = [];
let editandoConsultaIndex = null;
let eliminandoTipo = null;
let eliminandoIndice = null;

// // Variables para el canvas de firma
// let canvas, ctx;
// let dibujando = false;
// let ultimoX = 0;
// let ultimoY = 0;

// =====================
// INICIALIZACIÓN
// =====================

$(document).ready(function() {
    // Cargar historias guardadas del localStorage
    cargarHistoriasDeStorage();

    // Inicializar componentes
    // inicializarCanvasFirma();
    generarNumeroHistoria();

    // Event listeners
    configurarEventListeners();
});

/**
 * Carga las historias clínicas guardadas en localStorage
 */
function cargarHistoriasDeStorage() {
    const guardadas = localStorage.getItem('historiasClinicas');
    if (guardadas) {
        historiasGuardadas = JSON.parse(guardadas);
    }
}

/**
 * Guarda las historias clínicas en localStorage
 */
function guardarHistoriasEnStorage() {
    localStorage.setItem('historiasClinicas', JSON.stringify(historiasGuardadas));
}

/**
 * Genera un número de historia clínica único
 */
function generarNumeroHistoria() {
    const timestamp = Date.now().toString().slice(-6);
    const numero = `HC-${timestamp}`;
    $('#numeroHistoria').val(numero);
    historiaActual.numeroHistoria = numero;
}

// // =====================
// // CANVAS DE FIRMA
// // =====================

// /**
//  * Inicializa el canvas para la firma electrónica
//  */
// function inicializarCanvasFirma() {
//     canvas = document.getElementById('canvasFirma');
//     ctx = canvas.getContext('2d');

//     // Configurar el contexto
//     ctx.strokeStyle = '#1e3a8a';
//     ctx.lineWidth = 2;
//     ctx.lineCap = 'round';
//     ctx.lineJoin = 'round';

//     // Limpiar canvas
//     limpiarCanvas();

//     // Eventos de mouse
//     canvas.addEventListener('mousedown', iniciarDibujo);
//     canvas.addEventListener('mousemove', dibujar);
//     canvas.addEventListener('mouseup', detenerDibujo);
//     canvas.addEventListener('mouseout', detenerDibujo);

//     // Eventos táctiles para dispositivos móviles
//     canvas.addEventListener('touchstart', iniciarDibujoTouch);
//     canvas.addEventListener('touchmove', dibujarTouch);
//     canvas.addEventListener('touchend', detenerDibujo);
// }

// /**
//  * Limpia el canvas de firma
//  */
// function limpiarCanvas() {
//     ctx.fillStyle = '#ffffff';
//     ctx.fillRect(0, 0, canvas.width, canvas.height);

//     // Línea base para firma
//     ctx.strokeStyle = '#e2e8f0';
//     ctx.lineWidth = 1;
//     ctx.beginPath();
//     ctx.moveTo(20, canvas.height - 30);
//     ctx.lineTo(canvas.width - 20, canvas.height - 30);
//     ctx.stroke();

//     // Restaurar configuración
//     ctx.strokeStyle = '#1e3a8a';
//     ctx.lineWidth = 2;
// }

// /**
//  * Obtiene las coordenadas del mouse relativas al canvas
//  */
// function obtenerCoordenadas(e) {
//     const rect = canvas.getBoundingClientRect();
//     return {
//         x: e.clientX - rect.left,
//         y: e.clientY - rect.top
//     };
// }

// /**
//  * Inicia el dibujo en el canvas
//  */
// function iniciarDibujo(e) {
//     dibujando = true;
//     const coords = obtenerCoordenadas(e);
//     ultimoX = coords.x;
//     ultimoY = coords.y;
// }

// /**
//  * Dibuja en el canvas mientras se mueve el mouse
//  */
// function dibujar(e) {
//     if (!dibujando) return;

//     const coords = obtenerCoordenadas(e);

//     ctx.beginPath();
//     ctx.moveTo(ultimoX, ultimoY);
//     ctx.lineTo(coords.x, coords.y);
//     ctx.stroke();

//     ultimoX = coords.x;
//     ultimoY = coords.y;
// }

// /**
//  * Detiene el dibujo
//  */
// function detenerDibujo() {
//     dibujando = false;
// }

// /**
//  * Inicia el dibujo táctil
//  */
// function iniciarDibujoTouch(e) {
//     e.preventDefault();
//     const touch = e.touches[0];
//     const rect = canvas.getBoundingClientRect();

//     dibujando = true;
//     ultimoX = touch.clientX - rect.left;
//     ultimoY = touch.clientY - rect.top;
// }

// /**
//  * Dibuja con touch
//  */
// function dibujarTouch(e) {
//     e.preventDefault();
//     if (!dibujando) return;

//     const touch = e.touches[0];
//     const rect = canvas.getBoundingClientRect();
//     const x = touch.clientX - rect.left;
//     const y = touch.clientY - rect.top;

//     ctx.beginPath();
//     ctx.moveTo(ultimoX, ultimoY);
//     ctx.lineTo(x, y);
//     ctx.stroke();

//     ultimoX = x;
//     ultimoY = y;
// }

// =====================
// EVENT LISTENERS
// =====================

/**
 * Configura todos los event listeners de la aplicación
 */
function configurarEventListeners() {
    // Nueva historia
    $('#btnNuevaHistoria').on('click', nuevaHistoriaClinica);

    // // Listar historias
    // $('#btnListarHistorias').on('click', mostrarListaHistorias);

    // // Historial clínico (CRUD)
    // $('#btnAgregarConsulta').on('click', abrirModalNuevaConsulta);
    // $('#btnGuardarConsulta').on('click', guardarConsulta);

    // // Firma
    // $('#btnLimpiarFirma').on('click', function() {
    //     limpiarCanvas();
    //     $('#firmaGuardada').addClass('d-none');
    //     $('#canvasFirma').removeClass('d-none');
    // });

    // $('#btnGuardarFirma').on('click', guardarFirma);

    // Acciones principales
    // $('#btnGuardarHistoria').on('click', guardarHistoriaClinica);
    $('#btnImprimir').on('click', imprimirHistoria);
    $('#btnExportarPDF').on('click', exportarPDF);

    // // Confirmación de eliminación
    // $('#btnConfirmarEliminar').on('click', ejecutarEliminacion);
}

// =====================
// FUNCIONES CRUD
// =====================

/**
 * Crea una nueva historia clínica en blanco
 */
function nuevaHistoriaClinica() {
    // Limpiar todos los campos
    $('#selectMascota').val('');
    $('#btnCargarMascota').prop('disabled', true);

    // Limpiar datos de mascota
    $('#nombreMascota, #razaMascota, #edadMascota, #colorMascota, #pesoMascota').val('');
    $('#especieMascota, #sexoMascota').val('');

    // Limpiar datos de propietario
    $('#nombrePropietario, #telefonoPropietario, #emailPropietario, #direccionPropietario').val('');

    // Limpiar antecedentes
    $('#vacunaRabia, #vacunaParvovirus, #vacunaMoquillo').val('');
    $('#desparasitacionInterna, #desparasitacionExterna').val('');
    $('#alergias, #enfermedadesCronicas').val('');

    // Limpiar historial
    historiaActual.historialClinico = [];
    actualizarTablaHistorial();

    // // Limpiar firma
    // limpiarCanvas();
    // $('#firmaGuardada').addClass('d-none');
    // $('#canvasFirma').removeClass('d-none');
    $('#nombreVeterinario, #matriculaVeterinario').val('');

    // Limpiar observaciones
    $('#observacionesGenerales').val('');

    // Reiniciar historia actual
    historiaActual = {
        numeroHistoria: '',
        fechaCreacion: '',
        mascotaId: null,
        datosMascota: {},
        datosPropietario: {},
        antecedentes: {},
        historialClinico: [],
        firma: null,
        nombreVeterinario: '',
        matriculaVeterinario: '',
        observacionesGenerales: ''
    };

    // Generar nuevo número
    generarNumeroHistoria();

    mostrarAlerta('info', 'Nueva historia clínica iniciada. Complete los datos requeridos.');
}

// /**
//  * Abre el modal para agregar nueva consulta
//  */
// function abrirModalNuevaConsulta() {
//     editandoConsultaIndex = null;
//     $('#modalConsultaTitulo').html('<i class="bi bi-plus-circle me-2"></i>Agregar Consulta');
//     $('#formConsulta')[0].reset();
//     $('#consultaFecha').val(new Date().toISOString().split('T')[0]);
//     $('#consultaVeterinario').val($('#nombreVeterinario').val());

//     const modal = new bootstrap.Modal(document.getElementById('modalConsulta'));
//     modal.show();
// }

// /**
//  * Abre el modal para editar una consulta existente
//  */
// function editarConsulta(index) {
//     editandoConsultaIndex = index;
//     const consulta = historiaActual.historialClinico[index];

//     $('#modalConsultaTitulo').html('<i class="bi bi-pencil me-2"></i>Editar Consulta');
//     $('#consultaFecha').val(consulta.fecha);
//     $('#consultaMotivo').val(consulta.motivo);
//     $('#consultaDiagnostico').val(consulta.diagnostico);
//     $('#consultaTratamiento').val(consulta.tratamiento);
//     $('#consultaVeterinario').val(consulta.veterinario);

//     const modal = new bootstrap.Modal(document.getElementById('modalConsulta'));
//     modal.show();
// }

// /**
//  * Guarda una consulta (nueva o editada)
//  */
// function guardarConsulta() {
//     const fecha = $('#consultaFecha').val();
//     const motivo = $('#consultaMotivo').val().trim();
//     const veterinario = $('#consultaVeterinario').val().trim();

//     // Validación
//     if (!fecha || !motivo || !veterinario) {
//         mostrarAlerta('danger', 'Por favor complete los campos obligatorios (Fecha, Motivo, Veterinario).');
//         return;
//     }

//     const consulta = {
//         fecha: fecha,
//         motivo: motivo,
//         diagnostico: $('#consultaDiagnostico').val().trim(),
//         tratamiento: $('#consultaTratamiento').val().trim(),
//         veterinario: veterinario
//     };

//     if (editandoConsultaIndex !== null) {
//         // Editar existente
//         historiaActual.historialClinico[editandoConsultaIndex] = consulta;
//         mostrarAlerta('success', 'Consulta actualizada correctamente.');
//     } else {
//         // Agregar nueva
//         historiaActual.historialClinico.push(consulta);
//         mostrarAlerta('success', 'Consulta agregada correctamente.');
//     }

//     actualizarTablaHistorial();
//     bootstrap.Modal.getInstance(document.getElementById('modalConsulta')).hide();
// }

// /**
//  * Prepara la eliminación de una consulta
//  */
// function prepararEliminarConsulta(index) {
//     eliminandoTipo = 'consulta';
//     eliminandoIndice = index;
//     $('#mensajeConfirmacion').text('¿Está seguro de eliminar esta consulta del historial?');

//     const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
//     modal.show();
// }

/**
 * Prepara la eliminación de una historia clínica
 */
function prepararEliminarHistoria(index) {
    eliminandoTipo = 'historia';
    eliminandoIndice = index;
    $('#mensajeConfirmacion').text('¿Está seguro de eliminar esta historia clínica? Esta acción no se puede deshacer.');

    const modal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
    modal.show();
}

/**
 * Ejecuta la eliminación confirmada
 */
function ejecutarEliminacion() {
    if (eliminandoTipo === 'consulta') {
        historiaActual.historialClinico.splice(eliminandoIndice, 1);
        actualizarTablaHistorial();
        mostrarAlerta('success', 'Consulta eliminada correctamente.');
    } else if (eliminandoTipo === 'historia') {
        historiasGuardadas.splice(eliminandoIndice, 1);
        guardarHistoriasEnStorage();
        mostrarListaHistorias();
        mostrarAlerta('success', 'Historia clínica eliminada correctamente.');
    }

    bootstrap.Modal.getInstance(document.getElementById('modalConfirmarEliminar')).hide();
    eliminandoTipo = null;
    eliminandoIndice = null;
}

// /**
//  * Actualiza la tabla del historial clínico
//  */
// function actualizarTablaHistorial() {
//     const tbody = $('#tbodyHistorial');
//     tbody.empty();

//     if (historiaActual.historialClinico.length === 0) {
//         $('#mensajeSinConsultas').show();
//         return;
//     }

//     $('#mensajeSinConsultas').hide();

//     historiaActual.historialClinico.forEach((consulta, index) => {
//         const fechaFormateada = formatearFecha(consulta.fecha);
//         const fila = `
//             <tr>
//                 <td>${fechaFormateada}</td>
//                 <td>${consulta.motivo}</td>
//                 <td>${consulta.diagnostico || '-'}</td>
//                 <td>${consulta.tratamiento || '-'}</td>
//                 <td>${consulta.veterinario}</td>
//                 <td class="no-print">
//                     <button class="btn btn-sm btn-outline-primary me-1" onclick="editarConsulta(${index})" title="Editar">
//                         <i class="bi bi-pencil"></i>
//                     </button>
//                     <button class="btn btn-sm btn-outline-danger" onclick="prepararEliminarConsulta(${index})" title="Eliminar">
//                         <i class="bi bi-trash"></i>
//                     </button>
//                 </td>
//             </tr>
//         `;
//         tbody.append(fila);
//     });
// }

// // =====================
// // FIRMA ELECTRÓNICA
// // =====================

// /**
//  * Guarda la firma del canvas como imagen
//  */
// function guardarFirma() {
//     const dataURL = canvas.toDataURL('image/png');
//     historiaActual.firma = dataURL;

//     $('#firmaGuardada').attr('src', dataURL).removeClass('d-none');
//     $('#canvasFirma').addClass('d-none');

//     mostrarAlerta('success', 'Firma guardada correctamente.');
// }

// =====================
// GUARDAR HISTORIA
// =====================

/**
 * Valida y guarda la historia clínica completa
 */
function guardarHistoriaClinica() {
    // Validaciones básicas
    const nombreMascota = $('#nombreMascota').val().trim();
    const nombrePropietario = $('#nombrePropietario').val().trim();

    if (!nombreMascota) {
        mostrarAlerta('danger', 'Por favor ingrese el nombre de la mascota.');
        $('#nombreMascota').focus();
        return;
    }

    if (!nombrePropietario) {
        mostrarAlerta('danger', 'Por favor ingrese el nombre del propietario.');
        $('#nombrePropietario').focus();
        return;
    }

    // Recopilar todos los datos
    historiaActual.fechaCreacion = $('#fechaCreacion').val();
    historiaActual.numeroHistoria = $('#numeroHistoria').val();

    historiaActual.datosMascota = {
        nombre: nombreMascota,
        especie: $('#especieMascota').val(),
        raza: $('#razaMascota').val(),
        edad: $('#edadMascota').val(),
        sexo: $('#sexoMascota').val(),
        color: $('#colorMascota').val(),
        peso: $('#pesoMascota').val()
    };

    historiaActual.datosPropietario = {
        nombre: nombrePropietario,
        telefono: $('#telefonoPropietario').val(),
        email: $('#emailPropietario').val(),
        direccion: $('#direccionPropietario').val()
    };

    historiaActual.antecedentes = {
        vacunaRabia: $('#vacunaRabia').val(),
        vacunaParvovirus: $('#vacunaParvovirus').val(),
        vacunaMoquillo: $('#vacunaMoquillo').val(),
        desparasitacionInterna: $('#desparasitacionInterna').val(),
        desparasitacionExterna: $('#desparasitacionExterna').val(),
        alergias: $('#alergias').val(),
        enfermedadesCronicas: $('#enfermedadesCronicas').val()
    };

    historiaActual.nombreVeterinario = $('#nombreVeterinario').val();
    historiaActual.matriculaVeterinario = $('#matriculaVeterinario').val();
    historiaActual.observacionesGenerales = $('#observacionesGenerales').val();

    // Verificar si ya existe esta historia (para actualizar)
    const indexExistente = historiasGuardadas.findIndex(h => h.numeroHistoria === historiaActual.numeroHistoria);

    if (indexExistente >= 0) {
        historiasGuardadas[indexExistente] = { ...historiaActual };
        mostrarAlerta('success', `Historia clínica ${historiaActual.numeroHistoria} actualizada correctamente.`);
    } else {
        historiasGuardadas.push({ ...historiaActual });
        mostrarAlerta('success', `Historia clínica ${historiaActual.numeroHistoria} guardada correctamente.`);
    }

    guardarHistoriasEnStorage();
}

// =====================
// LISTAR Y CARGAR HISTORIAS
// =====================

// /**
//  * Muestra el modal con la lista de historias guardadas
//  */
// function mostrarListaHistorias() {
//     const tbody = $('#tbodyListaHistorias');
//     tbody.empty();

//     if (historiasGuardadas.length === 0) {
//         $('#mensajeSinHistorias').show();
//     } else {
//         $('#mensajeSinHistorias').hide();

//         historiasGuardadas.forEach((historia, index) => {
//             const fechaFormateada = formatearFecha(historia.fechaCreacion);
//             const numConsultas = historia.historialClinico ? historia.historialClinico.length : 0;

//             const fila = `
//                 <tr>
//                     <td><strong>${historia.numeroHistoria}</strong></td>
//                     <td>${historia.datosMascota.nombre} (${historia.datosMascota.especie || 'N/A'})</td>
//                     <td>${historia.datosPropietario.nombre}</td>
//                     <td>${fechaFormateada}</td>
//                     <td><span class="badge bg-primary badge-consultas">${numConsultas}</span></td>
//                     <td>
//                         <button class="btn btn-sm btn-primary me-1 cargarHistoria" data-id="${index}" title="Cargar">
//                             <i class="bi bi-folder2-open"></i>
//                         </button>
//                         <button class="btn btn-sm btn-danger" onclick="prepararEliminarHistoria(${index})" title="Eliminar">
//                             <i class="bi bi-trash"></i>
//                         </button>
//                     </td>
//                 </tr>
//             `;
//             tbody.append(fila);
//         });
//     }

//     const modal = new bootstrap.Modal(document.getElementById('modalListaHistorias'));
//     modal.show();
// }

$(document).on('click', '.cargarHistoria', function() {
    cargarHistoria($(this).attr('data-id'));
});

/**
 * Carga una historia clínica guardada
 */
function cargarHistoria(index) {
    const historia = historiasGuardadas[index];
    historiaActual = { ...historia };

    // Cargar datos en el formulario
    $('#fechaCreacion').val(historia.fechaCreacion);
    $('#numeroHistoria').val(historia.numeroHistoria);

    // Datos de mascota
    $('#nombreMascota').val(historia.datosMascota.nombre);
    $('#especieMascota').val(historia.datosMascota.especie);
    $('#razaMascota').val(historia.datosMascota.raza);
    $('#edadMascota').val(historia.datosMascota.edad);
    $('#sexoMascota').val(historia.datosMascota.sexo);
    $('#colorMascota').val(historia.datosMascota.color);
    $('#pesoMascota').val(historia.datosMascota.peso);

    // Datos de propietario
    $('#nombrePropietario').val(historia.datosPropietario.nombre);
    $('#telefonoPropietario').val(historia.datosPropietario.telefono);
    $('#emailPropietario').val(historia.datosPropietario.email);
    $('#direccionPropietario').val(historia.datosPropietario.direccion);

    // Antecedentes
    if (historia.antecedentes) {
        $('#vacunaRabia').val(historia.antecedentes.vacunaRabia);
        $('#vacunaParvovirus').val(historia.antecedentes.vacunaParvovirus);
        $('#vacunaMoquillo').val(historia.antecedentes.vacunaMoquillo);
        $('#desparasitacionInterna').val(historia.antecedentes.desparasitacionInterna);
        $('#desparasitacionExterna').val(historia.antecedentes.desparasitacionExterna);
        $('#alergias').val(historia.antecedentes.alergias);
        $('#enfermedadesCronicas').val(historia.antecedentes.enfermedadesCronicas);
    }

    // Historial clínico
    historiaActual.historialClinico = historia.historialClinico || [];
    actualizarTablaHistorial();

    // Firma
    if (historia.firma) {
        $('#firmaGuardada').attr('src', historia.firma).removeClass('d-none');
        $('#canvasFirma').addClass('d-none');
    } else {
        limpiarCanvas();
        $('#firmaGuardada').addClass('d-none');
        $('#canvasFirma').removeClass('d-none');
    }

    $('#nombreVeterinario').val(historia.nombreVeterinario || '');
    $('#matriculaVeterinario').val(historia.matriculaVeterinario || '');
    $('#observacionesGenerales').val(historia.observacionesGenerales || '');

    // Cerrar modal
    bootstrap.Modal.getInstance(document.getElementById('modalListaHistorias')).hide();

    mostrarAlerta('info', `Historia clínica ${historia.numeroHistoria} cargada correctamente.`);
}

// =====================
// IMPRESIÓN
// =====================

/**
 * Imprime la historia clínica
 */
function imprimirHistoria() {
    window.print();
}

// =====================
// EXPORTAR A PDF
// =====================

/**
 * Exporta la historia clínica a PDF usando jsPDF y html2canvas
 */
function exportarPDF() {
    mostrarAlerta('info', 'Generando PDF, por favor espere...');

    const documento = document.getElementById('documentoHistoria');

    // Ocultar elementos no imprimibles temporalmente
    const elementosOcultar = document.querySelectorAll('.no-print');
    elementosOcultar.forEach(el => el.style.display = 'none');

    // Mostrar firma si existe
    if (historiaActual.firma) {
        $('#firmaGuardada').removeClass('d-none');
        $('#canvasFirma').addClass('d-none');
    }

    html2canvas(documento, {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#ffffff'
    }).then(canvas => {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'letter');

        const imgWidth = 216; // Letter width in mm
        const pageHeight = 279; // Letter height in mm
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        let heightLeft = imgHeight;
        let position = 0;

        const imgData = canvas.toDataURL('image/png');

        // Primera página
        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        // Páginas adicionales si es necesario
        while (heightLeft > 0) {
            position = heightLeft - imgHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        // Nombre del archivo
        const nombreArchivo = `Historia_Clinica_${historiaActual.numeroHistoria || 'Nueva'}.pdf`;
        pdf.save(nombreArchivo);

        // Restaurar elementos ocultos
        elementosOcultar.forEach(el => el.style.display = '');

        mostrarAlerta('success', 'PDF exportado correctamente.');
    }).catch(error => {
        console.error('Error al generar PDF:', error);
        mostrarAlerta('danger', 'Error al generar el PDF. Por favor intente nuevamente.');

        // Restaurar elementos ocultos
        elementosOcultar.forEach(el => el.style.display = '');
    });
}

// =====================
// UTILIDADES
// =====================

/**
 * Muestra una alerta en el contenedor de alertas
 */
function mostrarAlerta(tipo, mensaje) {
    const iconos = {
        success: 'bi-check-circle-fill',
        danger: 'bi-x-circle-fill',
        info: 'bi-info-circle-fill',
        warning: 'bi-exclamation-triangle-fill'
    };

    const alerta = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            <i class="bi ${iconos[tipo]} me-2"></i>
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    $('#alertContainer').html(alerta);

    // Auto-cerrar después de 5 segundos
    setTimeout(() => {
        $('#alertContainer .alert').alert('close');
    }, 5000);
}

/**
 * Formatea una fecha ISO a formato legible
 */
function formatearFecha(fechaISO) {
    if (!fechaISO) return '-';

    const fecha = new Date(fechaISO + 'T00:00:00');
    const opciones = { day: '2-digit', month: '2-digit', year: 'numeric' };
    return fecha.toLocaleDateString('es-ES', opciones);
}

import Generalidades from '../generalidades.js'; // ES Modules

// Máscaras y variables globales
Generalidades.prototype.MASK_CORREO_INSTITUCIONAL = "*{1,}[.*{1,}][.*{1,}][.*{1,}]@usc.edu.co";
Generalidades.prototype.terminosBuscados = {};

// Repeater genérico
Generalidades.prototype.repeaterGenerico = function (id, initEmpty = false, prependItems = true, defaultValues = {}, callbackAgregado = null, callbackEliminado = null) {
    $(id).repeater({
        initEmpty,
        defaultValues,
        prependItems,
        show() {
            $(this).slideDown("slow");
            if (callbackAgregado && typeof callbackAgregado === "function") callbackAgregado(this);
        },
        hide(deleteElement) {
            $(this).slideUp(deleteElement, function () {
                if (callbackEliminado && typeof callbackEliminado === "function") callbackEliminado(this);
            });
        }
    });
}

// TouchSpin genérico
Generalidades.prototype.touchSpinGenerico = function (element, prefix = "#", minimo = 1, maximo = 100) {
    $(element).TouchSpin({
        buttondown_class: "btn btn-secondary",
        buttonup_class: "btn btn-secondary",
        min: minimo,
        max: maximo,
        stepinterval: 50,
        maxboostedstep: 10000000,
        prefix,
        firstclickvalueifempty: minimo
    });
}

// Mask sitio web
Generalidades.prototype.maskSitioWeb = function (element, mask = null) {
    if (!mask) mask = "*{1,}[.*{1,}][.*{1,}][.*{1,3}]";
    $(element).inputmask({
        mask,
        greedy: false,
        definitions: {
            '*': { validator: "[0-9A-Za-z!#$%&'*+:/=?^_`{|}~-]", cardinality: 1, casing: "lower" }
        }
    });
}

// Funciones de intl-tel-input
Generalidades.prototype.darTelefonoInput = function (elemento) {
    const input = document.querySelector(elemento);
    return input ? window.intlTelInputGlobals.getInstance(input) : null;
}

Generalidades.prototype.darCodigoInput = function (elemento) {
    const input = document.querySelector(elemento);
    return input ? window.intlTelInput(input).getSelectedCountryData() : null;
}

Generalidades.prototype.initTelefonoInput = function (elemento, config = null) {
    config ??= { initialCountry: 'CO', preferredCountries: ["CO", "US"] };
    const input = document.querySelector(elemento);
    return input ? window.intlTelInput(input, config) : null;
}

// Reemplazar ruta
Generalidades.prototype.reemplazarRuta = function (ruta, parametro, valor) {
    return ruta.replace(parametro, valor);
}

// Buscar en DataTable
Generalidades.prototype.buscarEnListado = function (dataTable, filtro) {
    const dt = $(dataTable).DataTable();
    $(filtro).each(function () {
        dt.column($(this).closest("th").index())
          .search($.fn.DataTable.ext.type.search.string($(this).val()));
    });
    dt.draw();
}

// Selectpicker
Generalidades.prototype.reiniciarSelectpicker = function (elemento) {
    $(elemento).val("default").selectpicker("refresh");
}

// Tooltip
Generalidades.prototype.refrescarTooltip = function (elemento) {
    if ($('.bs-tooltip-top').find('show')) $('.bs-tooltip-top').remove();
    $(elemento).tooltip('update');
}

// SweetAlert genérico
Generalidades.prototype.mensajeSwal = function (validaciones, type = 'error', title = 'Error', footer = null, accionConfirmar = null, mostrarCancelar = false, accionCancelar = null) {
    if (!validaciones) return;

    let html = typeof validaciones === "object" ? Object.values(validaciones).map(v => `<li>${v}</li>`).join('') : validaciones;

    const configSwal = {
        type, title, html, footer,
        focusConfirm: accionConfirmar ? false : undefined,
        confirmButtonText: accionConfirmar ? '<i class="fa fa-check"></i> Confirmar' : undefined,
        confirmButtonAriaLabel: accionConfirmar ? 'Confirmar' : undefined,
        showCloseButton: mostrarCancelar ? true : undefined,
        showCancelButton: mostrarCancelar ? true : undefined,
        cancelButtonText: mostrarCancelar ? '<i class="fa fa-times"></i> Cancelar' : undefined,
        cancelButtonAriaLabel: mostrarCancelar ? 'Cancelar' : undefined
    };

    swal.fire(configSwal).then(resultado => {
        if (resultado.value && accionConfirmar) accionConfirmar();
        else if (!resultado.value && accionCancelar) accionCancelar();
    });
}

// Capitalizar string
Generalidades.prototype.initcap = function (str) {
    return str.toLowerCase().split(' ').map(word => word[0].toUpperCase() + word.substr(1)).join(' ');
}

// Primer item seleccionado en Select2
Generalidades.prototype.darPrimerItemSelecionadoSelect2 = function (selector) {
    const select = $(selector).select2("data");
    return select ? select.shift() : null;
}

// Ventana emergente
Generalidades.prototype.ventanaEmergente = function (ruta, titulo = null, configuracion = null) {
    if (!configuracion) {
        const width = window.screen.width, height = window.screen.height;
        configuracion = {
            width: width / 2,
            height,
            menubar: 0, toolbar: 0,
            scrollbars: "no",
            resizable: "no",
            left: parseInt(width / 4),
            top: parseInt(height / 4)
        };
    }
    let configStr = Object.entries(configuracion).map(([k,v], i, arr) => `${k}=${v}`).join(',');
    return window.open(ruta, titulo, configStr);
}

// Summernote
Generalidades.prototype.limpiarSummernote = function (elemento) {
    $(elemento).summernote('code', null);
}

Generalidades.prototype.summernoteGenerico = function (idSummernote, altura = 150, toolbar = null, limCaracteres = null, claseCaracteres = null, onChange = null) {
    $(idSummernote).summernote("destroy");
    toolbar ??= [["style", ["bold","italic","underline","clear"]], ["fontname", ["fontname"]], ["fontsize", ["fontsize"]],
                 ["color", ["color"]], ["table", ["table"]], ["para", ["ul","ol","paragraph"]], ["height", ["height"]],
                 ["insert", ["link"]], ["view", ["fullscreen","codeview"]], ["save", ["save"]]];
    $(idSummernote).summernote({ height: altura, lang: "es-ES", toolbar,
        callbacks: { onChange, onChangeCodeView: onChange } // Puedes agregar onKeydown/onKeyup/onPaste similar al anterior
    });
}

// Notificación
Generalidades.prototype.notificacion = function (opciones) {
    if (!("Notification" in window)) return console.error("Notificaciones no soportadas");
    if (Notification.permission === "default" || Notification.permission === "denied") {
        Notification.requestPermission().then(p => { if (p === "granted") this.notificacion(opciones); });
        return;
    }
    opciones = Object.assign({ lang:"es", silent:false, requireInteraction:false, icon:"/images/logoUSC.png" }, opciones);
    return new Notification(opciones.titulo, opciones);
}

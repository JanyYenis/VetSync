"use strict";

export default class Generalidades {
    constructor() {
        if ($.validator && $.validator.messages) {
            $.validator.messages.required = "";
        }
        this.token = $('meta[name="csrf-token"]').attr("content");
    }
}

// instancia global (como lo usabas antes)
window.generalidades = new Generalidades();

/* ========================================
   VetCare Pro - Data Store (Simulated)
   ======================================== */

// Initialize data from localStorage or use defaults
const VetData = {
    // Clientes
    clientes: JSON.parse(localStorage.getItem('vetcare_clientes')) || [
        { id: 1, nombre: 'María González', telefono: '+1 234 567 001', email: 'maria.gonzalez@email.com', direccion: 'Calle 123 #45-67' },
        { id: 2, nombre: 'Carlos Rodríguez', telefono: '+1 234 567 002', email: 'carlos.rodriguez@email.com', direccion: 'Av. Principal #89' },
        { id: 3, nombre: 'Ana Martínez', telefono: '+1 234 567 003', email: 'ana.martinez@email.com', direccion: 'Carrera 56 #12-34' },
        { id: 4, nombre: 'Pedro López', telefono: '+1 234 567 004', email: 'pedro.lopez@email.com', direccion: 'Calle 78 #90-12' },
        { id: 5, nombre: 'Laura Sánchez', telefono: '+1 234 567 005', email: 'laura.sanchez@email.com', direccion: 'Av. Norte #34-56' }
    ],

    // Mascotas
    mascotas: JSON.parse(localStorage.getItem('vetcare_mascotas')) || [
        { id: 1, nombre: 'Max', tipo: 'Perro', raza: 'Golden Retriever', edad: 3, peso: 32, clienteId: 1 },
        { id: 2, nombre: 'Luna', tipo: 'Gato', raza: 'Siamés', edad: 2, peso: 4, clienteId: 2 },
        { id: 3, nombre: 'Rocky', tipo: 'Perro', raza: 'Bulldog Francés', edad: 4, peso: 12, clienteId: 3 },
        { id: 4, nombre: 'Mia', tipo: 'Gato', raza: 'Persa', edad: 1, peso: 3.5, clienteId: 3 },
        { id: 5, nombre: 'Coco', tipo: 'Perro', raza: 'Chihuahua', edad: 5, peso: 2.5, clienteId: 3 },
        { id: 6, nombre: 'Simba', tipo: 'Gato', raza: 'Maine Coon', edad: 2, peso: 6, clienteId: 4 },
        { id: 7, nombre: 'Bella', tipo: 'Perro', raza: 'Labrador', edad: 6, peso: 28, clienteId: 5 },
        { id: 8, nombre: 'Toby', tipo: 'Perro', raza: 'Beagle', edad: 4, peso: 14, clienteId: 1 }
    ],

    // Historial Clínico
    historial: JSON.parse(localStorage.getItem('vetcare_historial')) || [
        { id: 1, mascotaId: 1, fecha: '2024-01-15', motivo: 'Consulta de rutina', diagnostico: 'Estado de salud óptimo', tratamiento: 'Desparasitación preventiva', observaciones: 'Próxima vacuna en 6 meses' },
        { id: 2, mascotaId: 2, fecha: '2024-01-18', motivo: 'Vómitos frecuentes', diagnostico: 'Gastritis leve', tratamiento: 'Dieta blanda y medicación por 5 días', observaciones: 'Control en 1 semana' },
        { id: 3, mascotaId: 3, fecha: '2024-01-20', motivo: 'Vacunación', diagnostico: 'Saludable', tratamiento: 'Vacuna polivalente aplicada', observaciones: 'Sin reacciones adversas' },
        { id: 4, mascotaId: 1, fecha: '2024-02-10', motivo: 'Cojea de pata trasera', diagnostico: 'Esguince leve', tratamiento: 'Reposo y antiinflamatorios', observaciones: 'Evitar ejercicio por 2 semanas' },
        { id: 5, mascotaId: 4, fecha: '2024-02-15', motivo: 'Control post-esterilización', diagnostico: 'Recuperación exitosa', tratamiento: 'Ninguno', observaciones: 'Retirar puntos en 3 días' }
    ],

    // Prescripciones
    prescripciones: JSON.parse(localStorage.getItem('vetcare_prescripciones')) || [
        { id: 1, mascotaId: 1, fecha: '2024-02-10', medicamentos: 'Meloxicam 0.1mg/kg - 1 vez al día por 7 días\nOmeprazol 1mg/kg - 1 vez al día por 7 días', indicaciones: 'Administrar con comida.\nMantener en reposo.\nEvitar actividad física intensa.', proximaCita: '2024-02-24' },
        { id: 2, mascotaId: 2, fecha: '2024-01-18', medicamentos: 'Metoclopramida 0.5mg/kg - cada 8 horas por 3 días\nOmeprazol 1mg/kg - cada 24 horas por 5 días', indicaciones: 'Dieta blanda (pollo hervido y arroz).\nAgua fresca disponible siempre.\nSi persisten los vómitos, consultar de inmediato.', proximaCita: '2024-01-25' },
        { id: 3, mascotaId: 3, fecha: '2024-01-20', medicamentos: 'Vacuna Polivalente DHPP', indicaciones: 'Vigilar posibles reacciones en las siguientes 24 horas.\nEvitar baños por 1 semana.\nMantener alimentación normal.', proximaCita: '2024-07-20' }
    ],

    // Save data to localStorage
    save: function(key) {
        const keyMap = {
            'clientes': 'vetcare_clientes',
            'mascotas': 'vetcare_mascotas',
            'historial': 'vetcare_historial',
            'prescripciones': 'vetcare_prescripciones'
        };
        localStorage.setItem(keyMap[key], JSON.stringify(this[key]));
    },

    // Get next ID
    getNextId: function(array) {
        if (array.length === 0) return 1;
        return Math.max(...array.map(item => item.id)) + 1;
    },

    // CRUD Operations for Clientes
    addCliente: function(cliente) {
        cliente.id = this.getNextId(this.clientes);
        this.clientes.push(cliente);
        this.save('clientes');
        return cliente;
    },

    updateCliente: function(id, data) {
        const index = this.clientes.findIndex(c => c.id === id);
        if (index !== -1) {
            this.clientes[index] = { ...this.clientes[index], ...data };
            this.save('clientes');
            return this.clientes[index];
        }
        return null;
    },

    deleteCliente: function(id) {
        const index = this.clientes.findIndex(c => c.id === id);
        if (index !== -1) {
            this.clientes.splice(index, 1);
            this.save('clientes');
            return true;
        }
        return false;
    },

    getCliente: function(id) {
        return this.clientes.find(c => c.id === id);
    },

    // CRUD Operations for Mascotas
    addMascota: function(mascota) {
        mascota.id = this.getNextId(this.mascotas);
        this.mascotas.push(mascota);
        this.save('mascotas');
        return mascota;
    },

    updateMascota: function(id, data) {
        const index = this.mascotas.findIndex(m => m.id === id);
        if (index !== -1) {
            this.mascotas[index] = { ...this.mascotas[index], ...data };
            this.save('mascotas');
            return this.mascotas[index];
        }
        return null;
    },

    deleteMascota: function(id) {
        const index = this.mascotas.findIndex(m => m.id === id);
        if (index !== -1) {
            this.mascotas.splice(index, 1);
            this.save('mascotas');
            return true;
        }
        return false;
    },

    getMascota: function(id) {
        return this.mascotas.find(m => m.id === id);
    },

    getMascotasByCliente: function(clienteId) {
        return this.mascotas.filter(m => m.clienteId === clienteId);
    },

    // CRUD Operations for Historial
    addHistorial: function(registro) {
        registro.id = this.getNextId(this.historial);
        this.historial.push(registro);
        this.save('historial');
        return registro;
    },

    updateHistorial: function(id, data) {
        const index = this.historial.findIndex(h => h.id === id);
        if (index !== -1) {
            this.historial[index] = { ...this.historial[index], ...data };
            this.save('historial');
            return this.historial[index];
        }
        return null;
    },

    deleteHistorial: function(id) {
        const index = this.historial.findIndex(h => h.id === id);
        if (index !== -1) {
            this.historial.splice(index, 1);
            this.save('historial');
            return true;
        }
        return false;
    },

    getHistorialByMascota: function(mascotaId) {
        return this.historial.filter(h => h.mascotaId === mascotaId);
    },

    // CRUD Operations for Prescripciones
    addPrescripcion: function(prescripcion) {
        prescripcion.id = this.getNextId(this.prescripciones);
        this.prescripciones.push(prescripcion);
        this.save('prescripciones');
        return prescripcion;
    },

    updatePrescripcion: function(id, data) {
        const index = this.prescripciones.findIndex(p => p.id === id);
        if (index !== -1) {
            this.prescripciones[index] = { ...this.prescripciones[index], ...data };
            this.save('prescripciones');
            return this.prescripciones[index];
        }
        return null;
    },

    deletePrescripcion: function(id) {
        const index = this.prescripciones.findIndex(p => p.id === id);
        if (index !== -1) {
            this.prescripciones.splice(index, 1);
            this.save('prescripciones');
            return true;
        }
        return false;
    },

    // Statistics
    getStats: function() {
        const tiposMascotas = {};
        this.mascotas.forEach(m => {
            tiposMascotas[m.tipo] = (tiposMascotas[m.tipo] || 0) + 1;
        });

        return {
            totalClientes: this.clientes.length,
            totalMascotas: this.mascotas.length,
            totalHistorial: this.historial.length,
            totalPrescripciones: this.prescripciones.length,
            mascotasPorTipo: tiposMascotas
        };
    }
};

// Make it globally available
window.VetData = VetData;

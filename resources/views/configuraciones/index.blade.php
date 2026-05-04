@extends('layouts.index', ['title' => 'Configuraciones'])

@section('content')
    <div class="page-content">
        <!-- Configuración Page -->
        <div class="page" id="page-configuracion">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Configuración</h1>
                    <p class="page-subtitle">Ajustes del sistema</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Información de la Clínica</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nombre de la Clínica</label>
                                    <input type="text" class="form-control" value="VetCare Pro">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" value="Av. Principal #123">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" value="+1 234 567 890">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="info@vetcarepro.com">
                                </div>
                                <button type="button" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Preferencias</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                                <label class="form-check-label" for="darkModeSwitch">Modo Oscuro</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="notificationsSwitch" checked="">
                                <label class="form-check-label" for="notificationsSwitch">Notificaciones</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="emailAlertsSwitch" checked="">
                                <label class="form-check-label" for="emailAlertsSwitch">Alertas por Email</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

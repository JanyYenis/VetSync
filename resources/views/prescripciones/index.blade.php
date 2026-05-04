@extends('layouts.index', ['title' => 'Prescripciones'])

@section('content')
    <div class="page-content">
        <!-- Prescripciones Page -->
        <div class="page" id="page-prescripciones">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Prescripciones</h1>
                    <p class="page-subtitle">Recetas médicas para mascotas</p>
                </div>
                <div class="page-actions">
                    <a href="{{ route('prescripciones.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Prescripción
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchPrescripciones" placeholder="Buscar prescripciones...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Mascota</th>
                                    <th>Medicamentos</th>
                                    <th>Indicaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="prescripcionesTableBody">
                                <!-- Dynamic content -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

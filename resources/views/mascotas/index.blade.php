@extends('layouts.index', ['title' => 'Mascotas'])

@section('imports')
    @vite(['resources/js/mascotas/principal.js'])
@endsection

@section('content')
    <div class="page-content">
        <!-- Mascotas Page -->
        <div class="page" id="page-mascotas">
            <div class="page-header">
                <div>
                    <h1 class="page-title text-primary">Mascotas</h1>
                    <p class="page-subtitle">Gestiona la información de las mascotas</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mascotaModal">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Mascota
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto tablasScroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px" style="max-height: 480px !important;">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="tablaMascotas">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center all">#</th>
                                        <th width="10%" class="text-center all">Nombre</th>
                                        <th width="10%" class="text-center all">Tipo</th>
                                        <th width="10%" class="text-center all">Raza</th>
                                        <th width="10%" class="text-center all">Edad</th>
                                        <th width="10%" class="text-center all">Propietario</th>
                                        <th width="10%" class="text-center none">Peso</th>
                                        <th width="10%" class="text-center none">Genero</th>
                                        <th width="10%" class="text-center none">Color</th>
                                        <th width="10%" class="text-center all">Estado</th>
                                        <th width="10%" class="text-center all">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @component('mascotas.modals.crear')
        @slot('generos', $generos)
        @slot('tipos', $tipos)
    @endcomponent
    @component('mascotas.modals.editar')
    @endcomponent
@endsection

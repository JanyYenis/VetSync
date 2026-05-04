@php
    $color = $concepto?->color ?? '';
    $icono = $concepto?->icono ?? '';
    $nombreConcepto = $concepto?->nombre ?? '';
@endphp
<div class="text-lg-center">
    <span class="badge bg-{{$color}}-subtle text-{{$color}}">
        @if ($icono)
            <i class="{{$icono}} text-{{$color}}"></i>&nbsp;
        @endif
        {{ initcap($nombreConcepto) }}
    </span>
</div>

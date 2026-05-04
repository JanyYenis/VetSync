<div class="d-flex align-items-center gap-2">
    @if ($model?->infoTipo?->icono)
        <div class="avatar-sm bg-{{ $model?->infoTipo?->color }}-subtle
            text-{{ $model?->infoTipo?->color }} rounded-circle d-flex align-items-center
            justify-content-center" style="width: 36px; height: 36px;">
            <i class="fa {{ $model?->infoTipo?->icono ?? '' }}"></i>
        </div>
    @endif
    <strong>{{ $model?->nombre ?? 'N/A' }}</strong>
</div>

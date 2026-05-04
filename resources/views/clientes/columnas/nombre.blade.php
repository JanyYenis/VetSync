<div class="d-flex align-items-center gap-2">
    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center"
        style="width:54px;height:36px;">
        {{ $model?->nombre[0] ?? 'N/A' }}
    </div>
    <strong>{{ $model?->nombre ?? 'N/A' }}</strong>
</div>

@props([
    'name',
    'title',
    'message',
    'action' => null,
    'targetFormId' => null,
    'method' => 'POST',
    'triggerLabel',
    'triggerVariant' => 'outline',
    'triggerColor' => null,
    'triggerSize' => 'sm',
    'confirmLabel' => '确认',
    'confirmVariant' => 'filled',
    'confirmColor' => null,
    'confirmSize' => 'sm',
    'cancelLabel' => '取消',
])

<flux:modal.trigger :name="$name">
    <flux:button type="button" :variant="$triggerVariant" :color="$triggerColor" :size="$triggerSize">
        {{ $triggerLabel }}
    </flux:button>
</flux:modal.trigger>

<flux:modal :name="$name" dismissible="false">
    <div class="space-y-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $title }}</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $message }}</p>
        </div>
        <div class="flex justify-end gap-2">
            <flux:modal.close>
                <flux:button type="button" variant="filled" size="sm">{{ $cancelLabel }}</flux:button>
            </flux:modal.close>
            @if ($targetFormId)
                <flux:button
                    type="button"
                    :variant="$confirmVariant"
                    :color="$confirmColor"
                    :size="$confirmSize"
                    x-on:click="document.getElementById('{{ $targetFormId }}')?.submit()"
                >
                    {{ $confirmLabel }}
                </flux:button>
            @elseif ($action)
                <form method="post" action="{{ $action }}">
                    @csrf
                    @if (strtoupper($method) !== 'POST')
                        @method($method)
                    @endif
                    <flux:button type="submit" :variant="$confirmVariant" :color="$confirmColor" :size="$confirmSize">
                        {{ $confirmLabel }}
                    </flux:button>
                </form>
            @endif
        </div>
    </div>
</flux:modal>

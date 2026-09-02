<x-filament-panels::page>

    <form wire:submit="save">

        {{ $this->form }}

        <div
            class="flex justify-start"
            style="margin-top: 24px;"
        >
            <x-filament::button type="submit">
                Update Password
            </x-filament::button>
        </div>

    </form>

</x-filament-panels::page>
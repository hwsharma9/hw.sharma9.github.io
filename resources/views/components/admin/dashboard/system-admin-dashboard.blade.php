<x-admin.container-card>
    <x-slot name="title">
        {{ __(session('role_name') . ' Dashboard') }}
    </x-slot>
    Welcome To {{ session('role_name') }} Dashboard
</x-admin.container-card>

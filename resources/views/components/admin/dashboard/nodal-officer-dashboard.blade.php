<x-admin.container-card>
    <x-slot name="title">
        {{ __(session('role_name') . ' Dashboard') }}
    </x-slot>

    <div class="card-body">
        Welcome To {{ session('role_name') }} Dashboard
    </div>
</x-admin.container-card>

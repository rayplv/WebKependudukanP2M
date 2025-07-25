<div>
    <h1 class="text-2xl font-bold text-[#4B0082] mb-6">Tambah Akun Baru</h1>

    <x-card class="rounded-xl shadow-lg p-6">
        <form wire:submit.prevent="buatAkunBaru">
            <div class="space-y-4">
                <x-input-text wire:model="namaAkun" label="Nama Akun:" placeholder="Nama Akun" />
                <x-input-text wire:model="email" label="Email:" type="email" placeholder="example@mail.com" />
                <x-input-text wire:model="kataSandi" label="Kata Sandi:" type="password"
                    placeholder="Minimal 8 karakter" />
                <x-input-select wire:model="role" :options="$roleOptions" label="Role:" selected="aktif" />
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-6"
                    role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            @error('*')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-6">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">Please correct the following errors:</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @enderror

            <div class="flex justify-end space-x-2 mt-6">
                <x-button type="button" wire:click="cancel" variant="secondary">Batal</x-button>
                <x-button type="submit" variant="primary">Buat Akun Baru</x-button>
            </div>
        </form>
    </x-card>

</div>

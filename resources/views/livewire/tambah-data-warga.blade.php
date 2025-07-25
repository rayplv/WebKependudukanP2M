<div>
    <h1 class="text-2xl font-bold text-[#4B0082] mb-6">Tambah Data Warga Baru</h1>

    <x-card class="rounded-xl shadow-lg p-6">
        <form wire:submit.prevent="submitForm">
            <h2 class="text-xl font-semibold text-[#4B0082] mb-4">Informasi Pribadi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                {{-- Row 1: Nama Lengkap & No. NIK --}}
                <x-input-text wire:model="namaLengkap" label="Nama Lengkap:" placeholder="Nama Sesuai KTP" />
                <x-input-text wire:model="nik" label="No. NIK:" placeholder="NIK" />

                {{-- Row 2: Tempat Lahir & Tanggal Lahir --}}
                <x-input-select wire:model="tempatLahir" :options="$kotaOptions" label="Tempat Lahir:" selected="" />
                <x-input-text wire:model="tanggalLahir" label="Tanggal Lahir:" type="date" placeholder="dd/mm/yy" />

                {{-- Row 3: No. Telp/Whatsapp & No. Kartu Keluarga --}}
                <x-input-text wire:model="noTelpWhatsapp" label="No. Telp/Whatsapp:" placeholder="Nomor Telp" />
                <x-input-text wire:model="noKeluarga" label="No. Kartu Keluarga:" placeholder="Nomor Kartu Keluarga" />

                {{-- Row 4: Hubungan Dalam KK --}}
                <x-input-select wire:model="hubunganDalamKK" :options="$hubunganOptions" label="Hubungan Dalam KK:" selected=""
                    class="col-span-full md:col-span-1" />
                {{-- Empty space on the right for md:col-span-1 if no other field is here --}}
                {{-- <div class="hidden md:block"></div> --}}

                {{-- Row 5: Alamat --}}
                <x-input-text wire:model="alamat" label="Alamat:" placeholder="Alamat Sesuai KTP"
                    class="col-span-full" />

                {{-- Row 6: RT & RW --}}
                <div class="grid grid-cols-2 gap-x-6 col-span-full md:col-span-1">
                    <x-input-text wire:model="rt" label="RT:" type="number" placeholder="RT" />
                    <x-input-text wire:model="rw" label="RW:" type="number" placeholder="RW" />
                </div>
                {{-- Empty space on the right for md:col-span-1 if no other field is here --}}
                <div class="hidden md:block"></div>


                {{-- Row 7: Jenis Kelamin & Gol. Darah --}}
                <x-input-select wire:model="jenisKelamin" :options="$jenisKelaminOptions" label="Jenis Kelamin:" selected="" />
                <x-input-select wire:model="golDarah" :options="$golDarahOptions" label="Gol. Darah:" selected="" />

                {{-- Row 8: Agama & Status Pernikahan --}}
                <x-input-select wire:model="agama" :options="$agamaOptions" label="Agama:" selected="" />
                <x-input-select wire:model="statusPernikahan" :options="$statusPernikahanOptions" label="Status Pernikahan:"
                    selected="" />

                {{-- Row 9: Jenjang Pendidikan & Pekerjaan --}}
                <x-input-select wire:model="jenjangPendidikan" :options="$jenjangPendidikanOptions" label="Jenjang Pendidikan:"
                    selected="" />
                <x-input-select wire:model="pekerjaan" :options="$pekerjaanOptions" label="Pekerjaan:" selected="" />

                {{-- Row 10: Penyandang Disabilitas --}}
                <div class="col-span-full">
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model.live="penyandangDisabilitas"
                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">Penyandang Disabilitas</span>
                    </label>
                    @if ($penyandangDisabilitas)
                        <x-input-text wire:model="penyakitDisabilitas" placeholder="Penyakit Disabilitas"
                            class="mt-2" />
                    @endif
                </div>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            @error('*')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">Please correct the following errors:</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @enderror

            <div class="flex justify-end space-x-2">
                <x-button type="submit" variant="primary" class="flex items-center">
                    <x-heroicon-o-plus-circle class="h-5 w-5 mr-2" /> {{-- Heroicon --}}
                    Tambah Surat
                </x-button>
            </div>
        </form>
    </x-card>

</div>

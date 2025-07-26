<div>
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 rounded-lg {{ session('type') == 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }}">
            <div class="flex items-center">
                @if(session('type') == 'success')
                    <x-heroicon-o-check-circle class="h-5 w-5 mr-2" />
                @else
                    <x-heroicon-o-exclamation-circle class="h-5 w-5 mr-2" />
                @endif
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- Header dengan Judul dan Tombol -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#4E347E]">Manajemen Akun</h1>
        <x-button wire:click="openTambahModal" type="button" variant="primary"
            class="bg-[#376CB4] hover:bg-[#457BC5] text-white px-6 py-2 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
            <x-heroicon-o-plus class="h-5 w-5 mr-2" />
            Tambah Akun Baru
        </x-button>
    </div>

    <x-card class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Role</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($accounts as $account)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <x-heroicon-o-user class="h-4 w-4 mr-2 text-gray-400" />
                                    <span class="text-sm font-medium text-gray-900">{{ $account->nama }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $account->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $account->role === 'aktif' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                    {{ ucfirst($account->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button wire:click="editAccount({{ $account->id }})" 
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-200 transition-colors duration-150 text-xs font-medium">
                                        <x-heroicon-o-pencil class="h-4 w-4 mr-1" />
                                        Edit
                                    </button>
                                    <button onclick="confirmDeleteAccount({{ $account->id }})" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 rounded-md hover:bg-red-100 transition-colors duration-150 text-xs font-medium">
                                        <x-heroicon-o-trash class="h-4 w-4 mr-1" />
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 whitespace-nowrap text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <x-heroicon-o-user-group class="h-12 w-12 text-gray-300 mb-2" />
                                    <span>Tidak ada akun yang ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <!-- Modal Tambah Akun -->
    <div x-data="{ show: @entangle('showTambahModal') }" x-show="show" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-[#4E347E]" id="modal-title">
                            <x-heroicon-o-user-plus class="h-6 w-6 inline mr-2 text-[#376CB4]" />
                            Tambah Akun Baru
                        </h3>
                        <button wire:click="closeTambahModal" class="text-gray-400 hover:text-gray-600">
                            <x-heroicon-o-x-mark class="h-6 w-6" />
                        </button>
                    </div>

                    <form wire:submit.prevent="simpanAkun" class="space-y-4">
                        <x-input-text wire:model="formData.nama" label="Nama Lengkap" placeholder="Masukkan nama lengkap"
                            class="border-gray-300 rounded-md shadow-sm" required />
                        
                        <x-input-text wire:model="formData.email" label="Email" type="email" placeholder="Masukkan email"
                            class="border-gray-300 rounded-md shadow-sm" required />
                        
                        <x-input-text wire:model="formData.password" label="Password" type="password" placeholder="Masukkan password"
                            class="border-gray-300 rounded-md shadow-sm" required />
                        
                        <x-input-text wire:model="formData.password_confirmation" label="Konfirmasi Password" type="password" placeholder="Masukkan ulang password"
                            class="border-gray-300 rounded-md shadow-sm" required />
                        
                        <x-input-select wire:model="formData.role" label="Role"
                            placeholder="Pilih role pengguna"
                            :options="[
                                ['value' => 'aktif', 'label' => 'Aktif'],
                                ['value' => 'suspended', 'label' => 'Suspended']
                            ]"
                            class="border-gray-300 rounded-md shadow-sm" required />

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-6 -mx-6 -mb-4">
                            <x-button type="submit" variant="primary"
                                class="w-full sm:w-auto sm:ml-3 bg-[#376CB4] hover:bg-[#457BC5] text-white">
                                <x-heroicon-o-check class="h-5 w-5 mr-2" />
                                Simpan Akun
                            </x-button>
                            <x-button wire:click="closeTambahModal" type="button" variant="secondary"
                                class="mt-3 sm:mt-0 w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700">
                                <x-heroicon-o-x-mark class="h-5 w-5 mr-2" />
                                Batal
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Confirmation Modal -->
    <div id="deleteAccountModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md mx-4 shadow-2xl">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus Akun</h3>
            </div>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex space-x-3 justify-end">
                <button onclick="closeDeleteAccountModal()" type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-all duration-200 text-sm font-medium">
                    Batal
                </button>
                <button onclick="confirmDeleteAccountAction()" type="button"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-200 text-sm font-medium">
                    Hapus Akun
                </button>
            </div>
        </div>
    </div>

    <script>
    let accountToDelete = null;

    function confirmDeleteAccount(accountId) {
        accountToDelete = accountId;
        document.getElementById('deleteAccountModal').classList.remove('hidden');
        document.getElementById('deleteAccountModal').classList.add('flex');
    }

    function closeDeleteAccountModal() {
        accountToDelete = null;
        document.getElementById('deleteAccountModal').classList.add('hidden');
        document.getElementById('deleteAccountModal').classList.remove('flex');
    }

    function confirmDeleteAccountAction() {
        if (accountToDelete) {
            @this.call('deleteAccount', accountToDelete);
            closeDeleteAccountModal();
        }
    }
    </script>

</div>

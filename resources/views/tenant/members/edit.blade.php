<x-app-layout>
    <x-slot name="header">Edit Anggota</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="mb-6 pb-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>

            <form method="POST" action="{{ route('members.update', $user) }}">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="role" value="Role" />
                    <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="owner" @selected($currentRole === 'owner')>Owner</option>
                        <option value="admin" @selected($currentRole === 'admin')>Admin</option>
                        <option value="supervisor" @selected($currentRole === 'supervisor')>Supervisor</option>
                        <option value="staff" @selected($currentRole === 'staff')>Staff</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('members.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    <x-primary-button>Simpan Perubahan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

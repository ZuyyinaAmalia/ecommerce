<div class="max-w-2xl mx-auto p-6 space-y-6">
  <h1 class="text-2xl font-semibold">Edit Akun</h1>

  @if ($successMessage)
    <div class="p-3 rounded bg-green-50 border border-green-200 text-green-700">
      {{ $successMessage }}
    </div>
  @endif

  {{-- FOTO PROFIL --}}
  <div class="flex items-center gap-6">
    @if ($profile_photo)
      <img src="{{ asset('storage/' . $profile_photo) }}" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover">
    @elseif ($newPhoto)
      <img src="{{ $newPhoto->temporaryUrl() }}" alt="Preview" class="w-24 h-24 rounded-full object-cover">
    @else
      <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </div>
    @endif

    <div class="space-y-2">
      <input type="file" wire:model="newPhoto" accept="image/*" class="block text-sm">
      @error('newPhoto') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

      @if ($profile_photo)
        <button wire:click="removePhoto" type="button" class="text-sm text-red-600 hover:underline">Hapus Foto</button>
      @endif
    </div>
  </div>

  {{-- FORM UTAMA --}}
  <form wire:submit.prevent="save" class="space-y-4">
    <div>
      <label class="block text-sm font-medium">Nama</label>
      <input type="text" wire:model.defer="name" class="mt-1 block w-full border rounded px-3 py-2">
      @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium">Email</label>
      <input type="email" wire:model.defer="email" class="mt-1 block w-full border rounded px-3 py-2">
      @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium">Password Baru (opsional)</label>
      <input type="password" wire:model.defer="password" class="mt-1 block w-full border rounded px-3 py-2">
      @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm font-medium">Konfirmasi Password</label>
      <input type="password" wire:model.defer="password_confirmation" class="mt-1 block w-full border rounded px-3 py-2">
    </div>

    <div class="pt-4">
      <button type="submit" class="py-2 px-4 rounded bg-blue-600 text-white font-medium hover:bg-blue-700">
        Simpan Perubahan
      </button>
    </div>
  </form>
</div>
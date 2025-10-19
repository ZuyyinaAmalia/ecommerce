<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MyAccountPage extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $profile_photo;
    public $newPhoto;
    public $successMessage;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->profile_photo = $user->profile_photo;
    }

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required','email','max:255',
                Rule::unique('users','email')->ignore(auth()->id())
            ],
            'newPhoto' => 'nullable|image|max:2048', // maksimal 2MB
        ];

        // Hanya tambahkan aturan password jika diisi
        if (!empty($this->password)) {
            $rules['password'] = 'required|min:8|same:password_confirmation';
            $rules['password_confirmation'] = 'required|min:8';
        }

        return $rules;
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function removePhoto()
    {
        $user = auth()->user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->update(['profile_photo' => null]);
        $this->profile_photo = null;

        $this->successMessage = 'Foto profil berhasil dihapus.';
    }

    public function save()
    {
        $data = $this->validate();

        $user = auth()->user();

        // Update nama & email
        $user->name = $this->name;
        $user->email = $this->email;

        // Update password hanya jika diisi
        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        // Upload foto baru jika ada
        if ($this->newPhoto) {
            // hapus foto lama
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $this->newPhoto->store('profile-photos', 'public');
            $user->profile_photo = $path;
            $this->profile_photo = $path; // update tampilan livewire
        }

        $user->save();

        // reset field password
        $this->password = '';
        $this->password_confirmation = '';
        $this->newPhoto = null;

        $this->successMessage = 'Akun berhasil diperbarui.';
    }

    public function render()
    {
        return view('livewire.auth.my-account-page');
    }
}
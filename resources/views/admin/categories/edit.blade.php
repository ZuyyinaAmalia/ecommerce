@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('categories.index') }}" class="hover:underline">Categories</a> /
        <span class="text-gray-700 font-medium">Edit</span>
    </div>

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Category</h1>

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded-xl shadow-md max-w-3xl">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700 mb-2">Category Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 mr-2">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>

        {{-- Is Active --}}
        <div class="mb-6 flex items-center gap-2">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                       {{ $category->is_active ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-orange-500 
                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                            after:bg-white after:h-5 after:w-5 after:rounded-full after:transition-all
                            peer-checked:after:translate-x-full"></div>
            </label>
            <span class="text-gray-700 font-medium">Is active</span>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-3">
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg font-medium transition">
                Update
            </button>
            <a href="{{ route('categories.index') }}"
               class="border border-gray-300 px-5 py-2 rounded-lg hover:bg-gray-100 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection


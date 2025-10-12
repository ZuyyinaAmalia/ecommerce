@extends('layouts.admin')

@section('content')
<div class="p-6">
    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('categories.index') }}" class="hover:underline">Categories</a> / 
        <span class="text-gray-700 font-medium">Create</span>
    </div>

    {{-- Title --}}
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Create Category</h1>

    {{-- Form --}}
    <form action="{{ route('categories.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-md max-w-3xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            {{-- Name --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                @error('name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                @error('slug')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Is Active --}}
        <div class="mb-6 flex items-center gap-2">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
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
                Create
            </button>
            <button type="submit" name="create_another"
                    class="border border-gray-300 px-5 py-2 rounded-lg hover:bg-gray-100 transition">
                Create & Create Another
            </button>
            <a href="{{ route('categories.index') }}"
               class="border border-gray-300 px-5 py-2 rounded-lg hover:bg-gray-100 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection


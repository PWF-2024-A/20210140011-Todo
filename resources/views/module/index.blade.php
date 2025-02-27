@extends('layouts.app')

@section('content')
<div class="max-w-5xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h2 class="mb-4 text-2xl font-bold text-center text-gray-800">Uploaded Modules</h2>

    <!-- Tombol Upload -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('module.create') }}" class="px-4 py-2 text-white transition duration-300 bg-blue-500 rounded-md hover:bg-blue-600">
            + Upload New Module
        </a>
    </div>

    <!-- Notifikasi Berhasil -->
    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-200 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        @if($modules->count() > 0)
        <table class="w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-center border-b">No</th>
                    <th class="px-4 py-3 border-b">Title</th>
                    <th class="px-4 py-3 border-b">Category</th>
                    <th class="px-4 py-3 text-center border-b">Image</th>
                    <th class="px-4 py-3 text-center border-b">File</th>
                    <th class="px-4 py-3 text-center border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                <tr class="transition duration-200 hover:bg-gray-50">
                    <td class="px-4 py-3 text-center border-b">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 border-b">{{ $module->title }}</td>
                    <td class="px-4 py-3 border-b">{{ $module->category->name }}</td>

                    <!-- Gambar -->
                    <td class="px-4 py-3 text-center border-b">
                        @if($module->image_path)
                        <img src="{{ asset('storage/' . $module->image_path) }}" alt="Module Image" class="object-cover w-16 h-16 rounded-md shadow">
                    @else
                        <span class="text-gray-400">No Image</span>
                    @endif
                    </td>

                    <!-- File -->
                    <td class="px-4 py-3 text-center border-b">
                        @if($module->file_path)
                        <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="text-blue-500 hover:underline">Download</a>
                    @else
                        <span class="text-gray-400">No File</span>
                    @endif
                    </td>

                    <!-- Actions -->
                    <td class="px-4 py-3 text-center border-b">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('module.edit', $module->id) }}" class="text-yellow-500 transition duration-300 hover:text-yellow-600">Edit</a>

                            <form action="{{ route('module.destroy', $module->id) }}" method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 transition duration-300 hover:text-red-600" onclick="return confirm('Are you sure you want to delete this module?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p class="p-4 text-center text-gray-500">No modules uploaded yet.</p>
        @endif
    </div>
</div>
@endsection

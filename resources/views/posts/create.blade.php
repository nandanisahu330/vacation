@extends('layouts.admin')

@section('title', 'Add New Post')
@section('page_crumb', 'Create Post')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-1">
                <a href="{{ route('posts.index') }}" class="hover:underline">Post Management</a>
                <span>/</span>
                <span class="text-slate-400">Add Post</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Create New Post</h1>
            <p class="text-sm text-slate-500 mt-0.5">Fill in the details below to publish a new post.</p>
        </div>
        <div>
            <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-2xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Listing</span>
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)] overflow-hidden">
        <form id="postForm" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6" onsubmit="handleFormSubmit()">
            @csrf

            <!-- Post Title -->
            <div class="space-y-1.5">
                <label for="title" class="block text-sm font-semibold text-slate-800">
                    Post Title <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       placeholder="Enter an engaging post title (e.g. Exploring the Secret Beaches of Bali)..." 
                       required
                       class="w-full px-4 py-2.5 text-sm bg-slate-50/60 border @error('title') border-rose-300 bg-rose-50/20 text-rose-900 @else border-slate-300 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                @error('title')
                    <p class="text-xs text-rose-600 mt-1 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Post Description -->
            <div class="space-y-1.5">
                <label for="description" class="block text-sm font-semibold text-slate-800">
                    Description <span class="text-rose-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="6" 
                          placeholder="Write your detailed post content here..." 
                          required
                          class="w-full px-4 py-3 text-sm bg-slate-50/60 border @error('description') border-rose-300 bg-rose-50/20 text-rose-900 @else border-slate-300 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-600 mt-1 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Image Upload & Preview -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-800">
                    Post Image <span class="text-rose-500">*</span>
                    <span class="text-xs font-normal text-slate-500 ml-1">(JPG, JPEG, PNG, WEBP, GIF up to 5 MB)</span>
                </label>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
                    <!-- Dropzone -->
                    <div id="dropzone" 
                         onclick="document.getElementById('imageInput').click()" 
                         class="cursor-pointer border-2 border-dashed border-slate-300 hover:border-indigo-500 bg-slate-50/60 hover:bg-indigo-50/30 rounded-2xl p-6 text-center transition-all flex flex-col items-center justify-center min-h-[170px]">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-700">Click to upload or drag & drop</p>
                        <p class="text-xs text-slate-400 mt-1">High resolution photos recommended</p>
                    </div>

                    <!-- Hidden File Input -->
                    <input type="file" 
                           id="imageInput" 
                           name="image" 
                           accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" 
                           required 
                           onchange="previewSelectedImage(this)" 
                           class="hidden">

                    <!-- Image Preview Card -->
                    <div id="previewContainer" class="hidden rounded-2xl border border-slate-200 bg-slate-50 p-3 relative flex flex-col items-center justify-center min-h-[170px]">
                        <div class="w-full h-40 rounded-xl overflow-hidden bg-slate-200 relative group">
                            <img id="imagePreview" src="" alt="Preview" class="w-full h-full object-cover">
                            <button type="button" 
                                    onclick="clearSelectedImage()" 
                                    class="absolute top-2 right-2 bg-slate-900/80 hover:bg-rose-600 text-white p-1.5 rounded-lg text-xs backdrop-blur-xs transition-colors shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <p id="imageFileInfo" class="text-xs text-slate-500 font-medium mt-2 truncate w-full text-center"></p>
                    </div>
                </div>

                @error('image')
                    <p class="text-xs text-rose-600 mt-1 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Post Status -->
            <div class="space-y-1.5 max-w-xs">
                <label for="status" class="block text-sm font-semibold text-slate-800">
                    Status <span class="text-rose-500">*</span>
                </label>
                <select id="status" 
                        name="status" 
                        required
                        class="w-full px-4 py-2.5 text-sm bg-slate-50/60 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-700">
                    <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active (Visible to public)</option>
                    <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive (Draft / Hidden)</option>
                </select>
                @error('status')
                    <p class="text-xs text-rose-600 mt-1 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('posts.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        id="submitBtn" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/30 transition-all active:scale-98">
                    <span id="btnSpinner" class="hidden">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span id="btnText">Save Post</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // 5MB max check (5 * 1024 * 1024)
            if (file.size > 5242880) {
                alert('File size exceeds the 5 MB limit. Please select a smaller image.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imageFileInfo').textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                document.getElementById('previewContainer').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    function clearSelectedImage() {
        const input = document.getElementById('imageInput');
        input.value = '';
        document.getElementById('previewContainer').classList.add('hidden');
        document.getElementById('imagePreview').src = '';
    }

    function handleFormSubmit() {
        const btn = document.getElementById('submitBtn');
        const spinner = document.getElementById('btnSpinner');
        const text = document.getElementById('btnText');

        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        spinner.classList.remove('hidden');
        text.textContent = 'Saving Post...';
    }

    // Drag and drop support
    const dropzone = document.getElementById('dropzone');
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('border-indigo-600', 'bg-indigo-50/50');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('border-indigo-600', 'bg-indigo-50/50');
        }, false);
    });

    dropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            const input = document.getElementById('imageInput');
            input.files = files;
            previewSelectedImage(input);
        }
    }, false);
</script>
@endpush
@endsection

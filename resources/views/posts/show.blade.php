@extends('layouts.admin')

@section('title', 'Post Details: ' . $post->title)
@section('page_crumb', 'Post Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Breadcrumb & Navigation Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-1">
                <a href="{{ route('posts.index') }}" class="hover:underline">Post Management</a>
                <span>/</span>
                <span class="text-slate-400">Post #{{ $post->id }}</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Post Details</h1>
            <p class="text-sm text-slate-500 mt-0.5">Comprehensive view of post information, metadata, and status.</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3">
            <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-2xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Posts</span>
            </a>
            <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit Post</span>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Post Body (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)] overflow-hidden">
                <div class="aspect-[16/9] w-full bg-slate-900 flex items-center justify-center relative overflow-hidden">
                    @if($post->image_url)
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-slate-400 text-sm flex flex-col items-center gap-2">
                            <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>No Image Attached</span>
                        </div>
                    @endif
                </div>
                
                <div class="p-6 sm:p-8 space-y-4">
                    <div class="flex items-center gap-2">
                        @if($post->status === 'Active')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Inactive
                            </span>
                        @endif
                        <span class="text-xs text-slate-400">• Post ID: #{{ $post->id }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">
                        {{ $post->title }}
                    </h2>

                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Full Description</h4>
                        <div class="prose max-w-none text-slate-700 text-sm sm:text-base leading-relaxed whitespace-pre-line font-normal">
                            {{ $post->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metadata & Actions Sidebar (1 col) -->
        <div class="space-y-6">
            <!-- Meta Details Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)] p-6 space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-3">Post Metadata</h3>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Status</span>
                        <span class="font-semibold text-slate-800 text-sm">{{ $post->status }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5">Created Date</span>
                        <span class="font-semibold text-slate-800">{{ $post->created_at ? $post->created_at->format('M d, Y h:i A') : 'N/A' }}</span>
                        <span class="text-slate-400 block text-[11px]">({{ $post->created_at ? $post->created_at->diffForHumans() : '' }})</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5">Last Updated Date</span>
                        <span class="font-semibold text-slate-800">{{ $post->updated_at ? $post->updated_at->format('M d, Y h:i A') : 'N/A' }}</span>
                        <span class="text-slate-400 block text-[11px]">({{ $post->updated_at ? $post->updated_at->diffForHumans() : '' }})</span>
                    </div>

                    @if($post->image)
                        <div>
                            <span class="text-slate-400 block mb-0.5">Stored File Path</span>
                            <span class="font-mono text-slate-600 break-all text-[11px] bg-slate-50 p-1.5 rounded-lg block border border-slate-200">
                                {{ $post->image }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                    <a href="{{ route('posts.edit', $post) }}" class="w-full text-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-indigo-600/30 transition-all">
                        Edit This Post
                    </a>
                    
                    <button type="button" 
                            onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                            class="w-full text-center px-4 py-2 text-rose-600 hover:bg-rose-50 text-xs font-semibold rounded-xl transition-colors">
                        Delete Post
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 transform transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900">Confirm Deletion</h3>
                <p class="text-xs text-slate-500 mt-0.5">This action cannot be undone.</p>
            </div>
        </div>

        <p class="text-sm text-slate-600 mt-4 leading-relaxed">
            Are you sure you want to delete post: <span class="font-semibold text-slate-900">"{{ $post->title }}"</span>?
        </p>

        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="mt-6 flex items-center justify-end gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm shadow-rose-600/30 transition-colors">
                Delete Post
            </button>
        </form>
    </div>
</div>
@endsection

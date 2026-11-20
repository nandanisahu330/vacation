@extends('layouts.admin')

@section('title', 'Posts List')
@section('page_crumb', 'Post Listing')

@section('content')
<div class="space-y-6">
    <!-- Header banner & statistics -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Post Management</h1>
            <p class="text-sm text-slate-500 mt-1">Manage, curate, and publish vacation stories and articles.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-indigo-600/30 transition-all duration-150 active:scale-98">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add New Post</span>
            </a>
        </div>
    </div>

    <!-- Quick Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)] flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Posts</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($counts['total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)] flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Active Posts</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($counts['active']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)] flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Inactive Posts</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($counts['inactive']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter and Search Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)]">
        <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            <div class="flex-1 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <!-- Search by Title -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search posts by title..." 
                           class="w-full pl-10 pr-4 py-2 text-sm bg-slate-50/70 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400">
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-44">
                    <select name="status" class="w-full px-3 py-2 text-sm bg-slate-50/70 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-700">
                        <option value="">All Statuses</option>
                        <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Filter & Reset Buttons -->
                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-xl hover:bg-slate-800 transition-colors shadow-sm">
                        Filter
                    </button>
                    @if(request('search') || request('status') || request('per_page'))
                        <a href="{{ route('posts.index') }}" class="px-3 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            <!-- Page Size Selection -->
            <div class="flex items-center gap-2 justify-end text-sm text-slate-500 border-t md:border-t-0 pt-3 md:pt-0">
                <span class="whitespace-nowrap">Show per page:</span>
                <select name="per_page" onchange="this.form.submit()" class="px-2.5 py-1.5 text-sm bg-slate-50/70 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Posts Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-4 w-16 text-center">Sr. No.</th>
                        <th class="py-3.5 px-4 w-28">Image</th>
                        <th class="py-3.5 px-4 min-w-[200px]">Title</th>
                        <th class="py-3.5 px-4 min-w-[300px]">Description</th>
                        <th class="py-3.5 px-4 w-28 text-center">Status</th>
                        <th class="py-3.5 px-4 w-36 whitespace-nowrap">Created Date</th>
                        <th class="py-3.5 px-4 w-36 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($posts as $index => $post)
                        <tr class="hover:bg-slate-50/80 transition-colors group cursor-pointer" onclick="handleRowClick(event, '{{ route('posts.show', $post) }}')">
                            <!-- Sr. No. -->
                            <td class="py-4 px-4 text-center font-medium text-slate-500 text-xs">
                                {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}
                            </td>

                            <!-- Image Thumbnail -->
                            <td class="py-4 px-4">
                                <div class="w-16 h-12 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 shadow-2xs flex-shrink-0 flex items-center justify-center">
                                    @if($post->image_url)
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'text-[10px] text-slate-400\'>No Image</span>'">
                                    @else
                                        <span class="text-[10px] text-slate-400">No Image</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Title -->
                            <td class="py-4 px-4">
                                <a href="{{ route('posts.show', $post) }}" class="font-semibold text-slate-800 hover:text-indigo-600 transition-colors line-clamp-2">
                                    {{ $post->title }}
                                </a>
                            </td>

                            <!-- Description -->
                            <td class="py-4 px-4 text-slate-600">
                                <p class="line-clamp-2 text-xs leading-relaxed">
                                    {{ Str::limit($post->description, 120) }}
                                </p>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-4 text-center">
                                @if($post->status === 'Active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <!-- Created Date -->
                            <td class="py-4 px-4 text-xs text-slate-500 whitespace-nowrap">
                                <div>{{ $post->created_at ? $post->created_at->format('M d, Y') : 'N/A' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $post->created_at ? $post->created_at->format('h:i A') : '' }}</div>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-center whitespace-nowrap" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- View Action -->
                                    <a href="{{ route('posts.show', $post) }}" 
                                       title="View Post Details"
                                       class="p-1.5 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <!-- Edit Action -->
                                    <a href="{{ route('posts.edit', $post) }}" 
                                       title="Edit Post"
                                       class="p-1.5 text-slate-600 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <!-- Delete Action Button -->
                                    <button type="button" 
                                            onclick="openDeleteModal('{{ $post->id }}', '{{ addslashes($post->title) }}', '{{ route('posts.destroy', $post) }}')"
                                            title="Delete Post"
                                            class="p-1.5 text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <!-- Empty State -->
                        <tr>
                            <td colspan="7" class="py-14 text-center">
                                <div class="max-w-xs mx-auto flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-800">No posts found</h3>
                                    <p class="text-xs text-slate-500 mt-1 mb-5 text-center">
                                        @if(request('search') || request('status'))
                                            No posts match your current search or status filter. Try clearing filters.
                                        @else
                                            You haven't created any posts yet. Start publishing your first post!
                                        @endif
                                    </p>
                                    @if(request('search') || request('status'))
                                        <a href="{{ route('posts.index') }}" class="px-4 py-2 text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-xl transition-colors">
                                            Clear All Filters
                                        </a>
                                    @else
                                        <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm shadow-indigo-600/30 transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            <span>Create First Post</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination & Records Count Footer -->
        <div class="px-5 py-4 bg-slate-50/80 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-slate-500 font-medium text-center sm:text-left">
                @if($posts->total() > 0)
                    Showing <span class="font-bold text-slate-700">{{ $posts->firstItem() }}</span> to <span class="font-bold text-slate-700">{{ $posts->lastItem() }}</span> of <span class="font-bold text-slate-700">{{ $posts->total() }}</span> total records
                @else
                    Showing 0 records
                @endif
            </div>

            <div>
                {{ $posts->links() }}
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
            Are you sure you want to delete post: <span id="deletePostTitle" class="font-semibold text-slate-900"></span>?
        </p>

        <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-end gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm shadow-rose-600/30 transition-colors">
                Delete Post
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function handleRowClick(event, url) {
        if (!['A', 'BUTTON', 'INPUT', 'SELECT', 'SVG', 'PATH'].includes(event.target.tagName)) {
            window.location.href = url;
        }
    }

    function openDeleteModal(id, title, actionUrl) {
        document.getElementById('deletePostTitle').textContent = `"${title}"`;
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection

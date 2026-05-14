@extends('admin/layout/app')
@section('title', 'Test Series')

@section('header')
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
        <div class="flex flex-col">
            <h2 class="text-lg font-bold">Test Series</h2>
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <span class="text-[10px] font-medium text-slate-500 uppercase tracking-wider">Test Series</span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="flex items-center gap-3">
            {{-- <button onclick="openMapSubjectModal()"
                class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                    <path d="M12 8v8" />
                    <path d="M8 12h8" />
                </svg>
                Map Subject
            </button> --}}
            <a href="{{ route('admin.testseries.create') }}"
                class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" x2="12" y1="8" y2="16" />
                    <line x1="8" x2="16" y1="12" y2="12" />
                </svg>
                Add New Test Series
            </a>
        </div>
    </header>
@endsection
@section('content')

    <div class="flex-1 overflow-y-auto p-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="text-xs font-semibold text-slate-500 uppercase tracking-wider border-b border-slate-100 bg-slate-50/50">
                            <th class="px-6 py-4">Test Series</th>
                            <th class="px-6 py-4">Category</th>
                            {{-- <th class="px-6 py-4">Students</th> --}}
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Is Popular</th>
                            {{-- <th class="px-6 py-4">Toggle Status</th> --}}
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @foreach ($courses ?? [] as $item)
                            <tr class="hover:bg-slate-50 transition-colors group">

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('admin.testseries.show', $item->id) }}"
                                            class="shrink-0 group-hover:opacity-80 transition-opacity">
                                            <img src="{{ url(Storage::url($item->thumbnail)) ?? 'N/A' }}"
                                                class="w-16 h-10 rounded-lg object-cover">
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.testseries.show', $item->id) }}"
                                                class="font-semibold text-slate-900 hover:text-indigo-600 transition-colors">{{ $item->title ?? 'N/A' }}</a>
                                            {{-- <div class="flex flex-wrap gap-1 mt-1">
                                                <span
                                                    class="px-1.5 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[10px] font-medium border border-indigo-100">React</span>
                                                <span
                                                    class="px-1.5 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[10px] font-medium border border-indigo-100">JavaScript</span>
                                                <span
                                                    class="px-1.5 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[10px] font-medium border border-indigo-100">Web
                                                    Dev</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600">{{ $item->category->name ?? 'N/A' }}</span>
                                </td>
                                {{-- <td class="px-6 py-4 text-sm font-medium">1,240</td> --}}
                                <td class="px-6 py-4 text-sm font-bold">{{ $item->price ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span id="status-1"
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700">Active</span>
                                </td>
                                {{-- <td class="px-6 py-4">
                                    <button onclick="toggleStatus(1)"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full bg-slate-200 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        id="toggle-1">
                                        <span
                                            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-6"
                                            id="dot-1"></span>
                                    </button>
                                </td> --}}
                                <td class="px-6 py-4">
                                    <button onclick="togglePopular({{ $item->id }})"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors
                                          {{ $item->popular == 1 ? 'bg-indigo-600' : 'bg-slate-200' }}"
                                        id="toggle-{{ $item->id }}">

                                        <span
                                            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform
                                              {{ $item->popular == 1 ? 'translate-x-6' : 'translate-x-1' }}"
                                            id="dot-{{ $item->id }}">
                                        </span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.testseries.edit', $item->id) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                            title="Edit Course">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </a>
                                        <button
                                            onclick="confirmDelete('{{ route('admin.testseries.destroy', $item->id) }}')"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                            title="Delete Course">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                <line x1="10" x2="10" y1="11" y2="17" />
                                                <line x1="14" x2="14" y1="11" y2="17" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>|

    @push('script')
        <script>
            function toggleStatus(id) {
                const statusBadge = document.getElementById(`status-${id}`);
                const toggleBtn = document.getElementById(`toggle-${id}`);
                const dot = document.getElementById(`dot-${id}`);

                const isActive = statusBadge.innerText === 'ACTIVE';

                if (isActive) {
                    statusBadge.innerText = 'INACTIVE';
                    statusBadge.className =
                        'px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600';
                    toggleBtn.className =
                        'relative inline-flex h-6 w-11 items-center rounded-full bg-slate-200 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2';
                    dot.className = 'inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-1';
                } else {
                    statusBadge.innerText = 'ACTIVE';
                    statusBadge.className =
                        'px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700';
                    toggleBtn.className =
                        'relative inline-flex h-6 w-11 items-center rounded-full bg-indigo-600 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2';
                    dot.className = 'inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-6';
                }
            }

        

            function togglePopular(id) {
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const toggleBtn = document.getElementById(`toggle-${id}`);
                const dot = document.getElementById(`dot-${id}`);

                const isActive = toggleBtn.classList.contains('bg-indigo-600');
                const newStatus = isActive ? 0 : 1;

                fetch("{{ route('admin.courses-popular') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": token
                        },
                        body: JSON.stringify({
                            course_id: id,
                            toggle: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {

                            if (newStatus === 1) {
                                toggleBtn.classList.remove('bg-slate-200');
                                toggleBtn.classList.add('bg-indigo-600');

                                dot.classList.remove('translate-x-1');
                                dot.classList.add('translate-x-6');
                            } else {
                                toggleBtn.classList.remove('bg-indigo-600');
                                toggleBtn.classList.add('bg-slate-200');

                                dot.classList.remove('translate-x-6');
                                dot.classList.add('translate-x-1');
                            }

                            sweet('success', data.message);

                        } else {
                            sweet('error', data.message);
                        }
                    })
                    .catch(error => {
                        sweet('error', 'Something went wrong');
                    });
            }
        </script>
    @endpush
@endsection

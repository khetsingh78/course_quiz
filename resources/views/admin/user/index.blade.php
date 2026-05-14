@extends('admin/layout/app')
@section('title', 'Students List')


@section('header')
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
        <h2 class="text-xl font-bold">Students List</h2>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.export') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg">
                Export Users
            </a>
            <div class="relative w-64">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search students..."
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                        onkeypress="if(event.key === 'Enter') this.form.submit()">
                </form>
            </div>
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
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Phone</th>
                            <th class="px-6 py-4">Join Date</th>
                            <th class="px-6 py-4">Status</th>
                            {{-- <th class="px-6 py-4 text-right">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @foreach ($user ?? [] as $item)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah"
                                            class="w-10 h-10 rounded-full bg-indigo-50 border border-slate-100">
                                        <span class="font-semibold text-slate-900">{{ $item->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700">Active</span>
                                </td>
                                {{-- <td class="px-6 py-4 text-right">
                                    <button
                                        class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>
                                </td> --}}
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

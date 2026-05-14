@extends('admin/layout/app')
@section('title', 'Test Series')


@section('header')
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
        <div class="flex items-center gap-4">
            <a href="my-courses.html" class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            <div class="flex flex-col">
                <h2 class="text-lg font-bold">{{ $course->title ?? 'N/A' }}</h2>
                <!-- Breadcrumb -->
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.course.index') }}"
                                class="text-[10px] font-medium text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">My
                                Courses</a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-2 h-2 text-slate-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span
                                    class="text-[10px] font-medium text-slate-500 uppercase tracking-wider">{{ $course->title ?? 'N/A' }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openMapSubjectModal()"
                class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                    <path d="M12 8v8" />
                    <path d="M8 12h8" />
                </svg>
                Add Test
            </button>
            {{-- <a href="edit-course.html"
                class="flex items-center gap-2 px-4 py-2 border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                    <path d="m15 5 4 4" />
                </svg>
                Edit
            </a> --}}
            {{-- <button onclick="confirmDelete()"
                class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18" />
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                    <line x1="10" x2="10" y1="11" y2="17" />
                    <line x1="14" x2="14" y1="11" y2="17" />
                </svg>
                Delete
            </button> --}}
        </div>
    </header>
@endsection

@section('content')
    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">

        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-5xl mx-auto space-y-8">
                <!-- Hero Section -->
                <div
                    class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col md:flex-row">
                    <div class="md:w-2/5 h-64 md:h-auto relative">
                        <img src="{{ url(Storage::url($course->thumbnail)) ?? 'N/A' }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold uppercase tracking-wider rounded-full shadow-lg">Active</span>
                        </div>
                    </div>
                    <div class="md:w-3/5 p-8 flex flex-col justify-center">
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-indigo-100">{{ $course->category->name ?? 'N/A' }}</span>
                            <span class="text-slate-400 text-xs">•</span>
                            <span class="text-slate-500 text-xs font-medium">Updated at
                                {{ $course->updated_at->format('Y-m-d') }}</span>
                        </div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-4 leading-tight">{{ $course->title ?? 'N/A' }}</h1>
                        <p class="text-slate-600 mb-6 leading-relaxed">
                            {{ Str::limit($course->description, 50, '...') }}</p>

                        <div class="grid grid-cols-3 gap-6 pt-6 border-t border-slate-100">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Price</p>
                                <p class="text-xl font-bold text-slate-900">&#8377;{{ $course->price }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Discout</p>
                                <p class="text-xl font-bold text-slate-900">&#8377;{{ $course->dis_price }}</p>
                            </div>
                            {{-- <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Students</p>
                                <p class="text-xl font-bold text-slate-900">1,240</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Rating</p>
                                <p class="text-xl font-bold text-slate-900">4.8 <span
                                        class="text-sm font-normal text-slate-400">/ 5</span></p>
                            </div> --}}
                        </div>

                    </div>
                </div>

                <!-- Subjects Section -->
                <section class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900">Mapped Test Series</h3>
                        <span
                            class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full">{{ count($course->quizzes ?? []) }}
                            Test Series</span>
                    </div>



                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="topics-grid">
                        <!-- Topic Box 1 -->
                        @foreach ($course->quizzes ?? [] as $item)
                            <div
                                class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group flex flex-col relative">

                                <div class="flex items-start justify-between mb-4 relative z-10">
                                    <div
                                        class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                                        @if ($item->islocked)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="11" width="18" height="11" rx="2"
                                                    ry="2" />
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1">
                                        {{-- <button
                                            onclick="event.preventDefault(); editTopic('{{ $item }}','{{ route('admin.quizzes.update', $item->id) }}')"
                                            class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </button> --}}
                                        <button onclick="confirmDelete('{{ route('admin.quizzes.destroy', $item->id) }}')"
                                            class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                <line x1="10" x2="10" y1="11" y2="17" />
                                                <line x1="14" x2="14" y1="11" y2="17" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <a href="{{ route('admin.questions.index', ['quiz_id' => $item->id]) }}" class="">
                                    <h4 class="font-bold text-slate-900 mb-2 relative z-10">{{ $item->name ?? 'N/A' }}
                                    </h4>
                                </a>
                                <h4 class="font-bold text-slate-900 mb-2 relative z-10">Total Marks:-
                                    {{ $item->total_marks ?? 'N/A' }}
                                </h4>
                                <h4 class="font-bold text-slate-900 mb-2 relative z-10">Duration:-
                                    {{ $item->duration ?? 'N/A' }}Min
                                </h4>
                                <p class="text-sm text-slate-500 leading-relaxed flex-1 relative z-10">
                                    {{ $item->description ?? 'N/A' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Additional Info -->
                {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Course Objectives</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Understand the core principles of React 19
                            </li>
                            <li class="flex items-start gap-3 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Build high-performance web applications
                            </li>
                            <li class="flex items-start gap-3 text-sm text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Master server-side rendering with Next.js
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 mb-4">Instructor</h3>
                        <div class="flex items-center gap-4">
                            <img src="https://i.pravatar.cc/150?u=instructor" class="w-16 h-16 rounded-2xl object-cover">
                            <div>
                                <p class="font-bold text-slate-900">Dr. Sarah Johnson</p>
                                <p class="text-sm text-slate-500">Senior Software Architect</p>
                                <div class="flex gap-2 mt-2">
                                    <span class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-600">12 Courses</span>
                                    <span class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-600">45k Students</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </main>
    </div>

    <!-- Map Subject Modal -->
    <div
        class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-slate-900 opacity-50"></div>


        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-2xl shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-6 text-left px-8">
                <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                    <p class="text-xl font-bold text-slate-900">Map Test Series</p>
                    <div class="modal-close cursor-pointer z-50" onclick="openMapSubjectModal()">
                        <svg class="fill-current text-slate-500 hover:text-slate-900" xmlns="http://www.w3.org/2000/svg"
                            width="18" height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>
                <form id="topic-form" method="POST" action="{{ route('admin.quizzes.store') }}"
                    class="space-y-4 mt-6">
                    @csrf
                    <input type="text" value="{{ $course->id ?? '' }}" name="test_id" hidden>
                    <div class="space-y-4 mt-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Enter Test
                                Title
                            </label>
                            <input type="text" id="" name="title" value=""
                                placeholder="E.g CGL Exam 2025 Test"
                                class="title w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">
                                Total Marks
                            </label>
                            <input type="number" id="" name="total_marks" value=""
                                placeholder="E.g 100"
                                class="title w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">
                                Duration in minutes
                            </label>

                            <input type="number" id="" name="duration" value="" placeholder="120 min"
                                class="title w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 outline-none">

                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">
                                Is Locked
                            </label>
                            <select id="islocked" name="islocked"
                                class="title w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 outline-none">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>

                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Description
                            </label>
                            <textarea name="description" rows="2"
                                class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all resize-none"></textarea>
                        </div>

                    </div>

                    <div class="flex justify-end pt-6 gap-3">
                        <button onclick="openMapSubjectModal()"
                            class="px-6 py-2.5 bg-slate-100 text-slate-600 font-semibold rounded-xl hover:bg-slate-200 transition-all">Cancel</button>
                        <button
                            class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">Map
                            Test </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        function openMapSubjectModal() {
            const body = document.querySelector('body');
            const modal = document.querySelector('.modal');
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            body.classList.toggle('modal-active');
        }

        function mapSubject() {
            openMapSubjectModal();
        }
    </script>
@endsection

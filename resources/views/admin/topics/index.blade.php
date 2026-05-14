@extends('admin/layout/app')
@section('title', 'Topics')
@push('css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .modal {
            transition: opacity 0.25s ease;
        }

        body.modal-active {
            overflow-x: hidden;
            overflow-y: hidden !important;
        }
    </style>
@endpush
@section('header')
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.course.index') }}"
                class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            <div class="flex flex-col">
                <h2 class="text-lg font-bold">Subject Topics</h2>
                <!-- Breadcrumb -->
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.course.index') }}"
                                class="text-[10px] font-medium text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">My
                                Courses</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-2 h-2 text-slate-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="{{-- {{ route('admin.course.index') }} --}}"
                                    class="text-[10px] font-medium text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">Subjects</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-2 h-2 text-slate-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="text-[10px] font-medium text-slate-500 uppercase tracking-wider">
                                    Topics</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <button onclick="toggleModal()"
            class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="16" />
                <line x1="8" x2="16" y1="12" y2="12" />
            </svg>
            Create Topic
        </button>
    </header>
@endsection

@section('content')
    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="topics-grid">
                    <!-- Topic Box 1 -->
                    @foreach ($topics ?? [] as $item)
                        <div
                            class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group flex flex-col relative">

                            <div class="flex items-start justify-between mb-4 relative z-10">
                                <div
                                    class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                    </svg>
                                </div>
                                <div class="flex items-center gap-1">
                                    <button
                                        onclick="event.preventDefault(); editTopic('{{ $item }}','{{ route('admin.topics.update', $item->id) }}')"
                                        class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                            <path d="m15 5 4 4" />
                                        </svg>
                                    </button>
                                    <button onclick="confirmDelete('{{ route('admin.topics.destroy', $item->id) }}')"
                                        class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
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
                            </div>
                            <a href="{{ route('admin.lectures.index', ['lecture' => $item->id]) }}">
                                <h4 class="font-bold text-slate-900 mb-2 relative z-10">{{ $item->name ?? 'N/A' }}</h4>
                            </a>
                            <p class="text-sm text-slate-500 leading-relaxed flex-1 relative z-10">
                                {{ $item->description ?? 'N/A' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
    </div>

    <!-- Modal -->
    <div
        class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-slate-900 opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-2xl shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-6 text-left px-8">
                <!--Title-->
                <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                    <p class="text-xl font-bold text-slate-900" id="modal-title">Create New Topic</p>
                    <div class="modal-close cursor-pointer z-50" onclick="toggleModal()">
                        <svg class="fill-current text-slate-500 hover:text-slate-900" xmlns="http://www.w3.org/2000/svg"
                            width="18" height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!--Body-->
                <form id="topic-form" method="POST" action="{{ route('admin.topics.store') }}" class="space-y-4 mt-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Subject</label>

                        <input type="text" name="subject_id" id="subject-name" value="{{ $subject->id ?? '' }}"
                            hidden>
                        <input type="text" id="subject-name" value="{{ $subject->name ?? '' }}" readonly
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Topic
                            Name</label>
                        <input type="text" name="name" id="topic-name" placeholder="e.g. State Management"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Description</label>
                        <textarea id="topic-desc" name="description" rows="3" placeholder="Briefly describe what this topic covers..."
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all resize-none"></textarea>
                    </div>


                    <!--Footer-->
                    <div class="flex justify-end pt-6 gap-3">
                        <button onclick="toggleModal()"
                            class="px-6 py-2.5 bg-slate-100 text-slate-600 font-semibold rounded-xl hover:bg-slate-200 transition-all">Cancel</button>
                        <button
                            class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">Save
                            Topic</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Edit Modal -->
    <div
        class="editmodal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-slate-900 opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-2xl shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-6 text-left px-8">
                <!--Title-->
                <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                    <p class="text-xl font-bold text-slate-900" id="modal-title">Edit Topic</p>
                    <div class="modal-close cursor-pointer z-50" onclick="EditToggleModal()">
                        <svg class="fill-current text-slate-500 hover:text-slate-900" xmlns="http://www.w3.org/2000/svg"
                            width="18" height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                            </path>
                        </svg>
                    </div>
                </div>

                <!--Body-->
                <form id="edit-topic-form" method="post" action="" class="space-y-4 mt-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Subject</label>

                        <input type="text" name="subject_id" id="subject-name" value="{{ $subject->id ?? '' }}"
                            hidden>
                        <input type="text" id="subject-name" value="{{ $subject->name ?? '' }}" readonly
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Topic
                            Name</label>
                        <input type="text" name="name" id="edit-topic-name" placeholder="e.g. State Management"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Description</label>
                        <textarea id="edit-topic-desc" name="description" rows="3"
                            placeholder="Briefly describe what this topic covers..."
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all resize-none"></textarea>
                    </div>


                    <!--Footer-->
                    <div class="flex justify-end pt-6 gap-3">
                        <button onclick="EditToggleModal()"
                            class="px-6 py-2.5 bg-slate-100 text-slate-600 font-semibold rounded-xl hover:bg-slate-200 transition-all">Cancel</button>
                        <button
                            class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">Update
                            Topic</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal() {
            const body = document.querySelector('body');
            const modal = document.querySelector('.modal');
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            body.classList.toggle('modal-active');

            // Reset form if opening for create
            if (!modal.classList.contains('opacity-0')) {
                document.getElementById('modal-title').innerText = 'Create New Topic';
                document.getElementById('topic-name').value = '';
                document.getElementById('topic-desc').value = '';
            }
        }

        function EditToggleModal() {
            const body = document.querySelector('body');
            const modal = document.querySelector('.editmodal');
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            body.classList.toggle('modal-active');

            // Reset form if opening for create
            if (!modal.classList.contains('opacity-0')) {
                document.getElementById('edit-topic-name').value = '';
                document.getElementById('edit-topic-desc').value = '';
            }
        }


        function editTopic(item, route) {
            item = JSON.parse(item)
            // console.log(JSON.parse(item));
            EditToggleModal();
            // document.getElementById('modal-title').innerText = 'Edit Topic';
            // Mock data for edit
            if (item) {
                document.querySelector('#edit-topic-form').action = route;
                document.getElementById('edit-topic-name').value = item.name;
                document.getElementById('edit-topic-desc').value = item.description;
            }
        }
    </script>
@endsection

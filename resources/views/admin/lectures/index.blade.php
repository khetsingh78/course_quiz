@extends('admin/layout/app')
@section('title', 'Lectures list')

@section('header')
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.topics.index', ['topics' => $subject->subject->id]) }}"
                class="p-2 hover:bg-slate-100 rounded-lg transition-all text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            <div class="flex flex-col">
                <h2 class="text-lg font-bold">Topic Lectures</h2>
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
                                <a href="{{ route('admin.topics.index', ['topics' => $subject->subject->id]) }}"
                                    class="text-[10px] font-medium text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">{{ $subject->subject->name ?? 'N/A' }}</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-2 h-2 text-slate-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="{{ route('admin.lectures.index', ['lecture' => $subject->id]) }}"
                                    class="text-[10px] font-medium text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">{{ $subject->name ?? 'N/A' }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-2 h-2 text-slate-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span
                                    class="text-[10px] font-medium text-slate-500 uppercase tracking-wider">Lectures</span>
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
            Add Lecture
        </button>
    </header>
@endsection

@section('content')

    <main class="flex-1 flex flex-col overflow-hidden">
        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">
                <div class="space-y-4" id="lectures-list">
                    <!-- Lecture Item 1 -->

                    @foreach ($lectures ?? [] as $item)
                        {{-- @dd($item) --}}
                        <div
                            class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all flex items-center gap-6 group">
                            <div
                                class="w-40 h-24 bg-slate-100 rounded-xl overflow-hidden shrink-0 relative flex items-center justify-center">
                                {{-- <video width="400" controls>
                                    <source src="{{ url(Storage::url($item->video_url)) ?? 'N/A' }}" type="video/mp4">
                                </video> --}}

                                {{-- <div class="absolute inset-0 flex items-center justify-center">
                                    <div
                                        class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center text-indigo-600 shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="5 3 19 12 5 21 5 3" />
                                        </svg>
                                    </div>
                                </div>
                                <span
                                    class="absolute bottom-2 right-2 bg-slate-900/80 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">12:45</span> --}}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-slate-900 text-lg">{{ $item->title ?? 'N/A' }}</h4>
                                    <div class="flex items-center gap-1">
                                        {{-- <button onclick="editLecture(1)"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </button> --}}
                                        <button onclick="confirmDelete('{{ route('admin.lectures.destroy', $item->id) }}')"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
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
                                {{-- <p class="text-sm text-slate-500 line-clamp-2">In this lecture, we explore the fundamentals
                                    of
                                    JSX, why it's used in React, and how it differs from regular HTML.</p> --}}
                                <div class="flex items-center gap-4 mt-3">
                                    {{-- <span class="flex items-center gap-1.5 text-xs text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="7 10 12 15 17 10" />
                                            <line x1="12" x2="12" y1="15" y2="3" />
                                        </svg>
                                        2.4 MB
                                    </span> --}}
                                    @if ($item->notes_pdf)
                                        <a href="{{ url(Storage::url($item->notes_pdf)) ?? 'N/A' }}" target="_blank">
                                            <span class="flex items-center gap-1.5 text-xs text-slate-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                                </svg>
                                                View PDF
                                            </span>
                                        </a>
                                    @endif
                                    @if ($item->video_url)
                                        <a href="{{ $item->video_url }}" target="_blank">
                                            <span class="flex items-center gap-1.5 text-xs text-slate-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                    <polyline points="7 10 12 15 17 10" />
                                                    <line x1="12" y1="15" x2="12" y2="3" />
                                                </svg>
                                                Video Link
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </main>


    <!-- Modal -->
    <div
        class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50">
        <div class="modal-overlay absolute w-full h-full bg-slate-900 opacity-50"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-lg mx-auto rounded-2xl shadow-lg z-50 overflow-y-auto">
            <div class="modal-content py-6 text-left px-8">
                <!--Title-->
                <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                    <p class="text-xl font-bold text-slate-900" id="modal-title">Add New Lecture</p>
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
                <form id="lecture-form" class="space-y-4 mt-6">
                    <input id="" name="topic_id" type="text" value="{{ $topicId }}" hidden>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Lecture
                            Title</label>
                        <input type="text" name="title" id="lecture-title" placeholder="e.g. Enter title"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    {{-- <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Description</label>
                        <textarea id="lecture-desc" name="" rows="3" placeholder="Briefly describe what this lecture covers..."
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all resize-none"></textarea>
                    </div> --}}
                    {{-- <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Select
                            Type</label>
                        <select id="lecture_type" name="lecture_type" onchange="toggleLectureType()"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-white">
                            <option value="pdf">Upload PDF</option>
                            <option value="video_url">Video URL</option>
                            <option value="video">video</option>
                        </select>
                    </div> --}}

                    <div class="" id="pdf_section">
                        <label class="text-sm font-semibold text-slate-700">Upload PDF</label>

                        <div class="flex items-center gap-4">

                            <!-- Preview Box -->
                            <div id="pdfPreview"
                                class="w-16 h-16 bg-slate-100 rounded-xl border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden">

                                <!-- PDF Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                            </div>

                            <!-- File Input -->
                            <input type="file" name="pdf_file" value="" id="pdfFile"
                                accept="application/pdf"
                                class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                        </div>
                    </div>

                    <div class="" id="video_url_section">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Video
                            Url</label>
                        <input type="text" name="video_url" id="lecture-url" value="" placeholder="Video URL"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div class="" id="video_section">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Upload
                            Video</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 transition-all cursor-pointer group"
                            onclick="document.getElementById('video-upload').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-indigo-500 transition-colors"
                                    stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-slate-600">
                                    <span
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        Upload a file
                                    </span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-500">MP4, WebM up to 500MB</p>
                            </div>
                            {{-- <input id="video-upload" type="file" class="hidden" accept="video/*"> --}}
                            <input id="video-upload" value="" name="video" type="file" class="hidden"
                                accept="video/*">
                        </div>
                    </div>

                </form>
                <!--Footer-->
                <div class="flex justify-end pt-6 gap-3">
                    <button onclick="toggleModal()"
                        class="px-6 py-2.5 bg-slate-100 text-slate-600 font-semibold rounded-xl hover:bg-slate-200 transition-all">Cancel</button>
                    <button onclick="saveLecture('{{ route('admin.lectures.store') }}')"
                        class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all">Save
                        Lecture</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')
    <script>
        function toggleModal() {
            const body = document.querySelector('body');
            const modal = document.querySelector('.modal');
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            body.classList.toggle('modal-active');

            if (!modal.classList.contains('opacity-0')) {
                document.getElementById('modal-title').innerText = 'Add New Lecture';
                document.getElementById('lecture-title').value = '';
                document.getElementById('lecture-desc').value = '';
            }
        }

        function saveLecture(action) {
            // console.log(action);

            const form = document.getElementById('lecture-form'); // your form id
            const formData = new FormData(form);
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(action, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": token
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        sweet('success', data.message);
                        location.reload();
                    } else {
                        sweet('error', data.message);
                    }
                })
                .catch(error => {
                    sweet('error', error);
                });

        }

        function editLecture(id) {
            toggleModal();
            document.getElementById('modal-title').innerText = 'Edit Lecture';
            if (id) {
                document.getElementById('lecture-title').value = 'What is JSX?';
                document.getElementById('lecture-desc').value =
                    'In this lecture, we explore the fundamentals of JSX, why it\'s used in React, and how it differs from regular HTML.';
            }
        }

        // function toggleLectureType() {
        //     const type = document.getElementById('lecture_type').value;

        //     const pdf = document.getElementById('pdf_section');
        //     const videoUrl = document.getElementById('video_url_section');
        //     const video = document.getElementById('video_section');

        //     // Hide all first
        //     pdf.classList.add('hidden');
        //     videoUrl.classList.add('hidden');
        //     video.classList.add('hidden');

        //     pdf.querySelector('input').value = null;
        //     videoUrl.querySelector('input').value = null;
        //     video.querySelector('input').value = null;

        //     // Show selected
        //     if (type === 'pdf') {
        //         pdf.classList.remove('hidden');
        //     } else if (type === 'video_url') {
        //         videoUrl.classList.remove('hidden');
        //     } else if (type === 'video') {
        //         video.classList.remove('hidden');
        //     }
        // }
    </script>
@endpush

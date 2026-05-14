@extends('admin/layout/app')
@section('title', 'Question Options')
@push('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
@section('header')

    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
        <div class="flex flex-col">
            <h2 class="text-lg font-bold">Quiz Management</h2>
            <!-- Breadcrumb -->
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.testseries.index') }}"
                            class="text-[10px] font-medium text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">Test
                            Series</a>
                    </li>
                    {{-- <li>
                        <div class="flex items-center">
                            <svg class="w-2 h-2 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin.quizzes.index', ['quiz_id' => $quiz_id]) }}"
                                class="text-[10px] font-medium text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">{{ $subject->subject->name ?? 'N/A' }}</a>
                        </div>
                    </li> --}}

                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-2 h-2 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-[10px] font-medium text-slate-500 uppercase tracking-wider">
                                Questions</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <button onclick="openQuestionModal()"
            class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="16" />
                <line x1="8" x2="16" y1="12" y2="12" />
            </svg>
            Create Question
        </button>
        <button onclick="openQuestionModalImport()"
            class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="16" />
                <line x1="8" x2="16" y1="12" y2="12" />
            </svg>
            Import Questions
        </button>
    </header>
@endsection

@section('content')

    <main class="flex-1 flex flex-col overflow-hidden">
        <div class="flex-1 overflow-y-auto p-8">
            <!-- Sample Question Box -->
            @foreach ($questions as $key => $item)
                <div class="bg-white mb-2 p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="flex justify-between items-start">
                        <div class="space-y-4 flex-1">

                            <div class="prose prose-slate max-w-none">
                                <h3 class="text-base font-semibold leading-relaxed">
                                    {{ $key + 1 . '.' }}{!! $item->question_text ?? 'N/A' !!}</h3>
                            </div>
                            @foreach ($item->options as $option_key => $option_val)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    {{-- <div
                                        class="p-3 bg-emerald-50 border border-emerald-100 rounded-xl text-sm font-medium text-emerald-700 flex items-center justify-between">
                                        <span>Paris (Correct)</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500">
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </div> --}}
                                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-sm text-slate-600">
                                        <span>{!! $option_val->option_text . '.' ?? 'N/A' !!}</span>&nbsp;
                                        {!! $option_val->option_value ?? 'N/A' !!}
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center gap-2 ml-4">
                            <button onclick="editQuestion({{ $item }})"
                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </button>
                            <button onclick="confirmDelete('{{ route('admin.questions.destroy', $item->id) }}')"
                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </main>


    <!-- Create/Edit Question Modal -->
    <div id="questionModal"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div
            class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-900" id="modalTitle">Create New Question</h3>
                <button onclick="closeQuestionModal()"
                    class="p-2 hover:bg-slate-100 rounded-full transition-all text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="p-8 overflow-y-auto space-y-6 flex-1">
                <div class="space-y-4">
                    <label class="text-sm font-bold text-slate-700">Question Text (Rich Editor)</label>
                    <div id="questionEditor" class="bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Option 1
                        </label>
                        <div id="option1Editor"
                            class="option-editor bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Option 2</label>
                        <div id="option2Editor"
                            class="option-editor bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Option 3</label>
                        <div id="option3Editor"
                            class="option-editor bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Option 4</label>
                        <div id="option4Editor"
                            class="option-editor bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                    </div>
                </div>
            </div>

            <div class="p-8 overflow-y-auto space-y-6 flex-1">
                <div class="space-y-4">
                    <label class="text-sm font-bold text-slate-700">Question Answear</label>
                    <select name="answear" id="answear" class="text-sm font-bold text-slate-700 d-block border-2">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>

            <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <button onclick="closeQuestionModal()"
                    class="px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 rounded-xl transition-all">Cancel</button>
                <button onclick="saveQuestion('{{ route('admin.questions.store') }}',{{ $quiz_id }})"
                    class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">Save
                    Question</button>
            </div>
        </div>
    </div>


    <!-- Create/Edit Question Modal -->
    <div id="questionModalEdit"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div
            class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-900" id="">Edit Question</h3>
                <button onclick="closeQuestionModalEdit()"
                    class="p-2 hover:bg-slate-100 rounded-full transition-all text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="p-8 overflow-y-auto space-y-6 flex-1">
                <div class="space-y-4">
                    <label class="text-sm font-bold text-slate-700">Question Text </label>
                    <div id="questionEditorEdit" class="bg-white rounded-xl overflow-hidden border border-slate-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Option 1
                        </label>
                        <div id="option1EditorEdit"
                            class="option-editor bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Option 2</label>
                        <div id="option2EditorEdit"
                            class="option-editor bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Option 3</label>
                        <div id="option3EditorEdit"
                            class="option-editor bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Option 4</label>
                        <div id="option4EditorEdit"
                            class="option-editor bg-white rounded-xl overflow-hidden border border-slate-200"></div>
                    </div>
                </div>
            </div>

            <div class="p-8 overflow-y-auto space-y-6 flex-1">
                <div class="space-y-4">
                    <label class="text-sm font-bold text-slate-700">Question Answear</label>
                    <select name="answear" id="answearEdit" class="text-sm font-bold text-slate-700 d-block border-2">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>
            <input type="hidden" id="questionIdEdit" name="question_id">
            <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <button onclick="closeQuestionModalEdit()"
                    class="px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 rounded-xl transition-all">Cancel</button>
                <button onclick="updateQuestion()"
                    class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                    Update Question
                </button>
            </div>
        </div>
    </div>



    {{-- ---------import questions list ------------ --}}
    <div id="questionModalImport"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div
            class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-slate-900">Upload Questions File</h3>
                <button onclick="closeQuestionModalImport()"
                    class="p-2 hover:bg-slate-100 rounded-full transition-all text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.questions.import') }}" method="POST" enctype="multipart/form-data">

                <div class="p-6 border-b border-slate-100 flex items-center justify-between">

                    @csrf
                    <input type="file" name="quiz_file" accept=".xlsx">
                    <input type="text" name="quiz_id" value="{{ $quiz_id }}" hidden>

                    {{-- <button type="submit">Upload</button> --}}
                    <a href="{{ asset('sample-files/question_upload.xlsx') }}" download rel="noopener noreferrer">
                        Download Sample File
                    </a>
                </div>

                <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button onclick="closeQuestionModalImport()"
                        class="px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 rounded-xl transition-all">Cancel</button>
                    <button type="submit"
                        class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">Save
                        Question</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script')
    <!-- Scripts -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        let questionQuill, option1Quill, option2Quill, option3Quill, option4Quill;
        // Initialize Quill editors
        function initQuill() {
            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }],
                [{
                    'header': [1, 2, 3, false]
                }],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                ['link', 'image'],
                ['clean']
            ];

            const basicToolbar = [
                ['bold', 'italic', 'link'],
                ['clean']
            ];

            questionQuill = new Quill('#questionEditor', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow',
                placeholder: 'Write your question here...'
            });

            option1Quill = new Quill('#option1Editor', {
                modules: {
                    toolbar: basicToolbar
                },
                theme: 'snow',
                placeholder: 'Enter correct option...'
            });

            option2Quill = new Quill('#option2Editor', {
                modules: {
                    toolbar: basicToolbar
                },
                theme: 'snow',
                placeholder: 'Enter distraction...'
            });

            option3Quill = new Quill('#option3Editor', {
                modules: {
                    toolbar: basicToolbar
                },
                theme: 'snow',
                placeholder: 'Enter distraction...'
            });

            option4Quill = new Quill('#option4Editor', {
                modules: {
                    toolbar: basicToolbar
                },
                theme: 'snow',
                placeholder: 'Enter distraction...'
            });
        }

        let questionQuillEdit, option1QuillEdit, option2QuillEdit, option3QuillEdit, option4QuillEdit;
        // Initialize Quill editors
        function initQuillEdit() {
            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }],
                [{
                    'header': [1, 2, 3, false]
                }],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                ['link', 'image'],
                ['clean']
            ];

            const basicToolbar = [
                ['bold', 'italic', 'link'],
                ['clean']
            ];

            questionQuillEdit = new Quill('#questionEditorEdit', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow',
                placeholder: 'Write your question here...'
            });

            option1QuillEdit = new Quill('#option1EditorEdit', {
                modules: {
                    toolbar: basicToolbar
                },
                theme: 'snow',
                placeholder: 'Enter correct option...'
            });

            option2QuillEdit = new Quill('#option2EditorEdit', {
                modules: {
                    toolbar: basicToolbar
                },
                theme: 'snow',
                placeholder: 'Enter distraction...'
            });

            option3QuillEdit = new Quill('#option3EditorEdit', {
                modules: {
                    toolbar: basicToolbar
                },
                theme: 'snow',
                placeholder: 'Enter distraction...'
            });

            option4QuillEdit = new Quill('#option4EditorEdit', {
                modules: {
                    toolbar: basicToolbar
                },
                theme: 'snow',
                placeholder: 'Enter distraction...'
            });
        }

        function openQuestionModal() {
            document.getElementById('questionModal').classList.remove('hidden');
            if (!questionQuill) initQuill();
        }

        function closeQuestionModal() {
            document.getElementById('questionModal').classList.add('hidden');
        }

        function questionModalEdit() {
            document.getElementById('questionModalEdit').classList.remove('hidden');
            if (!questionQuillEdit) initQuillEdit();
        }

        function closeQuestionModalEdit() {
            document.getElementById('questionModalEdit').classList.add('hidden');
        }

        function openQuestionModalImport() {
            document.getElementById('questionModalImport').classList.remove('hidden');
            // if (!questionQuill) initQuill();
        }

        function closeQuestionModalImport() {
            document.getElementById('questionModalImport').classList.add('hidden');
        }

        function saveQuestion(action, quiz_id) {
            // Get HTML from editors
            const questionHTML = questionQuill.root.innerHTML;
            const op1HTML = option1Quill.root.innerHTML;
            const op2HTML = option2Quill.root.innerHTML;
            const op3HTML = option3Quill.root.innerHTML;
            const op4HTML = option4Quill.root.innerHTML;

            const answear = document.getElementById('answear').value;

            // console.log("Saving Question:", {
            //     questionHTML,
            //     op1HTML,
            //     op2HTML,
            //     op3HTML,
            //     op4HTML
            // });

            let formData = {
                "quiz_id": quiz_id,
                "question": questionHTML,
                "options": {
                    "A": op1HTML,
                    "B": op2HTML,
                    "C": op3HTML,
                    "D": op4HTML,
                },
                "answear": answear,
            }
            // console.log(formData);
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(action, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify(formData)
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

            // In a real app, you'd send this to your backend
            // alert('Question saved successfully! (Check console for HTML output)');
            // closeQuestionModal();
        }

        function updateQuestion() {
            // Get HTML from editors
            const questionHTML = questionQuillEdit.root.innerHTML;
            const op1HTML = option1QuillEdit.root.innerHTML;
            const op2HTML = option2QuillEdit.root.innerHTML;
            const op3HTML = option3QuillEdit.root.innerHTML;
            const op4HTML = option4QuillEdit.root.innerHTML;

            console.log(questionHTML, op1HTML, op2HTML, op3HTML, op4HTML);


            const answear = document.getElementById('answearEdit').value;
            const questionIdEdit = document.getElementById('questionIdEdit').value;
            console.log(questionIdEdit);


            let formData = {
                "question_id": questionIdEdit,
                "question": questionHTML,
                "options": {
                    "A": op1HTML,
                    "B": op2HTML,
                    "C": op3HTML,
                    "D": op4HTML,
                },
                "answear": answear,
            }
            console.log(formData);
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/admin/questions/${questionIdEdit}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify(formData)
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

            // In a real app, you'd send this to your backend
            // alert('Question saved successfully! (Check console for HTML output)');
            // closeQuestionModal();
        }

        function editQuestion(question) {
            console.log(question.options);
            document.getElementById('questionIdEdit').value = question.id;

            questionModalEdit();
            // document.getElementById('modalTitle').innerText = 'Edit Question';
            // Pre-fill logic here
            if (question) {
                questionQuillEdit.root.innerHTML = question.question_text;

                const optionEditors = [
                    option1QuillEdit,
                    option2QuillEdit,
                    option3QuillEdit,
                    option4QuillEdit
                ];
                question.options.forEach((element, key) => {
                    optionEditors[key].root.innerHTML = element.option_value;
                    if (element.is_correct) {
                        document.getElementById('answearEdit').value = element.option_text;
                    }
                });

            }
        }

        // function deleteQuestion(id) {
        //     if (confirm('Are you sure you want to delete this question?')) {
        //         // Delete logic here
        //         alert('Question deleted');
        //     }
        // }

        // function handleLogout() {
        //     if (confirm('Are you sure you want to logout?')) {
        //         window.location.href = '#';
        //     }
        // }
    </script>
@endpush

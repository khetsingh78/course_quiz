@extends('admin/layout/app')
@section('title', 'Edit Test Series')

@section('header')
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.testseries.index') }}"
                class="p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-slate-900">Edit Test Series</h1>
        </div>
        {{-- <div class="flex items-center gap-3">
            <button
                class="px-6 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-all">Update
                Course</button>
        </div> --}}
    </header>
@endsection
@section('content')
    <!-- Header -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('admin.testseries.update', $course->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-8 space-y-8">
                        <section class="space-y-6">
                            <h2 class="text-lg font-bold text-slate-900">Course Details</h2>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Course Title</label>
                                    <input type="text" name="title" value="{{ $course->title ?? 'N/A' }}"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Description</label>
                                    <textarea name="description" rows="4"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all resize-none">{{ $course->description ?? 'N/A' }}</textarea>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Course Thumbnail</label>
                                    <div class="flex items-center gap-4">
                                        <div class="w-24 h-24 bg-slate-100 rounded-xl border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden"
                                            id="courseImgPreview">
                                            <img src="{{ url(Storage::url($course->thumbnail)) ?? 'N/A' }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <input type="file" name="cover_image" id="courseImage" accept="image/*"
                                            class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"
                                            onchange="previewImage(this, 'courseImgPreview')">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <hr class="border-slate-100">

                        <!-- Classification -->
                        <section class="space-y-6">
                            <h2 class="text-lg font-bold text-slate-900">Classification & Pricing</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Category</label>
                                    <div class="flex gap-2">
                                        <select id="categorySelect" name="category"
                                            class="flex-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-white">
                                            @foreach ($categories ?? [] as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $course->category_id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button onclick="openCategoryModal()" type="button"
                                            class="w-12 h-12 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-all border border-indigo-100 animate-pulse"
                                            title="Add New Category">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="12" x2="12" y1="5" y2="19" />
                                                <line x1="5" x2="19" y1="12" y2="12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Price (INR)</label>
                                    <input type="number" name="price" value="{{ $course->price ?? '' }}"
                                        placeholder="0.00"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Discount Type</label>
                                    <div class="flex gap-2">
                                        <select id="categorySelect" name="discount_type"
                                            class="flex-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-white">
                                            <option value="flat" {{ $course->dis_type == 'flat' ? 'selected' : '' }}>Flat
                                            </option>
                                            <option value="percent" {{ $course->dis_type == 'percent' ? 'selected' : '' }}>
                                                Percent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Discount Value</label>
                                    <input type="number" name="discount_value" value="{{ $course->dis_price ?? 'N/A' }}"
                                        placeholder="0.00"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                </div>
                            </div>
                            {{-- <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Map Subjects (Multiple)</label>
                                <div class="space-y-3">
                                    <div class="flex gap-2">
                                        <input type="text" id="subjectInput"
                                            placeholder="Type subject and press Enter or click Add"
                                            class="flex-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                        <button type="button" onclick="addSubject()"
                                            class="px-6 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 transition-all active:scale-95">Add</button>
                                    </div>
                                    <div id="subjectsList"
                                        class="flex flex-wrap gap-2 min-h-[44px] p-2 border border-dashed border-slate-200 rounded-xl bg-slate-50/30">
                                        <!-- Subjects will be added here -->
                                        <p id="noSubjectsHint" class="text-xs text-slate-400 italic p-2">No subjects added
                                            yet...</p>
                                    </div>
                                </div>
                            </div> --}}
                        </section>
                    </div>
                    <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.testseries.index') }}"
                            class="px-6 py-2 text-sm font-semibold text-slate-600">Cancel</a>
                        <button
                            class="px-8 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition-all">Save
                            Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-2xl w-full max-w-md shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-900">Add New Category</h3>
                <button onclick="closeCategoryModal()"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="18" x2="6" y1="6" y2="18" />
                        <line x1="6" x2="18" y1="6" y2="18" />
                    </svg>
                </button>
            </div>
            <form id="addcategory" action="{{ route('admin.categories.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Category Name</label>
                        <input type="text" name="name" id="newCatName" placeholder="e.g. Mobile Development"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Category Type</label>
                        <select id="newCatType" name="category_type"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-white">
                            <option value="main">Main Category</option>
                            <option value="sub">Sub Category</option>
                            <option value="special">Special Module</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Category Image</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-slate-100 rounded-xl border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden"
                                id="catImgPreview">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                                    <circle cx="9" cy="9" r="2" />
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                </svg>
                            </div>
                            <input type="file" name="cover_image" id="catImage" accept="image/*"
                                class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"
                                onchange="previewImage(this, 'catImgPreview')">
                        </div>
                    </div>
                    <div class="pt-4">
                        <button
                            class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">Save
                            Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        <script>
            function previewImage(input, previewId) {
                const preview = document.getElementById(previewId);
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function openCategoryModal() {
                document.getElementById('categoryModal').classList.remove('hidden');
                document.getElementById('categoryModal').classList.add('flex');
            }

            function closeCategoryModal() {
                document.getElementById('categoryModal').classList.add('hidden');
                document.getElementById('categoryModal').classList.remove('flex');
            }

            document.querySelector("#addcategory").addEventListener("submit", function(e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);
                fetch(form.action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            sweet('success', data.message);
                            closeCategoryModal();
                            form.reset();
                            const select = document.getElementById('categorySelect');
                            const option = document.createElement('option');
                            option.text = data.data.name;
                            option.value = data.data.id;
                            select.add(option);
                            select.value = data.data.id;
                        } else {
                            sweet('error', data.message);
                        }
                    })
                    .catch(error => {
                        sweet('error', error);
                    });
            });
        </script>
    @endpush
@endsection

@extends('admin/layout/app')
@section('title', 'Add Course')

@section('header')
    <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
        <h2 class="text-xl font-bold">Categories</h2>
        <button onclick="openCategoryModal()"
            class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="16" />
                <line x1="8" x2="16" y1="12" y2="12" />
            </svg>
            Add New Category
        </button>
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
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Type</th>
                            {{-- <th class="px-6 py-4">Courses Count</th> --}}
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" id="categoryTableBody">
                        @foreach ($category ?? [] as $item)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ url(Storage::url($item->cover_image)) ?? 'N/A' }}"
                                            class="w-10 h-10 rounded-lg object-cover">
                                        <span class="font-semibold text-slate-900">{{ $item->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-600">{{ $item->type ?? 'N/A' }}</span>
                                </td>
                                {{-- <td class="px-6 py-4 text-sm font-medium">24 Courses</td> --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            onclick="editCategory('{{ $item->name }}', '{{ $item->type }}', '{{ route('admin.categories.update', $item->id) }}')"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </button>
                                        <button
                                            onclick="confirmDelete('{{ route('admin.categories.destroy', $item->id) }}')"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
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
    </div>
    </main>
    </div>

    <!-- Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-2xl w-full max-w-md shadow-2xl transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-900" id="modalTitle">Add New Category</h3>
                <button onclick="closeCategoryModal()"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                            {{-- <option value="sub">Sub Category</option>
                            <option value="special">Special Module</option> --}}
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

    {{-- Edit Category Model --}}
    <div id="EditCategoryModal"
        class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-2xl w-full max-w-md shadow-2xl transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-900" id="EditModalTitle">Edit New Category</h3>
                <button onclick="closeEditCategoryModal()"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="18" x2="6" y1="6" y2="18" />
                        <line x1="6" x2="18" y1="6" y2="18" />
                    </svg>
                </button>
            </div>
            <form id="editCategory" action="" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Category Name</label>
                        <input type="text" name="name" id="EditNewCatName" placeholder="e.g. Mobile Development"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Category Type</label>
                        <select id="EditNewCatType" name="type"
                            class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all bg-white">
                            <option value="main">Main Category</option>
                            {{-- <option value="sub">Sub Category</option>
                            <option value="special">Special Module</option> --}}
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Category Image</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-slate-100 rounded-xl border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-400 overflow-hidden"
                                id="EditCatImgPreview">
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
                                onchange="previewImage(this, 'EditCatImgPreview')">
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
@endsection

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
            document.getElementById('modalTitle').innerText = 'Add New Category';
            document.getElementById('newCatName').value = '';
            document.getElementById('catImgPreview').innerHTML =
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>';
            document.getElementById('categoryModal').classList.remove('hidden');
            document.getElementById('categoryModal').classList.add('flex');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.getElementById('categoryModal').classList.remove('flex');
        }

        function editCategory(name, type, route) {
            // console.log(name, type, route);
            document.querySelector('#editCategory').action = route;
            document.getElementById('EditModalTitle').innerText = 'Edit Category';
            document.getElementById('EditNewCatName').value = name;
            document.getElementById('EditNewCatType').value = type;
            document.getElementById('EditCategoryModal').classList.remove('hidden');
            document.getElementById('EditCategoryModal').classList.add('flex');
        }

        function closeEditCategoryModal() {
            document.getElementById('EditCategoryModal').classList.add('hidden');
            document.getElementById('EditCategoryModal').classList.remove('flex');
        }


        // function confirmDelete(action) {
        //     fetch(action, {
        //             method: "DELETE",
        //             headers: {
        //                 "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        //             },
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 sweet('success', data.message);
        //                 location.reload();
        //             } else {
        //                 sweet('error', data.message);
        //             }
        //         })
        //         .catch(error => {
        //             sweet('error', error);
        //         });
        // }

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
                        location.reload();
                    } else {
                        sweet('error', data.message);
                    }
                })
                .catch(error => {
                    sweet('error', error);
                });
        });

        document.querySelector("#editCategory").addEventListener("submit", function(e) {
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
                        location.reload();
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

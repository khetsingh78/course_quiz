 <aside class="w-64 bg-white border-r border-slate-200 flex flex-col shrink-0">
     <div class="p-6">
         <div class="flex items-center gap-3 text-indigo-600 font-bold text-2xl tracking-tight">
             <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                     <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
                 </svg>
             </div>
             Training
         </div>
     </div>
     <nav class="flex-1 px-4 space-y-1">
         <a href="{{ route('admin.dashboard') }}"
             class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold
            {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }}">
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                 <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                 <polyline points="9 22 9 12 15 12 15 22" />
             </svg>

             Dashboard
         </a>
         <a href="{{ route('admin.categories.index') }}"
             class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl transition-all">

             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                 <rect width="7" height="9" x="3" y="3" rx="1" />
                 <rect width="7" height="5" x="14" y="3" rx="1" />
                 <rect width="7" height="9" x="14" y="12" rx="1" />
                 <rect width="7" height="5" x="3" y="16" rx="1" />
             </svg>
             Categories
         </a>
         <a href="{{ route('admin.banners.index') }}"
             class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.banners.*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl transition-all">
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                 <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                 <path d="M7 9h10"></path>
                 <path d="M7 13h6"></path>
             </svg>
             Banners
         </a>
         <a href="{{ route('admin.course.index') }}"
             class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.course.*', 'admin.topics.*', 'admin.lectures.*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl transition-all">
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                 <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                 <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
             </svg>
             My Courses
         </a>
         <a href="{{ route('admin.testseries.index') }}"
             class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.testseries.*', 'admin.questions.*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl transition-all">
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                 <rect x="8" y="2" width="8" height="4" rx="1"></rect>
                 <path d="M9 12h6"></path>
                 <path d="M9 16h6"></path>
                 <path d="M5 6h14v16H5z"></path>
             </svg>
             Test Series
         </a>
         <a href="{{ route('admin.users.index') }}"
             class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl transition-all">
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                 <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                 <circle cx="9" cy="7" r="4" />
                 <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                 <path d="M16 3.13a4 4 0 0 1 0 7.75" />
             </svg>
             Students
         </a>
         {{-- <a href="#"
             class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-xl transition-all">
             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                 <path
                     d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                 <circle cx="12" cy="12" r="3" />
             </svg>
             Settings
         </a> --}}
     </nav>
     <div class="p-4 border-t border-slate-100">
         <form action="{{ route('logout') }}" method="post">
             @csrf
             <button
                 class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition-all font-semibold">
                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                     <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                     <polyline points="16 17 21 12 16 7" />
                     <line x1="21" x2="9" y1="12" y2="12" />
                 </svg>
                 Logout
             </button>
         </form>
     </div>
 </aside>

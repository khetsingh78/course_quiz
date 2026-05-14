<header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
    <h2 class="text-xl font-bold">Performance Overview</h2>
    <div class="flex items-center gap-4">
        <button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full relative">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
            </svg>
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
        </button>
        <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Alex" alt="Avatar"
                class="w-10 h-10 rounded-full border border-slate-200">
            <div class="hidden md:block">
                <p class="text-sm font-semibold">{{Auth::user()->name}}</p>
                <p class="text-xs text-slate-500">Instructor</p>
            </div>
        </div>
    </div>
</header>

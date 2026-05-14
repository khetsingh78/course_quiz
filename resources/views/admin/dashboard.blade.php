@extends('admin/layout/app')
@section('title', 'Dashboard')
@section('content')
    <div class="flex-1 overflow-y-auto p-8">
        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">$12,450</h3>
                    <p class="text-xs text-emerald-600 font-semibold mt-2">↑ 12% from last month</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Active Students</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">4,280</h3>
                    <p class="text-xs text-emerald-600 font-semibold mt-2">↑ 8% from last month</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Course Ratings</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">4.8/5.0</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-2">Based on 1.2k reviews</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Completion Rate</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">76%</h3>
                    <p class="text-xs text-amber-600 font-semibold mt-2">↓ 2% from last month</p>
                </div>
            </div>

            <!-- Charts Section -->
            {{-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Bar Chart -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-slate-800">Course Performance</h3>
                        <select class="text-xs border-none bg-slate-50 rounded-lg px-2 py-1 outline-none">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                        </select>
                    </div>
                    <div class="flex items-end justify-between h-48 gap-2">
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative group">
                                <div
                                    class="absolute bottom-0 w-full bg-indigo-600 rounded-t-lg h-[60%] group-hover:h-[70%] transition-all">
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">MON</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative group">
                                <div
                                    class="absolute bottom-0 w-full bg-indigo-600 rounded-t-lg h-[40%] group-hover:h-[50%] transition-all">
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">TUE</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative group">
                                <div
                                    class="absolute bottom-0 w-full bg-indigo-600 rounded-t-lg h-[85%] group-hover:h-[95%] transition-all">
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">WED</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative group">
                                <div
                                    class="absolute bottom-0 w-full bg-indigo-600 rounded-t-lg h-[55%] group-hover:h-[65%] transition-all">
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">THU</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative group">
                                <div
                                    class="absolute bottom-0 w-full bg-indigo-600 rounded-t-lg h-[70%] group-hover:h-[80%] transition-all">
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">FRI</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative group">
                                <div
                                    class="absolute bottom-0 w-full bg-indigo-600 rounded-t-lg h-[30%] group-hover:h-[40%] transition-all">
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">SAT</span>
                        </div>
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative group">
                                <div
                                    class="absolute bottom-0 w-full bg-indigo-600 rounded-t-lg h-[90%] group-hover:h-[100%] transition-all">
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">SUN</span>
                        </div>
                    </div>
                </div>

                <!-- Line Chart Placeholder -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-slate-800">Student Enrollment</h3>
                        <div class="flex gap-2">
                            <span class="flex items-center gap-1 text-[10px] font-bold text-slate-400"><span
                                    class="w-2 h-2 bg-indigo-600 rounded-full"></span> This Year</span>
                            <span class="flex items-center gap-1 text-[10px] font-bold text-slate-400"><span
                                    class="w-2 h-2 bg-slate-200 rounded-full"></span> Last Year</span>
                        </div>
                    </div>
                    <div class="relative h-48 flex items-center justify-center">
                        <svg class="w-full h-full" viewBox="0 0 400 100">
                            <path d="M0,80 Q50,20 100,60 T200,40 T300,70 T400,30" fill="none" stroke="#4f46e5"
                                stroke-width="3" />
                            <path d="M0,90 Q50,70 100,85 T200,75 T300,80 T400,65" fill="none" stroke="#e2e8f0"
                                stroke-width="2" stroke-dasharray="4" />
                        </svg>
                        <div
                            class="absolute bottom-0 w-full flex justify-between text-[10px] font-bold text-slate-400 px-2">
                            <span>JAN</span><span>MAR</span><span>MAY</span><span>JUL</span><span>SEP</span><span>NOV</span>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Recent Activity -->
            {{-- <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">Recent Enrollments</h3>
                    <button class="text-sm font-semibold text-indigo-600 hover:underline">View All</button>
                </div>
                <div class="divide-y divide-slate-50">
                    <div class="px-8 py-4 flex items-center justify-between hover:bg-slate-50 transition-all">
                        <div class="flex items-center gap-4">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah"
                                class="w-10 h-10 rounded-full bg-indigo-50">
                            <div>
                                <p class="text-sm font-bold">Sarah Miller</p>
                                <p class="text-xs text-slate-500">Enrolled in "Mastering React 19"</p>
                            </div>
                        </div>
                        <span class="text-xs font-medium text-slate-400">2 mins ago</span>
                    </div>
                    <div class="px-8 py-4 flex items-center justify-between hover:bg-slate-50 transition-all">
                        <div class="flex items-center gap-4">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=John"
                                class="w-10 h-10 rounded-full bg-indigo-50">
                            <div>
                                <p class="text-sm font-bold">John Doe</p>
                                <p class="text-xs text-slate-500">Enrolled in "UI Design Fundamentals"</p>
                            </div>
                        </div>
                        <span class="text-xs font-medium text-slate-400">1 hour ago</span>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

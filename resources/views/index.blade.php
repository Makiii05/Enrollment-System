<x-layout>
    <div class="flex self-center m-auto justify-center w-full p-6"> <!--center this x-->
    
        <div class="w-full max-w-3xl">
            <div class="text-center space-y-2 mb-12">
                <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                    DEPARTMENTS
                </h2>
                <p class="text-slate-500 text-lg">Please select your department to continue to login.</p>
            </div>
    
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-8">
                
                <a href="{{ route('registrar.login') }}" class="group relative flex flex-col items-center justify-center p-8 bg-white rounded-3xl shadow-sm border border-slate-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-indigo-200">
                    <div class="mb-4 p-4 bg-indigo-50 rounded-2xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-wide">REGISTRAR</span>
                    <p class="mt-2 text-sm text-slate-400 text-center">List & Records</p>
                </a>
    
                <a href="{{ route('accounting.login') }}" class="group relative flex flex-col items-center justify-center p-8 bg-white rounded-3xl shadow-sm border border-slate-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-emerald-200">
                    <div class="mb-4 p-4 bg-emerald-50 rounded-2xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
    
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-wide">ACCOUNTING</span>
                    <p class="mt-2 text-sm text-slate-400 text-center">Fees & Payments</p>
                </a>
    
                <a href="#" class="group relative flex flex-col items-center justify-center p-8 bg-white rounded-3xl shadow-sm border border-slate-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-orange-200">
                    <div class="mb-4 p-4 bg-orange-50 rounded-2xl text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-wide">ADMISSIONS</span>
                    <p class="mt-2 text-sm text-slate-400 text-center">New Enrollees</p>
                </a>
    
                <a href="{{ route('applicant.form') }}" class="group relative flex flex-col items-center justify-center p-8 bg-white rounded-3xl shadow-sm border border-slate-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:border-cyan-200">
                    <div class="mb-4 p-4 bg-cyan-50 rounded-2xl text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>

                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-wide">APPLICATION</span>
                    <p class="mt-2 text-sm text-slate-400 text-center">Application Form</p>
                </a>
    
            </div>
    
            <p class="mt-16 text-center text-slate-400 text-sm">
                &copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.
            </p>
        </div>
    
    </div>
</x-layout>
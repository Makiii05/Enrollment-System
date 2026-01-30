<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-base-200 flex items-center justify-center">
    <div class="w-full max-w-sm">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title justify-center text-2xl font-bold">
                    Admin Login
                </h2>
                <p class="text-center text-sm text-gray-500 mb-4">
                    Sign in to continue
                </p>
                <form class="space-y-4" method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email address</span>
                        </label>
                        <input autofocus name="email" type="email" placeholder="you@example.com" class="input input-bordered w-full" required/>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input name="password" type="password" placeholder="••••••••" class="input input-bordered w-full" required/>
                    </div>
                    @if ($errors->any())
                        <ul class="px-4 py-2 bg-red-100">
                            @foreach ($errors->all() as $error)
                                <li class="my-2 text-red-500">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-control mt-6">
                        <button class="btn btn-neutral w-full">
                            Login
                        </button>
                    </div>
                </form>
                <div class="text-center text-sm text-gray-500 mt-4">
                    © {{ date('Y') }} Enrollment System
                </div>
            </div>
        </div>
    </div>
</body>
</html>

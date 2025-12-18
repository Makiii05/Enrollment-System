@if($errors->any())
    <div class="alert alert-error shadow-lg m-4" role="alert">
        <div>
            <div>
                <h3 class="font-bold">Error!</h3>
                <div class="text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success shadow-lg m-4" role="alert">
        <div>
            <div>
                <h3 class="font-bold">Success!</h3>
                <div class="text-sm">{{ session('success') }}</div>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error shadow-lg m-4" role="alert">
        <div>
            <div>
                <h3 class="font-bold">Error!</h3>
                <div class="text-sm">{{ session('error') }}</div>
            </div>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning shadow-lg m-4" role="alert">
        <div>
            <div>
                <h3 class="font-bold">Warning!</h3>
                <div class="text-sm">{{ session('warning') }}</div>
            </div>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info shadow-lg m-4" role="alert">
        <div>
            <div>
                <h3 class="font-bold">Info</h3>
                <div class="text-sm">{{ session('info') }}</div>
            </div>
        </div>
    </div>
@endif

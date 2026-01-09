<x-admission_sidebar>

    <div class="m-4 font-bold text-4xl">
        <h2>Applicant</h2>
    </div>

    @include('partials.notifications')
    @include('partials.applicant-modal')
    
    <!--TABLE-->
    <div class="overflow-x-auto bg-white shadow">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $applicant)
                <tr>
                    <td><input type="checkbox" value="{{ $applicant->id }}"></td>
                    <td>{{$applicant->id}}</td>
                    <td>{{$applicant->application_no}}</td>
                    <td>{{$applicant->first_name}} {{$applicant->last_name}}</td>
                    <td>{{$applicant->status}}</td>
                    <td>
                        <button 
                            type="button" 
                            class="btn btn-sm btn-ghost text-primary"
                            onclick="openApplicantModal({{ json_encode($applicant) }})"
                        >
                            View Details
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $applicants->links() }}
    </div>

</x-admission_sidebar>
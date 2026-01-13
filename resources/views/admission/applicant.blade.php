<x-admission_sidebar>

    <div class="flex">
        <h2 class="m-4 font-bold text-4xl">Applicant</h2>
        <div class="ms-auto flex gap-2">
            <select name="schedule" class="select select-bordered" required>
                <option value="">Select Schedule</option>
                @foreach ($schedules as $schedule)
                <option value="{{ $schedule->id }}">{{ date('Y-m-d', strtotime($schedule->date)) }} | {{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</option>
                @endforeach
            </select>
            <button class="btn bg-black text-white disabled">Mark For Interview</button>
        </div>
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
                    <th>Id</th>
                    <th>Application No.</th>
                    <th>Applicant Name</th>
                    <th>Status</th>
                    <th>Details</th>
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
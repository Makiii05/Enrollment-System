<x-admission_sidebar>

    @include('partials.notifications')
    @include('partials.applicant-modal')
    @include('partials.edit-interview-modal')

    <form id="interviewForm" action="" method="POST">
        @csrf
        
        <div class="flex items-center gap-4 mb-4">
            <h2 class="font-bold text-4xl flex-1">Applicant (for interview)</h2>
            <select name="schedule_id" id="scheduleSelect" class="select select-bordered ms-auto" required>
                <option value="">Select Schedule</option>
                @foreach ($schedules as $schedule)
                <option value="{{ $schedule->id }}">{{ date('Y-m-d', strtotime($schedule->date)) }} | {{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</option>
                @endforeach
            </select>
            <button 
                type="submit" 
                id="markInterviewBtn"
                class="btn bg-gray-400 text-white cursor-not-allowed"
                disabled
            >
                Mark For Interview
            </button>
        </div>
        
        <!--TABLE-->
        <div class="overflow-x-auto bg-white shadow">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" class="checkbox">
                        </th>
                        <th>Id</th>
                        <th>Application No.</th>
                        <th>Applicant Name</th>
                        <th>Score</th>
                        <th>Remark</th>
                        <th>Result</th>
                        <th>Schedule</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applicants as $applicant)
                    <tr>
                        <td>
                            <input type="checkbox" name="applicant_ids[]" value="{{ $applicant->id }}" class="checkbox applicant-checkbox">
                        </td>
                        <td>{{$applicant->id}}</td>
                        <td>{{$applicant->applicant->application_no}}</td>
                        <td>{{$applicant->applicant->first_name}} {{$applicant->applicant->last_name}}</td>
                        <td>{{$applicant->interview_score ?? '-'}}</td>
                        <td>{{$applicant->interview_remark ?? '-'}}</td>
                        <td>{{$applicant->interview_result}}</td>
                        <td>{{date('Y-m-d', strtotime($applicant->interviewSchedule->date))}} | {{ date('g:i A', strtotime($applicant->interviewSchedule->start_time)) }} - {{ date('g:i A', strtotime($applicant->interviewSchedule->end_time)) }}</td>
                        <td>
                            <button 
                                type="button" 
                                class="btn btn-sm btn-ghost text-primary"
                                onclick="openApplicantModal({{ json_encode($applicant->applicant) }})">
                                View Details
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-sm btn-ghost text-yellow-600"
                                onclick="openInterviewEditModal({{ json_encode($applicant) }})">
                                Edit Score/Remarks
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
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleSelect = document.getElementById('scheduleSelect');
            const markInterviewBtn = document.getElementById('markInterviewBtn');
            const selectAllCheckbox = document.getElementById('selectAll');
            const applicantCheckboxes = document.querySelectorAll('.applicant-checkbox');

            function updateButtonState() {
                const scheduleSelected = scheduleSelect.value !== '';
                const anyChecked = Array.from(applicantCheckboxes).some(cb => cb.checked);
                
                if (scheduleSelected && anyChecked) {
                    markInterviewBtn.disabled = false;
                    markInterviewBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    markInterviewBtn.classList.add('bg-black', 'hover:bg-gray-800');
                } else {
                    markInterviewBtn.disabled = true;
                    markInterviewBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    markInterviewBtn.classList.remove('bg-black', 'hover:bg-gray-800');
                }
            }

            // Schedule select change
            scheduleSelect.addEventListener('change', updateButtonState);

            // Individual checkbox change
            applicantCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Update select all checkbox state
                    const allChecked = Array.from(applicantCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(applicantCheckboxes).some(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                    
                    updateButtonState();
                });
            });

            // Select all checkbox
            selectAllCheckbox.addEventListener('change', function() {
                applicantCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateButtonState();
            });

            // Initial state
            updateButtonState();
        });
    </script>

</x-admission_sidebar>
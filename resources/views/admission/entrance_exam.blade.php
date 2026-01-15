<x-admission_sidebar>

    @include('partials.notifications')
    @include('partials.applicant-modal')
    @include('partials.edit-exam-modal')

    <form id="examForm" action="{{ route('admission.applicant.mark-evaluation') }}" method="POST">
        @csrf
        
        <div class="flex items-center gap-4 mb-4">
            <h2 class="font-bold text-4xl flex-1">Applicant (for examination)</h2>
            <button 
                type="submit" 
                id="markEvalBtn"
                class="btn bg-gray-400 text-white cursor-not-allowed"
                disabled
            >
                Mark For Evaluation
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
                        <th>Math Score</th>
                        <th>Science Score</th>
                        <th>English Score</th>
                        <th>Filipino Score</th>
                        <th>Abstract Score</th>
                        <th>Total Score</th>
                        <th>Schedule</th>
                        <th>Result</th>
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
                        <td>{{$applicant->math_score ?? '-'}}</td>
                        <td>{{$applicant->science_score ?? '-'}}</td>
                        <td>{{$applicant->english_score ?? '-'}}</td>
                        <td>{{$applicant->filipino_score ?? '-'}}</td>
                        <td>{{$applicant->abstract_score ?? '-'}}</td>
                        <td>{{$applicant->exam_score ?? '-'}}</td>
                        <td>{{date('Y-m-d', strtotime($applicant->examSchedule->date))}} | {{ date('g:i A', strtotime($applicant->examSchedule->start_time)) }} - {{ date('g:i A', strtotime($applicant->examSchedule->end_time)) }}</td>
                        <td>{{$applicant->exam_result}}</td>
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
                                onclick="openExamEditModal({{ json_encode($applicant) }})">
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
            const markEvalBtn = document.getElementById('markEvalBtn');
            const selectAllCheckbox = document.getElementById('selectAll');
            const applicantCheckboxes = document.querySelectorAll('.applicant-checkbox');

            function updateButtonState() {
                const anyChecked = Array.from(applicantCheckboxes).some(cb => cb.checked);
                
                if (anyChecked) {
                    markEvalBtn.disabled = false;
                    markEvalBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    markEvalBtn.classList.add('bg-black', 'hover:bg-gray-800');
                } else {
                    markEvalBtn.disabled = true;
                    markEvalBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    markEvalBtn.classList.remove('bg-black', 'hover:bg-gray-800');
                }
            }


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
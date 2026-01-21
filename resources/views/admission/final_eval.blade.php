<x-admission_sidebar>

    @include('partials.notifications')
    @include('partials.applicant-modal')
    @include('partials.final-evaluation-modal')

    <form id="admitForm" action="{{ route('admission.evaluation.admit') }}" method="POST">
        @csrf
        
        <div class="flex items-center gap-4 mb-4">
            <h2 class="font-bold text-4xl flex-1">Applicant (for evaluation)</h2>
            <button 
                type="submit" 
                id="admitButton"
                class="btn bg-gray-400 text-white cursor-not-allowed"
                disabled
            >
                Admit Selected Applicants
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
                        <th>Final Score</th>
                        <th>Decision</th>
                        <th>Evaluated By</th>
                        <th>Evaluated At</th>
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
                        <td>{{$applicant->final_score ?? '-'}}</td>
                        <td>{{$applicant->decision }}</td>
                        <td>{{$applicant->evaluated_by ?? '-'}}</td>
                        <td>{{$applicant->evaluated_at ?? '-'}}</td>
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
                                onclick="openFinalEvaluationModal({{ json_encode($applicant) }}, {{ json_encode($applicant->applicant) }})">
                                Edit Decision/Department
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
            const admitButton = document.getElementById('admitButton');
            const selectAllCheckbox = document.getElementById('selectAll');
            const applicantCheckboxes = document.querySelectorAll('.applicant-checkbox');

            function updateButtonState() {
                const anyChecked = Array.from(applicantCheckboxes).some(cb => cb.checked);
                
                if (anyChecked) {
                    admitButton.disabled = false;
                    admitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    admitButton.classList.add('bg-black', 'hover:bg-gray-800');
                } else {
                    admitButton.disabled = true;
                    admitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                    admitButton.classList.remove('bg-black', 'hover:bg-gray-800');
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
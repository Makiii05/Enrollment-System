<x-admission_sidebar>

    @include('partials.notifications')
    @include('partials.applicant-modal')

    <div class="flex items-center gap-4 mb-4">
        <h2 class="font-bold text-4xl flex-1">Applicant</h2>
        
        <form id="deleteForm" action="{{ route('admission.applicant.delete') }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="applicant_ids[]" id="deleteApplicantIds">
            <button 
                type="button" 
                id="deleteBtn"
                onclick="confirmDelete()"
                class="btn bg-gray-400 text-white cursor-not-allowed"
                disabled
            >
                Delete Selected
            </button>
        </form>
    </div>

    <form id="interviewForm" action="{{ route('admission.applicant.mark-interview') }}" method="POST">
        @csrf
        
        <div class="flex justify-end items-center gap-4 mb-4">
            <select name="schedule_id" id="scheduleSelect" class="select select-bordered" required>
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
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applicants as $applicant)
                    <tr>
                        <td>
                            <input 
                                type="checkbox" 
                                name="applicant_ids[]" 
                                value="{{ $applicant->id }}" 
                                class="checkbox applicant-checkbox"
                                data-status="{{ $applicant->status }}"
                            >
                        </td>
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
                            @if($applicant->status !== 'admitted')
                            <button 
                                type="button" 
                                class="btn btn-sm btn-ghost text-red-600"
                                onclick="confirmSingleDelete({{ $applicant->id }}, '{{ $applicant->first_name }} {{ $applicant->last_name }}')"
                            >
                                Delete
                            </button>
                            @endif
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

    @include('partials.applicant-delete-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleSelect = document.getElementById('scheduleSelect');
            const markInterviewBtn = document.getElementById('markInterviewBtn');
            const deleteBtn = document.getElementById('deleteBtn');
            const selectAllCheckbox = document.getElementById('selectAll');
            const applicantCheckboxes = document.querySelectorAll('.applicant-checkbox');

            function updateButtonState() {
                const scheduleSelected = scheduleSelect.value !== '';
                const anyChecked = Array.from(applicantCheckboxes).some(cb => cb.checked);
                
                // Check if any non-admitted applicants are selected for delete button
                const anyDeletableChecked = Array.from(applicantCheckboxes).some(cb => cb.checked && cb.dataset.status !== 'admitted');
                
                // Mark Interview Button
                if (scheduleSelected && anyChecked) {
                    markInterviewBtn.disabled = false;
                    markInterviewBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    markInterviewBtn.classList.add('bg-black', 'hover:bg-gray-800');
                } else {
                    markInterviewBtn.disabled = true;
                    markInterviewBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    markInterviewBtn.classList.remove('bg-black', 'hover:bg-gray-800');
                }

                // Delete Button - only enable if non-admitted applicants are selected
                if (anyDeletableChecked) {
                    deleteBtn.disabled = false;
                    deleteBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    deleteBtn.classList.add('bg-red-600', 'hover:bg-red-700');
                } else {
                    deleteBtn.disabled = true;
                    deleteBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    deleteBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
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

        function confirmDelete() {
            document.getElementById('deleteConfirmModal').showModal();
        }

        function submitDelete() {
            const deleteForm = document.getElementById('deleteForm');
            const applicantCheckboxes = document.querySelectorAll('.applicant-checkbox:checked');
            
            // Clear existing hidden inputs
            const existingInputs = deleteForm.querySelectorAll('input[name="applicant_ids[]"]:not(#deleteApplicantIds)');
            existingInputs.forEach(input => input.remove());
            
            // Add hidden inputs for each selected applicant
            applicantCheckboxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'applicant_ids[]';
                input.value = checkbox.value;
                deleteForm.appendChild(input);
            });
            
            // Remove the placeholder input
            document.getElementById('deleteApplicantIds').remove();
            
            // Submit the form
            deleteForm.submit();
        }

        let singleDeleteApplicantId = null;

        function confirmSingleDelete(id, name) {
            singleDeleteApplicantId = id;
            document.getElementById('singleDeleteName').textContent = name;
            document.getElementById('singleDeleteConfirmModal').showModal();
        }

        function submitSingleDelete() {
            document.getElementById('singleDeleteId').value = singleDeleteApplicantId;
            document.getElementById('singleDeleteForm').submit();
        }
    </script>

</x-admission_sidebar>
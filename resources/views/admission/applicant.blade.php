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
            <select name="action" id="actionSelect" class="select select-bordered" required>
                <option value="">Select Action</option>
                <option value="markForInterview">Mark For Interview</option>
                <option value="markForExamination">Mark For Examination</option>
                <option value="markForEvaluation">Mark For Evaluation</option>
            </select>
            <div class="relative">
                <select name="schedule_id" id="scheduleSelect" class="select select-bordered min-w-[250px]" required>
                    <option value="">Select Schedule</option>
                </select>
                <div id="scheduleLoading" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 rounded-lg opacity-0 pointer-events-none transition-opacity duration-200">
                    <span class="loading loading-spinner loading-sm"></span>
                </div>
            </div>
            <button type="submit" id="proceedBtn" class="btn bg-gray-400 text-white cursor-not-allowed" disabled>
                Proceed
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
                            <a href="{{ route('admission.print.applicant.details', ['id' => $applicant->id]) }}" target="_blank" type="button" 
                                class="btn btn-sm btn-ghost text-success">
                                Print
                            </a>
                            <button type="button" 
                                class="btn btn-sm btn-ghost text-primary"
                                onclick="openApplicantModal({{ json_encode($applicant) }}, {{ json_encode($applicant->admission) }})"
                            >
                                View Details
                            </button>
                            @if($applicant->status !== 'admitted')
                            <button type="button" 
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
            const actionSelect = document.getElementById('actionSelect');
            const scheduleSelect = document.getElementById('scheduleSelect');
            const scheduleLoading = document.getElementById('scheduleLoading');
            const proceedBtn = document.getElementById('proceedBtn');
            const deleteBtn = document.getElementById('deleteBtn');
            const selectAllCheckbox = document.getElementById('selectAll');
            const applicantCheckboxes = document.querySelectorAll('.applicant-checkbox');

            function updateButtonState() {
                const actionSelected = actionSelect.value !== '';
                const scheduleSelected = scheduleSelect.value !== '';
                const anyChecked = Array.from(applicantCheckboxes).some(cb => cb.checked);
                const isEvaluation = actionSelect.value === 'markForEvaluation';
                
                // Check if any non-admitted applicants are selected for delete button
                const anyDeletableChecked = Array.from(applicantCheckboxes).some(cb => cb.checked && cb.dataset.status !== 'admitted');
                
                // Proceed Button - requires action, schedule, and selected applicants
                const canProceed = actionSelected && anyChecked && scheduleSelected;
                if (canProceed) {
                    proceedBtn.disabled = false;
                    proceedBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    proceedBtn.classList.add('bg-black', 'hover:bg-gray-800');
                } else {
                    proceedBtn.disabled = true;
                    proceedBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                    proceedBtn.classList.remove('bg-black', 'hover:bg-gray-800');
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

            // Async function to load schedules based on action
            async function loadSchedules(processType) {
                scheduleSelect.innerHTML = '<option value="">Select Schedule</option>';
                
                if (!processType) {
                    scheduleSelect.disabled = false;
                    updateButtonState();
                    return;
                }



                scheduleLoading.classList.remove('opacity-0', 'pointer-events-none');
                scheduleSelect.disabled = true;

                try {
                    const response = await fetch(`{{ route('admission.api.schedules') }}?process=${processType}`);
                    const data = await response.json();

                    scheduleSelect.innerHTML = '<option value="">Select Schedule</option>';
                    
                    if (data.success && data.data.length > 0) {
                        data.data.forEach(schedule => {
                            const option = document.createElement('option');
                            option.value = schedule.id;
                            option.textContent = schedule.label;
                            scheduleSelect.appendChild(option);
                        });
                    } else {
                        scheduleSelect.innerHTML = '<option value="">No schedules available</option>';
                    }
                } catch (error) {
                    console.error('Error loading schedules:', error);
                    scheduleSelect.innerHTML = '<option value="">Error loading schedules</option>';
                } finally {
                    scheduleLoading.classList.add('opacity-0', 'pointer-events-none');
                    scheduleSelect.disabled = false;
                    updateButtonState();
                }
            }

            // Action select change - load corresponding schedules
            actionSelect.addEventListener('change', function() {
                const action = this.value;
                let processType = '';
                
                if (action === 'markForInterview') {
                    processType = 'interview';
                } else if (action === 'markForExamination') {
                    processType = 'exam';
                } else if (action === 'markForEvaluation') {
                    processType = 'evaluation';
                }
                
                loadSchedules(processType);
            });

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
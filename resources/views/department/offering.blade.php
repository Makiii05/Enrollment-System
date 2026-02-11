<x-department_sidebar>

    @include('partials.notifications')
    @include('partials.dept-student-full-modal')

    <div class="flex items-center gap-4 mb-4">
        <h2 class="font-bold text-4xl">Subject Offering</h2>
        @if(isset($academicTerm))
            <h2 class="flex-1 text-2xl"><span>(Academic Term: <strong>{{ $academicTerm->description }}</strong>)</span></h2>
        @endif
    </div>
    
    <div class="flex gap-5">
        <!--PROSPECTUS TABLE-->
        <div class="overflow-x-auto bg-white shadow w-1/2">
            <div class="p-4">
                <form action="{{ route('department.subject_offering.search') }}" method="POST" class="grow flex gap-2 items-center">
                    @csrf
                    @if(isset($academicTerm))
                    <input type="hidden" name="academic_term_id" value="{{ $academicTerm->id }}" />
                    @endif
                    <select name="department" id="departmentSelect" class="select select-bordered" required>
                        <option value="">--Select Department--</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @if(isset($old_department) && $old_department == $department->id) selected @endif>{{ $department->description }}</option>
                        @endforeach
                    </select>
                    <select name="curriculum" id="curriculumSelect" class="select select-bordered" required>
                        <option value="">--Select Curriculum--</option>
                    </select>
                    <button type="submit" class="btn bg-white">Search</button>
                </form>
            </div>
            <div>
                @if(isset($prospectuses))
                    <div id="prospectusContainer">
                    @if ($prospectuses->count() > 0)
                    <div class="m-4">
                        @foreach ($prospectuses->groupBy('level_id') as $levelId => $groupedByLevel)
                        @php
                            $level = $groupedByLevel->first()->level;
                        @endphp
                        <details class="collapse bg-base-100 border-base-300 border mb-3">
                            <summary class="collapse-title font-semibold">{{ $level->program->code}} - {{ $level->description }}</summary>
                            <div class="collapse-content text-sm">
                                <table class="table table-zebra">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($groupedByLevel as $prospectus)
                                        <tr data-prospectus-id="{{ $prospectus->id }}">
                                            <td>{{ $prospectus->subject->code }}</td>
                                            <td>{{ $prospectus->subject->description }}</td>
                                            <td>{{ $prospectus->subject->unit }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>  
                        </details>
                        @endforeach
                    </div>
                    @else
                    <div class="m-4 alert bg-blue-400 text-white">
                        <span>No prospectuses found for the selected criteria.</span>
                    </div>
                    @endif
                    </div>
                @else
                    <div id="prospectusContainer"></div>
                @endif
            </div>
        </div>
    
        <!--SUBJECT OFFERING TABLE-->
        <div class="overflow-x-auto bg-white shadow w-1/2">
            <div class="p-4">
                <h3 class="font-semibold text-lg">Subject Offerings</h3>
            </div>
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Units</th>
                        <th>Final Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($subjectOfferings) && $subjectOfferings->count() > 0)
                        @foreach ($subjectOfferings as $offering)
                        <tr>
                            <td>{{ $offering->id }}</td>
                            <td>{{ $offering->code }}</td>
                            <td>{{ $offering->description }}</td>
                            <td>{{ $offering->subject->unit ?? '-' }}</td>
                            <td>-</td>
                            <td>
                                <button class="btn btn-sm btn-ghost text-primary font-semibold">View</button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-8">No subject offerings yet.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</x-department_sidebar>

<script>
    const curriculaApiUrl = '{{ url("/department/api/curricula-by-department") }}';

    // Load curricula by department
    async function loadCurriculaByDepartment(departmentId, selectElement, selectedCurriculumId = null) {
        if (!departmentId) {
            selectElement.innerHTML = '<option value="">--Select Curriculum--</option>';
            selectElement.disabled = false;
            return;
        }

        selectElement.innerHTML = '<option value="">Loading...</option>';
        selectElement.disabled = true;

        try {
            const response = await fetch(`${curriculaApiUrl}/${departmentId}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const curricula = await response.json();

            selectElement.innerHTML = '<option value="">--Select Curriculum--</option>';
            curricula.forEach(c => {
                const option = document.createElement('option');
                option.value = c.id;
                option.textContent = c.curriculum;
                if (selectedCurriculumId && c.id == selectedCurriculumId) {
                    option.selected = true;
                }
                selectElement.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading curricula:', error);
            selectElement.innerHTML = '<option value="">--Error loading curricula--</option>';
        } finally {
            selectElement.disabled = false;
        }
    }

    // Department change -> load curricula
    document.getElementById('departmentSelect').addEventListener('change', function() {
        const curriculumSelect = document.getElementById('curriculumSelect');
        loadCurriculaByDepartment(this.value, curriculumSelect);
    });

    // On page load, if department is pre-selected (after search), load its curricula
    document.addEventListener('DOMContentLoaded', function() {
        const departmentSelect = document.getElementById('departmentSelect');
        const curriculumSelect = document.getElementById('curriculumSelect');
        if (departmentSelect.value) {
            const oldCurriculum = '{{ $old_curriculum ?? '' }}';
            loadCurriculaByDepartment(departmentSelect.value, curriculumSelect, oldCurriculum || null);
        }
    });
</script>        
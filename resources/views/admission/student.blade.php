<x-admission_sidebar>

    @include('partials.notifications')
    @include('partials.student-detail-modal')
    @include('partials.student-contact-modal')
    @include('partials.student-guardian-modal')
    @include('partials.student-academic-history-modal')

    <div class="flex items-center gap-4 mb-4">
        <h2 class="font-bold text-4xl flex-1">Students</h2>
    </div>
    
    <!--TABLE-->
    <div data-table-wrapper>
    <div class="overflow-x-auto bg-white shadow">
        <table class="table" data-sortable-table>
            <!-- head -->
            <thead>
                <tr>
                    <th>Student No.</th>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Program</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th data-no-sort>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr>
                    <td>{{ $student->student_number }}</td>
                    <td>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</td>
                    <td>{{ $student->department->code ?? '-' }}</td>
                    <td>{{ $student->program->code ?? '-' }}</td>
                    <td>{{ $student->level->code ?? '-' }}</td>
                    <td>{{ ucfirst($student->status) }}</td>
                    <td>
                        <div class="flex gap-1 flex-wrap">
                            <button 
                                type="button" 
                                class="btn btn-xs btn-primary"
                                onclick="openStudentDetailModal({{ json_encode($student->load(['department', 'program', 'level'])) }})"
                            >
                                Details
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-xs btn-info"
                                onclick="openStudentContactModal({{ json_encode($student->contact) }}, '{{ $student->student_number }}')"
                            >
                                Contact
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-xs btn-secondary"
                                onclick="openStudentGuardianModal({{ json_encode($student->guardian) }}, '{{ $student->student_number }}')"
                            >
                                Guardian
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-xs btn-accent"
                                onclick="openStudentAcademicHistoryModal({{ json_encode($student->academicHistory) }}, '{{ $student->student_number }}')"
                            >
                                Academic
                            </button>
                            <a 
                                href="{{ route('admission.student.edit', $student->id) }}" 
                                class="btn btn-xs btn-warning"
                            >
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-8">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>

    @include('partials.table-sort-search')

</x-admission_sidebar>        
<x-department_sidebar>

    @include('partials.notifications')
    @include('partials.dept-student-full-modal')

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
                    <td>{{ $student->program->code ?? '-' }}</td>
                    <td>{{ $student->level->description ?? '-' }}</td>
                    <td>{{ ucfirst($student->status) }}</td>
                    <td>
                        <div class="flex gap-1 flex-wrap">
                            <button 
                                type="button" 
                                class="btn btn-sm btn-ghost text-primary font-semibold"
                                onclick="openDeptStudentFullModal({{ json_encode($student->load(['department', 'program', 'level'])) }}, {{ json_encode($student->contact) }}, {{ json_encode($student->guardian) }}, {{ json_encode($student->academicHistory) }})"
                            >
                                Details
                            </button>
                            <a 
                                href="{{ route('department.student.edit', $student->id) }}" 
                                class="btn btn-sm btn-ghost text-amber-600 font-semibold"
                            >
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-8">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>

    @include('partials.table-sort-search')


</x-department_sidebar>        
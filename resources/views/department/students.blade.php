<x-department_sidebar>

    @include('partials.notifications')
    @include('partials.dept-student-full-modal')

    <div class="flex items-center gap-4 mb-4">
        <h2 class="font-bold text-4xl flex-1">Students</h2>
        <div class="flex gap-2">
            <input type="text" id="searchInput" placeholder="Search students..." class="input input-bordered w-64" />
            <select id="statusFilter" class="select select-bordered">
                <option value="">All Status</option>
                <option value="enrolled">Enrolled</option>
                <option value="withdrawn">Withdrawn</option>
                <option value="dropped">Dropped</option>
                <option value="graduated">Graduated</option>
            </select>
        </div>
    </div>
    
    <!--TABLE-->
    <div class="overflow-x-auto bg-white shadow">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Student No.</th>
                    <th>Full Name</th>
                    <th>Program</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                                href="" 
                                class="btn btn-sm btn-ghost text-green-600 font-semibold"
                            >
                                Schedule
                            </a>
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
    
    @if(isset($students) && $students->hasPages())
    <div class="mt-4">
        {{ $students->links() }}
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const tableRows = document.querySelectorAll('tbody tr');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const statusCell = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase().trim() || '';
                    
                    const matchesSearch = text.includes(searchTerm);
                    const matchesStatus = statusValue === '' || statusCell.includes(statusValue);
                    
                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                });
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });
    </script>

</x-department_sidebar>        
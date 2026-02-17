<x-registrar_sidebar>

    <div class="m-4 font-bold text-4xl">
        <h2>Students</h2>
    </div>

    @include('partials.notifications')

    <!--TABLE-->
    <div data-table-wrapper>
    <div class="overflow-x-auto bg-white shadow">
        <table class="table" data-sortable-table>
            <thead>
                <tr>
                    <th>Student No.</th>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Program</th>
                    <th>Level</th>
                    <th data-no-sort>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr>
                    <td>{{ $student->student_number }}</td>
                    <td>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</td>
                    <td>{{ $student->department->code ?? '-' }}</td>
                    <td>{{ $student->program->code ?? '-' }}</td>
                    <td>{{ $student->level->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('registrar.student.assessment', $student->id) }}" class="btn btn-sm btn-ghost text-primary font-semibold">View</a>
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

</x-registrar_sidebar>

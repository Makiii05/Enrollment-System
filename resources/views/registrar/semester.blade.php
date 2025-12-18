<x-registrar_sidebar>

    <div class="m-4 font-bold text-4xl">
        <h2>Semester</h2>
    </div>

    @include('partials.notifications')
    <div class="m-4 grid">
        <button class="btn w-auto justify-self-end bg-white shadow" onclick="form_modal.showModal()">Add Semester</button>
    </div>
    <dialog id="form_modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold mb-4">Add Semester</h3>
            <form action="{{ route('registrar.semester.create') }}" method="POST" class="space-y-4 space-x-4 grid grid-cols-2">
                @csrf
                
                <div class="form-control col-span-2">
                    <label class="label">
                        <span class="label-text">Code</span>
                    </label>
                    <input type="text" name="code" class="input input-bordered w-full" placeholder="Enter semester code" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Description</span>
                    </label>
                    <input type="text" name="description" class="input input-bordered w-full" placeholder="Enter semester description" required>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Academic Year</span>
                    </label>
                    <input type="text" name="academic_year" class="input input-bordered w-full" placeholder="Enter semester academic year" required>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Start Date</span>
                    </label>
                    <input type="date" name="start_date" class="input input-bordered w-full" required>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">End Date</span>
                    </label>
                    <input type="date" name="end_date" class="input input-bordered w-full" required>
                </div>

                <div class="form-control col-span-2">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select name="status" class="select select-bordered w-full">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-action col-span-2">
                    <button type="button" class="btn" onclick="form_modal.close()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Semester</button>
                </div>
            </form>
        </div>
    </dialog>
    <!--TABLE-->
    <div class="overflow-x-auto bg-white shadow">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Academic Year</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($semesters as $semester)
                <tr>
                    <td>{{$semester->id}}</td>
                    <td>{{$semester->code}}</td>
                    <td>{{$semester->description ?? 'N/A'}}</td>
                    <td>{{$semester->academic_year ?? 'N/A'}}</td>
                    <td>{{$semester->start_date}}</td>
                    <td>{{$semester->end_date}}</td>
                    <td>{{$semester->status}}</td>
                    <td>
                        <button class="text-green-600 hover:underline" onclick="editSemester({{ $semester->id }}, '{{ $semester->code }}', '{{ $semester->start_date }}', '{{ $semester->end_date }}', '{{ $semester->status }}')">edit</button>
                        <form action="{{ route('registrar.semester.delete', $semester->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $semesters->links() }}
    </div>
    
    <script>
        function editSemester(id, code, startDate, endDate, status) {
            document.getElementById('form_modal').innerHTML = `
                <div class="modal-box w-11/12 max-w-5xl">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <h3 class="text-lg font-bold mb-4">Edit Semester</h3>
                    <form action="/registrar/semesters/${id}/update" method="POST" class="space-y-4 space-x-4 grid grid-cols-2">
                        @csrf
                        
                        <div class="form-control col-span-2">
                            <label class="label">
                                <span class="label-text">Code</span>
                            </label>
                            <input type="text" name="code" class="input input-bordered w-full" value="${code}" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Start Date</span>
                            </label>
                            <input type="date" name="start_date" class="input input-bordered w-full" value="${startDate}" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">End Date</span>
                            </label>
                            <input type="date" name="end_date" class="input input-bordered w-full" value="${endDate}" required>
                        </div>

                        <div class="form-control col-span-2">
                            <label class="label">
                                <span class="label-text">Status</span>
                            </label>
                            <select name="status" class="select select-bordered w-full">
                                <option value="active" ${status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>

                        <div class="modal-action col-span-2">
                            <button type="button" class="btn" onclick="form_modal.close()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Semester</button>
                        </div>
                    </form>
                </div>
            `;
            form_modal.showModal();
        }
    </script>
</x-registrar_sidebar>
<x-admission_sidebar>

    <div class="m-4 font-bold text-4xl">
        <h2>Schedule</h2>
    </div>

    @include('partials.notifications')
    <div class="m-4 grid">
        <button class="btn w-auto justify-self-end bg-white shadow" onclick="form_modal.showModal()">Add Schedule</button>
    </div>
    <dialog id="form_modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold mb-4">Add Schedule</h3>
            <form action="{{ route('admission.schedule.create') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Proctor</span>
                    </label>
                    <input type="text" name="proctor" class="input input-bordered w-full" placeholder="Enter proctor name" required>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Date</span>
                    </label>
                    <input type="date" name="date" class="input input-bordered w-full" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Start Time</span>
                        </label>
                        <input type="time" name="start_time" class="input input-bordered w-full" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">End Time</span>
                        </label>
                        <input type="time" name="end_time" class="input input-bordered w-full" required>
                    </div>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Process</span>
                    </label>
                    <select name="process" class="select select-bordered w-full">
                        <option value="exam">Exam</option>
                        <option value="interview">Interview</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Status</span>
                    </label>
                    <select name="status" class="select select-bordered w-full">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn" onclick="form_modal.close()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
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
                    <th>Proctor</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                <tr>
                    <td>{{$schedule->id}}</td>
                    <td>{{$schedule->proctor}}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->date)->format('M d, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
                    <td>{{ $schedule->process }}</td>
                    <td>{{ $schedule->status }}</td>
                    <td>
                        <button class="text-green-600 hover:underline" onclick="editSchedule({{ $schedule->id }}, '{{ $schedule->proctor }}', '{{ $schedule->date->format('Y-m-d') }}', '{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}', '{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}', '{{ $schedule->status }}', '{{ $schedule->process }}')">edit</button>
                        <form action="{{ route('admission.schedule.delete', $schedule->id) }}" method="POST" style="display:inline;">
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
        {{ $schedules->links() }}
    </div>
    
    <script>
        function editSchedule(id, proctor, date, start_time, end_time, status, process) {
            document.getElementById('form_modal').innerHTML = `
                <div class="modal-box w-11/12 max-w-5xl">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <h3 class="text-lg font-bold mb-4">Edit Schedule</h3>
                    <form action="/admission/schedules/${id}/update" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Proctor</span>
                            </label>
                            <input type="text" name="proctor" class="input input-bordered w-full" value="${proctor}" required>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Date</span>
                            </label>
                            <input type="date" name="date" class="input input-bordered w-full" value="${date}" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Start Time</span>
                                </label>
                                <input type="time" name="start_time" class="input input-bordered w-full" value="${start_time}" required>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">End Time</span>
                                </label>
                                <input type="time" name="end_time" class="input input-bordered w-full" value="${end_time}" required>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Process</span>
                            </label>
                            <select name="process" class="select select-bordered w-full">
                                <option value="exam" ${process === 'exam' ? 'selected' : ''}>Exam</option>
                                <option value="interview" ${process === 'interview' ? 'selected' : ''}>Interview</option>
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Status</span>
                            </label>
                            <select name="status" class="select select-bordered w-full">
                                <option value="active" ${status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>

                        <div class="modal-action">
                            <button type="button" class="btn" onclick="form_modal.close()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Schedule</button>
                        </div>
                    </form>
                </div>
            `;
            form_modal.showModal();
        }
    </script>
</x-admission_sidebar>

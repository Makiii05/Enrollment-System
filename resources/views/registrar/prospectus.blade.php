<x-registrar_sidebar>

    <div class="m-4 font-bold text-4xl">
        <h2>Prospectus</h2>
    </div>

    <div class="m-4 flex">
        <form action="{{ route('registrar.prospectus.search') }}" method="POST" class="grow">
            @csrf
            <select name="program" class="select select-bordered" required>
                <option value="">--Select Program--</option>
                @foreach ($programs as $program)
                <option value="{{ $program->id }}" @if(isset($old_program) && $old_program == $program->id) selected @endif>{{ $program->description }}</option>
                @endforeach
            </select>
            <select name="academic_year" class="select select-bordered" required>
                <option value="">--Select Academic Year--</option>
                <option value="2024 - 2025" @if(isset($old_academic_year) && $old_academic_year == "2024 - 2025") selected @endif>2024 - 2025</option>
                <option value="2025 - 2026" @if(isset($old_academic_year) && $old_academic_year == "2025 - 2026") selected @endif>2025 - 2026</option>
                <option value="2026 - 2027" @if(isset($old_academic_year) && $old_academic_year == "2026 - 2027") selected @endif>2026 - 2027</option>
                <option value="2027 - 2028" @if(isset($old_academic_year) && $old_academic_year == "2027 - 2028") selected @endif>2027 - 2028</option>
                <option value="2028 - 2029" @if(isset($old_academic_year) && $old_academic_year == "2028 - 2029") selected @endif>2028 - 2029</option>
                <option value="2029 - 2030" @if(isset($old_academic_year) && $old_academic_year == "2029 - 2030") selected @endif>2029 - 2030</option>
            </select>
            <button type="submit" class="btn bg-white">Search</button>
        </form>
        <button class="btn w-auto justify-self-end bg-white shadow" onclick="form_modal.showModal()">Add Prospectus</button>
    </div>

    <!-- Results Table -->
    @if(isset($prospectuses) && count($prospectuses) > 0)
    <div class="m-4">
        @foreach ($prospectuses->groupBy('semester_id') as $semesterId => $prospectusesBySemester)
            @php
                $semester = $prospectusesBySemester->first()->semester;
            @endphp
            <div class="mb-8">
                <h3 class="text-lg font-bold mb-4">{{ $semester->description }}</h3>
                <div class="overflow-x-auto bg-white shadow">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>Curriculum</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Lec Hour</th>
                                <th>Lab Hour</th>
                                <th>Lec Unit</th>
                                <th>Lab Unit</th>
                                <th>Total Unit</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prospectusesBySemester as $prospectus)
                            <tr>
                                <td>{{ $prospectus->curriculum->curriculum }}</td>
                                <td>{{ $prospectus->subject->code }}</td>
                                <td>{{ $prospectus->subject->description }}</td>
                                <td>{{ $prospectus->subject->lech }}</td>
                                <td>{{ $prospectus->subject->labh }}</td>
                                <td>{{ $prospectus->subject->lecu }}</td>
                                <td>{{ $prospectus->subject->labu }}</td>
                                <td>{{ $prospectus->subject->unit }}</td>
                                <td>{{ $prospectus->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-ghost" onclick="edit_modal_{{ $prospectus->id }}.showModal()">Edit</button>
                                    <form action="{{ route('registrar.prospectus.delete', $prospectus->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-ghost text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
    @elseif(isset($prospectuses))
    <div class="m-4 alert bg-blue-400 text-white">
        <span>No prospectuses found for the selected criteria.</span>
    </div>
    @endif
    <!--FORM-->
    <dialog id="form_modal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold mb-4">Add Prospectus</h3>
            <form action="{{ route('registrar.prospectus.insert') }}" method="POST" class="space-y-4 space-x-4 grid grid-cols-2">
                @csrf
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Curriculum</span>
                    </label>
                    <select name="curriculum" class="select select-bordered w-full">
                        @foreach ($curricula as $curriculum)
                        <option value="{{ $curriculum->id }}">{{ $curriculum->curriculum }} - {{$curriculum->program->description}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Semester</span>
                    </label>
                    <select name="semester" class="select select-bordered w-full">
                        @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}">{{ $semester->academic_year }} - {{ $semester->description }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Subject</span>
                    </label>
                    <select name="subject" class="select select-bordered w-full">
                        @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->description }}</option>
                        @endforeach
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

                <div class="modal-action col-span-2">
                    <button type="button" class="btn" onclick="form_modal.close()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Prospectus</button>
                </div>
            </form>
        </div>
    </dialog>

    @if(isset($prospectuses))
        @foreach ($prospectuses as $prospectus)
        <dialog id="edit_modal_{{ $prospectus->id }}" class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <h3 class="text-lg font-bold mb-4">Edit Prospectus</h3>
                <form action="{{ route('registrar.prospectus.update', $prospectus->id) }}" method="POST" class="space-y-4 space-x-4 grid grid-cols-2">
                    @csrf
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Curriculum</span>
                        </label>
                        <select name="curriculum" class="select select-bordered w-full">
                            @foreach ($curricula as $curriculum)
                            <option value="{{ $curriculum->id }}" @if($prospectus->curriculum_id == $curriculum->id) selected @endif>{{ $curriculum->curriculum }} - {{$curriculum->program->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Semester</span>
                        </label>
                        <select name="semester" class="select select-bordered w-full">
                            @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}" @if($prospectus->semester_id == $semester->id) selected @endif>{{ $semester->academic_year }} - {{ $semester->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Subject</span>
                        </label>
                        <select name="subject" class="select select-bordered w-full">
                            @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @if($prospectus->subject_id == $subject->id) selected @endif>{{ $subject->description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Status</span>
                        </label>
                        <select name="status" class="select select-bordered w-full">
                            <option value="active" @if($prospectus->status == 'active') selected @endif>Active</option>
                            <option value="inactive" @if($prospectus->status == 'inactive') selected @endif>Inactive</option>
                        </select>
                    </div>

                    <div class="modal-action col-span-2">
                        <button type="button" class="btn" onclick="edit_modal_{{ $prospectus->id }}.close()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Prospectus</button>
                    </div>
                </form>
            </div>
        </dialog>
        @endforeach
    @endif
</x-registrar_sidebar>
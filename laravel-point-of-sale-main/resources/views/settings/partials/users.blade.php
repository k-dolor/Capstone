<h5>Manage Users</h5>
<table class="table">
    <thead>
        <tr>
            {{-- <th>No.</th> --}}
            <th>Photo</th>
            <th>@sortablelink('name')</th>
            <th>@sortablelink('username')</th>
            <th>@sortablelink('email')</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $item)

        <tr>
            {{-- <td>{{ (($users->currentPage() * 10) - 10) + $loop->iteration  }}</td> --}}
            <td>
                <img class="avatar-60 rounded" src="{{ $item->photo ? asset('storage/profile/'.$item->photo) : asset('assets/images/user/1.png') }}">
            </td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->username }}</td>
            <td>{{ $item->email }}</td>
            <td>
                @foreach ($item->roles as $role)
                    <span class="badge bg-danger">{{ $role->name }}</span>
                @endforeach
            </td>
            <td>
                <form action="{{ route('users.destroy', $item->username) }}" method="POST" style="margin-bottom: 5px">
                    @method('delete')
                    @csrf
                    <div class="d-flex align-items-center list-action">
                        {{-- <a class="btn btn-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"
                            href="{{ route('users.show', $item->username) }}"><i class="ri-eye-line mr-0"></i>
                        </a> --}}
                        <a class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ route('users.edit', $item->username) }}"><i class="ri-pencil-line mr-0"></i>
                        </a>
                        <button type="submit" class="btn btn-warning mr-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="ri-delete-bin-line mr-0"></i></button>
                    </div>
                </form>
            </td>
        </tr>

{{-- <tr>

    <td>
        <img class="avatar-60 rounded" 
             src="{{ $item->photo ? asset('storage/profile/'.$item->photo) : asset('assets/images/user/1.png') }}">
    </td>
    <td>{{ $item->name }}</td>
    <td>{{ $item->username }}</td>
    <td>{{ $item->email }}</td>
    <td>
        @if ($item->roles->isNotEmpty())
            @foreach ($item->roles as $role)
                <span class="badge bg-danger">{{ $role->name }}</span>
            @endforeach
        @else
            <span class="badge bg-secondary">No Role Assigned</span>
        @endif
    </td>
</tr> --}}

@empty
<tr>
    <td colspan="7" class="text-center">No users found.</td>
</tr>
@endforelse

    </tbody>
</table>

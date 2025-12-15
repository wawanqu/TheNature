@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kelola Peran</h2>

    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-lime-300">
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Peran</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
		@foreach($users as $user)
		<tr>
        <td class="border px-4 py-2">{{ $user->name }}</td>
        <td class="border px-4 py-2">{{ $user->email }}</td>
        <td class="border px-4 py-2">{{ $user->role }}</td>
        <td class="border px-4 py-2">
            @if($user->role === 'super_admin')
                <span class="text-gray-500 italic">Tidak dapat diubah</span>
            @else
                <form action="{{ route('roles.update', $user) }}" method="POST" class="flex items-center space-x-2">
                    @csrf
                    <select name="role" class="border rounded px-2 py-1">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                </form>
            @endif
        </td>
		</tr>
		@endforeach
		</tbody>
    </table>
</div>
@endsection
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-12 justify-content-center">
            <div class="card">
                <div class="card-header">Roles <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary float-right">Add Role</a></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Role</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        {{ ucwords($role->name) }} <br>
                                        {{ ucfirst($role->description) }}
                                    </td>
                                    <td class="text-right">
                                        <form id="delete-company" action="{{ route('roles.delete', $role->id) }}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('delete')}}
                                            @if($role->permissions->count() > 0)
                                                <a href="{{ route('permissions.index',['role'=>$role->id]) }}" class="btn btn-default">Permissions</a>
                                            @endif
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">Edit</a>
                                            <button class="btn btn-danger btn-xs" onclick="confirmDelete(this.form)">delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $roles->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

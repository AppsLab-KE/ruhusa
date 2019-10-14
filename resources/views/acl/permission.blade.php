@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-12 justify-content-center">
            <div class="card">
                <div class="card-header">Permissions <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary float-right">Add Permission</a></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Permission</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>
                                        {{ ucwords($permission->name) }} <br>
                                        {{ ucfirst($permission->description) }}
                                    </td>
                                    <td class="text-right">
                                        <form id="delete-company" action="{{ route('permissions.delete', $permission->id) }}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('delete')}}
                                            @if($permission->roles->count() > 0)
                                                <a href="{{ route('roles.index',['permission'=>$permission->id]) }}" class="btn btn-default">Roles</a>
                                            @endif
                                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary">Edit</a>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="confirmDelete(this.form)">delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $permissions->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

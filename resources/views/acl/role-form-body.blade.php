@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-12 justify-content-center">
            @if(isset($role))
                <form action="{{ route('roles.update', $role->id) }}" method="post">
                    @else
                        <form action="{{ route('roles.store') }}" method="post">
                            @endif
                            <div class="card">
                                <div class="card-header"><a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">Back</a> {{ isset($role) ? 'Edit' : 'Add' }} Role</div>
                                @csrf
                                @if(isset($role))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    @include('ruhusa::acl.partials._role-form')
                                </div>
                                <div class="card-footer">
                                    <div class="col-md-12">
                                        <button class="btn btn-success float-right">{{ isset($role) ? 'Update' : 'Submit' }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
        </div>
    </div>
@endsection

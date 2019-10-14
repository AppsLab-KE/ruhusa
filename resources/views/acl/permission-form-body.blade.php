@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-12 justify-content-center">
            @if(isset($permission))
                <form action="{{ route('permissions.update', $permission->id) }}" method="post">
                    @else
                        <form action="{{ route('permissions.store') }}" method="post">
                            @endif
                            <div class="card">
                                <div class="card-header"><a href="{{ route('permissions.index') }}" class="btn btn-primary btn-sm">Back</a> {{ isset($permission) ? 'Edit' : 'Add' }} Permission</div>
                                @csrf
                                @if(isset($permission))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    @include('ruhusa::acl.partials._permission-form')
                                </div>
                                <div class="card-footer">
                                    <div class="col-md-12">
                                        <button class="btn btn-success float-right">{{ isset($permission) ? 'Update' : 'Submit' }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
        </div>
    </div>
@endsection

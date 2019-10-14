<div class="row">
    <div class="form-group col-6 {{ $errors->has('name') ? 'alert-danger' : ''}}">
        <label for="">Role Name</label>
        <input type="text" name="name" value="{{ $role->name ?? old('name') }}" class="form-control">
        <span>{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
    </div>
    <div class="form-group col-6">
        <label for="description">Description(optional)</label>
        <textarea name="description" id="description" rows="1" class="form-control">{{ $role->description ?? old('description') }}</textarea>
    </div>
    <div class="form-group col-12 {{ $errors->has('permissions') ? 'alert-danger' : ''}}">
        <label for="permission">Add permission(s) to role</label>
        <select name="permissions[]" id="permission" class="form-control select2" multiple>
            @foreach($permissions as $permission)
                <option {{ (in_array($permission->id, (isset($role) ? \Illuminate\Support\Arr::pluck($role->permissions, 'id') : old('permissions') ?? [])) ? 'selected' : '') }} value="{{ $permission->id }}">{{ ucfirst(str_replace('-',' ', str_replace('.',' ', $permission->name))) }}</option>
            @endforeach
        </select>
        <span>{{ $errors->has('permissions') ? $errors->first('permissions') : '' }}</span>
    </div>
    <div class="form-group col-12">
        <label for="users">Add users(s) to role (optional)</label>
        <select name="users[]" id="users" class="form-control select2" multiple>
            @foreach($users as $user)
                <option {{ (in_array($user->id, (isset($role) ? \Illuminate\Support\Arr::pluck($role->users, 'id') : old('users') ?? [])) ? 'selected' : '') }} value="{{ $user->id }}">{{ strtolower($user->username ?? $user->email) }}</option>
            @endforeach
        </select>
    </div>
</div>
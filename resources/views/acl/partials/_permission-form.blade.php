<div class="row">
    <div class="form-group col-6 {{ $errors->has('name') ? 'alert-danger' : ''}}">
        <label for="">Permission Name</label>
        <input type="text" name="name" value="{{ $permission->name ?? old('name') }}" class="form-control">
        <span>{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
    </div>
    <div class="form-group col-6">
        <label for="description">Description(optional)</label>
        <textarea name="description" id="description" rows="1" class="form-control">{{ $permission->description ?? old('description') }}</textarea>
    </div>
    <div class="form-group col-12">
        <label for="roles">Add role(s) to permission (Optional)</label>
        <select name="roles[]" id="roles" class="form-control select2" multiple>
            @foreach($roles as $role)
                <option {{ (in_array($role->id, (isset($permission) ? \Illuminate\Support\Arr::pluck($permission->roles, 'id') : old('roles') ?? [])) ? 'selected' : '') }} value="{{ $role->id }}">{{ ucfirst(str_replace('-',' ', str_replace('.',' ', $role->name))) }}</option>
            @endforeach
        </select>
    </div>

</div>
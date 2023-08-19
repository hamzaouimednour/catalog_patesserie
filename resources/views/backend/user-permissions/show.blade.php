@php
    $perms = Session::get('perms');
    $actions = array();
    if($perms->where('controller', 'user-permissions')->isNotEmpty() && !empty($perms->where('controller', 'user-permissions')->first()))
        $actions = $perms->where('controller', 'user-permissions')->first()->actions;
	if(Session::get('is_admin')){
        $actions = ['A', 'M', 'D', 'P'];
    }
@endphp
@if ($perms->where('controller', 'user-permissions')->isNotEmpty() || Session::get('is_admin') && !empty($actions) && in_array('M', $actions))
                        <input name="id" type="hidden" value="{{$id}}"/>
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e1">Utilisateur : <span class="tx-danger">*</span></label>
                            <input class="form-control" value="{{$user->name}}" disabled>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
                        <div class="form-group mg-b-0 pd-b-15">
                            <label for="field-e1">Groupe(s) d'autoriation(s) : <span class="tx-danger">*</span></label>
                            <select name="group-id[]" class="form-control select2-multi" data-placeholder="Sélectionner utilisateur(s)" multiple style="width: 100%" required>
                                {{-- <option></option> --}}
                                @foreach ($groups as $item)
                                    <option value="{{$item->id}}" {{in_array($item->id, $auth_groups) ? "selected" : NULL}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Ce champ est obligatoire</div>
                        </div><!-- form-group -->
@endif
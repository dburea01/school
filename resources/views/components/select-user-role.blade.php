<select {{ $attributes }}>
    <option value="" @if (''===$value) selected @endif>-- rôle --</option>

    @foreach($userRoles as $userRole)
    <option value="{{ $userRole }}" @if ($userRole->value==$value) selected @endif>{{ $userRole->label() }}</option>
    @endforeach
</select>
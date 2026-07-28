<select {{ $attributes }}>
    <option value="" @selected(blank($value))>-- rôle --</option>

    @foreach($userRoles as $userRole)
        <option value="{{ $userRole->value }}" @selected($userRole->value === $value)>
            {{ $userRole->label() }}
        </option>
    @endforeach
</select>
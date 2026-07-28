<select {{ $attributes }}>
    <option value="" @selected(blank($value))>-- genre --</option>

    @foreach($userGenders as $userGender)
        <option value="{{ $userGender->value }}" @selected($userGender->value === $value)>
            {{ $userGender->label() }}
        </option>
    @endforeach
</select>
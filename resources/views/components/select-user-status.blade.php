<select {{ $attributes }}>
    <option value="" @selected(blank($value))>-- status --</option>

    @foreach($userStatuses as $userStatus)
        <option value="{{ $userStatus->value }}" @selected($userStatus->value === $value)>
            {{ $userStatus->label() }}
        </option>
    @endforeach
</select>
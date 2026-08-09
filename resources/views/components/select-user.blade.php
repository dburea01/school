<select {{ $attributes }}>
    <option value="" @selected(blank($value))>-- professeur principal --</option>

    @foreach($users as $user)
        <option value="{{ $user->id }}" @selected($user->id === $value)>
            {{ $user->full_name }}
        </option>
    @endforeach
</select>
<x-mail::message>
# Someone sent you a message

Salut Dom, tu as reçu un message concernant le projet SCHOOL : 

**name** : {{ $name }}

**email** : {{ $email }}

**message**
{{ $message }}

<x-mail::button :url="$url" color="success">
Go to the appli
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

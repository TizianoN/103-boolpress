<x-mail::message>
  # Nuovo messaggio di {{ $name }} da Boolpress Frontoffice:

  {{ $message }}

  <x-mail::button :url="'mailto:' . $email">
    Rispondi
  </x-mail::button>
</x-mail::message>

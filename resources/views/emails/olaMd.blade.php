@component('mail::message')
# Olá T91 Md

Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut maxime excepturi sed natus delectus, blanditiis, dolores, aliquid similique sunt animi laborum quaerat. Aliquid distinctio error, ullam ipsum voluptas quam eius!

## Titulo 2

### Titulo 3

- Item
- item 2

@component('mail::button', ['url' => 'http://uol.com.br'])
Uol
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent

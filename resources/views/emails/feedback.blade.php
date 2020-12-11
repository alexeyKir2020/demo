@component('mail::message')
# Новое сообщение
# Тема: {{ $message['subject'] }}

{{ $message['message'] }}

@endcomponent

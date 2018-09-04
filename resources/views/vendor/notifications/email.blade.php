@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# السلام عليكم
@else
@if ($level == 'error')
# خطأ
@else
# 
@endif
@endif

{{-- Intro Lines --}}
{{-- @foreach ($introLines as $line)
{{ $line }}

@endforeach --}}
رابط استعادة كلمة المرور

{{-- Action Button --}}
@if (isset($actionText))
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
<!-- {{ $actionText }} -->
استعادة كلمة المرور
@endcomponent
@endif

{{-- Outro Lines --}}
{{-- @foreach ($outroLines as $line)
{{ $line }}

@endforeach --}}


<!-- Salutation -->
{{-- @if (! empty($salutation))
{{ $salutation }}
@else
Regards,<br>{{ config('app.name') }}
@endif --}}


<!-- Subcopy -->
@if (isset($actionText))
@component('mail::subcopy')
اذا كان الرابط  السابق لا يعمل قم بنسخ الرابط التالى ولصقه فى متصفحك: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endif
@endcomponent
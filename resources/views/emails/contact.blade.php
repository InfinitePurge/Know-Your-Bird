<x-mail::message>
# New Contact us Form Submission

@if($isAuthenticated)
**Submitted by Logged-In User**
@else
**Submitted by Guest User**
@endif

**Name:** {{ $name }}

**Email:** {{ $email }}
    
**Subject:** {{ $subject }}
    
**Message:** {{ $message }}

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

{{-- Thanks,<br> --}}
{{ config('app.name') }}
</x-mail::message>

@component('mail::message')
# Welcome, {{ $admin->name }}

Thanks for your cooperation and support,
@component('mail::panel')
To access Sotre, click on below button.
@endcomponent

@component('mail::button', ['url' => 'http://127.0.0.1:8000/store/admin/login','color'=>'primary'])
Store Login
@endcomponent

{{-- @component('mail::table')
| Product       | Quantity         | Total  |
|:------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
@endcomponent --}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent

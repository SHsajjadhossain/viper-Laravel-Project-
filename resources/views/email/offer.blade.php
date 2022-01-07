@component('mail::message')
# New Offer
# 25% Flat Discount!!

This Discount For All Products!
@component('mail::button', ['url' => "https://www.creativeitinstitute.com/", 'color' => 'success'])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent


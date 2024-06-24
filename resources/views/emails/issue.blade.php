@component('mail::message')
# New Issue Booking

Name: {{ $data['name'] }} <br>
Phone Number: {{ $data['phone'] }} <br>
Location: {{ $data['location'] }} <br>
Description:<br><br> {{ $data['description'] }} <br>

@endcomponent

<strong>Name:</strong> {{ $data->name }}<br/><br/>
<strong>Subject:</strong> {{ $data->subject }}<br/><br/>
<strong>Email:</strong> {{ $data->email }}<br/><br/>
<strong>Details:</strong>
{!! $data->renderedMessage() !!}

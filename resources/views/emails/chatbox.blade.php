@extends('layouts.mail')

@section('title', 'This is your Chatbox Conversation')

@section('content')
@foreach ($email['messages'] as $message)
		<div style="display: flex; padding: 1rem ;border-radius: 0.5rem; @if ($message['role'] === 'assistant') background-color: #bbf7d0; @else background-color: #bfcdfd; @endif margin-bottom: 1rem">
			<div style="font-size: 1.125rem; font-weight: 500; color: #1a202c; margin-right: 1rem;">
				@if ($message['role'] === 'assistant')
					Your Assistant
				@else
					You
				@endif
			</div>
			<div style="font-size: 1rem; color: #4a5568;">
				<p>
					{!! \Illuminate\Mail\Markdown::parse($message['content']) !!}
				</p>
			</div>
		</div>
	@endforeach
@endsection

@section('footer')
    <p>Thanks,<br>
    {{ config('app.name') }}</p>
@endsection
<div class="message-item {{ $message->user_id === auth()->id() ? 'own' : '' }}">
  @if($message->user_id !== auth()->id())
  <div class="message-sender">
    <i class="fas fa-user-circle"></i> {{ $message->user->username }}
  </div>
  @endif

  <div class="message-bubble">
    <p class="message-text">{{ $message->message }}</p>
    <div class="message-time">
      {{ $message->created_at->format('H:i') }}
    </div>
  </div>
</div>

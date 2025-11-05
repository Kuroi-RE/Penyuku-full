<div class="comment-item d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom" id="comment-{{ $comment->id }}">
  <div class="flex-grow-1">
    <strong class="text-primary">{{ $comment->user->username }}</strong>
    <p class="mb-1 mt-1">{{ $comment->body }}</p>
    <small class="text-muted">
      <i class="fas fa-clock me-1"></i>{{ $comment->created_at->diffForHumans() }}
    </small>
  </div>
  @if($comment->user_id === auth()->id())
  <button class="btn btn-sm btn-link text-danger" onclick="deleteComment({{ $comment->id }}, {{ $comment->post_id }})">
    <i class="fas fa-trash"></i>
  </button>
  @endif
</div>

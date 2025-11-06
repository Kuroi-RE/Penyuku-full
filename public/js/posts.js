// Posts Index JavaScript Functions
// DO NOT FORMAT - Keep AJAX syntax as is

// Toggle Custom Dropdown
function toggleDropdown(postId) {
  $('.custom-dropdown-menu').not(`#dropdown-${postId}`).hide();
  $(`#dropdown-${postId}`).toggle();
}

// Open Edit Modal
function openEditModal(postId) {
  $(`#dropdown-${postId}`).hide();
  var editModal = new bootstrap.Modal(document.getElementById(`editModal${postId}`));
  editModal.show();
}

// Close dropdowns when clicking outside
$(document).on('click', function(e) {
  if (!$(e.target).closest('.custom-dropdown').length) {
    $('.custom-dropdown-menu').hide();
  }
});

// Toggle Like
function toggleLike(postId) {
  $.ajax({
    url: `/posts/${postId}/like`,
    type: 'POST',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
      const btn = $(`.btn-like[data-post-id="${postId}"]`);
      btn.toggleClass('liked', response.liked);
      btn.find('.likes-count').text(response.likes_count);
    },
    error: function(xhr) {
      console.error('Error:', xhr);
      console.error('Response:', xhr.responseText);
      alert('Terjadi kesalahan saat menyukai postingan!');
    }
  });
}

// Toggle Comments Display
function toggleComments(postId) {
  $(`#comments-${postId}`).slideToggle();
}

// Submit Comment
function submitComment(event, postId) {
  event.preventDefault();
  const input = $(`#comment-input-${postId}`);
  const content = input.val();

  $.ajax({
    url: `/posts/${postId}/comment`,
    type: 'POST',
    data: {
      body: content,
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
      $(`#comments-list-${postId}`).append(response.html);
      input.val('');
      const currentCount = parseInt($(`#post-${postId} .comments-count`).text());
      $(`#post-${postId} .comments-count`).text(currentCount + 1);
    },
    error: function(xhr) {
      console.error('Error:', xhr);
      console.error('Response:', xhr.responseText);
      alert('Terjadi kesalahan saat menambahkan komentar!');
    }
  });
}

// Delete Comment
function deleteComment(commentId, postId) {
  if (!confirm('Yakin ingin menghapus komentar ini?')) return;

  $.ajax({
    url: `/comments/${commentId}`,
    type: 'POST',
    data: {
      _method: 'DELETE',
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
      $(`#comment-${commentId}`).fadeOut(300, function() {
        $(this).remove();
      });
      const currentCount = parseInt($(`#post-${postId} .comments-count`).text());
      $(`#post-${postId} .comments-count`).text(currentCount - 1);
    },
    error: function(xhr) {
      console.error('Error:', xhr);
      console.error('Response:', xhr.responseText);
      alert('Terjadi kesalahan saat menghapus komentar!');
    }
  });
}

// Delete Post
function deletePost(postId) {
  $(`#dropdown-${postId}`).hide();

  if (!confirm('Yakin ingin menghapus postingan ini?\n\nPostingan yang dihapus tidak dapat dikembalikan.')) {
    return;
  }

  $.ajax({
    url: `/posts/${postId}`,
    type: 'POST',
    data: {
      _method: 'DELETE',
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function() {
      $(`#post-${postId}`).css('opacity', '0.5');
    },
    success: function(response) {
      $(`#post-${postId}`).fadeOut(300, function() {
        $(this).remove();
      });
      const alertHtml = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle"></i> Postingan berhasil dihapus!
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      `;
      $('.container').prepend(alertHtml);
      setTimeout(function() {
        $('.alert-success').fadeOut();
      }, 3000);
    },
    error: function(xhr) {
      console.error('Error:', xhr);
      $(`#post-${postId}`).css('opacity', '1');
      alert('Gagal menghapus postingan: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
    }
  });
}

// Auto-hide success alerts on page load
$(document).ready(function() {
  setTimeout(function() {
    $('.alert-success').fadeOut();
  }, 5000);
});

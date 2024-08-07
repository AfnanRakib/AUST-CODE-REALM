//ripple effect
 document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('[data-mdb-ripple-init]').forEach((element) => {
                new mdb.Ripple(element);
            });
        });

        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function() {
                setTimeout(() => {
                    this.blur();
                }, 100);
            });
        });
		
//search bar
document.addEventListener('DOMContentLoaded', function() {
			const searchInput = document.querySelector('input[name="search"]');
			const form = document.querySelector('form');

			let typingTimer;

			const doneTypingInterval = 1500; // ms


			searchInput.addEventListener('input', function() {
				clearTimeout(typingTimer);
				if (this.value === '') {
					// If the search bar is cleared, immediately submit the form
					form.submit();
				} else {
					typingTimer = setTimeout(doneTyping, doneTypingInterval);
				}
			});

			function doneTyping() {
				form.submit();
			}
		});
		
//edit & delete video
$(document).ready(function() {
        // Delete video
        $('.delete-video').click(function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this video?')) {
                var videoId = $(this).data('video-id');
                
                $.ajax({
                    url: 'delete_video.php',
                    type: 'POST',
                    data: { video_id: videoId },
                    dataType: 'json',
                    success: function(response) {
                        console.log("Server response:", response);
                        if (response.success) {
                            location.reload();
                        } else {
                            console.error("Error deleting video:", response.error);
                            alert('Error: ' + response.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX request failed:", textStatus, errorThrown);
                        console.log("Response text:", jqXHR.responseText);
                        alert('An error occurred while deleting the video.');
                    }
                });
            }
        });

        // Edit video
		$('.edit-video').click(function(e) {
        e.preventDefault();
        var videoId = $(this).data('video-id');
        
        $.ajax({
            url: 'edit_video.php',
            type: 'GET',
            data: { id: videoId },
            dataType: 'json',
            success: function(video) {
                console.log("Received video data:", video);
                var modalContent = `
                    <form id="editVideoForm">
                        <input type="hidden" name="id" value="${video.id}">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="${video.title}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="video-description" name="description">${video.description}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="youtube_embed_url" class="form-label">YouTube Embed URL</label>
                            <input type="text" class="form-control" id="youtube_embed_url" name="youtube_embed_url" value="${video.youtube_embed_url}" required>
                        </div>
                        <button type="submit" class="btn btn-auto"style="background-color: rgb(3, 191, 98);">Save changes</button>
                    </form>
                `;
                
                $('#editModal .modal-body').html(modalContent);
                $('#editModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown);
                alert('An error occurred while fetching video details: ' + jqXHR.responseText);
            }
        });
    });

    // Handle edit form submission
    $(document).on('submit', '#editVideoForm', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'edit_video.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    console.error("Error updating video:", response.error);
                    alert('Error: ' + response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown);
                alert('An error occurred while updating the video: ' + jqXHR.responseText);
            }
        });
    });
});
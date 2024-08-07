 $(document).ready(function() {
        // Delete course
        $('.delete-course').click(function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this course?')) {
                var courseId = $(this).data('course-id');
                
                $.ajax({
                    url: 'delete_course.php',
                    type: 'POST',
                    data: { course_id: courseId },
                    dataType: 'json',
                    success: function(response) {
                        console.log("Server response:", response);
                        if (response.success) {
                            location.reload();
                        } else {
                            console.error("Error deleting course:", response.error);
                            alert('Error: ' + response.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX request failed:", textStatus, errorThrown);
                        console.log("Response text:", jqXHR.responseText);
                        alert('An error occurred while deleting the course.');
                    }
                });
            }
        });

        // Edit course
        $('.edit-course').click(function(e) {
        e.preventDefault();
        var courseId = $(this).data('course-id');
        
        $.ajax({
            url: 'edit_course.php',
            type: 'GET',
            data: { id: courseId },
            dataType: 'json',
            success: function(course) {
                console.log("Received course data:", course);
                var modalContent = `
                    <form id="editCourseForm">
                        <input type="hidden" name="id" value="${course.id}">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="${course.title}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea class="form-control" id="course-description" name="description">${course.description}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="image_url" name="image_url" value="${course.image_url}" required>
                        </div>
                        <button type="submit" class="btn btn-auto" style="background-color: rgb(3, 191, 98);">Save changes</button>
                    </form>
                `;
                
                $('#editModal .modal-body').html(modalContent);
                $('#editModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown);
                alert('An error occurred while fetching course details: ' + jqXHR.responseText);
            }
        });
    });

    // Handle edit form submission
    $(document).on('submit', '#editCourseForm', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'edit_course.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    console.error("Error updating course:", response.error);
                    alert('Error: ' + response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown);
                alert('An error occurred while updating the course: ' + jqXHR.responseText);
            }
        });
    });
});
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
		
		// search bar
		document.addEventListener('DOMContentLoaded', function() {
			const searchInput = document.querySelector('input[name="search"]');
			const searchType = document.querySelector('select[name="search_type"]');
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

			searchType.addEventListener('change', doneTyping);

			function doneTyping() {
				form.submit();
			}
		});
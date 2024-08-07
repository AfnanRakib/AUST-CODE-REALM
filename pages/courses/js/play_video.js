//try ide interaction
document.addEventListener('DOMContentLoaded', function() {
			const floatingButton = document.getElementById('floatingButton');
			const closeButton = document.getElementById('closeButton');
			const resizeHandle = document.querySelector('.resize-handle');
			const header = document.querySelector('.header');
			const buttonContent = document.querySelector('.button-content');
			const expandedContent = document.querySelector('.expanded-content');

			let isDragging = false;
			let isResizing = false;
			let startX, startY, startWidth, startHeight;

			// Event listeners
			floatingButton.addEventListener('click', toggleExpand);
			closeButton.addEventListener('click', closeExpanded);
			header.addEventListener('mousedown', startDragging);
			resizeHandle.addEventListener('mousedown', (e) => {
				isResizing = true;
				document.addEventListener('mousemove', resize);
				document.addEventListener('mouseup', stopResize);
			});

			document.addEventListener('mousemove', drag);
			document.addEventListener('mouseup', stopDragging);

			function toggleExpand(e) {
				if (floatingButton.classList.contains('expanded')) {
					return; // Do nothing if it's already expanded
				}
				floatingButton.classList.add('expanded');
				floatingButton.style.width = '500px'; // Expanded width
				floatingButton.style.height = '1000px'; // Expanded height
				buttonContent.style.display = 'none';
				expandedContent.style.display = 'flex';
			}

			function closeExpanded() {
				floatingButton.classList.remove('expanded');
				floatingButton.style.width = '100px'; // Default width
				floatingButton.style.height = '40px'; // Default height
				buttonContent.style.display = 'flex';
				expandedContent.style.display = 'none';
			}

			function startDragging(e) {
				if (!floatingButton.classList.contains('expanded')) return;
				isDragging = true;
				startX = e.clientX - floatingButton.offsetLeft;
				startY = e.clientY - floatingButton.offsetTop;
			}

			function drag(e) {
				if (isDragging) {
					floatingButton.style.left = (e.clientX - startX) + 'px';
					floatingButton.style.top = (e.clientY - startY) + 'px';
				} else if (isResizing) {
					const width = startWidth + (e.clientX - startX);
					const height = startHeight + (e.clientY - startY);
					floatingButton.style.width = width + 'px';
					floatingButton.style.height = height + 'px';
				}
			}

			function stopDragging() {
				isDragging = false;
				isResizing = false;
			}

			function resize(e) {
				if (!isResizing) return;
				floatingButton.style.width = (e.clientX - floatingButton.offsetLeft) + 'px';
				floatingButton.style.height = (e.clientY - floatingButton.offsetTop) + 'px';
				editor.resize();
			}

			function stopResize() {
				isResizing = false;
				document.removeEventListener('mousemove', resize);
			}

			// Prevent toggleExpand when clicking within the expanded content
			expandedContent.addEventListener('click', function(e) {
				e.stopPropagation();
			});
});
	//toogle & append new replies
	document.addEventListener('DOMContentLoaded', function() {
	document.querySelectorAll('.reply-form').forEach(form => {
			form.addEventListener('submit', function(e) {
				e.preventDefault();
				const formData = new FormData(this);
				const commentId = formData.get('comment_id');
				const videoId = formData.get('video_id');

				fetch('add_reply.php', {
					method: 'POST',
					body: formData
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						this.reset();
						appendNewReply(commentId, data.reply);
					} else {
						alert('Error submitting reply: ' + (data.message || 'Please try again.'));
					}
				});
			});
		});
	});

	function appendNewReply(commentId, reply) {
		const repliesContainer = document.getElementById(`replies-${commentId}`);
		const replyElement = document.createElement('div');
		replyElement.className = 'reply mb-2';
		replyElement.innerHTML = `
			<div class='reply-header'>
				<img src='${reply.Profile_Picture || '../../images/blank_profile_img.jpg'}' 
					alt='Profile Picture' class='profile-pic-small'>
				<strong>${reply.Handle}</strong>
			</div>
			<p>${reply.content}</p>
			<small>Replied on ${reply.created_at}</small>
		`;
		repliesContainer.insertBefore(replyElement, repliesContainer.firstChild);
		repliesContainer.style.display = 'block';
		const button = document.querySelector(`button[onclick="toggleReplies(${commentId})"]`);
		if (button) {
			button.textContent = 'Hide Replies';
		}
	}

	function toggleReplies(commentId) {
		const repliesContainer = document.getElementById(`replies-${commentId}`);
		const button = event.target;

		if (repliesContainer.style.display === 'none' || repliesContainer.style.display === '') {
			// Show replies
			fetch(`get_replies.php?comment_id=${commentId}`)
			.then(response => response.json())
			.then(replies => {
				repliesContainer.innerHTML = '';
				replies.forEach(reply => {
					const replyElement = document.createElement('div');
					replyElement.className = 'reply mb-2';
					replyElement.innerHTML = `
						<div class='reply-header'>
							<img src='${reply.Profile_Picture || '../../images/blank_profile_img.jpg'}' 
								alt='Profile Picture' class='profile-pic-small'>
							<strong>${reply.Handle}</strong>
						</div>
						<p>${reply.content}</p>
						<small>Replied on ${reply.created_at}</small>
					`;
					repliesContainer.appendChild(replyElement);
				});
				repliesContainer.style.display = 'block';
				button.textContent = 'Hide Replies';
			});
		} else {
			// Hide replies
			repliesContainer.style.display = 'none';
			button.textContent = 'Show Replies';
		}
	}
	//Q&A Script
	document.addEventListener('DOMContentLoaded', function() {
			const qaWindow = document.getElementById('qaWindow');
			const openQAButton = document.getElementById('openQAButton');
			const askQuestionBtn = document.getElementById('askQuestionBtn');
			const questionForm = document.getElementById('questionForm');
			const newQuestionForm = document.getElementById('newQuestionForm');
			const questionsList = document.getElementById('questionsList');

			//Q&A search bar
			const qaSearch = document.getElementById('qaSearch');
			const searchType = document.getElementById('searchType');
			const videoId = <?php echo $video_id; ?>;

			function searchQuestions(query = '', type = 'title') {
				fetch(`search_questions.php?video_id=${videoId}&search=${encodeURIComponent(query)}&search_type=${type}`)
				.then(response => response.json())
				.then(questions => {
					questionsList.innerHTML = '';
					if (questions.length === 0) {
						questionsList.innerHTML = '<p>No questions found.</p>';
					} else {
						questions.forEach(question => {
							const questionElement = createQuestionElement(question);
							questionsList.appendChild(questionElement);
						});
					}
				})
				.catch(error => {
					console.error('Error:', error);
					questionsList.innerHTML = '<p>An error occurred while loading questions.</p>';
				});
			}

			let typingTimer;
			const doneTypingInterval = 300; // ms

			qaSearch.addEventListener('input', function() {
				clearTimeout(typingTimer);
				if (this.value === '') {
					// If the search bar is cleared, immediately load all questions
					searchQuestions();
				} else {
					typingTimer = setTimeout(() => {
						searchQuestions(this.value, searchType.value);
					}, doneTypingInterval);
				}
			});

			searchType.addEventListener('change', function() {
				searchQuestions(qaSearch.value, this.value);
			});

			openQAButton.addEventListener('click', function() {
				if (qaWindow.style.width === '45%') {
					qaWindow.style.width = '0';
				} else {
					qaWindow.style.width = '45%';
				}
			});

			

			askQuestionBtn.addEventListener('click', function() {
				questionForm.style.display = 'block';
			});

			newQuestionForm.addEventListener('submit', function(e) {
				e.preventDefault();
				const formData = new FormData(newQuestionForm);
				
				fetch('submit_question.php', {
					method: 'POST',
					body: formData
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						alert('Question submitted successfully!');
						questionForm.style.display = 'none';
						loadQuestions();
					} else {
						alert('Error submitting question. Please try again.');
					}
				});
			});
			
			function loadQuestions() {
				const videoId = <?php echo $video_id; ?>;
				fetch(`get_questions.php?video_id=${videoId}`)
				.then(response => response.json())
				.then(questions => {
					questionsList.innerHTML = '';
					questions.forEach(question => {
						const questionElement = createQuestionElement(question);
						questionsList.appendChild(questionElement);
					});
				});
			}

			function createQuestionElement(question) {
				const element = document.createElement('div');
				element.className = 'question mb-3';
				element.innerHTML = `
					<div class="question-header d-flex align-items-center mb-2">
						<img src="${question.user_profile_picture || '../../images/blank_profile_img.jpg'}" alt="Profile Picture" class="profile-pic-small me-2">
						<strong>${question.user_handle}</strong>
					</div>
					<h4>Title: ${question.title}</h4>
					<p><strong>problem_description:</strong> ${question.problem_description}</p>
					${question.code ? `<p><strong> code: <pre><code>${question.code}</code></pre></p>` : ''}
					${question.error_log ? `<p><strong>Error Log:</strong> ${question.error_log}</p>` : ''}
					${question.attempted_solutions ? `<p><strong>Attempted Solutions:</strong> ${question.attempted_solutions}</p>` : ''}
					<button class="btn btn-sm btn-secondary" onclick="showAnswers(${question.id})">Show Answers</button>
					<div id="answers-${question.id}" class="answers mt-2" style="display: none;"></div>
					<form class="answer-form mt-2" onsubmit="submitAnswer(event, ${question.id})">
						<textarea class="form-control" name="content" required></textarea>
						<button type="submit" class="btn btn-auto mt-3" style="background-color: rgb(3, 191, 98); margin-top: 4px; margin-bottom: 10px;">Submit Answer</button>
					</form>
				`;
				return element;
			}

			window.showAnswers = function(questionId) {
				const answersContainer = document.getElementById(`answers-${questionId}`);
				const button = event.target;

				if (answersContainer.style.display === 'none' || answersContainer.style.display === '') {
					// Show answers
					fetch(`get_answers.php?question_id=${questionId}`)
					.then(response => response.json())
					.then(answers => {
						answersContainer.innerHTML = '';
						answers.forEach(answer => {
							const answerElement = document.createElement('div');
							answerElement.className = 'answer mb-2';
							answerElement.innerHTML = `
								<div class="answer-header d-flex align-items-center mb-2">
									<img src="${answer.user_profile_picture || '../../images/blank_profile_img.jpg'}" alt="Profile Picture" class="profile-pic-small me-2">
									<strong>${answer.user_handle}</strong>
								</div>
								<p>${answer.content}</p>
								<small>Posted on ${answer.created_at}</small>
							`;
							answersContainer.appendChild(answerElement);
						});
						answersContainer.style.display = 'block';
						button.textContent = 'Hide Answers';
					});
				} else {
					// Hide answers
					answersContainer.style.display = 'none';
					button.textContent = 'Show Answers';
				}
			};
			window.submitAnswer = function(event, questionId) {
				event.preventDefault();
				const form = event.target;
				const formData = new FormData(form);
				formData.append('question_id', questionId);

				fetch('submit_answer.php', {
					method: 'POST',
					body: formData
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						alert('Answer submitted successfully!');
						form.reset();
						// Immediately display the new answer
						appendNewAnswer(questionId, data.answer);
					} else {
						alert('Error submitting answer: ' + (data.message || 'Please try again.'));
					}
				});
			};

			function appendNewAnswer(questionId, answer) {
				const answersContainer = document.getElementById(`answers-${questionId}`);
				const answerElement = document.createElement('div');
				answerElement.className = 'answer mb-2';
				answerElement.innerHTML = `
					<div class="answer-header d-flex align-items-center mb-2">
						<img src="${answer.user_profile_picture || '../../images/blank_profile_img.jpg'}" alt="Profile Picture" class="profile-pic-small me-2">
						<strong>${answer.user_handle}</strong>
					</div>
					<p>${answer.content}</p>
					<small>Posted on ${answer.created_at}</small>
				`;
				answersContainer.insertBefore(answerElement, answersContainer.firstChild);
				answersContainer.style.display = 'block';
				const button = document.querySelector(`button[onclick="showAnswers(${questionId})"]`);
				if (button) {
					button.textContent = 'Hide Answers';
				}
			}
			loadQuestions();
});
//update and delete document
document.addEventListener('DOMContentLoaded', function() {
		var docForm = document.getElementById('docForm');
		if (docForm) {
			docForm.addEventListener('submit', function(e) {
				e.preventDefault();
				var content = document.getElementById('description').value;
				var videoId = <?php echo json_encode($video_id); ?>;
				console.log("Sending content:", content); // Debug log
				console.log("Video ID:", videoId); // Debug log

				fetch('update_document.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: 'video_id=' + encodeURIComponent(videoId) + '&content=' + encodeURIComponent(content)
				})
				.then(response => response.text())
				.then(data => {
					console.log("Response:", data); // Debug log
					alert(data);
				})
				.catch((error) => {
					console.error('Error:', error);
					alert('An error occurred: ' + error);
				});
			});
		}

		var deleteDocButton = document.getElementById('deleteDoc');
		if (deleteDocButton) {
			deleteDocButton.addEventListener('click', function() {
				if (confirm('Are you sure you want to delete this document?')) {
					var videoId = <?php echo json_encode($video_id); ?>;
					fetch('delete_document.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
						},
						body: 'video_id=' + encodeURIComponent(videoId)
					})
					.then(response => response.text())
					.then(data => {
						alert(data);
						document.getElementById('description').value = '';
					})
					.catch((error) => {
						console.error('Error:', error);
						alert('An error occurred: ' + error);
					});
				}
			});
		}
});
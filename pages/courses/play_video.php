<?php
require_once 'config.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    // Redirect to login page or show a message
    header("Location: login.php");
    exit();
}

define('DEFAULT_PROFILE_IMG', '../../images/blank_profile_img.jpg');

$video_id = $_GET['video_id'];

// Fetch video details
$video_sql = "SELECT v.*, c.id AS course_id, c.title AS course_title FROM videos v JOIN courses c ON v.course_id = c.id WHERE v.id = ?";
$video_stmt = $conn->prepare($video_sql);
$video_stmt->bind_param("i", $video_id);
$video_stmt->execute();
$video_result = $video_stmt->get_result();
$video = $video_result->fetch_assoc();


// Fetch comments
$comments_sql = "SELECT c.*, u.Handle, u.Profile_Picture FROM comments c 
                 JOIN users u ON c.user_id = u.UserID 
                 WHERE c.video_id = ? ORDER BY c.created_at DESC";
$comments_stmt = $conn->prepare($comments_sql);
$comments_stmt->bind_param("i", $video_id);
$comments_stmt->execute();
$comments_result = $comments_stmt->get_result();

// Fetch document
$doc_sql = "SELECT * FROM video_documents WHERE video_id = ?";
$doc_stmt = $conn->prepare($doc_sql);
$doc_stmt->bind_param("i", $video_id);
$doc_stmt->execute();
$doc_result = $doc_stmt->get_result();
$document = $doc_result->fetch_assoc();
// Check if the current user is the author
$is_author = ($_SESSION['user']['UserID'] == $video['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/problemPage.css">
    <link rel="stylesheet" href="../../css/navbar.css">
	<link rel="stylesheet" href="css/play_video.css">
	<script src="../../js/tinymce/tinymce.min.js"></script>
    <script src="../../js/tinyMCEinit.js"></script>
    <title><?php echo $video['title']; ?> - AUST CODE REALM</title>
</head>
<body>

    <!-- Navbar -->
	<?php include '../../helpers/navbar.php'; ?>
	<?php include '../../helpers/judge0.php'; ?>
	<!-- floating try ide button-->
	<div id="floatingButton" class="floating-button">
    <div class="button-content">Try IDE</div>
		<div class="expanded-content">
			<div class="header">
				<button id="closeButton">&times;</button>
				<span>Drag me</span>
			</div>
			<div class="content" >
					<div class="row">
						<!--STANDARD INPUT BAR-->
						<div class="form-group mb-3">
							<label for="stdin">Standard Input:</label>
							<textarea class="form-control" id="stdin" rows="3" placeholder="Enter standard input here..."></textarea>
						</div>
						<div class="col editor-container ;">
							<?php include '../../helpers/ide.php'; ?>
							 
						</div>
						<div class="container">
							<div class="row md-2">
								<div class="col-12 col-md-4 mb-2 mb-md-0">
									<button class="btn btn-mt-3"id="submitButton">RUN</button>
								</div>
							</div>
							<div class="row">
								<div id="resultDisplay" class="mt-4 p-3 border rounded" style="background-color: #f8f9fa; color: black;"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div style="height: 10px;"></div>
					</div>
				</div>
				<script src="../../js/ace/ace.js"></script>
				<script>
					
					document.getElementById('submitButton').addEventListener('click', function(event) {
						const selectElement = document.getElementById('selectLanguageMode');
						const languageName = selectElement.options[selectElement.selectedIndex].text;
						const languageId = languageModeIds[languageName];
						const code = editor.getValue();
						const stdin = document.getElementById('stdin').value; 

						const data = {
							languageId: languageId,
							languageName: languageName,
							code: code,
							stdin: stdin 
						};
						fetch('../../helpers/try_Ide_submit_code.php', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json',
							},
							body: JSON.stringify(data)
						})
						.then(response => {
							if (!response.ok) {
								throw new Error(`HTTP error! status: ${response.status}`);
							}
							return response.text(); 
						}).then(text => {
							console.log('Raw response:', text); 
							try {
								return JSON.parse(text); 
							} catch (error) {
								console.error('JSON parse error:', error);
								throw new Error('Invalid JSON response');
							}
						})
						.then(submissionData => {
							console.log('Success:', submissionData);

							// Display the result in the resultDisplay div
							const resultDisplay = document.getElementById('resultDisplay');
							let displayContent = `<h4>Compilation Result</h4>`;

							if (submissionData.stdout) {
								displayContent += `<p><strong>Stdout:</strong> ${submissionData.stdout}</p>`;
							}
							if (submissionData.stderr) {
								displayContent += `<p><strong>Stderr:</strong> ${submissionData.stderr}</p>`;
							}
							if (submissionData.compile_output) {
								displayContent += `<p><strong>Compile Output:</strong> ${submissionData.compile_output}</p>`;
							}
							if (!submissionData.stdout && !submissionData.stderr && !submissionData.compile_output&&!submissionData.status &&!submissionData.time &&!submissionData.memory &&!submissionData.created_at&&!submissionData.finished_at) 
							{
								displayContent = `<p>No output available.</p>`;
							}

							resultDisplay.innerHTML = displayContent;
						}).catch(error => {
							console.error('Error:', error);
							const resultDisplay = document.getElementById('resultDisplay');
							resultDisplay.innerHTML = `<p>Error occurred while processing the submission: ${error.message} </p>`;
						});
					});

				</script>
			</div>
			<div class="resize-handle"></div>
		</div>
	</div>

    <div class="container mt-4">
        
        
        <div class="green-header mb-4">
            <h2 style="color: rgb(3, 191, 98)"><?php echo $video['title']; ?></h2>
            <p>Course: <?php echo $video['course_title']; ?></p>
        </div>
		<div class="row">  
			<div class="col-md-3 col-sm-6 goback">
				<a href="course_videos.php?course_id=<?php echo $video['course_id']; ?>" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;">Go back to <?php echo $video['course_title']; ?> </a>
			</div>
		</div>

        <div class="video-container">
            <iframe width="100%" height="100%" src="<?php echo $video['youtube_embed_url']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			
        </div>
		
		<button id="openQAButton" class="btn btn mt-3" style="background-color: rgb(3, 191, 98); ">Open DOCs/Q&A</button>

		<!-- sliding window div -->
		<div id="qaWindow" class="qa-window">
			<nav class="qa-nav">
				<ul class="nav nav-tabs">


					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#Docs">Documents</a>
					</li>



					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#qa">Q&A</a>
					</li>
				</ul>
			</nav>
			<!-- upload document-->
			<div class="tab-content">
				<div class="tab-pane fade show active" id="Docs">
				<div class="mb-3">
						<label for="document" class="form-label">Provided docs:</label>
						<?php if ($is_author): ?>
							<form id="docForm">
								<textarea class="form-control" id="description" name="document" required><?php echo htmlspecialchars($document['content'] ?? ''); ?></textarea>
								<button type="submit" class="btn btn mt-3" style="background-color: rgb(3, 191, 98); margin-top: 4px; margin-bottom: 10px;">
									<?php echo $document ? 'Update' : 'Upload'; ?> Document
								</button>
								<?php if ($document): ?>
									<button type="button" id="deleteDoc" class="btn btn-danger mt-2">Delete Document</button>
								<?php endif; ?>
							</form>
						<?php else: ?>
							<div class="form-control" style="height: auto; min-height: 100px;">
								<?php echo nl2br(htmlspecialchars($document['content'] ?? 'No document available.')); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>


				<div class="tab-pane fade" id="qa">
					<h3>Questions and Answers</h3>
					<div class="mb-3">
					<div class="input-group">
						<input type="text" id="qaSearch" class="form-control" placeholder="Search questions...">
						<select id="searchType" class="form-select">
							<option value="title">Title</option>
							<option value="error_log">Error Log</option>
							<option value="problem_description">Problem Description</option>
						</select>
					</div>
					</div>
					<button id="askQuestionBtn"class="btn btn mt-3" style="background-color: rgb(3, 191, 98); margin-top: 4px; margin-bottom: 10px;">Ask a Question</button>
					<div id="questionForm" style="display: none;">
						<form id="newQuestionForm">
							<input type="hidden" name="video_id" value="<?php echo $video_id; ?>">
							<div class="mb-3">
								<label for="questionTitle" class="form-label">Question Title</label>
								<input type="text" class="form-control" id="questionTitle" name="title" required>
							</div>
							<div class="mb-3">
								<label for="code" class="form-label">Code (optional)</label>
								<textarea class="form-control" id="code" name="code" rows="3"></textarea>
							</div>
							<div class="mb-3">
								<label for="errorLog" class="form-label">Error Log (optional)</label>
								<textarea class="form-control" id="errorLog" name="error_log" rows="3"></textarea>
							</div>
							<div class="mb-3">
								<label for="problemDescription" class="form-label">Problem Description</label>
								<textarea class="form-control" id="problemDescription" name="problem_description" rows="3" required></textarea>
							</div>
							<div class="mb-3">
								<label for="attemptedSolutions" class="form-label">Attempted Solutions (optional)</label>
								<textarea class="form-control" id="attemptedSolutions" name="attempted_solutions" rows="3"></textarea>
							</div>
							<button type="submit" class="btn btn mt-3" style="background-color: rgb(3, 191, 98); margin-top: 4px; margin-bottom: 10px;">Submit Question</button>
						</form>
					</div>
					<div id="questionsList">
						<!-- Questions will be loaded here dynamically -->
					</div>
				</div>
			</div>
		</div>
			<p class="card-text" style = "flex-grow: 1; font-size: 20px;margin-top:20px"><?php echo "Discription:" . $video['description']; ?></p>

        <div class="comment-section">
			<h3>Comments</h3>
			<?php
			while ($comment = $comments_result->fetch_assoc()) {
				?>
				<div class='comment'>
					<div class='comment-header'>
						<img src='<?php echo $comment['Profile_Picture'] ? $comment['Profile_Picture'] : DEFAULT_PROFILE_IMG; ?>' 
							alt='Profile Picture' class='profile-pic'>
						<strong><?php echo htmlspecialchars($comment['Handle']); ?></strong>
					</div>
					<p><?php echo htmlspecialchars($comment['content']); ?></p>
					<small>Posted on <?php echo $comment['created_at']; ?></small>
					<!--toggle to show replies -->
					<br>
					<button class="btn btn-sm btn-secondary mt-2" onclick="toggleReplies(<?php echo $comment['id']; ?>)">Show Replies</button>
        			<div id="replies-<?php echo $comment['id']; ?>" class="replies mt-2" style="display: none;"></div>

					<!-- Reply form -->
					<form action='add_reply.php' method='post' class='reply-form mt-2'>
						<input type='hidden' name='comment_id' value='<?php echo $comment['id']; ?>'>
						<input type='hidden' name='video_id' value='<?php echo $video_id; ?>'>
						<div class='form-group'>
							<textarea class='form-control' name='content' rows='2' placeholder='Write a reply...' required></textarea>
						</div>
						<button type='submit' class='btn btn-sm btn-secondary mt-1'>Reply</button>
					</form>
					<div id="replies-<?php echo $comment['id']; ?>" class="replies mt-2" style="display: none;"></div>
				</div>
				<?php
			}
			?>

			
		</div>
		<!-- Add new comment form -->
			<form action="add_comment.php" method="post">
				<input type="hidden" name="video_id" value="<?php echo $video_id; ?>">
				<div class="form-group">
					<label for="comment">Add a comment:</label>
					<textarea class="form-control" id="comment" name="content" rows="3" required></textarea>
				</div>
				<button type="submit" class="btn btn mt-3" style="background-color: rgb(3, 191, 98); margin-top: 4px; margin-bottom: 10px;">Post Comment</button>
			</form>
	</div>
    <footer class="text-center py-4" style="background-color: rgb(3, 191, 98);">
        <p style="color: white;">&copy; 2024 AUST CODE REALM. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script>
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
				floatingButton.style.width = '600px'; // Expanded width
				floatingButton.style.height = '800px'; // Expanded height
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
	</script>
	<!-- toogle & append new replies-->
	<script>
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
	</script>
	<!--Q&A Script-->
	<script>
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
	</script>

	<!-- update and delete document-->
	<script>
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
	</script>
</body>
</html>

<?php
$conn->close();
?>
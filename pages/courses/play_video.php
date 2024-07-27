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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/problemPage.css">
    <link rel="stylesheet" href="../../css/navbar.css">
	
    <title><?php echo $video['title']; ?> - AUST CODE REALM</title>
    <style>
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(3, 191, 98, 0.3);
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 15px;
        }

        .comment-section {
            margin-top: 20px;
            height: 400px; 
            overflow-y: auto; 
            border: 1px solid #eee; 
            padding: 15px;
        }
        .comment {
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .reply-form {
        margin-top: 10px;
        margin-bottom: 10px;
		}
		.reply {
			margin-left: 20px;
			border-left: 2px solid #ddd;
			padding-left: 10px;
		}
		.btn {
            margin-top: auto;
            overflow: hidden;
            color: white;
        }
        
        .btn:active {
            overflow: hidden;
            transform: none !important;
        }
        .bg-image {
            position: relative;
            overflow: hidden;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .ripple {
            position: relative;
            overflow: hidden;
        }
        .ripple::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 255, 0, 0.2);
            pointer-events: none;
            transition: opacity 0.3s;
            opacity: 0;
        }
        .ripple:hover::before {
            opacity: 1;
        }
		
		.floating-button {
			position: fixed;
			width: 100px;
			height: 40px;
			bottom: 40px;
			right: 40px;
			background-color: rgb(3, 191, 98);
			color: #fff;
			border-radius: 20px;
			text-align: center;
			box-shadow: 2px 2px 3px #999;
			z-index: 1000;
			cursor: pointer;
			transition: all 0.3s ease;
			overflow: hidden;
		}

		.floating-button .button-content {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100%;
			font-size: 16px;
		}

		.floating-button .expanded-content {
			display: none;
			flex-direction: column;
			height: 100%;
		}

		.floating-button.expanded {
			width: 300px;
			height: 200px;
			border-radius: 10px;
		}

		.floating-button.expanded .button-content {
			display: none;
		}

		.floating-button.expanded .expanded-content {
			display: flex;
		}

		.floating-button .header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 10px;
			background-color: rgba(255, 255, 255, 0.1);
			cursor: move;
		}

		.floating-button .content {
			padding: 10px;
			flex-grow: 1;
			overflow-y: auto;
		}

		.floating-button .resize-handle {
			width: 10px;
			height: 10px;
			background-color: rgba(255, 255, 255, 0.5);
			position: absolute;
			right: 0;
			bottom: 0;
			cursor: se-resize;
		}

		#closeButton {
			background: none;
			border: none;
			color: #fff;
			font-size: 20px;
			cursor: pointer;
		}
		.comment-header, .reply-header {
			display: flex;
			align-items: center;
			margin-bottom: 5px;
		}

		.profile-pic {
			width: 40px;
			height: 40px;
			border-radius: 50%;
			margin-right: 10px;
		}

		.profile-pic-small {
			width: 30px;
			height: 30px;
			border-radius: 50%;
			margin-right: 10px;
			object-fit: cover;
		}

		.reply {
			margin-left: 40px;
			border-left: 2px solid #ddd;
			padding-left: 10px;
			margin-top: 10px;
		}
		.ace_editor {
			padding-left: 10px;
		}
		.ace_gutter {
			width: 50px !important;
		}
		.qa-window {
			position: fixed;
			top: 0;
			right: 0;
			height: 100%;
			width: 0;
			background-color: #f8f9fa;
			overflow-x: hidden;

			transition: 0.5s;
			padding-top: 60px;
			box-shadow: -2px 0 5px rgba(0,0,0,0.1);
		}

		.qa-nav {
			padding: 10px;
		}

		.tab-content {
			padding: 20px;
		}

		.question, .answer {
			overflow-y: auto; 
			border: 1px solid #ddd;
			padding: 10px;
			margin-bottom: 10px;
			border-radius: 5px;
		}

		pre code {
			display: block;
			background-color: #f8f9fa;
			border: 1px solid #e9ecef;
			border-radius: 4px;
			padding: 10px;
			white-space: pre-wrap;
			word-wrap: break-word;
		}
	</style>
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
		
		<button id="openQAButton" class="btn btn mt-3" style="background-color: rgb(3, 191, 98); ">Open Q&A</button>

		<!-- sliding window div -->
		<div id="qaWindow" class="qa-window">
			<nav class="qa-nav">
				<ul class="nav nav-tabs">


					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#dummy">Dummy</a><!-- have to put docs here-->
					</li>



					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#qa">Q&A</a>
					</li>
				</ul>
			</nav>
			<div class="tab-content">
				<div class="tab-pane fade show active" id="dummy">
					<p>This is a dummy tab.</p>
				</div>
				<div class="tab-pane fade" id="qa">
					<h3>Questions and Answers</h3>
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
					
					<!-- Reply form -->
					<form action='add_reply.php' method='post' class='reply-form mt-2'>
						<input type='hidden' name='comment_id' value='<?php echo $comment['id']; ?>'>
						<input type='hidden' name='video_id' value='<?php echo $video_id; ?>'>
						<div class='form-group'>
							<textarea class='form-control' name='content' rows='2' placeholder='Write a reply...' required></textarea>
						</div>
						<button type='submit' class='btn btn-sm btn-secondary mt-1'>Reply</button>
					</form>

					<!-- Replies -->
					<?php
					$replies_sql = "SELECT r.*, u.Handle, u.Profile_Picture FROM replies r 
									JOIN users u ON r.user_id = u.UserID 
									WHERE r.comment_id = ? AND r.video_id = ? ORDER BY r.created_at ASC";
					$replies_stmt = $conn->prepare($replies_sql);
					$replies_stmt->bind_param("ii", $comment['id'], $video_id);
					$replies_stmt->execute();
					$replies_result = $replies_stmt->get_result();

					while ($reply = $replies_result->fetch_assoc()) {
						?>
						<div class='reply'>
							<div class='reply-header'>
								<img src='<?php echo $reply['Profile_Picture'] ? $reply['Profile_Picture'] : DEFAULT_PROFILE_IMG; ?>' 
									 alt='Profile Picture' class='profile-pic-small'>
								<strong><?php echo htmlspecialchars($reply['Handle']); ?></strong>
							</div>
							<p><?php echo htmlspecialchars($reply['content']); ?></p>
							<small>Replied on <?php echo $reply['created_at']; ?></small>
						</div>
						<?php
					}
					$replies_stmt->close();
					?>
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
					<button type="submit" class="btn btn-auto mt-3"style="background-color: rgb(3, 191, 98); margin-top: 4px; margin-bottom: 10px;">Submit Answer</button>
				</form>
			`;
			return element;
		}

		window.showAnswers = function(questionId) {
			const answersContainer = document.getElementById(`answers-${questionId}`);
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
			});
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
					showAnswers(questionId);
				} else {
					alert('Error submitting answer. Please try again.');
				}
			});
		};

		loadQuestions();
	});
</script>





</body>
</html>

<?php
$conn->close();
?>
<?php include 'editProblemHelper.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="style.css">
    <title>Edit Problem - AUST CODE REALM</title>
    <script src="../js/tinymce/tinymce.min.js"></script>
    <script src="../js/tinyMCEinit.js"></script>
</head>
<body>
    <?php include '../helpers/navbar.php'; ?>
    <div class="container">
        <?php if (isset($_SESSION['alert'])): ?>
            <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['alert']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        <!-- Problem Details Section -->
        <div class="section-header">
            <h2>Problem Details</h2>
        </div>
        <form action="" method="post">
            <div class="row mb-3">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <label for="problemNumber" class="form-label">Problem Number</label>
                    <input type="text" class="form-control" id="problemNumber" name="problemNumber" value="<?= $problem['ProblemNumber'] ?>" required>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <label for="name" class="form-label">Problem Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $problem['Name'] ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Problem Description</label>
                <textarea id="description" name="description"><?= htmlspecialchars($problem['PlmDescription']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="inputSpecification" class="form-label">Input Specification</label>
                <textarea id="inputSpecification" name="inputSpecification"><?= htmlspecialchars($problem['InputSpecification']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="outputSpecification" class="form-label">Output Specification</label>
                <textarea id="outputSpecification" name="outputSpecification"><?= htmlspecialchars($problem['OutputSpecification']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea id="note" name="note"><?= htmlspecialchars($problem['Note']) ?></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <label for="memoryLimit" class="form-label">Memory Limit (KB)</label>
                    <input type="number" class="form-control" id="memoryLimit" name="memoryLimit" value="<?= $problem['MemoryLimit'] ?>" required>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <label for="timeLimit" class="form-label">Time Limit (ms)</label>
                    <input type="number" class="form-control" id="timeLimit" name="timeLimit" value="<?= $problem['TimeLimit'] ?>" required>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <label for="ratedFor" class="form-label">Rated For</label>
                    <input type="text" class="form-control" id="ratedFor" name="ratedFor" value="<?= $problem['RatedFor'] ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="sampleTestCaseNo" class="form-label">No. of Sample Test Cases</label>
                    <input type="number" class="form-control" id="sampleTestCaseNo" name="sampleTestCaseNo" value="<?= $problem['sampleTestNo'] ?>" placeholder="Serially top few Testcases will be added" required>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="sampleTestCaseNo" class="form-label">Contest ID</label>
                    <input type="number" class="form-control" id="contestID" name="contestID" value="<?= $contest_id ?>"required>
                </div>
            </div>
            <button type="submit" name="updateDetails" class="btn btn-primary">Save Problem Details</button>
        </form>

        <!-- Tags Section -->
        <div class="section-header">
            <h2>Tags</h2>
        </div>
        <form action="" method="post">
            <div class="mb-3">
                <div class="tag-container">
                    <?php foreach ($tags as $tag): ?>
                        <div class="tag-item">
                            <input type="checkbox" id="tag_<?= $tag['TagID'] ?>" name="tags[]" value="<?= $tag['TagID'] ?>" <?= $tag['selected'] ? 'checked' : '' ?>>
                            <label for="tag_<?= $tag['TagID'] ?>"><?= $tag['TagName'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="newTag" class="form-label">Create New Tag:</label>
                <div class="input-group">
                    <input type="text" id="newTag" name="newTag" class="form-control">
                    <button type="submit" name="createTag" class="btn btn-primary">Create Tag</button>
                </div>
            </div>
            <button type="submit" name="saveTags" class="btn btn-primary">Save Tags</button>
        </form>


        <!-- Test Cases Section -->
        <div class="section-header">
            <h2>Test Cases</h2>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Test Case No</th>
                    <th>Input</th>
                    <th>Output</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testCases as $testCase): ?>
                    <tr>
                        <td><?= $testCase['No'] ?></td>
                        <td><textarea readonly><?= htmlspecialchars($testCase['Input']) ?></textarea></td>
                        <td><textarea readonly><?= htmlspecialchars($testCase['Output']) ?></textarea></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateTestCaseModal_<?= $testCase['ID'] ?>">Update</button>
                            <form action="" method="post" class="d-inline">
                                <input type="hidden" name="testCaseID" value="<?= $testCase['ID'] ?>">
                                <input type="hidden" name="testCaseNo" value="<?= $testCase['No'] ?>">
                                <button type="submit" name="deleteTestCase" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Update Test Case Modal -->
                    <div class="modal fade" id="updateTestCaseModal_<?= $testCase['ID'] ?>" tabindex="-1" aria-labelledby="updateTestCaseModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateTestCaseModalLabel">Update Test Case #<?= $testCase['No'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="testCaseID" value="<?= $testCase['ID'] ?>">
                                        <div class="mb-3">
                                            <label for="updatedInput_<?= $testCase['ID'] ?>" class="form-label">Input</label>
                                            <textarea id="updatedInput_<?= $testCase['ID'] ?>" name="updatedInput" required><?= htmlspecialchars($testCase['Input']) ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="updatedOutput_<?= $testCase['ID'] ?>" class="form-label">Output</label>
                                            <textarea id="updatedOutput_<?= $testCase['ID'] ?>" name="updatedOutput" required><?= htmlspecialchars($testCase['Output']) ?></textarea>
                                        </div>
                                        <input type="hidden" name="testCaseNo" value="<?= $testCase['No'] ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="updateTestCase" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add New Test Case -->
        <div class="section-header">
            <h2>Add New Test Case</h2>
        </div>
        <form action="" method="post">
            <div class="mb-3">
                <label for="testCaseNo" class="form-label">Test Case No</label>
                <input type="number" class="form-control" id="testCaseNo" name="testCaseNo" required>
            </div>
            <div class="mb-3">
                <label for="newInput" class="form-label">Input</label>
                <textarea id="newInput" name="newInput" required></textarea>
            </div>
            <div class="mb-3">
                <label for="newOutput" class="form-label">Output</label>
                <textarea id="newOutput" name="newOutput" required></textarea>
            </div>
            <button type="submit" name="newTestCase" class="btn btn-primary">Add Test Case</button>
        </form>
    </div>
    <br>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>

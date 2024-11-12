<?php
session_start();
include('../header.php');
// Initialize error and success messages
$errorMessages = [];
$successMessage = "";

// Handle form submission for adding a student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'add_student') {
        // Add student
        $student_id = trim($_POST['student_id']);
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        
        if (empty($student_id) || empty($first_name) || empty($last_name)) {
            $errorMessages[] = "All fields are required.";
        } else {
            // Prevent re-adding student with the same ID
            $exists = false;
            foreach ($_SESSION['students'] as $student) {
                if ($student['student_id'] == $student_id) {
                    $exists = true;
                    break;
                }
            }

            if ($exists) {
                $errorMessages[] = "Student ID '$student_id' already exists!";
            } else {
                $_SESSION['students'][] = [
                    'student_id' => $student_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ];
                $successMessage = "Student added successfully!";
                
                // Redirect to the same page to avoid re-submission on refresh
                header('Location: register.php');
                exit(); // Stop further execution after redirect
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <!-- Link to your external CSS file -->
    <style>
    .bordered-container {
    border: 2px solid #ddd; /* Full border around the div */
    padding: 20px;  /* Add some padding inside the div */
    margin-top: 20px; /* Space between other elements */
    border-radius: 8px; /* Optional: rounded corners */
}</style>
</head>
<body>

<div class="container mt-3">
    <!-- Breadcrumb with clickable "Dashboard" link -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mt-5">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li> <!-- Go up one directory -->
            <li class="breadcrumb-item active" aria-current="page">Register Student</li>
        </ol>
    </nav>

    

    <!-- Success message -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success"><?= $successMessage ?></div>
    <?php endif; ?>

    <!-- Error messages -->
    <?php if (!empty($errorMessages)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errorMessages as $message): ?>
                    <li><?= $message ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Add student form inside a bordered container with padding, shadow, and border radius -->
    <div class="bordered-container">
        <form method="POST">

        <h3 class="text-left">Register a New Student</h3>
            <input type="hidden" name="action" value="add_student">
            
            <!-- Add border above the Student ID field -->
            <div class="">
                <label for="student_id">Student ID</label>
                <input type="number" class="form-control" id="student_id" name="student_id" required>
            </div>
            
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div> <!-- End of border-container -->

    <h3 class="mt-5">List of Students</h3>

    <!-- Table with a border around each cell -->
    <div class="bordered-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['students'])): ?>
                    <?php foreach ($_SESSION['students'] as $student): ?>
                        <tr>
                            <td><?= $student['student_id'] ?></td>
                            <td><?= $student['first_name'] ?></td>
                            <td><?= $student['last_name'] ?></td>
                            <td>
                                <!-- Edit button linking to edit.php with student_id -->
                                <a href="edit.php?student_id=<?= $student['student_id'] ?>" class="btn btn-warning btn-sm">Edit</a>

                                <!-- Delete button: Redirect to delete.php with student_id as a query parameter -->
                                <a href="delete.php?student_id=<?= $student['student_id'] ?>" class="btn btn-danger btn-sm">Delete</a>

                                <!-- Attach subject button -->
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="action" value="attach_subject">
                                    <input type="hidden" name="student_id_to_attach" value="<?= $student['student_id'] ?>">
                                    <button type="submit" class="btn btn-info btn-sm">Attach Subject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No students added yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div> <!-- End of border-container -->

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Include footer
include('../footer.php');
?>
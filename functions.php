<?php

function addUser($email, $password) {
    // You could integrate this with a database or a session-based user list.
    $_SESSION['users'][] = ["email" => $email, "password" => $password];
    return true;
}

function deleteUser($email) {
    if (isset($_SESSION['users'])) {
        foreach ($_SESSION['users'] as $index => $user) {
            if ($user['email'] === $email) {
                unset($_SESSION['users'][$index]);
                return true;
            }
        }
    }
    return false;
}

function updateUserPassword($email, $newPassword) {
    if (isset($_SESSION['users'])) {
        foreach ($_SESSION['users'] as &$user) {
            if ($user['email'] === $email) {
                $user['password'] = $newPassword;
                return true;
            }
        }
    }
    return false;
}

function getUserByEmail($email) {
    if (isset($_SESSION['users'])) {
        foreach ($_SESSION['users'] as $user) {
            if ($user['email'] === $email) {
                return $user;
            }
        }
    }
    return null;
}

function isLoggedIn() {
    return isset($_SESSION['email']) && $_SESSION['email'] !== '';
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function sendPasswordResetEmail($email) {
    if (!validateEmail($email)) return false;

    // Simulate sending a password reset link via email.
    return "Password reset link sent to $email";
}

function validateSubjectData($subject_data) {
    $errors = [];
    if (empty($subject_data['subject_name'])) $errors[] = "Subject Name is required.";
    if (empty($subject_data['subject_code'])) $errors[] = "Subject Code is required.";
    return $errors;
}

function addSubject($subject_data) {
    if (!empty($subject_data)) {
        $_SESSION['subjects'][] = $subject_data;
        return true;
    }
    return false;
}

function getSubjects() {
    return isset($_SESSION['subjects']) ? $_SESSION['subjects'] : [];
}

function deleteSubject($subject_code) {
    if (isset($_SESSION['subjects'])) {
        foreach ($_SESSION['subjects'] as $index => $subject) {
            if ($subject['subject_code'] === $subject_code) {
                unset($_SESSION['subjects'][$index]);
                return true;
            }
        }
    }
    return false;
}

function getSubjectByCode($subject_code) {
    if (isset($_SESSION['subjects'])) {
        foreach ($_SESSION['subjects'] as $subject) {
            if ($subject['subject_code'] === $subject_code) {
                return $subject;
            }
        }
    }
    return null;
}

function validateStudentEnrollment($student_id, $subject_code) {
    if (!empty($_SESSION['student_data']) && !empty($_SESSION['subjects'])) {
        foreach ($_SESSION['student_data'] as $student) {
            if ($student['student_id'] === $student_id) {
                foreach ($_SESSION['subjects'] as $subject) {
                    if ($subject['subject_code'] === $subject_code) {
                        return true;
                    }
                }
            }
        }
    }
    return false;
}

function enrollStudentInSubject($student_id, $subject_code) {
    if (validateStudentEnrollment($student_id, $subject_code)) {
        $_SESSION['enrollments'][] = ['student_id' => $student_id, 'subject_code' => $subject_code];
        return true;
    }
    return false;
}

function getStudentEnrollments($student_id) {
    $enrollments = [];
    if (!empty($_SESSION['enrollments'])) {
        foreach ($_SESSION['enrollments'] as $enrollment) {
            if ($enrollment['student_id'] === $student_id) {
                $enrollments[] = $enrollment;
            }
        }
    }
    return $enrollments;
}

function removeStudentFromSubject($student_id, $subject_code) {
    if (!empty($_SESSION['enrollments'])) {
        foreach ($_SESSION['enrollments'] as $index => $enrollment) {
            if ($enrollment['student_id'] === $student_id && $enrollment['subject_code'] === $subject_code) {
                unset($_SESSION['enrollments'][$index]);
                return true;
            }
        }
    }
    return false;
}

// Check if the user is logged in, else redirect to login
function guard() {
    if (empty($_SESSION['email']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
        // Only redirect if the user is not logged in and is trying to access a protected page
        header("Location: index.php"); 
        exit;
    }
}

guard(); // Use guard at the top of protected pages

?>

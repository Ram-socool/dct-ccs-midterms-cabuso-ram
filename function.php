<?php
session_start();

function getUsers() {
    return [
        ['email' => 'user1@email.com', 'password' => 'password1'],
        ['email' => 'user2@email.com', 'password' => 'password2'],
    ];
}
function deleteStudent($id) {
    $students = getStudents();

    // Filter out the student with the specified ID
    $students = array_filter($students, function($student) use ($id) {
        return $student['id'] != $id;
    });

    // Reindex the array and save it back to the session
    $_SESSION['students'] = array_values($students); // Reindex the array
}

function getStudents() {
    if (!isset($_SESSION['students'])) {
        $_SESSION['students'] = []; // Initialize as an empty array if not set
    }
    return $_SESSION['students'];
}
function getStudentById($id) {
    $students = getStudents();
    foreach ($students as $student) {
        if ($student['id'] == $id) {
            return $student;
        }
    }
    return null; // Return null if the student is not found
}

function validateLoginCredentials($email, $password) {
    $errors = [];
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    return $errors;
}

function checkLoginCredentials($email, $password, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return true;
        }
    }
    return false;
}

function checkUserSessionIsActive() {
    return isset($_SESSION['user']);
}

// functions.php

function guard() {
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        header("Location: index.php");
        exit;
    }
}


function displayErrors($errors) {
    if (!empty($errors)) {
        echo "<ul style='color: red;'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}
?>

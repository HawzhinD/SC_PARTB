<?php

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function insertUser($pdo, $userData, $passwordHash) {
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->execute([$userData['username'], $passwordHash, $userData['email']]);
}

function logUserCreation($pdo, $userId, $ip) {
    $stmt = $pdo->prepare("INSERT INTO logs (user_id, ip, action) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $ip, 'User created']);
}

function createUser($pdo, $userData, $ip) {
    $passwordHash = hashPassword($userData['password']);
    insertUser($pdo, $userData, $passwordHash);
    logUserCreation($pdo, $userData['username'], $ip);
}

function logActivity($pdo, $message, $ip) {
    $stmt = $pdo->prepare("INSERT INTO logs (message, ip) VALUES (?, ?)");
    $stmt->execute([$message, $ip]);
}


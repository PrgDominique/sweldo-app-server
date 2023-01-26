<?php

namespace App\Utils;

class ValidationUtil
{

    public static function validateFirstName(string $value = null)
    {
        if (empty($value)) {
            return 'Please enter your first name';
        }
        if (strlen($value) > 255) {
            return 'Max 255 characters only';
        }
        if (preg_match("/[^A-Za-z]/", $value)) {
            return 'Only letters are allowed';
        }
        return null;
    }

    public static function validateLastName(string $value = null)
    {
        if (empty($value)) {
            return 'Please enter your last name';
        }
        if (strlen($value) > 255) {
            return 'Max 255 characters only';
        }
        if (preg_match("/[^A-Za-z]/", $value)) {
            return 'Only letters are allowed';
        }
        return null;
    }

    public static function validateEmail(string $value = null)
    {
        if (empty($value)) {
            return 'Please enter your email';
        }
        if (strlen($value) > 255) {
            return 'Max 255 characters only';
        }
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email';
        }
        return null;
    }

    public static function validatePassword(string $value = null)
    {
        if (empty($value)) {
            return 'Please enter a password';
        }
        if (strlen($value) < 8) {
            return 'Password must be 8 characters and above';
        }
        if (strlen($value) > 255) {
            return 'Max 255 characters only';
        }
        return null;
    }

    public static function validateId(string $value = null)
    {
        if (empty($value)) {
            return 'Invalid id';
        }
        if (!is_numeric($value)) {
            return 'Invalid id';
        }
        return null;
    }

    public static function validateToken(string $value = null)
    {
        if (empty($value)) {
            return 'Invalid token';
        }
        if (strlen($value) != 30) {
            return 'Invalid token';
        }
        return null;
    }

    public static function validateTimestamp(string $value = null)
    {
        if (empty($value)) {
            return 'Invalid id';
        }
        if (!is_numeric($value)) {
            return 'Invalid id';
        }
        return null;
    }

    public static function validateTaskName(string $value = null)
    {
        if (empty($value)) {
            return 'Please enter your task name';
        }
        if (strlen($value) > 255) {
            return 'Max 255 characters only';
        }
        if (preg_match("/[^A-Za-z0-9\s]/", $value)) {
            return 'Only letters, numbers and space are allowed';
        }
        return null;
    }

    public static function validateTaskDescription(string $value = null)
    {
        if (empty($value)) {
            return 'Please enter your task description';
        }
        if (strlen($value) > 255) {
            return 'Max 255 characters only';
        }
        if (preg_match("/[^A-Za-z0-9\s]/", $value)) {
            return 'Only letters, numbers and space are allowed';
        }
        return null;
    }
}

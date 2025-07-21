<?php
namespace App\Models;

class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $role; // 'seeker' or 'recruiter'
}

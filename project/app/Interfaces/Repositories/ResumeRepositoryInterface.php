<?php


namespace App\Interfaces\Repositories;

interface ResumeRepositoryInterface
{
    public function createForUser(int $userId, array $data);
    public function updateResume(int $id, array $data);
    public function deleteResume(int $id);
    public function findUserResume(int $userId);
    public function findById(int $id);
}



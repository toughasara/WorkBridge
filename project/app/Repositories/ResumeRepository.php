<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ResumeRepositoryInterface;
use App\Models\Resume;

class ResumeRepository implements ResumeRepositoryInterface
{
    
    public function createForUser(int $userId, array $data)
    {
        return Resume::create(array_merge($data, ['user_id' => $userId]));
    }

    public function updateResume(int $id, array $data)
    {
        $resume = Resume::findOrFail($id);
        $resume->update($data);
        return $resume;
    }

    public function deleteResume(int $id)
    {
        Resume::destroy($id);
    }

    public function findUserResume(int $userId)
    {
        return Resume::where('user_id', $userId)->first();
    }

    public function findById(int $id)
    {
        return Resume::findOrFail($id);
    }

}
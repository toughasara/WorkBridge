<?php


namespace App\Interfaces\Services;

interface OffreServiceInterface
{
    public function getUserOffres(int $userId);
    public function getOffreWithRelations(int $id, int $userId);
    public function createOffre(array $data, int $userId);
    public function updateOffre(int $id, array $data, int $userId);
    public function deleteOffre(int $id, int $userId);
}
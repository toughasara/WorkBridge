<?php


namespace App\Interfaces\Repositories;

interface OffreRepositoryInterface
{
    public function getByUser(int $userId);
    public function findWithRelations(int $id, array $relations = []);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function attachSkills(int $offreId, array $skillIds);
    public function syncLanguages(int $offreId, array $languageData);
}
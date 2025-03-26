<?php


namespace App\Repositories;

use App\Interfaces\Repositories\OffreRepositoryInterface;
use App\Models\Offre;

class OffreRepository implements OffreRepositoryInterface
{
    public function getByUser(int $userId)
    {
        return Offre::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function findWithRelations(int $id, array $relations = [])
    {
        return Offre::with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Offre::create($data);
    }

    public function update(int $id, array $data)
    {
        $offre = Offre::findOrFail($id);
        $offre->update($data);
        return $offre;
    }

    public function delete(int $id)
    {
        $offre = Offre::findOrFail($id);
        $offre->skills()->detach();
        $offre->languages()->detach();
        return $offre->delete();
    }

    public function attachSkills(int $offreId, array $skillIds)
    {
        $offre = Offre::findOrFail($offreId);
        $offre->skills()->sync($skillIds);
    }

    public function syncLanguages(int $offreId, array $languageData)
    {
        $offre = Offre::findOrFail($offreId);
        $offre->languages()->sync($languageData);
    }
}
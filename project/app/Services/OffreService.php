<?php


namespace App\Services;

use App\Interfaces\Repositories\OffreRepositoryInterface;
use App\Interfaces\Services\OffreServiceInterface;
use Illuminate\Support\Facades\DB;

class OffreService implements OffreServiceInterface
{
    public function __construct(
        private OffreRepositoryInterface $offreRepository
    ) {}

    public function getUserOffres(int $userId)
    {
        return $this->offreRepository->getByUser($userId);
    }

    public function getOffreWithRelations(int $id, int $userId)
    {
        $offre = $this->offreRepository->findWithRelations($id, ['skills', 'languages', 'user']);
        
        if ($offre->user_id !== $userId) {
            throw new \Exception('Unauthorized access to this offer');
        }

        return $offre;
    }

    public function createOffre(array $data, int $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $offreData = array_merge($data, ['user_id' => $userId]);
            $offre = $this->offreRepository->create($offreData);
            
            $this->offreRepository->attachSkills($offre->id, $data['skill_ids']);
            
            $languageData = [];
            if (isset($data['language_ids']) && isset($data['language_levels'])) {
                foreach ($data['language_ids'] as $index => $languageId) {
                    $languageData[$languageId] = ['level' => $data['language_levels'][$index] ?? 'débutant'];
                }
                $this->offreRepository->syncLanguages($offre->id, $languageData);
            }

            return $offre;
        });
    }

    public function updateOffre(int $id, array $data, int $userId)
    {
        return DB::transaction(function () use ($id, $data, $userId) {
            $offre = $this->offreRepository->findWithRelations($id);
            
            if ($offre->user_id !== $userId) {
                throw new \Exception('Unauthorized access to this offer');
            }

            // Gestion du statut
            if ($data['statut'] === 'publiée') {
                $data['statut'] = 'en attente';
            }

            $this->offreRepository->update($id, $data);
            $this->offreRepository->attachSkills($id, $data['skill_ids']);
            
            $languageData = [];
            if (!empty($data['language_ids'])) {
                foreach ($data['language_ids'] as $index => $languageId) {
                    $languageData[$languageId] = ['level' => $data['language_levels'][$index] ?? 'débutant'];
                }
                $this->offreRepository->syncLanguages($id, $languageData);
            }

            return $offre;
        });
    }

    public function deleteOffre(int $id, int $userId)
    {
        return DB::transaction(function () use ($id, $userId) {
            $offre = $this->offreRepository->findWithRelations($id);
            
            if ($offre->user_id !== $userId) {
                throw new \Exception('Unauthorized access to this offer');
            }

            return $this->offreRepository->delete($id);
        });
    }
    
}
<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class BaseService
{
    protected BaseRepository $repository;

    /**
     * Construct
     *
     * @param BaseRepository $repository
     */
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all data.
     *
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        try {
            return $this->repository->getAll();
        } catch (Exception $e) {
            throw $e;
        }
    }
}

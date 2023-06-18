<?php

namespace App\Repositories\Domain;

use App\Repositories\BaseRepository;
use App\Models\Entity\LifeEvent;
use Illuminate\Database\Eloquent\Collection;

class LifeEventRepository extends BaseRepository
{
    /**
     * Construct
     *
     * @param LifeEvent $model
     */
    public function __construct(LifeEvent $model)
    {
        parent::__construct($model);
    }

    /**
     * Get data by timeline_id
     *
     * @param integer $timeline_id
     * @return Collection
     */
    public function getByTimelineId(int $timeline_id): Collection
    {
        return $this->model->where('timeline_id', $timeline_id)->get();
    }
}

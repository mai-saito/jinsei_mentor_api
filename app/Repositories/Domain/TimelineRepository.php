<?php

namespace App\Repositories\Domain;

use App\Repositories\BaseRepository;
use App\Models\Entity\Timeline;
use Illuminate\Support\Collection;

class TimelineRepository extends BaseRepository
{
    /**
     * Construct
     *
     * @param Timeline $model
     */
    public function __construct(Timeline $model)
    {
        parent::__construct($model);
    }

    /**
     * Get details of the selected timeline.
     *
     * @param integer $timeline_id
     * @return Collection
     */
    public function getTimeline(int $timeline_id): Collection
    {
        return $this->model->with([
            // Get related data from life_events table.
            'lifeEvents' => function ($query) {
                $query->orderBy('age', 'ASC');
            }
        ])->where('id', $timeline_id)->get();
    }
}

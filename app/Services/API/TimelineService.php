<?php

namespace App\Services\API;

use App\Services\BaseService;
use App\Repositories\Domain\TimelineRepository;
use App\Repositories\Domain\LifeEventRepository;
use App\Models\Entity\Timeline;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class TimelineService extends BaseService
{
    protected TimelineRepository $timelineRepository;
    protected LifeEventRepository $lifeEventRepository;

    /**
     * Construct
     *
     * @param TimelineRepository $timelineRepository
     * @paramLifeEventRepository $lifeEventRepository
     */
    public function __construct(
        TimelineRepository $timelineRepository,
        LifeEventRepository $lifeEventRepository
    ) {
        $this->timelineRepository = $timelineRepository;
        $this->lifeEventRepository = $lifeEventRepository;
    }

    /**
     * Get details of the selected timeline.
     *
     * @param integer $timeline_id
     * @return Collection
     */
    public function getTimeline(int $timeline_id): Collection
    {
        try {
            return $this->timelineRepository->getTimeline($timeline_id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Create a new record of the timeline.
     *
     * @param array $inputs
     * @return Timeline
     */
    public function store(array $attributes): Timeline
    {
        try {
            // Format data for life_events.
            $life_events_attributes = !empty($attributes['life_events']) ? $attributes['life_events'] : null;

            // Format data for timelines.
            unset($attributes['life_events']);

            // Transaction starts.
            DB::beginTransaction();

            // Insert new data into timelines.
            $timeline = $this->timelineRepository->save($attributes);

            // Set timeline_id to attributes of life_events.
            $timeline_id = $timeline->id;
            $life_events_attributes = array_map(function ($data) use ($timeline_id) {
                $data['timeline_id'] = $timeline_id;
                return $data;
            }, $life_events_attributes);

            // Insert new data into life_events.
            $this->lifeEventRepository->bulkInsert($life_events_attributes);

            // Transaction ends.
            DB::commit();

            return $timeline;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

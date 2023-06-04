<?php

namespace App\Repositories\Domain;

use App\Repositories\BaseRepository;
use App\Models\Entity\Timeline;
use Illuminate\Support\Collection;

class TimelineRepository extends BaseRepository
{
    /**
     * コンストラクタ
     *
     * @param Timeline $model
     */
    public function __construct(Timeline $model)
    {
        parent::__construct($model);
    }

    /**
     * 年表詳細を年表IDから取得
     *
     * @param integer $timeline_id
     * @return Collection
     */
    public function getTimeline(int $timeline_id): Collection
    {
        return $this->model->with([
            // 年表イベントの取得
            'lifeEvents' => function ($query) {
                $query->orderBy('age', 'ASC');
            }
        ])->where('id', $timeline_id)->get();
    }
}

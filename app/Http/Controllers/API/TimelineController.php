<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Domain\TimelineRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Entity\Timeline;

class TimelineController extends Controller
{
    protected TimelineRepository $timelineRepository;

    /**
     * コンストラクタ
     *
     * @param TimelineRepository $timelineRepository
     */
    public function __construct(TimelineRepository $timelineRepository)
    {
        $this->timelineRepository = $timelineRepository;
    }

    /**
     * 人生年表のリストを取得
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTimelines(Request $request): JsonResponse
    {
        // 年表一覧を取得
        $timelines = Timeline::get();

        return response()->json($timelines);
    }

    /**
     * 人生年表の詳細を取得
     *
     * @param Request $request
     * @param integer $timeline_id
     * @return JsonResponse
     */
    public function getTimeline(Request $request, int $timeline_id): JsonResponse
    {
        $timeline = $this->timelineRepository->getTimeline($timeline_id);
        return response()->json($timeline);
    }
}

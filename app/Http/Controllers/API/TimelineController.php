<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\TimelineService;
use App\Http\Requests\API\TimelineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class TimelineController extends Controller
{
    protected TimelineService $timelineService;

    /**
     * Construct
     *
     * @param TimelineService $timelineService
     */
    public function __construct(TimelineService $timelineService)
    {
        $this->timelineService = $timelineService;
    }

    /**
     * Get a list of timelines.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Get a list of timelines.
            $timelines = $this->timelineService->getAll();

            return response()->json($timelines);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get details of the timeline.
     *
     * @param Request $request
     * @param integer $timeline_id
     * @return JsonResponse
     */
    public function show(Request $request, int $timeline_id): JsonResponse
    {
        try {
            // Get details of the timeline.
            $timeline = $this->timelineService->getTimeline($timeline_id);

            return response()->json($timeline);
        } catch (Exception $e) {
            throw $e;
        }
    }
}

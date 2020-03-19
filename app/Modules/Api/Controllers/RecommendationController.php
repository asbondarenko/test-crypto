<?php

namespace App\Modules\Api\Controllers;

use App\Models\Assessment;
use App\Models\User;
use App\Models\Recommendation;
use App\Http\Resources\Recommendation as RecommendationResource;
use App\Modules\Api\Requests\CreateRecommendationRequest;
use App\Modules\Api\Requests\ListRecommendationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends ApiController
{
    /**
     * Get recommendations of the user.
     *
     * @param ListRecommendationRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ListRecommendationRequest $request)
    {
        $recommendations = Recommendation::where('user_id', $request->get('user_id'))->paginate();

        return RecommendationResource::collection($recommendations);
    }

    /**
     * Create recommendation for user.
     *
     * @param \App\Modules\Api\Requests\CreateRecommendationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRecommendationRequest $request)
    {
        $recommendation = Recommendation::create($request->all());

        return response()->json(new RecommendationResource($recommendation), 201);
    }

    /**
     * Add a like assessment.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Recommendation $recommendation
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, Recommendation $recommendation)
    {
        $params = [
            'recommendation_id' => $recommendation->id,
            'user_id' => Auth::id(),
        ];

        Assessment::updateOrCreate($params, ['state' => Assessment::LIKE]);

        return response()->json(null, 200);
    }

    /**
     * Add a dislike assessment.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Recommendation $recommendation
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislike(Request $request, Recommendation $recommendation)
    {
        $params = [
            'recommendation_id' => $recommendation->id,
            'user_id' => Auth::id(),
        ];

        Assessment::updateOrCreate($params, ['state' => Assessment::DISLIKE]);

        return response()->json(null, 200);
    }

    /**
     * Remove assessment.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Recommendation $recommendation
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAssessment(Request $request, Recommendation $recommendation)
    {
        $params = [
            'recommendation_id' => $recommendation->id,
            'user_id' => Auth::id(),
        ];

        $assessment = Assessment::where($params)->firstOrFail();
        $assessment->state = Assessment::VOID;
        $assessment->save();

        return response()->json(null, 200);
    }
}

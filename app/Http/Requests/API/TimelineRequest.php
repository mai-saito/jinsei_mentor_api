<?php

namespace App\Http\Requests\API;

use App\Http\Requests\BaseFormRequest;
use App\Repositories\Domain\TimelineRepository;
use Illuminate\Contracts\Validation\Validator;

class TimelineRequest extends BaseFormRequest
{
    protected TimelineRepository $timelineRepository;

    /**
     * Construct
     *
     * @param TimelineRepository $timelineRepository
     */
    public function __construct(TimelineRepository $timelineRepository)
    {
        $this->timelineRepository = $timelineRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'numeric|required',
            'title' => 'string|required_if:timeline_id,null|max:100',
            'description' => 'string',
            'life_events' => 'required',
            'life_events.*.title' => 'string|max:100',
            'life_events.*.description' => 'string',
            'life_events.*.slug' => 'string|max:20',
            'life_events.*.age' => 'int|required',
        ];
    }

    /**
     * Additional validation
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        // No further validation when it is for the new data entry.
        if ($this->input('timeline_id') === null) {
            return;
        }

        // Check if the data record exists when the update.
        $validator->after(function ($validator) {
            // Retrieve data from Timelines table by timeline_id.
            $data = $this->timelineRepository->exists(['id' => $this->input('timeline_id')]);

            // return an error message.
            if (is_null($data)) {
                $validator->errors()->add('timeline_id', '年表がすでに削除されています。');
            }
        });
    }
}

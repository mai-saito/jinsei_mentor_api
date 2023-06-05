<?php

namespace App\Http\Requests\API;

use App\Http\Requests\BaseFormRequest;
use App\Repositories\Domain\TimelineRepository;
use Illuminate\Contracts\Validation\Validator;

class TimelineRequest extends BaseFormRequest
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
            'user_id' => 'number|required',
            'title' => 'string|required|max:100',
            'description' => 'string',
            'life_events' => 'required',
            'life_events.*.title' => 'string|required|max:100',
            'life_events.*.description' => 'string',
            'life_events.*.slug' => 'string|required|max:20',
            'life_events.*.age' => 'int|required',
        ];
    }

    /**
     * 追加バリデーション処理
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        // 新規登録の場合
        if ($this->input('timeline_id') === null) {
            return;
        }

        // 更新の場合はデータの存在チェック
        $validator->after(function ($validator) {
            // 年表テーブルからデータを取得
            $data = $this->timelineRepository->getBy($this->input('timeline_id'));

            // データが存在しない場合はバリデーションメッセージを返却
            if (is_null($data)) {
                $validator->errors()->add('timeline_id', '年表がすでに削除されています。');
            }
        });
    }
}

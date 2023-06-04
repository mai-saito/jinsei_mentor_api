<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Exception;


/**
 * 共通DB処理
 */
class BaseRepository
{
    protected Model $model;

    /**
     * コンストラクタ
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * 登録・更新処理
     *
     * @param array $attributes
     * @return mixed
     */
    public function save(array $attributes): mixed
    {
        try {
            // カラム情報を取得
            $table = $this->model->getTable();
            $columns = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($table);

            // テーブルに存在しないカラムは削除
            foreach ($attributes as $key => $value) {
                if (!in_array($key, $columns)) {
                    unset($attributes[$key]);
                }
            }

            // 更新処理の場合
            if (isset($attributes['id'])) {
                // idを更新用の項目値から削除
                $id = $attributes['id'];
                unset($attributes['id']);

                // クエリ生成
                $query = $this->model->where('id', $id);

                // 更新日時が項目値に存在する場合は排他チェック
                if (isset($attributes['updated_at'])) {
                    // データから更新日時の取得
                    $updated_at = clone $query->first('updated_at')->updated_at;

                    if ($updated_at !== $attributes['updated_at']) {
                        // TODO: 排他チェック用例外作成
                        throw new Exception('排他チェック');
                    }
                }

                // データ更新
                return $query->update($attributes);
            }

            // データ登録
            return $this->model->create($attributes);
        } catch (Exception $e) {
            throw $e;
        }
    }
}

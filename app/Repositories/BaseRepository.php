<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Exception;

class BaseRepository
{
    protected Model $model;

    /**
     * Construct
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get data by a key.
     *
     * @param int|array $value
     * @param string $key
     * @return ?Model
     */
    public function getBy(int|array $value): ?Model
    {
        $query = $this->model->query();

        // Find data by primary key if $value is integer.
        if (is_int($value)) {
            return $query->find($value);
        }

        foreach ($value as $key => $val) {
            $query->where($key, $value);
        }
        return $query->first();
    }

    /**
     * Get all data.
     *
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->model->get();
    }

    /**
     * Insert or update data.
     *
     * @param array $attributes
     * @return Model|integer
     */
    public function save(array $attributes): Model|int
    {
        try {
            // Get all columns of the table.
            $table = $this->model->getTable();
            $columns = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($table);

            // Unset columns if not exists in the table.
            foreach ($attributes as $key => $value) {
                if (!in_array($key, $columns)) {
                    unset($attributes[$key]);
                }
            }

            // Update
            if (isset($attributes['id'])) {
                // unset 'id' from $attributes.
                $id = $attributes['id'];
                unset($attributes['id']);

                // Create a query
                $query = $this->model->where('id', $id);

                // Exclusive check if 'updated_at' exists in $attributes.
                if (isset($attributes['updated_at'])) {
                    // Get 'updated_at' of the registed data record.
                    $updated_at = clone $query->first('updated_at')->updated_at;

                    if ($updated_at !== $attributes['updated_at']) {
                        // TODO: 排他チェック用例外作成
                        throw new Exception('排他チェック');
                    }
                }

                // Update the data record with $attributes.
                return $query->update($attributes);
            }

            // Insert
            return $this->model->create($attributes);
        } catch (Exception $e) {
            throw $e;
        }
    }
}

<?php

namespace App\Repositories;

use App\Exceptions\ExclusiveLockException;
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
                        // Throw ExclusiveLockException if these updated_at do not match.
                        throw new ExclusiveLockException();
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

    /**
     * Bulk insert
     *
     * @param array $data
     * @return void
     */
    public function bulkInsert(array $data): void
    {
        try {
            // Get all columns of the table.
            $table = $this->model->getTable();
            $columns = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($table);

            // Get current datetime for created_at/updated_at.
            $timestamp = Carbon::now();

            // Unset columns if not exists in the table.
            foreach ($data as $index => $attributes) {
                // Unset items if not defined in the table.
                foreach ($attributes as $key => $value) {
                    if (!in_array($key, $columns)) {
                        unset($attributes[$key]);
                    }
                }

                foreach ($columns as $column) {
                    // Set timestamp for created_at/updated_at.
                    if ($column === 'created_at' || $column === 'updated_at') {
                        $data[$key][$column] = $timestamp;
                    }

                    // Set null to columns if not set in $attributes.
                    if (!array_key_exists($column, $attributes) && !in_array($column, $this->model->getGuarded())) {
                        $data[$index][$column] = null;
                    }
                }
            }

            // Insert all data.
            $this->model->insert($data);
        } catch (Exception $e) {
            throw $e;
        }
    }
}

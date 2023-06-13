<?php

namespace App\Repositories\Domain;

use App\Repositories\BaseRepository;
use App\Models\Entity\LifeEvent;

class LifeEventRepository extends BaseRepository
{
    /**
     * Construct
     *
     * @param LifeEvent $model
     */
    public function __construct(LifeEvent $model)
    {
        parent::__construct($model);
    }
}

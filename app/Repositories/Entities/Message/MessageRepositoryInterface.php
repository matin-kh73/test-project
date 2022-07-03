<?php

namespace App\Repositories\Entities\Message;

use Illuminate\Support\Collection;

interface MessageRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getMessages(): Collection;
}

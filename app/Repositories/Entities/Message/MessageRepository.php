<?php

namespace App\Repositories\Entities\Message;

use App\Models\Message;
use App\Repositories\BaseRepository;
use \Illuminate\Support\Collection;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function __construct(Message $message)
    {
        parent::__construct($message);
    }

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->model->get();
    }
}

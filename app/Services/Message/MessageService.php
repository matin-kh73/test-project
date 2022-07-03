<?php

namespace App\Services\Message;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;

class MessageService
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $entity;

    public function __construct(Message $message)
    {
        $this->entity = $message->newQuery();
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function store(array $data): Model
    {
        return $this->entity->create($data);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        return $this->entity->insert($data);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return int
     */
    public function update(int $id, array $data)
    {
        return $this->entity->where('id', $id)->update($data);
    }
}

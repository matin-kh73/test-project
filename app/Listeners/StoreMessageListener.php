<?php

namespace App\Listeners;

use App\Events\MessageSendSuccessfullyEvent;
use App\Http\Resources\KaveNegarResource;
use App\Services\Message\MessageService;

class StoreMessageListener
{
    /**
     * Create the event listener.
     *
     * @param MessageService $messageService
     */
    public function __construct(private MessageService $messageService)
    {

    }

    /**
     * Handle the event.
     *
     * @param MessageSendSuccessfullyEvent $event
     * @return void
     */
    public function handle(MessageSendSuccessfullyEvent $event)
    {
        $data = KaveNegarResource::collection($event->data)->resolve();
        $this->messageService->insert($data) ;
    }
}

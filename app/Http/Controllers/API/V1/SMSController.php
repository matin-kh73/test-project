<?php

namespace App\Http\Controllers\API\V1;

use App\Facades\SMSManager;
use App\Http\Controllers\Controller;
use App\Repositories\Entities\Message\MessageRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SMSController extends Controller
{
    /**
     * @var MessageRepositoryInterface
     */
    private $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function sendAsyncMessage(Request $request): JsonResponse
    {
        $message = $request->get('message');
        $receptors = $request->get('receptors');

        $response = SMSManager::driver('kave-negar')->sendAsyncMessage($message, $receptors);

        return Response::withoutData($response['message']);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function sendSyncMessage(Request $request): JsonResponse
    {
        $message = $request->get('message');
        $receptors = $request->get('receptors');

        $response = SMSManager::driver('kave-negar')->sendSyncMessage($message, $receptors);
        return Response::withoutData($response['message']);
    }

    /**
     * @return JsonResponse
     */
    public function messages(): JsonResponse
    {
        $messages = $this->messageRepository->getMessages();
        return Response::success($messages, __('messages_fetch_successfully'));
    }
}

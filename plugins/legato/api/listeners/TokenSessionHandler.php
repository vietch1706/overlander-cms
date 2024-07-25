<?php

namespace Legato\Api\Listeners;

use Legato\Api\Models\Settings;
use Legato\Api\Repositories\Token;

class TokenSessionHandler
{
    /**
     * @var Token
     */
    protected $tokenRepository;

    public function __construct(Token $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function handle($user): void
    {
        $concurrentSessionNumber = Settings::get('concurrent_session_number');
        if ($user->id) {
            $tokenCollection = $this->tokenRepository->getAllTokensByUser($user->id);
            $count = $tokenCollection->count();
            foreach ($tokenCollection as $token) {
                if ($concurrentSessionNumber > 0 && $count > $concurrentSessionNumber) {
                    $this->tokenRepository->delete($token->token);
                    $count--;
                }
            }
        }
    }
}

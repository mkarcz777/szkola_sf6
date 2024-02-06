<?php
namespace App\MessageHandler;

use App\Message\SendKey;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;

#[AsMessageHandler]
class SendKeyHandler
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function __invoke(SendKey $message)
    {
        throw new RecoverableMessageHandlingException('test');

        $user = $this->userRepository->find($message->getUserId());

        if (!$user) {
            return;
        }
        // ... do some work - like sending an SMS message!
        $this->sendEmail($user->getEmail(), $this->getKey());
    }

    //ponizsze 2 metody powinny byc w zewn. projekcie z serwisami; umieszczamy je tutaj zeby nie komplikowac przykladu :)

    //symulacja wysylki maila z kluczem dla uzytkownika
    private function sendEmail(string $email, int $key)
    {
        file_put_contents('email'.$key.'.txt', $email.' '.$key);
    }

    //symulacja pobierania klucza z zewn. serwera
    private function getKey(): int
    {
        sleep(5);
        return random_int(1000, 9999);
    }
}
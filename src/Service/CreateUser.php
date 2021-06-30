<?php


namespace Esatic\activateuser\Service;


use Esatic\activateuser\mail\NotifyNewAccount;
use Esatic\activateuser\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUser
{

    /**
     * @var Request
     */
    private Request $request;

    /**
     * CreateUser constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * Create user and generate password
     * @return array
     */
    public function execute(): array
    {
        $user = new User($this->request->except(['password']));
        $user->active = true;
        $password = Str::random(8);
        $user->password = bcrypt($password);
        $user->save();
        $this->notify($user, $password);
        return array(
            'contact' => $user,
            'password' => $password
        );
    }

     public function notify(User $user, string $password)
     {
         Log::info('Sending email');
         try {
             Mail::to($user)->send(new NotifyNewAccount($user->email, $password));
         } catch (\Exception $ex) {
             Log::info('Error: ' . $ex->getMessage());
         }
         Log::info('Email sended');
     }

}

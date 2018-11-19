<?php

namespace App\Api\Auth;

use App\Http\Controllers\Controller;
use App\Api\Proxy\LoginProxy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    private $loginProxy;

    public function __construct(LoginProxy $loginProxy)
    {
        $this->loginProxy = $loginProxy;
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        return new JsonResponse($this->loginProxy->attemptLogin($email, $password));
    }

    public function refresh(Request $request)
    {
        return new JsonResponse($this->loginProxy->attemptRefresh());
    }

    public function logout()
    {
        $this->loginProxy->logout();

        return new JsonResponse(null, 204);
    }
}

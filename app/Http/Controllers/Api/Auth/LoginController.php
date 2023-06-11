<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;

final class LoginController extends Controller
{
    public function __invoke(LoginUserRequest $request): void
    {
        dd($request->validated());
    }
}
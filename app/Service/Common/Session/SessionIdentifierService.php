<?php

namespace App\Service\Common\Session;

use Illuminate\Http\Request;

class SessionIdentifierService
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function verifyIdentifier(string $identifier): bool
    {
        return $this->getIdentifier() === $identifier;
    }

    public function getIdentifier(): string
    {
        return sha1($this->request->getClientIp() . $this->request->userAgent());
    }
}


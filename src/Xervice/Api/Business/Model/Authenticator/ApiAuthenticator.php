<?php


namespace Xervice\Api\Business\Model\Authenticator;


use DataProvider\ApiAuthDataProvider;
use DataProvider\AuthenticatorDataProvider;
use Symfony\Component\HttpFoundation\Request;
use Xervice\Api\Business\Exception\AuthorizationException;
use Xervice\Security\Business\Exception\SecurityException;
use Xervice\Security\Business\SecurityFacade;

class ApiAuthenticator implements ApiAuthenticatorInterface
{
    /**
     * @var \Xervice\Security\Business\SecurityFacade
     */
    private $securityFacade;

    /**
     * ApiAuthenticator constructor.
     *
     * @param \Xervice\Security\Business\SecurityFacade $securityFacade
     */
    public function __construct(SecurityFacade $securityFacade)
    {
        $this->securityFacade = $securityFacade;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Xervice\Api\Business\Exception\AuthorizationException
     */
    public function authenticate(Request $request)
    {
        $authHeader = $request->headers->get('authorization');

        if (!$authHeader) {
            throw new AuthorizationException('No HTTP_Authorization header found');
        }

        $authParts = explode(' ', $authHeader);

        if (count($authParts) < 2) {
            throw new AuthorizationException(
                sprintf(
                    'Wrong structure for HTTP_Authorization header %s',
                    $authHeader
                )
            );
        }

        $apiAuth = new ApiAuthDataProvider();
        $apiAuth->setAuthHeader($authHeader);

        $auth = new AuthenticatorDataProvider();
        $auth->setAuthData($apiAuth);

        try {
            $this->securityFacade->authenticate($authParts[0], $auth);
        } catch (SecurityException $exception) {
            throw new AuthorizationException(
                $exception->getMessage(),
                0,
                $exception
            );
        }
    }
}
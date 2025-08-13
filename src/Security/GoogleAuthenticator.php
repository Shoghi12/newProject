<?php

namespace App\Security;

// use App\Entity\User;
// use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use PHPMailer\PHPMailer\OAuth;
use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
// use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
// use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
// use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;


/**
 * @see https://symfony.com/doc/current/security/custom_authenticator.html
 */
class GoogleAuthenticator extends OAuth2Authenticator
{

     use TargetPathTrait;

    private ClientRegistry $clientRegistry;
    private EntityManagerInterface $em;
    private RouterInterface $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router)

    {
        $this->clientRegistry = $clientRegistry;
        $this->em             = $em;
        $this->router         = $router;
    }
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
          return $request->attributes->get('_route') === 'connect_google_check';
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('google');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function() use ($accessToken, $client) {
                /** @var GoogleUser $googleUser */
                $googleUser = $client->fetchUserFromToken($accessToken);

                $email = $googleUser->getEmail();
                $googleId = $googleUser->getId();

                // 1) Cherche un user existant
                $existingUser = $this->em->getRepository(User::class)
                                          ->findOneBy(['googleId' => $googleId])
                            ?? $this->em->getRepository(User::class)
                                          ->findOneBy(['email' => $email]);

                if ($existingUser) {
                    // si l'email existe déjà mais pas googleId, on le lie
                    if (!$existingUser->getGoogleId()) {
                        $existingUser->setGoogleId($googleId);
                        $this->em->flush();
                    }
                    return $existingUser;
                }

                // 2) Sinon, on crée l’utilisateur
                $user = new User();
                    $user->setEmail($email);
                    $user->setGoogleId((string)$googleId);
                    $user->setname($googleUser->getFirstName());
                    // $user->setLastname($googleUser->getLastName());
                    $user->setRoles(['ROLE_USER']);

                $this->em->persist($user);
                $this->em->flush();

                return $user;
            })
        );
    }

public function onAuthenticationSuccess(Request $request, $token, string $firewallName): ?Response
    {
        $target = $this->getTargetPath($request->getSession(), $firewallName)
               ?? $this->router->generate('app.fo.app_home');

        return new Response('', Response::HTTP_FOUND, ['Location' => $target]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $msg = strtr($exception->getMessageKey(), $exception->getMessageData());
        return new Response($msg, Response::HTTP_FORBIDDEN);
    }
}

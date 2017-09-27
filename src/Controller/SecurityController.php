<?php

namespace Persona\Hris\Controller;

use FOS\UserBundle\Model\UserManagerInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Persona\Hris\Core\Security\Model\UserInterface;
use Persona\Hris\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class SecurityController extends Controller
{
    /**
     * @ApiDoc(
     *     section="Security",
     *     description="User authentication",
     *     requirements={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "description"="Username"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "description"="Password"
     *      }
     *  })
     *
     * @Route(name="login_check", path="/login.json")
     *
     * @Method({"POST"})
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route(
     *     name="user_me",
     *     path="/users/me.{_format}",
     *     defaults={"_api_resource_class"=User::class, "_api_collection_operation_name"="user_me", "_format": "jsonld"}
     * )
     *
     * @Method("GET")
     */
    public function getLoggedUserAction()
    {
        return $this->getUser();
    }

    /**
     * @Route(
     *     name="update_profile",
     *     path="/users/update-profile.{_format}",
     *     defaults={"_api_resource_class"=User::class, "_api_collection_operation_name"="update_profile", "_format": "jsonld"}
     * )
     *
     * @Method("PUT")
     *
     * @param Request $request
     *
     * @return User|\FOS\UserBundle\Model\UserInterface
     */
    public function getUpdateProfileAction(Request $request)
    {
        /** @var User $requestData */
        $requestData = $request->attributes->get('data');
        /** @var User $user */
        $user = $this->getUser();

        if ($requestData->getFullName()) {
            $user->setFullName($requestData->getFullName());
        }

        if ($requestData->getEmail()) {
            $user->setEmail($requestData->getEmail());
        }

        if ($requestData->getImageString()) {
            $user->setImageString($requestData->getImageString());
        }

        if ($requestData->getImageExtension()) {
            $user->setImageExtension($requestData->getImageExtension());
        }

        /** @var UserManagerInterface $manager */
        $manager = $this->container->get('fos_user.user_manager');
        $manager->updateUser($user);

        return $manager->findUserByUsername($user->getUsername());
    }

    /**
     * @ApiDoc(
     *     section="Security",
     *     description="Change user password",
     *     requirements={
     *      {
     *          "name"="plainPassword",
     *          "dataType"="string",
     *          "description"="A new password"
     *      }
     *  })
     *
     * @Route(name="change_my_password", path="/change-password.json")
     *
     * @Method({"PUT"})
     *
     * @param Request $request
     *
     * @return Response|BadRequestHttpException
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            return new BadRequestHttpException();
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $rawRequest = json_decode($request->getContent(), true);
        if (!empty($rawRequest) && array_key_exists('plainPassword', $rawRequest)) {
            $user->setPlainPassword($rawRequest['plainPassword']);
        } else {
            $user->setPlainPassword($request->get('plainPassword'));
        }

        $userManager->updateUser($user);

        return new JsonResponse(['message' => 'Password is changed'], JsonResponse::HTTP_OK);
    }

    /**
     * @ApiDoc(
     *     section="Security",
     *     description="Mark user is logged out"
     * )
     *
     * @Route(name="logout", path="/logout.json")
     *
     * @Method({"PUT"})
     *
     * @param Request $request
     *
     * @return Response|BadRequestHttpException
     */
    public function logoutAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            return new BadRequestHttpException();
        }

        $user->setSessionId(null);
        $this->container->get('fos_user.user_manager')->updateUser($user);

        return new JsonResponse(['message' => 'User is logged out'], JsonResponse::HTTP_OK);
    }

    /**
     * @ApiDoc(
     *     section="Security",
     *     description="Generate unique username"
     * )
     *
     * @Route(
     *     name="generate_username", path="/username/generate/{fullname}.{_format}",
     *     defaults={"_format": "jsonld"}
     * )
     *
     * @Method({"GET"})
     *
     * @param Request $request
     * @param string  $fullname
     *
     * @return Response|BadRequestHttpException
     */
    public function generateUsernameAction(Request $request, $fullname)
    {
        $usernameGenerator = $this->container->get('ad3n.username.generator_factory');

        return new JsonResponse(['username' => $usernameGenerator->generate($fullname, new \DateTime())]);
    }

    /**
     * @return UserInterface|null
     */
    protected function getUser(): ? UserInterface
    {
        $user = parent::getUser();
        if (!$user) {
            $user = $this->container->get('persona.repository.orm.user_repository')->findUserBySessionId($this->container->get(UserInterface::SESSION_KEY));
        }

        return $user;
    }
}

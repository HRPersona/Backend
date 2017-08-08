<?php

namespace Persona\Hris\Core\Security\Subscriber;

use Persona\Hris\Core\Security\Authorization\AuthorizationFactory;
use Persona\Hris\Core\Security\Model\ModuleRepositoryInterface;
use Persona\Hris\Core\Security\Model\RoleHierarchyRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AuthorizationCheckerSubscriber implements EventSubscriberInterface
{
    /**
     * @var ModuleRepositoryInterface
     */
    private $moduleRepository;

    /**
     * @var RoleHierarchyRepositoryInterface
     */
    private $roleHierarchy;

    /**
     * @var AuthorizationFactory
     */
    private $authorizationFactory;

    /**
     * @param ModuleRepositoryInterface        $moduleRepository
     * @param RoleHierarchyRepositoryInterface $roleHierarchyRepository
     * @param AuthorizationFactory             $authorizationFactory
     */
    public function __construct(
        ModuleRepositoryInterface $moduleRepository,
        RoleHierarchyRepositoryInterface $roleHierarchyRepository,
        AuthorizationFactory $authorizationFactory
    ) {
        $this->moduleRepository = $moduleRepository;
        $this->roleHierarchy = $roleHierarchyRepository;
        $this->authorizationFactory = $authorizationFactory;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $uri = $request->getPathInfo();
        $splitPath = array_values(array_filter(explode('/', $uri)));
        $segment = count($splitPath);

        if (2 > $segment) {
            return;
        }
        $splitPath[$segment - 1] = explode('.', $splitPath[$segment - 1])[0];

        if (2 <= $segment) {
            $uri = '/'.implode('/', $splitPath);
        }

        if ($this->authorizationFactory->isExcludeAuthorization($uri)) {
            return;
        }

        if (!$module = $this->moduleRepository->findByPath($uri)) {
            throw new AccessDeniedException();
        }

        if (!$this->roleHierarchy->isGranted($request, $module)) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 5],
        ];
    }
}

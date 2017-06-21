<?php

namespace Persona\Hris\Core\Request;

use ApiPlatform\Core\EventListener\DeserializeListener;
use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use ApiPlatform\Core\Util\RequestAttributesExtractor;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class NormalizeRequest implements EventSubscriberInterface
{
    /**
     * @var DeserializeListener
     */
    private $decorated;

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @var SerializerContextBuilderInterface
     */
    private $serializerContextBuilder;

    /**
     * @param DenormalizerInterface             $denormalizer
     * @param SerializerContextBuilderInterface $serializerContextBuilder
     * @param DeserializeListener               $decorated
     */
    public function __construct(DenormalizerInterface $denormalizer, SerializerContextBuilderInterface $serializerContextBuilder, DeserializeListener $decorated)
    {
        $this->denormalizer = $denormalizer;
        $this->serializerContextBuilder = $serializerContextBuilder;
        $this->decorated = $decorated;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->isMethodCacheable() || $request->isMethod(Request::METHOD_DELETE)) {
            return;
        }

        if ('form' === $request->getContentType()) {
            $this->denormalizeFormRequest($request);
        } else {
            $this->decorated->onKernelRequest($event);
        }
    }

    /**
     * @param Request $request
     */
    private function denormalizeFormRequest(Request $request)
    {
        try {
            $attributes = RequestAttributesExtractor::extractAttributes($request);
        } catch (RuntimeException $e) {
            return;
        }

        $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
        $populated = $request->attributes->get('data');
        if (null !== $populated) {
            $context['object_to_populate'] = $populated;
        }

        $data = $request->request->all();
        $object = $this->denormalizer->denormalize($data, $attributes['resource_class'], null, $context);
        $request->attributes->set('data', $object);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 2],
        ];
    }
}

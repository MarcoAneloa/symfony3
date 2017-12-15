<?php

namespace BlogBundle\EventListner;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleListener implements EventSubscriberInterface{
    private $defaultLocale;

    public function __construct($defaultLocale="en")
    {
        $this->defaultLocale=$defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event){
        $request = $event->getRequest();
        if(!$request->hasPreviousSession()){
            return;
        }

        if($locale=$request->attributes->get(_locale)){
            $request->getSession()->set("_locale",$locale);
        }else{
            $request->setLocale($request->getSession()->set("_locale",$this->defaultLocale));
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST=>array(array("onKernelRequest",17))
        );
    }
}
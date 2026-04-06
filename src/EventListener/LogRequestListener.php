<?php

// src/EventListener/LogRequestListener.php
namespace App\EventListener;

use App\Entity\AppLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Security\Core\Security;

class LogRequestListener {
    private $em;
    private $security;

    public function __construct(EntityManagerInterface $em, Security $security) {
        $this->em = $em;
        $this->security = $security;
    }

    public function onKernelResponse(ResponseEvent $event) {
        $request = $event->getRequest();
        
        // FILTROS DE RENDIMIENTO (Omitir GET y Profiler)
        if ($request->isMethod('GET')) return;
        if (strpos($request->get('_route'), '_profiler') !== false) return;

        $log = new AppLog();

        // --- CAMBIO AQUÍ: Capturamos el name de la ruta ---
        // Si no tiene nombre de ruta (ej. errores 404), guardamos el controlador
        $routeName = $request->attributes->get('_route'); 
        $log->setController($routeName ?? $request->attributes->get('_controller'));
        
        $log->setMethod($request->getMethod());
        $log->setStatus($event->getResponse()->getStatusCode());
        
        $user = $this->security->getUser();
        if ($user && method_exists($user, 'getId')) {
            $log->setUserId($user->getId());
        }
        
        $log->setCreatedAt(new \DateTime());

        try {
            $this->em->persist($log);
            $this->em->flush();
        } catch (\Exception $e) {
            // Silencio para no afectar la experiencia de usuario
        }
    }
}
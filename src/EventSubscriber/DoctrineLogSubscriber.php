<?php
namespace App\EventSubscriber;

use App\Entity\AppLog;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class DoctrineLogSubscriber implements EventSubscriber {
    private $security;
    private $requestStack;

    public function __construct(Security $security, RequestStack $requestStack) {
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function getSubscribedEvents(): array {
        return [Events::postPersist, Events::postUpdate];
    }

    public function postPersist(LifecycleEventArgs $args) {
        $this->saveLog($args, 'INSERT');
    }

    public function postUpdate(LifecycleEventArgs $args) {
        $this->saveLog($args, 'UPDATE');
    }

    private function saveLog(LifecycleEventArgs $args, string $action) {
        $entity = $args->getObject();
        if ($entity instanceof AppLog) return;

        $em = $args->getObjectManager();
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->security->getUser();

        $log = new AppLog();
        
        // 1. Prioridad: Nombre de la ruta (ej: employed_edit)
        // 2. Si no hay ruta (ej: consola), nombre de la Entidad
        $routeName = $request ? $request->attributes->get('_route') : null;
        $reflect = new \ReflectionClass($entity);
        $log->setController($routeName ?? $reflect->getShortName());

        $log->setTableName($em->getClassMetadata(get_class($entity))->getTableName());
        $log->setRecordId((string)$entity->getId());
        $log->setMethod($action);
        $log->setStatus(200);
        $log->setUserId($user ? $user->getId() : null);
        $log->setCreatedAt(new \DateTime());

        // IMPORTANTE: Usar una conexión que no dispare más eventos para evitar lentitud
        $em->persist($log);
        $em->flush();
    }
}
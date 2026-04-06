<?php

namespace App\Controller;

use App\Entity\Consulta;
use App\Entity\Evolucion;
use App\Entity\Pacientes;
use App\Form\EvolucionType;
use App\Repository\EvolucionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evolucion')]
class EvolucionController extends AbstractController
{
    #[Route('/', name: 'app_evolucion_index', methods: ['GET'])]
    public function index(EvolucionRepository $evolucionRepository): Response
    {
        return $this->render('evolucion/index.html.twig', [
            'evolucions' => $evolucionRepository->findAll(),
        ]);
    }

    #[Route('/paciente/{id}/consulta/{c}', name:'app_evolucion_new', methods: ['GET', 'POST'])]
    public function new($id,$c,Request $request, EntityManagerInterface $entityManager): Response
    {
        $paciente= $entityManager->getRepository(Pacientes::class)->find($id);
        $consulta= $entityManager->getRepository(Consulta::class)->find($c);
        $evoluciones= $entityManager->getRepository(Evolucion::class)->findBy(['paciente'=>$paciente]);
        $e_consulta= $entityManager->getRepository(Evolucion::class)->findBy(['consulta'=>$consulta]);
        $evolucion = new Evolucion();
        $form = $this->createForm(EvolucionType::class, $evolucion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evolucion->setConsulta($consulta);
            $evolucion->setPaciente($paciente);
            $entityManager->persist($evolucion);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        return $this->renderForm('evolucion/new.html.twig', [
            'evolucion' => $evolucion,
            'consulta'=>$consulta,
            'paciente'=>$paciente,
            'antecedentes2'=>$evoluciones,
            'c'=>$e_consulta,
            'form' => $form,
        ]);
    }

   

    #[Route('/paciente/{p}/antecedente/{id}/consulta/{c}', name: 'app_evolucion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evolucion $evolucion,$p,$c, EntityManagerInterface $entityManager): Response
    {   $paciente= $entityManager->getRepository(Pacientes::class)->find($p);
        $consulta= $entityManager->getRepository(Consulta::class)->find($c);
        $form = $this->createForm(EvolucionType::class, $evolucion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        return $this->renderForm('evolucion/edit.html.twig', [
            'consulta'=>$consulta,
            'paciente'=>$paciente,
            'evolucion' => $evolucion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evolucion_delete', methods: ['DELETE'])]
    public function delete(Request $request, Evolucion $evolucion, EntityManagerInterface $entityManager): Response
    {
            $entityManager->remove($evolucion);
            $entityManager->flush();
            $response = new Response();
            $response->send();
    }
}

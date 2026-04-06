<?php

namespace App\Controller;

use App\Entity\Certificado;
use App\Entity\Consulta;
use App\Entity\Diagnostico;
use App\Entity\Pacientes;
use App\Form\CertificadoType;
use App\Repository\CertificadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/certificado')]
class CertificadoController extends AbstractController
{
    #[Route('/', name: 'app_certificado_index', methods: ['GET'])]
    public function index(CertificadoRepository $certificadoRepository): Response
    {
        return $this->render('certificado/index.html.twig', [
            'certificados' => $certificadoRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_certificado_new', methods: ['GET', 'POST'])]
    public function new(Consulta $consulta, Request $request, EntityManagerInterface $entityManager): Response
    {
        $paciente = $consulta->getPacientes();
        $diagnosticos = $entityManager->getRepository(Diagnostico::class)->findBy(['consulta' => $consulta]);

        $certificado = $entityManager->getRepository(Certificado::class)->findOneBy(['consulta' => $consulta]);

        if (!$certificado) {
            $certificado = new Certificado();
            $certificado->setConsulta($consulta);
        }

        $form = $this->createForm(CertificadoType::class, $certificado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($certificado);
            $entityManager->flush();

            return $this->redirectToRoute('app_certificado_new', ['id' => $consulta->getId()]);
        }

        return $this->render('certificado/new.html.twig', [
            'certificado' => $certificado,
            'form' => $form->createView(),
            'consulta' => $consulta,
            'paciente' => $paciente,
            'diagnosticos' => $diagnosticos,
        ]);
    }



    

    #[Route('/{id}', name: 'app_certificado_delete', methods: ['DELETE'])]
    public function delete(Certificado $certificado, EntityManagerInterface $entityManager)
    {

            $entityManager->remove($certificado);
            $entityManager->flush();
            $response = new Response();
            $response->send();
    }
}

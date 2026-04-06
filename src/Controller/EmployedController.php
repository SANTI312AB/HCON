<?php

namespace App\Controller;

use App\Entity\Employed;

use App\Entity\Paralelo;
use App\Form\EmployedType;
use App\Form\ParaleloType;
use App\Repository\EmployedRepository;
use App\Repository\ParaleloRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/employed")
 * @IsGranted("ROLE_SUPER_ADMIN",message="No tiene acceso a esta pagina")
 */
class EmployedController extends AbstractController
{
    /**
     * @Route("/", name="employed_index", methods={"GET"})
     */
    public function index(EmployedRepository $employedRepository): Response
    {
        return $this->render('employed/index.html.twig', [
            'employeds' => $employedRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="employed_new", methods={"GET","POST"})
   
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $employed = new Employed();
        $form = $this->createForm(EmployedType::class, $employed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file= $request->files->get('employed')['foto'];
            if ($file) {
         
            $filname= md5(uniqid()) .'.'. $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('fotos_directory'),
                        $filname
                    );
                } catch (FileException $e) {
                    throw  new \Exception('Error al subir archivos');
                    // ... handle exception if something happens during file upload
                }
                  $employed->setFoto($filname);
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
               
            }
            
            $employed->setUsername($form['Cedula']->getData());
            $employed->setPassword($passwordEncoder->encodePassword( $employed,$form['Cedula']->getData()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employed);
            $entityManager->flush();
            return $this->redirectToRoute('employed_index');
        }
        return $this->render('employed/new.html.twig', [
            'employed' => $employed,
            'form' => $form->createView(),
        ]);
    }

  

    
     


  


    /**
     * @Route("/{id}/edit", name="employed_edit", methods={"GET","POST"})
    
     */
    public function edit(Request $request, Employed $employed ,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(EmployedType::class, $employed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file= $request->files->get('employed')['foto'];
            if ($file) {
         
            $filname= md5(uniqid()) .'.'. $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('fotos_directory'),
                        $filname
                    );
                } catch (FileException $e) {
                    throw  new \Exception('Error al subir archivos');
                    // ... handle exception if something happens during file upload
                }
                  $employed->setFoto($filname);
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
               
            }
            $employed->setUsername($form['Cedula']->getData());
           
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employed_index');
        }

        return $this->render('employed/edit.html.twig', [
            'employed' => $employed,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("delete/{id}", name="employed_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Employed $employed): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employed->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employed);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employed_index');
    }
}

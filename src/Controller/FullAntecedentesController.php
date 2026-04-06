<?php

namespace App\Controller;

use App\Entity\Consulta;

use App\Entity\Pacientes;
use App\Entity\Provincia;

use App\Form\ProvinciaType;
use App\Repository\AntPatologicosRepository;
use App\Repository\ConsultaRepository;
use App\Repository\EvolucionRepository;
use App\Repository\PacientesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AntReproductivosRepository;
use App\Repository\AntNoPatologicosRepository;
use App\Repository\OtrosAntecedentesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\AntHeredofamiliaresRepository;
use App\Repository\AntQuirugicosRepository;
use App\Repository\AntLaboralesRepository;

class FullAntecedentesController extends AbstractController
{
    /**
     * @Route("/paciente/{id}/consulta/{c}", name="full_antecedentes", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY",message="No tiene acceso a esta pagina")
     */
    public function index($id,$c,PacientesRepository $pacientesRepository, ConsultaRepository $consultaRepository,AntPatologicosRepository $antPatologicosRepository,
    AntReproductivosRepository $antReproductivosRepository,AntNoPatologicosRepository $antNoPatologicosRepository,OtrosAntecedentesRepository $otrosAntecedentesRepository,
    AntHeredofamiliaresRepository $antHeredofamiliaresRepository,AntQuirugicosRepository $antQuirugicosRepository,AntLaboralesRepository $antLaboralesRepository,EvolucionRepository $evolucionRepository )
    {
        $em= $this->getDoctrine()->getManager();
        $paciente= $em->getRepository(Pacientes::class)->find($id);
        $consulta= $em->getRepository(Consulta::class)->find($c);

        $a=$pacientesRepository->paciennte_Diagnostico($paciente->getId(),$consulta->getId());
        $c= $consultaRepository->consulta_examene($consulta->getId());
        $ex=$consultaRepository->consulta_examenef($consulta->getId());
        $puesto= $pacientesRepository->paciente_puestotrabajo($paciente->getId());

         $antp =$antPatologicosRepository->findBy(['pacientes' =>$paciente]);
         $antr=$antReproductivosRepository->findBy(['pacientes'=>$paciente]);
         $antn=$antNoPatologicosRepository->findBy(['pacientes'=>$paciente]);
         $anto=$otrosAntecedentesRepository->findBy(['pacientes'=>$paciente]); 
         $antf= $antHeredofamiliaresRepository->findBy(['pacientes'=>$paciente]);
         $antq=$antQuirugicosRepository->findBy(['pacientes'=>$paciente]);
         $antl= $antLaboralesRepository->findBy(['pacientes'=>$paciente]); 
         $evc= $evolucionRepository->findBy(['paciente'=>$paciente]);
            
      return $this->render('full_antecedentes/index.html.twig',[
         'paciente'=>$paciente,
         'consulta'=>$consulta,
         'antp'=>$antp,
         'antr'=> $antr,
         'antn'=>$antn,
         'anto'=> $anto,
         'antf'=>$antf,
         'antq'=>$antq,
         'antl'=>$antl,
         'evc'=>$evc,
         'diagnosticos'=>$a,
         'examenes'=>$c,
         'examen_fisicos'=>$ex,
         'puesto'=>$puesto
       ]); 
        
    }


     /**
     * @Route("/nut/paciente/{id}/consulta/{c}", name="reporte_nutricional", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY",message="No tiene acceso a esta pagina")
     */
    public function report($id,$c,PacientesRepository $pacientesRepository, ConsultaRepository $consultaRepository)
    {
        $em= $this->getDoctrine()->getManager();
        $paciente= $em->getRepository(Pacientes::class)->find($id);
        $consulta= $em->getRepository(Consulta::class)->find($c);
    

        $antp=$pacientesRepository->paciennte_antPatologicos($paciente->getId());
        $antf=$pacientesRepository->paciente_AntFamiliares($paciente->getId());
        $nutricional=$consultaRepository->consulta_nutricional($consulta->getId());
        $antn=$pacientesRepository->paciennte_antNopatologicos($paciente->getId());
      
 
       
      return $this->render('full_antecedentes/reporte_n.html.twig',[
         'paciente'=>$paciente,
         'consulta'=>$consulta,
         'antp'=>$antp,
         'antf'=>$antf,
         'c'=>$nutricional,
         'antn'=>$antn,
       ]); 
    
        
    }

    /**
     * @Route("/nty/paciente/{id}/consulta/{c}", name="reporte_nutricional_d", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY",message="No tiene acceso a esta pagina")
     */
    public function report_d($id,$c,PacientesRepository $pacientesRepository, ConsultaRepository $consultaRepository)
    {
      $em= $this->getDoctrine()->getManager();
      $paciente= $em->getRepository(Pacientes::class)->find($id);
      $consulta= $em->getRepository(Consulta::class)->find($c);
  

      $antp=$pacientesRepository->paciennte_antPatologicos($paciente->getId());
      $antf=$pacientesRepository->paciente_AntFamiliares($paciente->getId());
      $nutricional=$consultaRepository->consulta_nutricional($consulta->getId());
      $antn=$pacientesRepository->paciennte_antNopatologicos($paciente->getId());
    

     
    return $this->render('full_antecedentes/reporte_nd.html.twig',[
       'paciente'=>$paciente,
       'consulta'=>$consulta,
       'antp'=>$antp,
       'antf'=>$antf,
       'c'=>$nutricional,
       'antn'=>$antn,
     ]); 
       
    }


    /**
     * @Route("/aptitud/paciente/{id}/consulta/{c}", name="reporte_aptitud", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY",message="No tiene acceso a esta pagina")
     */
    public function report_ap($id,$c,PacientesRepository $pacientesRepository, ConsultaRepository $consultaRepository)
    {
        $em= $this->getDoctrine()->getManager();
        $paciente= $em->getRepository(Pacientes::class)->find($id);
        $consulta= $em->getRepository(Consulta::class)->find($c);
   
      return $this->render('full_antecedentes/reporte_aptitud.html.twig',[
         'paciente'=>$paciente,
         'consulta'=>$consulta,

       ]); 
       
    }
  
  
/**
* @Route("/pa/{id}/consulta{c}", name="full_ant", methods={"GET","POST"})
* @IsGranted("IS_AUTHENTICATED_FULLY",message="No tiene acceso a esta pagina")
*/
public function ant($id,$c,ConsultaController $consultaRepository) {  
      $em= $this->getDoctrine()->getManager();
        $paciente= $em->getRepository(Pacientes::class)->find($id);   
        $consulta= $em->getRepository(Consulta::class)->find($c);
        $c= $consultaRepository->consulta_examene($consulta->getId());
      
   
      return $this->render('full_antecedentes/ant_base.html.twig',[
        'consulta'=>$consulta,
        'paciente'=>$paciente,
        'c'=>$c
       
      ]); 
   
}



  /**
   * @Route("/ficha_medica/paciente/{id}/consulta/{c}", name="ficha_medica")
   * @IsGranted("IS_AUTHENTICATED_FULLY",message="No tiene acceso a esta pagina")
   */
  public function action(
    $id,
    $c,
    PacientesRepository $pacientesRepository,
    ConsultaRepository $consultaRepository,
    AntPatologicosRepository $antPatologicosRepository,
    AntReproductivosRepository $antReproductivosRepository,
    AntNoPatologicosRepository $antNoPatologicosRepository,
    OtrosAntecedentesRepository $otrosAntecedentesRepository,
    AntHeredofamiliaresRepository $antHeredofamiliaresRepository,
    AntQuirugicosRepository $antQuirugicosRepository,
    AntLaboralesRepository $antLaboralesRepository,
    EvolucionRepository $evolucionRepository
  ) {
          $em= $this->getDoctrine()->getManager();
        $paciente= $em->getRepository(Pacientes::class)->find($id);
        $consulta= $em->getRepository(Consulta::class)->find($c);

        $a=$pacientesRepository->paciennte_Diagnostico($paciente->getId(),$consulta->getId());
        $c= $consultaRepository->consulta_examene($consulta->getId());
        $ex=$consultaRepository->consulta_examenef($consulta->getId());
        $puesto= $pacientesRepository->paciente_puestotrabajo($paciente->getId());

         $antp =$antPatologicosRepository->findBy(['pacientes' =>$paciente]);
         $antr=$antReproductivosRepository->findBy(['pacientes'=>$paciente]);
         $antn=$antNoPatologicosRepository->findBy(['pacientes'=>$paciente]);
         $anto=$otrosAntecedentesRepository->findBy(['pacientes'=>$paciente]); 
         $antf= $antHeredofamiliaresRepository->findBy(['pacientes'=>$paciente]);
         $antq=$antQuirugicosRepository->findBy(['pacientes'=>$paciente]);
         $antl= $antLaboralesRepository->findBy(['pacientes'=>$paciente]); 
         $evc= $evolucionRepository->findBy(['paciente'=>$paciente]);
            
      return $this->render('full_antecedentes/index_medico.html.twig',[
         'paciente'=>$paciente,
         'consulta'=>$consulta,
         'antp'=>$antp,
         'antr'=> $antr,
         'antn'=>$antn,
         'anto'=> $anto,
         'antf'=>$antf,
         'antq'=>$antq,
         'antl'=>$antl,
         'evc'=>$evc,
         'diagnosticos'=>$a,
         'examenes'=>$c,
         'examen_fisicos'=>$ex,
         'puesto'=>$puesto
       ]); 
  }


  /**
   * @Route("/certificado_confidencialidad/{id}", name="certificado_confidencialidad")
   * @IsGranted("IS_AUTHENTICATED_FULLY",message="No tiene acceso a esta pagina")
   */
  public function certificadoConfidencialidad($id)
  {
      $em= $this->getDoctrine()->getManager();
      $consulta= $em->getRepository(Consulta::class)->find($id);
      return $this->render('certificado/confidencialidad.html.twig', [
        'consulta'=>$consulta
      ]);
  }


  /**
   * @Route("/autorizacion/{id}", name="autorizacion")
   * @IsGranted("IS_AUTHENTICATED_FULLY",message="No tiene acceso a esta pagina")
   */
  public function autorizacion($id)
  {
      $em= $this->getDoctrine()->getManager();
      $consulta= $em->getRepository(Consulta::class)->find($id);
      return $this->render('certificado/autorizacion.html.twig', [
        'consulta'=>$consulta
      ]);
  }
}

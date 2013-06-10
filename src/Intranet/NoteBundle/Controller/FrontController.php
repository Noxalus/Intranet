<?php

namespace Intranet\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Intranet\NoteBundle\Entity\Exam;

class FrontController extends Controller
{
    /**
     * @Route("/{id_typeCourse}/addExam", name="add_exam")
     * @Template()
     */
    public function addExamAction($id_typeCourse)
    {
        $type = $this->getDoctrine()
                ->getRepository('IntranetScheduleBundle:CourseType')
                ->find($id_typeCourse);
        
        $exam = new Exam();
        
        $formBuilder = $this->createFormBuilder($exam);

        $formBuilder
                ->add('nom', 'text')
                ->add('date', 'date', array(
                    'format' => 'dd/MM/yyyy',
                    'widget' => 'single_text'))
                ->add('details', 'text', array('required' => false))
                ->add('maxnote', 'integer')
                ->add('coef', 'number');
        
        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $exam->setCours($type);
                $em = $this->getDoctrine()->getManager();
                $em->persist($exam);
                $em->flush();

                
//                $file= $request->request->get('file');
//                $extensions = array('.csv');
//                $extension = strrchr($file, '.');
//                
//                
//               
//                if (!in_array($extension, $extensions))
//                {
//                    $error = 'Vous devez uploader un fichier de type .csv';
//                }
//
//                if (!isset($error))
//                {
//                    $row = 1;
//                    if (($handle = fopen($file, 'r')) !== FALSE)
//                    {
//                        while (($data = fgetcsv($handle)) !== FALSE)
//                        {
//                            $num = count($data);
//                            if ($row > 1)
//                            {
//                                $note = new Note();
//
//                                $infos = array();
//                                for ($c = 0; $c < $num; $c++)
//                                {
//                                    $infos[] = $data[$c];
//                                }
//                                
//                                $user = $this->getDoctrine()
//                                        ->getRepository('IntranetUserBundle:User')
//                                        ->findOneBy(array('username' => $infos[0]));
//                                
//                                // Hydratation
//                                $note->setValue($infos[1]);
//                                $note->setComment($infos[2]);
//                                $note->setExam($exam);
//                                $note->setUser($user);
//                                
//                                $em = $this->getDoctrine()->getManager();
//                                $em->persist($note);
//                                $em->flush();
//                            }
//                            $row++;
//                        }
//                        fclose($handle);
//
//                    }
//                }
//                else
//                {
//                    $session->getFlashBag()->add('error', $error);
//                }

                return $this->redirect($this->generateUrl('coursetype_display', array('id' => $id_typeCourse)));
            }
        }
        
        return array(
            'type' => $type,
            'form' => $form->createView(),
        );
    }
}

?>

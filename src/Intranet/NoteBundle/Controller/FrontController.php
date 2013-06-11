<?php

namespace Intranet\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Intranet\NoteBundle\Entity\Exam;
use Intranet\NoteBundle\Entity\Note;

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
                ->add('name', 'text')
                ->add('date', 'date', array(
                    'format' => 'dd/MM/yyyy',
                    'widget' => 'single_text'))
                ->add('description', 'textarea', array('required' => false))
                ->add('maxnote', 'integer', array('data' => 20))
                ->add('coef', 'number');

        $form = $formBuilder->getForm();

        $request = $this->get('request');

        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $exam->setCourseType($type);
                $em = $this->getDoctrine()->getManager();
                $em->persist($exam);
                $em->flush();

                return $this->redirect($this->generateUrl('coursetype_display', array('id' => $id_typeCourse)));
            }
        }

        return array(
            'type' => $type,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/voir/{exam_id}", name="display_exam")
     * @Template()
     */
    public function displayExamAction($exam_id)
    {
        $exam = $this->getDoctrine()
                ->getRepository('IntranetNoteBundle:Exam')
                ->find($exam_id);

        $marks = $this->getDoctrine()->getRepository('IntranetNoteBundle:Note')->findBy(array('exam' => $exam));
        
        return array(
            'exam' => $exam,
            'marks' => $marks,
            'user' => $this->get('security.context')->getToken()->getUser()
        );
    }

    /**
     * @Route("/{exam_id}/ajouter/notes", name="add_marks")
     * @Template()
     */
    public function addMarksAction($exam_id)
    {
        $request = $this->get('request');

        $session = $request->getSession();

        if ($request->getMethod() == 'POST')
        {
            $file = $_FILES['file']['tmp_name'];
            $extensions = array('.csv');
            $extension = strrchr($_FILES['file']['name'], '.');

            if (!in_array($extension, $extensions))
            {
                $error = 'Vous devez uploader un fichier de type .csv';
            }

            if (!isset($error))
            {
                $row = 1;
                if (($handle = fopen($file, 'r')) !== FALSE)
                {
                    $exam = $this->getDoctrine()
                        ->getRepository('IntranetNoteBundle:Exam')
                        ->find($exam_id);
                    $em = $this->getDoctrine()->getManager();
                    $userManager = $this->container->get('fos_user.user_manager');
                    
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
                    {
                        $num = count($data);
                        if ($row > 1)
                        {
                            $infos = array();
                            $mark = new Note();
                            for ($c = 0; $c < $num; $c++)
                            {
                                $infos[] = $data[$c];
                            }
                            
                            // Hydratation
                            $user = $userManager->findUserByUsername($infos[0]);
                            if ($user)
                            {
                                var_dump($user->getUsername());
                                $mark->setUser($user);
                                $mark->setValue($infos[1]);
                                $mark->setComment($infos[2]);
                                $mark->setExam($exam);
                                $em->persist($mark);
                            }
                        }
                        $row++;
                    }
                    
                    fclose($handle);
                    $em->flush();
                }
            }
            else
            {
                $session->getFlashBag()->add('error', $error);
            }
        }

        return $this->redirect($this->generateUrl('display_exam', array('exam_id' => $exam_id)));
    }

}

?>

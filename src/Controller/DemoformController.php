<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// Added Request
use Symfony\Component\HttpFoundation\Request;

// Added Form builder additions
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemoformController extends AbstractController
{
    /**
     * @Route("/demoform", name="demo_form")
     */
    public function standardDemoForm(Request $request)
    {

      // Use the Symfony form builder to render the form via the template
      $form = $this->createFormBuilder([])
        ->add( 'name' , TextType::class , ['label' => 'name', 'required' => 'true'] )
        ->add( 'email' , EmailType::class , ['label' => 'email', 'required' => 'true'] )
        ->add( 'submit' , SubmitType::class , ['label' => 'submit'] )
        ->getForm();

      // Non Ajax approach to handling the form submission along with validation
      $form->handleRequest($request);
      if ( $form->isSubmitted() && $form->isValid() ) {

        // For debugging
        // dump($request);
        // die();

        $name = $form->get('name')->getData();
        $email = $form->get('email')->getData();

        echo "You have entered your name as {$name} & your email as {$email}";
        die();

        /*
        You got the form data now do something cool like save it to a database
        */

      }

        return $this->render('demoform/standardform.html.twig', [
            'controller_name' => 'DemoformController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/demoformajax", name="demo_form_ajax")
     */
    public function ajaxDemoForm(Request $request)
    {

      // Use the Symfony form builder to render the form via the template
      // We don't need the setAction or setMethod for Ajax since JS will handle that but its nice to have
      $form = $this->createFormBuilder(['attr' => ['id' => 'ajax-demo-form']])
        ->setAction($this->generateUrl('demo_form_ajax_submit'))
        ->setMethod('POST')
        ->add( 'name' , TextType::class , ['label' => 'name', 'required' => 'true'] )
        ->add( 'email' , EmailType::class , ['label' => 'email', 'required' => 'true'] )
        ->add( 'submit' , SubmitType::class , ['label' => 'submit'] )
        ->getForm();

        return $this->render('demoform/ajaxform.html.twig', [
            'controller_name' => 'DemoformController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/demoformajaxsubmit", name="demo_form_ajax_submit")
     */
    public function ajaxDemoFormSubmit(Request $request)
    {

      $dataArray = [];

      $name = $request->request->get('form')['name'];
      $email = $request->request->get('form')['email'];

      // I used array push you could also assign it in a more traditional way like $dataArray = [stuff];
      array_push( $dataArray, $name , $email );

      return new JsonResponse(array('response' => $dataArray));

    }

    /**
     * @Route("/demoformajaxsubmittest", name="demo_form_ajax_submit_test")
     */
    public function ajaxDemoFormSubmitTest(Request $request)
    {

      echo '<pre>';
      var_dump($request->request);
      echo '</pre>';
      echo 'Test ok';
      exit;

    }
}

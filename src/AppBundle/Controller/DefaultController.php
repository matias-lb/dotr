<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Entity\User;
use AppBundle\Entity\company;
use AppBundle\Form\UserType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/create", name="create_user")
     * @Route("/edit/{id}", name="edit_user")
     */
    public function createAction(Request $request, $id = null)
    {
        $dm = $this->getDoctrine()->getManager();
        if($id == null){
            $form = $this->createForm(UserType::class);
        } else {
            $user_edit = $dm->getRepository(User::class)->findOneById($id);
            $form = $this->createForm(UserType::class, $user_edit);
        }
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $zipcode = $form->get('zipcode')->getData();
            $phone = $form->get('phone')->getData();
            $company = $form->get('company')->getData();
            $checkUser = $dm->getRepository(User::class)->findOneBy(['firstname' => $firstname, 'lastname' => $lastname, 'phone' => $phone, 'company' => $company, 'active' => 1]);

            if(!$checkUser){
                if(!isset($user_edit)){
                    $user = new User();
                } else {
                    $user = $user_edit;
                }
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                if($phone) $user->setPhone($phone);
                if($zipcode) $user->setZipcode($zipcode);
                $user->setCompany($company);
                $user->setActive(1);
                $dm->persist($user);
                $dm->flush();
                return $this->redirectToRoute('list_users');
            } else {
                return $this->render('user/create.html.twig', array(
                    'form' => $form->createView(),
                    'error' => 'El usuario ' . $firstname . " " . $lastname . " ya pertenece a la empresa " . $company->getName()
                ));
            }
        }
        return $this->render('user/create.html.twig', array(
                    'form' => $form->createView()
                ));
    }

    /**
     * @Route("/list", name="list_users")
     */
    public function listAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();

        $users = $dm->getRepository(User::class)->getActiveUsers();
            
        return $this->render('user/list.html.twig', array(
                'users' => $users
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete_user")
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();

        $user = $dm->getRepository(User::class)->findOneById($id);

        if($user){
            $user->setActive(0);
            $dm->persist($user);
            $dm->flush();
        }

        return $this->redirectToRoute('list_users');
    }

   
}

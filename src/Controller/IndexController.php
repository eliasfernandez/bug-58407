<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/')]
    public function index(Request $request): Response
    {
        $user = new User();
        $user->setFirstName($request->get('firstName'));
        $user->setEmail($request->get('email'));
        $user->setTest($request->get('test'));
        $form = $this->createForm(UserType::class, $user);
        if ($request->isMethod('POST')) {
            $form->submit($request->get('user'));
        }
        return $this->render('index.html.twig', [
            'form' => $form,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Entity\User;
use DateTime;

class UsersController extends AbstractController
{

    public function list(EntityManagerInterface $em)
    {
        $user = $em->getRepository(User::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $data = [$user];
        $serializer = new Serializer($normalizers, $encoders);

        return new Response($serializer->serialize($data, 'json'));
    }

    public function delete($id, EntityManagerInterface $em, Request $request)
    {
        $user = $em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('dasboard');
    }

    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setMonedasBitcoin(0);
            $user->setMonedasMarketcoin(0);
            $user->setVecesRecividas(0);
            $user->setFechaCreacion(new DateTime(date("Y-m-d H:i:s")));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

         return $this->render(
             'security/register.html.twig',
             array('form' => $form->createView())
         );
    }
}

<?php

namespace App\Controller;

use App\Entity\Eventos;
use App\Form\EventoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EventoController extends AbstractController
{
    public function adminView(EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $eventos = $em->getRepository(Eventos::class)->findAll();
        return $this->render('admin/evento/index.html.twig', [
            'eventos' => $eventos,
            'user' => $user,
        ]);
    }

    public function userView(EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $eventos = $em->getRepository(Eventos::class)->findAll();
        return $this->render('user/eventos.html.twig', [
            'eventos' => $eventos,
            'user' => $user,
        ]);
    }

    function list(EntityManagerInterface $em) {
        $eventos = $em->getRepository(Eventos::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data = [];
        for ($i = 0; $i < count($eventos); $i++) {
            array_push($data, [
                "id" => $eventos[$i]->getId(),
                "nombre" => $eventos[$i]->getNombre(),
                "descripcion" => $eventos[$i]->getDescripcion(),
                "fecha" => $eventos[$i]->getFecha()->format('Y-m-d'),
                "duracionInicio" => $eventos[$i]->getDuracionInicio()->format('H:i:s'),
                "duracionFin" => $eventos[$i]->getDuracionFin()->format('H:i:s'),
            ]);
        }
        return new Response($serializer->serialize($data, 'json'));
    }

    public function edit($id, EntityManagerInterface $em, Request $request)
    {
        $evento = $em->getRepository(Eventos::class)->find($id);
        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evento);
            $em->flush();

            return $this->redirectToRoute('eventos_admin');
        }

        return $this->render(
            'admin/evento/editEvento.html.twig',
            ['form' => $form->createView()]
        );
    }

    public function delete($id, EntityManagerInterface $em, Request $request)
    {
        $evento = $em->getRepository(Eventos::class)->find($id);
        $em->remove($evento);
        $em->flush();
        return $this->redirectToRoute('eventos_admin');
    }

    function new (Request $request, EntityManagerInterface $em) {
        $user = new Eventos();
        $form = $this->createForm(EventoType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('eventos_admin');
        }

        return $this->render(
            'admin/evento/newEvento.html.twig',
            array('form' => $form->createView())
        );
    }
}

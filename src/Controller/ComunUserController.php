<?php

namespace App\Controller;

use App\Entity\Moneda;
use App\Entity\MonedaApoyo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComunUserController extends AbstractController
{
    public function index(EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $monedas = $em->getRepository(Moneda::class)->findByDueño($user);
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'monedas' => $monedas,
            'invitados' => null,
        ]);
    }

    public function indexMoneda(int $id, EntityManagerInterface $em)
    {
        $moneda = $em->getRepository(Moneda::class)->find($id);
        if(!$moneda)
        {
            throw $this->createNotFoundException('Moneda no encontrada'); 
        }
        $diamanteApoyo = $em->getRepository(MonedaApoyo::class)->
            findOneByMoneda($moneda);
        if (!$diamanteApoyo) {
            $diamanteApoyo = "Sin diamante de apoyo";
        } else {
            $diamanteApoyo = $diamanteApoyo->
                getMonedaDApoyo()->getDueño()->getNombres();
        }
        return $this->render('user/moneda/index.html.twig', [
            'moneda' => $moneda,
            'monedaDeApoyo' => $diamanteApoyo,
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\User;
use Safe\Exceptions\JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Safe\json_encode;

final class IndexController extends AbstractController
{
    /**
     * @Route("/{vueRouting}", requirements={"vuerouting"="^(?!api|_(profiler|wdt)).*"}, name="index")
     * @return Response
     * @throws JsonException
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('base.html.twig', [
            'isAuthenticated' => json_encode(!empty($user)),
            'roles' => json_encode(!empty($user) ? $user->getRoles() : []),
        ]);
    }
}

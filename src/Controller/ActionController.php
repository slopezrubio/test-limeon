<?php

namespace App\Controller;

use App\Form\Type\ActionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Action;
use App\Entity\Building;
use App\Entity\Apartment;
use App\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Flex\Response;

class ActionController extends AbstractController
{
    /**
     * @Route("/", name="task")
     */
    public function index()
    {
        return $this->render('views/actions.html.twig');
    }

    /**
     * @Route("/actions", name="show")
     */
    public function show() {
        $actions = $this->getDoctrine()
            ->getRepository(Action::class)
            ->all();

        var_dump($actions);
        die();
        return $this->render('views/actions.html.twig');
    }

    /**
     * @Route("/actions/new", name="newAction")
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request, ValidatorInterface $validator) {
        $entityManager = $this->getDoctrine()->getManager();

        $action = new Action();
        $action->setBuilding($this->getDoctrine()->getRepository(Building::class)->find($request->get('buildings')));
        $action->setApartment($this->getDoctrine()->getRepository(Apartment::class)->find($request->get('apartments')));
        $action->setRoom($this->getDoctrine()->getRepository(Room::class)->find($request->get('rooms')));
        $action->setDescription($request->get('description'));
        $action->setResponsable($request->get('responsable'));
        $action->setEmailResponsable($request->get('email-responsable'));
        $action->setPhoneNumberResponsable($request->get('prefixes'), $request->get('phone-number-responsable'));
        $action->setDateOfWork(date_create_from_format('m/d/Y', $request->get('date-of-work')));
        $action->setAttachedFiles($request->get('action-files'));

        //$form = $this->createForm(ActionType::class, $action);

        //$errors = $form->getErrors(true, false);
        $errors = $this->getErrorMessages($validator->validate($action));

        if (count($errors) > 0) {
            return $this->render('views/actions.html.twig', [
                'errors' => $errors
            ]);
        }

        $entityManager->persist($action);

        $entityManager->flush();

        return $this->render('views/actions.html.twig', $success = [
            'message' => 'The task has been created successfully.'
        ]);
    }

    public function getErrorMessages(ConstraintViolationListInterface $errors) {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errorMessages;
    }
}

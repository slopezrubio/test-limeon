<?php

namespace App\Controller;

use App\Form\Type\ActionType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Action;
use App\Entity\Building;
use App\Entity\Apartment;
use App\Entity\Room;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ActionController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->redirectToRoute('show-actions');
    }

    /**
     * @Route("/actions", name="show-actions")
     */
    public function show()
    {
        $actions = $this->getDoctrine()
            ->getRepository(Action::class)
            ->all();

        foreach ($actions as $property => $action) {
            $action['action']['phone_number_responsable'] = json_decode($action['action']['phone_number_responsable']);
            json_decode($action['action']['attached_files']);
        }


        $actions = Action::encodeFields($actions, [
            'phone_number_responsable',
            'attached_files'
        ]);

        return $this->render('views/actions.html.twig', [
            'actions' => $actions,
        ]);
    }

    /**
     * @Route("/actions/{id}", name="edit-action")
     *
     * @param $id
     * @return Response
     * @throws ExceptionInterface
     */
    public function single($id)
    {
        $action = $this->getDoctrine()
            ->getRepository(Action::class)
            ->find($id);

        //$date = $action->getDateOfWork()->format('d\t\h \o\f F\, Y');
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $action = $serializer->normalize($action, null, [
            ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            }
        ]);

        return $this->render('views/actions.html.twig', [
            'action' => $action,
        ]);
    }

    /**
     * @Route("/actions/new", name="create-action")
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     *
     * @return Response
     */
    public function create(Request $request, ValidatorInterface $validator, FileUploader $fileUploader)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $action = new Action();

        $this->setRequest($request, $action);

        //$errors = $form->getErrors(true, false);
        $errors = $this->getErrorMessages($validator->validate($action));

        if (count($errors) > 0) {
            $request->getSession()->getFlashBag()->set('warning', $errors);
            return $this->redirectToRoute('new-action');
        }

        $action->uploadAttachedFiles($fileUploader);

        $entityManager->persist($action);
        $entityManager->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/actions/new", name="new-action")
     *
     * @return Response
     */
    public function new()
    {
        return $this->render('views/actions.html.twig');
    }

    /**
     * @Route("/actions/delete/{id}", name="delete-action")
     *
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id) {
        $action = $this->getDoctrine()
            ->getRepository(Action::class)
            ->find($id);

        $entityManager = $this->getDoctrine()
            ->getManager();

        if ($action !== null) {
            $entityManager->remove($action);
            $entityManager->flush();
        }

        $response = new Response();
        return $response->send();
    }

    /**
     * @Route("/actions/edit/{id}", name="update-action")
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, string $id, ValidatorInterface $validator) {
        $entityManager = $this->getDoctrine()
            ->getManager();

        $action = $entityManager
            ->getRepository(Action::class)
            ->find($id);

        if (!$action) {
            throw $this->createNotFoundException('No action found for id '. $id);
        }

        $this->setRequest($request, $action);

        $errors = $this->getErrorMessages($validator->validate($action));

        if (count($errors) > 0) {
            $request->getSession()->getFlashBag()->set('warning', $errors);
            return $this->redirectToRoute('edit-action', [
                'id' => $id,
            ]);
        }

        $entityManager->flush();

        return $this->redirectToRoute('index');
    }

    public function setRequest(Request $request, Action $action) {
        $action->setBuilding($this->getDoctrine()->getRepository(Building::class)->find($request->get('buildings')));
        $action->setApartment($this->getDoctrine()->getRepository(Apartment::class)->find($request->get('apartments')));
        $action->setRoom($this->getDoctrine()->getRepository(Room::class)->find($request->get('rooms')));
        $action->setDescription($request->get('description'));
        $action->setResponsable($request->get('responsable'));
        $action->setEmailResponsable($request->get('email-responsable'));
        $action->setPhoneNumberResponsable($request->get('prefixes'), $request->get('phone-number-responsable'));
        $action->setDateOfWork(date_create_from_format('m/d/Y', $request->get('date-of-work')));
        $action->setAttachedFiles($request->files->get('action-files'));
    }

    public function getErrorMessages(ConstraintViolationListInterface $errors) {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errorMessages;
    }
}

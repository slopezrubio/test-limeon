<?php


namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class ActionType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options) {
       $builder
           ->add('description', Type\TextareaType::class, [
               'required' => true,
           ])
           ->add('phone_number_responsable', Type\TelType::class, [
               'required' => true,
           ])
           ->add('email_responsable', Type\EmailType::class, [
               'required' => false,
           ])
           ->add('date_of_work', Type\DateType::class, [
               'required' => false,
           ])
           ->add('attached_files', Type\FileType::class, [
               'required' => false,
           ]);

   }
}
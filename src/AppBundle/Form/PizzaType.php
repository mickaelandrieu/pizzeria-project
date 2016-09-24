<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('ingredients', CollectionType::class, [
                'entry_type' => PizzaIngredientType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                // prepare re-ordering of ingredients
                $pizza = $event->getData();
                $i = 0;

                foreach ($pizza['ingredients'] as &$ingredient) {
                    $ingredient['position'] = ++$i;
                }

                $event->setData($pizza);
            })
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                // we affect each ingredient to his pizza
                $pizza = $event->getData();

                foreach ($pizza->getIngredients() as $ingredient) {
                    $ingredient->setPosition((int) $ingredient->getPosition());
                    $ingredient->setPizza($pizza);
                }

                $event->setData($pizza);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Pizza',
        ]);
    }
}

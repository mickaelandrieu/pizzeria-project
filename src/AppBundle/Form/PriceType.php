<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\ValueObject\Price;

class PriceType extends AbstractType implements DataMapperInterface
{
    /**
     * For now we only use euros as currency, don't display currency input.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'money', [
                'divisor' => 100,
            ]
        )->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\ValueObject\Price',
            'empty_data' => null,
        ]);
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['amount']->setData($data ? $data->getAmount() : 0);
        $forms['currency']->setData($data ? $data->getCurrency() : 'EUR');
    }

    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = new Price(
            $forms['amount']->getData(),
            $forms['currency']->getData()
        );
    }
}

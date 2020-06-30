<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class TripFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('gpx_file', FileType::class, [
                'attr' => array(
                    'accept' => '.gpx'
                ),
                'data_class' => null,
                'label' => 'Trip data (GPX file)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '20480k',
                        'mimeTypes' => [
//                            'application/gpx',
//                            'application/gpx+xml',
                            'text/xml',
                            'application/octet-stream',

                        ],
                        'mimeTypesMessage' => 'Please upload a valid GPX document',
                    ])
                ],
            ])
        ;
    }

}

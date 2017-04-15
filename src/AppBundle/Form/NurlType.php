<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class NurlType extends AbstractType
{
    private $user;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->user= $options['user'];
        $builder->add('title')
                ->add('link')
                ->add('source')
                ->add('note')
                ->add('isPublic');

        $builder->add('collection', EntityType::class, [
            'class' => 'AppBundle:Collection',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->where('c.author = :user')
                    ->setParameter('user', $this->user);
            },
            'choice_label' => 'title',
            'mapped' => false,
            'required'=> false,
        ]);

        $builder->add('tags', EntityType::class, [
            'class' => 'AppBundle:Tag',
            'choice_label' => 'tagvalue',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->where('t.isProposed != true');
            },
            'mapped' => false,
            'required'=> false,
            'multiple' => true,
            'expanded' => true,
            'by_reference'=>false,
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Nurl',
            'user' => null,
            'attr' => array (
                'autocomplete' => 'off',
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_nurl';
    }
}
